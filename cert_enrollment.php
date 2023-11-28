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

<h1>Certification Enrollment</h1>

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
    
    <button type="submit" name="insert">Insert/Update Certification Enrollment</button>
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

<!-- Table Itself-->
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
      $selectSql = "SELECT * FROM cert_enrollment;";
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
          echo "<td><a href='?edit=" . $row["CertE_num"] . "'>Edit</a> | <a href='?delete=" . $row["CertE_num"] . "'>Delete</a></td>";
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

</body>
</html>
