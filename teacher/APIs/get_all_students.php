<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

$teacher_id = $_SESSION['tid'];

$page = $_GET['page'] ?? 1;
$search = $_GET['search'] ?? '';
$gender = $_GET['gender'] ?? 'All';

$limit = 10;
$offset = ($page - 1) * $limit;

$where = "
WHERE
(
    sec.teacher_id = '$teacher_id'

    OR

    sec.sec_id IN
    (
        SELECT section_id
        FROM class_subjects
        WHERE teacher_id = '$teacher_id'
    )
)
";

if (!empty($search)) {

    $where .= "
    AND (
        s.sid LIKE '%$search%'
        OR s.name LIKE '%$search%'
        OR s.email LIKE '%$search%'
    )";
}

if ($gender != "All") {

    $where .= "
    AND s.gender = '$gender'";
}

$countSql = "
SELECT COUNT(DISTINCT s.sid) as total

FROM students s

INNER JOIN sections sec
ON s.section_id = sec.sec_id

$where
";

$countResult = $conn->query($countSql);
$totalRows = $countResult->fetch_assoc()['total'];

$totalPages = ceil($totalRows / $limit);

$sql = "
SELECT DISTINCT
    s.*,
    sec.section_name,
    sec.class_id

FROM students s

INNER JOIN sections sec
ON s.section_id = sec.sec_id

$where

LIMIT $limit OFFSET $offset
";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "students" => $data,
    "totalPages" => $totalPages
]);
