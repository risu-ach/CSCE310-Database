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

<!--- Function to update/edit a document!-->
<!--- Uses a view combing application and document table
to make sure a user exists with corresponding application before update/edit a document!-->
<?php
if (isset($_POST["update"])) {
    $Doc_num = $_POST['Doc_num'];
    $App_num = $_POST['App_num'];
    $Link = $_POST['Link'];
    $Doc_type= $_POST['Doc_type'];
    $updateSql = "UPDATE document SET Link = '$Link', Doc_type = '$Doc_type' WHERE Doc_num = '$Doc_num' ";
    header("Location: document.php");
    if (mysqli_query($connection, $updateSql)) {
        echo "Document information updated successfully";
    } else {
        echo "Error updating document information: " . mysqli_error($connection);
    }
}

//Getting the ID of the document that was selected to be updated
$id_to_update = isset($_GET['Doc_num']) ? $_GET['Doc_num'] : die('Missing ID parameter');
$select_query = "SELECT * FROM document WHERE Doc_num = $id_to_update";
$result = mysqli_query($connection, $select_query);
$row = mysqli_fetch_assoc($result);
?>

<!--- Form to update/edit a document!-->
<form action="document.php">
        <button type="submit"><b>Back</b></button>
    </form> 
<form method='post' action="">
    <input type='hidden' name='Doc_num' value="<?php echo $row['Doc_num']; ?>">
    <input type='hidden' name='App_num' value="<?php echo $row['App_num']; ?>">
    Link: <input type='varchar' name='Link' value="<?php echo $row['Link']; ?>"><br>
    Document Type: <input type='varchar' name='Doc_type' value="<?php echo $row['Doc_type']; ?>"><br>
    <input type='submit' name='update' value='Update'>
</form>
</body>
</html>