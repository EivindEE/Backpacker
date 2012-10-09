<?php

session_start(); 
include("database.php");
include("login.php");
include("functions.php");
//displayLogin();

$table = 'review';
$comment = $_REQUEST['comment'];
$username = $_REQUEST['username'];
$location = $_REQUEST['location_id'];
$grade = $_REQUEST['grade'];
$region = $_REQUEST['region'];

insert_into_db($table, "review_text, writer, place, grade, region", '"' . $comment . '", "' . $username . '", "' . $location . '", "' . $grade . '", "' . $region . '"');

mysql_close($conn);
header('Location: ' . $_SERVER['HTTP_REFERER']);

?>