<?php
//Maya Lotfy 
//UIN: 730001793



include_once 'db.php';

session_start();

// Function to add a new administrator
function addAdministrator($UIN, $firstName, $middleInitial, $lastName, $username, $password, $userType, $email, $discordName)
{
    global $conn;
    $sql = "INSERT INTO users (UIN, First_name, M_initial, Last_name, Username, Passwords, User_type, Email, Discord_name) 
        VALUES ('$UIN','$firstName', '$middleInitial', '$lastName', '$username', '$password', '$userType', '$email', '$discordName')";
    if ($conn->query($sql) === TRUE ) {
        
        echo '<script>displayMessage("New Admin added successfully.");</script>';
        

    } else {
        echo '<script>displayMessage("Error adding admin");</script>';

    }
}

// Function to update user information
function updateAdministrator($UIN, $firstName, $middleInitial, $lastName, $username, $userType, $email, $discordName)
{
    global $conn;
    $sql = "UPDATE users SET 
            First_name='$firstName', 
            M_initial='$middleInitial', 
            Last_name='$lastName', 
            Username='$username', 
            User_type='$userType', 
            Email='$email', 
            Discord_name='$discordName'
            WHERE UIN='$UIN'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>displayMessage("Information Updated successfully.");</script>';


    } else {
        echo '<script>displayMessage("Error updating admin details");</script>';


    }

}

// Function to add a new student
function addStudent($UIN, $gender, $hispanicLatino, $race, $usCitizen, $firstGeneration, $dob, $gpa, $major, $minor1, $minor2, $expectedGraduation, $school, $classification, $phone, $studentType) {
    global $conn;

    $sql = "INSERT INTO college_student (UIN, Gender, Hispanic_latino, Race, US_citizen, First_generation, DoB, GPA, Major, Minor1, Minor2, Expected_graduation, School, Classification, Phone, Student_type) 
            VALUES ('$UIN', '$gender', '$hispanicLatino', '$race', '$usCitizen', '$firstGeneration', '$dob', '$gpa', '$major', '$minor1', '$minor2', '$expectedGraduation', '$school', '$classification', '$phone', '$studentType')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>displayMessage("New Student added successfully.");</script>';

    } else {
        echo '<script>displayMessage("Error adding student");</script>';

    }
}

function updateStudent($updateUIN, $updateData) {
    // Update the college_student table
    global $conn;

    $updateQuery = "UPDATE college_student SET 
        Gender = '{$updateData['updateGender']}',
        Hispanic_latino = '{$updateData['updateHispanicLatino']}',
        Race = '{$updateData['updateRace']}',
        US_citizen = '{$updateData['updateUsCitizen']}',
        First_generation = '{$updateData['updatefirstGeneration']}',
        GPA = '{$updateData['updateGpa']}',
        Major = '{$updateData['updateMajor']}',
        Minor1 = '{$updateData['updateMinor1']}',
        Minor2 = '{$updateData['updateMinor2']}',
        Expected_graduation = '{$updateData['updateExpectedGraduation']}',
        School = '{$updateData['updateSchool']}',
        Classification = '{$updateData['updateClassification']}',
        Phone = '{$updateData['updatePhone']}',
        Student_type = '{$updateData['updateStudentType']}'";

    // Check if 'DoB' is set in $updateData before adding it to the query
    if (isset($updateData['updatedob'])) {
        // Convert the date from m-d-Y to Y-m-d
        $dateObj = DateTime::createFromFormat('m-d-Y', $updateData['updatedob']);
        $formattedDate = $dateObj ? $dateObj->format('Y-m-d') : null;
        // Adding the formatted date to the query
        if ($formattedDate !== null) {
            $updateQuery .= ", DoB = '{$formattedDate}'";
        }
    }

    $updateQuery .= " WHERE UIN = '{$updateUIN}'";
    if ($conn->query($updateQuery) === TRUE) {
        
    } else {
        // Handle the case where the update fails
    }
}


