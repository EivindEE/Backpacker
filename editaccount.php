<?php
	// include functions and database connection
	include('PHPkoder/database.php');
	include('PHPkoder/functions.php');
	
	
	// meta tags
	$meta = '';
	
	// page title
	$title= "Edit Account - Backpacker"; 

	// javascripts (jQuery included by default)
	$javascript = ''; // her må kartdata genereres
	
	// body onLoad
	$onLoad = '';

	include('PHPkoder/header.php');
	
	// get userdata to be edited
	if($logged_in) {
		$user = mysql_fetch_array(retrive_from_db('uname, lname, fname, email, info', 'user', 'uname = "' . $_SESSION['username'] . '"'));
	} else {
		die('Fatal server error: "User" could not be retrieved');
	} 
?>
	<!-- full / half / onethird / twothirds -->
	<div class="full">
		<?php if(isset($_GET['up'])) {
				$up = $_GET['up'];
				if($up == true) {
					echo '<h1>Account Updated</h1>updated account info and password';
				} else if($up == false) {
					echo '<h1>Account Updated</h1>updated account info';
				}
			} else {?>
		<h1>Editing <?php echo $user[0] . "\'s account"; ?></h1>	
			<form class="half" method="POST" action="PHPkoder/updateAccount.php">
				<h2>First name</h2> <input type="text" name="fname" value="<?php echo $user[2]; ?>" />
				<h2>Last name</h2> <input type="text" name="lname"  value="<?php echo $user[1]; ?>" />
				<h2>Email</h2> <input type="email" name="email" value="<?php echo $user[3]; ?>" />	
				<fieldset>
				<h2>Change Password (if change)</h2>
				<h3>Old password</h3> <input type="password" name="oldpassword" />
				<h3>New password</h3> <input type="password" name="newpassword" />
				</fieldset>
				<h2>Description</h2>
				<textarea name="info"><?php echo $user[4]; ?></textarea>
				<input type="submit" value="Submit" />
			</form>
			<div class="half">
				<h2>Notes</h2>
				<ol>
					<li>You can't change your username since we use it to identify you</li>
					<li>If you edit your password, the new password will be mailed to the email account on record</li>
					<li>Please ensure that your email is correct, if we do not have the correct email on record, you will not be able to reset your password if you forget it</li>
				</ol>
			</div>
	<?php }		
	echo '</div>';
	
 include('PHPkoder/footer.php'); ?>
	