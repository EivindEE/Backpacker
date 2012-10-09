<?php
	// include functions and database connection
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
	// user to get
	$username = $_GET['id'];

	$user = mysql_fetch_array(retrive_from_db('uname, fname, lname, email, info, joined', 'user', 'uname = "' . $username . '"'), MYSQL_NUM);
	
	
	// meta tags
	$meta = '';
	
	// page title
	$title= "Viewing " . $user[0] . "'s profile - Backpacker"; 

	// javascripts (jQuery included by default)
	$javascript = ''; // her må kartdata genereres
	
	// body onLoad
	$onLoad = '';

	include('PHPkoder/header.php');
?>
	<!-- full / half / onethird / twothirds -->
	<div class="twothirds">
		<?php
			echo '<h1>' . $user[0] . '\'s feed</h1><ul id="friendfeed">';
			$friendfeed = retrive_from_db("uname, email, place, region, DATE_FORMAT(date, '%d. %M %Y - %H:%i') as new_date, review_text, grade", 'review, user','writer = uname AND writer = "' . $user[0] . '" ORDER BY date DESC'); 
			while ($row = mysql_fetch_array($friendfeed, MYSQL_NUM)) {
				if($row[2] == '0') {
					if($row[5] == "") {
						$review = "has visited ";
					} else {
						$review = "wrote a review of ";
					}
					$region = mysql_fetch_array(retrive_from_db('a_name', 'region', 'id = "' . $row[3] . '"'), MYSQL_NUM);
					printf('<li>%s <a href="user.php?id=%s" class="username">%s</a> %s<a href="viewLocation.php?id=%s">%s</a> and graded it %s/10.<em>%s</em></li>', '<img src="http://www.gravatar.com/avatar/' . md5( strtolower( trim($row[1]) ) ) . '?s=36" />', $row[0], $row[0], $review, $row[2], htmlentities($region[0]), $row[6], $row[4]);
				} else {
					$place = mysql_fetch_array(retrive_from_db('p_name', 'place', 'id = "' . $row[2] . '"'), MYSQL_NUM);
					if($row[5] == "") {
						$review = "has visited ";
					} else {
						$review = "wrote a review of ";
					}
					printf('<li>%s <a href="user.php?id=%s" class="username">%s</a> %s<a href="viewLocation.php?id=%s">%s</a> and graded it %s/10.<em>%s</em></li>', '<img src="http://www.gravatar.com/avatar/' . md5( strtolower( trim($row[1]) ) ) . '?s=36" />', $row[0], $row[0], $review, $row[2], htmlentities($place[0]), $row[6], $row[4]);
				}
			}
			?>
					</ul>
	</div>
	<div class="onethird" id="userinfo">
		<img class="left" style="margin-right: 10px;" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($user[3]))); ?> '?s=64"' alt="" />
		<h2 class="username"><?php echo $user[0]; ?></h2>
		<?php 
		if($logged_in) { 
			$exists = mysql_fetch_array(retrive_from_db('count(*)', 'follow', "follows = '" . $_SESSION['username'] . "' AND followed = '" . $user[0] . "'"), MYSQL_NUM);
			if($exists[0] == 0 && $user[0] != $_SESSION['username']) {	
		?>	
			<form action="PHPkoder/follow.php" method="post">
				<input type="hidden" name="followed" value="<?php echo $user[0]; ?>" />
				<input type="hidden" name="follows" value="<?php echo $_SESSION['username']; ?>" />
				<input type="hidden" name="followAction" value="1" />
				<input type="submit" value="Follow <?php echo $user[0]; ?>" />
			</form>
		<?php }
			else if($exists[0] > 0 && $user[0] != $_SESSION['username']) { ?>
				<form action="PHPkoder/follow.php" method="post">
				<input type="hidden" name="followed" value="<?php echo $user[0]; ?>" />
				<input type="hidden" name="follows" value="<?php echo $_SESSION['username']; ?>" />
				<input type="hidden" name="followAction" value="-1" />
				<input type="submit" value="Unfollow <?php echo $user[0]; ?>" />
			</form>
		<?php }} ?>
		<em><?php echo $user[1] . ' ' . $user[2]; ?></em>
		<em>Joined: <?php echo $user[5]; ?></em> - 
		<h2>Description</h2>
		<p><?php echo htmlentities($user[4]); ?></p>
		<?php if($user[0] == 'jas021') { echo $user[0] . ' has registered <a href="journey.php">1 journey</a>'; } ?>
		
	</div>
	<div class="onethird follow">
		<h2>Follows</h2>
		<?php  
			$follows = retrive_from_db('followed, email', 'follow, user', 'uname = followed AND follows = "' . $user[0] . '"');
			if($follows != "") {
				echo '<ul>';
				while($row = mysql_fetch_array($follows, MYSQL_NUM)) {
					printf('<li> <a href="user.php?id=%s">%s %s</a></li>', htmlentities($row[0]), '<img src="http://www.gravatar.com/avatar/' . md5( strtolower( trim($row[1]) ) ) . '?s=15" />',  htmlentities($row[0])); 
				}
				echo '</ul>';
			} else {
				echo 'no one';
			}
			echo '<h2>Followed by</h2>';
			$followed = retrive_from_db('follows, email', 'follow, user', 'uname = follows AND followed = "' . $user[0] . '"');
			if($followed != "") {
				echo '<ul>';
				while($row = mysql_fetch_array($followed, MYSQL_NUM)) {
					printf('<li> <a href="user.php?id=%s">%s %s</a></li>', htmlentities($row[0]), '<img src="http://www.gravatar.com/avatar/' . md5( strtolower( trim($row[1]) ) ) . '?s=15" />',  htmlentities($row[0]));
				}
				echo '</ul>';
			} else {
				echo 'no one.';
			}
		?>
	</div>
	
<?php include('PHPkoder/footer.php'); ?>
	