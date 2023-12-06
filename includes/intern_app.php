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
// Initialize filter variables
$filter_UIN = '';
$filter_Class_ID = '';
$filter_Class_status = '';
// Process filters if the form is submitted
if (isset($_POST['apply_filters'])) {
    $filter_UIN = $_POST['filter_UIN'];
    $filter_Internship_ID = $_POST['filter_Internship_ID'];
    $filter_Internship_Status = $_POST['filter_Internship_Status'];

}
?>

<!DOCTYPE html>
<html>

<body>

<h1>Add/Edit an Student's Internship</h1>

<!-- Display Form for Inserting/Updating Internship Application Information -->
<form method="post">
    <label for="IA_num">Application Number:</label>
    <input type="text" name="IA_num" required>
    
    <label for="UIN">UIN:</label>
    <select name="UIN" required>
        <?php
        $uinQuery = "SELECT UIN FROM college_student;";
        $uinResult = mysqli_query($conn, $uinQuery);

        while ($uinRow = mysqli_fetch_assoc($uinResult)) {
            echo "<option value='" . $uinRow['UIN'] . "'>" . $uinRow['UIN'] . "</option>";
        }
        ?>
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
    $UIN = $_POST['UIN'];
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
<!-- Filter Form -->
<form method="post">
    <label for="filter_UIN">Filter by UIN:</label>
    <select name="filter_UIN">
        <option value="">All</option>
        <?php
        $selectUINSql = "SELECT UIN FROM college_student;";
        $selectUINResult = mysqli_query($conn, $selectUINSql);

        while ($rowUIN = mysqli_fetch_array($selectUINResult)) {
            $selected = ($filter_UIN == $rowUIN["UIN"]) ? 'selected' : '';
            echo "<option value='" . $rowUIN["UIN"] . "' $selected>" . $rowUIN["UIN"] . "</option>";
        }
        ?>
    </select>

    <label for="filter_Internship_ID">Filter by Internship ID:</label>
    <select name="filter_Internship_ID">
        <option value="">All</option>
        <?php
        $selectInternshipIDSql = "SELECT Intern_ID FROM internship;";
        $selectInternshipIDResult = mysqli_query($conn, $selectInternshipIDSql);

        while ($rowInternshipID = mysqli_fetch_array($selectInternshipIDResult)) {
            $selected = ($filter_Internship_ID == $rowInternshipID["Intern_ID"]) ? 'selected' : '';
            echo "<option value='" . $rowInternshipID["Intern_ID"] . "' $selected>" . $rowInternshipID["Intern_ID"] . "</option>";
        }
        ?>
    </select>

    <label for="filter_Internship_Status">Filter by Internship Status:</label>
    <select name="filter_Internship_Status">
        <option value="">All</option>
        <option value="On process" <?php echo ($filter_Internship_Status == 'On process') ? 'selected' : ''; ?>>On process</option>
        <option value="completed" <?php echo ($filter_Internship_Status == 'completed') ? 'selected' : ''; ?>>Completed</option>
        <option value="Dropped" <?php echo ($filter_Internship_Status == 'Dropped') ? 'selected' : ''; ?>>Dropped</option>
    </select>

    <button type="submit" name="apply_filters" class="button">Apply Filters</button>
    <button type="button" onclick="clearFilters()" class="button clear-button">Clear Filters</button>
</form>

<!-- Table Itself-->
<h1> ALL Internship Applications</h1>
<table>
    <tr>
        <th>Application Number</th>
        <th>UIN</th>
        <th>Internship ID</th>
        <th>Internship Status</th>
        <th>Internship Year</th>
        <th>Action</th>x
    </tr>

    <?php 
        // Construct SQL query based on filters
        $selectSql = "SELECT * FROM intern_app WHERE 1";

        if (!empty($filter_UIN)) {
            $selectSql .= " AND UIN = '$filter_UIN'";
        }

        if (!empty($filter_Internship_ID)) {
            $selectSql .= " AND Intern_ID = '$filter_Internship_ID'";
        }

        if (!empty($filter_Internship_Status)) {
            $selectSql .= " AND Intern_status = '$filter_Internship_Status'";
        }

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
    function clearFilters() {
        document.getElementsByName('filter_UIN')[0].value = '';
        document.getElementsByName('filter_Internship_ID')[0].value = '';
        document.getElementsByName('filter_Internship_Status')[0].value = '';
        document.forms[0].submit(); // Submit the form after clearing filters
    }
</script>

</body>
</html>
