<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["userUIN"])) {
    // If not, redirect to the login page
    header("Location: login.php");
    exit();
}
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs310";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userUIN = $_SESSION["userUIN"];
$userName = $_SESSION["userName"];

// Function to fetch and display user information
function displayUserProfile($userUIN, $conn)
{
    $sql = "SELECT * FROM user_college_student_view WHERE UIN = '$userUIN'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $Data = $result->fetch_assoc();

        echo '<table border="1">';
        echo '<tr><th>Field</th><th>Value</th></tr>';
        echo '<tr><td>UIN</td><td>' . $Data["UIN"] . '</td></tr>';
        echo '<tr><td>First Name</td><td>' . $Data["First_name"] . '</td></tr>';
        echo '<tr><td>Middle Initial</td><td>' . $Data["M_initial"] . '</td></tr>';
        echo '<tr><td>Last Name</td><td>' . $Data["Last_name"] . '</td></tr>';
        echo '<tr><td>Username</td><td>' . $Data["Username"] . '</td></tr>';
        echo '<tr><td>Email</td><td>' . $Data["Email"] . '</td></tr>';
        echo '<tr><td>Discord Name</td><td>' . $Data["Discord_name"] . '</td></tr>';
        echo '<h2>Student Information</h2>';
        echo '<tr><td>Gender</td><td>' . $Data["Gender"] . '</td></tr>';
        echo '<tr><td>Hispanic/Latino</td><td>' . $Data["Hispanic_latino"] . '</td></tr>';
        echo '<tr><td>Race</td><td>' . $Data["Race"] . '</td></tr>';
        echo '<tr><td>US Citizen</td><td>' . $Data["US_citizen"] . '</td></tr>';
        echo '<tr><td>First Generation</td><td>' . $Data["First_generation"] . '</td></tr>';
        echo '<tr><td>DOB</td><td>' . $Data["DoB"] . '</td></tr>';
        echo '<tr><td>GPA</td><td>' . $Data["GPA"] . '</td></tr>';
        echo '<tr><td>Major</td><td>' . $Data["Major"] . '</td></tr>';
        echo '<tr><td>Minor1</td><td>' . $Data["Minor1"] . '</td></tr>';
        echo '<tr><td>Minor2</td><td>' . $Data["Minor2"] . '</td></tr>';
        echo '<tr><td>Expected Graduation</td><td>' . $Data["Expected_graduation"] . '</td></tr>';
        echo '<tr><td>School</td><td>' . $Data["School"] . '</td></tr>';
        echo '<tr><td>Classification</td><td>' . $Data["Classification"] . '</td></tr>';
        echo '<tr><td>Phone</td><td>' . $Data["Phone"] . '</td></tr>';
        echo '<tr><td>Student Type</td><td>' . $Data["Student_type"] . '</td></tr>';
        echo '</table>';

    }      
        
    else {
        echo '<p>User information not found.</p>';
    }
}

// Function to remove access in the database
function removeAccess($userUIN, $conn)
{

    $sql = "UPDATE users SET User_type='No Access Student' WHERE UIN=$userUIN";
    if ($conn->query($sql) === TRUE) {
        // Add any additional actions after successful update
        header("Location: logout.php");
        exit();
    } else {
        echo "Error: " . $sql . "\n" . $conn->error;
    }
}

// Function to update user credentials
function updateCredentials($userUIN, $newUsername, $newPassword, $conn)
{
    $sql = "UPDATE users SET Username='$newUsername', Passwords='$newPassword' WHERE UIN=$userUIN";
    if ($conn->query($sql) === TRUE) {
        // Add any additional actions after successful update
        echo '<script>displayMessage("Credentials updated Successfully.");</script>';

    } else {
        echo "Error: " . $sql . "\n" . $conn->error;
    }
}

