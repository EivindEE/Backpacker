<?php
	// include functions and database connection
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
	// henter fra database
	$user = mysql_fetch_array(retrive_from_db('*', 'user', "uname = 'jas021'"), MYSQL_NUM);
	$bergen = mysql_fetch_array(retrive_from_db('*', 'region', "id = 1"), MYSQL_NUM);
	$tromso = mysql_fetch_array(retrive_from_db('*', 'region', "id = 2"), MYSQL_NUM);
	$trondheim = mysql_fetch_array(retrive_from_db('*', 'region', "id = 3"), MYSQL_NUM);
	
	// meta tags
	$meta = '';
	
	// page title
	$title= "Journey"; 

	// javascripts (jQuery included by default)
	$javascript = '
	<script type="text/javascript">
	  var iconBlue = new GIcon(); 
    iconBlue.image = "http://labs.google.com/ridefinder/images/mm_20_blue.png";
    iconBlue.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
    iconBlue.iconSize = new GSize(12, 20);
    iconBlue.shadowSize = new GSize(22, 20);
    iconBlue.iconAnchor = new GPoint(6, 20);
    iconBlue.infoWindowAnchor = new GPoint(5, 1);

    var iconRed = new GIcon(); 
    iconRed.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
    iconRed.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
    iconRed.iconSize = new GSize(12, 20);
    iconRed.shadowSize = new GSize(22, 20);
    iconRed.iconAnchor = new GPoint(6, 20);
    iconRed.infoWindowAnchor = new GPoint(5, 1);

    var customIcons = [];
    customIcons["1"] = iconBlue;
    customIcons["2"] = iconRed;

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(60.4720240,  8.4689460), 5);
		
		


        // Change this depending on the name of your PHP file
        GDownloadUrl("journeyxml.php", function(data) {
          var xml = GXml.parse(data);
		  var points = new Array();
		  var journeys = xml.documentElement.getElementsByTagName("journey");
		  
			for (var i = 0; i < journeys.length; i++) {
            var name = journeys[i].getAttribute("name");
            var info = journeys[i].getAttribute("info");
            var type = journeys[i].getAttribute("type");
			
			var point = new GLatLng(parseFloat(journeys[i].getAttribute("lat")),
                                    parseFloat(journeys[i].getAttribute("lng")));
									
            var marker = createMarker(point, name, info, type);
			
			
			// setter punkter for vei i array
			points[i]= point;
			
			
			// legger markers p? kartet
            map.addOverlay(marker);
			
			
			// lager en polyline
			var polyline = new GPolyline(points, "#ff3056", 5, 0.7);
			
			
			// Legger polylinjen p? kartet
			map.addOverlay(polyline);
			
			}
          
        });
		 
		
      }
    }

    function createMarker(point, name, info, type) {
      var marker = new GMarker(point, customIcons[type]);
      var html = "<b>" + name + "</b> <br/>" + info;
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
	<!-- full / half / onethird / twothirds -->
	<div class="twothirds">	
  <h1>Journey</h1>	
  <hr />
 
  <div id="map" style="width: 100%; height: 500px"></div>
  
  <hr />
  Visited = <img src="http://labs.google.com/ridefinder/images/mm_20_blue.png" alt="some_text"/>
  Not Visited = <img src="http://labs.google.com/ridefinder/images/mm_20_red.png" alt="some_text"/>
  </div>
  
  <div class="onethird" id="userinfo">
		<img class="left" style="margin-right: 10px;" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($user[6]))); ?> '?s=64"' alt="" />
		<h2 class="username"><?php echo $user[0]; ?></h2>
		
		<em><?php echo $user[1] . ' ' . $user[2]; ?></em>
		<em>Joined: <?php echo $user[8]; ?></em> - 
		<h2>Description</h2>
		<p><?php echo $user[7]; ?></p>
		<?php if($user[0] == 'jas021') { echo $user[0] . ' has registered <a href="journey.php">1 journey</a>'; } ?>
		
	</div>
  
  <div class="onethird">
  <h2> Regions on <?php echo $user[0];?>'s journey</h2>
  <ul class="journeyelements">
  <li>
  <h3><a  href="region.php?id=<?php echo $bergen[0];?>"><?php echo $bergen[3];?></a></h3>
  <p><?php echo htmlentities($bergen[4]);?></p>
  </li>
  <li>
  <h3><a  href="region.php?id=<?php echo $tromso[0];?>"><?php echo $tromso[3];?></a></h3>
  <p><?php echo htmlentities($tromso[4]);?></p>
  
  </li>
  <li>
  <h3><a  href="region.php?id=<?php echo $trondheim[0];?>"><?php echo $trondheim[3];?></a></h3>
  <p><?php echo htmlentities($trondheim[4]);?></p>
  
  </li>
  </ul>
  
  </div>
  
	
<?php include('PHPkoder/footer.php'); ?>
	