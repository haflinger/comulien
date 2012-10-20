<?php
	$uicGare = (isset($_POST['uicGare'])) ? $_POST['uicGare']: '87545269';

	$dom = new DomDocument();
	$dom->load  ('http://tnhtn45:JhVbn41C@api.transilien.com/gare/' . $uicGare . '/depart');

	$trainsXML = $dom->getElementsByTagName('train');
	$trains = array();
	foreach($trainsXML as $trainXML)
	{
		$train['date'] = $trainXML->getElementsByTagName('date')->item(0)->nodeValue;
		$train['num'] = $trainXML->getElementsByTagName('num')->item(0)->nodeValue;
		$train['mission'] = $trainXML->getElementsByTagName('miss')->item(0)->nodeValue;
		$train['terminusUIC'] = $trainXML->getElementsByTagName('term')->item(0)->nodeValue;
		$trains[] = $train;
	}
		
	$json = json_encode($trains);
	echo $json;
?>