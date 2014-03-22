<?php
	include "include/config.php";
	if (!$_SESSION) session_start();
	
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
?>
<?php include "include/list.php";?>
