<?php 
// update
if(isset($_POST['id'],$_POST['name'],$_POST['address'],$_POST['open_time'],$_POST['food_type'])) {
	$id = intval($_POST['id']);
	$name = mysql_real_escape_string($_POST['name']);
	$address = mysql_real_escape_string($_POST['address']);
	$open_time = mysql_real_escape_string($_POST['open_time']);
	$food_type = intval($_POST['food_type']);
	
	mysql_query("UPDATE rest SET 
				name = '" . $name . "', 
				address = '" . $address . "', 
				open_time = '" . $open_time . "', 
				food_type = " . $food_type . "
				WHERE rest_id = " . $id . "
				AND user_id = " . $_SESSION["user_id"] . " LIMIT 1 ");
	header("location: index.php?page=view_my_rests");
} elseif (isset($_POST['id'], $_GET['delete'])) {
// delete
	$id = intval($_POST['id']);
	$r = mysql_query("DELETE FROM rest 
				WHERE rest_id = " . $id . "
				AND user_id = " . $_SESSION["user_id"] . " LIMIT 1 ");
	if (mysql_affected_rows($r) > 0) {
	mysql_query("DELETE FROM rest_fav
				WHERE rest_id = " . $id . " ");
	}
	header("location: index.php?page=view_my_rests");
} ?>
<table>
        <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Open time</th>
                <th>Food_type</th>
				<th>Update</th>
				<th>Delete</th>
				<th>Likes</th>
        </tr>
<?php
$r = mysql_query("SELECT * FROM food_type"); 
$food_types = array();
while($row_food = mysql_fetch_assoc($r)) { 
	$food_types[] = $row_food;
}
while($row = mysql_fetch_assoc($result)) { ?>
<tr>
	<form action="index.php?page=view_my_rests" method="post">
		<td><input type="hidden" name="id" value="<?php echo $row['rest_id']; ?>" />
		<input type="text" name="name" value="<?php echo $row['name']; ?>" /></td>
		<td><input type="text" name="address" value="<?php echo $row['address']; ?>" /></td>
		<td><input type="text" name="open_time" value="<?php echo $row['open_time']; ?>" /></td>
		<td><select name="food_type">
		<?php 
			foreach($food_types AS $food) { 
				if ($row['food_type'] == $food['food_id']) { ?>	
			<option value="<?php echo $food['food_id']; ?>" selected><?php echo $food['type']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $food['food_id']; ?>"><?php echo $food['type']; ?></option>
			<?php } ?>
		<?php }	?>
		</select></td>
		<td><input type="submit" value="Update" /></td>
	</form>
	<form action="index.php?page=view_my_rests&delete" method="post">
		<td><input type="hidden" name="id" value="<?php echo $row['rest_id']; ?>" />
		<input type="submit" value="Update" /></td>
	</form>
	<td><?php $r = mysql_query("SELECT COUNT(rest_id) AS likes 
				FROM rest_fav WHERE rest_id = " . $row['rest_id']);
		echo mysql_result($r, 0);
	?></td>
</tr>
<?php } ?>
</table>
