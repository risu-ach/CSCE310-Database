<?php 

    include_once 'includes/dbh.inc.php';

    $sql = "SELECT * FROM cc_event";
    $result = mysqli_query($conn, $sql);

    $resultCheck = mysqli_num_rows($result);

    $rows = $result->fetch_all(MYSQLI_ASSOC);     
?> 


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css"> 
        <title>Events</title>
    </head>
    <body>
    <form action="index.php">
        <button type="submit"><b>Home</b></button>
    </form>     
    <h2>Events Table</h2>


<table>
    <tr>
        <th>Event ID</th>
        <th>UIN</th>
        <th>Program Number</th>
        <th>Start Date</th>
        <th>Event Time</th>
        <th>Location</th>
        <th>End Date</th>
        <th>Event Type</th>
    </tr>

    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?php echo $row['Event_ID']; ?></td>
            <td><?php echo $row['UIN']; ?></td>
            <td><?php echo $row['Program_num']; ?></td>
            <td><?php echo $row['Start_date']; ?></td>
            <td><?php echo $row['Event_time']; ?></td>
            <td><?php echo $row['Location']; ?></td>
            <td><?php echo $row['End_date']; ?></td>
            <td><?php echo $row['Event_type']; ?></td>
            <td> <?php echo "<a href='update_event.php?Event_ID={$row['Event_ID']}'>Update</a>" ?></td>;
            <td><?php echo"<a href='?delete=" . $row["Event_ID"] . "'>Delete</a>"?></td>";
            ?> </td>
        </tr> 
    <?php endforeach; ?>
</table>


<h3>Add an event</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="Event_ID">Event ID:</label>
    <input type="int" id="Event_ID" name="Event_ID" required>
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

    <label for="Program_num">Program_num:</label>
    <select name="Program_num" required>
        <?php
        $selectProgramSql = "SELECT Program_num FROM program;";
        $selectProgramResult = mysqli_query($conn, $selectProgramSql);

        while ($rowProgram = mysqli_fetch_array($selectProgramResult)) {
            echo "<option value='" . $rowProgram["Program_num"] . "'>" . $rowProgram["Program_num"] . "</option>";
        }
        ?>
    </select>

    <label for="Start_date">Start Date(yyyy-mm-dd): </label>
    <input type="date" id="Start_date" name="Start_date" required>

    <label for="Event_time">Event Time(hh:mm:ss):</label>
    <input type="time" id="Event_time" name="Event_time" required>

    
    <label for="Location">Location:</label>
    <input type="varchar" id="Location" name="Location" required>

    <label for="End_date">End date(yyyy-mm-dd):</label>
    <input type="date" id="End_date" name="End_date" required>

    
    <label for="Event_type">Event Type:</label>
    <input type="varchar" id="Event_type" name="Event_type" required>

    <label for="ET_num">Event tracking Numbwe:</label>
    <input type="int" id="ET_num" name="ET_num" required>

    <button type="submit" name="add">Add Event</button>
</form> 

<h3>Update an Event</h3>
<form method="post">
    <label for="Event_ID">Event ID:</label>
    <input type="int" id="Event_ID" name="Event_ID" required>
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

    <label for="Program_num">Program_num:</label>
    <select name="Program_num" required>
        <?php
        $selectProgramSql = "SELECT Program_num FROM program;";
        $selectProgramResult = mysqli_query($conn, $selectProgramSql);

        while ($rowProgram = mysqli_fetch_array($selectProgramResult)) {
            echo "<option value='" . $rowProgram["Program_num"] . "'>" . $rowProgram["Program_num"] . "</option>";
        }
        ?>
    </select>

    <label for="Start_date">Start Date(yyyy-mm-dd): </label>
    <input type="date" id="Start_date" name="Start_date" required>

    <label for="Event_time">Event Time(hh:mm:ss):</label>
    <input type="time" id="Event_time" name="Event_time" required>

    
    <label for="Location">Location:</label>
    <input type="varchar" id="Location" name="Location" required>

    <label for="End_date">End date(yyyy-mm-dd):</label>
    <input type="date" id="End_date" name="End_date" required>

    
    <label for="Event_type">Event Type:</label>
    <input type="varchar" id="Event_type" name="Event_type" required>

    <label for="ET_num">Event tracking Numbwe:</label>
    <input type="int" id="ET_num" name="ET_num" required>

    <button type="submit" name="update"> Update</button>
