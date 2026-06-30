<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "months" => [],
        "years" => []
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
        "months" => [],
        "years" => []
    ]);

    exit;
}

$student = $studentResult->fetch_assoc();

$student_id = $student['sid'];

$query = "
    SELECT DISTINCT
        YEAR(attendance_date) AS year,
        MONTH(attendance_date) AS month
    FROM attendance
    WHERE student_id = '$student_id'
    ORDER BY attendance_date DESC
";

$result = $conn->query($query);

$months = [];
$years = [];

while ($row = $result->fetch_assoc()) {

    $month = str_pad($row['month'], 2, '0', STR_PAD_LEFT);

    if (!in_array($month, $months)) {
        $months[] = $month;
    }

    if (!in_array($row['year'], $years)) {
        $years[] = $row['year'];
    }
}

echo json_encode([
    "months" => $months,
    "years" => $years
]);
?>