<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

$tid = $_SESSION['tid'];

$sql = "
SELECT *
FROM teachers
WHERE tid='$tid'
";

$result = $conn->query($sql);

$data = $result->fetch_assoc();

$assignments = [];

$sql1 = "
SELECT
    c.class_name,
    s.section_name,
    sub.subject_name,
    sub.subject_code
FROM class_subjects cs

INNER JOIN sections s
    ON cs.section_id = s.sec_id

INNER JOIN classes c
    ON s.class_id = c.id

INNER JOIN subjects sub
    ON cs.subject_id = sub.sub_id

WHERE cs.teacher_id = '$tid' OR s.teacher_id = '$tid'
GROUP BY s.teacher_id
ORDER BY c.class_name, s.section_name
";

$result = $conn->query($sql1);

while ($row = $result->fetch_assoc()) {
    $assignments[] = $row;
}

$classCount = $conn->query("
SELECT COUNT(DISTINCT s.class_id) total
FROM class_subjects cs
INNER JOIN sections s
ON cs.section_id=s.sec_id
WHERE cs.teacher_id='$tid'
")->fetch_assoc();

$subjectCount = $conn->query("
SELECT COUNT(DISTINCT subject_id) total
FROM class_subjects
WHERE teacher_id='$tid'
")->fetch_assoc();

$studentCount = $conn->query("
SELECT COUNT(DISTINCT st.sid) total

FROM students st

INNER JOIN sections s
ON st.section_id=s.sec_id

INNER JOIN class_subjects cs
ON cs.section_id=s.sec_id

WHERE cs.teacher_id='$tid' OR s.teacher_id = '$tid'
")->fetch_assoc();

// echo json_encode($data);

echo json_encode([
    "teacher" => $data,
    "assignments" => $assignments,

    "assigned_classes" =>
    $classCount['total'],

    "assigned_subjects" =>
    $subjectCount['total'],

    "total_students" =>
    $studentCount['total']
]);
