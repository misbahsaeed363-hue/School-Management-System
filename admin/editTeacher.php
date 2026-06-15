<?php

// FOR UPDATE STUDENT INFO
if (isset($_REQUEST['edit'])) {

    // include db
    include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

    $id = $_REQUEST['edit'];

    $sql = "SELECT * FROM teachers 
        JOIN sections ON teachers.tid = sections.teacher_id 
        WHERE tid='$id'";
    $result = $conn->query($sql);

    $teacher = $result->fetch_assoc();

    $teacher_id = $teacher['tid'];
    $teacher_img = $teacher['images'];
    $teacher_name = $teacher['name'];
    $teacher_dob = $teacher['date_of_birth'];
    $teacher_email = $teacher['email'];
    $teacher_phone_num = $teacher['phone'];
    $teacher_address = $teacher['address'];
    $teacher_status = $teacher['status'];
    $teacher_gender = $teacher['gender'];
    $teacher_qualification = $teacher['qualification'];
    $teacher_experience_years = $teacher['experience_years'];
    $teacher_salary = $teacher['salary'];
    $teacher_mariral_status = $teacher['marital_status'];

    // send response
    echo json_encode([

        "teacher_id" => $teacher_id,
        "teacher_img" => $teacher_img,
        "teacher_name" => $teacher_name,
        "teacher_dob" => $teacher_dob,
        "teacher_email" => $teacher_email,
        "teacher_phone_num" => $teacher_phone_num,
        "teacher_address" => $teacher_address,
        "teacher_status" => $teacher_status,
        "teacher_gender" => $teacher_gender,
        "teacher_qualification" => $teacher_qualification,
        "teacher_experience_years" =>  $teacher_experience_years,
        "teacher_salary" => $teacher_salary,
        "teacher_mariral_status" => $teacher_mariral_status
    ]);
}