// Function to update user profile
function updateProfileFields($userUIN, $formData, $conn)
{

    // Get the columns in the 'users' and 'college_student' tables
    $usersColumns = getColumnNames($conn, 'users');
    $collegeStudentColumns = getColumnNames($conn, 'college_student');


    // Process the form data and update the profile fields
    foreach ($formData as $field => $value) {
        // Ensure the field is not 'updateProfile' or any other unwanted field
        if ($field !== 'updateProfile' && $field !== 'newPassword' && $field !== 'confirmPassword') {
            $field = substr($field, 3); // Remove the 'new' prefix
            // Use prepared statements to prevent SQL injection
           // Check if the field exists in the 'users' table
           if (in_array($field, $usersColumns)) {
            // Use prepared statements to prevent SQL injection
                $stmt = $conn->prepare("UPDATE users SET $field = ? WHERE UIN = ?");
                $stmt->bind_param('si', $value, $userUIN);

                if ($stmt->execute() !== TRUE) {
                    echo "Error updating $field in users table: " . $stmt->error;
                }

                $stmt->close();
            }
        
        }
    }

    foreach ($formData as $field => $value) {
        // Ensure the field is not 'updateProfile' or any other unwanted field
        if ($field !== 'updateProfile' && $field !== 'newPassword' && $field !== 'confirmPassword') {
            $field = substr($field, 3); // Remove the 'new' prefix

            // Check if the field exists in the 'college_student' table
            if (in_array($field, $collegeStudentColumns)) {
                // Use prepared statements to prevent SQL injection
                $stmt = $conn->prepare("UPDATE college_student SET $field = ? WHERE UIN = ?");
                $stmt->bind_param('si', $value, $userUIN);

                if ($stmt->execute() !== TRUE) {
                    echo '<script>displayMessage("Error updating.");</script>';

                }

            

                $stmt->close();
            }
        }
    }

    // Add any additional actions after successful update
    echo '<script>displayMessage("Profile Updated Successfully.");</script>';

}

// Function to get column names of a table
function getColumnNames($conn, $tableName) {
    $columns = array();

    $result = $conn->query("SHOW COLUMNS FROM $tableName");

    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    return $columns;
}

?>

<script>


    function displayMessage(message) {
        alert(message);
    }

</script>











<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
            
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #004953;
            color: #fff;
        }

        form {
            margin-bottom: 20px;
            display: none;
        }

        fieldset {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        legend {
            font-weight: bold;
            color: #264348;
        }

        button {
            margin-bottom: 10px;
            background-color:#004953 ;
            color: #fff;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #004040;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        #studentFields {
            margin-top: 20px;
        }

        #updateForm input[type="submit"],
        #updateForm input[type="button"] {
            margin-top: 20px;
        }

        #updateForm label {
            margin-top: 10px;
        }
        #credentialsForm input[type="submit"],
        #credentialsForminput[type="button"] {
            margin-top: 20px;
        }

        #credentialsForm label {
            margin-top: 10px;
        }

        #profile {
            padding-bottom: 20px; 
        }

    </style>
</head>


