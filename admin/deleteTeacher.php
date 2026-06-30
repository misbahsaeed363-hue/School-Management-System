<?php

session_start();

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

if (isset($_REQUEST['delete'])) {

    $id = $_REQUEST['delete'];

    $sql = "DELETE FROM teachers
        WHERE tid = '$id'";
    $result = $conn->query($sql);

    if ($result) {

        session_start();
        $_SESSION['toast'] = [
            "type" => "success",
            "title" => "Teacher Deleted",
            "message" => "Teacher successfully deleted from database"
        ];


        header("Location: teachers.php");
        exit;
    } else {

        session_start();
        $_SESSION['toast'] = [
            "type" => "error",
            "title" => "Error",
            "message" => "Something went wrong"
        ];

        header("Location: teachers.php");
        exit();
    }
}
