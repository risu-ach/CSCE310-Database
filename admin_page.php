
<!-- 
    Maya Lotfy
    UIN: 730001793

-->
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" type = "text/css" href="../includes/styles_admin_page.css">
    <script src="../includes/adminPageScript.JS" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

    <script>

        function displayMessage(message) {
            alert(message);
            window.location.href = "admin_page.php";
        }

    </script>

    <?php
        include_once 'includes/db.php';
        include_once 'includes/functions_admin.php';


        session_start();
        $userUIN = $_SESSION["userUIN"];
        $userName = $_SESSION["userName"];
    ?>
    <header>

        <h1>Admin Profile</h1>
        <h2>Welcome, <?php echo $userName; ?>, <?php echo $userUIN; ?>!</p>

    </header>

    <div class="button-container">

        <button onclick="toggleForm()">Add New User</button>
        <button onclick="toggleView()">View All Users</button>
        <button onclick = "toggleStudents()">Students' Information</button>
        <button onclick="logout()">logout</button>
    </div>

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

    <!-- Form for Updating students -->


    <form method="post" action="" id="updateStudentForm" style="display: none;">
        <label for="updateUIN">UIN:</label>
        <input type="text" name="updateUIN" id="updateUIN" readonly>

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


    <div id="studentInfoContainer">

        <table id="studentTable" style="display: none;">
            <tr>
                
                <th>UIN</th>
                <th>First Name</th>
                <th>Middle Initial</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>User Type</th>
                <th>Email</th>
                <th>Discord Name</th>
                <th>Gender</th>
                <th>Hispanic/Latino</th>
                <th>Race</th>
                <th>US citizen</th>
                <th>First Generation</th>
                <th>DOB</th>
                <th>GPA</th>
                <th>Major</th>
                <th>Minor1</th>
                <th>Minor2</th>
                <th>Expected Graduation</th>
                <th>School</th>
                <th>Classification</th>
                <th>Phone</th>
                <th>Student Type</th>
                
            </tr>
            <?php toggleStudents(); ?>
            
        </table>

    </div>

    <div class="table-container">
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


    </div>
    <div class="form-container">

        <!-- Form for removing access -->

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

        updateStudent($updateUIN, $updateData);
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


    ?>
</body>
</html>
