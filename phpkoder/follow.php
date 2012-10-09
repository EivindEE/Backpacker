<?php
	include('database.php');
	include('functions.php');
	$follows = $_REQUEST['follows']; /*bug */
	$followed = $_REQUEST['followed'];
	$followAction = $_REQUEST['followAction'];
	
	if($follows != "" && $followed != "" && $followAction == "1") {
		insert_into_db('follow', 'follows, followed', '"' . $follows . '", "' . $followed . '"');
	}
	else if($follows != "" && $followed != "" && $followAction == "-1") {
		delete_from_db('follow', 'follows = "' . $follows . '" AND followed = "' . $followed . '"');
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>