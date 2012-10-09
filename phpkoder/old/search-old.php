<?php 

include("database.php");
include("functions.php");

function search(){
	$search = $_GET["search"];
	$table = '';
	$toReturn = '';
	
	// Bygg WHERE for sted
	$where = buildWhere('p_name');
	$table = 'place';
	
	// Sjekker om det finnes en slik region
	$result = retrive_from_db('*', $table, $where);
	
	if(searchComplete($result)){
		$toReturn = buildReturn($result,'location','id');
	}		
	
	
	if(!searchComplete($result)){
		// Bygg WHERE for region
		$where = buildWhere('a_name');
		$table = 'region';
	
		// Sjekker om det finnes en slik region
		$result = retrive_from_db('*', $table, $where);
		
		if(searchComplete($result)){
			$toReturn = buildReturn($result,'region','id');
		}		
	}
	
	if(!searchComplete($result)){
		// Bygg WHERE for land
		$where = buildWhere('c_name');
		$table = 'country';
	
		// Sjekker om det finnes et slik land
		$result = retrive_from_db('*', $table, $where);
		
		if(searchComplete($result)){
			$toReturn = buildReturn($result,'country','c_name');
		}
	}
			
	if(!searchComplete($result)){
		// Bygg WHERE for bruker
		$where = buildWhere('uname');
		$table = 'user';
	
		// Sjekker om det finnes et slik land
		$result = retrive_from_db('*', $table, $where);
	
		if(searchComplete($result)){
			$toReturn = buildReturn($result,'user','uname');
		}
	}
	
	return $toReturn;
}

function buildWhere($field){
	$value = $_GET["search"];
	$where = $field . '="' . $value . '"';
	return $where;
}

function buildReturn($query,$id,$field){
	$regionToReturn = mysql_fetch_array($query);
	$toReturn = $id ."_id=". $regionToReturn[$field];
	return $toReturn;
}

function searchComplete($query){
	return mysql_numrows($query) > 0;
}



echo search();

?>