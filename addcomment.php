<?php if($logged_in) { ?>
<h3><?php echo $_SESSION['username'] . ':'; ?></h3>
<form action="PHPkoder/insertComment.php" method="POST" id="addReview" accept-charset="utf-8">
	<textarea name="comment" id="addComment"></textarea>
	Grade: <select name="grade">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
	</select>
	<input type="hidden" name="location_id" value="<?php if(isset($location_id)) { echo $location_id; } else { echo '0'; } ?>" />
	
	<input type="hidden" name="region" value="<?php if(isset($location_id)) { echo '0'; } else { echo $region; } ?>" />
	<input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" />
	<input type="submit" value="Add My Voice" />
</form>
<?php } ?>
