<?php
session_start();

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $attendance_date = $_POST['attendance_date'] ?? '';

    $student_ids = $_POST['student_ids'] ?? [];
    $statuses = $_POST['status'] ?? [];
    $remarks_arr = $_POST['remarks'] ?? [];

    if (!empty($student_ids)) {

        foreach ($student_ids as $student_id) {

            $status = $statuses[$student_id] ?? 'Present';

            $remarks = trim($remarks_arr[$student_id] ?? '');

            $sql = "
                INSERT INTO attendance (
                    student_id,
                    attendance_date,
                    status,
                    remarks
                )
                VALUES (
                    '$student_id',
                    '$attendance_date',
                    '$status',
                    '$remarks'
                )
                ON DUPLICATE KEY UPDATE
                    status = '$status',
                    remarks = '$remarks'
            ";

            $conn->query($sql);
        }

        $_SESSION['toast'] = [
            'type' => 'success',
            'title' => 'Success',
            'message' => 'Attendance saved successfully'
        ];

    } else {

        $_SESSION['toast'] = [
            'type' => 'error',
            'title' => 'Error',
            'message' => 'No students found'
        ];
    }
}

header("Location: attendance.php");
exit;
?>