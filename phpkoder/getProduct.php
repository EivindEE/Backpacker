<?php
/*include("database.php");
include("functions.php");

$country = null;
$region = null;	
if(isset($_GET["country_id"]))
	$country = $_GET["country_id"];
if(isset($_GET["region_id"]))
	$region = $_GET["region_id"];*/	

if(!isset($region)) {
		$region = null;
}

$table = 'product';
echo '<div class="product">';
if($region){
	$where = '	
	id IN (SELECT product
  	FROM  `need_region` , region
	WHERE  `id` =  "' . $region . '"
	AND  `region` =  `id`
	)';
	
	
	$result = retrive_from_db('*', $table, $where);
	while($row = mysql_fetch_array($result))
  	{
  		echo '<h3><a href="http://chillout.no/index.php?menu=store&Yprodukt=' . $row['id'] .'">' . htmlentities($row['p_name']) . '</a></h3>';
  		echo '<img src="' . $row['img'] . '" class="product-img"/>';
  		echo '<p>' . htmlentities($row['description']). '</p>';
  		echo '<em> Price:' . $row['cost'] . '</em>';
  	}
  }



if($country){
	$where = '	
	id IN (SELECT product
  	FROM  `need_country` , country
	WHERE  `c_name` =  "'.$country.'"
	AND  `country` =  `c_name`
	)';

	$result = retrive_from_db('*', $table, $where);

	while($row = mysql_fetch_array($result))
  	{
  		echo '<h3><a href="http://chillout.no/index.php?menu=store&Yprodukt=' . $row['id'] . '">' . htmlentities($row['p_name']) . '</a></h3>';
  		echo '<img src="' . $row['img'] . '" class="product-img"/>';
  		echo '<p>' . htmlentities($row['description']). '</p>';
  		echo '<em> Price:' . $row['cost'] . '</em>';
  	}
  }
echo '</div>';
?>