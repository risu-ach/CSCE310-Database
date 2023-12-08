<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$num = $_POST['num'];

	$sql = "DELETE FROM program WHERE Program_Num = $num;";
	mysqli_query($conn, $sql);

	header("Location: ../admin_programs.php?remove=success");
?>