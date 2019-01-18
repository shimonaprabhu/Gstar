<?php
	session_start();
	if(!$_SESSION['ID']) {  
  		header("Location: index.php");
	} 
	require_once('header.php');
	$cat_name=urlencode($_GET['cat']);
	if(!empty($_GET['soln']) && $_GET['type']=='add') {
    	$soln=$_GET['soln'];
	    $query_id=$_GET['query_id'];
	    $cat_name=$_GET['cat_name'];
		$query = "UPDATE queries SET soln='$soln' WHERE query_id='$query_id'";
		$result = mysqli_query($conn, $query);
		if($result==0){ ?>
			<script> location.replace("operror.php"); </script>
		<?php }
		else { ?>
			<script> location.replace("queries.php?cat=<?=$cat_name;?>"); </script>
		<?php }	      	
	}	

	else if(!empty($_GET['soln']) && $_GET['type']=='edit') {
    	$soln=$_GET['soln'];
	    $query_id=$_GET['query_id'];
	    $cat_name=$_GET['cat_name'];
		$query = "UPDATE queries SET soln='$soln' WHERE query_id='$query_id'";
		$result = mysqli_query($conn, $query);
		if($result==0){ ?>
			<script> location.replace("operror.php"); </script>
		<?php }
		else { ?>
			<script> location.replace("queries.php?cat=<?=$cat_name;?>"); </script>
		<?php }	      	
	}
?>
		<div class="container" id="admin-cont">
			<div class="row">
			<?php 
				require_once('left_nav.php');	
			?>
				<div class="col-lg-8">
				  	<?php

				  		$query = "SELECT cat_id from category where cat_name='$cat_name'";
				  		$result = mysqli_query($conn, $query);
				  		$row = mysqli_fetch_assoc($result);
				  		$cat_id=$row['cat_id'];
						$query = "SELECT * from queries where cat_id='$cat_id'";
						$result = mysqli_query($conn, $query);
						$count=mysqli_num_rows($result);
						if($count==0){ ?>
							<br>
							<h3 class="display text-center">No queries have been posted!</h3>
						<?php }
						else { ?>
							<br>
							<h3 class="display text-center"><?=urldecode($cat_name);?></h3>
							<br>
	  						<?php
							while($row = mysqli_fetch_assoc($result)) { $i=0;?>
								<div class="card" id="query">
  									<div class="card-body">
  										<ul id="unstyled-list">
		 									<li><span class="heading">PROBLEM <?=$row['query_id'];?></span></li><br>
											<li><span class="heading">QUERY: </span><?=$row['query'];?></li><br>
											<?php
											if($row['soln']!='') { ?>
				  								<li><span class="heading">SOLUTION: </span><?=$row['soln'];?></li>
				  								<br>
				  								<button class="btn" type="button" data-toggle="collapse" data-target="#collapseExample<?=$row['query_id'];?>" id="button">
    											Edit Answer	
											  	</button>
											</p>
											<div class="collapse" id="collapseExample<?=$row['query_id'];?>">
												<form action="queries.php" method="get">
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
				  							<?php }
				  							else { ?>
				  								<li>
				  									<form action="queries.php" method="get">
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
		  			?>
				</div>
			</div>
		</div>
<script>
	$( "#logout" ).css( "visibility", "visible" );
</script>
<?php
	require_once('footer.php');	
?>
