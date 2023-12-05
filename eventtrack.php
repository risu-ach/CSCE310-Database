<?php 
include_once 'includes/dbh.inc.php';
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css"> 
        <title>Track Events</title>
    </head>
    <body>
    <form action="index.php">
        <button type="submit"><b>Home</b></button>
    </form>     
    <h2>Events Tracking Table</h2>

    <table>
    <tr>
        <th>ET Num</th>
        <th>UIN</th>
        <th>Event_ID</th>
    </tr>

    <?php 
     $sql = "SELECT * FROM event_tracking";
     $result = mysqli_query($conn, $sql);
     $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0){
    while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["ET_Num"] . "</td>";
            echo "<td>" . $row["UIN"] . "</td>";
            echo "<td>" . $row["Event_ID"] . "</td>";
            echo "</tr>";
    }
}
else {
    echo "<tr><td colspan='4'>No events found</td></tr>";
  }
 ?> 
</table>

<!-- <h3>Add an event tracking</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="ET_Num">ET Num:</label>
    <input type="int" name="ET_Num" required>

    <!-- Get UIN from college_student -->
    <label for="UIN">UIN:</label>
    <select name="UIN" required>
        <?php
        $selectUINSql = "SELECT UIN FROM cc_event;";
        $selectUINResult = mysqli_query($conn, $selectUINSql);

        while ($rowUIN = mysqli_fetch_array($selectUINResult)) {
            echo "<option value='" . $rowUIN["UIN"] . "'>" . $rowUIN["UIN"] . "</option>";
        }
        ?>
    </select>
    <label for="Event_ID">Event_ID:</label>
    <select name="Event_ID" required>
        <?php
        $selectEventIDSql = "SELECT Event_ID FROM cc_event;";
        $selectEventIDResult = mysqli_query($conn, $selectEventIDSql);

        while ($rowUIN = mysqli_fetch_array($selectEventIDResult)) {
            echo "<option value='" . $rowUIN["Event_ID"] . "'>" . $rowUIN["Event_ID"] . "</option>";
        }
        ?>
    </select>

    <button type="submit" name="add">Add Event Tracking</button>
    </form> -->

    
<!-- <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $ET_Num = $_POST['ET_Num'];
    $Event_ID = $_POST['Event_ID'];
    $UIN = $_POST['UIN'];
"INSERT INTO event_tracking (ET_Num, UIN, Program_num) VALUES ('$ET_Num', '$UIN', '$Program_num')";
        header("Location: ".$_SERVER['PHP_SELF']);
        if ($conn->query($sql) === TRUE) {
            echo "Data added successfully";
        } else {
            echo "Error adding data: " . $conn->error;
    }
}
?> -->


<!-- 
<?php
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];

    $deleteSql = "DELETE FROM event_tracking WHERE Event_ID = '$delete'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Event tracking deleted successfully";
    } else {
        echo "Error deleting event tracking: " . mysqli_error($conn);
    }
}
?>