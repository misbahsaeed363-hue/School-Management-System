<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

$tid = $_SESSION['tid'];

$phone = $_POST['phone'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$address = $_POST['address'];

$imagePath = "";

if (!empty($_FILES['image']['name'])) {

    $fileName = time() . "_" . $_FILES['image']['name'];

    $imagePath = "uploads/" . $fileName;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/" . $imagePath
    );

    $sql = "
    UPDATE teachers
    SET
    phone='$phone',
    gender='$gender',
    date_of_birth='$dob',
    address='$address',
    images='$imagePath'
    WHERE tid='$tid'
    ";
} else {

    $sql = "
    UPDATE teachers
    SET
    phone='$phone',
    gender='$gender',
    date_of_birth='$dob',
    address='$address'
    WHERE tid='$tid'
    ";
}

$result = $conn->query($sql);

echo json_encode([
    "success" => $result
]);
