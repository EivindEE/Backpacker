<?php
 
include("database.php");
include("login.php");
include("functions.php");

$table = 'place';
$name = $_REQUEST['title'];
$description = $_REQUEST['description'];
$longtitude = $_REQUEST['lng']; 
$latitude = $_REQUEST['lat'];
$region = $_REQUEST['region'];
$type = $_REQUEST['type'];
$username = $_REQUEST['username'];
// $adress = $_REQUEST['geo'];

// if(!$adress) {
//  $adress = '';
// }

$id = insert_into_db($table, "p_name, description, lon, lat, region, uname", '"' . $name . '", "' . $description . '", "' . $longtitude . '", "' .  $latitude . '", "' .  $region . '", "' . $username . '"');
echo $id;
insert_into_db('place_type', 'place, place_type', '"' . $id . '", "' . $type . '"');
mysql_close($conn);
header('Location: ../viewLocation.php?id=' . $id);

?>

