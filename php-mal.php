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
	<div class="twothirds"><h1></h1></div>
	<div class="onethird"><h2></h2></div>
	<div class="onethird"><h2></h2></div>
	
<?php include('PHPkoder/footer.php'); ?>
	