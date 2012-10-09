<?php

if (isset($_REQUEST['e-mail']))
{
  require_once("Functions.php");
  connectToDB();
  $email = $_REQUEST['e-mail'];
  $username = $_REQUEST['username'];
  $password = $_REQUEST['password']; 
  $table = 'users';
  $result = retrieve_from_db("e-mail, username", $table, "e-mail = $email OR username = $username");
    while ($result)
    {
      if (retrieve_from_db('e-mail', $table, 'e-mail = $email'))
	{
	  echo 'The E-mail you entered is already taken. If it is yours, you may try to log in.';
	}
      else
	{
	  echo 'The username is already taken. Please choose another one.';
	}
    }

    insert_into_db($table, "e-mail, username, password", "$email, $username, $password");
 }




<form action="RegisterUser.php" method="post">
<input type="text" name="e-mail" />
<input type="text" name="username" />
<input type="text" name="password" />
<input type="submit" />
</form>


?>