//Maya Lotfy 
//UIN: 730001793
function toggleForm() {
    var form = document.getElementById("addUserForm");
    form.style.display = (form.style.display === "none") ? "block" : "none";
    
}

function cancelAddUser() {
    var form = document.getElementById("addUserForm");
    form.style.display = "none";
}

function cancelUpdateStudent() {
    document.getElementById('updateStudentForm').style.display = 'none';

}

function cancelUpdateAdmin() {
    document.getElementById('updateAdminForm').style.display = 'none';

}

function toggleView() {
    var table = document.getElementById("userTable");
    table.style.display = (table.style.display === "none") ? "table" : "none";
    
}

function toggleUpdateAdminForm(uin, firstName, middleInitial, lastName, username, userType, email, discordName){
    var form = document.getElementById("updateAdminForm");

    document.querySelector('#updateAdminForm [name="updateAdminUIN"]').value = uin;
    document.querySelector('#updateAdminForm [name="updateAdminFirstName"]').value = firstName;
    document.querySelector('#updateAdminForm [name="updateAdminMiddleInitial"]').value = middleInitial;
    document.querySelector('#updateAdminForm [name="updateAdminLastName"]').value = lastName;
    document.querySelector('#updateAdminForm [name="updateAdminUsername"]').value = username;
    document.querySelector('#updateAdminForm [name="updateAdminUserType"]').value = userType;
    document.querySelector('#updateAdminForm [name="updateAdminEmail"]').value = email;
    document.querySelector('#updateAdminForm [name="updateAdminDiscordName"]').value = discordName;
    form.style.display = (form.style.display === "none") ? "block" : "none";


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

function toggleStudents() {
    var table = document.getElementById("studentTable");
    table.style.display = (table.style.display === "none") ? "table" : "none";
}

function logout() {
    // Redirect to the logout page
    window.location.href = "logout.php";
}