<?php
include('include/config.php');
session_start();
ob_start();
if($_GET['theme'] == 'dark'){
	$_SESSION['theme'] = 'dark';
} elseif($_GET['theme'] == 'light'){
        $_SESSION['theme'] = 'light';
}

if($_GET['page'] == 'log_out'){
	unset($_SESSION['user_id']);
}

include("include/header.php");

if($_GET['page'] == "login"){
	include("include/login.php");
} elseif ($_GET['page'] == "register") {
	include('include/register.php');
} elseif ($_GET['page'] == "review") {
	include('include/review.php');
} elseif($_GET['page'] == "add" && isset($_SESSION['user_id'])){
	include("include/add.php");
} elseif($_GET['page'] == "view_my_rests" && isset($_SESSION['user_id'])){
	$result = mysql_query("SELECT * FROM rest 
						JOIN user ON rest.user_id = user.user_id 
						JOIN food_type ON rest.food_type = food_type.food_id
						WHERE rest.user_id = " . $_SESSION['user_id']);
	include("include/list_update.php");
} elseif($_GET['page'] == "view_my_favs" && isset($_SESSION['user_id'])){
	/* $result = mysql_query("SELECT *,rest.rest_id AS rest_id FROM rest 
						JOIN user ON rest.user_id = user.user_id 
						JOIN food_type ON rest.food_type = food_type.food_id
						JOIN rest_fav ON rest.rest_id = rest_fav.rest_id
						WHERE rest.user_id = " . $_SESSION['user_id']); */
	 $result = mysql_query("SELECT *,rest.rest_id AS rest_id FROM rest_fav 
					JOIN user ON rest_fav.user_id = user.user_id 
					JOIN rest ON rest_fav.rest_id = rest.rest_id
					JOIN food_type ON rest.food_type = food_type.food_id
					WHERE rest_fav.user_id = " . $_SESSION['user_id']); 
	include("include/list.php");
} else {
	if(isset($_GET["search"])){
		$sql = "select * from rest
				 JOIN user ON rest.user_id = user.user_id 
				 JOIN food_type ON rest.food_type = food_type.food_id
				 WHERE (name LIKE '%" . mysql_real_escape_string($_GET["search"]) . "%' 
				 OR address LIKE '%" . mysql_real_escape_string($_GET["search"]) . "%'
				 OR open_time LIKE '%" . mysql_real_escape_string($_GET["search"]) . "%') ";
		if (isset($_GET['food_type']) && intval($_GET['food_type']) != 0) {
			$sql .= " AND food_type = " . intval($_GET['food_type']);
		}
		$result = mysql_query($sql);
	}
	else{
	$result = mysql_query("SELECT * FROM rest JOIN user ON rest.user_id = user.user_id JOIN food_type ON rest.food_type = food_type.food_id");
}
	include("include/list.php");
}

include("include/footer.php");
?>
