<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$appnum = $_POST['appnum'];

	$sql = "DELETE FROM application WHERE App_num = $appnum;";
	mysqli_query($conn, $sql);

	header("Location: student_applications.php?remove=success");
?>