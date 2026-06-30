<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT
            s.sid,
            s.images,
            s.name,
            s.age,
            s.email,
            s.phone,
            s.gender,
            s.address,
            s.status,
            c.class_name,
            sec.section_name

        FROM students s

        LEFT JOIN sections sec
            ON s.section_id = sec.sec_id

        LEFT JOIN classes c
            ON sec.class_id = c.id

        WHERE s.user_id = '$user_id '";

$result = $conn->query($sql);

$student = $result->fetch_assoc();


header("Content-Type: application/json");

echo json_encode($student);

?>