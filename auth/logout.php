<?php
    // Start the session to access current user data
    session_start();
    // Remove all session data and log the user out
    session_destroy();

    // Redirect the user to the home page
    header("Location: ../index.php");
    exit();
?>