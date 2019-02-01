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
	$cat_name=$_POST['cat'];
	if (isset($_FILES['files']) && $_POST['type']=='file') { $problem=$_POST['problem'];
	$cat_name=$_POST['cat_name'];
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
				    } ?>
		<form action="queries.php" method="post" id="catform" onload="sub();">
			<input type="hidden" name="cat" value="<?=$cat_name;?>">
		</form>
	<?php }
/*If the option entered by the user is to add a solution to an unresolved query and all inputs are available, perform the updation operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation. We need to select the category id based on the category name passed.*/
	else if(!empty($_POST['soln']) && $_POST['type']=='add') {
    	$soln=$_POST['soln'];
	    $query_id=$_POST['query_id'];
	    $cat_name=$_POST['cat_name'];
	    $query = "SELECT cat_id from category where cat_name='$cat_name'";
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
			$query = "UPDATE queries SET soln='$soln' WHERE query_id='$query_id' and cat_id='$cat_id'";
			$result = mysqli_query($conn, $query);
			$resa=mysqli_affected_rows($conn);
			$resb=mysqli_error($conn);
			if(!empty($resb)){ ?>
				<script> errordisp("<?=$resb;?>");</script>
			<?php }
			else if(empty($resa)) { ?>
				<script> errordisp("No data available in database or data already updated!");</script>
			<?php }
			else { ?>
				<form action="queries.php" method="post" id="catform" onload="sub();">
					<input type="hidden" name="cat" value="<?=$cat_name;?>">
				</form>
			<?php }	
		}  	
	}	
/*If the option entered by the user is to edit a solution to a resolved query and all inputs are available, perform the updation operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation. We need to select the category id based on the category name passed.*/

	else if(!empty($_POST['soln']) && $_POST['type']=='edit') {
    	$soln=$_POST['soln'];
	    $query_id=$_POST['query_id'];
	    $cat_name=$_POST['cat_name'];
	    $query = "SELECT cat_id from category where cat_name='$cat_name'";
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
			$query = "UPDATE queries SET soln='$soln' WHERE query_id='$query_id' and cat_id='$cat_id'";
			$result = mysqli_query($conn, $query);
			$resa=mysqli_affected_rows($conn);
			$resb=mysqli_error($conn);
			if(!empty($resb)){ ?>
				<script> errordisp("<?=$resb;?>");</script>
			<?php }
			else if(empty($resa)) { ?>
				<script> errordisp("No data available in database or data already updated!");</script>
			<?php }
			else { ?>
				<form action="queries.php" method="post" id="catform" onload="sub();">
					<input type="hidden" name="cat" value="<?=$cat_name;?>">
				</form>
			<?php }
		}	      	
	}
/*If the option entered by the user is to edit either a resolved query or an unresolved query and all inputs are available, perform the updation operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation. We need to select the category id based on the category name passed.*/

		else if(!empty($_POST['question']) && $_POST['type']=='editq') {
    	$question=$_POST['question'];
	    $query_id=$_POST['query_id'];
	    $cat_name=$_POST['cat_name'];
	    $query = "SELECT cat_id from category where cat_name='$cat_name'";
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
			$query = "UPDATE queries SET query='$question' WHERE query_id='$query_id' and cat_id='$cat_id'";
			$result = mysqli_query($conn, $query);
			$resa=mysqli_affected_rows($conn);
			$resb=mysqli_error($conn);
			if(!empty($resb)){ ?>
				<script> errordisp("<?=$resb;?>");</script>
			<?php }
			else if(empty($resa)) { ?>
				<script> errordisp("No data available in database or data already updated!");</script>
			<?php }
			else { ?>
				<form action="queries.php" method="post" id="catform" onload="sub();">
					<input type="hidden" name="cat" value="<?=$cat_name;?>">
				</form>
			<?php }	
		}      	
	}

/*If the option entered by the user is to verify a comment to either a resolved query or an unresolved query and all inputs are available, perform the updation operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation. We need to set verified variable as 1 in the database for that comment.*/

		else if(!empty($_POST['com_id']) && $_POST['type']=='verify') {
	    $com_id=$_POST['com_id'];
	    $query = "UPDATE comments SET verified='1' WHERE com_id='$com_id'";
		$result = mysqli_query($conn, $query);
		$resa=mysqli_affected_rows($conn);
		$resb=mysqli_error($conn);
		if(!empty($resb)){ ?>
			<script> errordisp("<?=$resb;?>");</script>
		<?php }
		else if(empty($resa)) { ?>
			<script> errordisp("No data available in database or data already updated!");</script>
		<?php }
		else { ?>
			<form action="queries.php" method="post" id="catform" onload="sub();">
				<input type="hidden" name="cat" value="<?=$cat_name;?>">
			</form>
		<?php }	      	
	}