</form> 

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $Event_ID = $_POST['Event_ID'];
    $UIN = $_POST['UIN'];
    $Program_num = $_POST['Program_num'];
    $Start_date= $_POST['Start_date'];
    $Event_time = $_POST['Event_time'];
    $Location = $_POST['Location'];
    $End_date= $_POST['End_date'];
    $Event_type= $_POST['Event_type'];
    $ET_num = $_POST['ET_num'];

    $checkUINQuery = "SELECT UIN FROM college_student WHERE UIN = '$UIN'";
    $result = $conn->query($checkUINQuery);
    if ($result->num_rows == 0) {
        echo "Error: UIN '$UIN' does not exist in the college_student table.";
    } else {
        // Insert data into the table
        $sql = "INSERT INTO cc_event (Event_ID, UIN, Program_num, Start_date, Event_time, Location, End_date, Event_type) VALUES ('$Event_ID', '$UIN', '$Program_num', '$Start_date', '$Event_time', '$Location', '$End_date', '$Event_type')";
       // $sql = "INSERT INTO event_tracking (ET_num, UIN, Program_num) VALUES ('$ET_num', '$UIN', '$Program_num')";
        header("Location: ".$_SERVER['PHP_SELF']);
        if ($conn->query($sql) === TRUE) {
            echo "Data added successfully";
        } else {
            echo "Error adding data: " . $conn->error;
    }
}
}
?>
<?php 
if (isset($_POST['update'])) {
    $editNum = $_GET['update'];
    $editSql = "SELECT * FROM cc_event WHERE Event_ID = '$Event_ID'";
    $editResult = mysqli_query($conn, $editSql);

    if ($editResult && mysqli_num_rows($editResult) > 0) {
        $editRow = mysqli_fetch_array($editResult);
    ?>
    <script>
            document.addEventListener('DOMContentLoaded', function () {
            document.getElementsByName('Event_ID')[0].value = '<?php echo $editRow["Event_ID"]; ?>';
            document.getElementsByName('UIN')[0].value = '<?php echo $editRow["UIN"]; ?>';
            document.getElementsByName('Program_num')[0].value = '<?php echo $editRow["Program_num"]; ?>';
            document.getElementsByName('Start_date')[0].value = '<?php echo $editRow["Start_date"]; ?>';
            document.getElementsByName('Event_time')[0].value = '<?php echo $editRow["Event_time"]; ?>';
            document.getElementsByName('Location')[0].value = '<?php echo $editRow["Location"]; ?>';
            document.getElementsByName('End_date')[0].value = '<?php echo $editRow["End_date"]; ?>';
            document.getElementsByName('Event_type')[0].value = '<?php echo $editRow["Event_Type"]; ?>';
    </script> -->
    <?php
    }

    $Event_ID = $_POST['Event_ID'];
    $UIN = $_POST['UIN'];
    $Program_num = $_POST['Program_num'];
    $Start_date= $_POST['Start_date'];
    $Event_time = $_POST['Event_time'];
    $Location = $_POST['Location'];
    $End_date= $_POST['End_date'];
    $Event_type= $_POST['Event_type'];
    
    $checkDuplicateSql = "SELECT * FROM cc_event WHERE Event_ID = '$Event_ID'";
    $duplicateResult = mysqli_query($conn, $checkDuplicateSql);

    if (mysqli_num_rows($duplicateResult) > 0) {
        echo "Updating Event ID  $Event_ID ". "<br>";
        $updateSql = "UPDATE cc_event SET  Start_date = '$Start_date', Event_time = '$Event_time', Location = '$Location', End_date = '$End_date', Event_type = '$Event_type' WHERE Event_ID = '$Event_ID";
        if (mysqli_query($conn, $updateSql)) {
            echo "Event information updated successfully";
        } else {
            echo "Error updating event information: " . mysqli_error($conn);
        }
    }
}
?>



<?php
if (isset($_GET["delete"])) {
    $deleteEventID = $_GET['delete'];
    $deleteSql2 = "DELETE FROM event_tracking WHERE Event_ID = '$deleteEventID'";
    if (mysqli_query($conn, $deleteSql2)) {
        echo "Event deleted successfully";
    } else {
        echo "Error deleting program: " . mysqli_error($conn);
    }
    $deleteSql = "DELETE FROM cc_event WHERE Event_ID = '$deleteEventID'";
    if (mysqli_query($conn, $deleteSql)) {
        echo "Event deleted successfully";
    } else {
        echo "Error deleting program: " . mysqli_error($conn);
    }
}
?>

</body>
</html>
