<?php
	// include functions and database connection
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
	
	
	// get variables from url
	if(isset($_GET['id'])) { 
		$region_id = $_GET['id']; 
	}  else {
		$region_id = false; 
	}
	$region= $region_id;
	if(isset($_GET['type'])) { 
		$type=$_GET['type']; 
	} else { 
		$type=false; 
	}
	if($type) {
		$javavar = '
			for (var i = 0; i < journeys.length; i++) {
				var name = journeys[i].getAttribute("name");
				var info = journeys[i].getAttribute("info");
				var type = journeys[i].getAttribute("type");
				if(type == "' . $type . '") {
					var point = new GLatLng(parseFloat(journeys[i].getAttribute("lat")),
											parseFloat(journeys[i].getAttribute("lng")));
											
					var marker = createMarker(point, name, info, type);
					
					// legger markers p? kartet
					map.addOverlay(marker);
				
			
				}
		}';
	} else {
		$javavar = '
				for (var i = 0; i < journeys.length; i++) {
				var name = journeys[i].getAttribute("name");
				var info = journeys[i].getAttribute("info");
				var type = journeys[i].getAttribute("type");
				
				var point = new GLatLng(parseFloat(journeys[i].getAttribute("lat")),
										parseFloat(journeys[i].getAttribute("lng")));
										
				var marker = createMarker(point, name, info, type);
				
				// legger markers p? kartet
				map.addOverlay(marker);
				}';
	}
	
	//region info array
	$info = mysql_fetch_array(retrive_from_db('id, lon, lat, a_name, description, country', 'region', 'id = "' . $region_id . '"'), MYSQL_NUM);

	// avg grade
	$avg = mysql_fetch_array(retrive_from_db('AVG(grade)', 'review', 'region =' . $region), MYSQL_NUM);
	
	// variable for getProduct (country name)
	$country= $info[5];
	
	if(!is_numeric($region_id) || $region_id < 1) {
		die($region_id . ' is not a valid ID');
	}
	
	// meta tags
	$meta = '';
	
	// page title
	$title= $info[3] . ", " . $country . " - Backpacker"; 
	
	
	$place_arr = mysql_fetch_array(retrive_from_db('*', 'region', 'id = "' . $region_id . '"'), MYSQL_NUM);

	// javascripts (jQuery included by default)
	$javascript = '
	<script type="text/javascript">
	 
	 var iconAttraction = new GIcon(); 
    iconAttraction.image = "images/icons/sight.png";
    iconAttraction.shadow = "images/icons/shadow.png";
    iconAttraction.iconSize = new GSize(15, 18);
    iconAttraction.shadowSize = new GSize(22, 20);
    iconAttraction.iconAnchor = new GPoint(6, 18);
    iconAttraction.infoWindowAnchor = new GPoint(5, 1);

	 var iconCoffee = new GIcon(); 
    iconCoffee.image = "images/icons/coffee.png";
    iconCoffee.shadow = "images/icons/shadow.png";
    iconCoffee.iconSize = new GSize(15, 18);
    iconCoffee.shadowSize = new GSize(22, 20);
    iconCoffee.iconAnchor = new GPoint(6, 18);
    iconCoffee.infoWindowAnchor = new GPoint(5, 1);
		
	
     var iconToilet = new GIcon(); 
    iconToilet.image = "images/icons/toilets.png";
    iconToilet.shadow = "images/icons/shadow.png";
    iconToilet.iconSize = new GSize(15, 18);
    iconToilet.shadowSize = new GSize(22, 20);
    iconToilet.iconAnchor = new GPoint(6, 20);
    iconToilet.infoWindowAnchor = new GPoint(5, 1);
	
	 var iconWifi = new GIcon(); 
    iconWifi.image = "images/icons/wifi.png";
    iconWifi.shadow = "images/icons/shadow.png";
    iconWifi.iconSize = new GSize(15, 18);
    iconWifi.shadowSize = new GSize(22, 20);
    iconWifi.iconAnchor = new GPoint(6, 18);
    iconWifi.infoWindowAnchor = new GPoint(5, 1);
	
	 var iconHostel = new GIcon(); 
    iconHostel.image = "images/icons/hostel.png";
    iconHostel.shadow = "images/icons/shadow.png";
    iconHostel.iconSize = new GSize(15, 18);
    iconHostel.shadowSize = new GSize(22, 20);
    iconHostel.iconAnchor = new GPoint(6, 18);
    iconHostel.infoWindowAnchor = new GPoint(5, 1);
	
	 var iconRestaurant = new GIcon(); 
    iconRestaurant.image = "images/icons/restaurant.png";
    iconRestaurant.shadow = "images/icons/shadow.png";
    iconRestaurant.iconSize = new GSize(15, 18);
    iconRestaurant.shadowSize = new GSize(22, 20);
    iconRestaurant.iconAnchor = new GPoint(6, 20);
    iconRestaurant.infoWindowAnchor = new GPoint(5, 1);

	var customIcons = [];
    customIcons["cafe"] = iconCoffee;
    customIcons["attraction"] = iconAttraction;
	customIcons["toilet"] = iconToilet;
	customIcons["internet access"] = iconWifi;
	customIcons["hostel"] = iconHostel;
	customIcons["restaurant"] = iconRestaurant;
	

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        var center = new GLatLng(' . $place_arr[2] . ', ' . $place_arr[1] . ');
					map.setCenter(center, 13);
					
		
		
        // Change this depending on the name of your PHP file
        GDownloadUrl("rateingxml.php?id=' . $region_id . '", function(data) {
          var xml = GXml.parse(data);
		  var points = new Array();
		  var journeys = xml.documentElement.getElementsByTagName("journey");
		  
		  

			
           ' . $javavar . '
			

          
        });
		 
		
      }
    }

    function createMarker(point, name, info, type) {
      var marker = new GMarker(point, customIcons[type]);
      var html = "<b>" + name + "</b> <br/>" + "<a href=" + info + ">" + info + "</a>";
      GEvent.addListener(marker, "click", function() {
        marker.openInfoWindowHtml(html);
      });
      return marker;
    }
 
	</script>
	'; // her må kartdata genereres
	
	// body onLoad
	$onLoad = 'onload="load()" onunload="GUnload()"';

	include('PHPkoder/header.php');
