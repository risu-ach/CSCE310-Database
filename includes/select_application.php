<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$uin = $_POST['uin'];

	$sql = "SELECT * FROM application WHERE UIN = $uin;";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	
	if ($resultCheck > 0) {
		echo "<h3>Applications for student with UIN: $uin</h3>";
		echo "<table border='1'>

		<tr>
		<th>Application Num</th>
		<th>Program Num</th>
		<th>UIN</th>
		<th>Uncompleted Certs</th>
		<th>Completed Certs</th>
		<th>Purpose Statement</th>
		</tr>";

		while($row = mysqli_fetch_assoc($result))  {
		  echo "<tr>";
		  echo "<td>" . $row['App_num'] . "</td>";
		  echo "<td>" . $row['Program_num'] . "</td>";
		  echo "<td>" . $row['UIN'] . "</td>";
		  echo "<td>" . $row['Uncom_cert'] . "</td>";
		  echo "<td>" . $row['Com_cert'] . "</td>";
		  echo "<td>" . $row['Purpose_statement'] . "</td>";
		  echo "</tr>";
		}

		echo "</table>";
	}
	
?>