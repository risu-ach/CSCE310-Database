<!-- Made By Rishika Acharya -->
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

</head>
<body>

<h1>Add New Certificate</h1>

<!-- Display Form for Inserting/Updating Certification Information -->
<form method="post">
    <label for="Cert_ID">Certification ID:</label>
    <input type="text" name="Cert_ID" required>
    
    <label for="Cert_level">Certification Level:</label>
    <input type="text" name="Cert_level" required>
    
    <label for="Name">Name:</label>
    <input type="text" name="Name" required>
    
    <label for="Description">Description:</label>
    <input type="text" name="Description">
    
    <button type="submit" name="insert" class="button">Insert/Update Internship</button>
    <button type="button" onclick="clearForm()" class="button clear-button">Clear</button>
</form>

<!-- Handle Insert/Update -->
<?php
if (isset($_POST['insert'])) {
    $Cert_ID = $_POST['Cert_ID'];
    $Cert_level = $_POST['Cert_level'];
    $Name = $_POST['Name'];
    $Description = isset($_POST['Description']) ? $_POST['Description'] : null;

    // Check if the Certification ID already exists
    $checkDuplicateSql = "SELECT * FROM certification WHERE Cert_ID = '$Cert_ID'";
    $duplicateResult = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($duplicateResult) > 0) {
        echo "Updating Certification ID $Cert_ID ". "<br>";
        $updateSql = "UPDATE certification SET Cert_level = '$Cert_level', Name = '$Name', Description = " . ($Description !== null ? "'$Description'" : "NULL") . " WHERE Cert_ID = '$Cert_ID'";

        if (mysqli_query($conn, $updateSql)) {
            echo "Certification information updated successfully";
        } else {
            echo "Error updating certification information: " . mysqli_error($conn);
        }
    } else {
        $insertSql = "INSERT INTO certification (Cert_ID, Cert_level, Name, Description) VALUES ('$Cert_ID', '$Cert_level', '$Name', " . ($Description !== null ? "'$Description'" : "NULL") . ")";

        if (mysqli_query($conn, $insertSql)) {
            echo "New certification inserted successfully";
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!-- Table Itself-->
<h1> ALL Certificates</h1>
<table>
    <tr>
        <th>Certification ID</th>
        <th>Certification Level</th>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
    </tr>

    <?php 
      $selectSql = "SELECT * FROM certification;";
      $selectResult = mysqli_query($conn, $selectSql);
      $resultCheck = mysqli_num_rows($selectResult);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_array($selectResult)) {
          echo "<tr>";
          echo "<td>" . $row["Cert_ID"] . "</td>";
          echo "<td>" . $row["Cert_level"] . "</td>";
          echo "<td>" . $row["Name"] . "</td>";
          echo "<td>" . ($row["Description"] !== null ? $row["Description"] : 'NULL') . "</td>";
          echo "<td><button onclick=\"location.href='?edit=" . $row["Cert_ID"] . "'\">Edit</button> | <button onclick=\"location.href='?delete=" . $row["Cert_ID"] . "'\">Delete</button></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No certifications found</td></tr>";
      }
    ?>
</table>

<!-- Handle Edit -->
<?php
if (isset($_GET['edit'])) {
    $editCertID = $_GET['edit'];

    $editSql = "SELECT * FROM certification WHERE Cert_ID = '$editCertID'";
    $editResult = mysqli_query($conn, $editSql);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editRow = mysqli_fetch_array($editResult);
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementsByName('Cert_ID')[0].value = '<?php echo $editRow["Cert_ID"]; ?>';
                document.getElementsByName('Cert_level')[0].value = '<?php echo $editRow["Cert_level"]; ?>';
                document.getElementsByName('Name')[0].value = '<?php echo $editRow["Name"]; ?>';
                document.getElementsByName('Description')[0].value = '<?php echo $editRow["Description"]; ?>';
            });
        </script>
    <?php
    }
}
?>
<!-- Handle Delete -->
<?php
if (isset($_GET['delete'])) {
    $deleteCertID = $_GET['delete'];

    $deleteSql = "DELETE FROM certification WHERE Cert_ID = '$deleteCertID'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Certification deleted successfully";
    } else {
        echo "Error deleting certification: " . mysqli_error($conn);
    }
}
?>
<script>
    function clearForm() {
        document.getElementsByName('Intern_ID')[0].value = '';
        document.getElementsByName('Name')[0].value = '';
        document.getElementsByName('Description')[0].value = '';
        document.getElementsByName('Is_Gov')[0].value = '1';
    }
</script>

</body>
</html>
