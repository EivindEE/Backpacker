<?php
	// include functions and database connection
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
	
	$continent_id = $_GET['id'];
	
	//getting info from database
	
	
	
	// meta tags
	$meta = '';
	
	// page title
	$title= " =D - Backpacker"; 

	// javascripts (jQuery included by default)
	$javascript = '
	<script type="text/javascript" src="filpath"></script>
	'; // her må kartdata genereres
	
	// body onLoad
	$onLoad = '';

	include('PHPkoder/header.php');
?>
	<!-- full / half / onethird / twothirds -->
	<div class="twothirds"><h1><?php echo ucfirst($continent_id) ?></h1>
	
<img class="left" src="images/map/<?php echo $continent_id ?>.gif" usemap="#map" alt="World Map" border="0" width="270" height="140">
<map id="map" name="map">
<area shape="poly" coords="207,105,209,117,235,122,251,129,260,116,258,98,231,87,230,97,218,96" alt="Oceania" href="continent.php?id=Oceania">
<area shape="poly" coords="163,28,163,55,167,72,178,77,183,84,212,102,218,94,229,95,230,88,216,72,267,33,258,23,194,7,154,8" alt="Asia" href="continent.php?id=Asia">
<area shape="poly" coords="163,57,161,29,142,25,147,9,131,10,141,28,128,37,113,28,104,36,124,40,115,48,122,53,119,63,131,59,140,63,150,54" alt="Europe" href="continent.php?id=europe">
<area shape="poly" coords="145,61,152,56,162,59,168,74,159,83" alt="Middle East" href="continent.php?id=Middle East">
<area shape="poly" coords="140,116,148,118,164,106,165,79,158,84,144,63,129,61,111,76,120,88,132,88,138,117" alt="Africa" href="continent.php?id=africa">
<area shape="poly" coords="74,81,67,92,75,107,72,131,80,137,106,93,79,80" alt="South America" href="continent.php?id=South America">
<area shape="poly" coords="69,86,55,77,68,65,80,74,80,76" alt="Central America and the Caribbean" href="continent.php?id=Caribbiean">
<area shape="poly" coords="5,27,9,48,25,42,55,78,70,64,93,52,101,37,115,23,120,6,61,6" alt="North America" href="continent.php?id=North America">
</map>



<div class="left">
		<div class="left">
	<h2>Countries in <?php echo ucfirst($continent_id) ?></h2>
	<ul>
	<?php
	
	$related = retrive_from_db('c_name continent', 'country', "continent = '" . $continent_id . "' ORDER BY c_name ASC");
	$count = retrive_from_db('COUNT(c_name)', 'country', "continent = '" . $continent_id . "' ");
	$int = 0;
	while (($row = mysql_fetch_array($related, MYSQL_NUM)) && $int < $count) {
				$int++;
				print('<li><a href="country.php?id=' . $row[0] . '">' . $row[0] . '</a></li>');  
			}
	?>
	</ul>
	</div>
</div>

	</div>
	
	<div class="onethird">
	
	</div>
	<div class="onethird"><h2></h2></div>
	
<?php include('PHPkoder/footer.php'); ?>
	