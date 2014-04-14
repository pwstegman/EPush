<?php

	//get variables
	
	//$body = json_decode(file_get_contents('php://input'), true);
	//echo $body;
//	$body = '{ ' . json_decode(file_get_contents('php://input'),true) . '}';
	// Configuration
	//echo file_get_contents('php://input')->'a';
	echo http_get_request_body();
	$dbhost = 'localhost';
	$dbname = 'test';

	// Connect to test database
	$m = new Mongo("mongodb://$dbhost");
	$db = $m->$dbname;

	// Get the users collection
	$c_users = $db->mail;

	// Insert this new document into the users collection
	//$c_users->insert(file_get_contents('php://input'));
?>
