<?php
if (isset($_REQUEST['classId'])) {

    // include connection
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

    $classId = $_REQUEST['classId'];

    $sql = "SELECT * FROM sections
    WHERE class_id = '$classId'";
    $result = $conn->query($sql);
    $section = [];

    while ($row = $result->fetch_assoc()) {
        $section[] = $row;
    }

    echo json_encode($section);
}
