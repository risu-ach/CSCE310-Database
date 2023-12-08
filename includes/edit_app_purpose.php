<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$appnum = $_POST['appnum'];
	$purpose = $_POST['purpose'];

	$sql = "UPDATE application SET Purpose_statement = '$purpose' WHERE App_num = $appnum;";
	mysqli_query($conn, $sql);

	header("Location: student_applications.php?edit=success");
?>