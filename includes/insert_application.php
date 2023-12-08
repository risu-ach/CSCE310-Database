<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$num = $_POST['num'];
	$uin = $_POST['uin'];
	$uncom = $_POST['uncom'];
	$com = $_POST['com'];
	$purpose = $_POST['purpose'];

	$sql = "INSERT INTO application (Program_num, UIN, Uncom_cert, Com_cert, Purpose_statement) 
	VALUES ($num, $uin, '$uncom', '$com', '$purpose');";
	mysqli_query($conn, $sql);

	header("Location: student_applications.php?insert=success");
?>