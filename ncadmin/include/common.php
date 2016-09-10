<script>//layers
	$(document).ready(function(){
		$("#seclayer").hide();
		$("#seclayer_desc").hide();
		$("#seclayerDesc").hide();
		$("#share").click(function(){
			$("#seclayer").show();
		});
		
		
		$("#btnClose").click(function(){
			$("#seclayer").hide();
		});
		
		$("#seclayerAsc").click(function(){
			$("#seclayerDesc").show();
			$("#seclayerAsc").hide();
			$("#seclayer_asc").hide();
			$("#seclayer_desc").show();
		});
		
		$("#seclayerDesc").click(function(){
			$("#seclayerDesc").hide();
			$("#seclayerAsc").show();
			$("#seclayer_desc").hide();
			$("#seclayer_asc").show();
		});
		
	});
</script>	
<?php
	//the common output skeleton of the site
	require_once("./include/DBConfigs.php");
	$classDBRelatedFunctions = new classDBRelatedFunctions;
	new classCommon;
	class classCommon extends classDBRelatedFunctions{
		
		function test(){
			echo"qewr";
		}
		function menu($pagePasser,$counter,$userLevel){
			
			if($pagePasser === 0){
				$this->menuLoggedout();//no user is logged in and button must be log in
			}else{
				
				if($userLevel == 1){
						$this->menuLoggedInAdminUser();
					}else{
						$this->menuLoggedInNormalUser();//user is logged in and button must be logout
					}
				
				
			}
		}
		function body($pagePasser,$counter,$userLevel){
			if($pagePasser == 0){
				//when signed out
				$this->Login();
			}else{
				if(!isset($_GET['counter'])){
					$counter == "0";
				}else{
					$counter = $_GET['counter'];
				}
				
				if($counter == "0"){
					$this->bodyLoggedin();
				}elseif($counter == "1"){
					echo "counter is 1";
					
				}
				//echo "</div>";
			}
		}
		function Login(){
			echo "<body class=\"bg-black\">";

				echo "<div class=\"form-box\" id=\"login-box\">";
					echo "<div class=\"header\">Sign In</div>";
					echo "<form action=\"./\" method=\"post\">";
						echo "<div class=\"body bg-gray\">";
								echo "<div class=\"form-group\">";
									echo "<input type=\"text\" name=\"username\" class=\"form-control\" placeholder=\"User ID\"/>";
								echo "</div>";
								echo "<div class=\"form-group\">";
									echo "<input type=\"password\" name=\"password\" class=\"form-control\" placeholder=\"Password\"/>";
								echo "</div>";
								
							
						echo "</div>";
						echo "<div class=\"footer\">";   
							//echo "<button type=\"submit\" class=\"btn bg-olive btn-block\">Sign me in</button>";
							echo "<input class=\"btn bg-olive btn-block\" type=\"submit\" name=\"btnLogin\" value=\"Login\" />";
							//echo "<p><a href=\"#\">I forgot my password</a></p>";
							
							//echo "<a href=\"register.html\" class=\"text-center\">Register a new membership</a>";
						echo "</div>";
					echo "</form>";
							//echo "<input  class=\"btn bg-olive btn-block\" type=\"submit\" name=\"btnLogin\" value=\"Login\" />";
					
				echo "</div>";
			echo "</body>";
		}
		function menuLoggedInNormalUser(){
			//sidebar
			echo "<nav class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">";
			//<!-- Brand and toggle get grouped for better mobile display -->
				echo "<div class=\"navbar-header\">";
					echo "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-ex1-collapse\">";
					echo "<span class=\"sr-only\">Toggle navigation</span>";
					echo "<span class=\"icon-bar\"></span>";
					echo "<span class=\"icon-bar\"></span>";
					echo "<span class=\"icon-bar\"></span>";
					echo "</button>";
					echo "<a class=\"navbar-brand\" href=\"index.php\">NebulaChoma</a>";
				echo "</div>";
				
			//<!-- Collect the nav links, forms, and other content for toggling -->
				echo "<div class=\"collapse navbar-collapse navbar-ex1-collapse\">";
					echo "<ul class=\"nav navbar-nav side-nav\">";
					$currentFolderID = $_SESSION['userID'];
					$folderUpperDirectory = "none";
					$userID = $_SESSION['userID'];
					$_SESSION['currentPath'] = $currentPath = "uploads/$userID/";
						echo "<li class=\"active\"><a href=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=1\">My Drive</a></li>";
						echo "<li class=\"active\"><a href=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=2\">Shared Files</a></li>";
						echo "<li class=\"active\"><a href=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=3\">Public Files</a></li>";
						echo "<li class=\"active\"><a href=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=3\">Trash Bin</a></li>";
						
					echo "</ul>";
					
					echo "<ul class=\"nav navbar-nav navbar-right navbar-user\">";
						
						echo "<li class=\"dropdown user-dropdown\">";
							echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".$_SESSION['userName']."<b class=\"caret\"></b></a>";
							echo "<ul class=\"dropdown-menu\">";
								echo "<li><a href=\"#\"><i class=\"fa fa-user\"></i> Profile</a></li>";
								echo "<li><a href=\"#\"><i class=\"fa fa-envelope\"></i> Inbox <span class=\"badge\">7</span></a></li>";
								echo "<li><a href=\"#\"><i class=\"fa fa-gear\"></i> Settings</a></li>";
								echo "<li class=\"divider\"></li>";
								echo "<form method=\"POST\" action=\"index.php\" >";
									echo "<i class=\"fa fa-power-off\"></i><input id=\"logout\" type=\"submit\" name=\"bnt_logout\" value=\"Logout\" />";
									echo "</form>";
								echo "</a></li>";
								echo "<li><a href=\"logout.php\"><i class=\"fa fa-power-off\"></i> Log Out</a></li>";
							echo "</ul>";
						echo "</li>";
					echo "</ul>";

			echo "</nav>";
			
		}
		function menuLoggedInAdminUser(){
			
			
			
			echo "<div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">";
				echo "<ul class=\"nav navbar-nav navbar-right\">";
					echo "<li class=\"active\"><a href=\"#\">".$_SESSION['userName']."</a></li>";
					echo "<li class=\"dropdown\">";
						echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></a>";
						echo "<ul class=\"dropdown-menu\">";
							echo "<li><a href=\"#\">Activity Log</a></li>";
							echo "<li><a href=\"#\">Settings</a></li>";
							echo "<li><a href=\"#\">Admin Page</a></li>";
							echo "<li class=\"divider\"></li>";
							echo "<li><a href=\"#\" align=\"center\">";
							echo "<form method=\"POST\" action=\"index.php\" >";
								echo "<input type=\"submit\" name=\"bnt_logout\" value=\"Logout\" />";
								echo "</form>";
							echo "</a></li>";
						echo "</ul>";
					echo "</li>";
				echo "</ul>";
			echo "</div>";
			
			
			
			
		}
		//used to be menuLoggedout
		function bodyLoggedout(){
			echo "<div class=\"container\">";
			echo "<!-- Startup Template - START -->";
			echo "<div id=\"colordiv\">";
			    echo "<header class=\"navbar navbar-inverse bs-docs-nav\" role=\"banner\">";
			        echo "<div class=\"container \">";
			            echo "<div class=\"navbar-header\">";
			                echo "<button class=\"navbar-toggle\" type=\"button\" data-toggle=\"collapse\" data-target=\".bs-navbar-collapse\">";
			                    echo "<span class=\"sr-only\">Toggle navigation</span>";
			                    echo "<span class=\"icon-bar\"></span>";
			                    echo "<span class=\"icon-bar\"></span>";
			                    echo "<span class=\"icon-bar\"></span>";
			                echo "</button>";
			                echo "<a href=\"#\" class=\"navbar-brand scroll-link\" data-id=\"carousel1\"\>Nebula Choma</a>";
			            echo "</div>";
			            echo "<nav class=\"collapse navbar-collapse bs-navbar-collapse pull-right\" role=\"navigation\">";
			                echo "<ul class=\"nav navbar-nav\">";
			                    echo "<li><a href=\"#\" class=\"scroll-link\" data-id=\"signup\">Sign Up</a></li>";
			                    echo "<li><a href=\"#\" class=\"scroll-link\" data-id=\"login\">Log In</a></li>";
			                    echo "<li><a href=\"#\" class=\"scroll-link\" data-id=\"application\">Application Process</a></li>";
			                    echo "<li><a href=\"#\" class=\"scroll-link\" data-id=\"pricing\">Pricing</a></li>";
			                    echo "<li><a href=\"#\" class=\"scroll-link\" data-id=\"location\">Location</a></li>";
			                    echo "<li><a href=\"#\" class=\"scroll-link\" data-id=\"comments\">Comments</a></li>";
			                echo "</ul>";
			            echo "</nav>";
			        echo "</div>";
			    echo "</header>";
			    echo "<!--Carousel-->";
			    echo "<div id=\"carousel1\" class=\"carousel slide\" data-ride=\"carousel\">";
			        echo "<!-- Indicators -->";
			        echo "<ol class=\"carousel-indicators\">";
			            echo "<li data-target=\"#carousel1\" data-slide-to=\"0\" class=\"active\"></li>";
			            echo "<li data-target=\"#carousel1\" data-slide-to=\"1\"></li>";
			            echo "<li data-target=\"#carousel1\" data-slide-to=\"2\"></li>";
			            echo "<li data-target=\"#carousel1\" data-slide-to=\"3\"></li>";
			            echo "<li data-target=\"#carousel1\" data-slide-to=\"4\"></li>";
			            echo "<li data-target=\"#carousel1\" data-slide-to=\"5\"></li>";
			            echo "<li data-target=\"#carousel1\" data-slide-to=\"6\"></li>";
			
			        echo "</ol>";
			        echo "<div class=\"carousel-inner\">";
			            echo "<div class=\"item active\">";
			                echo "<div class=\"container\">";
			                    echo "<div class=\"carousel-caption\">";
			                        echo "<h1>Welcome to Nebula Choma!</h1>";
			                        echo "<p>A cloud storage made for Comclark Network and Technologies Corp.</p>";
			                    echo "</div>";
			                echo "</div>";
			            echo "</div>";
			            echo "<div class=\"item\">";
			                echo "<div class=\"container\">";
			                    echo "<div class=\"carousel-caption\">";
			                        echo "<h1>Sign Up</h1>";
			                        echo "<p>Use this section to sign up for our newsletter</p>";
			                        echo "<p><a href=\"#\" class=\"btn btn-lg btn-primary scroll-link\" data-id=\"signup\" role=\"button\">Sign Up</a></p>";
			                    echo "</div>";
			                echo "</div>";
			            echo "</div>";
			            echo "<div class=\"item\">";
			                echo "<div class=\"container\">";
			                    echo "<div class=\"carousel-caption\">";
			                        echo "<h1>Login</h1>";
			                        echo "<p>Login</p>";
			                        echo "<p><a href=\"#\" class=\"btn btn-lg btn-primary scroll-link\" data-id=\"login\" role=\"button\">Company</a></p>";
			                   echo "</div>";
			                echo "</div>";
			            echo "</div>";
			            echo "<div class=\"item\">";
			                echo "<div class=\"container\">";
			                    echo "<div class=\"carousel-caption\">";
			                        echo "<h1>Application</h1>";
			                        echo "<p>See how the application process works</p>";
			                        echo "<p><a href=\"#\" class=\"btn btn-lg btn-primary scroll-link\" data-id=\"application\" role=\"button\">Apply now!</a></p>";
			                    echo "</div>";
			                echo "</div>";
			            echo "</div>";
			            echo "<div class=\"item\"\>";
			               echo " <div class=\"container\">";
			                    echo "<div class=\"carousel-caption\">";
			                        echo "<h1>Pricing</h1>";
			                        echo "<p>See additional information on our pricing model</p>";
			                        echo "<p><a href=\"#\" class=\"btn btn-lg btn-primary scroll-link\" data-id=\"pricing\" role=\"button\">Prices</a></p>";
			                    echo "</div>";
			                echo "</div>";
			            echo "</div>";
			            echo "<div class=\"item\">";
			                echo "<div class=\"container\">";
			                    echo "<div class=\"carousel-caption\">";
			                        echo "<h1>Location</h1>";
			                        echo "<p>See where our office is located</p>";
			                        echo "<p><a href=\"#\" class=\"btn btn-lg btn-primary scroll-link\" data-id=\"location\" role=\"button\">Location</a></p>";
			                    echo "</div>";
			               echo " </div>";
			            echo "</div>";
			            echo "<div class=\"item\">";
			                echo "<div class=\"container\">";
			                    echo "<div class=\"carousel-caption\">";
			                        echo "<h1>Comments</h1>";
			                        echo "<p>Leave a comment. We will get back to you shortly!</p>";
			                        echo "<p><a href=\"#\" class=\"btn btn-lg btn-primary scroll-link\" data-id=\"comments\" role=\"button\">Comment</a></p>";
			                    echo "</div>";
			                echo "</div>";
			            echo "</div>";
			        echo "</div>";
				//end of carousel container
			        echo "<a class=\"left carousel-control\" href=\"#carousel1\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>";
			        echo "<a class=\"right carousel-control\" href=\"#carousel1\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
			    echo "</div>";
				
			    //echo "<!-- /.carousel -->";
			    echo "<div class=\"container\">";
			        echo "<div id=\"signup\" class=\"page-section\">";
			            echo "<div class=\"row\">";
			                echo "<div class=\"col-lg-12 text-center v-center\">";
			                    echo "<h1 class=\"customheader\">Sign Up</h1>";
			                    echo "<h3>Enter your email to sign-up for our newsletter</h3>";
			                    echo "<br>";
			                    echo "<br>";
			                    echo "<br>";

								echo "<div class=\"input-group\" style=\"width: 340px; text-align: center; margin: 0 auto;\">";
									echo "<form class=\"col-lg-12\" method=\"POST\" action=\"" . $_SERVER['PHP_SELF'] . "\">";
	
										//echo "<div class=\"input-group\" style=\"width: 340px; text-align: center; margin: 0 auto;\">";
					
										echo "<input class=\"form-control input-lg\" placeholder=\"Enter your employee number\" input type=\"text\" name=\"studentID\" />";
										echo "<input class=\"form-control input-lg\" placeholder=\"Enter your username\" input type=\"text\" name=\"userName\" />";
										echo "<input class=\"form-control input-lg\" placeholder=\"Enter your password\" input type=\"password\" name=\"userPassword\" />";
										echo "<input class=\"form-control input-lg\" placeholder=\"Retype your password\" input type=\"text\" name=\"userPasswordReType\" />";
										echo "<input class=\"form-control input-lg\" placeholder=\"Enter your first name\" input type=\"text\" name=\"userFirstName\" />";
										echo "<input class=\"form-control input-lg\" placeholder=\"Enter your last name\" input type=\"text\" name=\"userLastName\" />";
										echo "<input  class=\"btn btn-lg btn-primary\" type=\"submit\" name=\"btnSignup\" value=\"Sign Up\" />";
							//type=\"submit\" name=\"btnSignup\" value=\"Sign Up\"
							//echo "<input class=\"form-control input-lg\" input type=\"submit\" name=\"btnSignup\" />";
											//echo "<span class=\"input-group-btn\">";
												//echo "<button class=\"btn btn-lg btn-primary\" type=\"submit\" name=\"btnSignup\">OK</button></span>";
										//echo "</div>";
									echo "</form>";
								echo "</div>";
			                echo "</div>";
			            echo "</div>";
			            echo "<br>";
			            echo "<br>";
			            echo "<br>";
			            echo "<br>";
			            echo "<br>";
			            echo "<br>";
			            echo "<br>";
			            echo "<br>";
			            echo "<br>";
			            echo "<div class=\"text-center\">";
			                echo "<h1>Follow us</h1>";
			            echo "</div>";
			            echo "<div class=\"row\">";
			                echo "<div class=\"col-lg-12 text-center v-center\" style=\"font-size: 39pt;\">";
			                    echo "<a href=\"#\"><span class=\"avatar\"><i class=\"fa fa-google-plus\"></i></span></a>";
			                    echo "<a href=\"#\"><span class=\"avatar\"><i class=\"fa fa-linkedin\"></i></span></a>";
			                    echo "<a href=\"#\"><span class=\"avatar\"><i class=\"fa fa-facebook\"></i></span></a>";
			                    echo "<a href=\"#\"><span class=\"avatar\"><i class=\"fa fa-github\"></i></span></a>";
			                echo "</div>";
			            echo "</div>";
			        echo "</div>";
			        echo "<!--/#signup-->";
			       
			
			        echo "<div id=\"login\" class=\"row\">";
			            echo "<h1 class=\"text-center customheader\">Login</h1>";
			
			            echo "<div class=\"col-md-4\">";
			               /* echo "<div class=\"panel panel-primary\">";
			                    echo "<div class=\"panel-heading\">";
			                        echo "<h4 class=\"text-center\">Mission</h4>";
			                    echo "</div>";
			                    echo "<div style=\"margin: 10px;\">";
			                        echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit."; 
			                    echo "Nam iaculis, neque ac tincidunt mollis, leo eros scelerisque lorem, vel eleifend elit tellus eu turpis."; 
			                    echo "Vestibulum a iaculis elit. Proin congue, nulla vitae malesuada ullamcorper,"; 
			                    echo "purus augue dictum ipsum, et tempus enim libero eget augue."; 
			                    echo "Nullam ac ultrices mi, condimentum interdum ante."; 
			                    echo "Vivamus ut consectetur augue, sit amet fringilla felis."; 
			                    echo "Morbi malesuada diam at risus facilisis vestibulum."; 
			                    echo "Donec ipsum sapien, condimentum vitae congue eget, suscipit ac nulla."; 
			                    echo "Pellentesque vitae vulputate libero."; 
			                    echo "Sed pellentesque, velit eget mollis convallis, risus dui lacinia mi, non euismod metus risus non odio."; 
			                    echo "Quisque cursus lectus id sem vehicula, consectetur faucibus eros congue."; 
			                    echo "Maecenas condimentum consequat feugiat.";
			                    echo "</div>";
			                       echo "<div class=\"panel-footer text-center\">";
			                        echo "<span class=\"fa fa-crosshairs bigicon\"></span>";
			                    echo "</div>";
			                echo "</div>";*/
			            echo "</div>";
			            echo "<div class=\"col-md-4\">";
			                echo "<div class=\"panel panel-primary\">";
			                    echo "<form class=\"col-lg-12\" method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\" >";
			                        echo "<div class=\"input-group\" style=\"width: 340px; text-align: center; margin: 0 auto;\">";
			                            echo "<input class=\"form-control input-lg\" title=\"Confidential signup.\" placeholder=\"Enter your username\" name=\"username\" type=\"text\">";
										echo "<input class=\"form-control input-lg\" title=\"Confidential signup.\" placeholder=\"Enter your password\" name=\"password\" type=\"password\">";
										echo "<input  class=\"btn btn-lg btn-primary\" type=\"submit\" name=\"btnLogin\" value=\"Login\" />";
			                            //echo "<span class=\"input-group-btn\">";
											//echo "<input class=\"btn btn-lg btn-primary\" type=\"submit\" name=\"btnLogin\" value=\"Login\" />";
			                                //echo "<button class=\"btn btn-lg btn-primary\" type=\"button\" value=\"btnLogin\">Log In</button></span>";
			                        echo "</div>";
			                    echo "</form>";
			                    echo "<div class=\"panel-footer text-center\">";
			                        echo "<span class=\"fa fa-users bigicon\"></span>";
			                    echo "</div>";
			                echo "</div>";
			            echo "</div>";
			            echo "<div class=\"col-md-4\">";
			                /*echo "<div class=\"panel panel-primary\">";
			                    echo "<div class=\"panel-heading\">";
			                        echo "<h4 class=\"text-center\">Projects</h4>";
			                    echo "</div>";
			                    echo "<div style=\"margin: 10px;\">";
			                        echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit."; 
			                    echo "Nam iaculis, neque ac tincidunt mollis, leo eros scelerisque lorem, vel eleifend elit tellus eu turpis."; 
			                    echo "Vestibulum a iaculis elit. Proin congue, nulla vitae malesuada ullamcorper,"; 
			                    echo "purus augue dictum ipsum, et tempus enim libero eget augue."; 
			                    echo "Nullam ac ultrices mi, condimentum interdum ante."; 
			                    echo "Vivamus ut consectetur augue, sit amet fringilla felis."; 
			                    echo "Morbi malesuada diam at risus facilisis vestibulum."; 
			                    echo "Donec ipsum sapien, condimentum vitae congue eget, suscipit ac nulla."; 
			                    echo "Pellentesque vitae vulputate libero."; 
			                    echo "Sed pellentesque, velit eget mollis convallis, risus dui lacinia mi, non euismod metus risus non odio."; 
			                    echo "Quisque cursus lectus id sem vehicula, consectetur faucibus eros congue."; 
			                    echo "Maecenas condimentum consequat feugiat.";
			                    echo "</div>";
			                    echo "<div class=\"panel-footer text-center\">";
			                        echo "<span class=\"fa fa-tablet bigicon\"></span>";
			                    echo "</div>";
			                echo "</div>";*/
			            echo "</div>";
			        echo "</div>";
			       
			        echo "<!--/#whatwedo-->";
			
			
			        echo "<div id=\"application\" class=\"page-section\">";
			            echo "<h1 class=\"customheader text-center\">Application Process</h1>";
			            echo "<div style=\"margin-top: 100px; margin-bottom: 100px;\">";
			                echo "<div class=\"row\">";
			                    echo "<div class=\"progress\" id=\"progress1\">";
			                        echo "<div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"20\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 20%;\">";
			                        echo "</div>";
			                        echo "<span class=\"progress-type\">Overall Progress</span>";
			                        echo "<span class=\"progress-completed\">20%</span>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"row\">";
			                    echo "<div class=\"row step\">";
			                        echo "<div id=\"div1\" class=\"col-md-2\" onclick=\"javascript: resetActive(event, 0, 'step-1');\">";
			                            echo "<span class=\"fa fa-cloud-download\"></span>";
			                            echo "<div>Download</div>";
			                        echo "</div>";
			                        echo "<div class=\"col-md-2 activestep\" onclick=\"javascript: resetActive(event, 20, 'step-2');\">";
			                            echo "<span class=\"fa fa-pencil\"></span>";
			                            echo "<div>Fill out</div>";
			                       echo "</div>";
			                        echo "<div class=\"col-md-2\" onclick=\"javascript: resetActive(event, 40, 'step-3');\">";
			                            echo "<span class=\"fa fa-refresh\"></span>";
			                            echo "<div>Check</div>";
			                        echo "</div>";
			                        echo "<div class=\"col-md-2\" onclick=\"javascript: resetActive(event, 60, 'step-4');\">";
			                            echo "<span class=\"fa fa-dollar\"></span>";
			                            echo "<div>Pay Fee</div>";
			                        echo "</div>";
			                        echo "<div class=\"col-md-2\" onclick=\"javascript: resetActive(event, 80, 'step-5');\">";
			                            echo "<span class=\"fa fa-cloud-upload\"></span>";
			                            echo "<div>Submit</div>";
			                        echo "</div>";
			                        echo "<div id=\"last\" class=\"col-md-2\" onclick=\"javascript: resetActive(event, 100, 'step-6');\">";
			                            echo "<span class=\"fa fa-star\"></span>";
			                            echo "<div>Feedback</div>";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"row setup-content step hiddenStepInfo\" id=\"step-1\">";
			                    echo "<div class=\"col-xs-12\">";
			                        echo "<div class=\"col-md-12 well text-center\">";
			                            echo "<h1>STEP 1</h1>";
			                            echo "<h3 class=\"underline\">Instructions</h3>";
			                            echo "Download the application form from our repository.";
			                echo "This may require logging in.;";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"row setup-content step activeStepInfo\" id=\"step-2\">";
			                    echo "<div class=\"col-xs-12\">";
			                        echo "<div class=\"col-md-12 well text-center\">";
			                            echo "<h1>STEP 2</h1>";
			                            echo "<h3 class=\"underline\">Instructions</h3>";
			                            echo "Fill out the application."; 
			                echo "Make sure to leave no empty fields.";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"row setup-content step hiddenStepInfo\" id=\"step-3\">";
			                    echo "<div class=\"col-xs-12\">";
			                        echo "<div class=\"col-md-12 well text-center\">";
			                            echo "<h1>STEP 3</h1>";
			                            echo "<h3 class=\"underline\">Instructions</h3>";
			                            echo "Check to ensure that all data entered is valid.;"; 
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"row setup-content step hiddenStepInfo\" id=\"step-4\">";
			                    echo "<div class=\"col-xs-12\">";
			                        echo "<div class=\"col-md-12 well text-center\">";
			                            echo "<h1>STEP 4</h1>";
			                            echo "<h3 class=\"underline\">Instructions</h3>";
			                            echo "Pay the application fee."; 
			                echo "This can be done either by entering your card details, or by using Paypal.";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"row setup-content step hiddenStepInfo\" id=\"step-5\">";
			                    echo "<div class=\"col-xs-12\">";
			                        echo "<div class=\"col-md-12 well text-center\">";
			                            echo "<h1>STEP 5</h1>";
			                            echo "<h3 class=\"underline\">Instructions</h3>";
			                            echo "Upload the application."; 
			                echo "This may require a confirmation email.";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"row setup-content step hiddenStepInfo\" id=\"step-6\">";
			                    echo "<div class=\"col-xs-12\">";
			                        echo "<div class=\"col-md-12 well text-center\">";
			                            echo "<h1>STEP 6</h1>";
			                            echo "<h3 class=\"underline\">Instructions</h3>";
			                            echo "Send us feedback on the overall process."; 
			                echo"This step is not obligatory.";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			            echo "</div>";
			            echo "<!--/.container-->";
			        echo "</div>";
			        echo "<!--/#application-->";
			
			
			        echo "<div id=\"pricing\" class=\"page-section\">";
			            echo "<h1 class=\"customheader text-center\">Pricing Options</h1>";
			            echo "<div class=\"row\">";
			                echo "<div class=\"col-md-4\">";
			                    echo "<div class=\"panel panel-default\">";
			                        echo "<div class=\"panel-heading\">";
			                            echo "<h4 class=\"text-center\">Personal Package</h4>";
			                        echo "</div>";
			                        echo "<div class=\"panel-body text-center\">";
			                            echo "<p class=\"lead pull-right\">";
			                                echo "<strong>$10 / month</strong>";
			                            echo "</p>";
			                        echo "</div>";
			                        echo "<ul class=\"list-group list-group-flush text-center\">";
			                            echo "<li class=\"list-group-item\">Personal Use";
			                        echo "<span class=\"glyphicon glyphicon-ok pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Single Commercial License";
			                        echo "<span class=\"glyphicon glyphicon-remove pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Multiple site Commercial license";
			                        echo "<span class=\"glyphicon glyphicon-remove pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Technical Support";
			                        echo "<span class=\"glyphicon glyphicon-remove pull-right\"></span>";
			                            echo "</li>";
			                        echo "</ul>";
			                        echo "<div class=\"panel-footer\">";
			                            echo "<a class=\"btn btn-lg btn-block btn-default\">Purchase</a>";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"col-md-4\">";
			                    echo "<div class=\"panel panel-info\">";
			                        echo "<div class=\"panel-heading\">";
			                            echo "<h4 class=\"text-center\">Standard commercial package</h4>";
			                        echo "</div>";
			                        echo "<div class=\"panel-body text-center\">";
			                            echo "<p class=\"lead pull-right\">";
			                                echo "<strong>$27 / month</strong>";
			                            echo "</p>";
			                        echo "</div>";
			                        echo "<ul class=\"list-group list-group-flush text-center\">";
			                            echo "<li class=\"list-group-item\">Personal Use";
			                        echo "<span class=\"glyphicon glyphicon-ok pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Single Commercial License";
			                        echo "<span class=\"glyphicon glyphicon-ok pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Multiple site Commercial license";
			                        echo "<span class=\"glyphicon glyphicon-remove pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Technical Support";
			                        echo "<span class=\"glyphicon glyphicon-ok pull-right\"></span>";
			                            echo "</li>";
			                        echo "</ul>";
			                        echo "<div class=\"panel-footer\">";
			                            echo "<a class=\"btn btn-lg btn-block btn-info\">Purchase</a>";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			                echo "<div class=\"col-md-4\">";
			                    echo "<div class=\"panel panel-primary\">";
			                        echo "<div class=\"panel-heading\">";
			                            echo "<h4 class=\"text-center\">Premium commercial package</h4>";
			                        echo "</div>";
			                        echo "<div class=\"panel-body text-center\">";
			                            echo "<p class=\"lead pull-right\">";
			                                echo "<strong>$59 / month</strong>";
			                            echo "</p>";
			                        echo "</div>";
			                        echo "<ul class=\"list-group list-group-flush text-center\">";
			                            echo "<li class=\"list-group-item\">Personal Use";
			                        echo "<span class=\"glyphicon glyphicon-ok pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Single Commercial License";
			                        echo "<span class=\"glyphicon glyphicon-ok pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Multiple site Commercial license";
			                        echo "<span class=\"glyphicon glyphicon-ok pull-right\"></span>";
			                            echo "</li>";
			                            echo "<li class=\"list-group-item\">Technical Support";
			                        echo "<span class=\"glyphicon glyphicon-ok pull-right\"></span>";
			                            echo "</li>";
			                        echo "</ul>";
			                        echo "<div class=\"panel-footer\">";
			                            echo "<a class=\"btn btn-lg btn-block btn-primary\">Purchase</a>";
			                        echo "</div>";
			                    echo "</div>";
			                echo "</div>";
			            echo "</div>";
			        echo "</div>";
			
			       
			
			        echo "<div id=\"location\">";
			            echo "<h1 class=\"customheader text-center\">Office Location</h1>";
			            echo "<div class=\"text-center\">";
			                echo "<div>1111 Army Navy Drive</div>";
			                echo "<div>Arlington</div>";
			                echo "<div>VA 22203</div>";
			                echo "<div>USA</div>";
			            echo "</div>";
			            echo "<div class=\"page-section\">";
			                echo "<div class=\"row\">";
			                    echo "<div id=\"map-container\"></div>";
			                echo "</div>";
			            echo "</div>";
			        echo "</div>";
			
			     
			        echo "<div class=\"container\" id=\"comments\">";
			            echo "<h1 class=\"customheader text-center\">Submit Comments</h1>";
			            echo "<div class=\"row\">";
			                echo "<form role=\"form\">";
			                    echo "<div>";
			                        echo "<div class=\"well well-sm\"><strong><span class=\"glyphicon glyphicon-asterisk\"></span>Required Field</strong></div>";
			                        echo "<div class=\"form-group\">";
			                            echo "<label for=\"InputName\">Enter Name</label>";
			                            echo "<div class=\"input-group\">";
			                                echo "<input type=\"text\" class=\"form-control\" name=\"InputName\" id=\"InputName\" placeholder=\"Enter Name\" required>";
			                                echo "<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-asterisk\"></span></span>";
			                            echo "</div>";
			                        echo "</div>";
			                        echo "<div class=\"form-group\">";
			                            echo "<label for=\"InputEmail\">Enter Email</label>";
			                            echo "<div class=\"input-group\">";
			                                echo "<input type=\"email\" class=\"form-control\" id=\"InputEmailFirst\" name=\"InputEmail\" placeholder=\"Enter Email\" required>";
			                                echo "<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-asterisk\"></span></span>";
			                            echo "</div>";
			                        echo "</div>";
			                        echo "<div class=\"form-group\">";
			                            echo "<label for=\"InputEmail\">Confirm Email</label>";
			                            echo "<div class=\"input-group\">";
			                                echo "<input type=\"email\" class=\"form-control\" id=\"InputEmailSecond\" name=\"InputEmail\" placeholder=\"Confirm Email\" required>";
			                                echo "<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-asterisk\"></span></span>";
			                            echo "</div>";
			                        echo "</div>";
			                        echo "<div class=\"form-group\">";
			                            echo "<label for=\"InputMessage\">Enter Message</label>";
			                            echo "<div class=\"input-group\">";
			                                echo "<textarea name=\"InputMessage\" id=\"InputMessage\" class=\"form-control\" rows=\"5\" required></textarea>";
			                                echo "<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-asterisk\"></span></span>";
			                            echo "</div>";
			                        echo "</div>";
			                        echo "<input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Submit\" class=\"btn btn-info pull-right\">";
			                    echo "</div>";
			                echo "</form>";
			            echo "</div>";
			        echo "</div>";

			       
			    echo "</div>";
			    echo "<br />";
			    echo "<br />";
			echo "</div>";
			
			
		}
		function bodyLoggedin(){
			$userID = $_SESSION['userID'];
			$userName = $_SESSION['userName'];
			
			if(!isset($_GET['tab']) or !isset($_GET['currentFolderID']) or !isset($_GET['folderUpperDirectory']) or !isset($_GET['currentPath'])){
				$tab = 0;
				$currentFolderID = $_SESSION['userID'];
				$folderUpperDirectory = "none";
				$currentPath = "uploads/" . $_SESSION['userID'];
			}else{
				$tab = $_GET['tab'];
				$currentFolderID = $_GET['currentFolderID'];
				$folderUpperDirectory = $_GET['folderUpperDirectory'];
				$currentPath = $_GET['currentPath'];
			}
			
			echo "<body class=\"skin-blue\">";
				//<!-- header logo: style can be found in header.less -->
				echo "<header class=\"header\">";
					echo "<a href=\"./\" class=\"logo\">";
						//<!-- Add the class icon to your logo image or logo icon to add the margining -->
						echo "Nebula Choma";
					echo "</a>";
					//<!-- Header Navbar: style can be found in header.less -->
					echo "<nav class=\"navbar navbar-static-top\" role=\"navigation\">";
						//<!-- Sidebar toggle button-->
						echo "<a href=\"#\" class=\"navbar-btn sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">";
							echo "<span class=\"sr-only\">Toggle navigation</span>";
							echo "<span class=\"icon-bar\"></span>";
							echo "<span class=\"icon-bar\"></span>";
							echo "<span class=\"icon-bar\"></span>";
						echo "</a>";
						echo "<div class=\"navbar-right\">";
							echo "<ul class=\"nav navbar-nav\">";
								//<!-- Messages: style can be found in dropdown.less-->
								/*echo "<li class=\"dropdown messages-menu\">";
									echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
										echo "<i class=\"fa fa-envelope\"></i>";
										echo "<span class=\"label label-success\">4</span>";
									echo "</a>";
									//below are the messages
									echo "<ul class=\"dropdown-menu\">";
										//echo "<li class=\"header\">You have 4 messages</li>";
										echo "<li>";
											//<!-- inner menu: contains the actual data -->
											echo "<ul class=\"menu\">";
												echo "<li>";//<!-- start message -->
													echo "<a href=\"#\">";
														echo "<div class=\"pull-left\">";
															echo "<img src=\"img/avatar3.png\" class=\"img-circle\" alt=\"User Image\"/>";
														echo "</div>";
														echo "<h4>";
															echo "Support Team";
															echo "<small><i class=\"fa fa-clock-o\"></i> 5 mins</small>";
														echo "</h4>";
														echo "<p>Why not buy a new awesome theme?</p>";
													echo "</a>";
												echo "</li>";//<!-- end message -->
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<div class=\"pull-left\">";
															echo "<img src=\"img/avatar2.png\" class=\"img-circle\" alt=\"user image\"/>";
														echo "</div>";
														echo "<h4>";
														echo "	AdminLTE Design Team";
															echo "<small><i class=\"fa fa-clock-o\"></i> 2 hours</small>";
														echo "</h4>";
														echo "<p>Why not buy a new awesome theme?</p>";
													echo "</a>";
												echo "</li>";
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<div class=\"pull-left\">";
															echo "<img src=\"img/avatar.png\" class=\"img-circle\" alt=\"user image\"/>";
														echo "</div>";
														echo "<h4>";
															echo "Developers";
															echo "<small><i class=\"fa fa-clock-o\"></i> Today</small>";
														echo "</h4>";
														echo "<p>Why not buy a new awesome theme?</p>";
													echo "</a>";
												echo "</li>";
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<div class=\"pull-left\">";
															echo "<img src=\"img/avatar2.png\" class=\"img-circle\" alt=\"user image\"/>";
														echo "</div>";
														echo "<h4>";
															echo "Sales Department";
															echo "<small><i class=\"fa fa-clock-o\"></i> Yesterday</small>";
														echo "</h4>";
														echo "<p>Why not buy a new awesome theme?</p>";
													echo "</a>";
												echo "</li>";
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<div class=\"pull-left\">";
															echo "<img src=\"img/avatar.png\" class=\"img-circle\" alt=\"user image\"/>";
														echo "</div>";
														echo "<h4>";
															echo "Reviewers";
															echo "<small><i class=\"fa fa-clock-o\"></i> 2 days</small>";
														echo "</h4>";
														echo "<p>Why not buy a new awesome theme?</p>";
													echo "</a>";
												echo "</li>";
											echo "</ul>";
										echo "</li>";
										echo "<li class=\"footer\"><a href=\"#\">See All Messages</a></li>";
									echo "</ul>";
								echo "</li>";*/
								//<!-- Notifications: style can be found in dropdown.less -->
								/*echo "<li class=\"dropdown notifications-menu\">";
									echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
										echo "<i class=\"fa fa-warning\"></i>";
										echo "<span class=\"label label-warning\">10</span>";
									echo "</a>";
									echo "<ul class=\"dropdown-menu\">";
										echo "<li class=\"header\">You have 10 notifications</li>";
										echo "<li>";
											//<!-- inner menu: contains the actual data -->
											echo "<ul class=\"menu\">";
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<i class=\"ion ion-ios7-people info\"></i> 5 new members joined today";
													echo "</a>";
												echo "</li>";
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<i class=\"fa fa-warning danger\"></i> Very long description here that may not fit into the page and may cause design problems";
													echo "</a>";
												echo "</li>";
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<i class=\"fa fa-users warning\"></i> 5 new members joined";
													echo "</a>";
												echo "</li>";
		
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<i class=\"ion ion-ios7-cart success\"></i> 25 sales made";
													echo "</a>";
												echo "</li>";
												echo "<li>";
													echo "<a href=\"#\">";
														echo "<i class=\"ion ion-ios7-person danger\"></i> You changed your username";
													echo "</a>";
												echo "</li>";
											echo "</ul>";
										echo "</li>";
										echo "<li class=\"footer\"><a href=\"#\">View all</a></li>";
									echo "</ul>";
								echo "</li>";*/
								//<!-- Tasks: style can be found in dropdown.less -->
								/*echo "<li class=\"dropdown tasks-menu\">";
									echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
										echo "<i class=\"fa fa-tasks\"></i>";
										echo "<span class=\"label label-danger\">9</span>";
									echo "</a>";
									echo "<ul class=\"dropdown-menu\">";
										echo "<li class=\"header\">You have 9 tasks</li>";
										echo "<li>";
											//<!-- inner menu: contains the actual data -->
											echo "<ul class=\"menu\">";
												echo "<li>";//<!-- Task item -->
													echo "<a href=\"#\">";
														echo "<h3>";
															echo "Design some buttons";
															echo "<small class=\"pull-right\">20%</small>";
														echo "</h3>";
														echo "<div class=\"progress xs\">";
															echo "<div class=\"progress-bar progress-bar-aqua\" style=\"width: 20%\" role=\"progressbar\" aria-valuenow=\"20\" aria-valuemin=\"0\" aria-valuemax=\"100\">";
																echo "<span class=\"sr-only\">20% Complete</span>";
															echo "</div>";
														echo "</div>";
													echo "</a>";
												echo "</li>";//<!-- end task item -->
												//<!-- Task item -->
													echo "<a href=\"#\">";
														echo "<h3>";
															echo "Create a nice theme";
															echo "<small class=\"pull-right\">40%</small>";
														echo "</h3>";
														echo "<div class=\"progress xs\">";
															echo "<div class=\"progress-bar progress-bar-green\" style=\"width: 40%\" role=\"progressbar\" aria-valuenow=\"20\" aria-valuemin=\"0\" aria-valuemax=\"100\">";
																echo "<span class=\"sr-only\">40% Complete</span>";
															echo "</div>";
														echo "</div>";
													echo "</a>";
												echo "</li>";//<!-- end task item -->
												echo "<li>";//<!-- Task item -->
													echo "<a href=\"#\">";
														echo "<h3>";
															echo "Some task I need to do";
															echo "<small class=\"pull-right\">60%</small>";
														echo "</h3>";
														echo "<div class=\"progress xs\">";
															echo "<div class=\"progress-bar progress-bar-red\" style=\"width: 60%\" role=\"progressbar\" aria-valuenow=\"20\" aria-valuemin=\"0\" aria-valuemax=\"100\">";
																echo "<span class=\"sr-only\">60% Complete</span>";
															echo "</div>";
														echo "</div>";
													echo "</a>";
												echo "</li>";//<!-- end task item -->
												echo "<li>";//<!-- Task item -->
													echo "<a href=\"#\">";
														echo "<h3>";
															echo "Make beautiful transitions";
															echo "<small class=\"pull-right\">80%</small>";
														echo "</h3>";
														echo "<div class=\"progress xs\">";
															echo "<div class=\"progress-bar progress-bar-yellow\" style=\"width: 80%\" role=\"progressbar\" aria-valuenow=\"20\" aria-valuemin=\"0\" aria-valuemax=\"100\">";
																echo "<span class=\"sr-only\">80% Complete</span>";
															echo "</div>";
														echo "</div>";
													echo "</a>";
												echo "</li>";//<!-- end task item -->
											echo "</ul>";
										echo "</li>";
										echo "<li class=\"footer\">";
											echo "<a href=\"#\">View all tasks</a>";
										echo "</li>";
									echo "</ul>";
								echo "</li>";*/
								//<!-- User Account: style can be found in dropdown.less -->
								echo "<li class=\"dropdown user user-menu\">";
									echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
										echo "<i class=\"glyphicon glyphicon-user\"></i>";
										echo "<span> " . $userName.  "<i class=\"caret\"></i></span>";
									echo "</a>";
									echo "<ul class=\"dropdown-menu\">";
										//<!-- User image -->
										/*echo "<li class=\"user-header bg-light-blue\">";
											echo "<img src=\"img/avatar3.png\" class=\"img-circle\" alt=\"User Image\" />";
											echo "<p>";
												echo "Jane Doe - Web Developer";
												echo "<small>Member since Nov. 2012</small>";
											echo "</p>";
										echo "</li>";*/
										//<!-- Menu Body -->
										parent::functionDBConnect();
										if(mysqli_connect_errno()) {
											die("MySQL connection failed: ". mysqli_connect_error());
										}else{
										}
										$SQLQuery = mysql_query("SELECT SUM(fileSize) FROM tblfile WHERE userID = '$userID'") or die(mysql_error());
										if(mysql_num_rows($SQLQuery)>0){
											while($row = mysql_fetch_array($SQLQuery)) {
												$_SESSION['userUsedBytes'] = $row['SUM(fileSize)'];
											}
										}
										$SQLQuery = mysql_query("SELECT * FROM tbluser WHERE userID = '$userID'") or die(mysql_error());
										if(mysql_num_rows($SQLQuery)>0){
											while($row = mysql_fetch_array($SQLQuery)) {
												$_SESSION['userStorageCapacityMax'] = $row['userStorageCapacity'];
											}
										}
										echo "<li class=\"user-body\">";
											echo "<div class=\"col-xs-12 text-center\">";
												echo "{$this->bytesConverter($_SESSION['userUsedBytes'])} of {$_SESSION['userStorageCapacityMax']} GB used";
											echo "</div>";
										echo "</li>";
										
										//<!-- Menu Footer-->
										echo "<li class=\"user-footer\">";
											echo "<div class=\"pull-left\">";
												echo "<a href=\"index.php?tab=7&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\" class=\"btn btn-default btn-flat\">Profile</a>";
											echo "</div>";
											echo "<div class=\"pull-right\">";
												//echo "<a href=\"#\" class=\"btn btn-default btn-flat\">Sign out</a>";
												echo "<form method=\"POST\" action=\"./\" >";
													echo "<input class=\"btn btn-default btn-flat\" type=\"submit\" name=\"bnt_logout\" value=\"Logout\" />";
												echo "</form>";
												//echo "<input class=\"btn btn-default btn-flat\" type=\"submit\" name=\"btn_logout\" value=\"Log out\" />";
											echo "</div>";
										echo "</li>";
									echo "</ul>";
								echo "</li>";
							echo "</ul>";
						echo "</div>";
					echo "</nav>";
				echo "</header>";
				
				echo "<div class=\"wrapper row-offcanvas row-offcanvas-left\">";
					//<!-- Left side column. contains the logo and sidebar -->
					echo "<aside class=\"left-side sidebar-offcanvas\">";
						//<!-- sidebar: style can be found in sidebar.less -->
						echo "<section class=\"sidebar\">";
							//<!-- Sidebar user panel -->
							/*echo "<div class=\"user-panel\">";
								echo "<div class=\"pull-left image\">";
									echo "<img src=\"img/avatar3.png\" class=\"img-circle\" alt=\"User Image\" />";
								echo "</div>";
								echo "<div class=\"pull-left info\">";
									echo "<p>" . $userName . "</p>";
		
									echo "<a href=\"#\"><i class=\"fa fa-circle text-success\"></i> Online</a>";
								echo "</div>";
							echo "</div>";*/
							//<!-- search form -->
							/*echo "<form action=\"#\" method=\"get\" class=\"sidebar-form\">";
								echo "<div class=\"input-group\">";
									echo "<input type=\"text\" name=\"q\" class=\"form-control\" placeholder=\"Search...\"/>";
									echo "<span class=\"input-group-btn\">";
										echo "<button type='submit' name='seach' id='search-btn' class=\"btn btn-flat\"><i class=\"fa fa-search\"></i></button>";
									echo "</span>";
								echo "</div>";
							echo "</form>";*/
							//<!-- /.search form -->
							//<!-- sidebar menu: : style can be found in sidebar.less -->
							echo "<ul class=\"sidebar-menu\" id=\"nav\">";
							
							
							
							
							
							if(!isset($_SESSION['userSharingList'])){
								if($tab == 1){
									echo "<li class=\"active\" id=\"MyDrive\">";
								}else{
									echo "<li class=\"\" id=\"MyDrive\">";
								}
									echo "<a href=\"index.php?tab=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\">";
										echo "<i class=\"fa fa-folder\"></i> <span>My Drive</span>";
									echo "</a>";
								echo "</li>";
								
								if($tab == 2){
									echo "<li class=\"active\" id=\"Incoming\">";
								}else{
									echo "<li class=\"\" id=\"Incoming\">";
								}
									echo "<a href=\"index.php?tab=2&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\">";
										echo "<i class=\"fa fa-folder\"></i> <span>Incoming</span>";
										
										parent::functionDBConnect();
										if(mysqli_connect_errno()) {
											die("MySQL connection failed: ". mysqli_connect_error());
										}
										
										$SQLQuery = mysql_query("SELECT userIncomingFile FROM tbluser WHERE userID = '$userID'") or die(mysql_error());
										if(mysql_num_rows($SQLQuery)>0){
											while($row = mysql_fetch_array($SQLQuery)) {
												$userIncomingFile = $row['userIncomingFile'];
											}
										}
										if($tab != 2 and $userIncomingFile >= 1){
											echo"<span>Widgets</span> <small class=\"badge pull-right bg-green\">new</small>";
										}elseif ($tab == 2){
											parent::functionDBConnect();
											if(mysqli_connect_errno()) {
												die("MySQL connection failed: ". mysqli_connect_error());
											}
											$SQLQuery = mysql_query("UPDATE tbluser
														SET
															userIncomingFile='0'
														WHERE userID='$userID'") or die(mysql_error());
										
											mysql_query($SQLQuery);	
										}
										
									echo "</a>";
								echo "</li>";
								
								if($tab == 3){
									echo "<li class=\"active\" id=\"Shared\">";
								}else{
									echo "<li class=\"\" id=\"Shared\">";
								}
									echo "<a href=\"index.php?tab=3&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\">";
										echo "<i class=\"fa fa-folder\"></i> <span>Shared</span>";
									echo "</a>";
								echo "</li>";
									
								if($tab == 4){
									echo "<li class=\"active\" id=\"Public\">";
								}else{
									echo "<li class=\"\" id=\"Public\">";
								}
									echo "<a href=\"index.php?tab=4&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\">";
										echo "<i class=\"fa fa-folder\"></i> <span>Public</span>";
									echo "</a>";
								echo "</li>";
								
								if($tab == 5){
									echo "<li class=\"active\" id=\"Trash\">";
								}else{
									echo "<li class=\"\" id=\"Trash\">";
								}
									echo "<a href=\"index.php?tab=5&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\">";
										echo "<i class=\"fa fa-folder\"></i> <span>Trash</span>";
									echo "</a>";
								echo "</li>";
								if($tab == 8){
									echo "<li class=\"active\" id=\"Search\">";
								}else{
									echo "<li class=\"\" id=\"TrasSearchh\">";
								}
									echo "<a href=\"index.php?tab=8&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\">";
										echo "<i class=\"fa fa-folder\"></i> <span>Search</span>";
									echo "</a>";
								echo "</li>";
								if($_SESSION['userLevel'] == 1){
									if($tab == 6){
										echo "<li class=\"active\" id=\"Admin Panel\">";
									}else{
										echo "<li class=\"\" id=\"Admin Panel\">";
									}
										echo "<a href=\"index.php?tab=6&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\">";
											echo "<i class=\"fa fa-folder\"></i> <span>Admin Panel</span>";
										echo "</a>";
									echo "</li>";
								}
							}else{
								
							}
								
								/*echo "<li>";
									echo "<a href=\"pages/widgets.html\">";
										echo "<i class=\"fa fa-th\"></i> <span>Widgets</span> <small class=\"badge pull-right bg-green\">new</small>";
									echo "</a>";
								echo "</li>";
								echo "<li class=\"treeview\">";
									echo "<a href=\"#\">";
										echo "<i class=\"fa fa-bar-chart-o\"></i>";
										echo "<span>Charts</span>";
										echo "<i class=\"fa fa-angle-left pull-right\"></i>";
									echo "</a>";
									echo "<ul class=\"treeview-menu\">";
										echo "<li><a href=\"pages/charts/morris.html\"><i class=\"fa fa-angle-double-right\"></i> Morris</a></li>";
										echo "<li><a href=\"pages/charts/flot.html\"><i class=\"fa fa-angle-double-right\"></i> Flot</a></li>";
										echo "<li><a href=\"pages/charts/inline.html\"><i class=\"fa fa-angle-double-right\"></i> Inline charts</a></li>";
									echo "</ul>";
								echo "</li>";
								echo "<li class=\"treeview\">";
									echo "<a href=\"#\">";
										echo "<i class=\"fa fa-laptop\"></i>";
										echo "<span>UI Elements</span>";
										echo "<i class=\"fa fa-angle-left pull-right\"></i>";
									echo "</a>";
									echo "<ul class=\"treeview-menu\">";
										echo "<li><a href=\"pages/UI/general.html\"><i class=\"fa fa-angle-double-right\"></i> General</a></li>";
										echo "<li><a href=\"pages/UI/icons.html\"><i class=\"fa fa-angle-double-right\"></i> Icons</a></li>";
										echo "<li><a href=\"pages/UI/buttons.html\"><i class=\"fa fa-angle-double-right\"></i> Buttons</a></li>";
										echo "<li><a href=\"pages/UI/sliders.html\"><i class=\"fa fa-angle-double-right\"></i> Sliders</a></li>";
										echo "<li><a href=\"pages/UI/timeline.html\"><i class=\"fa fa-angle-double-right\"></i> Timeline</a></li>";
									echo "</ul>";
								echo "</li>";
								echo "<li class=\"treeview\">";
									echo "<a href=\"#\">";
										echo "<i class=\"fa fa-edit\"></i> <span>Forms</span>";
										echo "<i class=\"fa fa-angle-left pull-right\"></i>";
									echo "</a>";
									echo "<ul class=\"treeview-menu\">";
										echo "<li><a href=\"pages/forms/general.html\"><i class=\"fa fa-angle-double-right\"></i> General Elements</a></li>";
										echo "<li><a href=\"pages/forms/advanced.html\"><i class=\"fa fa-angle-double-right\"></i> Advanced Elements</a></li>";
										echo "<li><a href=\"pages/forms/editors.html\"><i class=\"fa fa-angle-double-right\"></i> Editors</a></li>";
									echo "</ul>";
								echo "</li>";
								echo "<li class=\"treeview\">";
									echo "<a href=\"#\">";
										echo "<i class=\"fa fa-table\"></i> <span>Tables</span>";
										echo "<i class=\"fa fa-angle-left pull-right\"></i>";
									echo "</a>";
									echo "<ul class=\"treeview-menu\">";
										echo "<li><a href=\"pages/tables/simple.html\"><i class=\"fa fa-angle-double-right\"></i> Simple tables</a></li>";
										echo "<li><a href=\"pages/tables/data.html\"><i class=\"fa fa-angle-double-right\"></i> Data tables</a></li>";
									echo "</ul>";
								echo "</li>";
								echo "<li>";
									echo "<a href=\"pages/calendar.html\">";
										echo "<i class=\"fa fa-calendar\"></i> <span>Calendar</span>";
										echo "<small class=\"badge pull-right bg-red\">3</small>";
									echo "</a>";
								echo "</li>";
								echo "<li>";
									echo "<a href=\"pages/mailbox.html\">";
										echo "<i class=\"fa fa-envelope\"></i> <span>Mailbox</span>";
										echo "<small class=\"badge pull-right bg-yellow\">12</small>";
									echo "</a>";
								echo "</li>";
								echo "<li class=\"dropdown user-dropdown\">";
							echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"fa fa-user\"></i> ".$_SESSION['userName']."<b class=\"caret\"></b></a>";
							echo "<ul class=\"dropdown-menu\">";
								echo "<li><a href=\"#\"><i class=\"fa fa-user\"></i> Profile</a></li>";
								echo "<li><a href=\"#\"><i class=\"fa fa-envelope\"></i> Inbox <span class=\"badge\">7</span></a></li>";
								echo "<li><a href=\"#\"><i class=\"fa fa-gear\"></i> Settings</a></li>";
								echo "<li class=\"divider\"></li>";
								echo "<form method=\"POST\" action=\"index.php\" >";
									echo "<i class=\"fa fa-power-off\"></i><input id=\"logout\" type=\"submit\" name=\"bnt_logout\" value=\"Logout\" />";
									echo "</form>";
								echo "</a></li>";
								echo "<li><a href=\"logout.php\"><i class=\"fa fa-power-off\"></i> Log Out</a></li>";
							echo "</ul>";
						echo "</li>";
								echo "<li class=\"treeview\">";
									echo "<a href=\"#\">";
										echo "<i class=\"fa fa-folder\"></i> <span>Examples</span>";
										echo "<i class=\"fa fa-angle-left pull-right\"></i>";
									echo "</a>";
									echo "<ul class=\"treeview-menu\">";
										echo "<li><a href=\"pages/examples/invoice.html\"><i class=\"fa fa-angle-double-right\"></i> Invoice</a></li>";
										echo "<li><a href=\"pages/examples/login.html\"><i class=\"fa fa-angle-double-right\"></i> Login</a></li>";
										echo "<li><a href=\"pages/examples/register.html\"><i class=\"fa fa-angle-double-right\"></i> Register</a></li>";
										echo "<li><a href=\"pages/examples/lockscreen.html\"><i class=\"fa fa-angle-double-right\"></i> Lockscreen</a></li>";
										echo "<li><a href=\"pages/examples/404.html\"><i class=\"fa fa-angle-double-right\"></i> 404 Error</a></li>";
										echo "<li><a href=\"pages/examples/500.html\"><i class=\"fa fa-angle-double-right\"></i> 500 Error</a></li>";
										echo "<li><a href=\"pages/examples/blank.html\"><i class=\"fa fa-angle-double-right\"></i> Blank Page</a></li>";
									echo "</ul>";
								echo "</li>";
							echo "</ul>";*/
						echo "</section>";
						//<!-- /.sidebar -->
					echo "</aside>";
		
					//<!-- Right side column. Contains the navbar and content of the page -->
					echo "<aside class=\"right-side\">";
						//<!-- Content Header (Page header) -->
						if($tab == 1){
							echo "<section class=\"content-header\">";
								echo "<h1>";
									echo "My Drive";
								echo "</h1>";
								echo "<ol class=\"breadcrumb\">";
									$this->functionBreadCrumbs($currentPath,$userID,$tab,$folderUpperDirectory,$currentFolderID);
									
								echo "</ol>";
							echo "</section>";
						}elseif($tab == 2){
							echo "<section class=\"content-header\">";
								echo "<h1>";
									echo "Incoming";
								echo "</h1>";
							echo "</section>";
						}elseif($tab == 3){
							echo "<section class=\"content-header\">";
								echo "<h1>";
									echo "Shared";
								echo "</h1>";
							echo "</section>";
						}elseif($tab == 4){
							echo "<section class=\"content-header\">";
								echo "<h1>";
									echo "Public";
								echo "</h1>";
							echo "</section>";
						}elseif($tab == 5){
							echo "<section class=\"content-header\">";
								echo "<h1>";
									echo "Trash";
								echo "</h1>";
							echo "</section>";
						}elseif($tab == 8){
							echo "<section class=\"content-header\">";
								echo "<h1>";
									echo "Search";
								echo "</h1>";
							echo "</section>";
						}elseif($tab == 6){
							echo "<section class=\"content-header\">";
								echo "<h1>";
									echo "Admin Panel";
								echo "</h1>";
							echo "</section>";
						}else{
							
						}
						
		
						//<!-- Main content -->
						//
						
						echo "<section class=\"content\" id=\"\">";
							//<!-- Small boxes (Stat box) -->
							echo "<div class=\"row\">";
								echo "<form action=\"index.php?tab=$tab&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\" method=\"post\" enctype=\"multipart/form-data\">";
									if(!isset($_SESSION['userSharingList'])){
										if($tab >= 1 and $tab <=5){
											$this->bodyMyDrive($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
										}elseif($tab == 8){
											$this->bodyMyDrive($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
										}elseif($tab == 6){
											if(isset($_SESSION['editUserPage'])){
												$this->bodyEditUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
											}elseif(isset($_SESSION['addUserPage'])){
												$this->bodyAddUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
											}else{
												$this->adminPanel($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
											}
										}elseif($tab == 7){
											$this->bodyEditUserProfile($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
										}else{
										}
									}else{
										if($tab >= 1 and $tab <=5){
											$this->userSharingList($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
										}elseif($tab == 8){
											$this->bodyMyDrive($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
										}elseif($tab == 6){
											if(isset($_SESSION['editUserPage'])){
												$this->bodyEditUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
											}elseif(isset($_SESSION['addUserPage'])){
												$this->bodyAddUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
											}else{
												$this->adminPanel($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
											}
										}elseif($tab == 7){
											$this->bodyEditUserProfile($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
										}else{
										}
									}
									
								echo "</form>";
							echo "</div>";
							
						echo "</section>";//<!-- /.content -->
					echo "</aside>";//<!-- /.right-side -->
				echo "</div>";//<!-- ./wrapper -->
		
			echo "</body>";
		}
		function functionBreadCrumbs($currentPath, $userID, $tab, $folderUpperDirectory, $currentFolderID){
			
			/*
			$count = strlen($currentPath);
			
			$arrayx = array();
			
			$varx = "";
			
			$z = 0;
			
			for($x=0; $x<=$count; $x++){
				$y = 1;
				$var = substr($currentPath, $x, $y);
				
				if($var != "/"){
					$varx .=  $var;
				}
				
				if ($x == $count){
					array_push($arrayx, $varx);
					$varx = "";
				}
			}
			echo $arrlen = count($arrayx);
			
			for($arr = 0; $arr <= $arrlen; $arrlen++){
				echo $arrayx[$arr] . "<br>";
			}
			*/
			$arrayBreadCrumbCheckVar = 0;
			$arrayBreadCrumb = array();
			$arrayBreadCrumbCurrentPath = array();
			$varTempWord = "";
			
			$str = $currentPath;
			$strlen = strlen( $str );
			for( $i = 0; $i <= $strlen; $i++ ) {
				$char = substr( $str, $i, 1 );
				// $char contains the current character, so do your processing here
				//echo "<br>" . $char . "<br>";
				
				if($char != "/"){
					$varTempWord .= $char;
				}else{
					
					foreach($arrayBreadCrumb as $breadCrumb){
						if($varTempWord == $breadCrumb){
							$arrayBreadCrumbCheckVar = 1;
						}
					}
					
					if($arrayBreadCrumbCheckVar != 1){
						array_push($arrayBreadCrumb, $varTempWord);
						$varTempWord = "";
					}
				}
			}
			$userID = $_SESSION['userID'];
			echo "<li><a href=\"index.php?tab=1&currentFolderID=12&folderUpperDirectory=none&currentPath=uploads/12\"><i class=\"fa fa-dashboard\"></i> My Drive</a></li>";
			foreach($arrayBreadCrumb as $breadCrumb){
				$SQLQueryBreadCrumb = mysql_query("SELECT * FROM tblfolder WHERE folderID = '$breadCrumb'") or die(mysql_error());
				
				//My Drive breadcrumb
				if($breadCrumb == "uploads"){
					continue;
				}
				
				if($breadCrumb == $userID){
					continue;
				}
				
				
				if(mysql_num_rows($SQLQueryBreadCrumb)>0){
					while($row = mysql_fetch_array($SQLQueryBreadCrumb)) {
						$currentFolderID = $row['folderID'];
						$folderUpperDirectory = $row['folderUpperDirectory'];
						$currentPathx = $row['fMime'] . $currentFolderID . "/";
						//$currentPath = $_GET['currentPath'] . $row['folderID'] . '/';
						$_SESSION['currentPath'] = $_GET['currentPath'];
						$tab = $_GET['tab'];
						$currentPathx = $row['fMime'] . "/" . $row['folderID'];
						echo "<li><a href=\"index.php?tab=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPathx\">{$row['fName']}</a></li>";
					}
				}
			}
			
			
			/*
			$domain = strstr($currentPath, '/');
			echo $domain; // prints @example.com
			echo "<br>";
			$user = strstr($currentPath, '/', true); // As of PHP 5.3.0
			echo $user; // prints name
			*/
		}
		function bodyExperimentx(){
			echo "<div class=\"box\">";
				echo "<div class=\"box-header\">";
					echo "<h3 class=\"box-title\">Data Table With Full Features</h3>";
				echo "</div>";//<!-- /.box-header -->
				echo "<div class=\"box-body table-responsive\">";
					echo "<table id=\"example1\" class=\"table dataTable table-bordered table-hover table-striped\">";
						echo "<thead>";
							echo "<tr>";
								echo "<th><input type=\"checkbox\" id=\"check-all\"/></th>";
								echo "<th>File ID</th>";
								echo "<th>fName</th>";
								echo "<th>file Mime</th>";
								echo "<th>file Size</th>";
								echo "<th>Folder Data/Upper Directory</th>";
								echo "<th>Folder ID</th>";
								echo "<th>Shared</th>";
								echo "<th>Public</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						echo "<tr>";
										//<input type="checkbox" />
										//echo "<td><input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"{$row['folderID']}\">$cbid</td>";
										echo "<td><input type=\"checkbox\" /></td>";
										echo "<td>qwer</td>";
										echo "<td>adsf</td>";
										echo "<td>zcxv</td>";
										echo "<td>mhg</td>";
										echo "<td>urt</td>";
										echo "<td>fgj</td>";//kawagian
										echo "<td>tjy</td>";
										echo "<td>qwer2</td>";
										
										echo "<td>asdf</td>";
										/*if(!empty($row['fileID'])){//file
											echo "<td>qwer1</td>";
										}else{//folder
											echo "<td>qwer2</td>";
										}
										echo "<td>asdf</td>";*/
									echo "</tr>";	
							$x = mysql_num_rows($SQLQuery);
							/*if(mysql_num_rows($SQLQuery)>0){
								while($row = mysql_fetch_array($SQLQuery)) {
									$cbid = "cb1_" . $x;
									echo "<tr>";
										//<input type="checkbox" />
										//echo "<td><input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"{$row['folderID']}\">$cbid</td>";
										echo "<td><input type=\"checkbox\" /></td>";
										echo "<td>qwer</td>";
										echo "<td>adsf</td>";
										echo "<td>zcxv</td>";
										echo "<td>mhg</td>";
										echo "<td>urt</td>";
										echo "<td>fgj</td>";//kawagian
										echo "<td>tjy</td>";
										echo "<td>qwer2</td>";
										
										echo "<td>asdf</td>";
										/*if(!empty($row['fileID'])){//file
											echo "<td>qwer1</td>";
										}else{//folder
											echo "<td>qwer2</td>";
										}
										echo "<td>asdf</td>";*/
									//echo "</tr>";
									/*$_SESSION['folderID'] = $row['folderID'];
									$x -= 1;
								}
							}*/
						echo "</tbody>";
						
					echo "</table>";
				echo "</div>";//<!-- /.box-body -->
			echo "</div>";//<!-- /.box -->';
			/*echo '<div class="box-body">
				<div class="row">
					<div class="col-md-9 col-sm-8">
						
						<div class="table-responsive">
							<!-- THE MESSAGES -->
							
							<table id="example2" class="table table-bordered table-hover table-mailbox">
								<thead>
									<tr>
										<th><input type="checkbox" id="check-all"/></td>
										<th>Rendering engine</th>
										<th>Browser</th>
										<th>Platform(s)</th>
										<th>Engine version</th>
									</tr>
								</thead>
								<tbody>
									<tr class="unread">
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star"></i></td>
										<td class="name"><a href="#">as</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">January 8, 2013 3:49:00 - 4:49:00</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">dohn Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">January 8, 2013 3:51:00 - 4:51:00</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">cohn Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">March 18, 2013 14:44</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">zohn Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">May 18, 2013 16:44</td>
									</tr>
									<!--<tr class="unread">
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr class="unread">
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr class="unread">
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>-->
								</tbody>
							</table>
						</div><!-- /.table-responsive -->
					</div><!-- /.col (RIGHT) -->
				</div><!-- /.row -->
			</div><!-- /.box-body -->';*/
		}
		function bodyExperiment(){
			echo '<div class="box-body">
				<div class="row">
					<div class="col-md-9 col-sm-8">
						<div class="row pad">
							<div class="col-sm-6">
								<label style="margin-right: 10px;">
									<input type="checkbox" id="check-all"/>
								</label>
								<!-- Action button -->
								<div class="btn-group">
									<button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
										Action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">Mark as read</a></li>
										<li><a href="#">Mark as unread</a></li>
										<li class="divider"></li>
										<li><a href="#">Move to junk</a></li>
										<li class="divider"></li>
										<li><a href="#">Delete</a></li>
									</ul>
								</div>
	
							</div>
							<div class="col-sm-6 search-form">
								<form action="#" class="text-right">
									<div class="input-group">
										<input type="text" class="form-control input-sm" placeholder="Search">
										<div class="input-group-btn">
											<button type="submit" name="q" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div><!-- /.row -->
	
						<div class="table-responsive">
							<!-- THE MESSAGES -->
							
							<table id="example2" class="table table-bordered table-hover table-mailbox">
								<thead>
									<tr>
										<td><input type="checkbox" id="check-all"/></td>
										<th>Rendering engine</th>
										<th>Browser</th>
										<th>Platform(s)</th>
										<th>Engine version</th>
									</tr>
								</thead>
								<tbody>
									<tr class="unread">
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star"></i></td>
										<td class="name"><a href="#">as</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">January 8, 2013 3:49:00 - 4:49:00</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">dohn Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">January 8, 2013 3:51:00 - 4:51:00</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">cohn Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">March 18, 2013 14:44</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">zohn Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">May 18, 2013 16:44</td>
									</tr>
									<!--<tr class="unread">
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr class="unread">
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr class="unread">
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>
									<tr>
										<td class="small-col"><input type="checkbox" /></td>
										<td class="small-col"><i class="fa fa-star-o"></i></td>
										<td class="name"><a href="#">John Doe</a></td>
										<td class="subject"><a href="#">Urgent! Please read</a></td>
										<td class="time">12:30 PM</td>
									</tr>-->
								</tbody>
							</table>
						</div><!-- /.table-responsive -->
					</div><!-- /.col (RIGHT) -->
				</div><!-- /.row -->
			</div><!-- /.box-body -->';
		}
		function bodyMyDrive($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			parent::functionDBConnect();
			if(mysqli_connect_errno()) {
				die("MySQL connection failed: ". mysqli_connect_error());
			}else{
				//echo "file listing connected";
			}
			$userID = $_SESSION['userID'];
			$_SESSION['currentFolderID'] = $currentFolderID;
			$_SESSION['folderUpperDirectory'] = $folderUpperDirectory;
			$_SESSION['currentPath'] = $currentPath;
			$_SESSION['currentFolderID'] = $currentFolderID;
			if($tab == 1){
				$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND status = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' AND (status = '1' OR status = '2' OR status = '3') ORDER BY fName ASC") or die(mysql_error());
			}elseif($tab == 2){
				$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE fileID IN (SELECT fileID from tblsharedfiles where fileShareeID='$userID')") or die(mysql_error());
			}elseif($tab == 3){
				$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' AND status = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' AND status = '2' ORDER BY fName ASC") or die(mysql_error());
			}elseif($tab == 4){
				$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND public = '1' AND status = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' AND status = '3' ORDER BY fName ASC") or die(mysql_error());
			}elseif($tab == 5){
				$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND status = '0' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' AND status = '0' ORDER BY fName ASC") or die(mysql_error());
			}elseif($tab == 8){
				$SQLQuery = mysql_query("SELECT * FROM tblfile WHERE public='1'") or die(mysql_error());
			}
			echo "<div class=\"box\">";
				echo "<div class=\"row\">";
                       echo "<div class=\"col-md-2\">";
							if($tab == 1){
					   			echo "<small>Upload file</small>";
								$this->fileUpload($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
							}else{
							}
						echo "</div>";
						echo "<div class=\"col-md-2\">";
							if($tab == 1){
								echo "<small>Create folder</small>";
								$this->createFolder($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
							}else{
							}
						echo "</div>";
						echo "<div class=\"col-md-2\">";
							if($tab != 5){
							echo "<small>Download checked items</small>";
								$this->download($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
							}else{
							}
						echo "</div>";
						echo "<div class=\"col-md-2\">";
							if($tab == 5){
								echo "<small>Restore checked items</small>";
								$this->restore($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
							}elseif($tab == 2){
							}else{
								echo "<small>Delete checked items</small>";
								$this->delete($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
							}
						echo "</div>";
						echo "<div class=\"col-md-2\">";
							if($tab != 2){
								echo "<small>Share checked files (NOT FOR FOLDERS)</small>";
								$this->btnShare($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
							}else{
							}
						echo "</div>";
						echo "<div class=\"col-md-2\">";
							if($tab != 2){
								echo "<small>Publicize checked files (NOT FOR FOLDERS)</small>";
								$this->btnPublicize($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
							}else{
							}
						echo "</div>";
				echo "</div>";
				
				echo "<div class=\"box-body table-responsive\">";
					echo "<table id=\"example1\" class=\"table table-bordered table-hover table-striped table-mailbox\">";
						echo "<thead>";
							echo "<tr>";
								echo "<td><input type=\"checkbox\" id=\"check-all\"/></td>";
								echo "<th>File ID</th>";
								echo "<th>fName</th>";
								echo "<th>file Mime</th>";
								echo "<th>file Size</th>";
								echo "<th>Folder Data/Upper Directory</th>";
								echo "<th>Folder ID</th>";
								echo "<th>Shared</th>";
								echo "<th>Public</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
							$x = mysql_num_rows($SQLQuery);
							if(mysql_num_rows($SQLQuery)>0){
								while($row = mysql_fetch_array($SQLQuery)) {
									$cbid = "cb1_" . $x;
									echo "<tr>";
										if(empty($row['fileID'])){
											echo "<td>";
												//echo "<input type=\"checkbox\" class=\"cbgroup1\" name=\"check_list[]\" value=\"{$row['folderID']}\">";
												echo "<input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"{$row['folderID']}\">";
											echo "</td>";
										}else{
											echo "<td>";
												//echo "<input type=\"checkbox\" class=\"cbgroup1\" name=\"check_list[]\" value=\"{$row['fileID']}\">";
												echo "<input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"{$row['fileID']}\">";
											echo "</td>";
										}
										if(!empty($row['fileID'])){//file
											echo "<td>{$row['fileID']}</td>";
										}else{//folder
											echo "<td>{$row['folderID']}</td>";
										}
										
										if(!empty($row['fileID'])){//file
											echo "<td>{$row['fName']}</td>";
										}else{//folder
											if($tab == 5){
												echo "<td>{$row['fName']}</td>";
											}else{
												echo "<td><a href=\"index.php?tab=$tab&currentFolderID={$row['folderID']}&folderUpperDirectory=$currentFolderID&currentPath=$currentPath". "/" . $row['folderID'] . "\">{$row['fName']}</a></td>";
											}
											
										}
										echo "<td>{$row['fileMime']}</td>";
										
										if(!empty($row['fileID'])){
											echo "<td>{$this->bytesConverter($row['fileSize'])}</td>";
										}else{
											echo "<td></td>";
										}
										
										echo "<td>{$row['fileData']}</td>";//kawagian
										echo "<td>{$row['folderID']}</td>";
										if(!empty($row['fileID'])){//file
											echo "<td>{$row['shared']}</td>";
										}else{//folder
											echo "<td></td>";
										}
										echo "<td>{$row['public']}</td>";
										/*if(!empty($row['fileID'])){//file
											echo "<td>qwer1</td>";
										}else{//folder
											echo "<td>qwer2</td>";
										}
										echo "<td>asdf</td>";*/
									echo "</tr>";
									$_SESSION['folderID'] = $row['folderID'];
									$x -= 1;
								}
							}
						echo "</tbody>";
						
					echo "</table>";
				echo "</div>";//<!-- /.box-body -->
			echo "</div>";//<!-- /.box -->';
		}
		function userSharingList($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			parent::functionDBConnect();
			if(mysqli_connect_errno()) {
				die("MySQL connection failed: ". mysqli_connect_error());
			}else{
				//echo "file listing connected";
			}
			$userID = $_SESSION['userID'];
			$_SESSION['currentFolderID'] = $currentFolderID;
			$_SESSION['folderUpperDirectory'] = $folderUpperDirectory;
			$_SESSION['currentPath'] = $currentPath;
			$_SESSION['currentFolderID'] = $currentFolderID;
			
			$SQLQuery = mysql_query("SELECT * FROM tbluser WHERE userAccountStatus = '1'") or die(mysql_error());
			echo "<div class=\"box\">";
				echo "<div class=\"box-header\">";
					echo "<h3 class=\"box-title\">Data Table With Full Features</h3>";
				echo "</div>";//<!-- /.box-header -->
				echo "<div class=\"row\">";
					echo "<div class=\"col-md-2\">";
						echo "<small>Select user to share to</small>";
						$this->btnSharex($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
				echo "</div>";
				
				echo "<div class=\"box-body table-responsive\">";
					
					
					echo "<table id=\"example1\" class=\"table table-bordered table-hover table-striped table-mailbox\">";
						echo "<thead>";
							echo "<tr>";
								echo "<td><input type=\"checkbox\" id=\"check-all\"/></td>";
								echo "<th>User ID</th>";
								echo "<th>User Name</th>";
								echo "<th>First Name</th>";
								echo "<th>Last Name</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
							$x = mysql_num_rows($SQLQuery);
							if(mysql_num_rows($SQLQuery)>0){
								while($row = mysql_fetch_array($SQLQuery)) {
									$cbid = "cb1_" . $x;
									echo "<tr>";
										echo "<td>";
											//echo "<input type=\"checkbox\" class=\"cbgroup1\" name=\"check_list[]\" value=\"{$row['folderID']}\">";
											echo "<input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"{$row['userID']}\">";
										echo "</td>";
										echo "<td>{$row['userID']}</td>";
										echo "<td>{$row['userName']}</td>";
										echo "<td>{$row['userFirstName']}</td>";
										echo "<td>{$row['userLastName']}</td>";
									echo "</tr>";
									$x -= 1;
								}
							}
						echo "</tbody>";
						
					echo "</table>";
				echo "</div>";//<!-- /.box-body -->
			echo "</div>";//<!-- /.box -->';
		}
		function bytesConverter($fileSizeBytes){
			if($fileSizeBytes < 1048576){
				$fileSizeConverted = round($fileSizeBytes / 1024, 2);
				$fileSizeConverted .= " KB";
			}elseif(($fileSizeBytes >= 1048576) and ($fileSizeBytes < 1073741824)){
				$fileSizeConverted = round($fileSizeBytes / 1048576, 2);
				$fileSizeConverted .=  " MB";
			}elseif($fileSizeBytes >= 1073741824){
				$fileSizeConverted = round($fileSizeBytes / 1073741824, 2);
				$fileSizeConverted .= " GB";
			}
			return $fileSizeConverted;
		}
		function adminPanel($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			parent::functionDBConnect();
			if(mysqli_connect_errno()) {
				die("MySQL connection failed: ". mysqli_connect_error());
			}else{
				//echo "file listing connected";
			}
			$userID = $_SESSION['userID'];
			$_SESSION['currentFolderID'] = $currentFolderID;
			$_SESSION['folderUpperDirectory'] = $folderUpperDirectory;
			$_SESSION['currentPath'] = $currentPath;
			$_SESSION['currentFolderID'] = $currentFolderID;
			
			$SQLQuery = mysql_query("SELECT * FROM tbluser") or die(mysql_error());
			echo "<div class=\"box\">";
				echo "<div class=\"box-header\">";
					echo "<h3 class=\"box-title\">Admin Panel</h3>";
				echo "</div>";//<!-- /.box-header -->
				echo "<div class=\"row\">";
					echo "<div class=\"col-md-2\">";
						$this->btnAddUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
					echo "</div>";
					echo "<div class=\"col-md-2\">";
						$this->btnEditUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
					echo "<div class=\"col-md-2\">";
					echo "</div>";
				echo "</div>";
				
				echo "<div class=\"box-body table-responsive\">";
					
					
					echo "<table id=\"example1\" class=\"table table-bordered table-hover table-striped table-mailbox\">";
						echo "<thead>";
							echo "<tr>";
								echo "<td></td>";
								echo "<th>User ID</th>";
								echo "<th>User Name</th>";
								echo "<th>First Name</th>";
								echo "<th>Last Name</th>";
								echo "<th>User Level</th>";
								echo "<th>Account Status</th>";
								echo "<th>Registration Date</th>";
								echo "<th>Storage Capacity (GB)</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
							$x = mysql_num_rows($SQLQuery);
							if(mysql_num_rows($SQLQuery)>0){
								while($row = mysql_fetch_array($SQLQuery)) {
									$cbid = "cb1_" . $x;
									echo "<tr>";
										echo "<td>";
											echo "<input type=\"radio\" name=\"radioUserID\" value=\"{$row['userID']}\">";
										echo "</td>";
										echo "<td>{$row['userID']}</td>";
										echo "<td>{$row['userName']}</td>";
										echo "<td>{$row['userFirstName']}</td>";
										echo "<td>{$row['userLastName']}</td>";
										echo "<td>{$row['userLevel']}</td>";
										echo "<td>{$row['userAccountStatus']}</td>";
										echo "<td>{$row['userRegistrationDate']}</td>";
										echo "<td>{$row['userStorageCapacity']} GB</td>";
									echo "</tr>";
									$x -= 1;
								}
							}
						echo "</tbody>";
						
					echo "</table>";
				echo "</div>";//<!-- /.box-body -->
			echo "</div>";//<!-- /.box -->';
		}
		function bodyLogo(){
			echo "<div id=\"body_Left\">";
				echo "Body Logo";
			echo "</div>";
		}
		function bodySignup(){
			echo "<div id=\"body_Rigth\">";
				echo "<form method=\"POST\" action=\"" . $_SERVER['PHP_SELF'] . "\" >";
					echo "Student ID: <input type=\"text\" name=\"studentID\" />";
					echo "Username: <input type=\"text\" name=\"userName\" />";
					echo "Password: <input type=\"text\" name=\"userPassword\" />";
					echo "Re-type Password: <input type=\"text\" name=\"userPasswordReType\" />";
					echo "First Name: <input type=\"text\" name=\"userFirstName\" />";
					echo "Last Name: <input type=\"text\" name=\"userLastName\" />";
					echo "<input type=\"submit\" name=\"btnSignup\" value=\"Sign Up\" />";
				echo "</form>";
			echo "</div>";
		}
		function testBody(){
			echo "test body when logged in";
		}
		function adminPage(){
			echo "abmkss";
		}
		function fileUpload($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div id=\"fileUpload\" style=\"padding:5px;\">";
			//$currentPath = $_GET['currentPath'];
				//echo "<form id=\"formFileUpload\" action=\"index.php?tab=$tab&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\" method=\"post\" enctype=\"multipart/form-data\">"; 
							echo "<input type=\"file\" name=\"userFile[]\" style=\"opacity:;
	
	width:160px;
	cursor:pointer;\" multiple><br>";
							echo "<input type=\"submit\" value=\"Upload file\" name=\"btnUpload\" >";
						//echo "</form>";
			echo "</div>";
		}
		function createFolder($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input type=\"text\" class=\"form-control\"  name=\"fName\">";
				//echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"btnCreateFolder\" value=\"Folder\" />";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnCreateFolder\" value=\"Create Folder\" />";
			echo "</div>";
			/*echo "<div id=\"fileCreateFolder\" class=\"collapse navbar-collapse\">";
				echo "<ul class=\"nav navbar-nav navbar-center\" style=\"width:auto\">";
					echo "<li class=\"dropdown\">";
						echo "<a href=\"\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" ><b>Create Folder</b></a>";
						echo "<ul class=\"dropdown-menu\">";
							echo "<li><a>";
								//echo "<form method=\"POST\" action=\"index.php?tab=$tab&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath\" >";//btb
									echo "<div class=\"input-group margin\"><br />";
                                        echo "<div class=\"input-group-btn\">";
                                            //echo "<button type=\"submit\" class=\"btn btn-danger\">Action</button>";
									echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"btnCreateFolder\" value=\"Folder\" />";
                                        echo "</div>";//<!-- /btn-group -->
                                        echo "<input type=\"text\" class=\"form-control\"  name=\"fName\">";
                                    echo "</div>";//<!-- /input-group -->
									
									//echo "<input type=\"text\" name=\"fName\" />";
									echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"btnCreateFolder\" value=\"Folder\" />";
								//echo "</form>";
							echo "</a></li>";
						echo "</ul>";
					echo "</li>";
				echo "</ul>";
			echo "</div>";	*/
		}
		function download($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnDownloadExperiment\" value=\"Download\" />";
			echo "</div>";
		}
		function btnAddUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnAddUser\" value=\"Add User\" />";
			echo "</div>";
		}
		function btnEditUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnEdit\" value=\"Edit\" />";
			echo "</div>";
		}
		function delete($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnTrash\" value=\"Delete\" />";
			echo "</div>";
		}
		function restore($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnRestore\" value=\"Restore\" />";
			echo "</div>";
		}
		function btnShare($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnShare\" value=\"Share\" />";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnUnShare\" value=\"UnShare\" />";
			echo "</div>";
		}
		function btnSharex($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnSharex\" value=\"Share\" />";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnUnSharex\" value=\"UnShare\" />";
			echo "</div>";
		}
		function btnPublicize($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnPublicize\" value=\"Publicize\" />";
				echo "<input class=\"btn bg-aqua btn-block\" type=\"submit\" name=\"btnUnPublicize\" value=\"UnPublicize\" />";
			echo "</div>";
		}
		function fileListing(){
			
			// Connect to the database
			parent::functionDBConnect();
			if(mysqli_connect_errno()) {
				die("MySQL connection failed: ". mysqli_connect_error());
			}else{
				//echo "file listing connected";
			}
			
			
			//$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID FROM tblfile WHERE userID = '$userID' UNION SELECT userID, '' , fName, '', '', '', folderID FROM tblfolder WHERE userID = '$userID' ORDER BY fName ASC") or die(mysql_error());
			//echo '<table id="keywords" cellspacing="0" cellpadding="0">';
			//SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID FROM tblfile WHERE userID = 0
//UNION
//SELECT userID, '' , fName, '', '', '', folderID FROM tblfolder WHERE userID = 0;

			
			$userID = $_SESSION['userID'];//sets $userID for WHERE part of the proceeding queries.
			if(!isset($_GET['sortBy']) and !isset($_GET['sortType']) and !isset($_GET['currentFolderID'])){
				//values if no table headers are clicked
				$sortBy = "default";
				$sortType = "default";
				$currentFolderID = $_SESSION['userID'];
				$folderUpperDirectory = "none";
				
			}else{
				//values if table headers are clicked
				$sortBy = $_GET['sortBy'];
				$sortType = $_GET['sortType'];
				$currentFolderID = $_GET['currentFolderID'];
				$_SESSION['currentFolderID'] = $currentFolderID;
				$_SESSION['currentFolderID'] . " this is session <br>";
				$currentFolderID . "<br>";
				$_SESSION['folderUpperDirectory'] = $folderUpperDirectory = $_GET['folderUpperDirectory'];
			}
			$currentPath = "12";
			//$currentPath = $_GET['currentPath'];
			$tab = 1;
			//$tab = $_GET['tab'];
			
			
			
			
			
			$this->functionBreadCrumbs($currentPath, $userID, $tab, $folderUpperDirectory, $currentFolderID, $tab, $sortBy, $sortType);
			
			//echo "here sortBy is " . $sortBy . " and here sortType is " . $sortType . " and currentFolderID is :" . $currentFolderID . "<br> and folderUpperDirectory is: " . $folderUpperDirectory . "<br>";
			
			echo "<ul class=\"nav navbar-nav navbar-center\" style=\"width:auto\">";//upload
				echo "<form id=\"formFileUpload\" action=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\" method=\"post\" enctype=\"multipart/form-data\">";
					echo "<input type=\"file\" name=\"userFile\"><br>";
					echo "<input type=\"submit\" value=\"Upload file\" name=\"btnUpload\">";
				echo "</form>";
			echo "</ul>";
			echo "<ul class=\"nav navbar-nav navbar-center\" style=\"width:auto\">";//create folder
				echo "<li class=\"dropdown\">";
					echo "<a href=\"\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" ><b>Create Folder</b></a>";
					echo "<ul class=\"dropdown-menu\">";
						echo "<li><a>";
							echo "<form method=\"POST\" action=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\" >";//btb
								echo "<input type=\"text\" name=\"fName\" />";
								echo "<input type=\"submit\" name=\"btnCreateFolder\" value=\"Folder\" />";
							echo "</form>";
						echo "</a></li>";
					echo "</ul>";
				echo "</li>";
			echo "</ul>";
				
			
			echo "<form action=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\" method=\"post\">";
			
			echo "<div id=\"seclayer\" >second layer";
				echo "<div id=\"btnClose\">X</div>";
					echo "<div class=\"container\">";
						$this->functionFileSharing();
					echo "</div>";
				echo "</div>";
			echo "</div>";
					echo "<button type=\"submit\" value=\"\" name=\"btnDownloadExperiment\">Download</button>";
					echo "<button type=\"submit\" value=\"\" name=\"btnDelete\">Delete</button>";
					echo "<ul class=\"nav navbar-nav navbar-center\" style=\"width:auto\">";//download and others
					echo "<li class=\"dropdown\">";
						echo "<a href=\"\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" ><b>Privacy</b></a>";
						echo "<ul class=\"dropdown-menu\">";
							echo "<li><a>";
								
								echo "<button type=\"submit\" value=\"\" name=\"btnPublic\">Public</button>";
								echo "<button type=\"submit\" value=\"\" name=\"btnPrivate\">Private</button>";
								echo "<div id=\"share\">Share</div>";
							echo "</a></li>";
						echo "</ul>";
					echo "</li>";
				echo "</ul>";		
			
			
			
			echo "<div class=\"table-responsive\">";//thead
				if($sortType == "desc"){
					
					echo "<table width=\"100%\" class=\"table table-striped\">";
					
					echo "<thead>";
						echo "<tr id=\"columnName\">";
							echo "<th><a><input type=\"checkbox\" id=\"cbgroup1_master\" onchange=\"togglecheckboxes(this,'cbgroup1')\"/></a></th>";
							echo "<th><a href=\"index.php?sortBy=userID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>UserID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fName</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileMime&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileMime</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileSize&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileSize</b></a></th>";
							echo "<th><a><b>folderData/UpperDirectory</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>folderID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>Shared</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>Public</b></a></th>";
						echo "</tr>";
					echo "</thead>";
				}elseif($sortType == "asc"){
					echo "<table width=\"100%\" class=\"table table-striped\">";
					echo "<thead>";
						echo "<tr id=\"columnName\">";
							echo "<th><a><input type=\"checkbox\" id=\"cbgroup1_master\" onchange=\"togglecheckboxes(this,'cbgroup1')\"/></a></th>";
							echo "<th><a href=\"index.php?sortBy=userID&sortType=desc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>UserID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileID&sortType=desc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fName&sortType=desc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fName</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileMime&sortType=desc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileMime</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileSize&sortType=desc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileSize</b></a></th>";
							echo "<th><a><b>folderData/UpperDirectory</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=desc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>folderID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>Shared</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>Public</b></a></th>";
						echo "</tr>";
					echo "</thead>";
				}else{
					echo "<table width=\"100%\" class=\"table table-striped\">";
					echo "<thead>";
						echo "<tr id=\"columnName\">";
							echo "<th><a><input type=\"checkbox\" id=\"cbgroup1_master\" onchange=\"togglecheckboxes(this,'cbgroup1')\"/></a></th>";
							echo "<th><a href=\"index.php?sortBy=userID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>UserID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fName</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileMime&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileMime</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=fileSize&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fileSize</b></a></th>";
							echo "<th><a><b>folderData/UpperDirectory</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>folderID</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>Shared</b></a></th>";
							echo "<th><a href=\"index.php?sortBy=folderID&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>Public</b></a></th>";
						echo "</tr>";
					echo "</thead>";
				}
			
			//here will be functionGetCurrentFolderID
			//include folderupperdirectory
			//included here is also $tab(1 = My Drive 2 = Shared Files 3 = Public Files)
				if($tab == 1){
					if($sortBy == "userID" and $sortType == "asc"){
					//echo "<br>userIDASC<br>";
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY userID ASC") or die(mysql_error());
					//echo "sort by userID";
					}elseif($sortBy == "userID" and $sortType == "desc"){
						//echo "<br>userIDDESC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY userID DESC") or die(mysql_error());
						//echo "sort by userID";
					}elseif($sortBy == "fileID" and $sortType == "asc"){
						//echo "<br>fileIDASC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fileID ASC") or die(mysql_error());
						//echo "sort by fileID";
					}elseif($sortBy == "fileID" and $sortType == "desc"){
						//echo "<br>fileIDDESC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fileID DESC") or die(mysql_error());
						//echo "sort by fileID";
					}elseif($sortBy == "fName" and $sortType == "asc"){
						//echo "<br>fNameASC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fName ASC") or die(mysql_error());
						//echo "sort by fName";
					}elseif($sortBy == "fName" and $sortType == "desc"){
						//echo "<br>fNameDESC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fName DESC") or die(mysql_error());
						//echo "sort by fName";
					}elseif($sortBy == "fileMime" and $sortType == "asc"){
						//echo "<br>fileMimeASC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fileMime ASC") or die(mysql_error());
						//echo "sort by fileMime";
					}elseif($sortBy == "fileMime" and $sortType == "desc"){
						//echo "<br>fileMimeDESC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fileMime DESC") or die(mysql_error());
						//echo "sort by fileMime";
					}elseif($sortBy == "fileSize" and $sortType == "asc"){
						//echo "<br>fileSezeASC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fileSize ASC") or die(mysql_error());
						//echo "sort by fileSize";
					}elseif($sortBy == "fileSize" and $sortType == "desc"){
						//echo "<br>fileSizeDESC<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fileSize DESC") or die(mysql_error());
						//echo "sort by fileSize";
					}else{
						//echo "<br>elsedefualt<br>";
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND folderUpperDirectory = '$currentFolderID' ORDER BY fName ASC") or die(mysql_error());
						//echo "sort by userIDefault";
					}
				}elseif($tab == 2){
					if($sortBy == "userID" and $sortType == "asc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY userID ASC") or die(mysql_error());
					}elseif($sortBy == "userID" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY userID DESC") or die(mysql_error());
					}elseif($sortBy == "fileID" and $sortType == "asc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileID ASC") or die(mysql_error());
					}elseif($sortBy == "fileID" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileID DESC") or die(mysql_error());
					}elseif($sortBy == "fName" and $sortType == "asc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fName ASC") or die(mysql_error());
					}elseif($sortBy == "fName" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fName DESC") or die(mysql_error());
					}elseif($sortBy == "fileMime" and $sortType == "asc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileMime ASC") or die(mysql_error());
					}elseif($sortBy == "fileMime" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileMime DESC") or die(mysql_error());
					}elseif($sortBy == "fileSize" and $sortType == "asc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileSize ASC") or die(mysql_error());
					}elseif($sortBy == "fileSize" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileSize DESC") or die(mysql_error());
					}else{
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '1' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fName ASC") or die(mysql_error());
					}
				}elseif($tab == 3){
					if($sortBy == "userID" and $sortType == "asc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY userID ASC") or die(mysql_error());
					}elseif($sortBy == "userID" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY userID DESC") or die(mysql_error());
					}elseif($sortBy == "fileID" and $sortType == "asc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileID ASC") or die(mysql_error());
					}elseif($sortBy == "fileID" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileID DESC") or die(mysql_error());
					}elseif($sortBy == "fName" and $sortType == "asc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fName ASC") or die(mysql_error());
					}elseif($sortBy == "fName" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fName DESC") or die(mysql_error());
					}elseif($sortBy == "fileMime" and $sortType == "asc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileMime ASC") or die(mysql_error());
					}elseif($sortBy == "fileMime" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileMime DESC") or die(mysql_error());
					}elseif($sortBy == "fileSize" and $sortType == "asc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileSize ASC") or die(mysql_error());
					}elseif($sortBy == "fileSize" and $sortType == "desc"){
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY fileSize DESC") or die(mysql_error());
					}else{
						$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize, fileData, folderID, shared, public FROM tblfile WHERE userID = '$userID' AND folderID = '$currentFolderID' AND shared = '1' UNION SELECT userID, '' , fName, '', '', folderUpperDirectory, folderID, '', '' FROM tblfolder WHERE userID = '$userID' AND (status = '2' OR status = '3') AND folderUpperDirectory = '$currentFolderID' ORDER BY userID ASC") or die(mysql_error());
					}
				}
				
				
				
				
				
				/*
			
				if($sortType = "asc"){
					//echo "if asc";
					echo '<table width="100%">
					<tr id="columnName">
						<td><a href=\'index.php?sortBy=userID&sortType=desc\'><b>UserID</b></a></td>
						<td><a href=\'index.php?sortBy=fileID&sortType=desc\'><b>fileID</b></a></td>
						<td><a href=\'index.php?sortBy=fName&sortType=desc\'><b>fName (bytes)</b></a></td>
						<td><a href=\'index.php?sortBy=fileMime&sortType=desc\'><b>fileMime</b></a></td>
						<td><a href=\'index.php?sortBy=fileSize&sortType=desc\'><b>fileSize</b></a></td>
					</tr>';
				}elseif($sortType = "desc"){
					//echo "if desc";
					echo '<table width="100%">
					<tr id="columnName">
						<td><a href=\'index.php?sortBy=userID&sortType=asc\'><b>UserID</b></a></td>
						<td><a href=\'index.php?sortBy=fileID&sortType=asc\'><b>fileID</b></a></td>
						<td><a href=\'index.php?sortBy=fName&sortType=asc\'><b>fName (bytes)</b></a></td>
						<td><a href=\'index.php?sortBy=fileMime&sortType=asc\'><b>fileMime</b></a></td>
						<td><a href=\'index.php?sortBy=fileSize&sortType=asc\'><b>fileSize</b></a></td>
					</tr>';
				}
				*/
				
				
				/*
				if($sortBy == "userID" && $sortType = "desc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY userID ASC") or die(mysql_error());
					//echo "sort by userID";
				}elseif($sortBy == "fileID" && $sortType = "desc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY fileID ASC") or die(mysql_error());
					//echo "sort by fileID";
				}elseif($sortBy == "fName" && $sortType = "desc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY fName ASC") or die(mysql_error());
					//echo "sort by fName";
				}elseif($sortBy == "fileMime" && $sortType = "desc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY fileMime ASC") or die(mysql_error());
					//echo "sort by fileMime";
				}elseif($sortBy == "fileSize" && $sortType = "desc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY fileSize ASC") or die(mysql_error());
					//echo "sort by fileSize";
				}elseif($sortBy == "userID" && $sortType = "asc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY userID DESC") or die(mysql_error());
					//echo "sort by userID";
				}elseif($sortBy == "fileID" && $sortType = "asc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY fileID DESC") or die(mysql_error());
					//echo "sort by fileID";
				}elseif($sortBy == "fName" && $sortType = "asc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY fName DESC") or die(mysql_error());
					//echo "sort by fName";
				}elseif($sortBy == "fileMime" && $sortType = "asc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY fileMime DESC") or die(mysql_error());
					//echo "sort by fileMime";
				}elseif($sortBy == "fileSize" && $sortType = "asc"){
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY fileSize DESC") or die(mysql_error());
					//echo "sort by fileSize";
				}else{
					$SQLQuery = mysql_query("SELECT userID, fileID, fName, fileMime, fileSize FROM tblfile ORDER BY userID ASC") or die(mysql_error());
					//echo "sort by userIDefault";
				}*/
				
				
				//folder function altered because of folder listing
				//must revise by getting folder id of current directory
				//e.g. select blah from tblfile THIS IS CORRECT! CREATE AN ALGORITHM
				//ALGORITHM STARTS FROM FILE LISTING GETTING THE FOLDER ID FROM TBLFILE
					
				if(mysql_num_rows($SQLQuery)>0){
						echo "<tbody>";
							
							$x = mysql_num_rows($SQLQuery);
							while($row = mysql_fetch_array($SQLQuery)) {
								$cbid = "cb1_" . $x;
								echo "<tr>";
								
								if(empty($row['fileID'])){
									echo "<td>";
										//echo "<input type=\"checkbox\" class=\"cbgroup1\" name=\"check_list[]\" value=\"{$row['folderID']}\">";
										echo "<input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"{$row['folderID']}\">";
									echo "</td>";
								}else{
									echo "<td>";
										//echo "<input type=\"checkbox\" class=\"cbgroup1\" name=\"check_list[]\" value=\"{$row['fileID']}\">";
										echo "<input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"{$row['fileID']}\">";
									echo "</td>";
								}
								echo "<td>{$row['userID']}</td>";
								echo "<td>{$row['fileID']}</td>";
								if($row['folderID'] != $_GET['currentFolderID']){
									$currentFolderID = $row['folderID'];
									$folderUpperDirectory = $row['fileData'];
									$currentPath = $_GET['currentPath'] . $row['folderID'] . '/';
									$_SESSION['currentPath'] = $_GET['currentPath'];
									$tab = $_GET['tab'];
									echo "<td><a href=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\">{$row['fName']}</a></td>";
								}else{
									echo "<td>{$row['fName']}</td>";
								}
								echo "<td>{$row['fileMime']}</td>";
								echo "<td>{$row['fileSize']}</td>";
								echo "<td>{$row['fileData']}</td>";//kawagian
								echo "<td>{$row['folderID']}</td>";
								
								
								if($row['fileID'] != ""){
									if($row['shared'] == 1){
										echo "<td>Shared</td>";
									}else{
										echo "<td>Private</td>";
									}
									
									if($row['public'] == 1){
										echo "<td>Public</td>";
									}else{
										echo "<td>Private</td>";
									}
									
									
									
									echo "<td>";
										echo "<button type=\"submit\" value=\"{$row['fileID']}\" name=\"fileIDPasser\">Download!</button>";
									echo "</td>";
								}
								echo "</tr>";
								$_SESSION['folderID'] = $row['folderID'];
								$x -= 1;
							}
							echo "<form>";
						echo "</tbody>";
					echo '</table>';
				echo "</div>";
				}else{
					echo "There are no files in the database";
				}
				
				
				
				
			}//end of function
		function functionFileSharing(){
			$userID = $_SESSION['userID'];//sets $userID for WHERE part of the proceeding queries.
			if(!isset($_GET['sortBy']) and !isset($_GET['sortType']) and !isset($_GET['currentFolderID'])){
				//values if no table headers are clicked
				$sortBy = "default";
				$sortType = "default";
				$currentFolderID = $_SESSION['userID'];
				$folderUpperDirectory = "none";
				
			}else{
				//values if table headers are clicked
				$sortBy = $_GET['sortBy'];
				$sortType = $_GET['sortType'];
				$currentFolderID = $_GET['currentFolderID'];
				$_SESSION['currentFolderID'] = $currentFolderID;
				$_SESSION['currentFolderID'] . " this is session <br>";
				$currentFolderID . "<br>";
				$_SESSION['folderUpperDirectory'] = $folderUpperDirectory = $_GET['folderUpperDirectory'];
			}
			
			$currentPath = $_GET['currentPath'];
			$tab = $_GET['tab'];
			echo "<div id=\"seclayerAsc\">asc</div>";	
			echo "<div id=\"seclayerDesc\">desc</div>";		
			
			echo "<div id=\"seclayer_asc\" class=\"contentAsc\">";
				$SQLQuery = mysql_query("SELECT* FROM tbluser ORDER BY userName ASC") or die(mysql_error());
				echo "<table>";
				echo "<button id=\"btnShare\" value=\"\" name=\"btnShare\">Share</button>";
				echo "<button id=\"btnUnShare\" value=\"\" name=\"btnUnShare\">unShare</button>";
					echo "<thead>";
						echo "<tr id=\"columnName\">";
							echo "<th><a><input type=\"checkbox\" id=\"cbgroup1_master\" onchange=\"togglecheckboxes(this,'cbgroup1')\"/></a></th>";
							echo "<th><a href=\"index.php?sortBy=fName&sortType=desc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fName</b></a></th>";
						echo "</tr>";
					echo "</thead>";
					if(mysql_num_rows($SQLQuery)>0){
						echo "<tbody>";
							
							$x = mysql_num_rows($SQLQuery);
							while($row = mysql_fetch_array($SQLQuery)) {
								$cbid = "cb1_" . $x;
								echo "<tr>";
									echo "<td>";
										echo "<input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg2[]\" value=\"{$row['userID']}\">";
									echo "</td>";
								echo "<td>{$row['userID']}</td>";
								echo "<td>{$row['userName']}</td>";
								
								$x -= 1;
							}
						echo "</tbody>";
					echo '</table>';
				echo "</div>";
				}else{
					echo "There are no files in the database";
				}
					
				echo "</table>";
			echo "</div>";
			
			echo "<div id=\"seclayer_desc\" class=\"contentDesc\">";
				$SQLQuery = mysql_query("SELECT* FROM tbluser ORDER BY userName DESC") or die(mysql_error());
				echo "<table>";
				echo "<button id=\"btnShare\" value=\"\" name=\"btnShare\">Share</button>";
				echo "<button id=\"btnUnShare\" value=\"\" name=\"btnUnShare\">unShare</button>";
					echo "<thead>";
						echo "<tr id=\"columnName\">";
							echo "<th><a><input type=\"checkbox\" id=\"cbgroup1_master\" onchange=\"togglecheckboxes(this,'cbgroup1')\"/></a></th>";
							echo "<th><a href=\"index.php?sortBy=fName&sortType=asc&counter=1&currentFolderID=$currentFolderID&folderUpperDirectory=$folderUpperDirectory&currentPath=$currentPath&tab=$tab\"><b>fName</b></a></th>";
						echo "</tr>";
					echo "</thead>";
					if(mysql_num_rows($SQLQuery)>0){
						echo "<tbody>";
							
							$x = mysql_num_rows($SQLQuery);
							while($row = mysql_fetch_array($SQLQuery)) {
								$cbid = "cb1_" . $x;
								echo "<tr>";
									echo "<td>";
										echo "<input type=\"checkbox\" id=\"{$cbid}\" class=\"cbgroup1\" name=\"cbg2[]\" value=\"{$row['userID']}\">";
									echo "</td>";
								echo "<td>{$row['userID']}</td>";
								echo "<td>{$row['userName']}</td>";
								
								$x -= 1;
							}
						echo "</tbody>";
					echo '</table>';
				echo "</div>";
				}else{
					echo "There are no files in the database";
				}
					
				echo "</table>";
			echo "</div>";
		}
		function btnUpdateUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"btnUpdateUser\" value=\"Update User\">";
			echo "</div>";
		}
		function btnUpdateUserEditProfile($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"btnUpdateUserEditProfile\" value=\"Update Profile\">";
			echo "</div>";
		}
		function btnCancel($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"form-group\">";
				echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"btnCancel\" value=\"Cancel\">";
			echo "</div>";
		}
		function btnAddUserx(){
			echo "<div class=\"form-group\">";
				echo "<input class=\"btn btn-primary\" type=\"submit\" name=\"btnAddUserx\" value=\"Add User\" />";
			echo "</div>";
		}
		function btnCancelAddUser(){
			echo "<div class=\"form-group\">";
				echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"btnCancelAddUser\" value=\"Cancel\">";
			echo "</div>";
		}
		function bodyEditUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			echo "<div class=\"box box-primary\">";
				echo "<div class=\"box-header\">";
					echo "<h3 class=\"box-title\">Edit User Info ID no. {$_SESSION['userIDx']} </h3>";
				echo "</div>";//<!-- /.box-header -->
				//<!-- form start -->
				echo "<div class=\"box-body\">";
					//echo "<form role=\"form\">";
						//<!-- text input -->
						/*
							$_SESSION['userIDx'] = $row['userID']; //license number
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
							$_SESSION['contactNumberx'] = $row['contactNumber'];
						*/
						echo "<div class=\"form-group\">";
							echo "<label>Username: {$_SESSION['userNamex']}</label>";
							echo "<input type=\"text\" class=\"form-control\" placeholder=\"Username\" name=\"userNamex\"/>";
							echo "<label>Password: {$_SESSION['userPasswordx']}</label>";
							echo "<input type=\"password\" class=\"form-control\" placeholder=\"Password\" name=\"userPasswordx\"/>";
							echo "<label>First Name: {$_SESSION['userFirstNamex']}</label>";
							echo "<input type=\"text\" class=\"form-control\" placeholder=\"First Name\" name=\"userFirstNamex\"/>";
							echo "<label>Last Name: {$_SESSION['userLastNamex']}</label>";
							echo "<input type=\"text\" class=\"form-control\" placeholder=\"Last Name\" name=\"userLastNamex\"/>";
							//salt is not presented
							if($_SESSION['userLevelx'] == 1){
								echo "<label>User Level: Admin</label>";
							}elseif($_SESSION['userLevelx'] == 2){
								echo "<label>User Level: User</label>";
							}
							echo "<select class=\"form-control\" name=\"userLevelx\">";
								echo "<option value=\"\"></option>";
								echo "<option value=\"2\">User</option>";
								echo "<option value=\"1\">Admin</option>";
							echo "</select>";
							if($_SESSION['userAccountStatusx'] == 1){
								echo "<label>User Level: Active</label>";
							}elseif($_SESSION['userAccountStatusx'] == 0){
								echo "<label>User Level: Inactive</label>";
							}
							echo "<select class=\"form-control\" name=\"userAccountStatusx\">";
								echo "<option value=\"\"></option>";
								echo "<option value=\"1\">Active</option>";
								echo "<option value=\"0\">Inactive</option>";
							echo "</select>";
							$userRegistrationDatex = $this->functionDateRearranger($_SESSION['userRegistrationDatex']);
							echo "<label>Date: {$userRegistrationDatex}</label>";
							echo "<input type=\"text\" class=\"form-control\" placeholder=\"Date yyyy-mm-dd\" name=\"userRegistrationDatex\"/>";
							echo "<label>User Storage Capacity: {$_SESSION['userStorageCapacityx']}</label>";
							echo "<input type=\"text\" class=\"form-control\" placeholder=\"User Storage Capacity\" name=\"userStorageCapacityx\"/>";
						echo "</div>";
					//echo "</form>";	
					/*echo "<div class=\"form-group\">";
						echo "<label for=\"exampleInputEmail1\">Email address</label>";
						echo "<input type=\"email\" class=\"form-control\" id=\"exampleInputEmail1\" placeholder=\"Enter email\">";
					echo "</div>";
					echo "<div class=\"form-group\">";
						echo "<label for=\"exampleInputPassword1\">Password</label>";
						echo "<input type=\"password\" class=\"form-control\" id=\"exampleInputPassword1\" placeholder=\"Password\">";
					echo "</div>";
					echo "<div class=\"form-group\">";
						echo "<label for=\"exampleInputFile\">File input</label>";
						echo "<input type=\"file\" id=\"exampleInputFile\">";
						echo "<p class=\"help-block\">Example block-level help text here.</p>";
					echo "</div>";
					echo "<div class=\"checkbox\">";
						echo "<label>";
							echo "<input type=\"checkbox\"> Check me out";
						echo "</label>";
					echo "</div>";
				echo "</div>";*///<!-- /.box-body -->
		
				echo "<div class=\"box-footer\">";
					echo "<div class=\"row\">";
						echo "<div class=\"col-md-2\">";
							$this->btnUpdateUser($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
						echo "</div>";
						echo "<div class=\"col-md-2\">";
							$this->btnCancel($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
						echo "</div>";
					echo "</div>";
				echo "</div>";	
			echo "</div>";//<!-- /.box -->
		}
		function bodyEditUserProfile($tab,$currentFolderID,$folderUpperDirectory,$currentPath){
			parent::functionDBConnect();
			if(mysqli_connect_errno()) {
				die("MySQL connection failed: ". mysqli_connect_error());
			}else{
				//echo "file listing connected";
			}
			$SQLQuery = mysql_query("SELECT * FROM tbluser WHERE userID = '{$_SESSION['userID']}'") or die(mysql_error());
			if(mysql_num_rows($SQLQuery)>0){
				while($row = mysql_fetch_array($SQLQuery)) {
					$_SESSION['userNameEditUserProfile'] = $userNameEditUserProfile = $row['userName'];
					$_SESSION['userPasswordEditUserProfile'] = $userPasswordEditUserProfile = $row['userPassword'];
					$_SESSION['userFirstNameEditUserProfile'] = $userFirstNameEditUserProfile = $row['userFirstName'];
					$_SESSION['userLastNameEditUserProfile'] = $userLastNameEditUserProfile = $row['userLastName'];
				}
			}
			echo "<div class=\"box box-primary\">";
				echo "<div class=\"box-header\">";
					echo "<h3 class=\"box-title\">Edit User Info ID no. {$_SESSION['userID']} </h3>";
				echo "</div>";//<!-- /.box-header -->
				//<!-- form start -->
				echo "<div class=\"box-body\">";
					//echo "<form role=\"form\">";
						//<!-- text input -->
						/*
							$_SESSION['userIDx'] = $row['userID']; //license number
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
							$_SESSION['contactNumberx'] = $row['contactNumber'];
						*/
						echo "<div class=\"form-group\">";
							echo "<label>Username: {$userNameEditUserProfile}</label>";
							echo "<input type=\"text\" class=\"form-control\" placeholder=\"Username\" name=\"userNameEditUserProfile\"/>";
							//userPassword for salting
							echo "<label>Password: {$userPasswordEditUserProfile}</label>";
							echo "<input type=\"password\" class=\"form-control\" placeholder=\"User Password\" name=\"userPasswordEditUserProfile\"/>";
							echo "<label>Re-type Password:</label>";
							echo "<input type=\"password\" class=\"form-control\" placeholder=\"User Retype Password\" name=\"userReTypePasswordEditUserProfile\"/>";
							echo "<label>First Name: {$userFirstNameEditUserProfile}</label>";
							echo "<input type=\"text\" class=\"form-control\" placeholder=\"First Name\" name=\"userFirstNameEditUserProfile\"/>";
							echo "<label>Last Name: {$userLastNameEditUserProfile}</label>";
							echo "<input type=\"text\" class=\"form-control\" placeholder=\"Last Name\" name=\"userLastNameEditUserProfile\"/>";
							//salt is not presented
						echo "</div>";
		
						echo "<div class=\"box-footer\">";
							echo "<div class=\"row\">";
								echo "<div class=\"col-md-2\">";
									$this->btnUpdateUserEditProfile($tab,$currentFolderID,$folderUpperDirectory,$currentPath);
								echo "</div>";
							echo "</div>";
						echo "</div>";
					echo "</div>";	
			echo "</div>";//<!-- /.box -->
		}
		function functionDateRearranger($Date){
			$Day = "";
			$Month = "";
			$Year = "";
			$dashCounter = 1;
			$str = $Date;
			$strlen = strlen( $str );
			for( $i = 0; $i <= $strlen; $i++ ) {
				$char = substr( $str, $i, 1 );
				// $char contains the current character, so do your processing here
				//echo "<br>" . $char . "<br>";
				
				if($char != "-"){
					if($dashCounter == 1){
						$Year .= $char;
					}elseif($dashCounter == 2){
						$Month .= $char;
					}
					elseif($dashCounter == 3){
						$Day .= $char;
					}
				}else{
					$dashCounter += 1;
					
				}
			}
			
			if($Month == "1"){
				$Monthx = "January";
			}elseif($Month == "2"){
				$Monthx = "February";
			}elseif($Month == "3"){
				$Monthx = "March";
			}elseif($Month == "4"){
				$Monthx = "April";
			}elseif($Month == "5"){
				$Monthx = "May";
			}elseif($Month == "6"){
				$Monthx = "June";
			}elseif($Month == "7"){
				$Monthx = "July";
			}elseif($Month == "8"){
				$Monthx = "August";
			}elseif($Month == "9"){
				$Monthx = "September";
			}elseif($Month == "10"){
				$Monthx = "October";
			}elseif($Month == "11"){
				$Monthx = "November";
			}elseif($Month == "12"){
				$Monthx = "December";
			}else{
				$Monthx = "Error";
			}
			$Datex = $Monthx . " " . $Day . ", " . $Year;
			return $Datex;
		}
		function bodyAddUser(){
			echo "<div class=\"box box-primary\">";
				echo "<div class=\"box-header\">";
					echo "<h3 class=\"box-title\">Add Users/Admins</h3>";
				echo "</div>";//<!-- /.box-header -->
				//<!-- form start -->
				echo "<form role=\"form\" action=\"index.php?tab=17\" method=\"post\">";
					echo "<div class=\"box-body\">";
						echo "<div class=\"form-group\">";
						/*echo "Student ID: <input type=\"text\" name=\"studentID\" />";
						echo "Username: <input type=\"text\" name=\"userName\" />";
						echo "Password: <input type=\"text\" name=\"userPassword\" />";
						echo "Re-type Password: <input type=\"text\" name=\"userPasswordReType\" />";
						echo "First Name: <input type=\"text\" name=\"userFirstName\" />";
						echo "Last Name: <input type=\"text\" name=\"userLastName\" />";
						echo "<input type=\"submit\" name=\"btnSignup\" value=\"Sign Up\" />";*/
						//userID
						echo "<label>User ID:</label>";
						echo "<input type=\"text\" class=\"form-control\" placeholder=\"User ID\" name=\"userID\"/ required>";
						//userName
						echo "<label>User Name:</label>";
						echo "<input type=\"text\" class=\"form-control\" placeholder=\"User Name\" name=\"userName\"/ required>";
						//userPassword for salting
						echo "<label>Password:</label>";
						echo "<input type=\"password\" class=\"form-control\" placeholder=\"User Password\" name=\"userPassword\"/ required>";
						echo "<label>Re-type Password:</label>";
						echo "<input type=\"password\" class=\"form-control\" placeholder=\"User Retype Password\" name=\"userReTypePassword\"/ required>";
						//userFirst Middle Last Name
						echo "<label>First Name:</label>";
						echo "<input type=\"text\" class=\"form-control\" placeholder=\"First name\" name=\"userFirstName\"/ required>";
						echo "<label>Last Name:</label>";
						echo "<input type=\"text\" class=\"form-control\" placeholder=\"User LastName\" name=\"userLastName\" required/>";
						//userLevel
						echo "<label>User Level:</label>";
						echo "<select class=\"form-control\" name=\"userLevel\" required>";
							echo "<option value=\"\">Please Select</option>";
							echo "<option value=\"2\">User</option>";
							echo "<option value=\"1\">Admin</option>";
						echo "</select>";
						//userAccouintStatus
						echo "<label>User Account Status:</label>";
						echo "<select class=\"form-control\" name=\"userAccountStatus\" required>";
							echo "<option value=\"\">Please Select</option>";
							echo "<option value=\"1\">Active</option>";
							echo "<option value=\"0\">Inactive</option>";
						echo "</select>";
						//userID
						//echo "<label>Storage Capacity (GB):</label>";
						//echo "<input type=\"text\" class=\"form-control\" placeholder=\"Storage Capacity\" name=\"userStorageCapacity\"/ required>";
					echo "</div>";
					
					
					
				echo "<div class=\"box-footer\">";
					echo "<div class=\"row\">";
						echo "<div class=\"col-md-2\">";
							$this->btnAddUserx();
						echo "</div>";
						echo "<div class=\"col-md-2\">";
							$this->btnCancelAddUser();
						echo "</div>";
					echo "</div>";
				echo "</div>";	
			echo "</div>";//<!-- /.box -->
		}
	}
	
?>
 