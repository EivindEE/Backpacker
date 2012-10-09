<?php
	// include functions and database connection
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
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
	<div class="full"><h1>World</h1>
		<img class="left" src="images/map/worldmap.gif" usemap="#map" alt="World Map" border="0" width="270" height="140">
		<map id="map" name="map">
<area shape="poly" coords="207,105,209,117,235,122,251,129,260,116,258,98,231,87,230,97,218,96" alt="Oceania" href="continent.php?id=oceania">
<area shape="poly" coords="163,28,163,55,167,72,178,77,183,84,212,102,218,94,229,95,230,88,216,72,267,33,258,23,194,7,154,8" alt="Asia" href="continent.php?id=Asia">
<area shape="poly" coords="163,57,161,29,142,25,147,9,131,10,141,28,128,37,113,28,104,36,124,40,115,48,122,53,119,63,131,59,140,63,150,54" alt="Europe" href="continent.php?id=Europe">
<area shape="poly" coords="145,61,152,56,162,59,168,74,159,83" alt="Middle East" href="continent.php?id=Middle East">
<area shape="poly" coords="140,116,148,118,164,106,165,79,158,84,144,63,129,61,111,76,120,88,132,88,138,117" alt="Africa" href="continent.php?id=africa">
<area shape="poly" coords="74,81,67,92,75,107,72,131,80,137,106,93,79,80" alt="South America" href="continent.php?id=South America">
<area shape="poly" coords="69,86,55,77,68,65,80,74,80,76" alt="Central America and the Caribbean" href="continent.php?id=Caribbiean">
<area shape="poly" coords="5,27,9,48,25,42,55,78,70,64,93,52,101,37,115,23,120,6,61,6" alt="North America" href="continent.php?id=North America">
</map>

		<ul style="display:inline;padding:0;margin:0;margin-right: 10px;">
			<li><a href="continent.php?id=africa" class="right_body">Africa</a></li>
			<li><a href="continent.php?id=asia" class="right_body">Asia</a></li>
			<li><a href="continent.php?id=caribbiean" class="right_body">Central America and the Caribbean</a></li>
			<li><a href="continent.php?id=europe" class="right_body">Europe</a></li>
			<li><a href="continent.php?id=Middle East" class="right_body">Middle East</a></li>
			<li><a href="continent.php?id=North America" class="right_body">North America</a></li>
			<li><a href="continent.php?id=oceania" class="right_body">Oceania</a></li>
			<li><a href="continent.php?id=south america" class="right_body">South America</a></li>
		</ul>
		<em style="display:block;clear:both;">Click the map or the continent name to get started</em>
	</div>
	
<?php include('PHPkoder/footer.php'); ?>
	