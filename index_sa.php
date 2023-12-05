<?php 
    //session_start();
    //$_SESSION["username"] = "Krossing";
    //session_destroy();
    //session_unset(); //detletes all session data
    include_once 'includes/db.php';
    //include_once 'update_event.php';

    $sql = "SELECT * FROM cc_event_view";
    $result = mysqli_query($conn, $sql);
    //$result = $conn->query($sql);
    $resultCheck = mysqli_num_rows($result);
    //echo $_SESSION["username"];
    if ($result === false) {
        die("Error executing the query: " . $conn->error);
    }
    $rows = $result->fetch_all(MYSQLI_ASSOC);     
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css"> 
        <li><a href="cc_event.php">Events Table</a></li>
        <li><a href="eventtrack.php">Event Tracking Table</a></li>
        <li><a href="document.php">Document Table</a></li>


<!--           
        <title>Events</title>
    </head>
    <body> 

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
                    <td><form method='post' action='update_event.php'>
                    <input type='hidden' name='Event_ID' value='" . $row['Event_ID'] . "'>
                    <input type='hidden' name='action' value='update'>
                    <input type='submit' name='action' value='Update'>
                    </form></td> 
                    <td><form method='post' action='delete_event.php'>
                    <input type='hidden' name='Event_ID' value='" . $row['Event_ID'] . "'>
                    <input type='hidden' name='action' value='delete'>
                    <input type='submit' name='action' value='Delete'>
                    </form></td>
                </tr> 
            <?php endforeach; ?>
        </table>
        <button onclick="location.href='add_event.php'">Add Event</button> 

        <?php
            //$conn->close();
        ?>
         <h3>Add Event</h3>

<form action="dbh.inc.php" method="post">
    <label for="Event_ID">Event ID:</label>
    <input type="int" id="Event_ID" name="Event_ID" required>

    <label for="UIN">UIN:</label>
    <input type="int" id="UIN" name="UIN" required>

    <label for="Program_num">Program Number:</label>
    <input type="int" id="Program_num" name="Program_num" required>

    <label for="Start_date">Start Date(yyyy-mm-dd): </label>
    <input type="date" id="Start_date" name="Start_date" required>

    <label for="Event_time">Event Time(hh:mm:ss):</label>
    <input type="time" id="Event_time" name="Event_time" required>

    
    <label for="Location">Location:</label>
    <input type="varchar" id="Location" name="Location" required>

     -->
    <!-- <label for="End_date">End date(yyyy-mm-dd):</label>
    <input type="date" id="End_date" name="End_date" required>

    
    <label for="Event_type">Event Type:</label>
    <input type="varchar" id="Event_type" name="Event_type" required>

    <input type="submit" value="Add Event">
</form>  -->

<!-- 
<h4>Update Event</h4>

<form action="dbh.inc.php" method="post">
    <label for="Event_ID">Event ID:</label>
    <input type="int" id="Event_ID" name="Event_ID" required>

    <label for="UIN">UIN:</label>
    <input type="int" id="UIN" name="UIN" required>

    <label for="Program_num">Program Number:</label>
    <input type="int" id="Program_num" name="Program_num" required>

    <label for="Start_date">Start Date(yyyy-mm-dd): </label>
    <input type="date" id="Start_date" name="Start_date" required>

    <label for="Event_time">Event Time(hh:mm:ss):</label>
    <input type="time" id="Event_time" name="Event_time" required>

    
    <label for="Location">Location:</label>
    <input type="varchar" id="Location" name="Location" required>

    
    <label for="End_date">End date(yyyy-mm-dd):</label>
    <input type="date" id="End_date" name="End_date" required> -->

<!--     
    <label for="Event_type">Event Type:</label>
    <input type="varchar" id="Event_type" name="Event_type" required>

    <input type="submit" value="Update Event">
</form>  --> 

</body>
</html> 


<?php
// Close the database connection
// $conn->close();
?>


 
