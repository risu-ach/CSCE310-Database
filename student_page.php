

<!-- 
    Maya Lotfy
    UIN: 730001793

-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type = "text/css" href="../includes/styles_student_page">
    <script src="../includes/studentPageScript" defer></script>
    <title>Student Page</title>
    
</head>


<body>
    <script>

    function displayMessage(message) {
        alert(message);
        window.location.href = "student_page.php";
    }

    </script>

    <?php
    include_once 'includes/db.php';
    include_once 'includes/functions_student';
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION["userUIN"])) {
        // If not, redirect to the login page
        header("Location: login.php");
        exit();
    }

    $userUIN = $_SESSION["userUIN"];
    $userName = $_SESSION["userName"];

    ?>

    <header>

        <h1>User Profile</h1>
        <p>Welcome, <?php echo $userName; ?>, <?php echo $userUIN; ?>!</p>
    </header>
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

    <?php 
                
        // Check if the "deactivate" parameter is set in the URL
        if (isset($_GET['deactivate']) && $_GET['deactivate'] == 'true') {
            // If yes, call the removeAccess function
            $userUIN = $_SESSION["userUIN"];
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