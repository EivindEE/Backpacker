<?php
	
	

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
				SELECT DISTINCT a_name, lon, lat, info ,journey_index
				FROM journey,region reg 
				WHERE journey_index =1 AND (journey_from=reg.id OR journey_to=reg.id)
				GROUP BY a_name";
				
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
	  echo utf8_encode('name="' . parseToXML($row['a_name']) . '" ');
	  echo utf8_encode('info="' . parseToXML($row['info']) . '" ');
	  echo 'lat="' . $row['lat'] . '" ';
	  echo 'lng="' . $row['lon'] . '" ';
	  echo 'type="' . $row['journey_index'] . '" ';
	  echo '/>';
	}
	// End XML file
	echo '</journeys>';


	?>