<?php
 if (file_exists("../../data/auction.xml")) {

 $xmlFile = "../../data/auction.xml";
 $HTML = "";
 $count = 0;
 //$dt = simplexml_load_file($xmlFile);
 $dom = DOMDocument::load($xmlFile);

 $itemnums = $dom->getElementsByTagName("totalitems")->item(0)->nodeValue;
 
 function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}
 
 if($itemnums > 0 )
 {
 
	$item = $dom->getElementsByTagName("item"); 
 

$count = 1 ;
foreach($item as $node) 
{ 
     $itemno = $node->getElementsByTagName("itemnum");
     $itemno = $itemno->item(0)->nodeValue;
  
	 $itemname = $node->getElementsByTagName("itemname");
	 $itemname = $itemname->item(0)->nodeValue;
	 
	 $category = $node->getElementsByTagName("category");
	 $category = $category->item(0)->nodeValue;
	 
	 $description = $node->getElementsByTagName("description");
	 $description = $description->item(0)->nodeValue;
	 
	 $buyprice = $node->getElementsByTagName("buyprice");
	 $buyprice = $buyprice->item(0)->nodeValue;
	 
	 $bidprice = $node->getElementsByTagName("bidprice");
	 $bidprice = $bidprice->item(0)->nodeValue;
	 
	 $startTime = $node->getElementsByTagName("starttime");
	 $startTime = $startTime->item(0)->nodeValue;
	 
	 $duration = $node->getElementsByTagName("duration");
	 $duration = $duration->item(0)->nodeValue;
	 
	 $status = $node->getElementsByTagName("status");
	 $status = $status->item(0)->nodeValue;
	 
	 if(strlen($description) > 30)
	 {
		 $description = substr($description,30)."....";
	 }
	 
	 $timenow = time();
	 $rrtime = $duration - ($timenow - $startTime ) ;
	 if($rrtime > 12)
	 {
		$remainingTime = secondsToTime($duration - ($timenow - $startTime )) ;
	 }
	 else 
	 {
		 $remainingTime = "Time over ";
	 }
	 if(trim($status) != "sold" && $rrtime > 12)
	 {
		 $HTML = $HTML."<div ><br><form class ='form-style-5'><span>ItemNo: ".$itemno."</span><br><span>item Name: ".$itemname."</span><br><span>Category : ".$category."</span><br><span>Description: ".$description."</span><br><span>Buy Price: ".$buyprice."</span><br><span>Current Bid Price: ".$bidprice."</span><br><span>Remaining time: ".$remainingTime.'</span></legend><br><button id ="'. $itemno .'" onclick="placebid(this.id)">PlaceBid</button> <button id ="'. $itemno .'" onclick="buynow(this.id)" >BuyNow</button><br></form></div>'; 
	 }
	 else if(trim($status) != "sold" && $rrtime < 12)
	 {
		  $HTML = $HTML."<div><br><form class ='form-style-5'><span>ItemNo: ".$itemno."</span><br><span>item Name: ".$itemname."</span><br><span>Category : ".$category."</span><br><span>Description: ".$description."</span><br><span>Buy Price: ".$buyprice."</span><br><span>Current Bid Price: ".$bidprice."</span><br><span>Remaining time: 0</span></legend><br><span>Time Expired</span></form><br></div>";
	 }		 
	 else 
	 {
		  $HTML = $HTML."<div><br><form class ='form-style-5'><span>ItemNo: ".$itemno."</span><br><span>item Name: ".$itemname."</span><br><span>Category : ".$category."</span><br><span>Description: ".$description."</span><br><span>Buy Price: ".$buyprice."</span><br><span>Current Bid Price: ".$bidprice."</span><br><span>Remaining time: 0 </span><br><span>Item has been Sold</span></form><br></div>";
	 }		 		
	 $count = $count + 1 ;
}
 }
else 
 {
   $HTML ="<br><span>No Items available</span>";
 }
           
  echo $HTML;   

 }
else
{
	
	echo "No Record Found";
}	
  ?>

