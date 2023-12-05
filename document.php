<!-- Sarah Abusada:Functionality set 4 -->

<?php 
include_once 'includes/db.php';
// if (!isset($_SESSION["userUIN"])) {
//     // If not, redirect to the login page
//     header("Location: login.php");
//     header("Location: ../loginpage.php");
//     exit();
// }
// $userUIN = $_SESSION["userUIN"];
// $userName = $_SESSION["userName"];
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
    <nav>
            <a href="index_sa.php">Dashboard</a>
            <a href="cc_event.php">Events</a>
            <a href="eventtrack.php">Event Tracking</a>
            <a href="document.php">Documents</a>
        </nav>
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
        </style>      
    <h2>Document Table</h2>


    <table>
    <tr>
        <th>Document Number</th>
        <th>Application Number</th>
        <th>Link</th>
        <th>Document Type</th>
    </tr>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input type="int" name="UIN" placeholder="Student UIN">
		<br>
		<button type="submit" name="search">Submit</button>
	</form>




<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"]))  {
    $UIN = $_POST['UIN'];
    $sql = "SELECT * FROM application_document_view where UIN = $UIN;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0){
    while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["Doc_num"] . "</td>";
            echo "<td>" . $row["App_num"] . "</td>";
            echo "<td>" . $row["Link"] . "</td>";
            echo "<td>" . $row["Doc_type"] . "</td>";
            echo "<td><a href='update_document.php?Doc_num={$row['Doc_num']}'>Update</a> </td>";
            echo "<td><a href='?delete=" . $row["Doc_num"] . "'>Delete</a></td>";
            echo "</tr>";
    }
    
}
else {
    echo "<tr><td colspan='4'>No documents found</td></tr>";
  }
}
 ?> 
</table>

<h3>Add a Document</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="Doc_num">Doc_num:</label>
    <input type="int" name="Doc_num" required>
    <label for="App_num">Application Number:</label>
    <select name="App_num" required>
        <?php
        $selectApplicationSql = "SELECT App_num FROM application;";
        $selectApplicationResult = mysqli_query($conn, $selectApplicationSql);
        while ($rowApp = mysqli_fetch_array($selectApplicationResult)) {
            echo "<option value='" . $rowApp["App_num"] . "'>" . $rowApp["App_num"] . "</option>";
        }
        ?>
    </select>
    <label for="Link">Link:</label>
    <input type="varchar" name="Link" required>
    <label for="Doc_type">Document Type:</label>
    <input type="varchar" name="Doc_type" required>
    <button type="submit" name="add">Add</button>
    </form>
</form> 



<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"]))  {
    $Doc_num = $_POST['Doc_num'];
    $App_num = $_POST['App_num'];
    $Link = $_POST['Link'];
    $Doc_type= $_POST['Doc_type'];
    $sql = "INSERT INTO document (Doc_num, App_num, Link, Doc_type) VALUES ('$Doc_num', '$App_num', '$Link','$Doc_type')";
    header("Location: ".$_SERVER['PHP_SELF']);
        if ($conn->query($sql) === TRUE) {
            echo "Data added successfully";
        } else {
            echo "Error adding data: " . $conn->error;
    }
}
?>

<?php
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];

    $deleteSql = "DELETE FROM document WHERE Doc_num = '$delete'";

    if (mysqli_query($conn, $deleteSql)) {
        echo "Document deleted successfully";
    } else {
        echo "Error deleting document: " . mysqli_error($conn);
    }
}
?>
