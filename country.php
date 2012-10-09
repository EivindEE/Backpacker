<?php
	// include functions and database connection
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
	$country_id = $_GET['id'];
	$country = $country_id;
	
	
	//info array
	$info = mysql_fetch_array(retrive_from_db('c_name, lon, lat, description, flag, continent', 'country', 'c_name = "' . $country_id . '"'), MYSQL_NUM);
	
	
	// meta tags
	$meta = '';
	
	// page title
	$title= $country . " - Backpacker"; 

	// javascripts (jQuery included by default)
	$javascript = '
	<script type="text/javascript" src="filpath">
	 function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        var center = new GLatLng(' . $info[2] . ', ' . $info[1] . ');
					map.setCenter(center, 13);
					
					
	
	
	
		}
	}
	</script>
	'; // her må kartdata genereres
	
	// body onLoad
	$onLoad = 'onload="load()" onunload="GUnload()"';

	include('PHPkoder/header.php');
?>
	<!-- full / half / onethird / twothirds -->
	<div class="twothirds">
	<h1><?php echo $info[0]?> </h1>

	<div class="flag">
		<img src="images/flag/<?php echo $info[4]?>" alt="<?php echo $info[0]?>" />
		<span>The official flag of <?php echo $info[0]?></span>
	</div>
	<div class="flag">
		<img style="clear:right;" src="images/country/<?php echo $country_id?>.png" alt="<?php echo $country_id?>" />
		<span><?php echo $info[0]?> marked with colour</span>
	</div>
	
	<p class="description"> <?php echo htmlentities($info[3])?> </p>

	<h2>Regions within <?php echo htmlentities($info[0])?></h2>
	<ul class="list">
		<?php
			$related = retrive_from_db('r.id, a_name', 'region r', "r.country = '" . $country_id . "' ORDER BY a_name ASC");
			$count = retrive_from_db('DISTINCT COUNT(r.id)', 'region r', "r.country = '" . $country_id . "' ");
			$int = 0;
			while (($row = mysql_fetch_array($related, MYSQL_NUM)) && $int < $count) {
				$int++;
				print('<li><a href="region.php?id=' . htmlentities($row[0]) . '">' . htmlentities($row[1]) . '</a></li>');  
			}
		?>
	</ul>
	
	
	<div id="map" style="width: 100%; height: 300px"></div>
	</div><!--- slutt på two thirds --->
	
	
	<div class="onethird">
			<h2>You'll need</h2>
		<?php include('PHPkoder/getProduct.php'); ?>

	</div>
	
	<div class="onethird">
	<h2> Top Places <?php echo $country_id?></h2>
	<ul id="related">
	
	<?php
	$related = retrive_from_db('DISTINCT pl.id, p_name, pl.description', 'place pl,region r', "r.country = '" . $country_id . "' AND r.id = region ORDER BY (SELECT AVG(grade) FROM review WHERE place = pl.id) DESC");
	$int = 0;
	while (($row = mysql_fetch_array($related, MYSQL_NUM)) && $int < 5) {
				$int++;
				printf('<li><h3><a href="viewLocation.php?id=%s">%s</a></h3><p>%s</p></li>', htmlentities($row[0]), htmlentities($row[1]), htmlentities($row[2]));  
			}
	?>
	</ul>
	</div>
	
<?php include('PHPkoder/footer.php'); ?>
	