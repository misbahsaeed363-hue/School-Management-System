<?php
session_start();
// include db
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "User not found";
        exit;
    }

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // ROLE REDIRECT
        if ($user['role'] == "admin") {
            header("Location: admin/dashboard.php");
            exit;
        }
        elseif ($user['role'] == "teacher") {
            header("Location: teacher/dashboard.php");
            exit;
        }
        else {
            header("Location: student/dashboard.php");
            exit;
        }

    } else {
        echo "Wrong password";
        exit;
    }

} else {
    echo "Form not submitted properly";
}

?>