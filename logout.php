<?php
	session_start();
	session_destroy();
	header('Location: index.php');
?>
<!--To logout from the session, delete the session variables-->
