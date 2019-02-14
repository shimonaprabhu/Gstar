<?php
	session_start();
	if(!$_SESSION['ID'] || $_SESSION['type']!='regular') {  
  		header("Location: index.php");
  		$_SESSION['access']='error';
	} 
	require_once('header.php');	
	require_once('operror.php');
	$query_id=$_POST['query_id'];
	$query = "SELECT file_name from files where query_id='$query_id'";
	$result = mysqli_query($conn, $query);
	$resa=mysqli_affected_rows($conn);
	$resb=mysqli_error($conn);
	if(!empty($resb)){ ?>
		<script> errordisp("<?=$resb;?>");</script>
	<?php }
	else{
		while($row = mysqli_fetch_assoc($result)) {
			$thelist .= '<a style="padding: 0px;" href="Files/'.$row['file_name'].'">'.$row['file_name'].'</a><br>';
		}
	}
?>

<div class="container" id="admin-cont">
			<div class="row">
<!--Include the file which shows the menu for the admin on the left-->
<?php 
	require_once('left_nav_reg.php');	
?>
			<div class="col-lg-8">
					<div class="jumbotron" id="main">
			  			<h1 class="display text-center">Files available for this query:</h1>
			  			<hr class="my-4">
			  			<?php 
				  			if ($thelist=='') {
				  				echo 'No files available for this query';
				  			}
				  			else{
				  				echo $thelist;
				  			}
				  		?>
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
