<?php
	session_start();
	if(!$_SESSION['ID'] || $_SESSION['type']!='admin') {  
  		header("Location: index.php");
  		$_SESSION['access']='error';
	} 

/*To maintain the logged in state, create the session and then check if the session exists in the database and if the privilege is admin*/

/*Include the used for displaying error messages*/	
	require_once('operror.php');
?>
<!--Display all the options available to the admin in the left navbar-->
				<div class="col-lg-4" id="side-bar-admin">
					<div class="jumbotron" id="menu-admin">
						<!--Create a dropdown menu that displays all the categories available by executing the queries and on clicking the category, submit a form that will display all the queries for that particular category. This will be an admin view, not containing some of the functions of the regular user like add comments-->
						<div class="row" id="dropdown">
							<div class="dropright">
		  						<a class="dropdown-toggle" href="queries.php" role="button" data-toggle="dropdown">Categories</a>
  								<div class="dropdown-menu" id="menu">
    								<?php
	  									$query = "SELECT cat_name, cat_id from category";
										$result = mysqli_query($conn, $query);
										$resa=mysqli_affected_rows($conn);
										$resb=mysqli_error($conn);
										if(!empty($resb)){ ?>
											<script> errordisp("<?=$resb;?>");</script>
										<?php }
										else if(empty($resa)) { ?>
											<a id="item" href="admin.php">No Categories available</a>
										<?php }
										else {
											while($row = mysqli_fetch_assoc($result)) { ?>
												<a id="item" name="<?=$row['cat_id'];?>" href="queries.php" onclick="func('<?=$row['cat_id'];?>');"><?=$row['cat_name'];?></a>
												<!-- <form action="queries.php" method="post" id="form<?=$row['cat_name'];?>">
													<input type="hidden" name="cat" value="<?=$row['cat_name'];?>">
													<a id="item" href="javascript:{}" onclick="submit('form<?=$row['cat_name'];?>');"><?=$row['cat_name'];?></a>
												</form> -->
											<?php }
										}
					  				?>
								</div>
							</div>
						</div>
						<div class="row">
							<a href="admin.php">Dashboard</a>
						</div>
						<div class="row">
							<a href="add_user.php">Add User</a>
						</div>
						<div class="row">
							<a href="del_user.php">Delete User</a>
						</div>
						<div class="row">
							<a href="mod_user.php">Modify User</a>
						</div>
						<div class="row">
							<a href="add_category.php">Add Category</a>
						</div>
						<div class="row">
							<a href="del_category.php">Delete Category</a>
						</div>
						<div class="row">
							<a href="modify_category.php">Modify Category</a>
						</div>
						<div class="row">
							<a href="post_query.php">Post Query</a>
						</div>
					</div>
				</div>

<!--Function to submit form on clicking a link-->
			<script>
				function submit(id){
					document.getElementById(id).submit(); 
					return false;
				}
				function func(val) {
			    var val1 = $("a[name="+val+"]").text();
			    $.ajax({
			        type: 'POST',
			        url: 'server.php',
			        data: { text1: val1 },
			        error: function () {
			        	errordisp("Unsuccessful operation!");
			      }
			    });
			}
			</script>