<?php
	session_start();
	if(!$_SESSION['ID']) {  
  		header("Location: index.php");
	} 
	require_once('header.php');	
?>
		<div class="container" id="admin-cont">
			<div class="row">
			<?php 
				require_once('left_nav.php');	
			?>
				<div class="col-lg-8">
					<div class="jumbotron" id="main">
			  			<h1 class="display text-center">Welcome!</h1>
			  			<hr class="my-4">
					</div>
				</div>
			</div>
		</div>
<script>
	$( "#logout" ).css( "visibility", "visible" );
</script>
<?php
	require_once('footer.php');	
?>
