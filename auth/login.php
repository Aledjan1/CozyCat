<?php 
    session_start();

    include "../includes/db.php";

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("
        SELECT usersID, name, lastname, email, password, role
        FROM users
        WHERE email = ?
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = (int)$row['usersID'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_role'] = $row['role'];

            header("Location: ../index.php");
            exit;
        }
    }

    $_SESSION['login_error'] = "Incorrect email or password.";
    header ("Location: ../index.php?login=error");
    exit;
?>