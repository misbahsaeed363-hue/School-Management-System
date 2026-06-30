<?php

session_start();

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

$loginTeacher_id = $_SESSION['tid'];

$sql = "SELECT DISTINCT
    sec.sec_id,
    sec.class_id,
    sec.section_name, 
    sub.subject_name,
    cs.teacher_id AS subject_teacher,
    sec.teacher_id AS class_teacher
    FROM sections sec
    LEFT JOIN class_subjects cs
    ON sec.sec_id = cs.section_id
    LEFT JOIN subjects sub
    ON cs.subject_id = sub.sub_id
    WHERE cs.teacher_id = '$loginTeacher_id'
   OR sec.teacher_id = '$loginTeacher_id'
";

$result = $conn->query($sql);

$data = [];


while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "data" => $data,
    "loginTeacher" => $loginTeacher_id
]);
