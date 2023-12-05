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

<h1> Add New Internship </h1>

<!-- Display Form for Inserting/Updating Internship Information -->
<form method="post">
    <label for="Intern_ID">Internship ID:</label>
    <input type="text" name="Intern_ID" required>
    
    <label for="Name">Name:</label>
    <input type="text" name="Name">
    
    <label for="Description">Description:</label>
    <input type="text" name="Description">
    
    <label for="Is_Gov">Is Government Internship:</label>
    <select name="Is_Gov">
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>
    
    <button type="submit" name="insert" class="button">Insert/Update Internship</button>
    <button type="button" onclick="clearForm()" class="button clear-button">Clear</button>
</form>

<!-- Handle Insert/Update -->
<?php
if (isset($_POST['insert'])) {
    $Intern_ID = $_POST['Intern_ID'];
    $Name = isset($_POST['Name']) ? $_POST['Name'] : null;
    $Description = isset($_POST['Description']) ? $_POST['Description'] : null;
    $Is_Gov = isset($_POST['Is_Gov']) ? $_POST['Is_Gov'] : null;

    // Check if the Internship ID already exists
    $checkDuplicateSql = "SELECT * FROM internship WHERE Intern_ID = '$Intern_ID'";
    $duplicateResult = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($duplicateResult) > 0) {
        echo "Updating Internship ID $Intern_ID ". "<br>";
        $updateSql = "UPDATE internship SET Name = " . ($Name ? "'$Name'" : "NULL") . ", Description = " . ($Description !== null ? "'$Description'" : "NULL") . ", Is_Gov = '$Is_Gov' WHERE Intern_ID = '$Intern_ID'";

        if (mysqli_query($conn, $updateSql)) {
            echo "Internship information updated successfully";
        } else {
            echo "Error updating internship information: " . mysqli_error($conn);
        }
    } else {
        $insertSql = "INSERT INTO internship (Intern_ID, Name, Description, Is_Gov) VALUES ('$Intern_ID', " . ($Name ? "'$Name'" : "NULL") . ", " . ($Description !== null ? "'$Description'" : "NULL") . ", '$Is_Gov')";

        if (mysqli_query($conn, $insertSql)) {
            echo "New internship inserted successfully";
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
    }
}
?>


<!-- Table Itself-->
<h1> ALL Internships</h1>
<table>
    <tr>
        <th>Internship ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Is Government Internship</th>
        <th>Action</th>
    </tr>

    <?php 
      $selectSql = "SELECT * FROM internship;";
      $selectResult = mysqli_query($conn, $selectSql);
      $resultCheck = mysqli_num_rows($selectResult);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_array($selectResult)) {
          echo "<tr>";
          echo "<td>" . $row["Intern_ID"] . "</td>";
          echo "<td>" . ($row["Name"] ? $row["Name"] : 'NULL') . "</td>";
          echo "<td>" . ($row["Description"] !== null ? $row["Description"] : 'NULL') . "</td>";
          echo "<td>" . ($row["Is_Gov"] ? 'Yes' : 'No') . "</td>";
          echo "<td><button onclick=\"location.href='?edit=" . $row["Intern_ID"] . "'\">Edit</button> | <button onclick=\"location.href='?delete=" . $row["Intern_ID"] . "'\">Delete</button></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No internships found</td></tr>";
      }
    ?>
</table>

<!-- Handle Edit -->
<?php
if (isset($_GET['edit'])) {
    $editInternID = $_GET['edit'];

    $editSql = "SELECT * FROM internship WHERE Intern_ID = '$editInternID'";
    $editResult = mysqli_query($conn, $editSql);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editRow = mysqli_fetch_array($editResult);
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementsByName('Intern_ID')[0].value = '<?php echo $editRow["Intern_ID"]; ?>';
                document.getElementsByName('Name')[0].value = '<?php echo $editRow["Name"]; ?>';
                document.getElementsByName('Description')[0].value = '<?php echo $editRow["Description"]; ?>';
                document.getElementsByName('Is_Gov')[0].value = '<?php echo $editRow["Is_Gov"]; ?>';
            });
        </script>
    <?php
    }
}
?>

<!-- Handle Delete -->
<?php
if (isset($_GET['delete'])) {
    $deleteInternID = $_GET['delete'];

    $deleteSql = "DELETE FROM internship WHERE Intern_ID = '$deleteInternID'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Internship deleted successfully";
    } else {
        echo "Error deleting internship: " . mysqli_error($conn);
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
