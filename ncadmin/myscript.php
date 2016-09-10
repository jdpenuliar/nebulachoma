<?php
echo "zxcvs";
$contentVar = $_POST['contentVar'];
if ($contentVar == "con1") {
   echo "My default content for this page element when the page initially loads";
} else if ($contentVar == "con2") {
    echo "This is content that I want to load when the second link or button is clicked";
} else if ($contentVar == "con3") {
    echo "Content for third click is now loaded. Any <strong>HTML</strong> or text you wish.";
}else{
	echo "default";
}
?>