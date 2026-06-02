<?php

include "connection.php";

if (isset($_GET['section_id']) &&  isset($_GET['class_id'])) {

    $section_id = $_GET['section_id'];
    $class_id = $_GET['class_id'];

    // students count
    $sql1 = "SELECT COUNT(*) AS total_students FROM students WHERE section_id = '$section_id'";
    $result1 = $conn->query($sql1);
    $row1 =  $result1->fetch_assoc();
    $total_students = $row1['total_students'];

    // section capacity and class id
    $sql2 = "SELECT capacity, class_id FROM sections WHERE sec_id = '$section_id' LIMIT 1";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $section_capacity = $row2['capacity'];
    $class = $row2['class_id'];

    // percentage
    $percent = (($total_students / $section_capacity) * 100);

    // CLASS TEACHER NAME
    $sql3 = "SELECT teachers.name FROM sections JOIN teachers ON sections.teacher_id = teachers.tid WHERE sections.sec_id = '$section_id' LIMIT 1";
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch_assoc();
    $class_teacher_name = $row3['name'];

    // TOTAL SUBJECTS
    $sql4 = "SELECT COUNT(*) AS total_subjects FROM class_subjects WHERE section_id = '$section_id'";
    $result4 = $conn->query($sql4);
    $row4 = $result4->fetch_assoc();
    $total_subjects = $row4['total_subjects'];


    // send response
    echo json_encode([
        "students" => $total_students,
        "capacity" => $section_capacity,
        "percent" => $percent,
        "class_teacher" => $class_teacher_name,
        "total_subjects" => $total_subjects,
        "class" => $class
    ]);
}



