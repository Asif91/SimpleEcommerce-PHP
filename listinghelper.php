<?php

header('Content-Type: text/xml');

if (isset($_GET['itemname']) && isset($_GET['description']) && isset($_GET['category'])&& isset($_GET['startPrice']) && isset($_GET['reservePrice'])&& isset($_GET['buyPrice']) && isset($_GET['duration'])) {
    $itemname = $_GET['itemname'];
    $description = $_GET['description'];
    $category = $_GET['category'];
    $startPrice = $_GET['startPrice'];
	$reservePrice = $_GET['reservePrice'];
	$buyPrice = $_GET['buyPrice'];
    $duration = $_GET['duration'];
	$status = "in_progress";
	$startTime = time();
	$startTime2 = date("H:i:s");
	$startDate = (date("Y-m-d"));
	session_start();
	
	$email = $_SESSION['user_email'];
	if (!file_exists("../../data/auction.xml")) {
        $result = createCustomerXML($itemname, $description, $category, $startPrice, $reservePrice, $buyPrice, $duration, $status, $startTime, $startDate, $email, $startTime2);
        if ($result["success"]) {
            $itemnum1 = $result["itemnum"];
      
			$msg = "Thank you your item has been listd in shopOnline. The item number is ". $itemnum1 .", and the bidding starts now : ". $startTime2 ." on ". $startDate ;
       
            echo $msg;
        } else {
            echo "Server Error: Error while saving data";
        }
    } else {
        $result = appendCustomerXML($itemname, $description, $category, $startPrice, $reservePrice, $buyPrice, $duration, $status, $startTime, $startDate, $email, $startTime2);
        if ($result["success"]) {
           $itemnum1 = $result["itemnum"];
      
			$msg = "Thank you your item has been listd in shopOnline. The item number is ". $itemnum1 .", and the bidding starts now : ". $startTime2 ." on ". $startDate ;
       
            echo $msg;        } else {
            echo $result["msg"];
        }
    }
  //  $_SESSION['user_email'] = $email;
}

function createCustomerXML($itemname, $description, $category, $startPrice, $reservePrice, $buyPrice, $duration, $status, $startTime, $startDate, $email, $startTime2) {
    
	$doc = new DomDocument('1.0');
    $doc->load('../../data/customer.xml');
    $customer = $doc->getElementsByTagName("customer");
	$customerId ; 
    foreach ($customer as $node) {
        $custemail = $node->getElementsByTagName("email")->item(0)->nodeValue;
        if ($custemail == $email) {
            $customerId = $node->getElementsByTagName("custnum")->item(0)->nodeValue;;
        }
    }
	
	
	$doc2 = new DomDocument('1.0');

    $root = $doc2->createElement('items');
    $root = $doc2->appendChild($root);

    $totalitems = $doc2->createElement('totalitems');
    $totalitems = $root->appendChild($totalitems);
    $value = $doc2->createTextNode("1");
    $value = $totalitems->appendChild($value);


    $item = $doc2->createElement('item');
    $item = $root->appendChild($item);

    $inamenode = $doc2->createElement('itemname');
    $inamenode = $item->appendChild($inamenode);
    $value = $doc2->createTextNode($itemname);
    $value = $inamenode->appendChild($value);

    $idescnode = $doc2->createElement('description');
    $idescnode = $item->appendChild($idescnode);
    $value = $doc2->createTextNode($description);
    $value = $idescnode->appendChild($value);

    $cidnode = $doc2->createElement('customerid');
    $cidnode = $item->appendChild($cidnode);
    $value = $doc2->createTextNode($customerId);
    $value = $cidnode->appendChild($value);

    $itemnumnode = $doc2->createElement('itemnum');
    $itemnumnode = $item->appendChild($itemnumnode);
    $value = $doc2->createTextNode("1");
    $value = $itemnumnode->appendChild($value);


    $categorynode = $doc2->createElement('category');
    $categorynode = $item->appendChild($categorynode);
    $value = $doc2->createTextNode($category);
    $value = $categorynode->appendChild($value);

	$timestampnode = $doc2->createElement('timestamp');
    $timestampnode = $item->appendChild($timestampnode);
    $value = $doc2->createTextNode($startTime2);
    $value = $timestampnode->appendChild($value);
	
	
    $spricenode = $doc2->createElement('startprice');
    $spricenode = $item->appendChild($spricenode);
    $value = $doc2->createTextNode($startPrice);
    $value = $spricenode->appendChild($value);

    $rpricenode = $doc2->createElement('reserveprice');
    $rpricenode = $item->appendChild($rpricenode);
    $value = $doc2->createTextNode($reservePrice);
    $value = $rpricenode->appendChild($value);	
	
    $bpricenode = $doc2->createElement('buyprice');
    $bpricenode = $item->appendChild($bpricenode);
    $value = $doc2->createTextNode($buyPrice);
    $value = $bpricenode->appendChild($value);

    $durationnode = $doc2->createElement('duration');
    $durationnode = $item->appendChild($durationnode);
    $value = $doc2->createTextNode($duration);
    $value = $durationnode->appendChild($value);
	
    $statusnode = $doc2->createElement('status');
    $statusnode = $item->appendChild($statusnode);
    $value = $doc2->createTextNode($status);
    $value = $statusnode->appendChild($value);

    $sdatenode = $doc2->createElement('startdate');
    $sdatenode = $item->appendChild($sdatenode);
    $value = $doc2->createTextNode($startDate);
    $value = $sdatenode->appendChild($value);
		
    $biddernode= $doc2->createElement('bidderid');
    $biddernode = $item->appendChild($biddernode);
    $value = $doc2->createTextNode("");
    $value = $biddernode->appendChild($value);

    $bidpricenode = $doc2->createElement('bidprice');
    $bidpricenode = $item->appendChild($bidpricenode);
    $value = $doc2->createTextNode($startPrice);
    $value = $bidpricenode->appendChild($value);

	
    $stimenode = $doc2->createElement('starttime');
    $stimenode = $item->appendChild($stimenode);
    $value = $doc2->createTextNode($startTime);
    $value = $stimenode->appendChild($value);
		
    $strXml = $doc2->save("../../data/auction.xml");
    return array("success" => true, "password" => $value->nodeValue, "itemnum" => "1");
}

