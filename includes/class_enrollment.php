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
    $filter_Class_ID = $_POST['filter_Class_ID'];
    $filter_Class_status = $_POST['filter_Class_status'];
}
?>

<!DOCTYPE html>
<html>

<body>

<h1>Enroll a Student for a class</h1>

<!-- Display Form for Inserting/Updating Class Enrollment Information -->
<form method="post">
    <label for="CE_num">Enrollment Number:</label>
    <input type="text" name="CE_num" required>
    
    <!-- Get UIN from college_student -->
    <label for="UIN">UIN:</label>
    <select name="UIN" required>
        <?php
        $selectUINSql = "SELECT UIN FROM college_student;";
        $selectUINResult = mysqli_query($conn, $selectUINSql);

        while ($rowUIN = mysqli_fetch_array($selectUINResult)) {
            echo "<option value='" . $rowUIN["UIN"] . "'>" . $rowUIN["UIN"] . "</option>";
        }
        ?>
    </select>
    
    <!-- Get Class_ID from classes -->
    <label for="class_ID">Class ID:</label>
    <select name="class_ID" required>
        <?php
        $selectClassIDSql = "SELECT Class_ID FROM classes;";
        $selectClassIDResult = mysqli_query($conn, $selectClassIDSql);

        while ($rowClassID = mysqli_fetch_array($selectClassIDResult)) {
            echo "<option value='" . $rowClassID["Class_ID"] . "'>" . $rowClassID["Class_ID"] . "</option>";
        }
        ?>
    </select>
    
    <label for="Class_status">Class Status:</label>
    <select name="Class_status" required>
        <option value="On process">On process</option>
        <option value="completed">Completed</option>
        <option value="Dropped">Dropped</option>
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
    
    <label for="Class_year">Class Year:</label>
    <select name="Class_year" required>
        <?php
        // Assuming Cert_year ranges from 2020 to 2028
        for ($i = 2020; $i <= 2028; $i++) {
            echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    
    <button type="submit" name="insert" class="button">Insert/Update Classes</button>
    <button type="button" onclick="clearForm()" class="button clear-button">Clear</button>
</form>


<!-- Handle Insert/Update -->
<?php
if (isset($_POST['insert'])) {
    $CE_num = $_POST['CE_num'];
    $UIN = $_POST['UIN'];
    $class_ID = $_POST['class_ID'];
    $Class_status = $_POST['Class_status'];
    $Semester = $_POST['Semester'];
    $Class_year = $_POST['Class_year'];

    // Check if the enrollment number already exists
    $checkDuplicateSql = "SELECT * FROM class_enrollment WHERE CE_num = '$CE_num'";
    $duplicateResult = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($duplicateResult) > 0) {
        echo "Updating Enrollment ID $CE_num ". "<br>";
        $updateSql = "UPDATE class_enrollment SET UIN = '$UIN', class_ID = '$class_ID', Class_status = '$Class_status', Semester = '$Semester', Class_year = '$Class_year' WHERE CE_num = '$CE_num'";

        if (mysqli_query($conn, $updateSql)) {
            echo "Class enrollment information updated successfully";
        } else {
            echo "Error updating class enrollment information: " . mysqli_error($conn);
        }
    } else {
        $insertSql = "INSERT INTO class_enrollment (CE_num, UIN, class_ID, Class_status, Semester, Class_year) VALUES ('$CE_num', '$UIN', '$class_ID', '$Class_status', '$Semester', '$Class_year')";

        if (mysqli_query($conn, $insertSql)) {
            echo "New class enrollment inserted successfully";
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

    <label for="filter_Class_ID">Filter by Class ID:</label>
    <select name="filter_Class_ID">
        <option value="">All</option>
        <?php
        $selectClassIDSql = "SELECT Class_ID FROM classes;";
        $selectClassIDResult = mysqli_query($conn, $selectClassIDSql);

        while ($rowClassID = mysqli_fetch_array($selectClassIDResult)) {
            $selected = ($filter_Class_ID == $rowClassID["Class_ID"]) ? 'selected' : '';
            echo "<option value='" . $rowClassID["Class_ID"] . "' $selected>" . $rowClassID["Class_ID"] . "</option>";
        }
        ?>
    </select>

    <label for="filter_Class_status">Filter by Class Status:</label>
    <select name="filter_Class_status">
        <option value="">All</option>
        <option value="On process" <?php echo ($filter_Class_status == 'On process') ? 'selected' : ''; ?>>On process</option>
        <option value="completed" <?php echo ($filter_Class_status == 'completed') ? 'selected' : ''; ?>>Completed</option>
        <option value="Dropped" <?php echo ($filter_Class_status == 'Dropped') ? 'selected' : ''; ?>>Dropped</option>
    </select>

    <button type="submit" name="apply_filters" class="button">Apply Filters</button>
    <button type="button" onclick="clearFilters()" class="button clear-button">Clear Filters</button>
</form>

<!-- Table Itself-->
<h1> All Classes Applications</h1>
<table>
    <tr>
        <th>Enrollment Number</th>
        <th>UIN</th>
        <th>Class ID</th>
        <th>Class Status</th>
        <th>Semester</th>
        <th>Class Year</th>
        <th>Action</th>
    </tr>

    <?php 
      // Construct SQL query based on filters
      $selectSql = "SELECT * FROM class_enrollment WHERE 1";
      if (!empty($filter_UIN)) {
          $selectSql .= " AND UIN = '$filter_UIN'";
      }
      if (!empty($filter_Class_ID)) {
          $selectSql .= " AND class_ID = '$filter_Class_ID'";
      }
      if (!empty($filter_Class_status)) {
          $selectSql .= " AND Class_status = '$filter_Class_status'";
      }

      $selectResult = mysqli_query($conn, $selectSql);
      $resultCheck = mysqli_num_rows($selectResult);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_array($selectResult)) {
          echo "<tr>";
          echo "<td>" . $row["CE_num"] . "</td>";
          echo "<td>" . $row["UIN"] . "</td>";
          echo "<td>" . $row["class_ID"] . "</td>";
          echo "<td>" . $row["Class_status"] . "</td>";
          echo "<td>" . $row["Semester"] . "</td>";
          echo "<td>" . $row["Class_year"] . "</td>";
          echo "<td><button onclick=\"location.href='?edit=" . $row["CE_num"] . "'\">Edit</button> | <button onclick=\"location.href='?delete=" . $row["CE_num"] . "'\">Delete</button></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='7'>No class enrollments found</td></tr>";
      }
    ?>
</table>
<!-- Handle Edit -->
<?php
if (isset($_GET['edit'])) {
    $editCENum = $_GET['edit'];

    $editSql = "SELECT * FROM class_enrollment WHERE CE_num = '$editCENum'";
    $editResult = mysqli_query($conn, $editSql);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editRow = mysqli_fetch_array($editResult);
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementsByName('CE_num')[0].value = '<?php echo $editRow["CE_num"]; ?>';
                document.getElementsByName('UIN')[0].value = '<?php echo $editRow["UIN"]; ?>';
                document.getElementsByName('class_ID')[0].value = '<?php echo $editRow["class_ID"]; ?>';
                document.getElementsByName('Class_status')[0].value = '<?php echo $editRow["Class_status"]; ?>';
                document.getElementsByName('Semester')[0].value = '<?php echo $editRow["Semester"]; ?>';
                document.getElementsByName('Class_year')[0].value = '<?php echo $editRow["Class_year"]; ?>';
            });
        </script>
    <?php
    }
}
?>

<!-- Handle Delete -->
<?php
if (isset($_GET['delete'])) {
    $deleteCENum = $_GET['delete'];

    $deleteSql = "DELETE FROM class_enrollment WHERE CE_num = '$deleteCENum'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Class enrollment deleted successfully";
    } else {
        echo "Error deleting class enrollment: " . mysqli_error($conn);
    }
}
?>
<script>
    function clearForm() {
        document.getElementsByName('CE_num')[0].value = '';
        document.getElementsByName('UIN')[0].value = '';
        document.getElementsByName('class_ID')[0].value = '';
        document.getElementsByName('Class_status')[0].value = '';
        document.getElementsByName('Semester')[0].value = '';
        document.getElementsByName('Class_year')[0].value = '';

    }
    function clearFilters() {
        document.getElementsByName('filter_UIN')[0].value = '';
        document.getElementsByName('filter_Class_ID')[0].value = '';
        document.getElementsByName('filter_Class_status')[0].value = '';
        document.forms[0].submit(); // Submit the form after clearing filters
    }
</script>


</body>
</html>

