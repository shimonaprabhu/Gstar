<?php
	session_start();
	if(!$_SESSION['ID']) {  
  		header("Location: index.php");
	} 
	require_once('header.php');	
	$ID=$_GET['InputUserID'];
	$password=md5($_GET['InputPassword']);
	$privilege=$_GET['type'];
	$phone=$_GET['InputPhone'];
	$email=$_GET['InputEmail'];
	$cat=urlencode($_GET['InputCategory']);
	if(!empty($ID) && !empty($password) && !empty($privilege) && !empty($phone) && !empty($email) && $_GET['modify']=='add_user') {
	    $query = "INSERT INTO user VALUES ('$ID', '$password', '$privilege', '$email', '$phone')";
		$result = mysqli_query($conn, $query);
		if($result==0){ ?>
			<script> location.replace("operror.php"); </script>
		<?php }
		else { ?>
			<script> location.replace("admin.php"); </script>
		<?php }
	}
		else if(isset($_GET['delete'])){
		$id=$_GET['delete'];
		$query = "DELETE FROM user WHERE id='$id'";
		$result = mysqli_query($conn, $query);
		if($result==0){ ?>
			<!-- <script> location.replace("operror.php"); </script> -->
		<?php }
		else { ?>
			<script> location.replace("del_user.php"); </script>
		<?php }
	}
	else if(!empty($ID) && !empty($privilege) && !empty($phone) && !empty($email) && $_GET['modify']=='mod_user') {
	    $query = "UPDATE user SET privilege='$privilege', email='$email', phone='$phone' WHERE id='$ID'";
		$result = mysqli_query($conn, $query);
		if($result==0){?>
			<script> location.replace("operror.php"); </script>
		<?php }
		else { ?>
			<script> location.replace("admin.php"); </script>
		<?php }
	}
	else if(!empty($cat) && $_GET['modify']=='add_cat') {
	    $query = "INSERT INTO category VALUES ('','','','','$cat')";
		$result = mysqli_query($conn, $query);
		if($result==0){ ?>
			<script> location.replace("operror.php"); </script>
		<?php }
		else { ?>
			<script> location.replace("admin.php"); </script>
		<?php }
	}
?>