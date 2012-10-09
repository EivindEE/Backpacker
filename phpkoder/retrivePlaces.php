

<?php 

session_start(); 
include("database.php");
include("login.php");
displayLogin();
  //require_once("Functions.php");
  //$con = connectToDB();

$table = 'place';

$result = retrive_from_db('*', $table, null);

while($row = mysql_fetch_array($result))
  {
  echo $row['id'] . " " . $row['lon'] . " " . $row['lat'] . " " . $row['adress'] . " " . $row['p_name'];
  }

mysql_close($con);

?>