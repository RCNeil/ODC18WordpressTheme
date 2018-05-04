<?php
	
	$postID = $_POST['id'];
	$deplat = $_POST['deplat'];
	$deplng = $_POST['deplng'];
	$destlat = $_POST['destlat'];
	$destlng = $_POST['destlng'];
	
	if($destlat >= 39.70232916628726 || $deplat >= 39.70232916628726) :
		$distance = 3;
	else:
		$distance = 5;
	endif;
	
	//DEPARTURE
	$destURL1 = 'http://firstmap.gis.delaware.gov/arcgis/rest/services/Transportation/DE_Transit/FeatureServer/4/query' . 
		'?where=1%3D1&outFields=LINENAME,LINEID' .
		'&geometry=' . $deplng . '%2C' . $deplat . 
		'&geometryType=esriGeometryPoint' .
		'&inSR=4326' . 
		'&spatialRel=esriSpatialRelIntersects' .		
		'&distance=' . $distance . '&units=esriSRUnit_StatuteMile' . 
		'&returnGeometry=false&returnDistinctValues=true'. 
		'&outSR=4326&f=json';
	$point1 = json_decode(file_get_contents($destURL1), true);	
	
	//DESTINATION
	$destURL2 = 'http://firstmap.gis.delaware.gov/arcgis/rest/services/Transportation/DE_Transit/FeatureServer/4/query' . 
		'?where=1%3D1&outFields=LINENAME,LINEID' .
		'&geometry=' . $destlng . '%2C' . $destlat . 
		'&geometryType=esriGeometryPoint' .
		'&inSR=4326' . 
		'&spatialRel=esriSpatialRelIntersects' .		
		'&distance=' . $distance . '&units=esriSRUnit_StatuteMile' .
		'&returnGeometry=false&returnDistinctValues=true'. 
		'&outSR=4326&f=json';
	$point2 = json_decode(file_get_contents($destURL2), true);
	
	$points = array_uintersect($point2['features'], $point1['features'], 'compareLineNames');
	
	function compareLineNames($linename1, $linename2)	{
	   return strcmp(serialize($linename1),serialize($linename2));
	}
	
	if(empty($points)) :
		return false;
	else:
		header('Content-type:application/json'); 
		$json = array();
		foreach($points as $ride) : 
			$json[] = $ride;
		endforeach;
		echo json_encode($json);
	endif;
?>