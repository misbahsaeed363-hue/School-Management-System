<?php

session_start();

// include db
include "connection.php";

if (isset($_REQUEST['delete'])) {

        $id = $_REQUEST['delete'];

        $sql = "DELETE FROM students
        WHERE sid = '$id'";
        $result = $conn->query($sql);

        if ($result) {

                session_start();
                $_SESSION['toast'] = [
                        "type" => "success",
                        "title" => "Student Deleted",
                        "message" => "Student successfully deleted from database"
                ];


                header("Location: students.php");
                exit;
        } else {

                session_start();
                $_SESSION['toast'] = [
                        "type" => "error",
                        "title" => "Error",
                        "message" => "Something went wrong"
                ];

                header("Location: students.php");
                exit();
        }
}
