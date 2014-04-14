<?php

echo $_GET["name"];

foreach($_GET as &$val){
	echo $_GET[$val];
}



?>
