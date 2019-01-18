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
					<div class="jumbotron" id="detailsmain">
			  			<h1 class="display text-center">Modify Details</h1>
			  			<hr class="my-4">
					  	<form action="server.php" method="get">
							<div class="form-row" id="form-center">
						  		<div class="form-group col-lg-12">
						    		<label for="InputUserID">Existing User ID</label>
						    		<input type="text" class="form-control" name="InputUserID" placeholder="Existing User ID">
						  		</div>
						  	</div>
							<div class="form-row" id="form-center">
						  		<div class="form-group col-lg-12">
						    		<label for="InputEmail">Email</label>
						    		<input type="text" class="form-control" name="InputEmail" placeholder="Email">
						  		</div>
						  	</div>
							<div class="form-row" id="form-center">
							  	<div class="form-group col-lg-12">
							    	<label for="InputPhone">Phone</label>
							    	<input type="text" class="form-control" name="InputPhone" placeholder="Phone">
							   	</div>
							</div>
							<div class="form-row" id="form-center">
							 	<div class="form-group col-lg-12">
							   		<label for="type">Privilege</label>
							      	<select name="type" id="type" class="form-control">
							        	<option value="admin">Administrator</option>
							        	<option value="regular">Regular User</option>
							      	</select>
							   </div>
						   	</div>
						   	<div id="btngrp">
							  <input type="submit" value="Submit" class="btn justify-content-center" id="button">
						  	</div>
						  	<input type="hidden" name="modify" value="mod_user">
						</form>
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
