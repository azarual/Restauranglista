<?php 
// update fav
if(isset($_GET['id'],$_GET['fav'])) {
	$id = intval($_GET['id']);
	$fav = $_GET['fav'];
	
	if ($fav == "yes") {
		mysql_query("INSERT INTO rest_fav (rest_id, user_id) 
					VALUES (" . $id . ", " . $_SESSION["user_id"] . ")");
	} else {
		mysql_query("DELETE FROM rest_fav
					WHERE rest_id = " . $id . "
					AND user_id = " . $_SESSION["user_id"] . " ");
	}
	header("location: index.php?page=list");
} ?>
<table>
        <tr>
				<th>Fav</th>
                <th>Name</th>
                <th>Address</th>
                <th>Open time</th>
                <th>Food_type</th>
				<th>Likes</th>
				<th>Review</th>
        </tr>
<?php while($row = mysql_fetch_assoc($result)) { ?>
	<tr>
		<?php if (isset($_SESSION["user_id"])) { 
			$r = mysql_query("SELECT * FROM rest_fav 
						WHERE user_id = " . $_SESSION["user_id"] . " 
						AND rest_id = " . $row['rest_id'] . " LIMIT 1"); 
			if (mysql_num_rows($r) > 0) {
		?>
		<td><a href="index.php?page=list&id=<?php echo $row['rest_id']; ?>&fav=no">yes</a></td>
		<?php 	} else { ?>
		<td><a href="index.php?page=list&id=<?php echo $row['rest_id']; ?>&fav=yes">no</a></td>
		<?php 	} ?>
		<?php } else { ?>
		<td>no</td>
		<?php } ?>
		<td><?php echo $row['name']; ?></td>
		<td><a href="find_geo.php?id=<?php echo $row['rest_id']; ?>"><?php echo $row['address']; ?></a></td>
		<td><?php echo $row['open_time']; ?></td>
		<td><?php echo $row['type']; ?></td>
		<td><?php $r = mysql_query("SELECT COUNT(rest_id) AS likes 
					FROM rest_fav WHERE rest_id = " . $row['rest_id']);
		echo mysql_result($r, 0);
		?></td>
		<td><a href="index.php?page=review&id=<?php echo $row['rest_id']; ?>">Review</a></td>
	</tr>
<?php } ?>
</table>
