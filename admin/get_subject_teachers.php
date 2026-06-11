<?php

// include connection
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

// TO GET SUBJECT WITH TEACHER NAME
if (isset($_GET['section_id'])) {

    $sec_id = $_GET['section_id'];

    $sql = "SELECT teachers.name , subjects.subject_name
    FROM class_subjects
    JOIN subjects ON class_subjects.subject_id = subjects.sub_id
    JOIN teachers ON teachers.tid = class_subjects.teacher_id
    WHERE class_subjects.section_id = '$sec_id'";
    $result = $conn->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
