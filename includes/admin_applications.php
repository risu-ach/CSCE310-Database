<!-- Made by Matthew Edge -->
<?php include_once 'db.php'; ?>
<?php include_once 'Admin_App_nav.php'; ?> <!-- Include the navigation bar -->
<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION["userUIN"])) {
    // If not, redirect to the login page
    header("Location: ../loginpage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<br>
	<h1>Add new application</h1>
	<form action="insert_application.php" method="POST">
		<input type="text" name="num" placeholder="Program Number">
		<br>
		<input type="text" name="uin" placeholder="Student UIN">
		<br>
		<input type="text" name="uncom" placeholder="Are you enrolled in any uncompleted certifications?">
		<br>
		<input type="text" name="com" placeholder="Have you completed any certifications?">
		<br>
		<input type="text" name="purpose" placeholder="Purpose statement">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
		
	<br>
	<br>
	<br>
	<br>
	
	<h1>Edit existing application</h1>
	Edit response to "Have you completed any certifications with the Cybersecurity Center?"
	<form action="edit_app_com.php" method="POST">
		<input type="text" name="appnum" placeholder="Application number">
		<br>
		<input type="text" name="com" placeholder="Answer here">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	<br>
	Edit response to "Are you enrolled in any uncompleted certifications with the Cybersecurity Center?"
	<form action="edit_app_uncom.php" method="POST">
		<input type="text" name="appnum" placeholder="Application number">
		<br>
		<input type="text" name="uncom" placeholder="Answer here">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	<br>
	Edit purpose statement
	<form action="edit_app_purpose.php" method="POST">
		<input type="text" name="appnum" placeholder="Application number">
		<br>
		<input type="text" name="purpose" placeholder="Purpose statement here">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
	
	<br>
	<br>
	<br>
	<br>
	
	<h1>Remove application</h1>
	<form action="remove_application.php" method="POST">
		<input type="text" name="appnum" placeholder="Application number">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>

	<br>
	<br>
	<br>
	<br>
	
	<h1>Review application</h1>
	<form action="select_application.php" method="POST">
		<input type="text" name="uin" placeholder="Student UIN">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>



<!-- Table -->
<h1> My Applications</h1>
<table>
    <tr>
        <th>Application Number</th>
        <th>Program Number</th>
        <th>UIN</th>
        <th>Uncompleted Certs</th>
        <th>Completed Certs</th>
        <th>Purpose Statement</th>
    </tr>

    <?php 
      $selectSql = "SELECT * FROM application;";
      $selectResult = mysqli_query($conn, $selectSql);
      $resultCheck = mysqli_num_rows($selectResult);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_array($selectResult)) {
          echo "<tr>";
          echo "<td>" . $row["App_num"] . "</td>";
          echo "<td>" . $row["Program_num"] . "</td>";
          echo "<td>" . $row["UIN"] . "</td>";
          echo "<td>" . $row["Uncom_cert"] . "</td>";
          echo "<td>" . $row["Com_cert"] . "</td>";
          echo "<td>" . $row["Purpose_statement"] . "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='9'>No applications found</td></tr>";
      }
    ?>
</table>


	
</body>
</html>