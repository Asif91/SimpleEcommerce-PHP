<?php
header('Content-Type: text/xml');

session_start();
if (isset($_GET['check']) && $_GET['check'] == "session") {
    if (isset($_SESSION['user_email'])) {
       echo $_SESSION['user_email'];
    } 
	else
	{
		echo "unavailable";
	}

}
 ?>