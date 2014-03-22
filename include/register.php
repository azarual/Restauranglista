<?php if(isset($_POST['username'])) {
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$email = mysql_real_escape_string($_POST['email']);
	
	// recaptcha
	require_once('recaptchalib.php');
	$privatekey = "6LfQJb0SAAAAAIi4SRhutTS_CyktssenU_JNfnjL";
	$resp = recaptcha_check_answer ($privatekey,
	                                $_SERVER["REMOTE_ADDR"],
	                                $_POST["recaptcha_challenge_field"],
	                                $_POST["recaptcha_response_field"]);
 
	$result = mysql_query("SELECT user_id FROM user WHERE username = '" . $username . "' OR email = '" . $email . "' LIMIT 1; ");
	if (mysql_num_rows($result) == 0 && $resp->is_valid) {
		$result = mysql_query("INSERT INTO user (username, password, email) VALUES ('" . $username . "', '" . md5($password) . "', '" . $email . "');");
		$_SESSION['user_id'] = mysql_insert_id();
		header("location: index.php?page=add");
	}
}
?>
<form action="index.php?page=register" method="post">
	<label for="username">Username</label><input type="text" id="username" name="username" />
	<label for="email">Email</label><input type="text" id="email" name="email" />
	<label for="password">Password</label><input type="password" id="password" name="password" />
<?php
  require_once('recaptchalib.php');
  $publickey = "6LfQJb0SAAAAAG_DddtlFjIMImbhV9DWvfohtXTI"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
?>
	<input type="submit" value="register" />
</form>
