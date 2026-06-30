<?php

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

$section_id = $_GET['secId'] ?? '';
$page = $_GET['page'] ?? 1;
$search = $_GET['search'] ?? '';
$gender = $_GET['gender'] ?? 'All';

$limit = 10;
$offset = ($page - 1) * $limit;

$where = "WHERE students.section_id = '$section_id'";

if (!empty($search)) {

    $where .= "
    AND (
        students.sid LIKE '%$search%'
        OR students.name LIKE '%$search%'
        OR students.email LIKE '%$search%'
    )";
}

if ($gender != "All") {

    $where .= "
    AND students.gender = '$gender'";
}

$countSql = "
SELECT COUNT(*) as total
FROM students
$where
";

$countResult = $conn->query($countSql);
$totalRows = $countResult->fetch_assoc()['total'];

$totalPages = ceil($totalRows / $limit);

$sql = "
SELECT
students.*,
sections.section_name,
sections.class_id
FROM students
LEFT JOIN sections
ON students.section_id = sections.sec_id

$where

LIMIT $limit OFFSET $offset
";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode([
    "students" => $data,
    "totalPages" => $totalPages
]);

?>