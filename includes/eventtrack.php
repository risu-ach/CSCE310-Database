<!-- Sarah Abusada:Functionality set 4 -->
<?php 
include_once 'db.php';
include_once 'admin_app_nav.php'; 
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
    <nav>
            <a href="index_sa.php">Dashboard</a>
            <a href="cc_event.php">Events</a>
            <a href="eventtrack.php">Event Tracking</a>
            <a href="document.php">Documents</a>
        <!-- </nav>
        <style>           
        nav {
            display: flex;
            justify-content: center;
            background-color: grey ;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 0 10px;
        } 
        </style>       -->
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
    //$uin = $_POST["UIN"];
    $sql = "SELECT * FROM event_tracking;";
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

<!-- <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    
     <input type="int" name="UIN" placeholder="Student UIN">
     <br>
     <button type="submit" name="search">Submit</button>
</form> -->


</body>
</html>

