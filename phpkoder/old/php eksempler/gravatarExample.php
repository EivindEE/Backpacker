<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
		<title>Get Gravatar</title>
</head>
	<body>
		<ul>
		<li>http://en.gravatar.com/site/implement/images/</li>
		</ul>
		<form action="gravatarExample.php" type="post">
			<input type="text" name="gravatar" />
			<input type="submit" />
		</form>
		<?php
			if($gravatar) {
				echo $gravatar . '\'s current Gravatar: <img src="http://www.gravatar.com/avatar/' . md5( strtolower( trim($gravatar) ) ) . '?d=' . urlencode('http://thunemedia.no/images/logo-nett-stor.png') . '" />';
			}
		?>
	</body>
           
</html>
