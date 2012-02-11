
<?php


require_once('sites/all/soap/nusoap.php');
$wsdl = "http://ascnet.osu.edu/eventtool/Programs.cfc?wsdl";

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client -> call('getFootnotes');
	$err = $client -> getError();
	if($err) {
		echo "<li><h2>Error!</h2>\n<p>Error details:<br />",$err,"</p></li>\n";
	} else {
	//print_r ($result['data'][1]);
	//print (strlen($result['data'][3][2]));
		output_all_footnotes($result);
	}
} catch (Exception $e) {
	echo "<li><h2>Error!</h2>\n<p>Error details:<br />",$e->message(),"</p></li>\n";
}

function output_all_footnotes($result) {

	$numfootnotes = count($result['data']);

	$i =0;
	echo '<div style="clear:both;"></div> <br/><br/>';
	if($numfootnotes > 0){
	
		while ($i <=  $numfootnotes){
			echo '<sup>';
			echo $result['data'][$i][0]; //footnotenumber
			echo '</sup>'; 
			echo $result['data'][$i][4]; // footnote
			//echo '</li>';
	
		echo '<br />';
		$i+=1;
		}
	}
	
	
	
	
}
	
?>
