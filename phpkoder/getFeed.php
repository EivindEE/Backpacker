<?php 
include('database.php');
include('functions.php');

friendfeed('Torstein', 'frontpage', '0');

/* generate update feeds */
function friendfeed($input, $type, $number) {
	// if friendfeed on user profile
	if($type == 'user') {
		$reviewQuery = retrive_from_db("uname, email, place, region, DATE_FORMAT(date, '%d. %M %Y - %H:%i'), date as timestamp, review_text, grade", 'review, user','writer = uname AND writer = "' . $input . '" ORDER BY date DESC'); 
		$locationQuery = retrive_from_db("u.uname, email, id as place, DATE_FORMAT(date, '%d. %M %Y - %H:%i'), date as timestamp", 'place p, user u','p.uname = u.uname AND u.uname = "' . $input . '" ORDER BY date DESC');
		
		return $output;
	}
	// if friendfeed on fronpage (for logged in user)
	else if($type == 'frontpage') {
		$reviewQuery = retrive_from_db("uname, email, place, region, DATE_FORMAT(date, '%d. %M %Y - %H:%i'), date as timestamp, review_text, grade", 'review, user','writer = uname AND writer IN(SELECT followed FROM follow WHERE follows = "' . $input . '") ORDER BY date DESC'); 
		$locationQuery = retrive_from_db("u.uname, email, id as place, DATE_FORMAT(date, '%d. %M %Y - %H:%i'), date as timestamp", 'user u, place p', 'u.uname = p.uname AND p.uname IN(SELECT followed FROM follow WHERE follows = "' . $input . '") ORDER BY date DESC');
		
		$reviewArray = array();
		for($i = 0;$row = mysql_fetch_array($reviewQuery, MYSQL_NUM);$i++) {	
			$reviewArray = array_merge($reviewArray, (array($row)));
		}
		$locationArray = array();
		for($i = 0;$row = mysql_fetch_array($locationQuery, MYSQL_NUM);$i++) {
			$array = array(array($row[0], $row[1], $row[2], $row[3], $row[4], '0', '0', '0'));
					
			$locationArray = array_merge($locationArray, $array);
		}
		$combinedArray = array_merge($locationArray, $reviewArray);
		usort($combinedArray,'compare_date');

		foreach( $combinedArray as $key => $va){
			echo $va[4];
		}
		
		$output="";
		return $output;
	}
	// if feed on continent
	else if($type == 'continent') {

		
		return $output;
		
	}
	// if feed on country
	else if($type == 'country') {
	
		return $output;
	}
	// if everything
	else if($type == 'world') {
	
		return $output;
	}
	else {
		die('Fatal error');
	}
}

function compare_date($a, $b)
{
  return strnatcmp(strtotime($a[4]), strtotime($b[4]));
}
?>
	