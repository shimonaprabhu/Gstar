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
	$problem=$_POST['problem'];
	$solution=$_POST['soln'];
	$category=$_POST['cat'];

/*Include the files to enable mailing functionality to send notification to users on new query post*/

	require_once('PHPMailer-master/PHPMailerAutoload.php');
/*If the option entered by the user is to post a query and all inputs are available, perform the insertion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation. We perform a conditional insertion, where if the solution is available, we insert the solution making it a resolved query else we leave this attrribute empty*/
	if(!empty($problem) && !empty($category) && $_POST['modify']=='post_query') {
			$query = "SELECT cat_id from category where cat_name='$category'";
			$result = mysqli_query($conn, $query);
	  		$row1 = mysqli_fetch_assoc($result);
	  		$cat_id=$row1['cat_id'];
	  		$resa=mysqli_affected_rows($conn);
			$resb=mysqli_error($conn);
			if(!empty($resb)){ ?>
				<script> errordisp("<?=$resb;?>");</script>
			<?php }
			else if(empty($resa)) { ?>
				<script> errordisp("No data available in database!");</script>
			<?php }
		  	else {
		  		if (!empty($solution)) {
					$query = "INSERT INTO queries VALUES ('','$cat_id','$problem','$solution')";
					$result2 = mysqli_query($conn, $query);
					$resb=mysqli_error($conn);
					if(!empty($resb)){ ?>
						<script> errordisp("<?=$resb;?>");</script>
					<?php }
					else { 
						if(isset($_FILES['files'])){
						foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
							$file_name = $_FILES['files']['name'][$key];
							$file_size =$_FILES['files']['size'][$key];
							$file_tmp =$_FILES['files']['tmp_name'][$key];
							$file_type=$_FILES['files']['type'][$key];
								$query = "SELECT query_id from queries where query='$problem'";
								$result = mysqli_query($conn, $query);
								$row=mysqli_fetch_assoc($result);
								$query_id=$row['query_id'];
						        $query="INSERT into files VALUES('$query_id','$file_name','$file_size','$file_type')";
						        $result = mysqli_query($conn, $query);
								$resb=mysqli_error($conn);
								if(!empty($resb)){ ?>
									<script> errordisp("File already exists");</script>
								<?php }
						        $desired_dir="Files";
						        if(is_dir("$desired_dir/".$file_name)==false){
						            move_uploaded_file($file_tmp,"Files/".$file_name);
						        }else{
						         //rename the file if another one exist
						            $new_dir="user_data/".$file_name.time();
						            rename($file_tmp,$new_dir) ;				
						        }		
						    }
						}
/*Send notifications to all users using PHPMailer functionality. Select all the emails of the users from the database, set the subject and email body, and finally configure all the attributes of the PHPMailer object.*/
						$mailSub = 'New query has been posted';
						$mailto='';
						$mailMsg = $problem;
						$query = "SELECT email from user";
						$result = mysqli_query($conn, $query);
						$resa=mysqli_affected_rows($conn);
						$resb=mysqli_error($conn);
						if(!empty($resb)){ ?>
							<script> errordisp("<?=$resb;?>");</script>
						<?php }
						else if(empty($resa)) { ?>
							<script> errordisp('No users in database to be mailed!');</script>
						<?php }
						else {
							while($row = mysqli_fetch_assoc($result)) { 
								$mailto=$row['email'];
								$mail = new PHPMailer(true);
								$mail ->IsSmtp();
								$mail ->SMTPDebug = 0;
								$mail ->SMTPAuth = true;
								$mail ->SMTPSecure = 'ssl';
								$mail ->Host = "smtp.gmail.com";
								$mail ->Port = 465; // or 587
								$mail ->IsHTML(true);
								$mail ->Username = "AttendancePortal123@gmail.com";
								$mail ->Password = "attendanceportal1*";
								$mail ->SetFrom("AttendancePortal123@gmail.com");
								$mail ->Subject = $mailSub;
								$mail ->Body = $mailMsg;
								$mail ->AddAddress($mailto);
								if(!$mail->Send()) { ?>
									<script> errordisp("Notifications was not sent!");</script>
						 		<?php }
						 		}
						}?>
						<script> location.replace("post_query.php"); </script>
					<?php }
				  	}
				else {
					$query = "INSERT INTO queries VALUES ('','$cat_id','$problem','')";
					$result3 = mysqli_query($conn, $query);
					$resb=mysqli_error($conn);
					if(!empty($resb)){ ?>
						<script> errordisp("<?=$resb;?>");</script>
					<?php }
					else { 
						if(isset($_FILES['files'])){
						foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
							$file_name = $_FILES['files']['name'][$key];
							$file_size =$_FILES['files']['size'][$key];
							$file_tmp =$_FILES['files']['tmp_name'][$key];
							$file_type=$_FILES['files']['type'][$key];
								$query = "SELECT query_id from queries where query='$problem'";
								$result = mysqli_query($conn, $query);
								$row=mysqli_fetch_assoc($result);
								$query_id=$row['query_id'];
						        $query="INSERT into files VALUES('$query_id','$file_name','$file_size','$file_type')";
						        $result = mysqli_query($conn, $query);
								$resb=mysqli_error($conn);
								if(!empty($resb)){ ?>
									<script> errordisp("File already exists");</script>
								<?php }
						        $desired_dir="Files";
						        if(is_dir("$desired_dir/".$file_name)==false){
						            move_uploaded_file($file_tmp,"Files/".$file_name);
						        }else{
						         //rename the file if another one exist
						            $new_dir="user_data/".$file_name.time();
						            rename($file_tmp,$new_dir) ;				
						        }		
						    }
						}
/*Send notifications to all users using PHPMailer functionality. Select all the emails of the users from the database, set the subject and email body, and finally configure all the attributes of the PHPMailer object.*/
						$mailSub = 'New query has been posted';
						$mailto='';
						$mailMsg = $problem;
						$query = "SELECT email from user";
						$result = mysqli_query($conn, $query);
						$resa=mysqli_affected_rows($conn);
						$resb=mysqli_error($conn);
						if(!empty($resb)){ ?>
							<script> errordisp("<?=$resb;?>");</script>
						<?php }
						else if(empty($resa)) { ?>
							<script> errordisp('No users in database to be mailed!');</script>
						<?php }
						else {
							while($row = mysqli_fetch_assoc($result)) { 
								$mailto=$row['email'];
								$mail = new PHPMailer(true);
								$mail ->IsSmtp();
								$mail ->SMTPDebug = 0;
								$mail ->SMTPAuth = true;
								$mail ->SMTPSecure = 'ssl';
								$mail ->Host = "smtp.gmail.com";
								$mail ->Port = 465; // or 587
								$mail ->IsHTML(true);
								$mail ->Username = "AttendancePortal123@gmail.com";
								$mail ->Password = "attendanceportal1*";
								$mail ->SetFrom("AttendancePortal123@gmail.com");
								$mail ->Subject = $mailSub;
								$mail ->Body = $mailMsg;
								$mail ->AddAddress($mailto);
								if(!$mail->Send()) { ?>
									<script> errordisp("Notifications was not sent!");</script>
						 		<?php }
						 		}
						}?>
						<script> location.replace("post_query.php"); </script>
					<?php }			  		
					}
				}
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
			  			<h1 class="display text-center">Enter Details</h1>
			  			<hr class="my-4">
					  	<form action="post_query.php" method="post" enctype="multipart/form-data">
					  		<label for="cat">Category</label>
					  		<select name="cat" id="type" class="form-control">
					  			<option value="" disabled selected hidden>Options</option>
<!-- Display all the categories as option menu -->
								<?php
					  				$query = "SELECT cat_name from category";
									$result = mysqli_query($conn, $query);
									$resa=mysqli_affected_rows($conn);
									$resb=mysqli_error($conn);
									if(!empty($resb)){ ?>
										<script> errordisp("<?=$resb;?>");</script>
									<?php }
									else if(empty($resa)) { ?>
										<option>No categories in database!</option>
									<?php }
									else {
										while($row = mysqli_fetch_assoc($result)) { ?>
										<option value="<?=$row['cat_name'];?>"><?=$row['cat_name'];?></option>
										<?php }
									}
					  			?>
					  		</select>
					  		<br><label for="problem">Problem:</label>
							<textarea rows="10" cols="100" class="form-control" name="problem" placeholder="Enter the problem here"></textarea>
							<br><label for="soln">Solution</label>
						  	<textarea rows="10" cols="100" class="form-control" name="soln" placeholder="Enter the solution here"></textarea><br>
							<input type="file" name="files[]" multiple="" />
							<br>
							<br>
						   	<div id="btngrp">
							  <input type="submit" value="Submit" class="btn justify-content-center" id="button">
						  	</div>
						  	<input type="hidden" name="modify" value="post_query">
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
