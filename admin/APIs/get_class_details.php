<?php

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

$class_id = (int) $_GET['class_id'];

$sql = "SELECT 
sections.section_name,
teachers.name AS teacher_name,
COUNT(students.sid) AS total_students

FROM sections

JOIN teachers
ON sections.teacher_id = teachers.tid

LEFT JOIN students
ON students.section_id = sections.sec_id

WHERE sections.class_id = '$class_id'

GROUP BY sections.sec_id, sections.section_name, teachers.name
";

$result = $conn->query($sql);

$sections = [];

while ($row = $result->fetch_assoc()) {

    $sections[] = $row;
}

echo json_encode([
    
    "class" => $class_id,
    "sections" => $sections
]);
