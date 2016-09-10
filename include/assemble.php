<?php
	//outputs the skeleton of the site
	include_once('./include/common.php');
	class classAssemble extends classCommon{
			function functionIndex($pagePasser,$counter,$userLevel){
				//parent::menu($pagePasser,$counter,$userLevel);
				parent::body($pagePasser,$counter,$userLevel);
					
			}
	}
?>
