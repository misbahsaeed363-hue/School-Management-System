<?php
session_start();
// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT users.id AS id, users.images AS images, 
    users.name AS name, users.email AS email, users.password AS password, users.role AS role, teachers.tid AS tid FROM users LEFT JOIN teachers
    ON users.id = teachers.user_id
    WHERE users.email='$email'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "User not found";
        exit;
    }

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_image'] = $user['images'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['tid'] = $user['tid'];

        // ROLE REDIRECT
        if ($user['role'] == "admin") {

            $_SESSION['toast'] = [
                "type" => "success",
                "title" => "Login Successfull",
                "message" => "Successfully login to your Profile"
            ];

            header("Location: admin/dashboard.php");
            exit;
        } elseif ($user['role'] == "teacher") {

            $_SESSION['toast'] = [
                "type" => "success",
                "title" => "Login Successfull",
                "message" => "Successfully login to your Profile"
            ];

            header("Location: teacher/dashboard.php");
            exit;
        } else {

            $_SESSION['toast'] = [
                "type" => "success",
                "title" => "Login Successfull",
                "message" => "Successfully login to your Profile"
            ];

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
