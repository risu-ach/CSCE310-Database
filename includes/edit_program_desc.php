<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$num = $_POST['num'];
	$desc = $_POST['desc'];

	$sql = "UPDATE program SET Description = '$desc' WHERE Program_Num = $num;";
	mysqli_query($conn, $sql);

	header("Location: ../admin_programs.php?edit=success");
?>