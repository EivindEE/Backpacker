<?php

// Users Information Index
// Version 1.0


require_once("functions.php");

connectToDB();

echo "<b>Memberlist:</b> <br /><br />";

// Saves all information from "userInfo" to the variable: $query
$query = "SELECT * FROM userInfo";

// Executes the query, but we get an error if it fails.
$result = mysql_query($query) or die(mysql_error());

	// Loops through the resultset, finds the values, and writes them out.
	while($data=mysql_fetch_array($result))
	{
		echo "Username: $data[username]<br />";
              	echo "Name: $data[name]<br />";
		echo "Age: $data[age]<br />";
		echo "Is from: $data[from]<br /><br />";				
	}
?>

<form action="InsertUserInfo.php" method="post">
Username: <input type="text" name="username" />
Name: <input type="text" name="name" />
Age: <input type="text" name="age" />
From: <input type="text" name="from" />
<input type="submit" />
</form>
