<div>
	<form action="" method="get" id="search_form" onsubmit="return form_action(this);">
		<input type="text" onkeyup="enterkey(this);" name="search" id="search"/>
		<select id="food_type_search" name="food_type" onchange="filter_search();">
			<option value="0">All types</option>
		<?php $r = mysql_query("SELECT * FROM food_type"); 
			while($row = mysql_fetch_assoc($r)) { ?>	
			<option value="<?php echo $row['food_id']; ?>"><?php echo $row['type']; ?></option>
		<?php }	?>
		</select>
		<input type="submit" value="Search"/>
	</form>
</div>

<div id = "search_result">
</div>


<div>
<?php if (isset($_SESSION['user_id'])) { ?>
	<a href="index.php?page=add">Add</a>
	<a href="index.php?page=view_my_rests">My restaurangs</a>
	<a href="index.php?page=view_my_favs">My favourites</a>
	<a href="index.php?page=log_out">Log out</a>
<?php } else { ?>
	<a target="_top" href="index.php?page=login">Login</a>
	<a href="index.php?page=register">Register</a>
<?php } ?>
	<a href="index.php?page=list">All restaurangs</a>
        <a href="index.php?theme=dark">Dark theme</a>
        <a href="index.php?theme=light">Light theme</a>

</div>

