<?php
if(!isset($_GET['id'])) {
	die();
}
include "include/config.php";
if (!$_SESSION) session_start();
	
$id = intval($_GET['id']);

$sql = "select * from rest
		 JOIN user ON rest.user_id = user.user_id 
		 JOIN food_type ON rest.food_type = food_type.food_id
		 WHERE rest_id = " . $id . " LIMIT 1 ";
$result = mysql_query($sql);
if (mysql_num_rows($result) > 0) {
	$row = mysql_fetch_assoc($result);
	$result = mysql_query($sql);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title></title>
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/standard.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
  var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	codeAddress();
  }

  function codeAddress() {
    var address = "<?php echo $row['address']; ?>";
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map, 
            position: results[0].geometry.location
        });
      } else {
		alert("Restaurang address not found");
        //alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
	

</script>
</head>
<body onload="initialize()">
<a href="index.php?page=list">Go back</a>
<?php include "include/list.php";?>
<div id="map_canvas" style="height:90%"></div>
</body>
</html>
