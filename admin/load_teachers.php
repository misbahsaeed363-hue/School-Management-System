<?php
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

header("Content-Type: application/json");

$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$search = $_GET['search'] ?? '';
$class = $_GET['class'] ?? '';
$section = $_GET['section'] ?? '';
$gender = $_GET['gender'] ?? '';

$where = "WHERE 1=1";

$baseQuery = "FROM teachers
LEFT JOIN sections ON teachers.tid = sections.teacher_id";


// SEARCH
if (!empty($search)) {
    $where .= " AND teachers.name LIKE '%$search%'";
}

if (!empty($class) && $class != "All") {
    $where .= " AND sections.class_id = '$class'";
}

if (!empty($section) && $section != "All") {
    $where .= " AND sections.sec_id = '$section'";
}

if (!empty($gender) && $gender != "All") {
    $where .= " AND teachers.gender = '$gender'";
}


// TOTAL RECORDS
$totalQuery = $conn->query("SELECT COUNT(*) as total $baseQuery $where");
$total = $totalQuery->fetch_assoc()['total'];

$totalPages = ceil($total / $limit);


// DATA QUERY
$sql = "SELECT teachers.*, sections.section_name, sections.class_id
        $baseQuery
        $where
        LIMIT $offset, $limit";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


// RESPONSE
echo json_encode([
    "debug" => [
        "search" => $search,
        "class" => $class,
        "section" => $section,
        "gender" => $gender,
        "sql" => $sql
    ],
    "data" => $data,
    "totalPages" => $totalPages,
    "currentPage" => $page,
    "totalRecords" => $total
]);
exit;
