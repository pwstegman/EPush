<?php

$body = @file_get_contents('php://input');
echo $body;

foreach($body as $k=>$v){
	echo $k . ' ' . $v . ' ; ';
}
?>
