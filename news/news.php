<ul>
<?php

require_once('sites/all/soap/nusoap.php');
if(!isset($wsdl)){ $wsdl = "http://ascnet.osu.edu/newstool/News.cfc?wsdl"; }

if(!isset($news_query_name)) { $news_query_name = "selNewsSiteHeadline"; }
if(!isset($n_param)){
	if(!isset($siteid)) { echo "<li>Error: SiteID was not specified.</li>"; $siteid = 1; }
	if(!isset($orderDirection)) { 
		$n_param = array('SiteID' => $siteid);
	}else{
		$n_param = array('SiteID' => $siteid, 'orderDirection' => $orderDirection);
	}
}

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client->call($news_query_name, $n_param);
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
			echo $result['data'][$i][3];
			echo '</a> - <em>Posted on ';
			echo date('m/d/Y', strtotime($result['data'][$i][2]));
			echo '</li></em>';
		echo '<div style="height: 9px;">&nbsp;</div>';
		$i+=1;
		}
	}else{
		echo '<li>No Entries.</li>';
	}
}
	
?>
</ul>