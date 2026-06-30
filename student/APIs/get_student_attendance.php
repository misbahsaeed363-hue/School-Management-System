<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "attendance" => [],
        "currentPage" => 1,
        "totalPages" => 0
    ]);

    exit;
}

$user_id = $_SESSION['user_id'];

$studentQuery = "
    SELECT sid
    FROM students
    WHERE user_id = '$user_id'
";

$studentResult = $conn->query($studentQuery);

if ($studentResult->num_rows == 0) {

    echo json_encode([
        "attendance" => [],
        "currentPage" => 1,
        "totalPages" => 0
    ]);

    exit;
}

$student = $studentResult->fetch_assoc();

$student_id = $student['sid'];

$month = $_GET['month'] ?? 'All';
$year = $_GET['year'] ?? 'All';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$limit = 10;
$offset = ($page - 1) * $limit;

$where = " WHERE student_id = '$student_id' ";

if ($month != "All") {
    $where .= " AND MONTH(attendance_date) = '$month' ";
}

if ($year != "All") {
    $where .= " AND YEAR(attendance_date) = '$year' ";
}

$countQuery = "
    SELECT COUNT(*) AS total
    FROM attendance
    $where
";

$countResult = $conn->query($countQuery);

$totalRecords = $countResult->fetch_assoc()['total'];

$totalPages = ceil($totalRecords / $limit);

$query = "
    SELECT *
    FROM attendance
    $where
    ORDER BY attendance_date DESC
    LIMIT $limit OFFSET $offset
";

$result = $conn->query($query);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "attendance" => $data,
    "currentPage" => $page,
    "totalPages" => $totalPages,
    "totalRecords" => $totalRecords
]);

?>