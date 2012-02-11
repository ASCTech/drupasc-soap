<ul>
<?php
if(!isset($siteid)) { echo "<li>Error: SiteID was not specified.</li>"; $siteid = 1; }
if(!isset($maxnews)) { $maxnews = 3; }

require_once('../nusoap.php');
$wsdl="http://ascnet.osu.edu/newstool/News.cfc?wsdl";

if(!isset($orderDirection)) { 
	$param = array('SiteID' => $siteid);
}else{
	$param = array('SiteID' => $siteid, 'orderDirection' => $orderDirection);
}
try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client->call('selNewsParentSiteHeadline', $param);
	$err = $client->getError();
	if($err) {
		echo "<h2>Error!</h2>\n<li>Error details:<br />",$err,"</li><li class='viewall'>&nbsp;</li>\n";
	} else {
		output_block_news_results($result, $maxnews);
	}
} catch (Exception $e) {
	echo "<h2>Error!</h2>\n<li>Error details:<br />",$e->message(),"</li>\n";
}

function output_block_news_results($result, $maxnews) {
	$numevents = count($result['data']);

	$i = 0;
	if($numevents > 0){
		while ($i < $maxnews &&  $i < $numevents){
			echo "<li><a href='",url(),"dsp_news?NewsID=";
			echo $result['data'][$i][0] ;
			echo "' target='_top' class='headlineLink' title='Find Out More'>";
			echo $result['data'][$i][1];
			echo '</a> - <em>',date('m/d/Y', strtotime($result['data'][$i][3])),'</em>';
			echo '</li>';
			$i++;
		}
		echo "<li class='viewall'><a href='news' target='_top' title='View all news' class='headlineLink' >More News...</a></li>";
	}else{
		echo '<li>No Entries.</li>';
		echo "<li class='viewall'>&nbsp;</li>";
	}
}

?>
</ul>
