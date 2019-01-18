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
			  			<h1 class="display text-center">Delete User</h1>
			  			<hr class="my-4">
				  			<?php
				  				$query = "SELECT * from user";
								$result = mysqli_query($conn, $query);
								$count=mysqli_num_rows($result);
								if($count==0){ ?>
									<h5>No users in database</h5>
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
						  						<a href="server.php?delete=<?=$row['id'];?>" class="btn btn-default btn-xs" id="delbutton">-</span></a>
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
<script>
	$( "#logout" ).css( "visibility", "visible" );
</script>
<?php
	require_once('footer.php');	
?>
