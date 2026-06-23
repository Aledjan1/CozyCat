<?php 
    // Start session to store user data and error messages
    session_start();

    // Connect to the database
    include "../includes/db.php";

    // Get email and password from the login form
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare SQL query to find the user by email
    $stmt = $conn->prepare("
        SELECT usersID, name, lastname, email, password, role
        FROM users
        WHERE email = ?
    ");

    // Bind the email and execute the query
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get query result from the database
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

         // Convert the result into an associative array
        if (password_verify($password, $row['password'])) {
            // Save user information in the session
            $_SESSION['user_id'] = (int)$row['usersID'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_role'] = $row['role'];

            // Redirect the user to the home page
            header("Location: ../index.php");
            exit;
        }
    }
    // Store login error message in the session
    $_SESSION['login_error'] = "Incorrect email or password.";

    // Redirect back if login fails
    header ("Location: ../index.php?login=error");
    exit;
?>