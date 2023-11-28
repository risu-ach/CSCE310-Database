<?php include_once 'includes/db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Classes Table</h1>

<!-- Display Form for Inserting/Updating Class Information -->
<form method="post">
    <label for="Class_ID">Class ID:</label>
    <input type="text" name="Class_ID" required>
    
    <label for="Name">Name:</label>
    <input type="text" name="Name">
    
    <label for="Type">Type:</label>
    <input type="text" name="Type">
    
    <label for="Description">Description:</label>
    <input type="text" name="Description">
    
    <button type="submit" name="insert">Insert/Update Class</button>
</form>

<!-- Handle Insert/Update -->
<?php
if (isset($_POST['insert'])) {
    $Class_ID = $_POST['Class_ID'];
    $Name = isset($_POST['Name']) ? $_POST['Name'] : null;
    $Type = isset($_POST['Type']) ? $_POST['Type'] : null;
    $Description = isset($_POST['Description']) ? $_POST['Description'] : null;
    

    // Check if the class ID already exists
    $checkDuplicateSql = "SELECT * FROM classes WHERE Class_ID = '$Class_ID'";
    $duplicateResult = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($duplicateResult) > 0) {
        echo "Updating Class ID $Class_ID ". "<br>";
        $updateSql = "UPDATE classes SET Name = " . ($Name !== null ? "'$Name'" : "NULL") . ", Type = " . ($Type !== null ? "'$Type'" : "NULL") . ", Description = " . ($Description !== null ? "'$Description'" : "NULL") . " WHERE Class_ID = '$Class_ID'";
      
        if (mysqli_query($conn, $updateSql)) {
            echo "Class information updated successfully";
        } else {
            echo "Error updating class information: " . mysqli_error($conn);
        }
    } else {
        $insertSql = "INSERT INTO classes (Class_ID, Name, Type, Description) VALUES ('$Class_ID', " . ($Name !== null ? "'$Name'" : "NULL") . ", " . ($Type !== null ? "'$Type'" : "NULL") . ", " . ($Description !== null ? "'$Description'" : "NULL") . ")";
        
        if (mysqli_query($conn, $insertSql)) {
            echo "New class inserted successfully";
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!-- Table Itself-->
<table>
    <tr>
        <th>Class ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Description</th>
        <th>Action</th>
    </tr>

    <?php 
      $selectSql = "SELECT * FROM classes;";
      $selectResult = mysqli_query($conn, $selectSql);
      $resultCheck = mysqli_num_rows($selectResult);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_array($selectResult)) {
          echo "<tr>";
          echo "<td>" . $row["Class_ID"] . "</td>";
          echo "<td>" . ($row["Name"] ? $row["Name"] : 'NULL') . "</td>";
          echo "<td>" . ($row["Type"] ? $row["Type"] : 'NULL') . "</td>";
          echo "<td>" . ($row["Description"] ? $row["Description"] : 'NULL') . "</td>";
          echo "<td><a href='?edit=" . $row["Class_ID"] . "'>Edit</a> | <a href='?delete=" . $row["Class_ID"] . "'>Delete</a></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No classes found</td></tr>";
      }
    ?>
</table>

<!-- Handle Edit -->
<?php
if (isset($_GET['edit'])) {
    $editClassID = $_GET['edit'];

    $editSql = "SELECT * FROM classes WHERE Class_ID = '$editClassID'";
    $editResult = mysqli_query($conn, $editSql);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editRow = mysqli_fetch_array($editResult);
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementsByName('Class_ID')[0].value = '<?php echo $editRow["Class_ID"]; ?>';
                document.getElementsByName('Name')[0].value = '<?php echo $editRow["Name"]; ?>';
                document.getElementsByName('Type')[0].value = '<?php echo $editRow["Type"]; ?>';
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
    $deleteClassID = $_GET['delete'];

    $deleteSql = "DELETE FROM classes WHERE Class_ID = '$deleteClassID'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Class deleted successfully";
    } else {
        echo "Error deleting class: " . mysqli_error($conn);
    }
}
?>

</body>
</html>
