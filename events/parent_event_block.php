<ul>
<?php
if(!isset($siteid)) { echo "<li>Error: SiteID was not specified.</li>"; $siteid = 1; }
if(!isset($maxevents)) { $maxevents = 3; }
if(!isset($reverse_order)) { $reverse_order = 0; }

require_once('../nusoap.php');
$wsdl = "http://ascnet.osu.edu/eventtool/Event.cfc?wsdl";
$param = array('SiteID' => $siteid);

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client -> call('selEventParentSiteAnnouncement', $param);
	$err = $client->getError();
	if($err) {
		echo "<h2>Error!</h2>\n<li>Error details:<br />",$err,"</li><li class='viewall'>&nbsp;</li>\n";
	} else {
		output_block_events_results($result, $maxevents, $reverse_order);
	}
} catch (Exception $e) {
	echo "<h2>Error!</h2>\n<li>Error details:<br />",$e->message(),"</li><li class='viewall'>&nbsp;</li>\n";
}

function output_block_events_results($result, $maxevents, $reverse_order) {

	$numevents = count($result['data']);

	$i = 0;
	if($numevents > 0){
		$event_items = array();
		while ($i < $maxevents &&  $i < $numevents){
			$text = "<li><a href='".url()."dsp_event?EventID=";
			$text .= $result['data'][$i][0];
			$text .= "' target='_top' class='headlineLink' title='Find Out More'>";
			$text .= date('m/d/Y', strtotime($result['data'][$i][3]));
			$text .= '</a> - ';
			$text .= $result['data'][$i][2];
			$text .= '</li>';
			$event_items[$i] = $text;
			$i++;
		}
		if($reverse_order){
			for($i = count($event_items)-1; $i>=0; $i--){ echo $event_items[$i]; }
		}else{
			for($i=0; $i<count($event_items); $i++){ echo $event_items[$i]; }
		}
	}else{
		echo '<li>No Entries.</li>';
	}

	if($numevents > 0){
		echo "<li class='viewall'><a href='events' target='_top' title='View all events' class='headlineLink' >More Events...</a></li>";
	} else {
		echo "<li class='viewall'>&nbsp;</li>";
	}

}

?>
</ul>
