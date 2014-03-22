<?php

require_once "common.php";
session_start();

function escape($thing) {
    return htmlentities($thing);
}

function run() {
    $consumer = getConsumer();

    // Complete the authentication process using the server's
    // response.
    $return_to = getReturnTo();
    $response = $consumer->complete($return_to);

    // Check the response status.
    if ($response->status == Auth_OpenID_CANCEL) {
        // This means the authentication was cancelled.
        $msg = 'Verification cancelled.';
    } else if ($response->status == Auth_OpenID_FAILURE) {
        // Authentication failed; display the error message.
        $msg = "OpenID authentication failed: " . $response->message;
    } else if ($response->status == Auth_OpenID_SUCCESS) {
        // This means the authentication succeeded; extract the
        // identity URL and Simple Registration data (if it was
        // returned).
        $openid = $response->getDisplayIdentifier();
        $esc_identity = escape($openid);

        $success = sprintf('You have successfully verified ' .
                           '<a href="%s">%s</a> as your identity.',
                           $esc_identity, $esc_identity);
		
		include "../include/config.php";
		$result = mysql_query("select user_id from user_openids where openid_url = '" . $esc_identity . "' ");
		if (mysql_num_rows($result) > 0) {
		// login
			$_SESSION['user_id'] = mysql_result($result, 0);
			header("location: http://restauranglista.se/");
		} else {
		// register or connect to an account
			$_SESSION['openid_url'] = $esc_identity;
			//header("location: ../index.php?page=login");
			
			$result = mysql_query("INSERT INTO user (username) VALUES('');");
			$_SESSION['user_id'] = mysql_insert_id();
			mysql_query("insert into user_openids (openid_url, user_id) 
						 values ('" . $_SESSION['openid_url'] . "', '" . $_SESSION['user_id'] . "') ");
			header("location: http://restauranglista.se/");
		}
		
    }
	?><a href="index.php?page=list">Go back</a><?php
	if (isset($msg)) { print "<div class=\"alert\">$msg</div>"; } 
    if (isset($error)) { print "<div class=\"error\">$error</div>"; } 
    if (isset($success)) { print "<div class=\"success\">$success</div>"; }
}

run();

?>