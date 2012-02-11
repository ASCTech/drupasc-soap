<?php

require_once('sites/all/soap/nusoap.php');
$wsdl = "http://ascnet.osu.edu/newstool/News.cfc?wsdl";
$newsid = $_GET['NewsID'];
$param = array('NewsID' => $newsid);

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client->call('selNews', $param);
	$err = $client->getError();
	if($err) {
		echo "<h2>Error!</h2>\n<p>Sorry, there was an error with your request.  Error details follow:<br />",$err,"</p>\n";
	} else {
		output_single_news_results($result);
	}
} catch (Exception $e) {
	echo "<h2>Error!</h2>\n<p>Sorry, there was an error with your request.  Error details follow:<br />",$e->message(),"</p>\n";
}

function output_single_news_results($result) {
	echo "<p><strong>Posted on:</strong>",date('m/d/Y', strtotime($result['data'][0][2]));
	echo $result['data'][0][5];
}

?>