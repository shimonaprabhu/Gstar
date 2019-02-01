<?php
	session_start();
	if(!$_SESSION['ID']  || $_SESSION['type']!='admin') {  
  		header("Location: index.php");
  		$_SESSION['access']='error';
	} 

/*To maintain the logged in state, create the session and then check if the session exists in the database and if the privilege is admin*/

/*Extract data posted using the form and include the files to make connection to the DB and also include script files. operror is used for displaying error messages*/	
	require_once('header.php');	
	require_once('operror.php');
/*If the option entered by the user is to delete user and all inputs are available, perform the deletion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation */	
	if(isset($_POST['delete'])){
		$id=$_POST['delete'];
		$query = "DELETE FROM user WHERE id='$id'";
		$result = mysqli_query($conn, $query);
		$resa=mysqli_affected_rows($conn);
		$resb=mysqli_error($conn);
		if(!empty($resb)){ ?>
			<script> errordisp("<?=$resb;?>");</script>
		<?php }
		else if(empty($resa)) { ?>
			<script> errordisp("No data available in database!");</script>
		<?php }
		else { ?>
			<script> location.replace("del_user.php"); </script>
		<?php }
	}
?>
<!--Create a container to show all the available users that the admin can delete-->
		<div class="container" id="admin-cont">
			<div class="row">
<!--Include the file which shows the menu for the admin on the left-->
			<?php 
				require_once('left_nav.php');	
			?>
				<div class="col-lg-8">
					<div class="jumbotron" id="detailsmain">
			  			<h1 class="display text-center">Delete User</h1>
			  			<hr class="my-4">
<!--Execute the query to display all the users that can be deleted, if there are no users or there is an error in the query, display messages accordingly-->
				  			<?php
				  				$query = "SELECT * from user";
								$result = mysqli_query($conn, $query);
								$resa=mysqli_affected_rows($conn);
								$resb=mysqli_error($conn);
								if(!empty($resb)){ ?>
									<script> errordisp("<?=$resb;?>");</script>
								<?php }
								else if(empty($resa)) { ?>
									<br>
									<h3 class="display text-center">No users in database!</h3>
								<?php }
								else { ?>
									<table>
			  							<tr>
				  							<th>User ID</th>
				  							<th>Privilege</th>
				  							<th>Email</th>
				  							<th>Phone</th>
				  							<th>Delete</th>
				  						</tr>
				  					<?php
									while($row = mysqli_fetch_assoc($result)) { ?>
										<tr>
				  							<td><?=$row['id'];?></td>
				  							<td><?=$row['privilege'];?></td>
				  							<td><?=$row['email'];?></td>
				  							<td><?=$row['phone'];?></td>
				  							<td>
				  								<form action="del_user.php" method="post">
													<input type="hidden" name="delete" value="<?=$row['id'];?>">
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
