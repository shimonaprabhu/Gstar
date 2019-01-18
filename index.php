<?php
	session_start();
	require_once('header.php');	
		if(!empty($_GET['InputUserID']) && !empty($_GET['InputPassword'])) {
		    if($_GET['type']=='admin'){
		    	$ID=$_GET['InputUserID'];
	       		$password=md5($_GET['InputPassword']);
	       		$privilege=$_GET['type'];
		    	$query = "SELECT * from user where id='$ID' && password='$password' && privilege='$privilege'";
				$result = mysqli_query($conn, $query);
				$count=mysqli_num_rows($result);
				if($count==0){ ?>
					<script> location.replace("loginerror.php"); </script>
				<?php }
				else {
					while($row = mysqli_fetch_assoc($result)) {
						if ($row["privilege"]=='admin') { 
							$_SESSION['ID']=$ID; ?>
						    <script> location.replace("admin.php"); </script>
						<?php }
					}
				}	      	
			}
			else if ($_GET['type']=='regular') {
		    	$ID=$_GET['InputUserID'];
	       		$password=md5($_GET['InputPassword']);
	       		$privilege=$_GET['type'];
		    	$query = "SELECT * from user where id='$ID' && password='$password' && privilege='$privilege'";
				$result = mysqli_query($conn, $query);
				$count=mysqli_num_rows($result);
				if($count==0){ ?>
					<script> location.replace("loginerror.php"); </script>
				<?php }
				else {
					while($row = mysqli_fetch_assoc($result)) {
						if ($row["privilege"]=='regular') { 
							$_SESSION['ID']=$ID; ?>
						    <script> location.replace("regular.php"); </script>
						<?php }
					}
				}	      	
			}
		}
?>
		<div class="container">	
			<div class="jumbotron" id="loginmain">
	  			<h3 class="display text-center">Please enter login details</h3>
	  			<hr class="my-4">
	  			<form action="index.php" method="get">
					<table>
							<tr>
								<td><br><label for="InputUserID">User ID</label></td>
								<td><br><input type="text" class="form-control" name="InputUserID" placeholder="User ID" size="50"></td>
							</tr>
							<tr>
								<td><label for="InputPassword">Password</label></td>
								<td><input type="password" class="form-control" name="InputPassword" placeholder="Password" size="50"></td>
							</tr>
							<tr>
								<td><label for="type">Privilege</label></td>
								<td>
									<select name="type" id="type" class="form-control">
										<option value="admin">Administrator</option>
										<option value="regular">Regular User</option>
									</select>
								</td>
							</tr>
					</table>
				   	<div id="btngrp">
					  <input type="submit" value="Submit" class="btn justify-content-center" id="button">
				  	</div>
				</form>
			</div>
		</div>
<?php
	require_once('footer.php');	
?>
