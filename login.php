<?php
session_start();
echo session_id();
echo "<br><br>";

include ( "account.php" ) ;
include ( "myfunctions.php" ) ;
include ( "formpage.html" );

//Error Reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors' , 1);

//CSS for message output

$db = mysqli_connect($hostname, $username, $password , $project);

if (mysqli_connect_errno())
  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
}


$user = $_GET["user"];
$pass = $_GET["pass"];
$delay = $_GET["delay"];

echo "Username entered is $user<br>";
echo "Password is $pass<br>";
echo "Wait $delay seconds before redirecting<br>";

echo "<br>Checking User Credentials<br>";

if (! auth($user,$pass))
  {
    redirect ("Incorrect credentials entered, redirecting to login page.", "login.html", $delay);
  }
  else {

    global $db;
    $s = "select * from accounts where user = '$user' and pass = '$pass'";
    $t = mysqli_query($db,$s) or die(mysqli_error());
    $r = mysqli_fetch_array($t,MYSQLI_ASSOC);


    $_SESSION["logged"] = true;
    $_SESSION["user"]	= $user;
    $_SESSION["Current_Balance"] = $r['cur_balance'];
    $_SESSION["email"] = $r["mail"];


    redirect ("Correct Credentials entered, redirecting to application.","formpagehandler.php",$delay);
  }
 echo "<br>redirect function working";



 ?>

