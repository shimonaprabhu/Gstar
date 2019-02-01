<?php
	session_start();
	if(!$_SESSION['ID'] || $_SESSION['type']!='regular') {  
  		header("Location: index.php");
  		$_SESSION['access']='error';
	} 

/*To maintain the logged in state, create the session and then check if the session exists in the database and if the privilege is regular*/

/*Include the files to make connection to the DB and also include script files. operror is used for displaying error messages*/	
	require_once('header.php');
	require_once('operror.php');	

?>
<!--Display all the options available to the admin in the left navbar-->
				<div class="col-lg-4" id="side-bar-admin">
					<div class="jumbotron" id="menu-admin">
							<div class="row">
								<a href="regular.php">Dashboard</a>
							</div>
<!--Display all the categories available by executing the queries and on clicking the category, submit a form that will display all the queries for that particular category. This will only be a user view, not admin view.-->
							<?php
				  				$query = "SELECT cat_name from category";
								$result = mysqli_query($conn, $query);
								$count=mysqli_num_rows($result);
								$resa=mysqli_affected_rows($conn);
								$resb=mysqli_error($conn);
								if(!empty($resb)){ ?>
									<script> errordisp("<?=$resb;?>");</script>
								<?php }
								else if(empty($resa)) { ?>
									<a href="admin.php">No Categories available</a>
								<?php }
								else {
									while($row = mysqli_fetch_assoc($result)) { ?>
										<div class="row">
											<form action="landing.php" method="post" id="form<?=$row['cat_name'];?>">
												<input type="hidden" name="cat" value="<?=$row['cat_name'];?>">
												<a id="itemreg" href="javascript:{}" onclick="submit('form<?=$row['cat_name'];?>');"><?=$row['cat_name'];?></a>
											</form>
										</div>
									<?php }
								}
		  					?>
					</div>
				</div>
			<script>
				function submit(id){
					document.getElementById(id).submit(); 
					return false;
				}
			</script>