<?php
	session_start();
	require_once('header.php');	
	require_once('operror.php');
	if ($_SESSION['access']=='error') { ?>
  		<script> errordisp("You cannot access this page, please contact admin.");</script>
	<?php }

/*Include the files to make connection to the DB and also include script files. operror is used for displaying error messages*/	

/*To maintain the logged in state, create the session and then check if the user has accessed a page that is not within his privilege. If yes, the display the appropriate message*/

/*If all the login credentials are available, perform the selection operation on the database to check if the user exists and if he exists, check if his privileges are admin or regular, checking for errors, displaying the appropriate error message, else redirecting to the appropriate page according to the permissions */

		if(!empty($_POST['InputUserID']) && !empty($_POST['InputPassword'])) {
		    if($_POST['type']=='admin'){
		    	$ID=$_POST['InputUserID'];
	       		$password=md5($_POST['InputPassword']);
	       		$privilege=$_POST['type'];
		    	$query = "SELECT * from user where id='$ID' && password='$password' && privilege='$privilege'";
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
					while($row = mysqli_fetch_assoc($result)) {
						if ($row["privilege"]=='admin') { 
							$_SESSION['ID']=$ID; 
							$_SESSION['type']='admin'; ?>
						    <script> location.replace("admin.php"); </script>
						<?php }
					}
				}	      	
			}
			else if ($_POST['type']=='regular') {
		    	$ID=$_POST['InputUserID'];
	       		$password=md5($_POST['InputPassword']);
	       		$privilege=$_POST['type'];
		    	$query = "SELECT * from user where id='$ID' && password='$password' && privilege='$privilege'";
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
					while($row = mysqli_fetch_assoc($result)) {
						if ($row["privilege"]=='regular') { 
							$_SESSION['ID']=$ID; 
							$_SESSION['type']='regular'; ?>
						    <script> location.replace("regular.php"); </script>
						<?php }
					}
				}	      	
			}
		}
?>
<!--Create a container to show form input elements to take in user inputs-->
		<div class="container">	
			<div class="jumbotron" id="loginmain">
	  			<h3 class="display text-center">Please enter login details</h3>
	  			<hr class="my-4">
	  			<form action="index.php" method="post">
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
										<option value="" disabled selected hidden>Options</option>
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
<!--Once the index.php page is loaded, i.e. once the home page is loaded, automatically logout-->
		<script>
			$(document).ready(function(){
				require_once('logout.php');	
			})
		</script>
<!--Include the file that contains the display of footer-->

<?php
	require_once('footer.php');	
?>
