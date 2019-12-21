<?php

ini_set('display_errors',1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
require('config.php');


$connection_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
try{
	$db = new PDO($connection_string, $username, $password);
}
catch(Exception $e){
	echo $e->getMessage();
	exit("Try Again");
}
?>
