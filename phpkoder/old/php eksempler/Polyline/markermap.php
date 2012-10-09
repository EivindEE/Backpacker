<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAXCmx7hyAYR3Hg-AXHEdbKxQKBp_WCrOUSCNtx_8lpFnqBNbAWxQVrlYld_aceirhDC6bRdGkUYU84A" type="text/javascript"></script>
  </head>
  <body onunload="GUnload()">

    <div id="map" style="width: 550px; height: 450px"></div>
	<?php
	if (isset($_GET['address']))
        $address = $_GET['address'];
    else
        $address = '';
	?>
	<form method="get" action="markermap.php">
                <div>
                    <input type="text"
                           name="address"
                           value="<?php echo htmlSpecialChars($address) ?>" />
                    <input type="submit" value="Lookup" />
                </div>
            </form>


    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>
	
	
<?php
	
?>

 
    <script type="text/javascript">
   
    
    if (GBrowserIsCompatible()) { 

      // A function to create the marker and set up the event window
      // Dont try to unroll this function. It has to be here for the function closure
      // Each instance of the function preserves the contends of a different instance
      // of the "marker" and "html" variables which will be needed later when the event triggers.    
      function createMarker(point,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }

      // Display the map, with some controls and set the initial location 
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(60.4720240,8.4689460),6);
    
     
		
		// kart variabler
	 var lat = 60.3910809
	 var lon = 5.3222972
	
	 //setter mark pointers på kartet
      var point = new GLatLng(lat,lon);
      var marker = createMarker(point,'<div style="width:240px">Chillout TravelCentre <a href="http://hoguslg.uib.no/info210/h10/jas021/index.php">Link<\/a> to our Webpage<\/div>')
      map.addOverlay(marker);

      var point = new GLatLng(59.9204412,10.7572683 );
      var marker = createMarker(point,'Chillout TravelCentre<br>Second Info Window')
      map.addOverlay(marker);

    }
    
    // gir advarsel om browser ikkje støtter API
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

 
    </script>
  </body>

</html>




