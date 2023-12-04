<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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

        #addUserForm input[type="submit"],
        #addUserForm input[type="button"] {
            margin-top: 20px;
        }

        #addUserForm label {
            margin-top: 10px;
        }

        /* Adjusted spacing for checkbox fields */
        #addUserForm input[type="checkbox"] {
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<script>


    function displayMessage(message) {
        alert(message);
        window.location.href = "admin_page.php";;
    }

</script>

    


<?php
    session_start();

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


   


    // c. Select: View a list of all user types along with their roles.
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


    // i. Delete: Remove access to the system for a given account.
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
    // ii. Delete: Full delete with corresponding data.
    function fullDelete($uin)
    {
        global $conn;
       // Use prepared statements to prevent SQL injection
        $sql = "DELETE FROM users WHERE UIN = ?";
        $sqlStudent = "DELETE FROM college_student WHERE UIN = ?";
        
        // Prepare and execute the first query
        $stmt1 = $conn->prepare($sql);
        $stmt1->bind_param("i", $uin);
        $result1 = $stmt1->execute();

        // Prepare and execute the second query
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

        // Close the prepared statements
        $stmt1->close();
        $stmt2->close();
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

    function toggleStudents(){
        global $conn;

        $sql = "SELECT * FROM user_student_view";
        $result = $conn->query($sql);

        echo '<div id="studentInfoContainer">';

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<tr><th>UIN</th><th>First Name</th><th>Middle Initial</th>
            <th>Last Name</th><th>Username</th><th>Email</th><th>Discord Name</th>
            <th>Gender</th><th>Hispanic/Latino</th><th>Race</th>
            <th>US citizen</th><th>First Generation</th><th>DOB</th>
            <th>GPA</th><th>Major</th><th>Minor1</th><th>Minor2</th>
            <th>Expected Graduation</th><th>School</th><th>Classification</th>
            <th>Phone</th><th>Student Type</th></tr>';  
            while ($Data = $result->fetch_assoc()) {
                echo '<tr>';

           
                echo '<td>' . $Data["UIN"] . '</td>';
                echo '<td>' . $Data["First_name"] . '</td>';
                echo '<td>' . $Data["M_initial"] . '</td>';
                echo '<td>' . $Data["Last_name"] . '</td>';
                echo '<td>' . $Data["Username"] . '</td>';
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
                
            }
            echo '</table>';
        } 
        else {
            echo '<p>No student information available.</p>';
        }

        echo '</div>';
    }
    
    
    // Close connection
    //$conn->close();
    session_write_close();


    ?>
    <h1>Admin Profile</h1>



    <p>Welcome, <?php echo $userName; ?>, <?php echo $userUIN; ?>!</p>

    <button onclick="toggleForm()">Add New User</button>
    <button onclick="toggleView()">View All Users</button>
    <button onclick = "toggleStudents()" action = 'toggleStudents'>Students' Information</button>


    <button onclick="logout()">logout</button>

    


    <!-- Form for Adding New User -->
    <form method="post" action="" id="addUserForm">
        <fieldset>
            <legend>Add New User</legend>

            <label for="UIN">UIN:</label>
            <input type="text" name="UIN" required>

            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" required>

            <label for="middleInitial">Middle Initial:</label>
            <input type="char" name="middleInitial" maxlength="1">

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" required>

            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="userType">User Type:</label>
            <select name="userType" id="userType" onchange="toggleStudentFields()">
                <option value="admin">Admin</option>
                <option value="student">Student</option>
            </select>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="discordName">Discord Name:</label>
            <input type="text" name="discordName">

            <div id="studentFields" style="display: none;">
                <label for="gender">Gender:</label>
                <select name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <label for="hispanicLatino">Hispanic/Latino:</label>
                <select name="hispanicLatino" >
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>


                <label for="race">Race:</label>
                <select name="race" required>
                    <option value="White">White</option>
                    <option value="Asian/Pacific Islander">Asian/Pacific Islander</option>
                    <option value="Black">Black</option>
                    <option value="Hispanic">Hispanic</option>
                    <option value="Other">Other</option>

                </select>
                

                <label for="usCitizen">U.S. Citizen:</label>
                <select name="usCitizen">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>


                <label for="firstGeneration">First Generation:</label>
                <select name="firstGeneration">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>


                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob">

                <label for="gpa">GPA:</label>
                <input type="text" name="gpa">

                <label for="major">Major:</label>
                <input type="text" name="major">

                <label for="minor1">Minor #1:</label>
                <input type="text" name="minor1">

                <label for="minor2">Minor #2:</label>
                <input type="text" name="minor2">

                <label for="expectedGraduation">Expected Graduation:</label>
        
                <select name="expectedGraduation" required>
                    <?php
                    for ($year = date("Y"); $year <= date("Y") + 10; $year++) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
    

                <label for="school">School:</label>
                <input type="text" name="school">

                <label for="classification">Classification:</label>
                <select name="classification" required>
                    <option value="Freshman">Freshman</option>
                    <option value="Sophomore">Sophomore</option>
                    <option value="Junior">Junior</option>
                    <option value="Senior">Senior</option>
                    <option value="Senior">Graduate</option>
                </select>

                <label for="phone">Phone:</label>
                <input type="text" name="phone">

                <label for="studentType">Student Type:</label>
                <input type="text" name="studentType">
            </div>  

            

            <input type="submit" name="addUser" value="Add User">

            <label for="cancelButton"></label>
            <input type="button" value="Cancel" onclick="cancelAddUser()">



        </fieldset>
    </form>

    <table id="userTable" style="display: none;">
        <tr>
            
            <th>UIN</th>
            <th>First Name</th>
            <th>Middle Initial</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>User Type</th>
            <th>Email</th>
            <th>Discord Name</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>

            
        </tr>
        <?php
        viewAllUsers();
        ?>
    </table>
    

    <form method="post" action="" id="updateStudentForm" style="display: none;">
        <label for="updateUIN">UIN:</label>
        <input type="text" name="updateUIN" id="updateUIN" readonly>

        <!-- Include fields specific to students -->
        <label for="updateFirstName">First Name:</label>
        <input type="text" name="updateFirstName" id="updateFirstName" >

        <label for="updateMiddleInitial">Middle Initial:</label>
        <input type="char" name="updateMiddleInitial" id = "updateMiddleInitial" maxlength="1" >

        <label for="updateLastName">Last Name:</label>
        <input type="text" name="updateLastName" id = "updateLastName" required>

        <label for="updateUsername">Username:</label>
        <input type="text" name="updateUsername" id = "updateUsername">

        <label for="updateUserType">User Type:</label>
        <select name="updateUserType" id="updateUserType">
            <option value="admin">Admin</option>
            <option value="student">Student</option>
        </select>

        <label for="updateEmail">Email:</label>
        <input type="email" name="updateEmail" id = "updateEmail" >

        <label for="updateDiscordName">Discord Name:</label>
        <input type="text" name="updateDiscordName" id = "updateDiscordName">

        

        <label for="updateGender">Gender:</label>
        <select name="updateGender" id = "updateGender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="updateHispanicLatino">Hispanic/Latino:</label>
        <select name="updateHispanicLatino"  id = "updateHispanicLatino" >
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <label for="updateRace">Race:</label>
        <select name="updateRace" id ="updateRace" >
            <option value="White">White</option>
            <option value="Asian/Pacific Islander">Asian/Pacific Islander</option>
            <option value="Black">Black</option>
            <option value="Hispanic">Hispanic</option>
            <option value="Other">Other</option>

        </select>
        

        <label for="updateUsCitizen">U.S. Citizen:</label>
        <select name="updateUsCitizen"  id ="updateUsCitizen">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>


        <label for="updatefirstGeneration">First Generation:</label>
        <select name="updatefirstGeneration" id="updatefirstGeneration">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <label for="updatedob">Date of Birth (mm-dd-yyyy):</label>
        <input type="text" name="updatedob" id= "updatedob" >

        <label for="updateGpa">GPA:</label>
        <input type="text" name="updateGpa" id="updateGpa">

        <label for="updateMajor">Major:</label>
        <input type="text" name="updateMajor" id="updateMajor">

        <label for="updateMinor1">Minor #1:</label>
        <input type="text" name="updateMinor1" id="updateMinor1">

        <label for="updateMinor2">Minor #2:</label>
        <input type="text" name="updateMinor2" id="updateMinor2">

        <label for="updateExpectedGraduation">Expected Graduation:</label>
        <select name="updateExpectedGraduation" id = "updateExpectedGraduation" required>
            <?php
            for ($year = date("Y"); $year <= date("Y") + 10; $year++) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>


        <label for="updateSchool">School:</label>
        <input type="text" name="updateSchool" id="updateSchool">

        <label for="updateClassification">Classification:</label>
        <select name="updateClassification" id ="updateClassification" required>
            <option value="Freshman">Freshman</option>
            <option value="Sophomore">Sophomore</option>
            <option value="Junior">Junior</option>
            <option value="Senior">Senior</option>
            <option value="Senior">Graduate</option>
        </select>

        <label for="updatePhone">Phone:</label>
        <input type="text" name="updatePhone" id= "updatePhone">

        <label for="updateStudentType">Student Type:</label>
        <input type="text" name="updateStudentType" id="updateStudentType">


        <input type="submit" name="updateUser" value="Update User">
        <input type="button" value="Cancel" onclick="cancelUpdateStudent()">

    </form>

    <form method="post"  id="updateAdminForm" style="display: none;">
        <label for="updateAdminUIN">UIN:</label>
        <input type="text" name="updateAdminUIN" id="updateAdminUIN" readonly>

        <!-- Include fields specific to students -->
        <label for="updateAdminFirstName">First Name:</label>
        <input type="text" name="updateAdminFirstName" id="updateAdminFirstName" >

        <label for="updateAdminMiddleInitial">Middle Initial:</label>
        <input type="char" name="updateAdminMiddleInitial" id = "updateAdminMiddleInitial" maxlength="1" >

        <label for="updateAdminLastName">Last Name:</label>
        <input type="text" name="updateAdminLastName" id = "updateAdminLastName" required>

        <label for="updateAdminUsername">Username:</label>
        <input type="text" name="updateAdminUsername" id = "updateAdminUsername">

        <label for="updateAdminUserType">User Type:</label>
        <select name="updateAdminUserType" id="updateAdminUserType">
            <option value="admin">admin</option>
            <option value="student">student</option>
        </select>

        <label for="updateAdminEmail">Email:</label>
        <input type="email" name="updateAdminEmail" id = "updateAdminEmail" >

        <label for="updateAdminDiscordName">Discord Name:</label>
        <input type="text" name="updateAdminDiscordName" id = "updateAdminDiscordName">

        <input type="submit" name="updateAdmin" value="Update Admin">
        <input type="button" value="Cancel" onclick="cancelUpdateAdmin()">



    </form>

    <form id="removeAccessForm" method="post" >
        <input type="hidden" name="action" value="removeAccess">
        <input type="hidden" name="uin" id="removeUIN">
        <input type="hidden" name="userType" id="removeUserType">
        <input type="submit" name="removeAccess" value="Remove Access">
    </form>
    <!-- Form for Full Delete -->
    <form method="post" action="" id="fullDeleteForm">
        <input type="hidden" name="action" value="fullDelete">
        <input type="hidden" name="uin" id="deleteUIN">
        <input type="submit" name="fullDelete" value="Full Delete">
    </form>

    <div id="studentInfoContainer" style="display:none;">
        <?php toggleStudents(); ?>
    </div>

    <?php
    
    // Check if the form is submitted for adding a new user
    if (isset($_POST['addUser'])) {
        $UIN = $_POST['UIN'];
        $firstName = $_POST['firstName'];
        $middleInitial = $_POST['middleInitial'];
        $lastName = $_POST['lastName'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $userType = $_POST['userType'];
        $email = $_POST['email'];
        $discordName = $_POST['discordName'];

        // Call the function to add a new user
        addAdministrator($UIN, $firstName, $middleInitial, $lastName, $username, $password, $userType, $email, $discordName);

        // Additional fields for students
        if ($userType === 'student') {
            $gender = $_POST['gender'];
            $hispanicLatino = $_POST['hispanicLatino'];
            $race = $_POST['race'];
            $usCitizen = $_POST['usCitizen'];
            $firstGeneration = $_POST['firstGeneration'];
            $dob = $_POST['dob'];
            $gpa = $_POST['gpa'];
            $major = $_POST['major'];
            $minor1 = $_POST['minor1'];
            $minor2 = $_POST['minor2'];
            $expectedGraduation = $_POST['expectedGraduation'];
            $school = $_POST['school'];
            $classification = $_POST['classification'];
            $phone = $_POST['phone'];
            $studentType = $_POST['studentType'];

            // Call the function to add a new student
            addStudent($UIN, $gender, $hispanicLatino, $race, $usCitizen, $firstGeneration, $dob, $gpa, $major, $minor1, $minor2, $expectedGraduation, $school, $classification, $phone, $studentType);

            
        }
    }

    if (isset($_POST['removeAccess'])) {
        $RemoveAccessUIN = $_POST['uin'];
        $RemoveAccessUserType = $_POST['userType'];

        removeAccess($RemoveAccessUIN, $RemoveAccessUserType);
    }

    if (isset($_POST['fullDelete'])) {
        $fullDeleteUIN = $_POST['uin'];

        fullDelete($fullDeleteUIN);
    }

    if (isset($_POST['updateUser'])) {

        $updateUIN = $_POST['updateUIN'];

        $updateData = $_POST;
        $updateFirstName = $_POST['updateFirstName'];
        $updateMiddleInitial = $_POST['updateMiddleInitial'];
        $updateLastName = $_POST['updateLastName'];
        $updateUsername = $_POST['updateUsername'];
        $updateUserType = $_POST['updateUserType'];
        $updateEmail = $_POST['updateEmail'];
        $updateDiscordName = $_POST['updateDiscordName'];

        updateAdministrator($updateUIN, $updateFirstName, $updateMiddleInitial, $updateLastName, $updateUsername, $updateUserType, $updateEmail, $updateDiscordName);

        // Example: Update the college_student table
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

            // Add the formatted date to the query
            if ($formattedDate !== null) {
                $updateQuery .= ", DoB = '{$formattedDate}'";
            }
        }

        $updateQuery .= " WHERE UIN = '{$updateUIN}'";

        // Execute the update query
        if ($conn->query($updateQuery) === TRUE) {
    
        } 
    }

    if (isset($_POST['updateAdmin'])) {

        $updateUIN = $_POST['updateAdminUIN'];
        $updateFirstName = $_POST['updateAdminFirstName'];
        $updateMiddleInitial = $_POST['updateAdminMiddleInitial'];
        $updateLastName = $_POST['updateAdminLastName'];
        $updateUsername = $_POST['updateAdminUsername'];
        $updateUserType = $_POST['updateAdminUserType'];
        $updateEmail = $_POST['updateAdminEmail'];
        $updateDiscordName = $_POST['updateAdminDiscordName'];
        updateAdministrator($updateUIN, $updateFirstName, $updateMiddleInitial, $updateLastName, $updateUsername, $updateUserType, $updateEmail, $updateDiscordName);


    }

    if (isset($_GET['action']) && $_GET['action'] == 'toggleStudents') {
        toggleStudents();
    }

 
    ?>
    <script>
        function toggleForm() {
            var form = document.getElementById("addUserForm");
            form.style.display = (form.style.display === "none") ? "block" : "none";
            
        }

        function cancelAddUser() {
            var form = document.getElementById("addUserForm");
            form.style.display = "none";
        }

        function cancelUpdateStudent() {
            var form = document.getElementById("updateStudentForm");
            document.getElementById('updateStudentForm').style.display = 'none';

        }

        function cancelUpdateAdmin() {
            var form = document.getElementById("updateAdminForm");
            document.getElementById('updateAdminForm').style.display = 'none';

        }

        function toggleView() {
            var table = document.getElementById("userTable");
            table.style.display = (table.style.display === "none") ? "table" : "none";
            
        }
  
        function toggleUpdateAdminForm(uin, firstName, middleInitial, lastName, username, userType, email, discordName){


            document.querySelector('#updateAdminForm [name="updateAdminUIN"]').value = uin;

            document.querySelector('#updateAdminForm [name="updateAdminFirstName"]').value = firstName;
            document.querySelector('#updateAdminForm [name="updateAdminMiddleInitial"]').value = middleInitial;
            document.querySelector('#updateAdminForm [name="updateAdminLastName"]').value = lastName;
            document.querySelector('#updateAdminForm [name="updateAdminUsername"]').value = username;
            document.querySelector('#updateAdminForm [name="updateAdminUserType"]').value = userType;
            document.querySelector('#updateAdminForm [name="updateAdminEmail"]').value = email;
            document.querySelector('#updateAdminForm [name="updateAdminDiscordName"]').value = discordName;
            document.getElementById('updateAdminForm').style.display = 'block';

        }
        function populateUpdateStudentForm(userData) {

            var storedDate = userData.DoB;

           // Convert the stored date to m-d-Y format for display
            var dateObj = new Date(storedDate);
            var formattedDate = (dateObj.getMonth() + 1).toString().padStart(2, '0') + '-' + dateObj.getDate().toString().padStart(2, '0') + '-' + dateObj.getFullYear();
            document.getElementById('updateUIN').value = userData.UIN;
            document.getElementById('updateFirstName').value = userData.First_name;
            document.getElementById('updateMiddleInitial').value = userData.M_initial;
            document.getElementById('updateLastName').value = userData.Last_name; // Example: Fetch and set the last name
            document.getElementById('updateUsername').value = userData.Username; // Example: Fetch and set the username
            document.getElementById('updateUserType').value = userData.User_type; // Example: Fetch and set the user type
            document.getElementById('updateEmail').value = userData.Email; // Example: Fetch and set the email
            document.getElementById('updateDiscordName').value = userData.Discord_name; // Example: Fetch and set the Discord name
            document.getElementById('updateGender').value = userData.Gender; // Example: Fetch and set the email
            document.getElementById('updateHispanicLatino').value = userData.Hispanic_latino; // Example: Fetch and set the email
            document.getElementById('updateRace').value = userData.Race; // Example: Fetch and set the email
            document.getElementById('updateUsCitizen').value = userData.US_citizen; // Example: Fetch and set the U.S. Citizen checkbox
            document.getElementById('updatefirstGeneration').value = userData.First_generation; // Example: Fetch and set the email
            document.getElementById('updatedob').value = formattedDate; // Example: Fetch and set the email
            document.getElementById('updateGpa').value = userData.GPA; // Example: Fetch and set the GPA
            document.getElementById('updateMajor').value = userData.Major; // Example: Fetch and set the major
            document.getElementById('updateMinor1').value = userData.Minor1; // Example: Fetch and set minor 1
            document.getElementById('updateMinor2').value = userData.Minor2; // Example: Fetch and set minor 2
            document.getElementById('updateExpectedGraduation').value = userData.Expected_graduation; // Example: Fetch and set expected graduation
            document.getElementById('updateSchool').value = userData.School; // Example: Fetch and set the school
            document.getElementById('updateClassification').value = userData.Classification; // Example: Fetch and set the classification
            document.getElementById('updatePhone').value = userData.Phone; // Example: Fetch and set the phone
            document.getElementById('updateStudentType').value = userData.Student_type; // Example: Fetch and set the student type

            
        }

        function toggleUpdateUserForm(userDataJSON) {
            // Parse the JSON-encoded userData
            var userData = userDataJSON;

            populateUpdateStudentForm(userData);
            document.getElementById('updateStudentForm').style.display = 'block';

        }

        function toggleRemove(uin, userType) {

            var form = document.getElementById("removeAccessForm");
            var removeUIN = document.getElementById("removeUIN");
            var removeUserType= document.getElementById("removeUserType");
            removeUIN.value = uin;
            removeUserType.value = userType;
            form.style.display = (form.style.display === "none") ? "block" : "none";
            
        }
    
        function toggleDelete(uin) {
            var form = document.getElementById("fullDeleteForm");
            var deleteUIN = document.getElementById("deleteUIN");
            deleteUIN.value = uin;
            form.style.display = (form.style.display === "none") ? "block" : "none";
        }
    
        function toggleStudentFields() {
            var userType = document.getElementById("userType").value;
            var studentFields = document.getElementById("studentFields");

            // Show student fields only if the user type is "student"
            studentFields.style.display = (userType === "student" || userType === "Student" ) ? "block" : "none";
        }

        // JavaScript code for toggling visibility
        function toggleStudents() {
            var container = document.getElementById('studentInfoContainer');
            container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
        }

        function logout() {
            // Redirect to the logout page
            window.location.href = "logout.php";
        }
    </script>

</body>

</html>
