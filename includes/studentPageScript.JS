//Maya Lotfy 
//UIN: 730001793


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
        window.location.href = "student_page.php?deactivate=true";
        alert("Account Deactivated");
        window.location.href = "logout.php";
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
    window.location.href = "student_page.php?updateCredentials=true?newUsername=" + encodeURIComponent(newUsername) + "&newPassword=" + encodeURIComponent(newPassword);
}


function logout() {
    // Redirect to the logout page
    window.location.href = "logout.php";
}