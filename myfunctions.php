<?php
session_start();
include ("account.php");

$db = mysqli_connect($hostname, $username, $password , $project);

if (mysqli_connect_errno())
  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
}

function auth ($user, $pass)
  {
    global $db;
    $s = "select * from accounts where user = '$user' and pass = '$pass'";
    $t = mysqli_query($db,$s) or die(mysqli_error());

    $num = mysqli_num_rows($t);

    if ($num > 0) {
      return true;
    }
    else {
      return false;
    }
  }

function redirect ($message, $targetfile, $delay){

  echo "<br>$message<br>";
  header( "refresh:$delay; url=".$targetfile );
  exit();
}

function gatekeeper()
{
		if ( !(isset($_SESSION["logged"])) )
		{
			redirect ("Restricted access, please sign in first.", "login.html", "5");
		}

}

function deposit ($user,$amount)
{
  global $db;

  $s = "select * from accounts where user = '$user'";
  echo "SQL statement is $s<br>";

  $t = mysqli_query($db,$s);

  $num = mysqli_num_rows($t);
  echo "<br> There were $num rows retrieved.<br><br>";

  $r = mysqli_fetch_array($t,MYSQLI_ASSOC);
  $c = $r['cur_balance'];

  $c = $amount + $c;

  $x = "update accounts SET cur_balance = $c where user = '$user'" ;
  echo "<br>Depositing $amount into current balance";
  $_SESSION["Current_Balance"] = $c;

  echo "SQL statement is $x <br>";

  $y = mysqli_query($db,$x) or die (mysqli_error());

  echo "$c<br>";
  echo "$amount<br>";

  $q = "insert into transactions values ('$user','D','$amount', NOW())";
  echo "<br>$q<br>";

  $u = mysqli_query($db,$q)  or die (mysqli_error($db));

}

function withdraw ($user,$amount)
{
  global $db;

  $s = "select * from accounts where user = '$user'";
  echo "SQL statement is $s<br>";

  $t = mysqli_query($db,$s);

  $num = mysqli_num_rows($t);
  echo "<br> There were $num rows retrieved.<br><br>";

  $r = mysqli_fetch_array($t,MYSQLI_ASSOC);
  $c = $r['cur_balance'];

  $c = $c - $amount;

  $x = "update accounts SET cur_balance = $c where user = '$user'" ;
  echo "<br>Withdrawing $amount from current balance";
  $_SESSION["Current_Balance"] = $c;

  echo "SQL statement is $x <br>";

  $y = mysqli_query($db,$x) or die (mysqli_error($db));

  $q = "insert into transactions values ('$user','W','$amount', NOW())";
  echo "<br>$q<br>";

  $u = mysqli_query($db,$q) or die (mysqli_error());
}

function show ($user, $out){

    global $db;
    $out = "The Username entered is $user";
    $s = "select * from transactions where user = '$user'";
    $t = mysqli_query($db,$s) or die(mysqli_error());

    echo "<table border='1'>
    <tr>
    <th>User</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Date</th>
    </tr>";

    while($row = mysqli_fetch_array($t))
    {
    echo "<tr>";
    echo "<td>" . $row['user'] . "</td>";
    echo "<td>" . $row['type'] . "</td>";
    echo "<td>" . $row['amount'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "</tr>";
    }
    echo "</table>";

  }

  function mailer ($user, $out){

    global $db;

    $s = "select mail from accounts where user = '$user'";
    echo "SQL statement is $s<br>";

    $t = mysqli_query($db,$s);

    $num = mysqli_num_rows($t);
    echo "<br> There were $num rows retrieved.<br><br>";

    $r = mysqli_fetch_array($t,MYSQLI_ASSOC);
    $email = $r['mail'];



      $to = $email;
      $subject  = "Mailinator Test";
      $out = "The Username entered is $user";
      $message = "$out";

      mail ($to, $subject, $message);
    }

?>
