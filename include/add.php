<?php if(isset($_POST['name'],$_POST['address'],$_POST['open_time'],$_POST['food_type'])) {
	$name = mysql_real_escape_string($_POST['name']);
	$address = mysql_real_escape_string($_POST['address']);
	$open_time = mysql_real_escape_string($_POST['open_time']);
	$food_type = intval($_POST['food_type']);
	
	mysql_query("insert into rest (name, address, open_time, food_type, user_id) 
	values('" . $name . "', '" . $address . "', '" . $open_time . "', " . $food_type . ", " . $_SESSION["user_id"] . ")");
	header("location: index.php?page=view_my_rests");
} ?>

<form action="index.php?page=add" method="post">
	<label for="name">Name</label><input type="text" id="name" name="name" />
	<label for="address">Address</label><input type="text" id="address" name="address" />
	<label for="open_time">Open time</label><input type="text" id="open_time" name="open_time" />
    <label for="food_type">Food Type</label>
	<select id="food_type" name="food_type">
	<?php $r = mysql_query("SELECT * FROM food_type"); 
		while($row = mysql_fetch_assoc($r)) { ?>	
		<option value="<?php echo $row['food_id']; ?>"><?php echo $row['type']; ?></option>
	<?php }	?>
	</select>
	
	<input type="submit" value="Add restaurang" />
	
</form>
