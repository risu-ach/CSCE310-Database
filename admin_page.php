<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
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
    $updateUsCitizen = isset($_POST['updateUsCitizen']) ? 1 : 0;



    // Function to add a new administrator
    function addAdministrator($UIN, $firstName, $middleInitial, $lastName, $username, $password, $userType, $email, $discordName)
    {
        global $conn;
        $sql = "INSERT INTO users (UIN, First_name, M_initial, Last_name, Username, Passwords, User_type, Email, Discord_name) 
            VALUES ('$UIN','$firstName', '$middleInitial', '$lastName', '$username', '$password', '$userType', '$email', '$discordName')";
        if ($conn->query($sql) === TRUE) {
            echo "New user added successfully.\n";
        } else {
            echo "Error: " . $sql . "\n" . $conn->error;
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
            echo "User updated successfully.\n";
        } else {
            echo "Error updating user: " . $conn->error;
        }
       

    }



    // Function to update student information
    function updateStudentTable($UIN, $gender, $usCitizen, $gpa, $major, $minor1, $minor2, $expectedGraduation, $school, $classification, $phone, $studentType)
    {
        global $conn;

        $sql = "UPDATE college_student SET 

                Gender = '$gender',
                US_citizen='$usCitizen', 
                GPA='$gpa', 
                Major='$major', 
                Minor1='$minor1', 
                Minor2='$minor2', 
                Expected_graduation='$expectedGraduation', 
                School='$school', 
                Classification='$classification', 
                Phone='$phone', 
                Student_type='$studentType'
                WHERE UIN='$UIN'";

        if ($conn->query($sql) === TRUE) {
            echo "Student details updated successfully.\n";
        } else {
            echo "Error updating student details: " . $conn->error;
        }
    }



    // c. Select: View a list of all user types along with their roles.
    function viewAllUsers()
    {
        global $conn;
        $sql = "SELECT * FROM user_college_student_view";
        $result = $conn->query($sql);
        

        echo '<div id="userListContainer">';
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
                echo '<td><button onclick="toggleUpdateUserForm(\'' . $row["UIN"] . '\', \'' . $row["First_name"] . '\', \'' . $row["M_initial"] . '\', \'' .
                $row["Last_name"] . '\', \'' . $row["Username"] . '\', \'' . $row["User_type"] . '\', \'' .
                $row["Email"] . '\', \'' . $row["Discord_name"] . '\', \'' . $row["Gender"] . '\', \'' . $row["Hispanic_latino"] . '\', \'' . $row["Race"] . '\', \'' .
                $row["US_citizen"] . '\', \'' . $row["First_generation"] . '\', \'' . $dobFormatted . '\', \'' .
                $row["GPA"] . '\', \'' . $row["Major"] . '\', \'' . $row["Minor1"] . '\', \'' .
                $row["Minor2"] . '\', \'' . $row["Expected_graduation"] . '\', \'' . $row["School"] . '\', \'' .
                $row["Classification"] . '\', \'' . $row["Phone"] . '\', \'' . $row["Student_type"] . '\')">Update</button></td>';
                
                echo '<td><button onclick="toggleRemove(\'' . $row["UIN"] . '\')">Remove Access</button></td>';

                echo '<td><button onclick="toggleDelete(\'' . $row["UIN"] . '\')">Full Delete</button></td>';


                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "No users found.\n";
        }
    }


    
    
    // d. Delete: Remove all user types from the system.
    function removeAllAdministrators()
    {
        global $conn;
        $sql = "DELETE FROM users";
        if ($conn->query($sql) === TRUE) {
            echo "All users removed from the system.\n";
        } else {
            echo "Error: " . $sql . "\n" . $conn->error;
        }
    }

    // i. Delete: Remove access to the system for a given account.
    function removeAccess($uin)
    {
        global $conn;
        $sql = "UPDATE users SET User_type='No Access' WHERE UIN=$uin";
        if ($conn->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "\n" . $conn->error;
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
        } else {
            echo "Deletion successful.";
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
            echo "Student details added successfully.\n";
        } else {
            echo "Error: " . $sql . "\n" . $conn->error;
        }
    }
    
    // Close connection
    //$conn->close();

    ?>
    <h1>Admin Profile</h1>


    <p>Welcome, <?php echo $userName; ?>, <?php echo $userUIN; ?>!</p>

    <button onclick="toggleForm()">Add New User</button>
    <button onclick="toggleView()">View All Users</button>
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
                <input type="checkbox" name="hispanicLatino" value="1">

                <label for="race">Race:</label>
                <select name="race" required>
                    <option value="White">White</option>
                    <option value="Asian/Pacific Islander">Asian/Pacific Islander</option>
                    <option value="Black">Black</option>
                    <option value="Hispanic">Hispanic</option>
                    <option value="Other">Other</option>

                </select>
                

                <label for="usCitizen">U.S. Citizen:</label>
                <input type="checkbox" name="usCitizen">

                <label for="firstGeneration">First Generation:</label>
                <input type="checkbox" name="firstGeneration" >

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
        <input type="text" name="updateFirstName" id="updateFirstName" readonly>

        <label for="updateMiddleInitial">Middle Initial:</label>
        <input type="char" name="updateMiddleInitial" id = "updateMiddleInitial" maxlength="1" readonly>

        <label for="updateLastName">Last Name:</label>
        <input type="text" name="updateLastName" id = "updateLastName" required>

        <label for="updateUsername">Username:</label>
        <input type="text" name="updateUsername" id = "updateUsername">

        <label for="updateUserType">User Type:</label>
        <select name="updateUserType" id="updateUserType" onchange="toggleStudentFields()">
            <option value="admin">Admin</option>
            <option value="student">Student</option>
        </select>

        <label for="updateEmail">Email:</label>
        <input type="email" name="updateEmail" id = "updateEmail" >

        <label for="updateDiscordName">Discord Name:</label>
        <input type="text" name="updateDiscordName" id = "updateDiscordName">

        <div id="studentField" style="display: none;">

            <label for="updateGender">Gender:</label>
            <select name="updateGender" id = "updateGender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="updateHispanicLatino">Hispanic/Latino:</label>
            <input type="checkbox" name="updateHispanicLatino"  id = "updateHispanicLatino" readonly>

            <label for="updateRace">Race:</label>
            <select name="updateRace" id ="updateRace" readonly>
                <option value="White">White</option>
                <option value="Asian/Pacific Islander">Asian/Pacific Islander</option>
                <option value="Black">Black</option>
                <option value="Hispanic">Hispanic</option>
                <option value="Other">Other</option>

            </select>
            

            <label for="updateUsCitizen">U.S. Citizen:</label>
            <input type="checkbox" name="updateUsCitizen"  id ="updateUsCitizen" <?php echo ($_POST['updateUsCitizen'] == 1) ? 'checked' : ''; ?>>

            <label for="updatefirstGeneration">First Generation:</label>
            <input type="checkbox" name="updatefirstGeneration"  id ="updatefirstGeneration" readonly>

            <label for="updatedob">Date of Birth:</label>
            <input type="text" name="updatedob" id= "updatedob" readonly>

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
        </div>




        <input type="submit" name="updateUser" value="Update User">
        <input type="button" value="Cancel" onclick="cancelUpdate()">

    </form>


    <!-- Button for Remove Access -->
    

    <!-- Button for Full Delete -->
    

    <form id="removeAccessForm" method="post" >
        <input type="hidden" name="action" value="removeAccess">
        <input type="hidden" name="uin" id="removeUIN">
        <input type="submit" name="removeAccess" value="Remove Access">
    </form>
    <!-- Form for Full Delete -->
    <form method="post" action="" id="fullDeleteForm">
        <input type="hidden" name="action" value="fullDelete">
        <input type="hidden" name="uin" id="deleteUIN">
        <input type="submit" name="fullDelete" value="Full Delete">
    </form>

    

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
            $usCitizen = isset($_POST['usCitizen']) ? 1 : 0;
            $firstGeneration = isset($_POST['firstGeneration']) ? 1 : 0;
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
        reloadUserList();
    }

    if (isset($_POST['removeAccess'])) {
        $RemoveAccessUIN = $_POST['uin'];

        removeAccess($RemoveAccessUIN);
    }

    if (isset($_POST['fullDelete'])) {
        $fullDeleteUIN = $_POST['uin'];

        fullDelete($fullDeleteUIN);
    }

    

    if (isset($_POST['updateUser'])) {
        
        $updateUIN = $_POST['updateUIN'];
        $updateFirstName = $_POST['updateFirstName'];
        $updateMiddleInitial = $_POST['updateMiddleInitial'];
        $updateLastName = $_POST['updateLastName'];
        $updateUsername = $_POST['updateUsername'];
        $updateUserType = $_POST['updateUserType'];
        $updateEmail = $_POST['updateEmail'];
        $updateDiscordName = $_POST['updateDiscordName'];

        
        updateAdministrator($updateUIN, $updateFirstName, $updateMiddleInitial, $updateLastName, $updateUsername, $updateUserType, $updateEmail, $updateDiscordName);

        

        if($updateUserType === 'student'){


            $updateGender = $_POST['updateGender'];
            $updateUsCitizen = isset($_POST['updateUsCitizen']) ? 1 : 0;
            $updateGpa = $_POST['updateGpa'];
            $updateMajor = $_POST['updateMajor'];
            $updateMinor1 = $_POST['updateMinor1'];
            $updateMinor2 = $_POST['updateMinor2'];
            $updateExpectedGraduation = $_POST['updateExpectedGraduation'];
            $updateSchool = $_POST['updateSchool'];
            $updateClassification = $_POST['updateClassification'];
            $updatePhone = $_POST['updatePhone'];
            $updateStudentType = $_POST['updateStudentType'];


            // Call the function to update the student
            updateStudentTable($updateUIN, $updateGender, $updateUsCitizen, $updateGpa,  $updateMajor, $updateMinor1, $updateMinor2, $updateExpectedGraduation, $updateSchool, $updateClassification, $updatePhone, $updateStudentType);

        }

    

        
    
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

        function cancelUpdate() {
            var form = document.getElementById("updateStudentForm");
            form.style.display = "none";
        }

        function toggleView() {
            var table = document.getElementById("userTable");
            table.style.display = (table.style.display === "none") ? "table" : "none";
        }
        

        function toggleUpdateUserForm(uin, firstName, middleInitial, lastName, username, userType, email, discordName, gender, hispanicLatino, race, uscitizen, firstgen, dob, 
        gpa, major, minor1, minor2, expectedgrad, school, classification, phone, studentType) {
            
            
            // You can use the uin parameter to fetch user details for the selected user
            // Display the update form or perform other actions as needed
            //alert('Update button clicked for UIN: ' + uin);
            document.querySelector('#updateStudentForm [name="updateUIN"]').value = uin;

            document.querySelector('#updateStudentForm [name="updateFirstName"]').value = firstName;
            //document.getElementById('updateFirstName').value = ''; // Example: Fetch and set the first name
            document.querySelector('#updateStudentForm [name="updateMiddleInitial"]').value = middleInitial;
            document.querySelector('#updateStudentForm [name="updateLastName"]').value = lastName;
            document.querySelector('#updateStudentForm [name="updateUsername"]').value = username;
            document.querySelector('#updateStudentForm [name="updateUserType"]').value = userType;
            document.querySelector('#updateStudentForm [name="updateEmail"]').value = email;
            document.querySelector('#updateStudentForm [name="updateDiscordName"]').value = discordName;


            if (userType === 'student') {
            // Fetch and populate fields specific to students

            
                document.querySelector('#updateStudentForm [name="updateGender"]').value = gender; // Example: Fetch and set the gender
                document.getElementById('updateHispanicLatino').value = hispanicLatino; // Example: Fetch and set Hispanic/Latino status
                document.querySelector('#updateRace').value = race; // Example: Fetch and set the race
                document.getElementById('updateUsCitizen').checked = uscitizen; // Example: Fetch and set the U.S. Citizen checkbox
                document.getElementById('updatefirstGeneration').checked = firstgen; // Example: Fetch and set the First Generation checkbox
                document.getElementById('updatedob').value = dob; // Example: Fetch and set the Date of Birth
                document.getElementById('updateGpa').value = gpa; // Example: Fetch and set the GPA
                document.getElementById('updateMajor').value = major; // Example: Fetch and set the major
                document.getElementById('updateMinor1').value = minor1; // Example: Fetch and set minor 1
                document.getElementById('updateMinor2').value = minor2; // Example: Fetch and set minor 2
                document.getElementById('updateExpectedGraduation').value = expectedgrad; // Example: Fetch and set expected graduation
                document.getElementById('updateSchool').value = school; // Example: Fetch and set the school
                document.getElementById('updateClassification').value = classification; // Example: Fetch and set the classification
                document.getElementById('updatePhone').value = phone; // Example: Fetch and set the phone
                document.getElementById('updateStudentType').value = studentType; // Example: Fetch and set the student type


                // Display the update form for students
                document.getElementById('updateStudentForm').style.display = 'block';
                document.getElementById('studentField').style.display = 'block';
            }
            else{
                document.getElementById('updateStudentForm').style.display = 'block';
                document.getElementById('studentField').style.display = 'none';
            }

            


            
        }
   
      
        function toggleRemove(uin) {

            var form = document.getElementById("removeAccessForm");
            var removeUIN = document.getElementById("removeUIN");
            removeUIN.value = uin;
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
            studentFields.style.display = (userType === "student") ? "block" : "none";
        }

        

        function logout() {
            // Redirect to the logout page
            window.location.href = "logout.php";
        }
    </script>

</body>

</html>
