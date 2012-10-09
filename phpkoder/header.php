<?php 
header('content-type: text/html; charset: utf-8');
session_start(); 
include("login.php");
//include('functions.php'); 

function logout() {
		/**
		 * Delete cookies - the time must be in the past,
		 * so just negate what you added when creating the
		 * cookie.
		 */
		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
		   setcookie("cookname", "", time()-60*60*24*100, "/");
		   setcookie("cookpass", "", time()-60*60*24*100, "/");
		}
	   /* Kill session variables */
	   unset($_SESSION['username']);
	   unset($_SESSION['password']);
	   $_SESSION = array(); // reset session array
	   session_destroy();   // destroy session.

	   return "<h1>Logged Out</h1>\n You have successfully <b>logged out</b>.";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="no" lang="no">
<head>
	<?php
		if(!$meta) {
			$meta = '';
		}
		if(!$title) {
			$title = 'Backpacker';
		}
		if(!$javascript) {
			$javascript = '';
		}
		if(!$onLoad) {
			$onLoad = '';
		}
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="shortcut icon" href="favicon.ico" />

	<?php echo $meta; // custom meta tags ?>
	<title><?php echo $title; // input from the page the header is displayed in, used to display titlebar in the browser?></title>
	<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>--><!-- jQuery javascriptbibliotek -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

	<!---- google API key for hogus.uib.no ---->
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAXCmx7hyAYR3Hg-AXHEdbKxQKBp_WCrOUSCNtx_8lpFnqBNbAWxQVrlYld_aceirhDC6bRdGkUYU84A" type="text/javascript"></script>
	<script type="text/javascript" src="js/dropdown.js"></script><!-- Header dropdown -->
	<?php echo $javascript; // input in the form of javascripts/javascript includes ?>
	<link rel="stylesheet" type="text/css" href="styles/screen.css" media="screen" /><!-- stilsett for datamaskinvisning -->
</head>
<body <?php echo $onLoad; ?>>
	<div id="header">
		
		<a href="index.php"><img src="images/backpacker-logo.png" alt="Backpacker by Chillout" /></a>
		<form type="GET" action="PHPkoder/search.php">
			<input type="text" id="searchBox" name="search" value="search Backpacker" onblur="this.value = this.value || this.defaultValue; this.style.color = '#999';" onfocus="this.value=''; this.style.color = '#333';" />
			<input src="images/magnifier.png" id="searchSubmit" type="image" />
		</form>&nbsp;
		<ul class="topnav">  
			<li class="expandable"><a href="world.php">Continents</a>
				<ul class="hidden" style="display:none;">
					<li><a href="continent.php?id=africa">Africa</a></li>
					<li><a href="continent.php?id=asia">Asia</a></li>
					<li><a href="continent.php?id=carib">Central America and the Caribbean</a></li>
					<li><a href="continent.php?id=europe">Europe</a></li>
					<li><a href="continent.php?id=meast">Middle East</a></li>
					<li><a href="continent.php?id=namerica">North America</a></li>
					<li><a href="continent.php?id=pacific">Pacific</a></li>
					<li><a href="continent.php?id=samerica">South America</a></li>
				</ul>
			</li>
			<li class="expandable"><a href="">Top Countries</a>
				<ul class="hidden" style="display:none;">
					<li><a href="country.php?id=denmark">Denmark</a></li>
					<li><a href="country.php?id=england">England</a></li>
					<li><a href="country.php?id=greece">Greece</a></li>
					<li><a href="country.php?id=norway">Norway</a></li>
					<li><a href="country.php?id=sweden">Sweden</a></li>
				</ul>
			</li>
			<?php 
			
			if($logged_in) {
				echo '	<li class="expandable"><a href="user.php?id=' . $_SESSION['username'] . '"><img src="http://www.gravatar.com/avatar/' . md5( strtolower( trim($_SESSION['email']) ) ) . '?s=15" />' . $_SESSION['username'] . '</a>
							<ul class="hidden" style="display:none;">
								<li><a href="editaccount.php">Edit profile</a></li>
								<li><a href="PHPkoder/Logout.php">Log out</a></li>
							</ul>
						</li>';
			} else { ?>
				<li class="expandable login"><a href="">Login</a>
					<form id="loginForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="hidden" style="display:none;">
						<label for="username">Name:</label><input name="user" type="text" />
						<label for="password">Password:</label><input name="pass" type="password" />
						Remember me <input type="checkbox" name="remember" /> <input type="submit" name="sublogin" value="Login" />
						No account? <a href="index.php">Register for free</a>
					</form>
				</li>
			<?php } ?>
		</ul>
	</div>
	
	<div id="body">