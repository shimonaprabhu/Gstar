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
/*If the option entered by the user is to delete category and all inputs are available, perform the deletion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation. Once the category is deleted and the operation is successful, delete all the child queries so that there are no orphaned queries. Once this operation is complete and successful, we also delete all the comments that are related to all those categories that belong to that category.*/	
	if(isset($_POST['delcat'])){
		$delcat=$_POST['delcat'];
		$query4 = "SELECT cat_id from category where cat_name='$delcat'";
		$result4 = mysqli_query($conn, $query4);
	  	$row4 = mysqli_fetch_assoc($result4);$cat_id=$row4['cat_id'];
	  	$resa=mysqli_affected_rows($conn);
		$resb=mysqli_error($conn);
		if(!empty($resb)){ ?>
			<script> errordisp("<?=$resb;?>");</script>
		<?php }
		else if(empty($resa)) { ?>
			<script> errordisp("No data available in database!");</script>
		<?php }
		else {
			$query = "DELETE FROM category WHERE cat_name='$delcat'";
			$result = mysqli_query($conn, $query);
			$resa=mysqli_affected_rows($conn);
			$resb=mysqli_error($conn);
			if(!empty($resb)){ ?>
				<script> errordisp("<?=$resb;?>");</script>
			<?php }
			else if(empty($resa)) { ?>
				<script> errordisp("No data available in database!");</script>
			<?php }
			else {
				$query3 = "DELETE FROM queries WHERE cat_id='$cat_id'";
				$result3 = mysqli_query($conn, $query3);
				$resa=mysqli_affected_rows($conn);
				$resb=mysqli_error($conn);
				if(!empty($resb)){ ?>
					<script> errordisp("<?=$resb;?>");</script>
				<?php }
				else if(empty($resa)) { ?>
					<script> errordisp("No queries in this category available in database!");</script>
				<?php }
				else {
					$query2 = "DELETE FROM comments WHERE cat_id='$cat_id'";
					$result2 = mysqli_query($conn, $query2);
					$resa=mysqli_affected_rows($conn);
					$resb=mysqli_error($conn);
					if(!empty($resb)){ ?>
						<script> errordisp("<?=$resb;?>");</script>
					<?php }
					else if(empty($resa)) { ?>
						<script> errordisp("No comments in this category data available in database!");</script>
					<?php }
					else { ?>
						<script> location.replace("del_category.php"); </script>
					<?php }
				}
			}
		}
	}	
?>
<!--Create a container to show all the available categories that the admin can delete-->
		<div class="container" id="admin-cont">
			<div class="row">
<!--Include the file which shows the menu for the admin on the left-->
			<?php 
				require_once('left_nav.php');	
			?>
				<div class="col-lg-8">
					<div class="jumbotron" id="detailsmain">
			  			<h1 class="display text-center">Delete Category</h1>
			  			<hr class="my-4">
<!--Execute the query to display all the categories that can be deleted, if there are no categories or there is an error in the query, display messages accordingly-->
				  			<?php
				  				$query = "SELECT cat_name from category";
								$result = mysqli_query($conn, $query);
								$resa=mysqli_affected_rows($conn);
								$resb=mysqli_error($conn);
								if(!empty($resb)){ ?>
									<script> errordisp("<?=$resb;?>");</script>
								<?php }
								else if(empty($resa)) { ?>
									<br>
									<h3 class="display text-center">No categories in database!</h3>
								<?php }
								else { ?>
									<table>
			  							<tr>
				  							<th></th><th>Category</th>
				  							<th></th><th>Delete</th>
				  						</tr>
				  					<?php
									while($row = mysqli_fetch_assoc($result)) { ?>
										<tr>
				  							<td></td><td><?=$row['cat_name'];?></td>
				  							<td></td><td>
				  								<form action="del_category.php" method="post">
													<input type="hidden" name="delcat" value="<?=$row['cat_name'];?>">
													<input type="submit" value="-" class="btn justify-content-center" id="button">
												</form>
				  							</td>
				  						</tr>
									<?php }
								}
				  			?>
			  			</table>
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
