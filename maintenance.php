<?php 

session_start();
$email = $_SESSION['user_email'];
if (file_exists("../../data/auction.xml")) {

   
if (isset($_GET['action']) && $_GET['action'] == "processitems" ) 
{
	$doc = new DomDocument('1.0');
    $doc->load('../../data/auction.xml');	
$item = $doc->getElementsByTagName("item");
	$echo = "Items are processed" ;
    foreach ($item as $node) {
    		
			
			$status = $node->getElementsByTagName("status")->item(0)->nodeValue;
			if($status == "in_progress"){
				
				$duration = $node->getElementsByTagName("duration");
				$duration = $duration->item(0)->nodeValue;
				$startTime = $node->getElementsByTagName("starttime");
				$startTime = $startTime->item(0)->nodeValue;
				
				$timenow = time();
				$rrtime = $duration - ($timenow - $startTime ) ;
				if($rrtime<11)
				{
					//$echo  = $rrtime ;
					$reserveprice = $node->getElementsByTagName("reserveprice")->item(0)->nodeValue ;
					$cbidprice = $node->getElementsByTagName("bidprice")->item(0)->nodeValue ;
					
					if($cbidprice <= $reserveprice)
					{
					//	$echo  = "comparison" ;
						$node->getElementsByTagName("status")->item(0)->nodeValue = "failed";
						
						
					}
					else
					{
						$node->getElementsByTagName("status")->item(0)->nodeValue = "sold";
						
					}
				}
				

			}

			
		}
    
	

	
	$strXml = $doc->save('../../data/auction.xml');	
	
	
	echo $echo;
}
else if (isset($_GET['action']) && $_GET['action'] == "generatereports" ) 
{
	
	
    $xml = new DOMDocument;
    $xml->load("../../data/auction.xml");

    $xsl = new DOMDocument;
    $xsl->load("revenue.xsl");

    //Configure the transformer
    $proc = new XSLTProcessor;
    $proc->importStyleSheet($xsl); // attach the xsl rules
	$echo  = $proc->transformToXML($xml);

	$nodesToDelete = array(); 
	$s = "ss" ;
	$doc = new DomDocument('1.0');
    $doc->load('../../data/auction.xml');
    $item = $doc->getElementsByTagName("item");
    foreach ($item as $node) 
	{
        $status = $node->getElementsByTagName("status")->item(0)->nodeValue;
        if ($status == "failed" || $status =="sold" ) 
		{
			
		//	$s = "failed";
			$nodesToDelete[] = $node; 

			
		}
    }

	foreach($nodesToDelete as $nodeD)
	{
		
		$c = $doc->getElementsByTagName("totalitems")->item(0)->nodeValue  ;
			 $doc->getElementsByTagName("totalitems")->item(0)->nodeValue = $c -1 ;
			  
			$nodeD->parentNode->removeChild($nodeD);
		//	$node = $n ;
		
	}
	
	$strXml = $doc->save('../../data/auction.xml');	
	
	echo $echo ;

}
else
{
	echo "operation failed" ;
}
}
else
{
	echo "No Records available";
}
?>