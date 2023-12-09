//Maya Lotfy 
//UIN: 730001793


//toggle the visibility of student's profile

function toggleProfile() {
    var profile = document.getElementById("profile");
    profile.style.display = (profile.style.display === "none") ? "block" : "none";

}

// toggle the visibility of the update form

function toggleUpdateForm() {
    var updateForm = document.getElementById("updateForm");
    updateForm.style.display = (updateForm.style.display === "none") ? "block" : "none";
}


// updating student's information
function updateProfileFields() {
    var formData = new FormData(document.getElementById("updateForm"));

    //data to URL-encoded string
    var urlSearchParams = new URLSearchParams(formData);
    var encodedFormData = urlSearchParams.toString();

    // profile update
    window.location.href = "student_page.php?updateProfile=true&" + encodedFormData;
}

//cancel updating student information

function cancelUpdateStudent() {
    document.getElementById('updateForm').style.display = 'none';

}

//cancel updating login credentials
function cancelCredentials() {
    document.getElementById('credentialsForm').style.display = 'none';

}

// confirm deactivation of the student's account
function confirmDeactivate() {
    var confirmation = confirm("Are you sure you want to deactivate your account?");
    if (confirmation) {
        // If user clicks "Yes", submit the form and call removeAccess()
        window.location.href = "student_page.php?deactivate=true";
        alert("Account Deactivated");
        window.location.href = "logout.php";
    }

}

// toggle the visibility of the login credentials form
function toggleCredentialsForm() {
    var credentialsForm = document.getElementById("credentialsForm");
    credentialsForm.style.display = (credentialsForm.style.display === "none") ? "block" : "none";
}


function submitCredentialsForm() {
    var newUsername = document.getElementById("newUsername2").value;
    var newPassword = document.getElementById("newPassword").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    if (newPassword !== confirmPassword) {
        alert("Passwords do not match.");
        return;
    }
    document.getElementById("hiddenNewUsername").value = newUsername;
    document.getElementById("hiddenNewPassword").value = newPassword;
    document.getElementById("credentialsForm").submit();

}

//toggle the visibility of the password 
function togglePasswordVisibility(fieldId) {
    var passwordField = document.getElementById(fieldId);
    var toggleButton = document.querySelector('.toggle-password[data-target-field="' + fieldId + '"] i');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.classList.remove('fa-eye');
        toggleButton.classList.add('fa-eye-slash');
    } else {
        passwordField.type = "password";
        toggleButton.classList.remove('fa-eye-slash');
        toggleButton.classList.add('fa-eye');
    }
}


document.addEventListener("DOMContentLoaded", function () {
    var toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var fieldId = button.dataset.targetField;
            togglePasswordVisibility(fieldId);
        });
    });
});


function logout() {
    // Redirect to the logout page
    window.location.href = "logout.php";
}