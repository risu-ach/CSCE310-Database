<!-- Made By Rishika Acharya -->
<?php include_once 'includes/db.php'; ?>
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
            margin-top: 60px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .buttonGrid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: auto;
            grid-gap: 20px;
            margin: auto;
        }

        .dashboard-button {
            border: none;
            padding: 15px;
            cursor: pointer;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            font-size: 18px;
            transition: background-color 0.3s, transform 0.2s;
            border-radius: 8px;
            overflow: hidden;
            background-color: #4CAF50; /* Green */
        }

        .dashboard-button:hover {
            background-color: #3498db; /* Blue on hover */
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<h1>Dashboard</h1>

<div class="buttonGrid">
    <a class="dashboard-button" href="includes/student_applications.php">Program</a>
    <a class="dashboard-button" href="includes/student_intern.php">InternShip</a>
    <a class="dashboard-button" href="includes/student_certificate.php">Certificate</a>
    <a class="dashboard-button" href="includes/student_classes.php">Classes</a>
    <a class="dashboard-button" href="includes/document.php">Documents</a>
    <a class="dashboard-button" href="student_page.php">Account Info</a>
    <a class="dashboard-button" href="logout.php">Logout</a>
</div>



</body>
</html>
