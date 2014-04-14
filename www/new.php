<?php

foreach($_GET as $key => $value){
	echo $key . " : " . $value;
	echo "<br>";
}

echo exec('bash run.sh');

?>
