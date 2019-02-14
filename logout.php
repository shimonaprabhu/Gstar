<?php
	session_start();
	session_destroy();
	header('Location: index.php');
	$_SESSION['access']='';
?>
<!--To logout from the session, delete the session variables-->
