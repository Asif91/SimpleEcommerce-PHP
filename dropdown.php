<?php
header('Content-Type: text/xml');
if (file_exists("../../data/auction.xml")) {

 $doc = new DomDocument('1.0');
    $doc->load('../../data/auction.xml');
    $item = $doc->getElementsByTagName("item");
	$categories = ""; 
	$comm = "";
    foreach ($item as $node) {
        $itemcategory = $node->getElementsByTagName("category")->item(0)->nodeValue ;
        $categories .= $comm.$itemcategory;
		$comm =",";
    }
	echo $categories;
}
else 
{
	echo "none" ; 
}
?>