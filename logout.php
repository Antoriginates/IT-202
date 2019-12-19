<?php

include ( "myfunctions.php" ) ;

session_destroy();
redirect ("Thank you for using the application, Please log in again.", "formpage.html", "3");
exit;
 ?>
