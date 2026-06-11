<?php

// FOR UPDATE STUDENT INFO
if (isset($_REQUEST['edit'])) {

        // include db
        include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

        $id = $_REQUEST['edit'];

        $sql = "SELECT * FROM students 
        JOIN sections ON students.section_id = sections.sec_id 
        WHERE sid='$id'";
        $result = $conn->query($sql);

        $student = $result->fetch_assoc();

        $student_id = $student['sid'];
        $student_img = $student['images'];
        $student_name = $student['name'];
        $student_age = $student['age'];
        $student_email = $student['email'];
        $student_phone_num = $student['phone'];
        $student_address = $student['address'];
        $student_section = $student['section_id'];
        $student_class = $student['class_id'];
        $student_status = $student['status'];
        $student_gender = $student['gender'];

        // send response
        echo json_encode([

                "student_id" => $student_id,
                "student_img" => $student_img,
                "student_name" => $student_name,
                "student_age" => $student_age,
                "student_email" => $student_email,
                "student_phone_num" => $student_phone_num,
                "student_address" => $student_address,
                "student_class" => $student_class,
                "student_section" => $student_section,
                "student_status" => $student_status,
                "student_gender" => $student_gender

        ]);
}
