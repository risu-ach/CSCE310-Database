<!-- Made By Rishika Acharya -->
<?php include_once 'db.php'; ?>
<?php include_once 'Student_App_nav.php'; ?> <!-- Include the navigation bar -->
<?php 
session_start();
// Check if the user is logged in
if (!isset($_SESSION["userUIN"])) {
    // If not, redirect to the login page
    header("Location: ../loginpage.php");
    exit();
}

$userUIN = $_SESSION["userUIN"];
$userName = $_SESSION["userName"];

?>
<!DOCTYPE html>
<html>

<body>

<h1>Apply For An Internship</h1>

<!-- Display Form for Inserting/Updating Internship Application Information -->
<form method="post">
    <?php $randomIANum = rand(1000, 9999); ?>
    <label for="IA_num">Application Number:</label>
    <input type="text" name="IA_num" value="<?php echo $randomIANum; ?>" required>
    
    <!-- Get UIN from college_student -->
    <label for="UIN">UIN:</label>
    <select name="UIN" required disabled>
        <option value="<?php echo $userUIN; ?>"><?php echo $userUIN; ?></option>
    </select>
    
    <label for="Intern_ID">Internship ID:</label>
    <select name="Intern_ID">
        <?php
        $internIDQuery = "SELECT Intern_ID FROM internship;";
        $internIDResult = mysqli_query($conn, $internIDQuery);

        while ($internIDRow = mysqli_fetch_assoc($internIDResult)) {
            echo "<option value='" . $internIDRow['Intern_ID'] . "'>" . $internIDRow['Intern_ID'] . "</option>";
        }
        ?>
    </select>
    
    <label for="Intern_status">Internship Status:</label>
    <select name="Intern_status" required>
        <option value="On process">On process</option>
        <option value="completed">Completed</option>
        <option value="Dropped">Dropped</option>
    </select>
    
    <label for="Intern_year">Internship Year:</label>
    <select name="Intern_year" required>
        <?php
        // Assuming Cert_year ranges from 2020 to 2028
        for ($i = 2020; $i <= 2028; $i++) {
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    
    <button type="submit" name="insert" class="button">Insert/Update Internship</button>
    <button type="button" onclick="clearForm()" class="button clear-button">Clear</button>
</form>

<!-- Handle Insert/Update -->
<?php
if (isset($_POST['insert'])) {
    $IA_num = $_POST['IA_num'];
    $UIN = $userUIN;
    $Intern_ID = isset($_POST['Intern_ID']) ? $_POST['Intern_ID'] : null;
    $Intern_status = isset($_POST['Intern_status']) ? $_POST['Intern_status'] : null;
    $Intern_year = isset($_POST['Intern_year']) ? $_POST['Intern_year'] : null;

    // Check if the application number already exists
    $checkDuplicateSql = "SELECT * FROM intern_app WHERE IA_num = '$IA_num'";
    $duplicateResult = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($duplicateResult) > 0) {
        echo "Updating Application ID $IA_num ". "<br>";
        $updateSql = "UPDATE intern_app SET UIN = '$UIN', Intern_ID = " . ($Intern_ID ? "'$Intern_ID'" : "NULL") . ", Intern_status = " . ($Intern_status ? "'$Intern_status'" : "NULL") . ", Intern_year = " . ($Intern_year ? "'$Intern_year'" : "NULL") . " WHERE IA_num = '$IA_num'";

        if (mysqli_query($conn, $updateSql)) {
            echo "Internship application information updated successfully";
        } else {
            echo "Error updating internship application information: " . mysqli_error($conn);
        }
    } else {
        $insertSql = "INSERT INTO intern_app (IA_num, UIN, Intern_ID, Intern_status, Intern_year) VALUES ('$IA_num', '$UIN', " . ($Intern_ID ? "'$Intern_ID'" : "NULL") . ", " . ($Intern_status ? "'$Intern_status'" : "NULL") . ", " . ($Intern_year ? "'$Intern_year'" : "NULL") . ")";

        if (mysqli_query($conn, $insertSql)) {
            echo "New internship application inserted successfully";
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!-- Table Itself-->
<h1> My Internship Applications</h1>
<table>
    <tr>
        <th>Application Number</th>
        <th>UIN</th>
        <th>Internship ID</th>
        <th>Internship Status</th>
        <th>Internship Year</th>
        <th>Action</th>
    </tr>

    <?php 
      $selectSql = "SELECT * FROM intern_app  WHERE UIN = '$userUIN';";
      $selectResult = mysqli_query($conn, $selectSql);
      $resultCheck = mysqli_num_rows($selectResult);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_array($selectResult)) {
          echo "<tr>";
          echo "<td>" . $row["IA_num"] . "</td>";
          echo "<td>" . $row["UIN"] . "</td>";
          echo "<td>" . ($row["Intern_ID"] ? $row["Intern_ID"] : 'NULL') . "</td>";
          echo "<td>" . ($row["Intern_status"] ? $row["Intern_status"] : 'NULL') . "</td>";
          echo "<td>" . ($row["Intern_year"] ? $row["Intern_year"] : 'NULL') . "</td>";
          echo "<td><button onclick=\"location.href='?edit=" . $row["IA_num"] . "'\">Edit</button> | <button onclick=\"location.href='?delete=" . $row["IA_num"] . "'\">Delete</button></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No internship applications found</td></tr>";
      }
    ?>
</table>

<!-- Handle Edit -->
<?php
if (isset($_GET['edit'])) {
    $editIANum = $_GET['edit'];

    $editSql = "SELECT * FROM intern_app WHERE IA_num = '$editIANum'";
    $editResult = mysqli_query($conn, $editSql);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editRow = mysqli_fetch_array($editResult);
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementsByName('IA_num')[0].value = '<?php echo $editRow["IA_num"]; ?>';
                document.getElementsByName('UIN')[0].value = '<?php echo $editRow["UIN"]; ?>';
                document.getElementsByName('Intern_ID')[0].value = '<?php echo $editRow["Intern_ID"]; ?>';
                document.getElementsByName('Intern_status')[0].value = '<?php echo $editRow["Intern_status"]; ?>';
                document.getElementsByName('Intern_year')[0].value = '<?php echo $editRow["Intern_year"]; ?>';
            });
        </script>
    <?php
    }
}
?>

<!-- Handle Delete -->
<?php
if (isset($_GET['delete'])) {
    $deleteIANum = $_GET['delete'];

    $deleteSql = "DELETE FROM intern_app WHERE IA_num = '$deleteIANum'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Internship application deleted successfully";
    } else {
        echo "Error deleting internship application: " . mysqli_error($conn);
    }
}
?>
<script>
    function clearForm() {
        document.getElementsByName('IA_num')[0].value = '';
                document.getElementsByName('UIN')[0].value = '';
                document.getElementsByName('Intern_ID')[0].value = '';
                document.getElementsByName('Intern_status')[0].value = '';
                document.getElementsByName('Intern_year')[0].value = '';
   
    }
</script>

</body>
</html>
