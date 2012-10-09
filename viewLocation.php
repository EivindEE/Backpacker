<?php 
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
	// generate variables
	$location = "";
	$region = "";
	$location_id = "";
	
	// get variables from url
	$location_id = $_GET['id'];
	
	if(!is_numeric($location_id) || $location_id < 1) {
		die($location_id . ' is not a valid ID');
	}
	
	// SQL queries
	$place_arr = mysql_fetch_array(retrive_from_db('*', 'place', 'id = "' . $location_id . '"'), MYSQL_NUM);
	$avg = mysql_fetch_array(retrive_from_db('AVG(grade)', 'review', 'place =' . $location_id), MYSQL_NUM);
	
	// generate local variables
	$location = htmlentities($place_arr[3]);
	$regionName = mysql_fetch_array(retrive_from_db('a_name, country', 'region', 'id =' . $place_arr[7]), MYSQL_NUM);
	$region = $place_arr[7];
	$country = $regionName[1];
	$description = htmlentities($place_arr[6]);
	
	// generate meta info
	$meta = '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />';
	$title= $location . ", " . $regionName[0] . " - Backpacker";    
	$javascript = '
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAXCmx7hyAYR3Hg-AXHEdbKxQKBp_WCrOUSCNtx_8lpFnqBNbAWxQVrlYld_aceirhDC6bRdGkUYU84A" type="text/javascript"></script>
		<script type="text/javascript">
			function load(lat,lon) {
				if (GBrowserIsCompatible()) {
					var map = new GMap2(document.getElementById("map"));
					map.addControl(new GSmallMapControl());
					map.addControl(new GMapTypeControl());
					var center = new GLatLng(' . $place_arr[2] . ', ' . $place_arr[1] . ');
					map.setCenter(center, 15);
					if(lon) {
						center = new GLatLng(lat, lon);
					}
					map.setCenter(center, 15);
					
					
					geocoder = new GClientGeocoder();
					var marker = new GMarker(center, {draggable: false});  
					map.addOverlay(marker);
					
					document.getElementById("lat").value = center.lat();
					document.getElementById("lng").value = center.lng();
					geocoder = new GClientGeocoder();		
				}
			}
		</script>'; // her mÂ kartdata genereres
	$onLoad = 'onload="load()" onunload="GUnload()"';
	
	include('PHPkoder/header.php');
	?>
	<div class="twothirds">
		<h1><?php echo $location?>, <a href="region.php?id=<?php echo $region[0];?>"> <?php echo $regionName[0];?></a>, <a href="country.php?id=<?php echo $country?>"> <?php echo ucfirst($regionName[1]);?></a></h1>
		<p><?php echo $description; ?></p>
		<p>Grade: <?php if($avg[0] == "") { echo 'Not rated'; } else { echo (round(($avg[0]*10))/10) . '/10'; } ?></p>
		<div id="map" style="width: 100%; height: 300px"></div>
		<h2>Reviews</h2>
		<ul id="reviews">
			<?php 
				// kommentarer sorteres i stigende rekkefølge etter timestamp
				$comment = retrive_from_db("usr.email, rev.writer, rev.grade, rev.review_text, DATE_FORMAT(rev.date, '%d. %M %Y - %H:%i') as new_date", 'review rev, user usr', 'rev.writer = usr.uname AND rev.place = ' . $location_id . ' ORDER BY date'); 
				while ($row = mysql_fetch_array($comment, MYSQL_NUM)) {
					printf('<li><h3>%s <a href="user.php?id=%s">%s</a></h3><em class="date right">%s</em><span class="grade right">Grade given: %s</span> <p>%s</p></li>', '<img src="http://www.gravatar.com/avatar/' . md5( strtolower( trim($row[0]) ) ) . '?s=36" />', htmlentities($row[1]), htmlentities($row[1]),htmlentities($row[4]), htmlentities($row[2]), htmlentities($row[3]));  
				}
			?>
		</ul>
		
		<?php if($logged_in) {
			include('addcomment.php');
		} else {
			echo'<p>Log in to add your voice</p>.';
		}
		?>
	</div>
	<div class="onethird">
		<h2>You'll need</h2>
		<?php include('PHPkoder/getProduct.php'); ?>
	</div>
	<div class="onethird">
		<h2>Top 5 Places nearby</h2>
		<ul id="related">
		<?php 
			$related = retrive_from_db('pl.id, p_name, description', 'place pl', "pl.id != '" . $place_arr[0] . "' AND region = '" . $place_arr[7] . "' ORDER BY (SELECT AVG(grade) FROM review WHERE place = pl.id) DESC"); 
			$int = 0;
			while (($row = mysql_fetch_array($related, MYSQL_NUM)) && $int < 5) {
				$int++;
				printf('<li><h3><a href="viewLocation.php?id=%s">%s</a></h3><p>%s</p></li>', htmlentities($row[0]), htmlentities($row[1]), htmlentities($row[2]));  
			}
		?>
		</ul>
	</div>
<?php include('PHPkoder/footer.php'); ?>