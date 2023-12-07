<?php
	// Made by Matthew Edge
	include_once 'db.php';
	
	$num = $_POST['num'];

	$sql = "SELECT * FROM program WHERE Program_Num = $num;";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	
	if ($resultCheck > 0) {
		echo "<h3>Report for Program # $num</h3>";
		echo "<table border='1'>

		<tr>
		<th>Program Number</th>
		<th>Name</th>
		<th>Description</th>
		</tr>";

		while($row = mysqli_fetch_assoc($result))  {
		  echo "<tr>";
		  echo "<td>" . $row['Program_num'] . "</td>";
		  echo "<td>" . $row['Name'] . "</td>";
		  echo "<td>" . $row['Description'] . "</td>";
		  echo "</tr>";
		}

		echo "</table>";
	}
	
?>