<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$appnum = $_POST['appnum'];
	$uncom = $_POST['uncom'];

	$sql = "UPDATE application SET Uncom_cert = '$uncom' WHERE App_num = $appnum;";
	mysqli_query($conn, $sql);

	header("Location: student_applications.php?edit=success");
?>