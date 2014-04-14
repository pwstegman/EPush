<?php

foreach($_GET as $key => $value){
	echo $key . " : " . $value;
	echo "<br>";
}
//$body = json_decode(file_get_contents('php://input'), true);
//echo $body;

?>
