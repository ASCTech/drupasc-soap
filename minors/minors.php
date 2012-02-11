
<?php


require_once('sites/all/soap/nusoap.php');
$wsdl = "http://ascnet.osu.edu/eventtool/Programs.cfc?wsdl";

try {
	$client = new soapclient($wsdl, 'wsdl');
	$result = $client -> call('getMinorsList');
	$err = $client -> getError();
	if($err) {
		echo "<li><h2>Error!</h2>\n<p>Error details:<br />",$err,"</p></li>\n";
	} else {
	//print_r ($result['data'][3]);
	//print (strlen($result['data'][3][2]));
		output_all_minors_results($result);
	}
} catch (Exception $e) {
	echo "<li><h2>Error!</h2>\n<p>Error details:<br />",$e->message(),"</p></li>\n";
}

function output_all_minors_results($result) {

	$numminors = count($result['data']);

	$i =0;
	echo '<div id="left" style="float:left;width:49%;">';
	if($numminors > 0){
		//calculate halfway point
		$halfcount = $numminors/2 ;
		while ($i <=  $halfcount){
			if( strlen($result['data'][$i][8]) > 0) //if filename has data
				{
					echo "<a href='http://ascnet.osu.edu/global/shared/major_minors/" ;
					echo $result['data'][$i][8] ; //filename
					echo "'>";
				}
			else
				{
					echo $result['data'][$i][8] ; //filename
				}
			echo $result['data'][$i][5]; //friendlyname
			echo '</a> - ';
			echo '<sup>';
			echo $result['data'][$i][6]; //footnote
			echo '</sup>'; 
			echo $result['data'][$i][0]; // unitnum
			//echo '</li>';
	
		echo '<br />';
		$i+=1;
		}
	}
	echo '</div>';
	
	
	
	echo '<div id="right" style="float:right;width:49%">';
	if($numminors > 0){
		while ($i <  $numminors){
			if( strlen($result['data'][$i][8]) > 0) //if filename has data
				{
					echo "<a href='http://ascnet.osu.edu/global/shared/major_minors/" ;
					echo $result['data'][$i][8] ; //filename
					echo "'>";
				}
			else
				{
					echo $result['data'][$i][8]; //filename
				}
			echo $result['data'][$i][5]; //friendlyname
			echo '</a> - ';
			echo '<sup>';
			echo $result['data'][$i][6]; //footnote
			echo '</sup>'; 
			echo $result['data'][$i][0]; // unitnum
			//echo '</li>';
	
		echo '<br />';
		$i+=1;
		}
	}
	echo '</div>';
}
	
?>