<body>

    <h1>User Profile</h1>
    <p>Welcome, <?php echo $userName; ?>, <?php echo $userUIN; ?>!</p>


    <!-- Button to toggle view/hide administrators -->
    <button onclick="toggleProfile()">View Profile</button>
    <button onclick="toggleUpdateForm()" id="updateButton" style="display:none;">Update Personal Information</button>
    <button onclick="toggleCredentialsForm()">Change login credentials</button>
    <button onclick="confirmDeactivate()">Deactivate account</button>
    <button onclick="logout()">logout</button>



     <!-- Display user profile information -->
    <div id="profile" style="display:none;">
        <?php displayUserProfile($userUIN, $conn); ?>
    </div>


    <form id="updateForm" style="display:none;">
        <fieldset>
            <legend>Update Personal Information</legend>
            
            <?php
            // Fetch user profile fields dynamically
            $userDataSql = "SELECT * FROM users WHERE UIN = '$userUIN'";
            $userDataResult = $conn->query($userDataSql);
            $nonEditableFields = ['UIN', 'Passwords'];


            if ($userDataResult->num_rows > 0) {
                $userData = $userDataResult->fetch_assoc();

                // Generate form fields for each user profile field
                foreach ($userData as $field => $value) {
                    $editable = true;


                    // Check if the current field is in the nonEditableFields array
                    if (in_array($field, $nonEditableFields)) {
                        $editable = false;
                    }


                    if ( $field != 'User_type' && $editable ) { // Exclude certain fields, adjust as needed
                        echo '<label for="new' . $field . '">' . ucfirst($field) . ':</label>';
                        echo '<input type="text" id="new' . $field . '" name="new' . $field . '" value="' . $value . '"><br>';
                    }
                    elseif ($field != 'Passwords' && $field != 'User_type'){

                        // Display the value as text if the field is not editable
                        echo '<label>' . ucfirst($field) . ':</label>';
                        echo '<span>' . $value . '</span><br>';
                    }
                    else{
                        continue;
                    }
                }
            }

            $studentDataSql = "SELECT * FROM college_student WHERE UIN = '$userUIN'";
            $studentDataResult = $conn->query($studentDataSql);

            if ($studentDataResult->num_rows > 0) {
                $studentData = $studentDataResult->fetch_assoc();

                // Generate form fields for each user profile field
                foreach ($studentData as $field => $value) {
                    $editable = true;
                     // Check if the current field is in the nonEditableFields array
                    if (in_array($field, $nonEditableFields)) {
                        $editable = false;
                    }
                    if ($field != 'UIN' && $field != 'Student_type' && $editable) { // Exclude certain fields, adjust as needed
                        echo '<label for="new' . $field . '">' . ucfirst($field) . ':</label>';
                        echo '<input type="text" id="new' . $field . '" name="new' . $field . '" value="' . $value . '"><br>';
                    }
                    elseif ($field != 'UIN' && $field != 'Student_type'){
                        // Display the value as text if the field is not editable
                        echo '<label>' . ucfirst($field) . ':</label>';
                        echo '<span>' . $value . '</span><br>';

                    }
                    else{
                        continue;
                    }
                }
            }
            ?>

            <button type="button" onclick="updateProfileFields()">Update</button>
        </fieldset>
    </form>


    

    
    <!-- Form to change login credentials -->
    <form id="credentialsForm" style="display:none;">
        <fieldset>
            <legend>Change Login Credentials</legend>
            <label for="newUsername">New Username:</label>
            <input type="text" id="newUsername" name="newUsername" required><br>
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required><br>
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required><br>
            <button type="button" onclick="submitCredentialsForm()">Update Credentials</button>
        </fieldset>
    </form>


   

    <!-- Button for Full Delete -->
    

    

    
    <script>
        
    

        var updateClicked = false;

        function toggleProfile() {
            var profile = document.getElementById("profile");
            profile.style.display = (profile.style.display === "none") ? "block" : "none";

            if (updateClicked) {
                // If "Update Personal Information" was clicked, show the form
                toggleUpdateForm();
                updateClicked = false; // Reset the flag
            } else {
                var updateButton = document.getElementById("updateButton");
                updateButton.style.display = "block"; // Show the "Update Personal Information" button
            }

            if(profile.style.display === "none"){
                var updateButton = document.getElementById("updateButton");
                updateButton.style.display = "none"; 

            }
        }

        function toggleUpdateForm() {
            var updateForm = document.getElementById("updateForm");
            updateForm.style.display = (updateForm.style.display === "none") ? "block" : "none";

            updateClicked = true;
        }

        




        function updateProfileFields() {
            var formData = new FormData(document.getElementById("updateForm"));

            // Convert form data to URL-encoded string
            var urlSearchParams = new URLSearchParams(formData);
            var encodedFormData = urlSearchParams.toString();

            // Redirect to the page with a parameter indicating profile update
            window.location.href = "student_page.php?updateProfile=true&" + encodedFormData;
        }


        

        function confirmDeactivate() {
            var confirmation = confirm("Are you sure you want to deactivate your account?");
            if (confirmation) {
                // If user clicks "Yes", submit the form and call removeAccess()
                window.location.href = "logout.php?deactivate=true";
            } else {
                
            }

        }
        function toggleCredentialsForm() {
            var credentialsForm = document.getElementById("credentialsForm");
            credentialsForm.style.display = (credentialsForm.style.display === "none") ? "block" : "none";
        }

        function submitCredentialsForm() {
            var newUsername = document.getElementById("newUsername").value;
            var newPassword = document.getElementById("newPassword").value;
            var confirmPassword = document.getElementById("confirmPassword").value;

            // Perform client-side validation (you may want to add more checks)
            if (newPassword !== confirmPassword) {
                alert("Passwords do not match.");
                return;
            }

            // Redirect to the page with a parameter indicating credentials update
            window.location.href = "student_page.php?updateCredentials=true&newUsername=" + encodeURIComponent(newUsername) + "&newPassword=" + encodeURIComponent(newPassword);
        }

        
        function logout() {
            // Redirect to the logout page
            window.location.href = "logout.php";
        }
    </script>
    <?php 
                
        // Check if the "deactivate" parameter is set in the URL
        if (isset($_GET['deactivate']) && $_GET['deactivate'] == 'true') {
            // If yes, call the removeAccess function
            removeAccess($userUIN, $conn);
        }

        // Check if the "updateCredentials" parameter is set in the URL
        if (isset($_GET['updateCredentials']) && $_GET['updateCredentials'] == 'true') {
            // If yes, call the updateCredentials function
            $newUsername = $_GET['newUsername'];
            $newPassword = $_GET['newPassword'];
            updateCredentials($userUIN, $newUsername, $newPassword, $conn);
        }

        if (isset($_GET['updateProfile']) && $_GET['updateProfile'] == 'true') {
            // If yes, call the updateProfileField function
           
            updateProfileFields($userUIN, $_GET, $conn);
        }
            
            
    ?>

</body>

</html>