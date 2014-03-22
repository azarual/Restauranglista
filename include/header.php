<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Restaurang Yap list</title>
<?php if ($_SESSION['theme'] == 'dark') { ?>
<link type="text/css" rel="stylesheet" href="include/dark.css" />
<?php } else { ?>
<link type="text/css" rel="stylesheet" href="include/light.css" />
<?php } ?>

<!-- Simple OpenID Selector -->
<link rel="stylesheet" href="openid-selector/css/openid.css" />
<script type="text/javascript" src="openid-selector/js/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="openid-selector/js/openid-jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	openid.img_path = 'openid-selector/images/';
	openid.init('openid_identifier');
});
</script>
<!-- /Simple OpenID Selector -->

<script>
function createxhr(){
		var xmlHttp = false;
		if(window.XMLHttpRequest){xmlHttp = new XMLHttpRequest();}
		else if(window.ActiveXObject) {
					try {xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");}
					catch(e){
							try{xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");}
							catch(e){
									alert("Your browser does not support AJAX!");
									return false;
								}
							}
						}
		return xmlHttp;
}



function enterkey(e)
{
	var xhr = createxhr();
	/*if (document.getElementById("food_type_search").value != 0) {
		xhr.open("GET", "search_db.php?type=" + document.getElementById("food_type_search").value + "&search=" + encodeURIComponent(e.value) +"&" + Math.random(), true);
	} else {*/
		xhr.open("GET", "search_db.php?search=" + encodeURIComponent(e.value) +"&" + Math.random(), true);
	//}
	xhr.onreadystatechange=function()
		{
				if(xhr.readyState==4 && xhr.status == 200)
				{
						document.getElementById("search_result").innerHTML = xhr.responseText;
						filter_search();
				}
		}
			xhr.send(null);
}

function filter_search() {
	var result = document.getElementById("search_result").getElementsByTagName('tr');
	var food_type = document.getElementById("food_type_search");
	if (food_type.value != 0) {
		var selected = food_type.options[food_type.selectedIndex].text;
		for (i = 1; i < result.length; i++) {
			if (selected != result[i].children[4].innerHTML) {
				result[i].style.display = 'none';	
			} else {
				result[i].style.display = '';
			}
		}
	} else {
		for (i = 1; i < result.length; i++) {
				result[i].style.display = '';
		}
	}
}

function form_action(form) {
	window.location.href = "search-" + encodeURIComponent(document.getElementById("search").value) + "-" + document.getElementById("food_type_search").value;
	//form.action = "search-" + encodeURIComponent(document.getElementById("search").value);
	return false;
}
</script>
</head>
<body>
<?php
include("menu_header.php");

