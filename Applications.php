<!-- Made By Rishika Acharya -->
<?php include_once 'includes/db.php'; ?>
<?php include_once 'admin_app_nav.php'; ?> <!-- Include the navigation bar -->

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
    <a class="dashboard-button" href="includes/intern.php">Internships</a>
    <a class="dashboard-button" href="includes/intern_app.php">Intern Application</a>
    <a class="dashboard-button" href="includes/classes.php">Classes</a>
    <a class="dashboard-button" href="includes/class_enrollment.php">Class Application</a>
    <a class="dashboard-button" href="includes/certificate.php">Certificate</a>
    <a class="dashboard-button" href="cert_enrollment.php">Certificate Application</a>
</div>



</body>
</html>
