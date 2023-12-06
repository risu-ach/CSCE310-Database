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
$filter_Cert_ID = '';
$filter_Cert_status = '';
$filter_Train_status = '';
// Process filters if the form is submitted
if (isset($_POST['apply_filters'])) {
    $filter_UIN = $_POST['filter_UIN'];
    $filter_Cert_ID = $_POST['filter_Cert_ID'];
    $filter_Cert_status = $_POST['filter_Cert_status'];
    $filter_Train_status = $_POST['filter_Train_status'];
}
?>
<!DOCTYPE html>
<html>
<body>

<h1> Add a Student's Certification</h1>

<!-- Display Form for Inserting/Updating Certification Enrollment Information -->
<form method="post">
    <label for="CertE_num">Certification Enrollment Number:</label>
    <input type="text" name="CertE_num" required>
    
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
    
    <label for="Cert_ID">Certification ID:</label>
    <select name="Cert_ID" required>
        <?php
        $certIDQuery = "SELECT Cert_ID FROM certification;";
        $certIDResult = mysqli_query($conn, $certIDQuery);

        while ($certIDRow = mysqli_fetch_assoc($certIDResult)) {
            echo "<option value='" . $certIDRow['Cert_ID'] . "'>" . $certIDRow['Cert_ID'] . "</option>";
        }
        ?>
    </select>
    
    <label for="Cert_status">Certification Status:</label>
    <select name="Cert_status" required>
        <option value="On process">On process</option>
        <option value="completed">Completed</option>
        <option value="Dropped">Dropped</option>
    </select>
    
    <label for="Training_status">Training Status:</label>
    <select name="Training_status" required>
        <option value="On process">On process</option>
        <option value="completed">Completed</option>
        <option value="Dropped">Dropped</option>
    </select>
    
    <label for="Program_num">Program Number:</label>
    <select name="Program_num" required>
        <?php
        $certIDQuery = "SELECT Program_num FROM program;";
        $certIDResult = mysqli_query($conn, $certIDQuery);

        while ($certIDRow = mysqli_fetch_assoc($certIDResult)) {
            echo "<option value='" . $certIDRow['Program_num'] . "'>" . $certIDRow['Program_num'] . "</option>";
        }
        ?>
    </select>
    
    <label for="Semester">Semester:</label>
    <select name="Semester" required>
        <?php
        // Assuming Semester ranges from 1 to 10
        for ($i = 1; $i <= 10; $i++) {
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    
    <label for="Cert_year">Certification Year:</label>
    <select name="Cert_year" required>
        <?php
        // Assuming Cert_year ranges from 2020 to 2028
        for ($i = 2020; $i <= 2028; $i++) {
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    
    <button type="submit" name="insert" class="button">Insert/Update Certificate</button>
    <button type="button" onclick="clearForm()" class="button clear-button">Clear</button>
</form>

<!-- Handle Insert/Update -->
<?php
if (isset($_POST['insert'])) {
    $CertE_num = $_POST['CertE_num'];
    $UIN = $_POST['UIN'];
    $Cert_ID = $_POST['Cert_ID'];
    $Cert_status = $_POST['Cert_status'];
    $Training_status = $_POST['Training_status'];
    $Program_num = $_POST['Program_num'];
    $Semester = $_POST['Semester'];
    $Cert_year = $_POST['Cert_year'];

    // Check if the enrollment number already exists
    $checkDuplicateSql = "SELECT * FROM cert_enrollment WHERE CertE_num = '$CertE_num'";
    $duplicateResult = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($duplicateResult) > 0) {
        echo "Updating Certification Enrollment ID $CertE_num ". "<br>";
        $updateSql = "UPDATE cert_enrollment SET UIN = '$UIN', Cert_ID = '$Cert_ID', Cert_status = '$Cert_status', Training_status = '$Training_status', Program_num = '$Program_num', Semester = '$Semester', Cert_year = '$Cert_year' WHERE CertE_num = '$CertE_num'";

        if (mysqli_query($conn, $updateSql)) {
            echo "Certification enrollment information updated successfully";
        } else {
            echo "Error updating certification enrollment information: " . mysqli_error($conn);
        }
    } else {
        $insertSql = "INSERT INTO cert_enrollment (CertE_num, UIN, Cert_ID, Cert_status, Training_status, Program_num, Semester, Cert_year) VALUES ('$CertE_num', '$UIN', '$Cert_ID', '$Cert_status', '$Training_status', '$Program_num', '$Semester', '$Cert_year')";

        if (mysqli_query($conn, $insertSql)) {
            echo "New certification enrollment inserted successfully";
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
                echo "<option value='" . $rowUIN["UIN"] . "'>" . $rowUIN["UIN"] . "</option>";
            }
            ?>
        </select>
        <label for="filter_Cert_ID">Filter by Certification ID:</label>
        <select name="filter_Cert_ID">
            <option value="">All</option>
            <?php
            $selectCertIDSql = "SELECT Cert_ID FROM certification;";
            $selectCertIDResult = mysqli_query($conn, $selectCertIDSql);

            while ($rowCertID = mysqli_fetch_array($selectCertIDResult)) {
                echo "<option value='" . $rowCertID["Cert_ID"] . "'>" . $rowCertID["Cert_ID"] . "</option>";
            }
            ?>
        </select>
        <label for="filter_Cert_status">Filter by Certificate Status:</label>
        <select name="filter_Cert_status">
            <option value="">All</option>
            <option value="On process" <?php echo ($filter_Cert_status == 'On process') ? 'selected' : ''; ?>>On process</option>
            <option value="completed" <?php echo ($filter_Cert_status == 'completed') ? 'selected' : ''; ?>>Completed</option>
            <option value="Dropped" <?php echo ($filter_Cert_status == 'Dropped') ? 'selected' : ''; ?>>Dropped</option>
        </select>
        <label for="filter_Train_status">Filter by Class Status:</label>
        <select name="filter_Train_status">
            <option value="">All</option>
            <option value="On process" <?php echo ($filter_Train_status == 'On process') ? 'selected' : ''; ?>>On process</option>
            <option value="completed" <?php echo ($filter_Train_status == 'completed') ? 'selected' : ''; ?>>Completed</option>
            <option value="Dropped" <?php echo ($filter_Train_status == 'Dropped') ? 'selected' : ''; ?>>Dropped</option>
        </select>

        <button type="submit" name="apply_filters" class="button">Apply Filter</button>
        <button type="button" onclick="clearFilter()" class="button clear-button">Clear Filter</button>
    </form>


<!-- Table Itself-->
<h1> All Certificates</h1>
<table>
    <tr>
        <th>Certification Enrollment Number</th>
        <th>UIN</th>
        <th>Certification ID</th>
        <th>Certification Status</th>
        <th>Training Status</th>
        <th>Program Number</th>
        <th>Semester</th>
        <th>Certification Year</th>
        <th>Action</th>
    </tr>

    <?php
        $selectSql = "SELECT * FROM cert_enrollment WHERE 1";
        if (!empty($filter_UIN)) {
            $selectSql .= " AND UIN = '$filter_UIN'";
        }
        if (!empty($filter_Cert_ID)) {
            $selectSql .= " AND Cert_ID = '$filter_Cert_ID'";
        }
        if (!empty($filter_Cert_status)) {
            $selectSql .= " AND Cert_status = '$filter_Cert_status'";
        }
        if (!empty($filter_Train_status)) {
            $selectSql .= " AND Training_status = '$filter_Train_status'";
        }
        $selectResult = mysqli_query($conn, $selectSql);
        $resultCheck = mysqli_num_rows($selectResult);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_array($selectResult)) {
          echo "<tr>";
          echo "<td>" . $row["CertE_num"] . "</td>";
          echo "<td>" . $row["UIN"] . "</td>";
          echo "<td>" . $row["Cert_ID"] . "</td>";
          echo "<td>" . $row["Cert_status"] . "</td>";
          echo "<td>" . $row["Training_status"] . "</td>";
          echo "<td>" . $row["Program_num"] . "</td>";
          echo "<td>" . $row["Semester"] . "</td>";
          echo "<td>" . $row["Cert_year"] . "</td>";
          echo "<td><button onclick=\"location.href='?edit=" . $row["CertE_num"] . "'\">Edit</button> | <button onclick=\"location.href='?delete=" . $row["CertE_num"] . "'\">Delete</button></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='9'>No certification enrollments found</td></tr>";
      }
    ?>
</table>

<!-- Handle Edit -->
<?php
if (isset($_GET['edit'])) {
    $editCertENum = $_GET['edit'];

    $editSql = "SELECT * FROM cert_enrollment WHERE CertE_num = '$editCertENum'";
    $editResult = mysqli_query($conn, $editSql);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editRow = mysqli_fetch_array($editResult);
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementsByName('CertE_num')[0].value = '<?php echo $editRow["CertE_num"]; ?>';
                document.getElementsByName('UIN')[0].value = '<?php echo $editRow["UIN"]; ?>';
                document.getElementsByName('Cert_ID')[0].value = '<?php echo $editRow["Cert_ID"]; ?>';
                document.getElementsByName('Cert_status')[0].value = '<?php echo $editRow["Cert_status"]; ?>';
                document.getElementsByName('Training_status')[0].value = '<?php echo $editRow["Training_status"]; ?>';
                document.getElementsByName('Program_num')[0].value = '<?php echo $editRow["Program_num"]; ?>';
                document.getElementsByName('Semester')[0].value = '<?php echo $editRow["Semester"]; ?>';
                document.getElementsByName('Cert_year')[0].value = '<?php echo $editRow["Cert_year"]; ?>';
            });
        </script>
    <?php
    }
}
?>

