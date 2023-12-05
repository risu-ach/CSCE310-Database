<?php
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

function displayStudentInfo($userUIN,$conn){
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