function appendCustomerXML($itemname, $description, $category, $startPrice, $reservePrice, $buyPrice, $duration, $status, $startTime, $startDate, $email, $startTime2) {
    $doc = new DomDocument('1.0');
    $doc->load('../../data/customer.xml');
    $customer = $doc->getElementsByTagName("customer");
	$customerId ; 
    foreach ($customer as $node) {
        $custemail = $node->getElementsByTagName("email")->item(0)->nodeValue;
        if ($custemail == $email) {
            $customerId = $node->getElementsByTagName("custnum")->item(0)->nodeValue;;
        }
    }

	
	$doc2 = new DomDocument('1.0');
    $doc2->load('../../data/auction.xml');
    $item = $doc2->getElementsByTagName("item");
	
    $root = $doc2->getElementsByTagName("items")->item(0);
    $itemnum = $doc2->getElementsByTagName("totalitems")->item(0)->nodeValue++;

   
    $item = $doc2->createElement('item');
    $item = $root->appendChild($item);

    $inamenode = $doc2->createElement('itemname');
    $inamenode = $item->appendChild($inamenode);
    $value = $doc2->createTextNode($itemname);
    $value = $inamenode->appendChild($value);

    $idescnode = $doc2->createElement('description');
    $idescnode = $item->appendChild($idescnode);
    $value = $doc2->createTextNode($description);
    $value = $idescnode->appendChild($value);

    $cidnode = $doc2->createElement('customerid');
    $cidnode = $item->appendChild($cidnode);
    $value = $doc2->createTextNode($customerId);
    $value = $cidnode->appendChild($value);

    $itemnumnode = $doc2->createElement('itemnum');
    $itemnumnode = $item->appendChild($itemnumnode);
    $value = $doc2->createTextNode($itemnum + 1);
    $value = $itemnumnode->appendChild($value);


    $categorynode = $doc2->createElement('category');
    $categorynode = $item->appendChild($categorynode);
    $value = $doc2->createTextNode($category);
    $value = $categorynode->appendChild($value);

	$timestampnode = $doc2->createElement('timestamp');
    $timestampnode = $item->appendChild($timestampnode);
    $value = $doc2->createTextNode($startTime2);
    $value = $timestampnode->appendChild($value);
	
    $spricenode = $doc2->createElement('startprice');
    $spricenode = $item->appendChild($spricenode);
    $value = $doc2->createTextNode($startPrice);
    $value = $spricenode->appendChild($value);

    $rpricenode = $doc2->createElement('reserveprice');
    $rpricenode = $item->appendChild($rpricenode);
    $value = $doc2->createTextNode($reservePrice);
    $value = $rpricenode->appendChild($value);	
	
    $bpricenode = $doc2->createElement('buyprice');
    $bpricenode = $item->appendChild($bpricenode);
    $value = $doc2->createTextNode($buyPrice);
    $value = $bpricenode->appendChild($value);

    $durationnode = $doc2->createElement('duration');
    $durationnode = $item->appendChild($durationnode);
    $value = $doc2->createTextNode($duration);
    $value = $durationnode->appendChild($value);
	
    $statusnode = $doc2->createElement('status');
    $statusnode = $item->appendChild($statusnode);
    $value = $doc2->createTextNode($status);
    $value = $statusnode->appendChild($value);

    $sdatenode = $doc2->createElement('startdate');
    $sdatenode = $item->appendChild($sdatenode);
    $value = $doc2->createTextNode($startDate);
    $value = $sdatenode->appendChild($value);
		

    $biddernode= $doc2->createElement('bidderid');
    $biddernode = $item->appendChild($biddernode);
    $value = $doc2->createTextNode("");
    $value = $biddernode->appendChild($value);

    $bidpricenode = $doc2->createElement('bidprice');
    $bidpricenode = $item->appendChild($bidpricenode);
    $value = $doc2->createTextNode($startPrice);
    $value = $bidpricenode->appendChild($value);

		
    $stimenode = $doc2->createElement('starttime');
    $stimenode = $item->appendChild($stimenode);
    $value = $doc2->createTextNode($startTime);
    $value = $stimenode->appendChild($value);
	
	$strXml = $doc2->save('../../data/auction.xml');
    return array("success" => true, "itemnum" => $itemnum + 1);
}

?> 