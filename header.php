<!--Display the logout button which is hidden by default-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Portal</title>
<!--link to necessary CDN's needed for Bootstrap, jQuery-->
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="CSS/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<!--Conection to the database-->
		<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "resolution";
			// Create connection
			$conn = mysqli_connect($servername, $username, $password, $dbname);
		?>
	</head>
<!--Create the navbar common to all pages, containing links to the main page and top navbar-->
	<body id="background">
		<ul class="nav flex-column sticky-top">
  			<li class="nav-item navbar" id="top">
    			<a class="navbar-brand nav" href="index.php"><img src="logo.png">  Accord Software & Systems Pvt. Ltd.</a>
  			</li>
  			<li class="nav-item navbar">
				<a class="navbar-brand nav" href="index.php">Portal</a>
		  		<a class="navbar-brand nav" id="logout" href="logout.php">Logout</a>
  			</li>
		</ul>


