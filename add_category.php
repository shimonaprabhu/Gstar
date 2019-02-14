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
	$cat=$_POST['InputCategory'];
/*If the option entered by the user is to add category and all inputs are available, perform the insertion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation */
	if(!empty($cat) && $_POST['modify']=='add_cat') {
	    $query = "INSERT INTO category VALUES ('','$cat')";
		$result = mysqli_query($conn, $query);
		$resb=mysqli_error($conn);
		if(!empty($resb)){ ?>
			<script> errordisp("<?=$resb;?>");</script>
		<?php }
		else { ?>
			<script> location.replace("add_category.php"); </script>
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
			  			<h1 class="display text-center">Add Category</h1>
			  			<hr class="my-4">
					  	<form action="add_category.php" method="post">
							<div class="form-row" id="form-center">
						  		<div class="form-group col-lg-12">
						    		<label for="InputCategory">Category<span class="error">*</span></label>
						    		<input required type="text" class="form-control" name="InputCategory" placeholder="Category">
						  		</div>
						  	</div>
						  	<br>
							<br>
							<span class="error">* Required Fields</span>
							<br>
							<br>
						   	<div id="btngrp">
							  <input type="submit" value="Submit" class="btn justify-content-center" id="button">
						  	</div>
						  	<input type="hidden" name="modify" value="add_cat">
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
