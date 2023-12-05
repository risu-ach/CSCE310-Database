<?php 
    //session_start();
    //$_SESSION["username"] = "Krossing";
    //session_destroy();
    //session_unset(); //detletes all session data
    // include_once 'includes/db.php';
    // //include_once 'update_event.php';

    // $sql = "SELECT * FROM cc_event_view";
    // $result = mysqli_query($conn, $sql);
    // //$result = $conn->query($sql);
    // $resultCheck = mysqli_num_rows($result);
    // //echo $_SESSION["username"];
    // if ($result === false) {
    //     die("Error executing the query: " . $conn->error);
    // }
    // $rows = $result->fetch_all(MYSQLI_ASSOC);     
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css"> 
        <style>
            body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

form {
    max-width: 400px;
    margin: auto;
}
label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
}

input[type="submit"] {
    padding: 10px;
    background-color: green;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border: 1px solid #f2f2f2;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}


button {
    background-color: green;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: green;
}

.mainButtons{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-auto-rows: auto;
    grid-gap: 20px;
    margin: auto;
}

.mainPageButton {
    border: none;
    padding: 15px;
    cursor: pointer;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: white;
    font-size: 35px;
    transition: background-color 0.3s, transform 0.2s;
    border-radius: 8px;
    overflow: hidden;
    background-color: lightsteelblue; /* Green */
}

.dashboard-button:hover {
    background-color: #3498db; /* Blue on hover */
    transform: scale(1.05);
}
</style>
    <body>
        <h1>Dashboard</h1>
        <div class ="mainButtons">
            <a class="mainPageButton" href="cc_event.php">Events</a>
            <a class="mainPageButton" href="eventtrack.php">Event Tracking</a>
            <a class="mainPageButton" href="document.php">Documents</a>
            <a class="mainPageButton" href="logout.php">Logout</a>

    </div>  
</body>
</html>