<!-- Handle Delete -->
<?php
if (isset($_GET['delete'])) {
    $deleteCertENum = $_GET['delete'];

    $deleteSql = "DELETE FROM cert_enrollment WHERE CertE_num = '$deleteCertENum'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Certification enrollment deleted successfully";
    } else {
        echo "Error deleting certification enrollment: " . mysqli_error($conn);
    }
}
?>
<script>
    function clearForm() {
        document.getElementsByName('CertE_num')[0].value = '';
        document.getElementsByName('UIN')[0].value = '';
        document.getElementsByName('Cert_ID')[0].value = '';
        document.getElementsByName('Cert_status')[0].value = '';
        document.getElementsByName('Training_status')[0].value = '';
        document.getElementsByName('Program_num')[0].value = '';
        document.getElementsByName('Semester')[0].value = '';
        document.getElementsByName('Cert_year')[0].value = '';
            
    }
    function clearFilter() {
        var filterUIN = document.getElementsByName('filter_UIN')[0].value;
        var filterCertID = document.getElementsByName('filter_Cert_ID')[0].value;
        var filterCertStatus = document.getElementsByName('filter_Cert_status')[0].value;
        var filterTrainStatus = document.getElementsByName('filter_Train_status')[0].value;

        document.forms[0].reset(); // Reset the entire form
        document.getElementsByName('filter_UIN')[0].value = filterUIN;
        document.getElementsByName('filter_Cert_ID')[0].value = filterCertID;
        document.getElementsByName('filter_Cert_status')[0].value = filterCertStatus;
        document.getElementsByName('filter_Train_status')[0].value = filterTrainStatus;

        document.forms[0].submit(); // Submit the form after resetting filters
    }
</script>

</body>
</html>
