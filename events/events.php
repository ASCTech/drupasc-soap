<ul>
<?php

require_once('sites/all/soap/nusoap.php');
$wsdl = "http://ascnet.osu.edu/eventtool/Event.cfc?wsdl";

if(!isset($event_query_name)) { $event_query_name = "selEventSite"; }
if(!isset($e_param)){
	if(!isset($siteid)) { echo "<li>Error: SiteID was not specified.</li>"; $siteid = 1; }
	if(!isset($orderDirection)) { 
		$e_param = array('SiteID' => $siteid);
	}else{
		$e_param = array('SiteID' => $siteid, 'orderDirection' => $orderDirection);
	}
}

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client -> call($event_query_name, $e_param);
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
			echo date('m/d/Y h:i A', strtotime($result['data'][$i][2]));
			echo '</a> - ';
			echo $result['data'][$i][5];
			echo '</li>';	
		echo '<div style="height: 9px;">&nbsp;</div>';
		$i+=1;
		}
	}else{
		echo '<li>No Entries.</li>';
	}
}
	
?>
</ul>