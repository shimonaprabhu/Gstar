<?php
	session_start();
	if(!$_SESSION['ID']) {  
  		header("Location: index.php");
	} 
	require_once('header.php');	
?>
		<div class="jumbotron" id="loginmain">
  			<h3 class="display text-center">Please enter login details</h3>
  			<hr class="my-4">
			<div class="form-row" id="form-center">
		  		<div class="form-group col-lg-12">
		    		<label for="InputEmail">Email</label>
		    		<input type="text" class="form-control" name="InputUSN" placeholder="Email">
		  		</div>
			  	<div class="form-group col-lg-12">
			    		<label for="InputPassword">Password</label>
			    		<input type="password" class="form-control" name="InputPassword" placeholder="Password">
			   	</div>
		   	</div>
		</div>
<script>
	$( "#logout" ).css( "visibility", "visible" );
</script>
<?php
	require_once('footer.php');	
?>