// View a list of all user types along with their roles.
function viewAllUsers()
{
    global $conn;
    $sql = "SELECT * FROM user_college_student_view";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["UIN"] . '</td>';
            echo '<td>' . $row["First_name"] . '</td>';
            echo '<td>' . $row["M_initial"] . '</td>';
            echo '<td>' . $row["Last_name"] . '</td>';
            echo '<td>' . $row["Username"] . '</td>';
            echo '<td>' . $row["User_type"] . '</td>';
            echo '<td>' . $row["Email"] . '</td>';
            echo '<td>' . $row["Discord_name"] . '</td>';
            $dobFormatted = date_format(date_create($row["DoB"]), 'm/d/Y');
            if($row["User_type"] === 'student'){
                $userData = array(
                    "UIN" => $row["UIN"],
                    "First_name" => $row["First_name"],
                    "M_initial" => $row["M_initial"],
                    "Last_name" => $row["Last_name"],
                    "Username" => $row["Username"],
                    "User_type" => $row["User_type"],
                    "Email" => $row["Email"],
                    "Discord_name" => $row["Discord_name"],
                    "Gender" => $row["Gender"],
                    "Hispanic_latino" => $row["Hispanic_latino"],
                    "Race" => $row["Race"],
                    "US_citizen" => $row["US_citizen"],
                    "First_generation" => $row["First_generation"],
                    "DoB" => $dobFormatted,
                    "GPA" => $row["GPA"],
                    "Major" => $row["Major"],
                    "Minor1" => $row["Minor1"],
                    "Minor2" => $row["Minor2"],
                    "Expected_graduation" => $row["Expected_graduation"],
                    "School" => $row["School"],
                    "Classification" => $row["Classification"],
                    "Phone" => $row["Phone"],
                    "Student_type" => $row["Student_type"]
                );
                echo '<td><button onclick="toggleUpdateUserForm(' . htmlspecialchars(json_encode($userData), ENT_QUOTES, 'UTF-8') . ' )">Update Student</button></td>';

                
            }
            elseif ($row["User_type"] === 'admin'){

                echo '<td><button onclick="toggleUpdateAdminForm(\'' . $row["UIN"] . '\', \'' . $row["First_name"] . '\', \'' . $row["M_initial"] . '\', \'' .
                $row["Last_name"] . '\', \'' . $row["Username"] . '\', \'' . $row["User_type"] . '\', \'' .
                $row["Email"] . '\', \'' . $row["Discord_name"] . '\')">Update Admin</button></td>';

            }
            else{
                echo '<td><button onclick="toggleUpdateAdminForm(\'' . $row["UIN"] . '\', \'' . $row["First_name"] . '\', \'' . $row["M_initial"] . '\', \'' .
                $row["Last_name"] . '\', \'' . $row["Username"] . '\', \'' . $row["User_type"] . '\', \'' .
                $row["Email"] . '\', \'' . $row["Discord_name"] . '\')">Update</button></td>';

            }
            
            echo '<td><button onclick="toggleRemove(\'' . $row["UIN"] . '\', \'' . $row["User_type"] . '\')">Remove Access</button></td>';
            echo '<td><button onclick="toggleDelete(\'' . $row["UIN"] . '\')">Full Delete</button></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<script>displayMessage("No users found");</script>';

    }
}


// Remove access to the system for a given account.
function removeAccess($uin, $userType)
{
    global $conn;
    if($userType === 'student'){
        $sql = "UPDATE users SET User_type='No Access Student' WHERE UIN=$uin";

    }
    elseif($userType === 'admin'){
        $sql = "UPDATE users SET User_type='No Access Admin' WHERE UIN=$uin";

    }
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>displayMessage("Access Removed successfully.");</script>';

    } else {
        echo '<script>displayMessage("Error removing access);</script>';

    }
}
// delete user
function fullDelete($uin)
{
    global $conn;
    $sql = "DELETE FROM users WHERE UIN = ?";
    $sqlStudent = "DELETE FROM college_student WHERE UIN = ?";
    
    $stmt1 = $conn->prepare($sql);
    $stmt1->bind_param("i", $uin);
    $result1 = $stmt1->execute();

    $stmt2 = $conn->prepare($sqlStudent);
    $stmt2->bind_param("i", $uin);
    $result2 = $stmt2->execute();

    // Check for errors in both queries
    if ($result1 === FALSE || $result2 === FALSE) {
        echo "Error: " . $stmt1->error . "\n" . $stmt2->error;
        echo '<script>displayMessage("Error deleting");</script>';

    } else {
        echo '<script>displayMessage(" User deleted successfully.");</script>';

    }

    $stmt1->close();
    $stmt2->close();
}



function toggleStudents(){
    global $conn;

    $sql = "SELECT * FROM user_student_view";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
          
        while ($Data = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $Data["UIN"] . '</td>';
            echo '<td>' . $Data["First_name"] . '</td>';
            echo '<td>' . $Data["M_initial"] . '</td>';
            echo '<td>' . $Data["Last_name"] . '</td>';
            echo '<td>' . $Data["Username"] . '</td>';
            echo '<td>' . $Data["User_type"] . '</td>';
            echo '<td>' . $Data["Email"] . '</td>';
            echo '<td>' . $Data["Discord_name"] . '</td>';
            echo '<td>' . $Data["Gender"] . '</td>';
            echo '<td>' . $Data["Hispanic_latino"] . '</td>';
            echo '<td>' . $Data["Race"] . '</td>';
            echo '<td>' . $Data["US_citizen"] . '</td>';
            echo '<td>' . $Data["First_generation"] . '</td>';
            echo '<td>' . $Data["DoB"] . '</td>';
            echo '<td>' . $Data["GPA"] . '</td>';
            echo '<td>' . $Data["Major"] . '</td>';
            echo '<td>' . $Data["Minor1"] . '</td>';
            echo '<td>' . $Data["Minor2"] . '</td>';
            echo '<td>' . $Data["Expected_graduation"] . '</td>';
            echo '<td>' . $Data["School"] . '</td>';
            echo '<td>' . $Data["Classification"] . '</td>';
            echo '<td>' . $Data["Phone"] . '</td>';
            echo '<td>' . $Data["Student_type"] . '</td>';
            echo '</tr>';
            
        }
        echo '</table>';
       
    } 
    else {
        echo '<p>No student information available.</p>';
    }  
}

session_write_close();
?>
