<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$num = $_POST['num'];
	$name = $_POST['name'];

	$sql = "UPDATE program SET Name = '$name' WHERE Program_Num = $num;";
	mysqli_query($conn, $sql);

	header("Location: ../admin_programs.php?edit=success");
?>