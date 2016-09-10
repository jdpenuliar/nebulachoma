<?php
	session_start();
	require_once("./include/DBConfigs.php");
	if(isset($_POST['btnLogin'])){
		$xuname = $_POST['username'];
		$xpword = $_POST['password'];
		$classDBRelatedFunctions->functionUserAuthentication($xuname,$xpword);
	}//login button checcker
	if(isset($_POST['btnCreateFolder'])){
		$classDBRelatedFunctions->functionDBConnect();
		$folderUpperDirectory = $_GET['currentFolderID'];
		$currentPath = $_GET['currentPath'];
		if($classDBRelatedFunctions->functionCheckFolder($_SESSION['userID'],$_SESSION['folderID'],$_POST['fName'],$folderUpperDirectory) == 1){
			echo "Folder already available";
		}else{$classDBRelatedFunctions->functionCreateFolder($_SESSION['userID'],$_SESSION['folderID'],$_POST['fName'], $folderUpperDirectory, $currentPath);
		}
	}// create button working
	if(!empty($_SESSION['userName'])){
		$userID = $_SESSION['userID'];
		$userName = $_SESSION['userName'] ;
		$userPassword = $_SESSION['userPassword'];
		$userLevel = $_SESSION['userLevel'];
		$pagePasser = $_SESSION['pagePasser'];
		$counter = $_SESSION['counter'];
		
		if(isset($_POST['bnt_logout'])){
			$userID = "none";
			$userName = "none";
			$userPassword = "none";
			/*echo" index.php counter " .*/ $counter = "0";
			$userLevel = "0";
			$pagePasser = 0;
			/*echo "page passer is zero";*/
			session_destroy();
			$classDBRelatedFunctions->functionDBDisconnect();
		}
	}else{
		$userID = "none";
		$userName = "none" . "else";
		$userPassword = "none";
		/*echo " index.php counter " . */ $counter = "0";
		$userLevel = "0";
		/*echo "page passer of index.php" .*/ $pagePasser = 0;
		session_destroy();
		$classDBRelatedFunctions->functionDBDisconnect();
	}//session checker
	if(isset($_POST['btnSignup'])){
		$SUuserID = $_POST['studentID'];
		$SUuserName = $_POST['userName'];
		$SUuserPassword = $_POST['userPassword'];
		$SUuserPasswordReType = $_POST['userPasswordReType'];
		$SUuserFirstName = $_POST['userFirstName'];
		$SUuserLastName = $_POST['userLastName'];
		$classDBRelatedFunctions->functionUserSignup($SUuserID, $SUuserName, $SUuserPassword, $SUuserPasswordReType, $SUuserFirstName, $SUuserLastName);
	}//signup button checcker
	if(isset($_POST['btnUpload']) and $_FILES['userFile']['size'] > 0){
		$NumberOfFiles = 0;
		$uploadTotalSize = 0;
		foreach($_FILES['userFile']['name'] as $key => $name ){
			$userID = $_SESSION['userID'];
			$fName = $_FILES['userFile']['name'][$key];
			$fileSize =$_FILES['userFile']['size'][$key];
			$tmpName =$_FILES['userFile']['tmp_name'][$key];
			$fileMime=$_FILES['userFile']['type'][$key];
			$fileError=$_FILES['userFile']['error'][$key];
			
			$uploadTotalSize += $fileSize;
		}
		if($uploadTotalSize < (($_SESSION['userStorageCapacityMax'] * 1073741824) - $_SESSION['userUsedBytes'])){
			foreach($_FILES['userFile']['name'] as $key => $name ){
				$userID = $_SESSION['userID'];
				$fName = $_FILES['userFile']['name'][$key];
				$fileSize =$_FILES['userFile']['size'][$key];
				$tmpName =$_FILES['userFile']['tmp_name'][$key];
				$fileMime=$_FILES['userFile']['type'][$key];
				$fileError=$_FILES['userFile']['error'][$key];
				if($classDBRelatedFunctions->fileCheck($fName,$_GET['currentFolderID'])==1){
					echo "file already available";
				}else{
					if($fileError>0){
						echo "Error: " . $fileError . "<br />";
					}else{
						$userID = $_SESSION['userID'];
						$fName = $_FILES['userFile']['name'][$key];
						$fileSize =$_FILES['userFile']['size'][$key];
						$tmpName =$_FILES['userFile']['tmp_name'][$key];
						$fileMime=$_FILES['userFile']['type'][$key];
						
						$currentPath = $_GET['currentPath'];
						
						if (!file_exists($currentPath)) {
							mkdir($currentPath, 0777, true);
						}
						
						
						
						move_uploaded_file($tmpName,
						$currentPath . "/" . $fName);
						
						$folderID = $_GET['currentFolderID'];//prob
						$fileData = $currentPath . "/" .$fName;
						
						$classDBRelatedFunctions->fileUploadToDB($userID ,$fName,$fileMime,$fileSize,$fileData, $folderID);
						echo "<script>";
							echo "alert(\"Your file(s) are uploaded\");";
						echo "</script>";
					}
				}	
				
			}
		}
	}//multiple file upload working!!!!!!!!!!!!!!
	if(isset($_POST['fileIDPasser'])) {
		$id = $_POST['fileIDPasser'];		
		$classDBRelatedFunctions->functionDBConnect();
		if(mysqli_connect_errno()) {
			die("MySQL connection failed: ". mysqli_connect_error());
		}
		$SQLQuery = mysql_query("SELECT fName, fileMime, fileData FROM tblfile where fileID = $id") or die(mysql_error());
			//$result = $dbLink->query($sql);
			if(mysql_num_rows($SQLQuery)>0){
				while($row = mysql_fetch_array($SQLQuery)) {
					$fName = $row['fName'];
					$fileMime = $row['fileMime'];
					$fileData = $row['fileData'];
				}
			}else{
				echo "There are no files in the database";
			}
		header('Pragma: public'); 	// required
		header('Expires: 0');		// no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($fName)).' GMT');
		header('Cache-Control: private',false);
		header('Content-Type: '.$fileMime);
		header('Content-Disposition: attachment; filename="'.basename($fName).'"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($fName));	// provide file size
		header('Connection: close');
		readfile($fName);		// push it out
		exit();
	}//force download no longer experiement
	if(isset($_POST['btnDownload'])){
		if(!empty($_POST['cbg1'])) {
			$fileNames=array();
			$classDBRelatedFunctions->functionDBConnect();
			foreach($_POST['cbg1'] as $check) {
				$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileID = '$check'") or die(mysql_error());
				if(mysql_num_rows($SQLQuery)>0){
					while($row = mysql_fetch_array($SQLQuery)) {
						//echo "{$row['fName']}";
						$id = $row['fileID'];
						array_push($fileNames, $row['fName']);
					}
				}
			}
			
		}else{
			echo "empty";
		}
		
		if($arrlength == 1){
			$SQLQuery = mysql_query("SELECT fName, fileMime, fileData FROM tblfile where fileID = $id") or die(mysql_error());
			//$result = $dbLink->query($sql);
			if(mysql_num_rows($SQLQuery)>0){
				while($row = mysql_fetch_array($SQLQuery)) {
					$fName = $row['fName'];
					$fileMime = $row['fileMime'];
					$fileData = $row['fileData'];
				}
			}else{
				echo "There are no files in the database";
			}
			header('Pragma: public'); 	// required
			header('Expires: 0');		// no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($fName)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$fileMime);
			header('Content-Disposition: attachment; filename="'.basename($fName).'"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($fName));	// provide file size
			header('Connection: close');
			readfile($fName);		// push it out
			exit();
		}else{
			$zip = new ZipArchive();
			echo $zip_name = time().".zip"; // Zip name
			echo $_SESSION['currentPath'];
			$zip->open($zip_name,  ZipArchive::CREATE);
			foreach ($fileNames as $file) {
				echo $path = $_SESSION['currentPath'].$file;
				
				if(file_exists($path)){
					$zip->addFromString(basename($path),  file_get_contents($path));  
				}
				else{
					echo"file does not exist";
				}
			}
			$zip->close();
			
			header("Content-type: application/zip"); 
			header("Content-Disposition: attachment; filename=$zip_name"); 
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			readfile("$zip_name");
			unlink("$zip_name"); 
			exit;
		}
		
	}//filedonwloadaszip multiple files experiment
	if(isset($_POST['btnDownloadFolder'])){
		$the_folder = 'uploads/0/0_1';
		$zip_file_name = 'archive.zip';
		 
		$res = $classDBRelatedFunctions->open($zip_file_name, ZipArchive::CREATE);
		 
		if($res === TRUE) {
			$classDBRelatedFunctions->addDir($the_folder, basename($the_folder));
			$classDBRelatedFunctions->close();
			header("Content-type: application/zip"); 
			header("Content-Disposition: attachment; filename=$zip_file_name"); 
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			readfile("$zip_file_name");
			unlink("$zip_file_name"); 
			exit;
		}
		else
			echo 'Could not create a zip archive';
			
		
	}//download folder experiment
	if(isset($_POST['btnDownloadExperiment'])){
		
		if(!empty($_POST['cbg1'])) {
			$fileNames=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			
			$classDBRelatedFunctions->functionDBConnect();
		
			foreach($_POST['cbg1'] as $check) {
				$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileID = '$check' AND userID = '$userID'") or die(mysql_error());
				if(mysql_num_rows($SQLQuery)>0){
					while($row = mysql_fetch_array($SQLQuery)) {
						$id = $row['fileID'];
						array_push($fileNames, $row['fName']);
					}
				}else{
					$SQLQuery = mysql_query("SELECT * FROM tblfolder WHERE folderID = '$check' AND userID = '$userID' AND folderUpperDirectory = '$currentFolderID'") or die(mysql_error());
					if(mysql_num_rows($SQLQuery)>0){
						while($row = mysql_fetch_array($SQLQuery)) {
							$id = $row['folderID'];
							array_push($fileNames, $row['folderID']);
						}
					}
				}
			}
		}else{
		}
		$arrlength=count($fileNames);//pushes the check list to array
		
		
		
		//zipping process
		
		
		//this is for only 1 checked box
		if($arrlength == 1){
			
			//This is for folder downloads
			$SQLQuery = mysql_query("SELECT folderID FROM tblfolder where folderID = '$fileNames[0]' AND userID = '$userID' and folderUpperDirectory = '$currentFolderID'") or die(mysql_error());
			if(mysql_num_rows($SQLQuery)>0){
				//to check if the array name is a directory then it will be zipped and downloaded
				while($row = mysql_fetch_array($SQLQuery)) {
					$folderID = $row['folderID'];
					$_SESSION['currentPath'] . "/" . $folderID . "<br>";
					//echo $do = (filetype( $_SESSION['currentPath'] . $folderID) == 'dir') ? 'addDir' : 'addFile';
					
					$the_folder = $_SESSION['currentPath'] . "/" . $folderID;
					$zipname = $zip_file_name = 'Nebulachoma.zip';
					$rootPath = realpath($the_folder);
					$za = new classDBRelatedFunctions;
					
					$res = $za->open($zip_file_name, ZipArchive::CREATE);
					
					if($res === TRUE) {
						$za->addDir($the_folder, basename($the_folder));
						$za->close();
						header("Content-type: application/zip"); 
						header("Content-Disposition: attachment; filename=$zip_file_name"); 
						header("Pragma: no-cache"); 
						header("Expires: 0"); 
						readfile("$zip_file_name");
						unlink("$zip_file_name");
					}
						
				}
			}
			
			
			
			//if the file name in the array is a file not a directory this will download directly
			$SQLQuery = mysql_query("SELECT fName, fileMime, fileData FROM tblfile where fileID = '$id'") or die(mysql_error());
			//$result = $dbLink->query($sql);
			if(mysql_num_rows($SQLQuery)>0){
				while($row = mysql_fetch_array($SQLQuery)) {
					$fName = $row['fName'];
					$fileMime = $row['fileMime'];
					$fileData = $row['fileData'];
				}
			}else{
				echo "There are no files in the databaseadsf";
			}
			echo $file = realpath($fileData);
			if(file_exists($file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($file);
				exit;
			}else{
				echo "patawad";
			}
			
			
			
			
		}else{//this is when there are multiple files checked
			
				
			if (!file_exists('temp/' . $userID)) {
				mkdir('temp/' . $userID, 0777, true);
			}
			foreach ($fileNames as $file) {
				echo $file;
				echo "<br> path: ";
				echo $path = $_SESSION['currentPath']. "/" .$file ;
				echo "<br>";
				echo $do = (is_dir($path) == 'dir') ? 'addDir' : 'addFile';
				echo "<br>";
				if($do == "addFile"){
					copy($_SESSION['currentPath'] . '/' . $file, 'temp/' . $userID . '/' . $file); 
					
				}else{
					$classDBRelatedFunctions->recurse_copy($_SESSION['currentPath'],'temp/' . $userID);//$src,$dst
				}
			}
			$the_folder = 'temp/' . $userID;
			$zipname = $zip_file_name = 'Nebulachoma.zip';
			$rootPath = realpath($the_folder);
			$za = new classDBRelatedFunctions;
			
			$res = $za->open($zip_file_name, ZipArchive::CREATE);
			
			if($res === TRUE) {
				$za->addDir($the_folder, basename($the_folder));
				$za->close();
				header("Content-type: application/zip"); 
				header("Content-Disposition: attachment; filename=$zip_file_name"); 
				header("Pragma: no-cache"); 
				header("Expires: 0"); 
				readfile("$zip_file_name");
				unlink("$zip_file_name");
			}
			else{
				echo 'Could not create a zip archive';
			}
			$classDBRelatedFunctions->functionDeleteFolder($the_folder);
			//$classDBRelatedFunctions->recurse_copy('uploads/12/12_1','temp/' . basename($_SESSION['currentPath']));//$src,$dst
			
		}
		break;
	}//real working download!!!!!!!!!!!!!!!!!!!!!!!!
	if(isset($_POST['btnPublic'])){
		if(!empty($_POST['cbg1'])) {
			$fileNames=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			$classDBRelatedFunctions->functionDBConnect();
			foreach($_POST['cbg1'] as $check) {
				$classDBRelatedFunctions->functionCheckFileTypePublic($check, $folderUpperDirectory, $currentPath, $currentFolderID);
				array_push($fileNames, $check);
			}
			echo "<script>";
				echo "alert(\"Your file(s) are publicized\");";
			echo "</script>";
		}else{
			echo "empty";
		}
		
	}
	if(isset($_POST['btnPrivate'])){
		if(!empty($_POST['cbg1'])) {
			$fileNames=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			
			$classDBRelatedFunctions->functionDBConnect();
			foreach($_POST['cbg1'] as $check) {
				$classDBRelatedFunctions->functionCheckFileTypePrivate($check, $folderUpperDirectory, $currentPath, $currentFolderID);
			}
		}else{
			echo "empty";
		}
	}
	if(isset($_POST['btnShare'])){
		if(!empty($_POST['cbg1']) and !empty($_POST['cbg2'])) {
			$fileIDs=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			//$classDBRelatedFunctions->functionDBConnect();
			$fileIDs=array();
			$userIDs=array();
			
			foreach($_POST['cbg1'] as $check) {
				foreach($_POST['cbg2'] as $check2) {
					$classDBRelatedFunctions->functionCheckFileTypeSharing($check2, $check, $folderUpperDirectory, $currentPath, $currentFolderID);
					array_push($userIDs, $check2);
				}
				array_push($fileIDs, $check);
			}
			
		}
	}
	if(isset($_POST['btnUnShare'])){
		if(!empty($_POST['cbg1']) and !empty($_POST['cbg2'])) {
			$fileIDs=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			//$classDBRelatedFunctions->functionDBConnect();
			$fileIDs=array();
			$userIDs=array();
			
			foreach($_POST['cbg1'] as $check) {
				foreach($_POST['cbg2'] as $check2) {
					$classDBRelatedFunctions->functionCheckFileTypeUnShare($check2, $check, $folderUpperDirectory, $currentPath, $currentFolderID);
					array_push($userIDs, $check2);
				}
				array_push($fileIDs, $check);
			}
			echo "<script>";
				echo "alert(\"Your file(s) are unshared\");";
			echo "</script>";
		}
	}
	if(isset($_POST['btnTrash'])){
		if(!empty($_POST['cbg1'])) {
			$fileNames=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			
			$classDBRelatedFunctions->functionDBConnect();
		
			foreach($_POST['cbg1'] as $check) {
				$path = $_SESSION['currentPath']. "/" .$check ;
				$do = (is_dir($path) == 'dir') ? 'addDir' : 'addFile';
				if($do == "addFile"){
					$classDBRelatedFunctions->listTrashFiles($check);
				}else{
					$classDBRelatedFunctions->listTrashFolder($check);
				}
			}
			echo "<script>";
				echo "alert(\"Your file(s) are trashed\");";
			echo "</script>";
		}else{
		}
	}
	if(isset($_POST['btnRestore'])){
		if(!empty($_POST['cbg1'])) {
			$fileNames=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			
			$classDBRelatedFunctions->functionDBConnect();
		
			foreach($_POST['cbg1'] as $check) {
				$path = $_SESSION['currentPath']. "/" .$check ;
				$do = (is_dir($path) == 'dir') ? 'addDir' : 'addFile';
				if($do == "addFile"){
					$classDBRelatedFunctions->listRestoreFiles($check);
				}else{
					$classDBRelatedFunctions->listRestoreFolder($check);
				}
			}
			echo "<script>";
				echo "alert(\"Your file(s) are restored\");";
			echo "</script>";
		}else{
		}
	}
	if(isset($_POST['btnShare'])){
		if(!empty($_POST['cbg1'])) {
			$_SESSION['userSharingList'] = 1;
			$fileIDs=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			$fileIDsCounter = 0;
			foreach($_POST['cbg1'] as $check) {
				array_push($fileIDs,$check);
			}
			$_SESSION['fileIDs'] = $fileIDs;
			
		}else{
		}
	}
	if(isset($_POST['btnSharex'])){
		if(!empty($_POST['cbg1'])) {
			unset($_SESSION['userSharingList']);
			$fileIDsCounter = 0;
			foreach($_POST['cbg1'] as $check) {
				foreach($_SESSION['fileIDs'] as $files) {
					$classDBRelatedFunctions->ShareFiles($files,$_SESSION['userID'], $check);
				}
			}
			echo "<script>";
				echo "alert(\"Your file(s) are shared\");";
			echo "</script>";
		}else{
		}
	}
	if(isset($_POST['btnUnShare'])){
		if(!empty($_POST['cbg1'])) {
			$_SESSION['userSharingList'] = 1;
			$fileIDs=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			$fileIDsCounter = 0;
			foreach($_POST['cbg1'] as $check) {
				array_push($fileIDs,$check);
			}
			$_SESSION['fileIDs'] = $fileIDs;
		}else{
		}
	}
	if(isset($_POST['btnUnSharex'])){
		if(!empty($_POST['cbg1'])) {
			unset($_SESSION['userSharingList']);
			$fileIDsCounter = 0;
			foreach($_POST['cbg1'] as $check) {
				foreach($_SESSION['fileIDs'] as $files) {
					$classDBRelatedFunctions->UnShareFiles($files,$_SESSION['userID'], $check);
				}
			}
			echo "<script>";
				echo "alert(\"Your file(s) are unshared\");";
			echo "</script>";
		}else{
		}
	}
	if(isset($_POST['btnPublicize'])){
		if(!empty($_POST['cbg1'])) {
			foreach($_POST['cbg1'] as $check) {
				$classDBRelatedFunctions->Publicize($check);
			}
			echo "<script>";
				echo "alert(\"Your file(s) are publicized\");";
			echo "</script>";
		}else{
		}
	}
	if(isset($_POST['btnUnPublicize'])){
		if(!empty($_POST['cbg1'])) {
			foreach($_POST['cbg1'] as $check) {
				$classDBRelatedFunctions->UnPublicize($check);
			}
			echo "<script>";
				echo "alert(\"Your file(s) are unpublicized\");";
			echo "</script>";
		}else{
		}
	}
	if(isset($_POST['btnDelete'])){
		if(!empty($_POST['cbg1']) and !empty($_POST['cbg2'])) {
			$fileIDs=array();
			$folderUpperDirectory = $_SESSION['folderUpperDirectory'];
			$currentPath = $_SESSION['currentPath'];
			$currentFolderID = $_SESSION['currentFolderID'];
			$classDBRelatedFunctions->functionDBConnect();
			$fileIDs=array();
			$userIDs=array();
			foreach($_POST['cbg1'] as $check) {
				$sql = "UPDATE tblfile SET shared = '0' WHERE fileID = '$check' AND userID = '$userID'";
				mysql_query($sql);
				array_push($fileIDs, $check);
				
			}
			foreach($_POST['cbg2'] as $check2) {
				array_push($userIDs, $check2);
				
			}
			
			
			$arrlengthx=count($fileIDs);
			$arrlengthy=count($userIDs);
			
			
			$myarray=array();
			foreach($_POST['cbg1'] as $fileID) {
				
				
				foreach($_POST['cbg2'] as $userIDx) {
					$myarray[$fileID][] = $userIDx;
				
				}
				echo "<br>";
			}
			
			
			$arrlenghtsum = $arrlengthx + $arrlengthy;
			foreach($_POST['cbg1'] as $fileID) {
				for($y = 0; $y < $arrlengthy; $y++){
					
					
					
					$queryaddT="DELETE FROM tblsharedfiles WHERE fileID = '".$fileID."' AND fileOwnerID = '".$userID."' AND fileShareeID = '".$myarray[$fileID][$y]."'";
					$resultaddF=mysql_query($queryaddT) or die(mysql_error());
				}
				
				$arrlenghtsum -= 1; 
				
			}
		}
	}
	if(isset($_POST['btnEdit'])){
		if(!empty($_POST['radioUserID']) and ($_POST['radioUserID'] != 0)/*somehow if a post gets a value of 0 from a submit it reads it as empty*/) {
			$_SESSION['editUserPage'] = 1;
			$classDBRelatedFunctions->sessionEditUserInfo($_POST['radioUserID']);
		}else{
		}
	}
	if(isset($_POST['btnCancel'])){
		unset($_SESSION['editUserPage']);
		unset($_SESSION['userIDx']);
		unset($_SESSION['userNamex']);
		unset($_SESSION['userPasswordx']);
		unset($_SESSION['userFirstNamex']);
		unset($_SESSION['userLastNamex']);
		unset($_SESSION['userLevelx']);
		unset($_SESSION['userAccountStatusx']);
		unset($_SESSION['userRegistrationDatex']);
		unset($_SESSION['userStorageCapacityx']);
	}//for admin panel edit user
	if(isset($_POST['btnAddUser'])){
		$_SESSION['addUserPage'] = 1;
	}
	if(isset($_POST['btnAddUserx'])){
		$userID = $_POST['userID'];//license number
		$userName = $_POST['userName'];
		$userPassword = $_POST['userPassword'];
		$userReTypePassword = $_POST['userReTypePassword'];
		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];
		$userLevel = $_POST['userLevel'];
		$userAccountStatus = $_POST['userAccountStatus'];
		$userStorageCapacity = 5;
		$classDBRelatedFunctions->functionUserSignup($userID, $userName, $userPassword, $userReTypePassword, $userLevel, $userAccountStatus, $userFirstName,$userLastName,$userStorageCapacity);
		unset($_SESSION['addUserPage']);
		echo "<script>";
			echo "alert(\"New user has been added\")";
		echo "</script>";
	}
	if(isset($_POST['btnCancelAddUser'])){
		unset($_SESSION['addUserPage']);
	}//for admin panel add user
	if(isset($_POST['btnUpdateUser'])){
		$userIDx = $_SESSION['userIDx'];
		
		if(empty($_POST['userNamex']) or $_POST['userNamex'] == " "){
			$userNamex = $_SESSION['userNamex'];
		}else{
			$userNamex = $_POST['userNamex'];
		}
		
		//password skipped atm
		//its in the dbconfigs
		$userPasswordx = $_POST['userPasswordx'];
		
		if(empty($_POST['userFirstNamex']) or $_POST['userFirstNamex'] == " "){
			$userFirstNamex = $_SESSION['userFirstNamex'];
		}else{
			$userFirstNamex = $_POST['userFirstNamex'];
		}
		if(empty($_POST['userLastNamex']) or $_POST['userLastNamex'] == " "){
			$userLastNamex = $_SESSION['userLastNamex'];
		}else{
			$userLastNamex = $_POST['userLastNamex'];
		}
		if(empty($_POST['userLevelx']) or $_POST['userLevelx'] == " "){
			$userLevelx = $_SESSION['userLevelx'];
		}else{
			$userLevelx = $_POST['userLevelx'];
		}
		if(empty($_POST['userAccountStatusx']) or $_POST['userAccountStatusx'] == " "){
			$userAccountStatusx = $_SESSION['userAccountStatusx'];
		}else{
			$userAccountStatusx = $_POST['userAccountStatusx'];
		}
		if(empty($_POST['userRegistrationDatex']) or $_POST['userRegistrationDatex'] == " "){
			$userRegistrationDatex = $_SESSION['userRegistrationDatex'];
		}else{
			$userRegistrationDatex = $_POST['userRegistrationDatex'];
		}
		if(empty($_POST['userStorageCapacityx']) or $_POST['userStorageCapacityx'] == " "){
			$userStorageCapacityx = $_SESSION['userStorageCapacityx'];
		}else{
			$userStorageCapacityx = $_POST['userStorageCapacityx'];
		}
		//last condition is for the password to register changes
		$classDBRelatedFunctions->functionUpdateUser($userIDx, $userNamex, $userPasswordx, $userFirstNamex, $userLastNamex, $userLevelx, $userAccountStatusx, $userRegistrationDatex, $userStorageCapacityx);
		unset($_SESSION['editUserPage']);
		echo "<script>";
				echo "alert(\"Account updated\");";
			echo "</script>";
	}
	if(isset($_POST['btnUpdateUserEditProfile'])){
		$userIDx = $_SESSION['userID'];
		
		if(empty($_POST['userNameEditUserProfile']) or $_POST['userNameEditUserProfile'] == " "){
			$userNamex = $_SESSION['userNameEditUserProfile'];
		}else{
			$userNamex = $_POST['userNameEditUserProfile'];
		}
		
		//password skipped atm
		//its in the dbconfigs
		$userPasswordx = $_POST['userPasswordEditUserProfile'];
		$userReTypePasswordx = $_POST['userReTypePasswordEditUserProfile'];
		
		if(empty($_POST['userFirstNameEditUserProfile']) or $_POST['userFirstNameEditUserProfile'] == " "){
			$userFirstNamex = $_SESSION['userFirstNameEditUserProfile'];
		}else{
			$userFirstNamex = $_POST['userFirstNameEditUserProfile'];
		}
		if(empty($_POST['userLastNameEditUserProfile']) or $_POST['userLastNameEditUserProfile'] == " "){
			$userLastNamex = $_SESSION['userLastNameEditUserProfile'];
		}else{
			$userLastNamex = $_POST['userLastNamuserLastNameEditUserProfileex'];
		}
		//last condition is for the password to register changes
		$classDBRelatedFunctions->functionUpdateUserEditProfile($userIDx, $userNamex, $userPasswordx, $userReTypePasswordx, $userFirstNamex, $userLastNamex);
		echo "<script>";
				echo "alert(\"Account updated\");";
			echo "</script>";
	}
?>
<!doctype html>
<html>
<head>
    <title>Nebula Choma</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="./css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="./css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="./css/AdminLTE.css" rel="stylesheet" type="text/css" />
	
    
	<!-- DATA TABLES -->
    <link href="./css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="./css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="./css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
	
	<?php
		$classAssemble->functionIndex($pagePasser,$counter,$userLevel);
		
	?>
    <!-- jQuery 2.0.2 -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="./js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="./js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="./js/AdminLTE/app.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="./js/AdminLTE/demo.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="./js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
        $(function() {
            $("#example1").dataTable();
            $('#example2').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false
            });
        });
        $(function() {
            
            "use strict";

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            //When unchecking the checkbox
            $("#check-all").on('ifUnchecked', function(event) {
                //Uncheck all checkboxes
                $("input[type='checkbox']", ".table-mailbox").iCheck("uncheck");
            });
            //When checking the checkbox
            $("#check-all").on('ifChecked', function(event) {
                //Check all checkboxes
                $("input[type='checkbox']", ".table-mailbox").iCheck("check");
            });
            //Handle starring for glyphicon and font awesome
            $(".fa-star, .fa-star-o, .glyphicon-star, .glyphicon-star-empty").click(function(e) {
                e.preventDefault();
                //detect type
                var glyph = $(this).hasClass("glyphicon");
                var fa = $(this).hasClass("fa");

                //Switch states
                if (glyph) {
                    $(this).toggleClass("glyphicon-star");
                    $(this).toggleClass("glyphicon-star-empty");
                }

                if (fa) {
                    $(this).toggleClass("fa-star");
                    $(this).toggleClass("fa-star-o");
                }
            });

            //Initialize WYSIHTML5 - text editor
            $("#email_message").wysihtml5();
        });
    </script>
</html>