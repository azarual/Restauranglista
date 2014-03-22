<?php
if (!isset($_GET['id'])) {
	return;
}

$id = intval($_GET['id']);

// insert
if(isset($_POST['review'])) {
	$review = mysql_real_escape_string($_POST['review']);
	
	mysql_query("INSERT INTO rest_review (content, rest_id, user_id) 
	VALUES ('" . $review . "', " . $id . ", " . $_SESSION["user_id"] . ")");
	header("location: index.php?page=review&id=".$id);
} 

$sql = "select * from rest
		 JOIN user ON rest.user_id = user.user_id 
		 JOIN food_type ON rest.food_type = food_type.food_id
		 WHERE rest_id = " . $id . " LIMIT 1 ";
$result = mysql_query($sql);
?>
<?php include "include/list.php";?>
<hr />
<h1>Review</h1>
<?php 
$result = mysql_query("SELECT * FROM rest_review WHERE rest_id = " . $id . " LIMIT 1");
while ($row = mysql_fetch_assoc($result)) { ?>
<div class="review"><?php echo $row['content'];?><br /><?php echo $row['date'];?></div>
<?php } ?>
<?php if (isset($_SESSION['user_id'])) { ?>
<form action="index.php?page=review&id=<?php echo $id; ?>" method="post">
	<label for="review">Review</label>
	<textarea id="review" name="review"></textarea>
	<input type="submit" value="Add review" />
</form>
<?php } ?>