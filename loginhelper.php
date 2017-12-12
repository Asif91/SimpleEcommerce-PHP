<?php
 if (file_exists("../../data/customer.xml")) {

session_start();
if (isset($_GET['action']) && $_GET['action'] == "login") {
    if (!file_exists("../../data/customer.xml")){
        echo "Server Error:Customer data missing.";
    } else if (isset($_SESSION['user_email'])) {
        unset ($_SESSION['user_email']);
    } 
	
	if(! (isset($_SESSION['user_email']))){
        if (isset($_GET['email']) && isset($_GET['pass'])) {
			$found = FALSE ;
			$email = $_GET['email'];
            $password = $_GET['pass'];
            $dom = DOMDocument::load("../../data/customer.xml");
			
			$customer = $dom->getElementsByTagName("customer");
			foreach ($customer as $node) {
			$custemail = $node->getElementsByTagName("email")->item(0)->nodeValue;
			$custpass = $node->getElementsByTagName("password")->item(0)->nodeValue;
			if ($custemail == $email &&  $custpass == $password) {
				            // TO-DO Read XML and check customer.
            $_SESSION['user_email'] = $email;
			$found = TRUE ; 
            
			break;
			}

			}
			if(trim($found) == TRUE)
			{
				echo "OK";
			}
			else{
				echo "wrong password or email";
			}

        } else {
            echo "Error: Email or Password missing";
        }
    }
} else {
    unset($_SESSION['user_email']);
    echo "OK";

	}
	
 }
 
 else 
 {
	 
	 echo "No Record Found";
 }
?> 