/*If the option entered by the user is to delete a comment to either a resolved query or an unresolved query and all inputs are available, perform the deletion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation.*/
	
	else if(!empty($_POST['com_id']) && $_POST['type']=='del_com') {
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
			<form action="queries.php" method="post" id="catform" onload="sub();">
				<input type="hidden" name="cat" value="<?=$cat_name;?>">
			</form>
		<?php }	      	
	}

/*If the option entered by the user is to delete either a resolved query or an unresolved query and all inputs are available, perform the deletion operation on the database, checking for errors, displaying the appropriate error message, else redirecting to the original page after the operation. Once a query is deleted, we must also delete all the child comments to prevent comments from being orphaned.*/
	
		else if(!empty($_POST['query_id']) && !empty($_POST['cat_id']) && $_POST['type']=='delq') {
	    $query_id=$_POST['query_id'];
	    $cat_id=$_POST['cat_id'];
	    $query = "DELETE FROM queries WHERE cat_id='$cat_id' AND query_id='$query_id'";
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
			$query2 = "DELETE FROM comments WHERE cat_id='$cat_id' AND query_id='$query_id'";
			$result2 = mysqli_query($conn, $query2);
			$resa=mysqli_affected_rows($conn);
			$resb=mysqli_error($conn);
			if(!empty($resb)){ ?>
				<script> errordisp("<?=$resb;?>");</script>
			<?php }
			else if(empty($resa)) { ?>
				<script> errordisp("No data available in database!");</script>
			<?php }
			else { ?>
				<form action="queries.php" method="post" id="catform" onload="sub();">
					<input type="hidden" name="cat" value="<?=$cat_name;?>">
				</form>
			<?php }
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
								<br>
		  						<?php
		  						/*$i=0;*/
/*Display problem header*/
								while($row = mysqli_fetch_assoc($result)) { /*$i=$i+1;*/ ?>
									<div class="card" id="query">
	  									<div class="card-body">
	  										<ul id="unstyled-list"><!-- 
			 									<li><span class="heading">PROBLEM <?php echo $i;?></span></li><br> -->
			 									<form action="queries.php" method="post">
<!--Provide an option to delete the query by the click of a button-->
													<div id="btngrp">
													    <input type="submit" value="Delete Query" class="btn justify-content-center" id="button">
												  	</div>
												  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
												  	<input type="hidden" name="cat_id" value="<?=$cat_id;?>">
												  	<input type="hidden" name="cat" value="<?=$cat_name;?>">
												  	<input type="hidden" name="type" value="delq">
												</form>
					  							<br>
<!--Display the Resolved query, the solution to it by looping over the result array and also provide collapsible buttons to edit query, edit answer and view comments-->
												<?php
												if($row['soln']!='') { ?>
													<li><span class="heading">RESOLVED QUERY: </span><?=$row['query'];?></li><br>
													<li><span class="heading">SOLUTION: </span><?=nl2br($row['soln']);?></li><br>
					  								<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'].$i;?>" id="button">
	    											Edit Query
												  	</button>
												  	<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'];?>" id="buttoncom">
	    											Edit Answer	
												  	</button>
													<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'].$cat_id.$_SESSION['ID'];?>" id="buttoncom">
		    										View Comments	
													</button>
													<form action="queries.php" method="post" enctype="multipart/form-data">
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
															</form>
<!--The collapsible form which shows on clicking Edit Query and then submits the form to perform the function -->
												<div class="collapse" id="collapseExample<?=$row['query_id'].$i;?>">
													<form action="queries.php" method="post">
															<ul id="unstyled-list-solution">
																<br><label for="question"><span class="heading">QUERY: </span></label>
																<br><textarea rows="10" class="form-control" name="question" placeholder="Enter the query here"></textarea>
																<br>
															</ul>
														   	<div id="btngrp">
															  <input type="submit" value="Post Query" class="btn justify-content-center" id="button">
														  	</div>
														  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
														  	<input type="hidden" name="cat_name" value="<?=$cat_name;?>">
														  	<input type="hidden" name="type" value="editq">
														</form>
												</div>
<!--The collapsible form which shows on clicking Edit Answer and then submits the form to perform the function -->
												<div class="collapse" id="collapseExample<?=$row['query_id'];?>">
													<form action="queries.php" method="post">
															<ul id="unstyled-list-solution">
																<br><label for="soln"><span class="heading">SOLUTION: </span></label>
																<br><textarea rows="10" class="form-control" name="soln" placeholder="Enter the solution here"></textarea>
																<br>
															</ul>
														   	<div id="btngrp">
															  <input type="submit" value="Post Answer" class="btn justify-content-center" id="button">
														  	</div>
														  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
														  	<input type="hidden" name="cat_name" value="<?=$cat_name;?>">
														  	<input type="hidden" name="type" value="edit">
														</form>
												</div>
												<br>
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
<!-- show if the comment is verified by the admin or not. If it is not verified, give the option to mark it as verified by submitting a form to update the verified attribute for that particular comment -->
																	<?php
																		if($r['verified']=='0'){ ?>
																			<form action="queries.php" method="post" id="form<?=$r['com_id'];?>" style="display: inline;">
																				<input type="hidden" name="com_id" value="<?=$r['com_id'];?>">
																				<input type="hidden" name="cat" value="<?=$cat_name;?>">
																				<input type="hidden" name="type" value="verify">
																				<span class="badge badge-info"><a href="javascript:{}" onclick="submit('form<?=$r['com_id'];?>');" id="verified">Mark as verified</a></span>
																			</form>
																		<?php }
																		else{ ?>
																			<span class="badge badge-info">Verified!</span>
																	<?php } ?>
<!-- Delete any comment posted by any user -->
																<form action="queries.php" method="post" id="form<?=$r['com_id'].$cat_name;?>" style="display: inline;">
																				<input type="hidden" name="com_id" value="<?=$r['com_id'];?>">
																				<input type="hidden" name="cat" value="<?=$cat_name;?>">
																				<input type="hidden" name="type" value="del_com">
																				<span class="badge badge-warning"><a href="javascript:{}" onclick="submit('form<?=$r['com_id'].$cat_name;?>');" id="verified">Delete</a></span>
																	</form>
																	<br>
																	<p><?=nl2br($r['comment']);?></p>
																	<hr>
																</li>
															<?php }
														}
													?>
												</div>
					  							<?php }
					  							else { ?>
<!--Display the Unresolved query, by looping over the result array and also provide collapsible buttons to edit query and view comments-->
					  								<li><span class="heading">UNRESOLVED QUERY: </span><?=$row['query'];?></li><br>
					  								<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'].$i;?>" id="button">
	    											Edit Query
												  	</button>
													<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'].$cat_id.$_SESSION['ID'];?>" id="buttoncom">
		    										View Comments	
													</button>
													<form action="queries.php" method="post" enctype="multipart/form-data">
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
															</form>
<!--The collapsible form which shows on clicking Edit Query and then submits the form to perform the function -->
													<div class="collapse" id="collapseExample<?=$row['query_id'].$i;?>">
													<form action="queries.php" method="post">
															<ul id="unstyled-list-solution">
																<br><label for="question"><span class="heading">QUERY: </span></label>
																<br><textarea rows="10" class="form-control" name="question" placeholder="Enter the query here"></textarea>
																<br>
															</ul>
														   	<div id="btngrp">
															  <input type="submit" value="Post Query" class="btn justify-content-center" id="button">
														  	</div>
														  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
														  	<input type="hidden" name="cat_name" value="<?=$cat_name;?>">
														  	<input type="hidden" name="type" value="editq">
														</form>
												</div>
												<br>
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
<!-- show if the comment is verified by the admin or not. If it is not verified, give the option to mark it as verified by submitting a form to update the verified attribute for that particular comment -->
																	<?php
																		if($r['verified']=='0'){ ?>
																			<form action="queries.php" method="post" id="form<?=$r['com_id'];?>" style="display: inline;">
																				<input type="hidden" name="com_id" value="<?=$r['com_id'];?>">
																				<input type="hidden" name="cat" value="<?=$cat_name;?>">
																				<input type="hidden" name="type" value="verify">
																				<span class="badge badge-info"><a href="javascript:{}" onclick="submit('form<?=$r['com_id'];?>');" id="verified">Mark as verified</a></span>
																			</form>
																		<?php }
																		else{ ?>
																			<span class="badge badge-info">Verified!</span>
																	<?php } ?>
<!-- Delete any comment posted by any user -->
																	<form action="queries.php" method="post" id="form<?=$r['com_id'].$cat_name;?>" style="display: inline;">
																				<input type="hidden" name="com_id" value="<?=$r['com_id'];?>">
																				<input type="hidden" name="cat" value="<?=$cat_name;?>">
																				<input type="hidden" name="type" value="del_com">
																				<span class="badge badge-warning"><a href="javascript:{}" onclick="submit('form<?=$r['com_id'].$cat_name;?>');" id="verified">Delete</a></span>
																	</form>
																	<br>
																	<p><?=nl2br($r['comment']);?></p>
																	<hr>
																</li>
															<?php }
														}
													?>
												</div>
					  								<li>
<!-- Provide a form to enter the solution for the unresolved query -->
					  									<form action="queries.php" method="post">
															<ul id="unstyled-list-solution">
																<br><label for="soln"><span class="heading">SOLUTION: </span></label>
																<br><textarea rows="10" class="form-control" name="soln" placeholder="Enter the solution here"></textarea>
																<br>
															</ul>
														   	<div id="btngrp">
															  <input type="submit" value="Post Answer" class="btn justify-content-center" id="button">
														  	</div>
														  	<input type="hidden" name="query_id" value="<?=$row['query_id'];?>">
														  	<input type="hidden" name="cat_name" value="<?=$cat_name;?>">
														  	<input type="hidden" name="type" value="add">
														</form>
													</li>
					  							<?php } ?>
					  						</ul>
									    </div>
									</div>
								<br>
		  					<?php }
		  					}
		 				}
		  			?>
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
