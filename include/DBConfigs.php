<?php
	//Database connected functions
	include("./include/assemble.php");
	$classCommon = new classCommon;
	$classAssemble = new classAssemble;
	$classDBRelatedFunctions = new classDBRelatedFunctions;
	//$classPDORelatedFunctions = new classPDORelatedFunctions;
	
	class classDBRelatedFunctions extends ZipArchive {
		private $saltChars;
		public $errorMessage;
		private $passwordFromDB;
		private $saltFromDB;
		function functionError(){
			if(!empty($this->errorMessage)){
				echo $this->errorMessage;
			}elseif(empty($this->errorMessage)){
				return "no error";	
			}
		}
		function functionDBConnect(){
			$host = "localhost";
			$database = "nebulachoma";
			$username = "root";
			$password = "juhancastro!";
			$DBConnection = mysql_connect("$host","$username","$password");
			$DBSelect = mysql_select_db($database, $DBConnection);
			if(!$DBSelect){
				die("Database selection failed: " . mysql_error());
			}
			return $DBConnection;
		}
		function functionDBDisconnect(){
			mysql_close($this->functionDBConnect());
		}
		function functionGenerateSalt(){
			return dechex(mt_rand(0,2147483647)).(mt_rand(0,2147483647));
		}
		function functionGenerateConfirmCode(){
			return dechex(mt_rand(0,2147483647)).(mt_rand(0,2147483647));
		}
		function functionCheckUserName($userName){
			$codeResult = mysql_query("SELECT * FROM tbluser WHERE username='$userName'" );
			return mysql_num_rows($codeResult)? 1 : 0;
		}
		function functionGenerateFileID($userID){
			$this->functionDBConnect();
			for ($x=0; $x>=0; $x++){
				$checkFileID = "file" . $userID . $x;
				if($this->functionCheckFileID($checkFileID) == 1){
					echo 'Error! Failed to insert the file';
					break;
				}else{
					echo $fileID = $checkFileID;
					break;
				}
			} 
			
			return $fileID;
		}
		function functionCheckFileID($checkFileID){
			$codeResult = mysql_query("SELECT * FROM tblfile WHERE fileID='$checkFileID'" );
			return mysql_num_rows($codeResult)? 1 : 0;
		}
		function functionCheckUserID($userID){
			$codeResult = mysql_query("SELECT * FROM tbluser WHERE userID='$userID'" );
			return mysql_num_rows($codeResult)? 1 : 0;
		}
		function functionCheckPasswordSignUp($passWord1,$passWord2){
			if($passWord1 == $passWord2){
				return true;	
			}else{
				return false;	
			}
		}
		function functionEncryptPassword($password,$salt){
			$hashedPassword = hash('sha256',$password.$salt);
			for($round = 0; $round < 65536; $round++ ){
				$hashedPassword = hash('sha256',$hashedPassword.$salt);
			}
			return $hashedPassword;		
		}
		function functionUserSignup($userID, $userName, $userPassword, $userPasswordReType, $userLevel, $userAccountStatus, $userFirstName,$userLastName, $userStorageCapacity){
			$this->functionDBConnect();
			$salt = $this->functionGenerateSalt();
			if($this->functionCheckUserID($userID) == 1){
				$this->errorMessage = "UserID Unavailable!";
				$this->functionError();
			}
			if($this->functionCheckUserName($userName) == 1){
				$this->errorMessage = "Username Unavailable!";
				$this->functionError();
			}
			if($this->functionCheckPasswordSignUp($userPassword,$userPasswordReType) == false){
				$this->errorMessage = "Password Unmatch!";
				$this->functionError();
			}else{
				$encryptedPassword = $this->functionEncryptPassword($userPassword,$salt);
			}
			
			
			
			$dateToday = date('Y') . "-" . date('m')  . "-" . date('d');
			$SQLQuery = "INSERT INTO tbluser
			(userID, userName, userPassword, salt, userFirstName, userLastName, userLevel, userAccountStatus, userRegistrationDate, userStorageCapacity)			VALUES('$userID', '$userName', '$encryptedPassword', '$salt', '$userFirstName', '$userLastName', '$userLevel', '$userAccountStatus', '$dateToday', '$userStorageCapacity')";
			if (!mysql_query($SQLQuery,$this->functionDBConnect()))
			{
				die ('Error: ' . mysql_error());
			}
			
			
			/*$dateToday = date('Y') . "-" . date('m')  . "-" . date('d'). " " . date('h')  . ":" . date('i'). ":" . date('s');
			$SQLQuery = "INSERT INTO tbluser
			(userID, userName, userPassword, salt, userFirstName, userLastName, userLevel, userAccountStatus, userRegistrationDate)
			VALUES
			('$userID','$userName','$encryptedPassword','$salt','$userFirstName','$userLastName','2','1','$dateToday')";
			if (!mysql_query($SQLQuery,$this->functionDBConnect()))
			{
				die ('Error: ' . mysql_error());
			}*/
		}
		function functionGetPasswordFromDB($userName){
			$result = mysql_query("SELECT * FROM tbluser WHERE username='$userName'");
			while($row=mysql_fetch_array($result)){  
				$this->saltFromDB	= $row['salt']; 
				$this->passwordFromDB = $row['userPassword']; 
			}
		}
		function functionUserAuthentication($username,$password){
			$this->functionDBConnect();
			if($this->functionCheckUserName($username) == 0){
				$this->errorMessage = "Username Unavailable!";
				$this->functionError();
			}
			$this->functionGetPasswordFromDB($username);
			$loginSalt = $this->saltFromDB;
			$newEncryptedPassword = $this->functionEncryptPassword($password,$loginSalt);
			$encrypt = $this->passwordFromDB;
			if($this->functionCheckPasswordSignUp($encrypt,$newEncryptedPassword) == true){
				
				$result = mysql_query("SELECT * FROM tbluser WHERE userName='$username' and userPassword='$newEncryptedPassword' and userLevel='2'");
				while($row = mysql_fetch_array($result))
				{
					$userID = $row['userID'];
					$userName = $row['userName'];
					$userPassword = $row['userPassword'];
					$userLevel = $row['userLevel'];
				}
				
				if(!empty($userName)){
					//session_start();
					$_SESSION['userID'] = $userID;
					$_SESSION['userName'] = $userName;
					$_SESSION['userPassword'] = $userPassword;
					$_SESSION['userLevel'] = $userLevel;
					$_SESSION['pagePasser'] = 1;
					$_SESSION['counter'] = "0";
				}else{
					echo "username or password unmatch!";
				}
			}else{
				echo "username or password unmatch!";	
			}
			
		}
		function fileUploadToDB($userID ,$fName,$fileMime,$fileSize,$fileData,$folderID){
			$this->functionDBConnect();
			$dateToday = date('Y') . "-" . date('m')  . "-" . date('d'). " " . date('h')  . ":" . date('i'). ":" . date('s');
			
			$sql = "INSERT INTO tblfile(
										userID,
										fName,
										fileMime,
										fileSize,
										fileData,
										fileUploaded,
										folderID,
										shared,
										public,
										status
										) VALUES(
												'$userID',
												'$fName',
												'$fileMime',
												'$fileSize',
												'$fileData',
												'$dateToday',
												'$folderID',
												'0',
												'0',
												'1')";
				
			mysql_query($sql);
			/*
			if($folderID == $userID){
				$fName = "My Cloud";
				$folderUpperDirectory = "none";
			}else{
				$fName = $_GET['currentFolderID'];
				$folderUpperDirectory = $_GET['folderUpperDirectory'];
			}
			$this->functionFolders($userID, $folderID,$fName,$folderUpperDirectory);*/
			
		}
		function functionCheckFolder($userID, $folderID,$fName,$folderUpperDirectory){
			$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE userID='$userID' AND folderID='$folderID' AND fName='$fName' AND folderUpperDirectory='$folderUpperDirectory'") or die(mysql_error());
			
						
			return mysql_num_rows($SQLQuery)? 1 : 0;
		}
		function functionFolders($userID, $folderID,$fName,$folderUpperDirectory){
			if($this->functionCheckFolder($userID, $folderID,$fName,$folderUpperDirectory) == 0){
				$SQLQuery = mysql_query("INSERT INTO tblfolder(
										userID,
										folderID,
										fName,
										folderUpperDirectory
										) VALUES(
												'$userID',
												'$folderID',
												'$fName',
												'$folderUpperDirectory')") or die(mysql_error());
				
				mysql_query($SQLQuery);	
			}else{
				$this->errorMessage = "folder already available";
				$this->functionError();
			}
		}
		function functionCheckFolderUpperDirectory($folderID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("SELECT fName, folderUpperDirectory FROM tblfolder WHERE folderID='$folderID'") or die(mysql_error());
			if(mysql_num_rows($SQLQuery)>0){
					while($row = mysql_fetch_array($SQLQuery)) {
						$folderUpperDirectory = $row['folderUpperDirectory'];
					}
					
			}
			echo $folderUpperDirectory . "asdf";
			break;
			return $folderUpperDirectory;
		}
		function functionGetPathForUpload($currentFolderID){
			echo $currentFolderID;
			/*if (!file_exists('uploads/' . $userID  . '/')) {
				mkdir('uploads/' . $userID  . '/', 0777, true);
			}*/
			$path = 'uploads/' . $_SESSION['userID']  . '/';
			echo $path . $currentFolderID;
			echo "<br>";
			
			if (!file_exists($path . $currentFolderID)){
				echo "doesnt exist";
				
					for($x=1; $x<=100;){
						echo $tmppath = $path . $_SESSION['userID'] . '_' . $x;
						echo "<br>";
						if (!file_exists($tmppath . $currentFolderID)){
							$x++;
						}else{
							break;
						}
					}
				
				
			}else{
				echo "exist";
			}
			
			
			//for ($x=1; $x<=100;) {
				
			//}
			
		}
		function functionCreateFolder($userID,$folderID,$fName,$folderUpperDirectory, $currentPath){
			$this->functionDBConnect();
			if(($folderUpperDirectory == "none") or ($folderUpperDirectory == $userID)){
				$folderUpperDirectory = $userID;
			}
			$path = $currentPath;
			for ($x=1; $x<=1000;) {
				$newFolderID = $folderUpperDirectory . "_" . $x;
				$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderUpperDirectory='$folderUpperDirectory' AND fName = '$fName'") or die(mysql_error());
				if(mysql_num_rows($SQLQuery)>0){
					echo "Folder name already available!";
					break;
				}else{
					$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID = '$newFolderID'") or die(mysql_error());
					if(mysql_num_rows($SQLQuery)>0){
						while($row = mysql_fetch_array($SQLQuery)) {
							//echo $row['folderID'];
						}
						$x++;
					}else{
						if (!file_exists($path . "/" . $newFolderID)) {
							mkdir($path . "/" . $newFolderID, 0777, true);
							
							
							$SQLQuery = mysql_query("INSERT INTO tblfolder(
									userID,
									folderID,
									fName,
									folderUpperDirectory,
									fMime,
									status
									) VALUES(
											'$userID',
											'$newFolderID',
											'$fName',
											'$folderUpperDirectory',
											'$currentPath',
											'1')") or die(mysql_error());
			
							mysql_query($SQLQuery);
							
							
							break;
						}else{
							$x++;
						}
					}
				}
			}
		}
		function fileCheck($userFile,$folderID){
			$this->functionDBConnect();
			$codeResult = mysql_query("SELECT * FROM tblfile WHERE fName='$userFile' AND folderID='$folderID' AND status='1'" );
			return mysql_num_rows($codeResult)? 1 : 0;
			$this->functionDBDisconnect();
			echo "file check" . $userFile;
		}
		function zipFilesDownload($file_names,$archive_file_name,$file_path){
			$zip = new ZipArchive();
			if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
			  exit("cannot open <$archive_file_name>\n");
			
			}
			foreach($file_names as $files){
			  $zip->addFile($files);
			}
			$zip->close();
			
			
			header("Content-type: application/zip"); 
			header("Content-Disposition: attachment; filename=$archive_file_name"); 
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			readfile("$archive_file_name"); 
			exit;
		
		}
		function functionDeleteFolder($dirname){
			if (is_dir($dirname))
				$dir_handle = opendir($dirname);
			if (!$dir_handle)
				return false;
			while($file = readdir($dir_handle)) {
				if ($file != "." && $file != "..") {
					if (!is_dir($dirname."/".$file))
				unlink($dirname."/".$file);
				else
					$this->functionDeleteFolder($dirname.'/'.$file);
				}
			}
			closedir($dir_handle);
			rmdir($dirname);
			return true;
		}
		function rrmdir($dir) {
			echo "delete";
			if (is_dir($dir)) {
				$objects = scandir($dir);
				foreach ($objects as $object) {
					if ($object != "." && $object != "..") {
						if (filetype($dir."/".$object) == "dir") 
							rrmdir($dir."/".$object); 
						else unlink   ($dir."/".$object);
					}
				}
				reset($objects);
				rmdir($dir);
			}
		}
		function recurse_copy($src,$dst){
			$dir = opendir($src); 
			@mkdir($dst); 
			while(false !== ( $file = readdir($dir)) ) { 
				if (( $file != '.' ) && ( $file != '..' )) { 
					if ( is_dir($src . '/' . $file) ) { 
						$this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
					} 
					else { 
						copy($src . '/' . $file,$dst . '/' . $file); 
					} 
				} 
			} 
			closedir($dir); 
		}
		public function addDir($location, $name) {
			$this->addEmptyDir($name);
	
			$this->addDirDo($location, $name);
		 } // EO addDir;
	
		/**
		 * Add Files & Dirs to archive.
		 *
		 * @param string $location Real Location
		 * @param string $name Name in Archive
		 * @author Nicolas Heimann
		 * @access private
		 **/ //working zip
		private function addDirDo($location, $name) {
			$name .= '/';
			$location .= '/';
	
			// Read all Files in Dir
			$dir = opendir ($location);
			while ($file = readdir($dir))
			{
				if ($file == '.' || $file == '..') continue;
	
				// Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
				$do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
				$this->$do($location . $file, $name . $file);
			}
		} // EO addDirDo(); //working zip
		function functionCheckFileType($location, $name) {
			//name of folder then base name. eg uploads/0 to 0
			//adddirdo (uploads/0, 0)
			$name .= '/';
			$location .= '/';
	 
			// Read all Files in Dir
			$dir = opendir ($location);
			while ($file = readdir($dir))
			{
				if ($file == '.' || $file == '..') continue;
	 
				// Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
				echo $do = (is_dir( $location . $file) == 'dir') ? 'addDir' : 'addFile';
				echo "<br>";
				echo filetype($location . $file);
				break;
				$this->$do($location . $file, $name . $file);
			}
		}
		function functionCheckFileTypeSharing($userID, $fileID, $folderUpperDirectory, $currentPath, $currentFolderID) {
			$this->functionDBConnect();
			echo $currentPath . "<br>";
			echo $userID . " " . $fileID . " " . $folderUpperDirectory . " " . $currentPath . " " . $currentFolderID . "<br><br><br><br>";
			$fileShareeID = $userID;
			$fileOwnerID = $_SESSION['userID'];
			$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileID='$fileID'") or die(mysql_error());//for confirmation in database only
			if(mysql_num_rows($SQLQuery)>0){
				echo "if option";
				while($row = mysql_fetch_array($SQLQuery)) {
					$fileData = $row['fileData'];
				}
				$SQLMakeShared = mysql_query("UPDATE tblfile SET shared = '1' WHERE fileID='$fileID'") or die(mysql_error());
				mysql_query($SQLMakeShared);
				
				$SQLMakeSharedCheck = mysql_query("SELECT * FROM tblsharedfiles WHERE fileID='$fileData' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
				if((mysql_num_rows($SQLMakeSharedCheck)>0)){
				}else{
					$SQLMakeShared = mysql_query("INSERT INTO tblsharedfiles
					(fileID, fileOwnerID, fileShareeID)
					VALUES
					('$fileData','$fileOwnerID','$fileShareeID')") or die(mysql_error());
					mysql_query($SQLMakeShared);
				}
				
			}else{
				echo "else option";
				$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID='$fileID'") or die(mysql_error());//for confirmation in database only
				if(mysql_num_rows($SQLQuery)>0){
					while($row = mysql_fetch_array($SQLQuery)) {
						$fileData = $row['folderID'];
						$status = $row['status'];
					}
					
					if($status == 0){
						$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '1' WHERE folderID='$fileID'") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}elseif($status == 1 or $status == 2){
						$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '3' WHERE folderID='$fileID'") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}else{
					}
					
					
					$SQLMakeSharedCheck = mysql_query("SELECT * FROM tblsharedfiles WHERE fileID='$fileID' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
					if((mysql_num_rows($SQLMakeSharedCheck)>0)){
						echo "<br>already in tblsharedfiles else <br>";
					}else{
						$SQLMakeShared = mysql_query("INSERT INTO tblsharedfiles
						(fileID, fileOwnerID, fileShareeID)
						VALUES
						('$fileData','$fileOwnerID','$fileShareeID')") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}
					$this->listFolderFiles($currentPath . $fileID . "/",  $fileOwnerID, $fileShareeID);
					
				}else{
					echo "nothing was found";
				}
				
			}
			/*
			echo "qwerqewrqewr";
			//name of folder then base name. eg uploads/0 to 0
			//adddirdo (uploads/0, 0)
			$name .= '/';
			$location .= '/';
	 
			// Read all Files in Dir
			$dir = opendir ($location);
			while ($file = readdir($dir))
			{
				if ($file == '.' || $file == '..') continue;
	 
				// Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
				echo $do = (is_dir( $location . $file) == 'dir') ? 'addDir' : 'addFile';
				echo "<br>";
				echo filetype($location . $file);
				break;
				$this->$do($location . $file, $name . $file);
			}*/
		}
		function listFolderFiles($dir, $fileOwnerID, $fileShareeID){
			echo "listFolderFiles<br><br><br>";
			$ffs = scandir($dir);
			//echo '<ol>';
			echo "<br>" . $dir . "<br><br>";
			
			foreach($ffs as $ff){
				if($ff != '.' && $ff != '..'){
					if(is_dir($dir . $ff . "/")){
						echo "this is dir: " . $dir;
						$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID='$ff'") or die(mysql_error());
						if(mysql_num_rows($SQLQuery)==1){
							echo "<br>this is a folder: ";
							echo $ff;
							echo "<br><br>";
							
							
							while($row = mysql_fetch_array($SQLQuery)) {
								$fileData = $row['folderID'];
								$status = $row['status'];
							}
							
							if($status == 0){
								$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '1' WHERE folderID='$ff'") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}elseif($status == 1 or $status == 2){
								$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '3' WHERE folderID='$ff'") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}else{
							}
							
							
							
							$SQLMakeSharedCheck = mysql_query("SELECT * FROM tblsharedfiles WHERE fileID='$ff' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
							if((mysql_num_rows($SQLMakeSharedCheck)>0)){
								echo "<br>already in tblsharedfiles else <br>";
							}else{
								$SQLMakeShared = mysql_query("INSERT INTO tblsharedfiles
								(fileID, fileOwnerID, fileShareeID)
								VALUES
								('$fileData','$fileOwnerID','$fileShareeID')") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}
							
							
							
						}else{
							echo "nothing was found in tblfile";
						}
						$this->listFolderFiles($dir . $ff . "/", $fileOwnerID, $fileShareeID);
					}elseif(is_file($dir.$ff)){
						$fileData = $dir.$ff;
						$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileData='$fileData'") or die(mysql_error());
						if(mysql_num_rows($SQLQuery)==1){
							$SQLMakeShared = mysql_query("UPDATE tblfile SET shared = '1' WHERE fileData='$fileData'") or die(mysql_error());
							mysql_query($SQLMakeShared);
							
							$SQLMakeSharedCheck = mysql_query("SELECT * FROM tblsharedfiles WHERE fileID='$fileData' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
							if((mysql_num_rows($SQLMakeSharedCheck)>0)){
								echo "<br>already in tblsharedfiles else <br>";
							}else{
								$SQLMakeShared = mysql_query("INSERT INTO tblsharedfiles
								(fileID, fileOwnerID, fileShareeID)
								VALUES
								('$fileData','$fileOwnerID','$fileShareeID')") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}
						}
						echo "<br><br>This is a file: " . $dir . $ff ."<br><br>";
					}
					
					//echo '</li>';
				}
			}
			echo "<br>end of function<br>";
			//echo '</ol>';
		}
		function functionCheckFileTypeUnShare($userID, $fileID, $folderUpperDirectory, $currentPath, $currentFolderID) {
			$this->functionDBConnect();
			$fileShareeID = $userID;
			$fileOwnerID = $_SESSION['userID'];
			$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileID='$fileID'") or die(mysql_error());//for confirmation in database only
			if(mysql_num_rows($SQLQuery)>0){
				while($row = mysql_fetch_array($SQLQuery)) {
					$fileData = $row['fileData'];
				}
				$SQLMakeShared = mysql_query("UPDATE tblfile SET shared = '0' WHERE fileID='$fileID'") or die(mysql_error());
				mysql_query($SQLMakeShared);
				
				$SQLMakeSharedCheck = mysql_query("SELECT * FROM tblsharedfiles WHERE fileID='$fileData' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
				if((mysql_num_rows($SQLMakeSharedCheck)>0)){
				}else{
					$SQLMakeShared = mysql_query("DELETE FROM tblsharedfiles WHERE fileID='$fileData' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
					mysql_query($SQLMakeShared);
				}
				
			}else{
				$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID='$fileID'") or die(mysql_error());//for confirmation in database only
				if(mysql_num_rows($SQLQuery)>0){
					while($row = mysql_fetch_array($SQLQuery)) {
						$fileData = $row['folderID'];
						$status = $row['status'];
					}
					
					if($status == 0 or $status == 2){
					}elseif($status == 1){
						$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '0' WHERE folderID='$fileID'") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}elseif($status == 3){
						$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '2' WHERE folderID='$fileID'") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}else{
					}
					
					
					$SQLMakeSharedCheck = mysql_query("SELECT * FROM tblsharedfiles WHERE fileID='$fileID' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
					if((mysql_num_rows($SQLMakeSharedCheck)>0)){
						$SQLMakeUnShared = mysql_query("DELETE FROM tblsharedfiles WHERE fileID='$fileData' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
						mysql_query($SQLMakeUnShared);
					}else{
					}
					$this->listFolderFilesUnShare($currentPath . $fileID . "/",  $fileOwnerID, $fileShareeID);
					
				}else{
					echo "nothing was found";
				}
				
			}
			/*
			echo "qwerqewrqewr";
			//name of folder then base name. eg uploads/0 to 0
			//adddirdo (uploads/0, 0)
			$name .= '/';
			$location .= '/';
	 
			// Read all Files in Dir
			$dir = opendir ($location);
			while ($file = readdir($dir))
			{
				if ($file == '.' || $file == '..') continue;
	 
				// Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
				echo $do = (is_dir( $location . $file) == 'dir') ? 'addDir' : 'addFile';
				echo "<br>";
				echo filetype($location . $file);
				break;
				$this->$do($location . $file, $name . $file);
			}*/
		}
		function listFolderFilesUnShare($dir, $fileOwnerID, $fileShareeID){
			$ffs = scandir($dir);
			foreach($ffs as $ff){
				if($ff != '.' && $ff != '..'){
					if(is_dir($dir . $ff . "/")){
						$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID='$ff'") or die(mysql_error());
						if(mysql_num_rows($SQLQuery)==1){
							while($row = mysql_fetch_array($SQLQuery)) {
								$fileData = $row['folderID'];
								$status = $row['status'];
							}
							
							if($status == 0 or $status == 2){
							}elseif($status == 1){
								$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '0' WHERE folderID='$ff'") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}elseif($status == 3){
								$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '2' WHERE folderID='$ff'") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}else{
							}
							
							
							
							$SQLMakeSharedCheck = mysql_query("SELECT * FROM tblsharedfiles WHERE fileID='$ff' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
							if((mysql_num_rows($SQLMakeSharedCheck)>0)){
								$SQLMakeUnShared = mysql_query("DELETE FROM tblsharedfiles WHERE fileID='$ff' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
								mysql_query($SQLMakeUnShared);
							}else{
							}
						}else{
						}
						$this->listFolderFilesUnShare($dir . $ff . "/", $fileOwnerID, $fileShareeID);
					}elseif(is_file($dir.$ff)){
						$fileData = $dir.$ff;
						$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileData='$fileData'") or die(mysql_error());
						if(mysql_num_rows($SQLQuery)==1){
							$SQLMakeShared = mysql_query("UPDATE tblfile SET shared = '0' WHERE fileData='$fileData'") or die(mysql_error());
							mysql_query($SQLMakeShared);
							
							$SQLMakeSharedCheck = mysql_query("SELECT * FROM tblsharedfiles WHERE fileID='$fileData' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
							if((mysql_num_rows($SQLMakeSharedCheck)>0)){
								$SQLMakeUnShared = mysql_query("DELETE FROM tblsharedfiles WHERE fileID='$fileData' and fileOwnerID='$fileOwnerID' and fileShareeID='$fileShareeID'") or die(mysql_error());
								mysql_query($SQLMakeUnShared);
							}else{
							}
						}
					}
				}
			}
		}
		function functionCheckFileTypePublic($fileID, $folderUpperDirectory, $currentPath, $currentFolderID) {
			$this->functionDBConnect();
			$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileID='$fileID'") or die(mysql_error());//for confirmation in database only
			if(mysql_num_rows($SQLQuery)>0){
				//echo "if option";
				while($row = mysql_fetch_array($SQLQuery)) {
					$fileData = $row['fileData'];
				}
				$SQLMakeShared = mysql_query("UPDATE tblfile SET public = '1' WHERE fileID='$fileID'") or die(mysql_error());
				mysql_query($SQLMakeShared);
			}else{
				//echo "else option";
				$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID='$fileID'") or die(mysql_error());//for confirmation in database only
				if(mysql_num_rows($SQLQuery)>0){
					while($row = mysql_fetch_array($SQLQuery)) {
						$fileData = $row['folderID'];
						$status = $row['status'];
					}
					
					if($status == 0){
						$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '2' WHERE folderID='$fileID'") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}elseif($status == 1 or $status == 2){
						$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '3' WHERE folderID='$fileID'") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}else{
					}
					
					$this->listFolderFilesPublic($currentPath . $fileID . "/");
					
				}else{
					//echo "nothing was found";
				}
				
			}
			/*
			echo "qwerqewrqewr";
			//name of folder then base name. eg uploads/0 to 0
			//adddirdo (uploads/0, 0)
			$name .= '/';
			$location .= '/';
	 
			// Read all Files in Dir
			$dir = opendir ($location);
			while ($file = readdir($dir))
			{
				if ($file == '.' || $file == '..') continue;
	 
				// Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
				echo $do = (is_dir( $location . $file) == 'dir') ? 'addDir' : 'addFile';
				echo "<br>";
				echo filetype($location . $file);
				break;
				$this->$do($location . $file, $name . $file);
			}*/
		}
		function listFolderFilesPublic($dir){
			$ffs = scandir($dir);
			foreach($ffs as $ff){
				if($ff != '.' && $ff != '..'){
					if(is_dir($dir . $ff . "/")){
						$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID='$ff'") or die(mysql_error());
						if(mysql_num_rows($SQLQuery)==1){
							
							while($row = mysql_fetch_array($SQLQuery)) {
								$fileData = $row['folderID'];
								$status = $row['status'];
							}
							
							if($status == 0){
								$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '2' WHERE folderID='$ff'") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}elseif($status == 1 or $status == 2){
								$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '3' WHERE folderID='$ff'") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}else{
							}
							
							
						}else{
						}
						$this->listFolderFilesPublic($dir . $ff . "/");
					}elseif(is_file($dir.$ff)){
						$fileData = $dir.$ff;
						$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileData='$fileData'") or die(mysql_error());
						if(mysql_num_rows($SQLQuery)==1){
							$SQLMakeShared = mysql_query("UPDATE tblfile SET public = '1' WHERE fileData='$fileData'") or die(mysql_error());
							mysql_query($SQLMakeShared);
						}
						//echo "<br><br>This is a file: " . $dir . $ff ."<br><br>";
					}
					
					//echo '</li>';
				}
			}
			//echo "<br>end of function<br>";
			//echo '</ol>';
		}
		function functionCheckFileTypePrivate($fileID, $folderUpperDirectory, $currentPath, $currentFolderID) {
			$this->functionDBConnect();
			$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileID='$fileID'") or die(mysql_error());//for confirmation in database only
			if(mysql_num_rows($SQLQuery)>0){
				//echo "if option";
				while($row = mysql_fetch_array($SQLQuery)) {
					$fileData = $row['fileData'];
				}
				$SQLMakeShared = mysql_query("UPDATE tblfile SET public = '0' WHERE fileID='$fileID'") or die(mysql_error());
				mysql_query($SQLMakeShared);
			}else{
				//echo "else option";
				$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID='$fileID'") or die(mysql_error());//for confirmation in database only
				if(mysql_num_rows($SQLQuery)>0){
					while($row = mysql_fetch_array($SQLQuery)) {
						$fileData = $row['folderID'];
						$status = $row['status'];
					}
					
					if($status == 0){
					}elseif($status == 2){
						$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '0' WHERE folderID='$fileID'") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}elseif($status == 3){
						$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '2' WHERE folderID='$fileID'") or die(mysql_error());
						mysql_query($SQLMakeShared);
					}else{
					}
					
					$this->listFolderFilesPrivate($currentPath . $fileID . "/");
					
				}else{
					//echo "nothing was found";
				}
				
			}
			/*
			echo "qwerqewrqewr";
			//name of folder then base name. eg uploads/0 to 0
			//adddirdo (uploads/0, 0)
			$name .= '/';
			$location .= '/';
	 
			// Read all Files in Dir
			$dir = opendir ($location);
			while ($file = readdir($dir))
			{
				if ($file == '.' || $file == '..') continue;
	 
				// Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
				echo $do = (is_dir( $location . $file) == 'dir') ? 'addDir' : 'addFile';
				echo "<br>";
				echo filetype($location . $file);
				break;
				$this->$do($location . $file, $name . $file);
			}*/
		}
		function listFolderFilesPrivate($dir){
			$ffs = scandir($dir);
			foreach($ffs as $ff){
				if($ff != '.' && $ff != '..'){
					if(is_dir($dir . $ff . "/")){
						$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID='$ff'") or die(mysql_error());
						if(mysql_num_rows($SQLQuery)==1){
							
							while($row = mysql_fetch_array($SQLQuery)) {
								$fileData = $row['folderID'];
								$status = $row['status'];
							}
							
							if($status == 0){
							}elseif($status == 2){
								$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '0' WHERE folderID='$ff'") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}elseif($status == 3){
								$SQLMakeShared = mysql_query("UPDATE tblfolder SET status = '2' WHERE folderID='$ff'") or die(mysql_error());
								mysql_query($SQLMakeShared);
							}else{
							}
							
							
						}else{
						}
						$this->listFolderFilesPrivate($dir . $ff . "/");
					}elseif(is_file($dir.$ff)){
						$fileData = $dir.$ff;
						$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileData='$fileData'") or die(mysql_error());
						if(mysql_num_rows($SQLQuery)==1){
							$SQLMakeShared = mysql_query("UPDATE tblfile SET public = '0' WHERE fileData='$fileData'") or die(mysql_error());
							mysql_query($SQLMakeShared);
						}
						//echo "<br><br>This is a file: " . $dir . $ff ."<br><br>";
					}
					
					//echo '</li>';
				}
			}
			//echo "<br>end of function<br>";
			//echo '</ol>';
		}
		function listTrashFiles($fileID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblfile
						SET
							status='0'
						WHERE fileID='$fileID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
		}
		function listTrashFolder($folderID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblfolder
						SET
							status='0'
						WHERE folderID='$folderID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
			
			
			$SQLQuery = mysql_query("UPDATE tblfile
						SET
							status='0'
						WHERE folderID='$folderID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
		}
		function listRestoreFiles($fileID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblfile
						SET
							status='1'
						WHERE fileID='$fileID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
		}
		function listRestoreFolder($folderID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblfolder
						SET
							status='1'
						WHERE folderID='$folderID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
			
			
			$SQLQuery = mysql_query("UPDATE tblfile
						SET
							status='1'
						WHERE folderID='$folderID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
		}
		function ShareFiles($fileID, $fileOwnerID, $fileShareeID){
			$this->functionDBConnect();
			
			$SQLQuery = mysql_query("INSERT INTO tblsharedfiles
			(fileID, fileOwnerID, fileShareeID)
			VALUES
			('$fileID','$fileOwnerID','$fileShareeID')") or die(mysql_error());
			mysql_query($SQLQuery);
			
			$SQLQuery = mysql_query("UPDATE tblfile
						SET
							shared='1'
						WHERE fileID='$fileID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
			
			$SQLQuery = mysql_query("UPDATE tbluser
						SET
							userIncomingFile='1'
						WHERE userID='$fileShareeID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
			
			
			
		}
		function UnShareFiles($fileID, $fileOwnerID, $fileShareeID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("DELETE FROM tblsharedfiles WHERE fileID='$fileID' and $fileShareeID='$fileShareeID'") or die(mysql_error());
			mysql_query($SQLQuery);
			
			$SQLQuery = mysql_query("UPDATE tblfile
						SET
							shared='0'
						WHERE fileID='$fileID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
		}
		function Publicize($fileID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblfile
						SET
							public='1'
						WHERE fileID='$fileID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
		}
		function UnPublicize($fileID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("UPDATE tblfile
						SET
							public='0'
						WHERE fileID='$fileID'") or die(mysql_error());
		
			mysql_query($SQLQuery);
		}
		function sessionEditUserInfo($userID){
			$this->functionDBConnect();
			$SQLQuery = mysql_query("SELECT * FROM tbluser WHERE userID='$userID'") or die(mysql_error());
			if(mysql_num_rows($SQLQuery)>0){
				while($row = mysql_fetch_array($SQLQuery)){
					$_SESSION['userIDx'] = $row['userID'];
					$_SESSION['userNamex'] = $row['userName'];
					$_SESSION['userPasswordx'] = $row['userPassword'];
					$_SESSION['userFirstNamex'] = $row['userFirstName'];
					$_SESSION['userLastNamex'] = $row['userLastName'];
					$_SESSION['userLevelx'] = $row['userLevel'];
					$_SESSION['userAccountStatusx'] = $row['userAccountStatus'];
					$_SESSION['userRegistrationDatex'] = $row['userRegistrationDate'];
					$_SESSION['userStorageCapacityx'] = $row['userStorageCapacity'];
				}
			}
		}
		function functionUpdateUser($userID, $userName, $userPassword, $userFirstName, $userLastName, $userLevel, $userAccountStatus, $userRegistrationDate, $userStorageCapacity){
			
			/*$_SESSION['userIDx'] = $row['userID']; //license number
			$_SESSION['userNamex'] = $row['userName'];
			$_SESSION['userPasswordx'] = $row['userPassword'];
			$_SESSION['saltx'] = $row['salt'];
			$_SESSION['userLevelx'] = $row['userLevel'];
			$_SESSION['userAccountStatusx'] = $row['userAccountStatus'];
			$_SESSION['userRegistrationDatex'] = $row['userRegistrationDate'];
			$_SESSION['userFirstNamex'] = $row['userFirstName'];
			$_SESSION['userMiddleNamex'] = $row['userMiddleName'];
			$_SESSION['userLastNamex'] = $row['userLastName'];
			$_SESSION['DOBx'] = $row['DOB'];
			$_SESSION['genderx'] = $row['gender'];
			$_SESSION['addressx'] = $row['address'];
			$_SESSION['contactNumberx'] = $row['contactNumber'];*/
			$this->functionDBConnect();
			if(empty($userPassword) or $userPassword == " "){
				$SQLQuery = "UPDATE tbluser
							SET
								userName='$userName',
								userLevel='$userLevel',
								userAccountStatus='$userAccountStatus',
								userRegistrationDate='$userRegistrationDate',
								userFirstName='$userFirstName',
								userLastName='$userLastName',
								userStorageCapacity = '$userStorageCapacity'
							WHERE userID='$userID'";
				if (!mysql_query($SQLQuery,$this->functionDBConnect()))
				{
					die ('Error: ' . mysql_error());
				}
				/*$SQLQuery = "UPDATE tbluser
				(userID, userName, userPassword, salt, userLevel, userAccountStatus, userRegistrationDate, userFirstName, userMiddleName, userLastName, DOB, gender, address, contactNumber)
				VALUES
				('$userID','$userName','$encryptedPassword','$salt','$userLevel','$userAccountStatus','$dateToday','$userFirstName','$userMiddleName','$userLastName','$DOBx','$gender','$address','$contactNumber')";*/
				
			}else{
				$salt = $this->functionGenerateSalt();
				$encryptedPassword = $this->functionEncryptPassword($userPassword,$salt);
				
				$SQLQuery = "UPDATE tbluser
							SET
								userName='$userName',
								userPassword = '$encryptedPassword',
								salt = '$salt',
								userLevel='$userLevel',
								userAccountStatus='$userAccountStatus',
								userRegistrationDate='$userRegistrationDate',
								userFirstName='$userFirstName',
								userLastName='$userLastName',
								userStorageCapacity = '$userStorageCapacity'
							WHERE userID='$userID'";
				if (!mysql_query($SQLQuery,$this->functionDBConnect()))
				{
					die ('Error: ' . mysql_error());
				}
			}
		}
		function functionAddUser($userID, $userName, $userPassword, $userPasswordReType, $userLevel, $userAccountStatus, $userFirstName,$userLastName, $userStorageCapacity){
			//echo $userID, $userName, $userPassword, $userPasswordReType, $userLevel, $userAccountStatus, $userFirstName, $userMiddleName,$userLastName,$DOBx,$gender,$address,$contactNumber;
			$this->functionDBConnect();
			$salt = $this->functionGenerateSalt();
			if($this->functionCheckUserID($userID) == 1){
				$this->errorMessage = "UserID Unavailable!";
				$this->functionError();
			}
			if($this->functionCheckUserName($userName) == 1){
				$this->errorMessage = "Username Unavailable!";
				$this->functionError();
			}
			if($this->functionCheckPasswordSignUp($userPassword,$userPasswordReType) == false){
				$this->errorMessage = "Password Unmatch!";
				$this->functionError();
			}else{
				$encryptedPassword = $this->functionEncryptPassword($userPassword,$salt);
			}
			$dateToday = date('Y') . "-" . date('m')  . "-" . date('d'). " " . date('h')  . ":" . date('i'). ":" . date('s');
			$SQLQuery = "INSERT INTO tbluser
			(userID, userName, userPassword, salt, userFirstName, userLastName, userLevel, userAccountStatus, userRegistrationDate, userStorageCapacity)
		VALUES
		('$userID','$userName','$encryptedPassword','$salt','$userFirstName','$userLastName','$userLevel','$userAccountStatus','$dateToday','$userStorageCapacity')";
			if (!mysql_query($SQLQuery,$this->functionDBConnect()))
			{
				die ('Error: ' . mysql_error());
			}
			
			
		}
		function functionUpdateUserEditProfile($userID, $userName, $userPassword, $userReTypePassword, $userFirstName, $userLastName){
			
			/*$_SESSION['userIDx'] = $row['userID']; //license number
			$_SESSION['userNamex'] = $row['userName'];
			$_SESSION['userPasswordx'] = $row['userPassword'];
			$_SESSION['saltx'] = $row['salt'];
			$_SESSION['userLevelx'] = $row['userLevel'];
			$_SESSION['userAccountStatusx'] = $row['userAccountStatus'];
			$_SESSION['userRegistrationDatex'] = $row['userRegistrationDate'];
			$_SESSION['userFirstNamex'] = $row['userFirstName'];
			$_SESSION['userMiddleNamex'] = $row['userMiddleName'];
			$_SESSION['userLastNamex'] = $row['userLastName'];
			$_SESSION['DOBx'] = $row['DOB'];
			$_SESSION['genderx'] = $row['gender'];
			$_SESSION['addressx'] = $row['address'];
			$_SESSION['contactNumberx'] = $row['contactNumber'];*/
			$this->functionDBConnect();
			if(empty($userPassword) or $userPassword == " "){
				$SQLQuery = "UPDATE tbluser
							SET
								userName='$userName',
								userFirstName='$userFirstName',
								userLastName='$userLastName'
							WHERE userID='$userID'";
				if (!mysql_query($SQLQuery,$this->functionDBConnect()))
				{
					die ('Error: ' . mysql_error());
				}
				/*$SQLQuery = "UPDATE tbluser
				(userID, userName, userPassword, salt, userLevel, userAccountStatus, userRegistrationDate, userFirstName, userMiddleName, userLastName, DOB, gender, address, contactNumber)
				VALUES
				('$userID','$userName','$encryptedPassword','$salt','$userLevel','$userAccountStatus','$dateToday','$userFirstName','$userMiddleName','$userLastName','$DOBx','$gender','$address','$contactNumber')";*/
				
			}else{
				$salt = $this->functionGenerateSalt();
				if($this->functionCheckPasswordSignUp($userPassword,$userReTypePassword) == false){
					$this->errorMessage = "Password Unmatch!";
					$this->functionError();
					exit;
				}else{
					$encryptedPassword = $this->functionEncryptPassword($userPassword,$salt);
					$SQLQuery = "UPDATE tbluser
							SET
								userName='$userName',
								userPassword = '$encryptedPassword',
								salt = '$salt',
								userFirstName='$userFirstName',
								userLastName='$userLastName'
							WHERE userID='$userID'";
					if (!mysql_query($SQLQuery,$this->functionDBConnect()))
					{
						die ('Error: ' . mysql_error());
					}
				}
			}
			
		}
		function functionAcceptEULA($userID){
			$this->functionDBConnect();
			$SQLQuery = "UPDATE tbluser
							SET
								userEULA='1'
							WHERE userID='$userID'";
					if (!mysql_query($SQLQuery,$this->functionDBConnect()))
					{
						die ('Error: ' . mysql_error());
					}
		}
	}
	
	
	//tbl folder status: 0 = private 1= shared 2=public 3=shared and public
?>
