<?php
	session_start();
	if(!$_SESSION['ID']) {  
  		header("Location: index.php");
	} 
?>
				<div class="col-lg-4" id="side-bar-admin">
					<div class="jumbotron" id="menu-admin">
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
						<div class="row" id="dropdown">
							<div class="dropright">
							  	<a class=" dropdown-toggle" href="queries.php" role="button" data-toggle="dropdown">Queries</a>
								<div class="dropdown-menu">
									<?php
				  					$query = "SELECT cat_name from category";
									$result = mysqli_query($conn, $query);
									$count=mysqli_num_rows($result);
									if($count==0){ ?>
										<a id="item" href="admin.php">No Categories available</a>
									<?php }
									else {
										while($row = mysqli_fetch_assoc($result)) { ?>
											<a id="item" href="queries.php?cat=<?=$row['cat_name'];?>"><?=urldecode($row['cat_name']);?></a>
										<?php }
										}
				  					?>
						  		</div>
							</div>
						</div>

						<div class="row">
							<a href="add_category.php">Add Category</a>
						</div>
					</div>
				</div>