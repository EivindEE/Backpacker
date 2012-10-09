<?php
session_start(); 
include("database.php");
include("login.php");
include("functions.php");
//displayLogin();
if($logged_in) {
	$table = 'review';
	$lname = $_REQUEST['lname'];
	$fname = $_REQUEST['fname'];
	$email = $_REQUEST['email'];
	$info = $_REQUEST['info'];
	
	
	$updatePass = checkPassword();
	
	if($updatePass) {  
		update_db('user', 'fname = "' . $fname . '", lname= "' . $lname . '", email= "' . $email . '", info= "' . $info . '", upassword= "' . $updatePass . '"', 'uname = "' . $_SESSION['username'] .'"');
		mysql_close($conn);
		header('Location: ' . $_SERVER['HTTP_REFERER'] . '?up=true');
	} else {
		update_db('user', 'fname = "' . $fname . '", lname= "' . $lname . '", email= "' . $email . '", info= "' . $info . '"', 'uname = "' . $_SESSION['username'] .'"');
		mysql_close($conn);
		header('Location: ' . $_SERVER['HTTP_REFERER'] . '?up=false');
	}
} else {
	mysql_close($conn);
	header('Location: ' . $_SERVER['HTTP_REFERER']. '?up=failed');
}
// check if password is  to be updated
function checkPassword() {
	if(isset($_REQUEST['oldpassword']) && isset($_REQUEST['newpassword'])) {
	
		// request stated old password as md5
		$oldpassword = md5($_REQUEST['oldpassword']);
		
		// retrieve stored password
		$user = mysql_fetch_array(retrive_from_db('upassword', 'user', 'uname = "' . $_SESSION['username'] . '"'));
		
		if($oldpassword == $user[0]) {
			// update password
			return md5($_REQUEST['newpassword']);
		} 
		
		else {
			// do not update
			return false;
		}
	} else {
		// do not update
		return false;
	}
}

?>