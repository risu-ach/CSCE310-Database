<!-- Sarah Abusada:Functionality set 4 -->
<?php 
    include_once 'db.php';
    include_once 'admin_app_nav.php'; 
session_start();
// Check if the user is logged in
if (!isset($_SESSION["userUIN"])) {
    // If not, redirect to the login page
    header("Location: ../loginpage.php");
    exit();
}
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Events</title>
    </head>
        <body>
        <h2>Events Table</h2>

<!--- Create Form to add an event-->
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
    <label for="Start_date">Start Date: </label>
    <input type="date" id="Start_date" name="Start_date" required>
    <label for="Event_time">Event Time:</label>
    <input type="time" id="Event_time" name="Event_time" required>
    <label for="Location">Location:</label>
    <input type="varchar" id="Location" name="Location" required>
    <label for="End_date">End date:</label>
    <input type="date" id="End_date" name="End_date" required>
    <label for="Event_type">Event Type:</label>
    <input type="varchar" id="Event_type" name="Event_type" required>
    <button type="submit" name="add">Add Event</button>
</form> 

<!--- Adding an Event!-->
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
    $checkUINQuery = "SELECT UIN FROM college_student WHERE UIN = '$UIN'";
    $result = $conn->query($checkUINQuery);
    $sql = "INSERT INTO cc_event (Event_ID, UIN, Program_num, Start_date, Event_time, Location, End_date, Event_type) VALUES ('$Event_ID', '$UIN', '$Program_num', '$Start_date', '$Event_time', '$Location', '$End_date', '$Event_type')";
    $conn->query($sql);
    }
?>

<!--- Deleting an event-->
<?php
if (isset($_GET["delete"])) {
    $deleteEventID = $_GET['delete'];
    $deleteSql2 = "DELETE FROM event_tracking WHERE Event_ID = '$deleteEventID'"; 
    //deletes from event_tracking if deletion occurs in cc_event tabe
    if (mysqli_query($conn, $deleteSql2)) {
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

<!--- Creating the events table-->
<h3>Events Table</h3>
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
    <?php
    $sql = "SELECT * FROM cc_event";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $rows = $result->fetch_all(MYSQLI_ASSOC);     
    ?> 
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
            <?php
            echo "<td><a href='update_event.php?Event_ID={$row['Event_ID']}'>Update</a> </td>"; //update/edit a specific event
            echo "<td><a href='?delete=" . $row["Event_ID"] . "'>Delete</a></td>"; //delete an  event
            ?>
        </tr> 
    <?php endforeach; ?>
</table>

<!--- Using index created in database to search through cc_event table to find events based on program number!-->
<!--form to get user input of program number-->
<h3>Search by Program Number</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="Program_num">Program Number:</label>
    <input type="int" id="Program_num" name="Program_num" required>
    <button type="submit" name="searchProgramNum">Search</button>
</form> 

<!--Output rows from event table that correspond to that program number-->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchProgramNum"])) {
    $getProgramNum = $_POST['Program_num'];
    $searchSql= "SELECT * FROM cc_event WHERE Program_num = '$getProgramNum'";
    $result = $conn->query($searchSql);
    $resultCheck = mysqli_num_rows($result); 
    if($resultCheck == 0){
        echo "This Program does not have any events";
    }
    else {
        $rows = $result->fetch_all(MYSQLI_ASSOC); 
        ?>
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
            </tr> 
        <?php endforeach; ?>
<?php
    }
}
?>
</table>
</body>
</html> 
