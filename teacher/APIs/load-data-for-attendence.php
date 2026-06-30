<?php

// include connection
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

// header('Content-Type: application/json');

if (
    isset($_REQUEST['date']) && isset($_REQUEST['section'])
) {

    $date = $_REQUEST['date'];
    $section = $_REQUEST['section'];


    session_start();

    $teacher_id = $_SESSION['tid'];
    $check = " SELECT * FROM sections WHERE sec_id='$section' AND teacher_id='$teacher_id' ";

    $result1 = $conn->query($check);

    if ($result1->num_rows == 0) {

        exit;
    }

    $sql = "SELECT s.sid, s.images, s.name, a.status, sec.class_id, sec.section_name
    FROM students s
    LEFT JOIN attendance a
    ON s.sid = a.student_id
    AND a.attendance_date = '$date'
    LEFT JOIN sections sec
    ON s.section_id = sec.sec_id
    WHERE s.section_id = '$section';";
    $result = $conn->query($sql);

    $student = [];

    while ($row = $result->fetch_assoc()) {
        $student[] = $row;
    };

    echo json_encode($student);
}
