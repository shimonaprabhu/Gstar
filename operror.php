<?php
	session_start();
	if(!$_SESSION['ID']) {  
  		header("Location: index.php");
	} 
	require_once('header.php');	
?>
		<div class="jumbotron" id="loginmain">
  			<h1 class="display text-center">Operation unsuccessful!</h1>
  			<hr class="my-4">
  			<div id="btngrp">
  				<a href="admin.php" class="btn justify-content-center" id="button">Dashboard</a>
			</div>
		</div>
<script>
	$( "#logout" ).css( "visibility", "visible" );
</script>
<?php
	require_once('footer.php');	
?>
