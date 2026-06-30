<?php

// for add section
if (isset($_REQUEST['sclass']) && isset($_REQUEST['sec-name']) && isset($_REQUEST['sec-teacher']) && isset($_REQUEST['sec-capacity'])) {

    session_start();

    // connect db
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

    $class = $_REQUEST['sclass'];
    $section = $_REQUEST['sec-name'];
    $teacher = $_REQUEST['sec-teacher'];
    $capacity = $_REQUEST['sec-capacity'];

    $sql = "INSERT INTO sections(class_id, teacher_id, section_name, capacity)
    VALUES('$class', '$teacher', '$section', '$capacity')";
    $result = $conn->query($sql);

    if ($result) {

        $_SESSION['toast'] = [
            "type" => "success",
            "title" => "Section Added",
            "message" => "Section successfully added to database"
        ];

        header("Location: classes.php");
        exit();
    } else {

        $_SESSION['toast'] = [
            "type" => "error",
            "title" => "Error",
            "message" => "Something went wrong"
        ];

        header("Location: classes.php");
        exit();
    }
}
