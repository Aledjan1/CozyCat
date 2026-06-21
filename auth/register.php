<?php
    session_start();

    include "../includes/db.php";

    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($name) || empty($lastname) || empty($email) || empty($password)) {
        header("Location: ../index.php?register=empty");
        exit;
    }

    $checkStmt = $conn->prepare("SELECT usersID FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['register_error'] = "This email is already registered.";
        header("Location: ../index.php?register=error");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO users (name, lastname, email, password)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("ssss", $name, $lastname, $email, $hashedPassword);
    $stmt->execute();

    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_role'] = 'user';

    header("Location: ../index.php");
    exit;
?>