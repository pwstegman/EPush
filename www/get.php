<?php
	// Configuration
	$dbhost = 'localhost';
	$dbname = 'test';

	// Connect to test database
	$m = new Mongo("mongodb://$dbhost");
	$db = $m->$dbname;

	// Get the users collection
	$c_users = $db->users->find();
    
    foreach ($c_users as $data) {
        var_dump($data);
    }
?>
