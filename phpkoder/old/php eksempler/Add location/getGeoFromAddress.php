<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	$address = $_GET["address"];
	//if(strlen($address) >= 4) {
    if (isset($_GET['address']))
        $address = $_GET['address'];
    else
        $address = '';

    $lookupPerformed = true;

    if (strlen($address) > 0) {
        require_once('Geocoder.php');
        $geocoder = new Geocoder('ABQIAAAAXCmx7hyAYR3Hg-AXHEdbKxQKBp_WCrOUSCNtx_8lpFnqBNbAWxQVrlYld_aceirhDC6bRdGkUYU84A');

        try {
            $placemarks = $geocoder->lookup($address);
        }
        catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }

        $lookupPerformed = true;
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google maps API test</title>
	 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAXCmx7hyAYR3Hg-AXHEdbKxQKBp_WCrOUSCNtx_8lpFnqBNbAWxQVrlYld_aceirhDC6bRdGkUYU84A" type="text/javascript"></script>


  </head>
  	<body>
			<!--			
            <form method="get" action="index.php">
                <div>
                           name="address"
                    <input type="text"
                           value="<?php echo htmlSpecialChars($address); ?>"  name="address" />
                    <input type="submit" value="Lookup" />
                </div>
            </form>-->

            <?php if ($lookupPerformed) { ?>
                <hr />

                <h2>Geocoder Results</h2>

                <?php if (count($placemarks) > 0) { ?>
                    
                        <?php foreach ($placemarks as $placemark) { ?>
                          <input type="radio" name="geo" onClick="load('<?php echo $placemark->getPoint()->getLatitude() ?>',
						  '<?php echo $placemark->getPoint()->getLongitude() ?>')" value="
						  <?php echo $placemark->getPoint()->getLatitude() ?>| 
						  <?php echo $placemark->getPoint()->getLongitude() ?>" />
						<?php echo htmlSpecialChars ($placemark->getAddress()) ?> - <?php echo $placemark->getPoint()->getLatitude() ?> |  
						  <?php echo $placemark->getPoint()->getLongitude() ?><br />
				
				
						<?php //$lati = $placemark->getPoint()->getLatitude() ?>
						<?php //$long = $placemark->getPoint()->getLongitude() ?>
						
		
                           
                        <?php } ?>
                    
                <?php } else { ?>
                    <p>
                        No matches found for <strong><?php echo htmlSpecialChars($address) ?></strong>
                    </p>
                <?php } ?>
            <?php } //} else {} ?>
        </div>
		
	</body>
	
</html>