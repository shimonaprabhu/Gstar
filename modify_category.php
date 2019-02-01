<?php
	session_start();
	if(!$_SESSION['ID'] || $_SESSION['type']!='admin') {  
  		header("Location: index.php");
  		$_SESSION['access']='error';
	} 

/*To maintain the logged in state, create the session and then check if the session exists in the database and if the privilege is admin*/

/*Extract data posted using the form and include the files to make connection to the DB and also include script files. operror is used for displaying error messages*/

	require_once('header.php');
	require_once('operror.php');
/*If the option entered by the user is to modify category and all inputs are available, perform the updation operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation */
	if(!empty($_POST['InputCategory']) && !empty($_POST['OutputCategory']) && $_POST['modify']=='mod_cat') {
		$ic=$_POST['InputCategory'];	
		$oc=$_POST['OutputCategory'];
		$query = "UPDATE category SET cat_name='$oc' WHERE cat_name='$ic'";
		$result = mysqli_query($conn, $query);
		$resa=mysqli_affected_rows($conn);
		$resb=mysqli_error($conn);
		if(!empty($resb)){ ?>
			<script> errordisp("<?=$resb;?>");</script>
		<?php }
		else if(empty($resa)) { ?>
			<script> errordisp("No data available in database or data already updated!");</script>
		<?php }
		else { ?>
			<script> location.replace("modify_category.php"); </script>
		<?php }
	}	
?>
<!--Create a container to show form input elements to take in user inputs-->
		<div class="container" id="admin-cont">
			<div class="row">
<!--Include the file which shows the menu for the admin on the left-->
			<?php 
				require_once('left_nav.php');	
			?>
<!--Create a container to show form input elements to take in user inputs-->
				<div class="col-lg-8">
					<div class="jumbotron" id="detailsmain">
			  			<h1 class="display text-center">Modify Category</h1>
			  			<hr class="my-4">
					  	<form action="modify_category.php" method="post">
							<div class="form-row" id="form-center">
						  		<div class="form-group col-lg-12">
						    		<label for="InputCategory">Existing Category Name</label>
						    		<input type="text" class="form-control" name="InputCategory" placeholder="Old Category">
						    		<br>
						    		<label for="OutputCategory">New Category Name</label>
						    		<input type="text" class="form-control" name="OutputCategory" placeholder="New Category">
						  		</div>
						  	</div>
						   	<div id="btngrp">
							  <input type="submit" value="Submit" class="btn justify-content-center" id="button">
						  	</div>
						  	<input type="hidden" name="modify" value="mod_cat">
						</form>
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
