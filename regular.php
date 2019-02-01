<?php
	session_start();
	if(!$_SESSION['ID'] || $_SESSION['type']!='regular') {  
  		header("Location: index.php");
  		$_SESSION['access']='error';
	} 
	require_once('header.php');	
?>

<!--To maintain the logged in state, create the session and then check if the session exists in the database and if the privilege is regular-->

<!--Create a container to contain welcome message-->
		<div class="container" id="admin-cont">
			<div class="row">
<!--Include the file which shows the menu for the regular user on the left-->
			<?php 
				require_once('left_nav_reg.php');	
			?>
				<div class="col-lg-8">
					<div class="jumbotron" id="main">
			  			<h1 class="display text-center">Welcome!</h1>
			  			<hr class="my-4">
					</div>
				</div>
			</div>
		</div>
<!--Display the logout button which is hidden by default-->
<script>
	$( "#logout" ).css( "visibility", "visible" );
</script>
<!--Include the file that contains the display of footer-->
<?php
	require_once('footer.php');	
?>
