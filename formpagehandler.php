<?php
session_start();

include ( "myfunctions.php" );
include ( "account.php" );

$user = $_SESSION["user"];
$choice = $_GET["choice"];
$depo = $_GET["amount"];
global $out;

switch ($choice) {
  case 'D':
    deposit ($user,$depo);
    echo "<br>Transaction Completed!";

    break;

  case 'W':
  if ($_SESSION["Current_Balance"] - $depo < 0)
  {
    redirect ("Invalid transaction attempted, this transaction will overdraw your account, returning to application","formpage.php","2");
  }
  else {
    withdraw ($user,$depo);
    echo "<br>Transaction Completed!";
  }
    break;

  case 'S':
  if(isset($_GET['mail']) &&
   $_GET['mail'] == 'Yes')
    {
        show($user,$out);
        mailer ($user,$out);
        echo "<br>Transaction Completed!";


    }
    else
    {
        echo "Service only available for mail";
    }
    break;

}
 ?>

 <form action="formpage.html">
 	<button type="submit" name="button" value="submit">Make another transaction</button>
 </form>
