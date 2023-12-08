<!-- Sarah Abusada:Functionality set 4 -->
<?php 
include_once 'db.php';
include_once 'admin_app_nav.php'; 
?>
<?php
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
        <title>Track Events</title>
    </head>
    <body>
    <h2>Events Tracking Table</h2>

<!--- Creating the event tracking table!-->
<!--- Event tracking table uses trigger from database to automatically get inserted, updated and 
deleted when the corresponding function is carried out on the cc_event table.-->
<table>
    <tr>
        <th>ET Num</th>
        <th>UIN</th>
        <th>Event_ID</th>
    </tr>

    <?php 
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

<!-- Search by UIN through event tracking database to keep track of student attendance-->
<!--form to get student UIN-->
<h3>Search by UIN</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="UIN">UIN:</label>
    <input type="int" id="UIN" name="UIN" required>
    <button type="submit" name="searchUIN">Search</button>
</form> 

<!--Output rows from event tracking table that correspond to that UIN-->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchUIN"])) {
    $getUIN = $_POST['UIN'];
    $searchSql= "SELECT * FROM event_tracking WHERE UIN = '$getUIN'";
    $result = $conn->query($searchSql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck == 0){
        echo "This student is not attending any events";
    }
    else {
        $rows = $result->fetch_all(MYSQLI_ASSOC); 
    ?>
        <table>
        <tr>
            <th>ET Number</th>
            <th>UIN</th>
            <th>Event_ID</th>
        </tr>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['ET_Num']; ?></td>
                <td><?php echo $row['UIN']; ?></td>
                <td><?php echo $row['Event_ID']; ?></td>
            </tr> 
        <?php endforeach; ?>
    <?php
    }
}
?>
</table>
</body>
</html>

