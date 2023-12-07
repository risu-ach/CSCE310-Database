<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$appnum = $_POST['appnum'];
	$com = $_POST['com'];

	$sql = "UPDATE application SET Com_cert = '$com' WHERE App_num = $appnum;";
	mysqli_query($conn, $sql);

	header("Location: student_applications.php?edit=success");
?>