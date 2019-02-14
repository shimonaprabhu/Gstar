<?php
	session_start();
	if(!$_SESSION['ID'] || $_SESSION['type']!='regular') {  
  		header("Location: index.php");
  		$_SESSION['access']='error';
	}
/*To maintain the logged in state, create the session and then check if the session exists in the database and if the privilege is admin*/

/*Extract data posted using the form and include the files to make connection to the DB and also include script files. operror is used for displaying error messages*/	
	require_once('header.php');
	require_once('operror.php');

/*Include the files to enable mailing functionality to send notification to users on new query post*/
	require_once('PHPMailer-master/PHPMailerAutoload.php');
	$cat_name=$_SESSION['data'];
	/*$cat_name=$_POST['cat'];*/
/*If the option entered by the user is to add a comment to a query and all inputs are available, perform the insertion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation.*/
	if (!empty($_FILES)&&!(array_sum($_FILES['files']['error'])>0) && $_POST['type']=='file') { 
		$problem=$_POST['problem'];
		$cat_name=$_POST['cat_name'];
		$cat_id=$_POST['cat_id'];
		foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['files']['name'][$key];
					$file_size =$_FILES['files']['size'][$key];
					$file_tmp =$_FILES['files']['tmp_name'][$key];
					$file_type=$_FILES['files']['type'][$key];
						$query = "SELECT query_id from queries where query='$problem'";
						$result = mysqli_query($conn, $query);
						$row=mysqli_fetch_assoc($result);
						$query_id=$row['query_id'];
				        $query="INSERT into files VALUES('$query_id','$cat_id','$file_name','$file_size','$file_type')";
				        $result = mysqli_query($conn, $query);
						$resb=mysqli_error($conn);
						if(!empty($resb)){ ?>
							<script> errordisp("File already exists");</script>
						<?php }
				        $desired_dir="Files";
				        if(is_dir("$desired_dir/".$file_name)==false){
				            move_uploaded_file($file_tmp,"Files/".$file_name);
				        }
				        else { ?>
							<script> errordisp("File already exists");</script>
						<?php }		
				    } ?>
				   	<script>refresh("<?=$cat_name;?>");</script>
		<!-- <form action="landing.php" method="post" id="catform" onload="sub();">
			<input type="hidden" name="cat" value="<?=$cat_name;?>">
		</form> -->
	<?php }

	else if (!empty($_POST['comment']) && $_POST['type']=='com') {
		$query_id=$_POST['query_id'];
		$cat_id=$_POST['cat_id'];
		$user_id=$_SESSION['ID'];
		$content=$_POST['comment'];
		$query = "INSERT INTO comments VALUES ('','$user_id','$cat_id','$query_id','$content','0')";
		$result = mysqli_query($conn, $query);
		$resb=mysqli_error($conn);
		if(!empty($resb)){ ?>
			<script> errordisp("<?=$resb;?>");</script>
		<?php }
		else { 
			$query = "SELECT cat_name from category where cat_id='$cat_id'";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($result);
			$cat_name=$row['cat_name']; 
			$resa=mysqli_affected_rows($conn);
			$resb=mysqli_error($conn);
			if(!empty($resb)){ ?>
				<script> errordisp("<?=$resb;?>");</script>
			<?php }
			else if(empty($resa)) { ?>
				<script> errordisp("No data available in database!");</script>
			<?php }
			else { ?>
				<script>refresh("<?=$cat_name;?>");</script>
				<!-- <form action="landing.php" method="post" id="catform" onload="sub();">
					<input type="hidden" name="cat" value="<?=$cat_name;?>">
				</form> -->

			<?php }
		}
	}
