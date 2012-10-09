<?php 
	// include functions and database connection
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
	if(isset($_REQUEST['region'])) {
		$region = $_REQUEST['region'];
	}
	if(isset($_REQUEST['lon'])) {
		$lon = $_REQUEST['lon'];
	} else {
		$lon = '5.3221902';
	}
	if(isset($_REQUEST['lat'])) {
		$lat = $_REQUEST['lat'];
	} else {
		$lat = '60.3912184';
	}
	
	$meta = '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />';
	$title="BACKPACKER - add location";    
	$javascript = '
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAXCmx7hyAYR3Hg-AXHEdbKxQKBp_WCrOUSCNtx_8lpFnqBNbAWxQVrlYld_aceirhDC6bRdGkUYU84A" type="text/javascript"></script>
		<script type="text/javascript">
		function showHint(str)
		{
		if (str.length==0)
		  { 
		  document.getElementById("txtHint").innerHTML="";
		  return;
		  }
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			}
		  }
		xmlhttp.open("GET","PHPkoder/getGeoFromAddress.php?address="+str,true);
		xmlhttp.send();
		}
		</script>
		<script type="text/javascript">
		
			function load(lat,lon) {
			if (GBrowserIsCompatible()) {
				var map = new GMap2(document.getElementById("map"));
				map.addControl(new GSmallMapControl());
				map.addControl(new GMapTypeControl());
				var center = new GLatLng(' . $lat . ', ' . $lon . ');
				map.setCenter(center, 11);
				if(lon) {
					center = new GLatLng(lat, lon);
				}
				map.setCenter(center, 11);
				
				
				geocoder = new GClientGeocoder();
				var marker = new GMarker(center, {draggable: true});  
				map.addOverlay(marker);
				
				document.getElementById("lat").value = center.lat();
				document.getElementById("lng").value = center.lng();
				geocoder = new GClientGeocoder();
				
				
				GEvent.addListener(marker, "dragend", function() {
					var point =marker.getPoint();
					map.panTo(point);
					document.getElementById("lat").value = point.lat();
					document.getElementById("lng").value = point.lng();
				});
				GEvent.addListener(map, "moveend", function() {
					map.clearOverlays();
					var center = map.getCenter();
					var marker = new GMarker(center, {draggable: true});
					map.addOverlay(marker);
					document.getElementById("lat").value = center.lat();
					document.getElementById("lng").value = center.lng();
				});
				GEvent.addListener(marker, "dragend", function() {
					var point =marker.getPoint();
					map.panTo(point);
					document.getElementById("lat").value = point.lat();
					document.getElementById("lng").value = point.lng();
				});
				GEvent.addListener(marker, "dragend", function() {
					var point =marker.getPoint();
					map.panTo(point);
					document.getElementById("lat").value = point.lat();
					document.getElementById("lng").value = point.lng();
				});
			}
			
			
			
			GEvent.addListener(map, "moveend", function() {
				map.clearOverlays();
				var center = map.getCenter();
				var marker = new GMarker(center, {draggable: true});
				map.addOverlay(marker);
				document.getElementById("lat").value = center.lat();
				document.getElementById("lng").value = center.lng();
				GEvent.addListener(marker, "dragend", function() {
					var pt =marker.getPoint();
					map.panTo(pt);
					document.getElementById("lat").value = pt.lat();
					document.getElementById("lng").value = pt.lng();
				});
			});
			
			
		}
			

			</script>
		'; 
		$onLoad = 'onload="load()" onunload="GUnload()"';
		include('PHPkoder/header.php');
		if($logged_in) {
	?>
	<div class="full">
		
		<h1>Add location</h1>
		<form method="POST" action="PHPkoder/insertPlaces.php" name="addlocation">
			<input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" />
			<div class="half">
				<h2>Name</h2>
				<input type="text" name="title" id="title" />
				<h2>Description</h2>
				<textarea name="description" id="description"></textarea>
				<h2>Type</h2>
				<select name="type">
					<option value="restaurant">Restaurant</option>
					<option value="cafe">Caf&#233</option>
					<option value="toilet">Toilet</option>
					<option value="internet access">Internet Access</option>
					<option value="attraction">Attraction</option>
					<option value="hostel">Hostel</option>
				</select>
				<input type="hidden" name="region" value="<?php echo $region; ?>" />
				<h2>Add location image</h2>
				<input type="file" name="image" />
			</div>

			<div class="half">
			<h2>Add from address</h2>
			<input type="text" id="txt1" onkeyup="showHint(this.value)" />
			<span id="txtHint"></span>
			
			<h2>OR: Drag pointer to location</h2>
			<div id="map" style="width: 460px; height: 300px"></div>		
				<label>Latitude:</label> <input type="text" id="lat" name="lat" onchange="load(document.getElementById('lat').value,document.getElementById('lng').value)" value="" />	
				<label>Longitude:</label> <input type="text" id="lng" name="lng" onchange="load(document.getElementById('lat').value,document.getElementById('lng').value)" value="" />
			</div>
			<input class="submit" type="submit" value="Add location" />
		</form>
	</div>
<?php 
	// if not logged on
	} else {
		echo '<div class="full">You must be logged on to add locations</div>';
	}
include('PHPkoder/footer.php'); ?>