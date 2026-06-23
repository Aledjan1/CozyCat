<?php
    // Start session to save user login data and error messages
    session_start();

    // Connect to the database
    include "../includes/db.php";

    // Get registration form data
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check that all form fields are filled in
    if (empty($name) || empty($lastname) || empty($email) || empty($password)) {
        header("Location: ../index.php?register=empty");
        exit;
    }

    // Check if this email already exists in the database
    $checkStmt = $conn->prepare("SELECT usersID FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    // Stop registration if the email is already registered
    if ($result && $result->num_rows > 0) {
        $_SESSION['register_error'] = "This email is already registered.";
        header("Location: ../index.php?register=error");
        exit;
    }

    // Hash password before saving it to the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Add new user to the users table
    $stmt = $conn->prepare("
        INSERT INTO users (name, lastname, email, password)
        VALUES (?, ?, ?, ?)
    ");

    // Bind values and execute the query
    $stmt->bind_param("ssss", $name, $lastname, $email, $hashedPassword);
    $stmt->execute();

    // Save new user data in the session after registration
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_role'] = 'user';

    // Redirect user to the home page
    header("Location: ../index.php");
    exit;
?>