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

<h1>Program Table</h1>

<!-- Display Form for Inserting/Updating Program Description and Name -->
<form method="post">
    <label for="program_num">Program Number:</label>
    <input type="text" name="program_num" required>
    
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    
    <label for="description">Description:</label>
    <input type="text" name="description" required>
    
    <button type="submit" name="insert">Insert/Update Program</button>
</form>

<!-- Handle Insert/update -->
<?php
if (isset($_POST['insert'])) {
    $program_num = $_POST['program_num'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Check if the program ID already exists
    $checkDuplicateSql = "SELECT * FROM program WHERE Program_num = '$program_num'";
    $duplicateResult = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($duplicateResult) > 0) {
        echo "Updating ID $program_num ". "<br>";
        $updateSql = "UPDATE program SET Name = '$name', Description = '$description' WHERE Program_num = '$program_num'";

        if (mysqli_query($conn, $updateSql)) {
            echo "Program information updated successfully";
        } else {
            echo "Error updating program information: " . mysqli_error($conn);
        }
    } else {
        $insertSql = "INSERT INTO program (Program_num, Name, Description) VALUES ('$program_num', '$name', '$description')";

        if (mysqli_query($conn, $insertSql)) {
            echo "New program inserted successfully";
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
    }
}
?>
<!-- Table Itself-->
<table>
    <tr>
        <th>Program Number</th>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
    </tr>

    <?php 
      $selectSql = "SELECT * FROM program;";
      $selectResult = mysqli_query($conn, $selectSql);
      $resultCheck = mysqli_num_rows($selectResult);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_array($selectResult)) {
          echo "<tr>";
          echo "<td>" . $row["Program_num"] . "</td>";
          echo "<td>" . $row["Name"] . "</td>";
          echo "<td>" . $row["Description"] . "</td>";
          echo "<td><a href='?edit=" . $row["Program_num"] . "'>Edit</a> | <a href='?delete=" . $row["Program_num"] . "'>Delete</a></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No programs found</td></tr>";
      }
    ?>
</table>

<!-- Handle Edit -->
<?php
if (isset($_GET['edit'])) {
    $editProgramNum = $_GET['edit'];

    $editSql = "SELECT * FROM program WHERE Program_num = '$editProgramNum'";
    $editResult = mysqli_query($conn, $editSql);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editRow = mysqli_fetch_array($editResult);
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementsByName('program_num')[0].value = '<?php echo $editRow["Program_num"]; ?>';
                document.getElementsByName('name')[0].value = '<?php echo $editRow["Name"]; ?>';
                document.getElementsByName('description')[0].value = '<?php echo $editRow["Description"]; ?>';
            });
        </script>
    <?php
    }
}
?>

<!-- Handle Delete -->
<?php
if (isset($_GET['delete'])) {
    $deleteProgramNum = $_GET['delete'];

    $deleteSql = "DELETE FROM program WHERE Program_num = '$deleteProgramNum'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Program deleted successfully";
    } else {
        echo "Error deleting program: " . mysqli_error($conn);
    }
}
?>

</body>
</html>
