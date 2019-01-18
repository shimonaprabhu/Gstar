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
			  			<h1 class="display text-center">Enter Category</h1>
			  			<hr class="my-4">
					  	<form action="server.php" method="get">
							<div class="form-row" id="form-center">
						  		<div class="form-group col-lg-12">
						    		<label for="InputCategory">Category</label>
						    		<input type="text" class="form-control" name="InputCategory" placeholder="Category">
						  		</div>
						  	</div>
						   	<div id="btngrp">
							  <input type="submit" value="Submit" class="btn justify-content-center" id="button">
						  	</div>
						  	<input type="hidden" name="modify" value="add_cat">
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