/*If the option entered by the user is to add a query and all inputs are available, perform the insertion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation.*/
	else if (!empty($_POST['problem']) && $_POST['type']=='post_query') {
		$problem=$_POST['problem'];
		$cat_id=$_POST['cat_id'];
		$query = "INSERT INTO queries VALUES ('','$cat_id','$problem','')";
		$result = mysqli_query($conn, $query);
		$resb=mysqli_error($conn);
		if(!empty($resb)){ ?>
			<script> errordisp("<?=$resb;?>");</script>
		<?php }
		else { 
			if(!(array_sum($_FILES['files']['error'])>0)){
				foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['files']['name'][$key];
					$file_size =$_FILES['files']['size'][$key];
					$file_tmp =$_FILES['files']['tmp_name'][$key];
					$file_type=$_FILES['files']['type'][$key];
						$query = "SELECT query_id from queries where query='$problem'";
						$result = mysqli_query($conn, $query);
						$row=mysqli_fetch_assoc($result);
						$query_id=$row['query_id'];
				        $query="INSERT into files VALUES('$query_id','$cat_id','$file_name','$file_size','$file_type')";
				        $result = mysqli_query($conn, $query);
						$resb=mysqli_error($conn);
						if(!empty($resb)){ ?>
							<script> errordisp("File already exists");</script>
						<?php }
				        $desired_dir="Files";
				        if(is_dir("$desired_dir/".$file_name)==false){
				            move_uploaded_file($file_tmp,"Files/".$file_name);
				        }
				        else { ?>
							<script> errordisp("File already exists");</script>
						<?php			
				        }		
				    }
				}
			$query = "SELECT cat_name from category where cat_id='$cat_id'";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($result);
			$cat_name=$row['cat_name']; 
			$resa=mysqli_affected_rows($conn);
			$resb=mysqli_error($conn);
			if(!empty($resb)){ ?>
				<script> errordisp("<?=$resb;?>");</script>
			<?php }
			else if(empty($resa)) { ?>
				<script> errordisp("No data available in database!");</script>
			<?php }
			else { $mailSub = 'New query has been posted';
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
							try {
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
							}
							 	catch(phpmailerException $e) { ?> 
							 		<script> errordisp('Some e-mail addresses may not be delivered due to incorrect email addresses or incorrect setup of mail server.');</script> 
							 	<?php }
					 		}
					} ?>
					<script>refresh("<?=$cat_name;?>");</script>
				<!-- <form action="landing.php" method="post" id="catform" onload="sub();">
					<input type="hidden" name="cat" value="<?=$cat_name;?>">
				</form> -->
			<?php }
		}
	}
/*If the option entered by the user is to delete a comment to a query and all inputs are available, perform the deletion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation.*/
	else if(!empty($_POST['com_id']) && $_POST['type']=='del_com') {
		$cat_name=$_POST['cat'];
	    $com_id=$_POST['com_id'];
	    $query = "DELETE FROM comments WHERE com_id='$com_id'";
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
			<script>refresh("<?=$cat_name;?>");</script>
			<!-- <form action="landing.php" method="post" id="catform" onload="sub();">
				<input type="hidden" name="cat" value="<?=$cat_name;?>">
			</form> -->
		<?php }	      	
	}

	
?>
<!--Create a container to show form input elements to take in user inputs-->
		<div class="container" id="admin-cont">
			<div class="row">
<!--Include the file which shows the menu for the regular user on the left-->
				<?php 
					require_once('left_nav_reg.php');	
				?>
				<div class="col-lg-8">
