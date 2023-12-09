<?php
//Maya Lotfy 
//UIN: 730001793


session_start();

// Destroy all session data
session_destroy();

// Redirect to the login page
header("Location: loginpage.php");
exit();
?>