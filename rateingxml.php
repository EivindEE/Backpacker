<?php
		
		
	$id = $_GET['id'];

	require("userid.php");
		function parseToXML($htmlStr) 
		{ 
		$xmlStr=str_replace('<','&lt;',$htmlStr); 
		$xmlStr=str_replace('>','&gt;',$xmlStr); 
		$xmlStr=str_replace('"','&quot;',$xmlStr); 
		$xmlStr=str_replace("'",'&#39;',$xmlStr); 
		$xmlStr=str_replace("&",'&amp;',$xmlStr);
		return $xmlStr; 
		

		} // Opens a connection to a MySQL server
		$connection=mysql_connect ('hoguslg.uib.no:3306', $username, $password);
		if (!$connection) {
		  die('Not connected : ' . mysql_error());
		}// Set the active MySQL database
		$db_selected = mysql_select_db($database, $connection);
		if (!$db_selected) {
		  die ('Can\'t use db : ' . mysql_error());
		}// Select all the rows in the markers table
		$query ="
				SELECT p.id, p_name, link, p.region, lon, lat, place_type
				FROM place p, place_type pt
				WHERE pt.place = p.id AND p.region = " . $id . " 
				GROUP BY p.id";
				
				
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query: ' . mysql_error());
		}	
		
	header("Content-type:text/xml");
	// Starter XML
	echo'<journeys>';
	// Iterate through the rows, printing XML nodes for each
	while ($row = @mysql_fetch_assoc($result)){
	  // ADD TO XML DOCUMENT NODE
	  echo '<journey ';
	  echo utf8_encode('name="' . parseToXML($row['p_name']) . '" ');
	  echo utf8_encode('info="' . parseToXML($row['link']) . '" ');
	  echo 'lat="' . $row['lat'] . '" ';
	  echo 'lng="' . $row['lon'] . '" ';
	  echo 'type="' . $row['place_type'] . '" ';
	  echo '/>';
	}
	// End XML file
	echo '</journeys>';


	?>