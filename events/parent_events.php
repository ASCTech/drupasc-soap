<ul>
<?php

if(!isset($siteid)) { echo "<li>Error: SiteID was not specified.</li>"; $siteid = 1; }

require_once('sites/all/soap/nusoap.php');
$wsdl = "http://ascnet.osu.edu/eventtool/Event.cfc?wsdl";
if(!isset($orderDirection)) { 
	$param = array('SiteID' => $siteid);
}else{
	$param = array('SiteID' => $siteid, 'orderDirection' => $orderDirection);
}

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client -> call('selEventParentSite', $param);
	$err = $client -> getError();
	if($err) {
		echo "<li><h2>Error!</h2>\n<p>Error details:<br />",$err,"</p></li>\n";
	} else {
		output_all_events_results($result);
	}
} catch (Exception $e) {
	echo "<li><h2>Error!</h2>\n<p>Error details:<br />",$e->message(),"</p></li>\n";
}

function output_all_events_results($result) {

	$numevents = count($result['data']);

	$i =0;
	if($numevents > 0){
		while ($i <  $numevents){
			echo "<li><a href='dsp_event?EventID=";
			echo $result['data'][$i][0] ;
			echo "' target='_top' class='headlineLink' title='Find Out More'>";
			echo date('m/d/Y h:i A', strtotime($result['data'][$i][3]));
			echo '</a> - ';
			echo $result['data'][$i][2];
			echo '</li>';
	
		echo '<br />';
		$i+=1;
		}
	}else{
		echo '<li>No Entries.</li>';
	}
}
	
?>
</ul>