?>
	<div class="twothirds">
	
	<h1><?php echo htmlentities($info[3])?>,<a href="country.php?id=<?php echo $country?>"> <?php echo ucfirst($country)?></a></h1>
		<?php if($logged_in) { ?>
			<form id="addLocation" action="addLocation.php" method="POST">
				<input type="hidden" name="region" value="<?php echo $region; ?>" />
				<input type="hidden" name="lon" value="<?php echo $place_arr[1]; ?>" />
				<input type="hidden" name="lat" value="<?php echo $place_arr[2]; ?>" />
				<input type="submit" value="Add location in this region" />
			</form>
		<?php } ?>
		<p class="description"><?php echo htmlentities($info[4])?></p>
		<p>Grade: <?php if($avg[0] == "") { echo 'Not rated'; } else { echo (round(($avg[0]*10))/10) . '/10'; } ?></p>
		<div id="map" style="width: 100%; height: 300px"></div>
	  
	  		
	<?php
		$cafe = mysql_fetch_array(retrive_from_db('DISTINCT COUNT(place)', 'place_type,place', "region = '" . $region_id . "' AND place_type ='cafe' AND id = place"), MYSQL_NUM);
		$rest = mysql_fetch_array(retrive_from_db('DISTINCT COUNT(place)', 'place_type,place', "region = '" . $region_id . "' AND place_type ='restaurant' AND id = place"), MYSQL_NUM);
		$attr = mysql_fetch_array(retrive_from_db('DISTINCT COUNT(place)', 'place_type,place', "region = '" . $region_id . "' AND place_type ='attraction' AND id = place"), MYSQL_NUM);
		$toilet = mysql_fetch_array(retrive_from_db('DISTINCT COUNT(place)', 'place_type,place',"region = '" . $region_id . "' AND place_type ='toilet' AND id = place"), MYSQL_NUM);
		$internet = mysql_fetch_array(retrive_from_db('DISTINCT COUNT(place)', 'place_type,place',"region = '" . $region_id . "' AND place_type ='internet access' AND id = place"), MYSQL_NUM);
		$hostel = mysql_fetch_array(retrive_from_db('DISTINCT COUNT(place)', 'place_type,place',"region = '" . $region_id . "' AND place_type ='hostel' AND id = place"), MYSQL_NUM);
		$all = mysql_fetch_array(retrive_from_db('DISTINCT COUNT(place)', 'place_type,place',"region = '" . $region_id . "'  AND id = place"), MYSQL_NUM);
	
	if($type) { ?>
	<ul class="placeTypes">
			
			<li>All<a href="region.php?id=<?php echo $region_id ?>">(<?php echo $all[0]; ?>)</a></li>
			<li>Cafe<a href="region.php?id=<?php echo $region_id ?>&type=cafe">(<?php echo $cafe[0]; ?>)</a><img class="icons" src="images/icons/coffee.png" alt="Cafe" /></li>
			<li>Restaurant<a href="region.php?id=<?php echo $region_id ?>&type=restaurant">(<?php echo $rest[0]; ?>)</a><img class="icons" src="images/icons/restaurant.png" alt="Restaurant" /></li>
			<li>Attraction<a href="region.php?id=<?php echo $region_id ?>&type=attraction">(<?php echo $attr[0]; ?>)</a><img class="icons" src="images/icons/sight.png" alt="Attraction" /></li>
			<li>Toilet<a href="region.php?id=<?php echo $region_id ?>&type=toilet">(<?php echo $toilet[0]; ?>)</a><img class="icons" src="images/icons/toilets.png" alt="Toilet" /></li>
			<li>Internet Access<a href="region.php?id=<?php echo $region_id ?>&type=internet access">(<?php echo $internet[0]; ?>)</a><img class="icons" src="images/icons/wifi.png" alt="Internet Accsess" /></li>
			<li>Hostel<a href="region.php?id=<?php echo $region_id ?>&type=hostel">(<?php echo $hostel[0]; ?>)</a><img class="icons" src="images/icons/hostel.png" alt="Hostel" /></li>
		</ul>
	<h2> <?php echo ucfirst($type)?></h2>
	<ul class="list">
		<?php
			$related = retrive_from_db('id, p_name', 'place,place_type', "place = id AND place_type ='" . $type . "' AND region = '" . $region_id . "' 			ORDER BY p_name ASC");
			$count = retrive_from_db('COUNT(id)', 'place,place_type', "place = id AND place_type ='" . $type . "' AND region = '" . $region_id . "'");
			$int = 0;
			while (($row = mysql_fetch_array($related, MYSQL_NUM)) && $int < $count) {
				$int++;
				print('<li><a href="viewlocation.php?id=' . $row[0] . '">' . htmlentities($row[1]) . '</a></li>');  
			}
		?>
	</ul>
	<?php
	}else { ?>
		<ul class="placeTypes">
			
			<li>All<a href="region.php?id=<?php echo $region_id ?>">(<?php echo $all[0]; ?>)</a></li>
			<li>Cafe<a href="region.php?id=<?php echo $region_id ?>&type=cafe">(<?php echo $cafe[0]; ?>)</a><img class="icons" src="images/icons/coffee.png" alt="Cafe" /></li>
			<li>Resturant<a href="region.php?id=<?php echo $region_id ?>&type=restaurant">(<?php echo $rest[0]; ?>)</a><img class="icons" src="images/icons/restaurant.png" alt="Restaurant" /></li>
			<li>Attraction<a href="region.php?id=<?php echo $region_id ?>&type=attraction">(<?php echo $attr[0]; ?>)</a><img class="icons" src="images/icons/sight.png" alt="Attraction" /></li>
			<li>Toilet<a href="region.php?id=<?php echo $region_id ?>&type=toilet">(<?php echo $toilet[0]; ?>)</a><img class="icons" src="images/icons/toilets.png" alt="Toilet" /></li>
			<li>Internet Access<a href="region.php?id=<?php echo $region_id ?>&type=internet access">(<?php echo $internet[0]; ?>)</a><img class="icons" src="images/icons/wifi.png" alt="Internet Accsess" /></li>
			<li>Hostel<a href="region.php?id=<?php echo $region_id ?>&type=hostel">(<?php echo $hostel[0]; ?>)</a><img class="icons" src="images/icons/hostel.png" alt="Hostel" /></li>
		</ul>
		<?php
		} ?>
		<h2>Reviews</h2>
			<ul id="reviews">
				<?php $comment = retrive_from_db('usr.email, rev.writer, rev.grade, rev.review_text', 'review rev, user usr', 'rev.writer = usr.uname AND rev.region = ' . $region); 
					while ($row = mysql_fetch_array($comment, MYSQL_NUM)) {
						printf('<li><h3>%s <a href="user.php?id=%s">%s</a></h3>  <span class="grade">Gave grade: %s/10</span> <p>%s</p></li>', '<img src="http://www.gravatar.com/avatar/' . md5( strtolower( trim($row[0]) ) ) . '?s=36" />', htmlentities($row[1]), htmlentities($row[1]), htmlentities($row[2]), htmlentities($row[3]));  
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
		<h2>Top 5 Places in <?php echo $info[3] ?> </h2>
		<ul id="related">
		<?php 
			$related = retrive_from_db('pl.id, p_name, description', 'place pl', "region = '" . $region_id . "' ORDER BY (SELECT AVG(grade) FROM review WHERE place = pl.id) DESC"); 
			$int = 0;
			while (($row = mysql_fetch_array($related, MYSQL_NUM)) && $int < 5) {
				$int++;
				printf('<li><h3><a href="viewLocation.php?id=%s">%s</a></h3><p>%s</p></li>', htmlentities($row[0]), htmlentities($row[1]), htmlentities($row[2]));  
			}
		?>
		</ul>
	</div>
	
<?php include('PHPkoder/footer.php'); ?>
	