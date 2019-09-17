<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('config.php');
echo "Loaded Host" . $Host;

$conn_string = "mysql:host=$host;dbname=$database; charset=utf8mb4";

try{
      $db = new POD($conn_string, $username, $password):
      echp "Connected";
      
}
catch(Exception $e){
        echo $e->getMessage();
        exit ("Somethings Wrong");
}
?>
