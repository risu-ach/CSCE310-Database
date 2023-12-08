<!-- Sarah Abusada:Functionality set 4 -->
<?php 
include_once 'db.php';
$connection = mysqli_connect("localhost", "root", "", "CSCE_310");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css"> 
        <title>Documentation</title>
    </head>
    <body>

<!--- Function to update/edit an event!-->
<?php
    if (isset($_POST["update"])) {
        $Event_ID = $_POST['Event_ID'];
        $UIN = $_POST['UIN'];
        $Program_num = $_POST['Program_num'];
        $Start_date= $_POST['Start_date'];
        $Event_time = $_POST['Event_time'];
        $Location = $_POST['Location'];
        $End_date= $_POST['End_date'];
        $Event_type= $_POST['Event_type'];
        $updateSql = "UPDATE cc_event SET  Start_date = '$Start_date', Event_time = '$Event_time', Location = '$Location', End_date = '$End_date', Event_type = '$Event_type' WHERE Event_ID = '$Event_ID'";
        header("Location: cc_event.php");
        if (mysqli_query($connection, $updateSql)) {
            echo "Event information updated successfully";
        } else {
            echo "Error updating document information: " . mysqli_error($connection);
        }
}

//Getting the ID of the event that was selected to be updated/edited
$id_to_update = isset($_GET['Event_ID']) ? $_GET['Event_ID'] : die('Missing ID parameter');
$select_query = "SELECT * FROM cc_event WHERE Event_ID = $id_to_update";
$result = mysqli_query($connection, $select_query);
$row = mysqli_fetch_assoc($result);
?>

<!--- form to fill out information to edit/update an event!-->
<form action="cc_event.php">
        <button type="submit"><b>Back</b></button>
    </form> 
<form method='post' action="">
    <input type='hidden' name='Event_ID' value="<?php echo $row['Event_ID']; ?>">
    <input type='hidden' name='UIN' value="<?php echo $row['UIN']; ?>">
    <input type='hidden' name='Program_num' value="<?php echo $row['Program_num']; ?>">
    Start Date: <input type='date' name='Start_date' value="<?php echo $row['Start_date']; ?>"><br>
    Event Time: <input type='time' name='Event_time' value="<?php echo $row['Event_time']; ?>"><br>
    Location: <input type='varchar' name='Location' value="<?php echo $row['Location']; ?>"><br>
    End_date: <input type='date' name='End_date' value="<?php echo $row['End_date']; ?>"><br>
    Event Type: <input type='varchar' name='Event_type' value="<?php echo $row['Event_type']; ?>"><br>
    <input type='submit' name='update' value='Update'>
</form>
</body>
</html>