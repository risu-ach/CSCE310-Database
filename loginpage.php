<script>
    //Maya Lotfy 
    //UIN: 730001793

function displayMessage(message) {
    alert(message);
}

</script>

<?php

include_once 'includes/db.php';


session_start();

// Function to authenticate the user
function authenticateUser($username, $password)
{
    global $conn;
    // prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if ($password === $row['Passwords']){
            $_SESSION['userUIN'] = $row['UIN'];
            $_SESSION['userName'] = $row['First_name'];
            // Password is correct, redirect to the appropriate page based on user_type
            if ($row['User_type'] == 'admin' || $row['User_type'] == 'Admin') {
                header("Location: Admin_App.php");
            } elseif ($row['User_type'] == 'student' || $row['User_type'] == 'Student') {
                header("Location: Student_App.php");
            } elseif($row['User_type'] == 'No Access Student' || $row['User_type'] == 'No Access Admin') {
                echo '<script>displayMessage("Access Denied");</script>';
            }
            else{
                echo '<script>displayMessage("Invalid User");</script>';
            }
        } else {
            echo '<script>displayMessage("Incorrect Password");</script>';
        }
    } else {
        echo '<script>displayMessage("No username found, try again");</script>';
    }
}

// Check if the form is submitted for login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call the function to authenticate the user
    authenticateUser($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        form {
            max-width: 300px;
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <h2>Login Page</h2>

    <!-- Form for login -->
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>

    

</body>

</html>
