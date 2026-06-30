<?php


session_start();

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

$loginTeacher_id = $_SESSION['tid'];

$sql = "SELECT COUNT(*) AS Assigned_classes , section_name
FROM sections 
WHERE teacher_id = 23";

$result = $conn->query($sql);

$data = [];


while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "data" => $data,
    "loginTeacher" => $loginTeacher_id
]);
