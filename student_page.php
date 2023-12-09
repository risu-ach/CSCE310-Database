

<!-- 
    Maya Lotfy
    UIN: 730001793

-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type = "text/css" href="../includes/styles_student_page.css">
    <script src="../includes/studentPageScript.JS" defer></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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
    include_once 'includes/functions_student.php';
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
        <h2>Welcome, <?php echo $userName; ?>, <?php echo $userUIN; ?>!</h2>
    </header>

    <div class="button-container">
        <button onclick="toggleProfile()">View Profile</button>
        <button onclick="toggleUpdateForm()">Update Personal Information</button>
        <button onclick="toggleCredentialsForm()">Change login credentials</button>
        <button onclick="confirmDeactivate()">Deactivate account</button>
        <button onclick="logout()">logout</button>
    </div>



     <!-- Displaying user profile information -->
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

            $userFields = array(
                "UIN" => 'UIN',
                "First_name" => 'First Name',
                "M_initial" => 'Middle Initial',
                "Last_name" => 'Last Name',
                "Username" => 'Username',
                "Passwords" => 'Password',
                "User_type" => 'User Type',
                "Email" => 'Email',
                "Discord_name" => 'Discord Name'
            );

            $studentFields = array(
                "Gender" => 'Gender',
                "Hispanic_latino" => 'Hispanic/Latino',
                "Race" => 'Race',
                "US_citizen" => 'US citizen',
                "First_generation" => 'First generation',
                "DoB" => 'DOB',
                "GPA" => 'GPA',
                "Major" => 'Major',
                "Minor1" => 'Minor 1',
                "Minor2" => 'Minor 2',
                "Expected_graduation" => 'Expected graduation',
                "School" => 'School',
                "Classification" => 'Classification',
                "Phone" => 'Phone',
                "Student_type" => 'Student_type'
            );


            if ($userDataResult->num_rows > 0) {
                $userData = $userDataResult->fetch_assoc();

                //form fields for each student profile field
                foreach ($userData as $field => $value) {
                    $editable = true;
                    if (in_array($field, $nonEditableFields)) {
                        $editable = false;
                    }
                    if ( $field != 'User_type' && $editable ) { 
                        echo '<label for="new' . $field . '">' . $userFields[$field] . ':</label>';
                        echo '<input type="text" id="new' . $field . '" name="new' . $field . '" value="' . $value . '"><br>';
                    }
                    elseif ($field != 'User_type'){
                        // Displaying the value if the field is not editable
                        echo '<label>' . $userFields[$field] . ':</label>';
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
                        echo '<label for="new' . $field . '">' . $studentFields[$field] . ':</label>';
                        echo '<input type="text" id="new' . $field . '" name="new' . $field . '" value="' . $value . '"><br>';
                    }
                    elseif ($field != 'UIN' && $field != 'Student_type'){
                        // Display the value as text if the field is not editable
                        echo '<label>' . $studentFields[$field] . ':</label>';
                        echo '<span>' . $value . '</span><br>';

                    }
                    else{
                        continue;
                    }
                }
            }
            ?>
            <div class="button-container2">

                <button type="button" onclick="updateProfileFields()" class="margin-top">Update</button>
                <button type="button" onclick="cancelUpdateStudent()" class="margin-top">Cancel</button>

            </div>

        </fieldset>
    </form>

    <!-- Form to change login credentials -->
    <form id="credentialsForm" style="display:none;" method="post" action="student_page.php" onsubmit="submitCredentialsForm()">

        <fieldset>
            <legend>Change Login Credentials</legend>

            <label for="newUsername2">New Username:</label>
            <div class="input-group">
                <input type="text" id="newUsername2" name="newUsername2" class="form-control" required><br>
            </div>
                        

            <label for="newPassword">New Password:</label>
            <div class="input-group">
                <input type="password" id="newPassword" name="newPassword" class="form-control" required>
                <div class="input-group-append">
                    <span class="input-group-text toggle-password" onclick="togglePasswordVisibility('newPassword')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>
            <br>

            <label for="confirmPassword">Confirm Password:</label>
            <div class="input-group">
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                <div class="input-group-append">
                    <span class="input-group-text toggle-password" onclick="togglePasswordVisibility('confirmPassword')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>
            <br>

            <input type="hidden" id="hiddenNewUsername" name="hiddenNewUsername">
            <input type="hidden" id="hiddenNewPassword" name="hiddenNewPassword">

        
            <div class="button-container2">
                <button type="submit" name="updateCredentials" class="margin-top">Update Credentials</button>
                <button type="submit" onclick="cancelCredentials()" class="margin-top">Cancel</button>
            </div>


        </fieldset>
    </form>

    <?php 
                
        //Checking if the "deactivate" is set in the URL
        if (isset($_GET['deactivate']) && $_GET['deactivate'] == 'true') {
            // If yes, call the removeAccess function
            $userUIN = $_SESSION["userUIN"];
            removeAccess($userUIN, $conn);
        }

        
        // Checking if the "updateCredentials" parameter is set in the URL
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['updateCredentials'])) {
            // If yes, call the updateCredentials function
            $newUsername = $_POST['hiddenNewUsername'];
            $newPassword = $_POST['hiddenNewPassword'];
            updateCredentials($userUIN, $newUsername, $newPassword, $conn);
        }
        
        //Checking if the "updateProfile" is set in the URL
        if (isset($_GET['updateProfile']) && $_GET['updateProfile'] == 'true') {
            // If yes, call the updateProfileField function
            updateProfileFields($userUIN, $_GET, $conn);
        }
            
            
    ?>

</body>

</html>