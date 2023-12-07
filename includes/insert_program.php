<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$num = $_POST['num'];
	$name = $_POST['name'];
	$desc = $_POST['desc'];

	$sql = "INSERT INTO program (Program_num, Name, Description) 
	VALUES ($num, '$name', '$desc');";
	mysqli_query($conn, $sql);

	header("Location: ../admin_programs.php?insert=success");
?>