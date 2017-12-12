<?php 
session_start();
$email = $_SESSION['user_email'];
$doc = new DomDocument('1.0');
    $doc->load('../../data/customer.xml');
    $customer = $doc->getElementsByTagName("customer");
	$customerId ; 
    foreach ($customer as $node) {
        $custemail = $node->getElementsByTagName("email")->item(0)->nodeValue;
        if ($custemail == $email) {
            $customerId = $node->getElementsByTagName("custnum")->item(0)->nodeValue;
        }
    }
if (file_exists("../../data/auction.xml")) {

if (isset($_GET['action']) && $_GET['action'] == "bid" ) 
{
	

	$itemId = $_GET['itemid'] ;
	$ubidprice = $_GET['bid'];
	$doc2 = new DomDocument('1.0');
    $doc2->load('../../data/auction.xml');
	$itemno ;
	$item = $doc2->getElementsByTagName("item");
	$echo = "Thank you, your bid has been placed" ;
    foreach ($item as $node) {
        $itemno = trim($node->getElementsByTagName("itemnum")->item(0)->nodeValue);
        if ($itemno == $itemId) {
			
			
			$cbidprice = $node->getElementsByTagName("bidprice")->item(0)->nodeValue;
			if($cbidprice >= $ubidprice){
				
				$echo ="Sorry your bid is not valid";
			}
			else
			{
            
				$node->getElementsByTagName("bidprice")->item(0)->nodeValue = $ubidprice;
				$node->getElementsByTagName("bidderid")->item(0)->nodeValue = $customerId;
			}
			//break ;
		}
    }
	

	
	$strXml = $doc2->save('../../data/auction.xml');	
	
	
	echo $echo;
}
else if (isset($_GET['action']) && $_GET['action'] == "buy")
{
	$itemId = $_GET['itemid'] ; 	
	$doc2 = new DomDocument('1.0');
    $doc2->load('../../data/auction.xml');
	$itemno ;
	$item = $doc2->getElementsByTagName("item");
	
    foreach ($item as $node) {
        $itemno = trim($node->getElementsByTagName("itemnum")->item(0)->nodeValue);
        if ($itemno == $itemId) {
			$buyprice = $node->getElementsByTagName("buyprice")->item(0)->nodeValue;
            $node->getElementsByTagName("status")->item(0)->nodeValue = "sold";
		    $node->getElementsByTagName("bidprice")->item(0)->nodeValue = $buyprice;
			$node->getElementsByTagName("bidderid")->item(0)->nodeValue = $customerId;
		
			//break ;
		}
    }
	

	
	$strXml = $doc2->save('../../data/auction.xml');	
	
	echo "Thank you for purchasing this item". $itemId ;
}



}
else
{
	echo "no record found " ;
}
?>