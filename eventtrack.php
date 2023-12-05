<!-- Sarah Abusada:Functionality set 4 -->
<?php 
include_once 'includes/db.php';
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

<!--- Creating the event tracking table!-->
<!--- Event tracking table uses trigger from database to automatically get inserted, updated and 
deleted when the corresponding function is carried out on the cc_event table-->
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

</body>
</html>