<!--Extract the category id from the category name input by the user and select all the queries related to that category. If there are any errors, display the appropriate error message or else perform the functions required to display the page-->
					<?php	

						$query = "SELECT cat_id from category where cat_name='$cat_name'";
						$result = mysqli_query($conn, $query);
						$row = mysqli_fetch_assoc($result);
						$cat_id=$row['cat_id'];
						$resa=mysqli_affected_rows($conn);
						$resb=mysqli_error($conn);
						if(!empty($resb)){ ?>
							<script> errordisp("<?=$resb;?>");</script>
						<?php }
						else if(empty($resa)) { ?>
							<script> errordisp("No data available in database!");</script>
						<?php }
						else {
							$query = "SELECT * from queries where cat_id='$cat_id'";
							$result = mysqli_query($conn, $query);
							$count=mysqli_num_rows($result);  
							$resa=mysqli_affected_rows($conn);
							$resb=mysqli_error($conn);
							if(!empty($resb)){ ?>
								<script> errordisp("<?=$resb;?>");</script>
							<?php }
							else if(empty($resa)) { ?>
								<br>
								<h3 class="display text-center">No queries have been posted!</h3>
							<?php }	
									else { ?>
										<br>
										<h3 class="display text-center"><?=$cat_name;?></h3>
<!-- Create a search box for keyword based search on queries and submit the form-->
										<form action="key.php" method="post">
											<table id="search">
													<tr>
														<td><br><input type="text" class="form-control" name="search" placeholder="Search" size="25"></td>
														<td><br><input type="submit" value="Submit" class="btn justify-content-center" id="button"></td>
														<input type="hidden" name="cat_name" value="<?=$cat_name?>">
														<input type="hidden" name="cat_id" value="<?=$cat_id?>">
													</tr>
											</table> 	
										</form>
										<br>
										<button type="button" class="btn" data-toggle="modal" data-target="#exampleModalCenter" id="button">
											Post a query in this category
										</button>
										<br>
<!-- Display a modal on the click of a button to Post a query. This modal contains a form which inserts the query in the database-->
										<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
												<div class="modal-content">
										      		<div class="modal-header">
										        		<h5 class="modal-title" id="exampleModalCenterTitle">Post a Query</h5>
										        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          			<span aria-hidden="true">&times;</span>
										        		</button>
										      		</div>
										      		<div class="modal-body">
										      			<form action="landing.php" method="post" enctype="multipart/form-data">
													  		<br><label for="problem">Problem:</label>
															<textarea rows="5" class="form-control" name="problem" placeholder="Enter the problem here"></textarea>
															<br>
															<input type="file" name="files[]" multiple="" />
															<br>
															<br>
														   	<div id="btngrp">
															  <input type="submit" value="Submit" class="btn justify-content-center" id="button">
														  	</div>
														  	<input type="hidden" name="type" value="post_query">
														  	<input type="hidden" name="cat_id" value="<?=$cat_id;?>">
														</form>
										  			</div>
										    	</div>
										  	</div>
										</div>
										<br>
		  								<?php
		  									/*$i=0;*/
											while($row = mysqli_fetch_assoc($result)) { /*$i=$i+1;*/ ?>
	  										<div class="card" id="query">
			  									<div class="card-body">
			  										<ul id="unstyled-list">
					 									<!-- <li><span class="heading">PROBLEM <?php echo $i;?></span></li><br> -->
														<?php
														if($row['soln']!='') { ?>
<!--Display the Resolved query, the solution to it by looping over the result array and also provide collapsible buttons to edit query, edit answer and view comments-->
															<li><span class="heading">RESOLVED QUERY: </span><?=$row['query'];?></li><br>	
							  								<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'];?>" id="button">
	    													Answer	
												  			</button>
												  			<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'].$cat_id.$_SESSION['ID'];?>" id="buttoncom">
	    													View Comments	
												  			</button>
												  			<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'].$cat_id;?>" id="buttoncom">
	    													Add Comment	
												  			</button>
												  			<form action="files_reg.php" method="post" style="display: inline;">
															  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
															  	<input type="submit" value="View Files" class="btn" type="button" id="buttoncom">
															</form>
															<form action="landing.php" method="post" enctype="multipart/form-data">
														  		<br>
																<input type="file" name="files[]" multiple="" />
																<br>
																<br>
															   	<div id="btngrp">
																  <input type="submit" value="Upload" class="btn justify-content-center" id="button">
															  	</div>
															  	<input type="hidden" name="type" value="file">
															  	<input type="hidden" name="problem" value="<?=$row['query']?>">
															  	<input type="hidden" name="cat_name" value="<?=$cat_name;?>">
																<input type="hidden" name="cat_id" value="<?=$cat_id;?>">
															</form>
<!--The collapsible content which shows on clicking View Answer-->
															<div class="collapse" id="collapseExample<?=$row['query_id'];?>">
																<?php
																	$query_id=$row['query_id'];
																	$query2 = "SELECT soln from queries where cat_id='$cat_id' and query_id='$query_id'";
																	$result2 = mysqli_query($conn, $query2);
																	$row2=mysqli_fetch_assoc($result2);
																  	$resa=mysqli_affected_rows($conn);
																	$resb=mysqli_error($conn);
																	if(!empty($resb)){ ?>
																		<script> errordisp("<?=$resb;?>");</script>
																	<?php }
																	else if(empty($resa)) { ?>
																		<script> errordisp("No data available in database!");</script>
																	<?php }
																	else{ ?>
																		<br><li><span class="heading">ANSWER: </span><?=nl2br($row2['soln']);?></li><br>
																	<?php }
																?>
															</div>	
<!--The collapsible content which shows on clicking View Comments-->
															<div class="collapse" id="collapseExample<?=$row['query_id'].$cat_id.$_SESSION['ID'];?>">
<!-- display all the comments for a particular query by selecting the  query id and category id, displaying the appropriate error message in case of an error-->
																<?php
																	$query_id=$row['query_id'];
																	$query3 = "SELECT * from comments where cat_id='$cat_id' and query_id='$query_id'";
																	$result3 = mysqli_query($conn, $query3);
																  	$resa=mysqli_affected_rows($conn);
																	$resb=mysqli_error($conn);
																	if(!empty($resb)){ ?>
																		<script> errordisp("<?=$resb;?>");</script>
																	<?php }
																	else if(empty($resa)) { ?>
																		<br><li><span class="heading">COMMENT: </span><?='No comments available!';?></li>
																	<?php }
																	else{ 
																		while($r = mysqli_fetch_assoc($result3)) { ?>
																			<br>
																			<li>
<!-- display the user id of the person who postedd the comment-->
																				<span class="badge" id="user">Posted By: <?=nl2br($r['user_id']);?></span>
<!-- show if the comment is verified by the admin or not. -->
																				<?php
																					if ($r['verified']=='1'){ ?>
																						<span class="badge badge-info">Verified!</span>
<!-- If the logged in user has posted any comments previously, allow the user to delete only those comments and not those posted by other users-->
																				<?php } 
																					if($_SESSION['ID']==$r['user_id']) { ?>
																						<form action="landing.php" method="post" id="form<?=$r['com_id'].$cat_name;?>" style="display: inline;">
																							<input type="hidden" name="com_id" value="<?=$r['com_id'];?>">
																							<input type="hidden" name="cat" value="<?=$cat_name;?>">
																							<input type="hidden" name="type" value="del_com">
																							<span class="badge badge-warning"><a href="javascript:{}" onclick="submit('form<?=$r['com_id'].$cat_name;?>');" id="verified">Delete My Comment</a></span>
																						</form>
																					<?php } ?>
																				<br>
																				<p><?=nl2br($r['comment']);?></p>
																				<hr>
																			</li>

																		<?php }
																	}
																?>
															</div>
<!-- Provide a collapsible form for posting a comment -->
															<div class="collapse" id="collapseExample<?=$row['query_id'].$cat_id;?>">
																<form action="landing.php" method="post">
																	<ul id="unstyled-list-solution">
																		<br><label for="comment"><span class="heading">COMMENT: </span></label>
																		<br><textarea rows="10" class="form-control" name="comment" placeholder="Enter the comment here"></textarea>
																		<br>
																	</ul>
																   	<div id="btngrp">
																	  <input type="submit" value="Post Comment" class="btn justify-content-center" id="button">
																  	</div>
																  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
																  	<input type="hidden" name="cat_id" value="<?=$cat_id;?>">
																  	<input type="hidden" name="type" value="com">
																</form>
															</div>	
							  							<?php }
							  							else { ?>
<!--Display the Unresolved query, by looping over the result array and also provide collapsible buttons to view comments and add comment-->	
							  								<li><span class="heading">UNRESOLVED QUERY: </span><?=$row['query'];?></li><br>
												  			<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'].$cat_id.$_SESSION['ID'];?>" id="button">
	    													View Comments	
												  			</button>
												  			<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'].$cat_id;?>" id="buttoncom">
	    													Add Comment	
												  			</button>
												  			<form action="files_reg.php" method="post" style="display: inline;">
															  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
															  	<input type="submit" value="View Files" class="btn" type="button" id="buttoncom">
															</form>
												  			<form action="landing.php" method="post" enctype="multipart/form-data">
														  		<br>
																<input type="file" name="files[]" multiple="" />
																<br>
																<br>
															   	<div id="btngrp">
																  <input type="submit" value="Upload" class="btn justify-content-center" id="button">
															  	</div>
															  	<input type="hidden" name="type" value="file">
															  	<input type="hidden" name="problem" value="<?=$row['query']?>">
															  	<input type="hidden" name="cat_name" value="<?=$cat_name;?>">
															  	<input type="hidden" name="cat_id" value="<?=$cat_id;?>">
															</form>
<!--The collapsible content which shows on clicking View comments-->
															<div class="collapse" id="collapseExample<?=$row['query_id'].$cat_id.$_SESSION['ID'];?>">
<!-- display all the comments for a particular query by selecting the  query id and category id, displaying the appropriate error message in case of an error-->
																<?php
																	$query_id=$row['query_id'];
																	$query3 = "SELECT * from comments where cat_id='$cat_id' and query_id='$query_id'";
																	$result3 = mysqli_query($conn, $query3);
																	$resa=mysqli_affected_rows($conn);
																	$resb=mysqli_error($conn);
																	if(!empty($resb)){ ?>
																		<script> errordisp("<?=$resb;?>");</script>
																	<?php }
																	else if(empty($resa)) { ?>
																		<br><li><span class="heading">COMMENT: </span><?='No comments available!';?></li>
																	<?php }
																	else{ 
																		while($r = mysqli_fetch_assoc($result3)) { ?>
																			<br>
																			<li>
<!-- display the user id of the person who postedd the comment-->
																				<span class="badge" id="user">Posted By: <?=nl2br($r['user_id']);?></span>
																				<?php
																					if ($r['verified']=='1'){ ?>
<!-- show if the comment is verified by the admin or not. -->
																						<span class="badge badge-info">Verified!</span>
																				<?php } 
																					if($_SESSION['ID']==$r['user_id']) { ?>
<!-- If the logged in user has posted any comments previously, allow the user to delete only those comments and not those posted by other users-->
																						<form action="landing.php" method="post" id="form<?=$r['com_id'].$cat_name;?>" style="display: inline;">
																							<input type="hidden" name="com_id" value="<?=$r['com_id'];?>">
																							<input type="hidden" name="cat" value="<?=$cat_name;?>">
																							<input type="hidden" name="type" value="del_com">
																							<span class="badge badge-warning"><a href="javascript:{}" onclick="submit('form<?=$r['com_id'].$cat_name;?>');" id="verified">Delete My Comment</a></span>
																						</form>
																					<?php } ?>
																				<br>
																				<p><?=nl2br($r['comment']);?></p>
																				<hr>
																			</li>

																		<?php }
																	}
																?>
															</div>
<!--The collapsible form which shows on clicking Post Comment and then submits the form to perform the function -->
															<div class="collapse" id="collapseExample<?=$row['query_id'].$cat_id;?>">
																<form action="landing.php" method="post">
																	<ul id="unstyled-list-solution">
																		<br><label for="comment"><span class="heading">COMMENT: </span></label>
																		<br><textarea rows="10" class="form-control" name="comment" placeholder="Enter the comment here"></textarea>
																		<br>
																	</ul>
																   	<div id="btngrp">
																	  <input type="submit" value="Post Comment" class="btn justify-content-center" id="button">
																  	</div>
																  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
																  	<input type="hidden" name="cat_id" value="<?=$cat_id;?>">
																  	<input type="hidden" name="type" value="com">
																</form>
															</div>
							  							<?php } ?>
							  						</ul>
											    </div>
											</div>
											<br>
										<?php } 
									}
									} ?>
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