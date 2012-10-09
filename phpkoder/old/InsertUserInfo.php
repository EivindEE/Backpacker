<?php

// Insert Users information
// Version 1.0


require_once("Functions.php");

connectToDB();

// Inserts the users information into "userInfo"
$insert = "INSERT INTO brukerInfo (username, name, age, from)
VALUES
('$_POST[username]','$_POST[name]','$_POST[age]','$_POST[from]')";

// If the query fails, we get an error
if (!mysql_query($insert))
  {
  die('Error: ' . mysql_error());
  }

// Redirects back to userInfoIndex.php
Header("Location: UserInfoIndex.php");

?>