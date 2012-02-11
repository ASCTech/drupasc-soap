<?php

require_once('sites/all/soap/nusoap.php');
$wsdl = "http://ascnet.osu.edu/eventtool/Event.cfc?wsdl";
$eventid = $_GET['EventID'];
$param = array('EventID' => $eventid);

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client->call('selEvent', $param);
	$err = $client->getError();
	if($err) {
		echo "<h2>Error!</h2>\n<p>Error details:<br />",$err,"</p>\n";
	} else {
		output_single_events_results($result);
	}
} catch (Exception $e) {
	echo "<h2>Error!</h2>\n<p>Error details:<br />",$e->message(),"</p>\n";
}

function output_single_events_results($result) {
	echo "<h2>".$result['data'][0][5]."</h2>";
	echo "<p><strong>Date:</strong><br/>"; 
	echo date('m/d/Y', strtotime($result['data'][0][2]));//date

	echo "</p><p> <strong>Time:</strong><br />";
	echo date('h:i A',strtotime($result['data'][0][2]));
	if ($result['data'][0][2] != $result['data'][0][3]) {
		echo " - ".date('h:i A',strtotime($result['data'][0][3])); 
	}
	echo "</p><p><strong>Location:</strong><br />";
	echo $result['data'][0][4];
	echo "</p><p><strong>Description:</strong><br />";
	echo $result['data'][0][6];

	echo "</p><p><strong>Contact:</strong><br />";
	echo $result['data'][0][7];
	echo "</p>";
}

?>