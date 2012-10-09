<?php

// Functions
// Version: 1.0


// Connect to database
// -------------------------------------
function connectToDB() 
{
// Connects to the database.
$con = mysql_connect("hoguslg.uib.no", "jas021", "database");

// If connection fails, error will show.
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// Selects a database.
mysql_select_db("jas021");

return $con;
}


function insert_into_db($table, $columns, $values){
		

	$query = 'INSERT INTO ' .  $table . ' (' . $columns . ')'  . ' VALUES (' . $values . ')';
	if (!mysql_query($query))
	  {
	    die('Error: ' . mysql_error());
	  }
	else {
	  echo 'Query was successfully inserted into the database.';
	}
	return mysql_insert_id();
}

function retrive_from_db($values, $table, $where){
  $query = 'SELECT ' . $values . 
             ' FROM ' . $table;
if($where){
   $query .= ' WHERE ' . $where;
 }
if (!mysql_query($query))
  {
  	die('Error: ' . mysql_error());
  }
  
  return mysql_query($query);

}

function update_db($table, $values, $where){
  $query = 'UPDATE ' . $table . ' SET ' . $values . ' WHERE ' . $where;
  if (!mysql_query($query))
    {
      die('Error: ' . mysql_error());
    }
}

function delete_from_db($table, $where){
  $query = 'DELETE FROM ' . $table . ' WHERE ' . $where;
  if (!mysql_query($query))
    {
      die('Error: ' . mysql_error());
    }
}
?>