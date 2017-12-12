<?php

header('Content-Type: text/xml');
session_start();
if (isset($_GET['email']) && isset($_GET['fname']) && isset($_GET['sname'])) {
    $email = $_GET['email'];
    $fname = $_GET['fname'];
    $sname = $_GET['sname'];
    if (!file_exists("../../data/customer.xml")) {
        $result = createCustomerXML($email, $fname, $sname);
        if ($result["success"]) {
            $custnum = $result["custnum"];
            $pass = $result["password"];
  		$subject = "Shipping Request with ShipOnline";
					
				// composing headers 
				$headers = "From : ShipOnline <registration@shiponline.com.au>\r\n" ;
				$headers .= "Reply-To: 101390278@student.swinburne.edu.au\r\n";
				$headers .="X-Mailer: PHP/".phpversion();
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $msg = "Dear " . $fname . ", Welcome to ShipOnline! Your customer id is " . $custnum . " and password is " . $pass . ".";
            mail($email, "Welcome to ShipOnline!", $msg, $headers, "-r 101390278@student.swin.edu.au");
             echo "OK";
        } else {
            echo "Server Error: Error while saving data";
        }
    } else {
        $result = appendCustomerXML($email, $fname, $sname);
        if ($result["success"]) {
            $custnum = $result["custnum"];
            $pass = $result["password"];
			$subject = "Shipping Request with ShipOnline";
					
				// composing headers 
				$headers = "From : ShipOnline <registration@shiponline.com.au>\r\n" ;
				$headers .= "Reply-To: 101390278@student.swinburne.edu.au\r\n";
				$headers .="X-Mailer: PHP/".phpversion();
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $msg = "Dear " . $fname . ", Welcome to ShipOnline! Your customer id is " . $custnum . " and password is " . $pass . ".";
            mail("101390278@student.swin.edu.au", "Welcome to ShipOnline!", $msg, $headers, "-r 101390278@student.swin.edu.au");
            echo "OK";
        } else {
            echo $result["msg"];
        }
    }
    $_SESSION['user_email'] = $email;
}

function createCustomerXML($email, $fname, $sname) {
    $doc = new DomDocument('1.0');

    $root = $doc->createElement('customers');
    $root = $doc->appendChild($root);

    $totalcust = $doc->createElement('totalcust');
    $totalcust = $root->appendChild($totalcust);
    $value = $doc->createTextNode("1");
    $value = $totalcust->appendChild($value);


    $cust = $doc->createElement('customer');
    $cust = $root->appendChild($cust);

    $fnamenode = $doc->createElement('firstname');
    $fnamenode = $cust->appendChild($fnamenode);
    $value = $doc->createTextNode($fname);
    $value = $fnamenode->appendChild($value);

    $snamenode = $doc->createElement('surname');
    $snamenode = $cust->appendChild($snamenode);
    $value = $doc->createTextNode($sname);
    $value = $snamenode->appendChild($value);

    $emailnode = $doc->createElement('email');
    $emailnode = $cust->appendChild($emailnode);
    $value = $doc->createTextNode($email);
    $value = $emailnode->appendChild($value);

    $custnum = $doc->createElement('custnum');
    $custnum = $cust->appendChild($custnum);
    $value = $doc->createTextNode("1");
    $value = $custnum->appendChild($value);

    $passnode = $doc->createElement('password');
    $passnode = $cust->appendChild($passnode);
    $value = $doc->createTextNode(rand(100000, 999999));
    $value = $passnode->appendChild($value);

    $strXml = $doc->save("../../data/customer.xml");
    return array("success" => true, "password" => $value->nodeValue, "custnum" => "1");
}

function appendCustomerXML($email, $fname, $sname) {
    $doc = new DomDocument('1.0');
    $doc->load('../../data/customer.xml');
    $customer = $doc->getElementsByTagName("customer");
    foreach ($customer as $node) {
        $custemail = $node->getElementsByTagName("email")->item(0)->nodeValue;
        if ($custemail == $email) {
            return array("success" => false, "msg" => "Error: Email already exists");
        }
    }

    $root = $doc->getElementsByTagName("customers")->item(0);
    $custnum = $doc->getElementsByTagName("totalcust")->item(0)->nodeValue++;

    $cust = $doc->createElement('customer');
    $cust = $root->appendChild($cust);

    $fnamenode = $doc->createElement('firstname');
    $fnamenode = $cust->appendChild($fnamenode);
    $value = $doc->createTextNode($fname);
    $value = $fnamenode->appendChild($value);

    $snamenode = $doc->createElement('surname');
    $snamenode = $cust->appendChild($snamenode);
    $value = $doc->createTextNode($sname);
    $value = $snamenode->appendChild($value);

    $emailnode = $doc->createElement('email');
    $emailnode = $cust->appendChild($emailnode);
    $value = $doc->createTextNode($email);
    $value = $emailnode->appendChild($value);

    $custnumnode = $doc->createElement('custnum');
    $custnumnode = $cust->appendChild($custnumnode);
    $value = $doc->createTextNode($custnum + 1);
    $value = $custnumnode->appendChild($value);

    $passnode = $doc->createElement('password');
    $passnode = $cust->appendChild($passnode);
    $value = $doc->createTextNode(rand(100000, 999999));
    $value = $passnode->appendChild($value);

    $strXml = $doc->save('../../data/customer.xml');
    return array("success" => true, "password" => $value->nodeValue, "custnum" => $custnum);
}

?> 