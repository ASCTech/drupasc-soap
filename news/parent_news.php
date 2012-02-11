<ul>
<?php

if(!isset($siteid)) { echo "<li>Error: SiteID was not specified.</li>"; $siteid = 1; }

require_once('sites/all/soap/nusoap.php');
if(!isset($wsdl)){ $wsdl = "http://ascnet.osu.edu/newstool/News.cfc?wsdl"; }
if(!isset($orderDirection)) { 
	$param = array('SiteID' => $siteid);
}else{
	$param = array('SiteID' => $siteid, 'orderDirection' => $orderDirection);
}

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client->call('selNewsParentSite', $param);
	$err = $client->getError();
	if($err) {
		echo "<h2>Error!</h2>\n<p>Sorry, there was an error with your request.  Error details follow:<br />",$err,"</p>\n";
	} else {
		output_all_news_results($result);
	}
} catch (Exception $e) {
	echo "<h2>Error!</h2>\n<p>Sorry, there was an error with your request.  Error details follow:<br />",$e->message(),"</p>\n";
}

function output_all_news_results($result) {
	$numevents = count($result['data']);
	$i =0;
	if($numevents > 0){
		while ($i <  $numevents){
			echo "<li><a href='dsp_news?NewsID=";
			echo $result['data'][$i][0] ;
			echo "' target='_top' class='headlineLink' title='Find Out More'>";
			echo $result['data'][$i][1];
			echo '</a> - <em>Posted on ';
			echo date('m/d/Y', strtotime($result['data'][$i][3]));
			echo '</li></em>';
		echo '<br />';
		$i+=1;
		}
	}else{
		echo '<li>No Entries.</li>';
	}
}
	
?>
</ul>