<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

// Get Values
$id = $_REQUEST['id'] ?? '';

$name = trim($_REQUEST['name']);
$email = trim($_REQUEST['email']);
$phone = trim($_REQUEST['phone']);
$gender = trim($_REQUEST['gender']);
$date_of_birth = trim($_REQUEST['date_of_birth']);
$address = trim($_REQUEST['address']);
$qualification = trim($_REQUEST['qualification']);
$experience_years = trim($_REQUEST['experience_years']);
$salary = trim($_REQUEST['salary']);
$status = trim($_REQUEST['status']);
$marital_status = trim($_REQUEST['marital_status']);
$joining_date = $_REQUEST['joining_date'];

$error = [];

// VALIDATIONS

if (empty($name)) {
    $error[] = "Name is required";
}

if (empty($email)) {
    $error[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Invalid email format";
}

if (empty($phone)) {
    $error[] = "Phone is required";
} elseif (!preg_match("/^[0-9]{11}$/", $phone)) {
    $error[] = "Phone must contain 11 digits";
}

if (empty($qualification)) {
    $error[] = "Qualification is required";
}

if (empty($experience_years)) {
    $error[] = "Experience is required";
}

if (empty($salary)) {
    $error[] = "Salary is required";
}

if (empty($address)) {
    $error[] = "Address is required";
}

if (empty($gender)) {
    $error[] = "Gender is required";
}

if (empty($status)) {
    $error[] = "Status is required";
}

if (!empty($error)) {

    foreach ($error as $err) {
        echo $err . "<br>";
    }

    exit();
}


// ================= UPDATE =================

if (!empty($id)) {

    if (!empty($_FILES['image']['name'])) {

        $file_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $folder = "uploads/" . $file_name;

        move_uploaded_file($tmp_name, $folder);
    } else {

        $folder = $_POST['old_image'];
    }

    $sql = "UPDATE teachers SET

        images='$folder',
        name='$name',
        email='$email',
        phone='$phone',
        gender='$gender',
        date_of_birth='$date_of_birth',
        address='$address',
        qualification='$qualification',
        experience_years='$experience_years',
        salary='$salary',
        status='$status',
        marital_status='$marital_status',
        joining_date = '$joining_date'

        WHERE tid='$id'
    ";

    $result = $conn->query($sql);

    $teacher = $conn->query("SELECT user_id FROM teachers WHERE tid='$id'");
    $teacherRow = $teacher->fetch_assoc();

    $user_id = $teacherRow['user_id'];

    if ($user_id) {

        $conn->query("
            UPDATE users
            SET name='$name', email='$email'
            WHERE id='$user_id'
        ");
    }

    if ($result) {

        $_SESSION['toast'] = [
            "type" => "success",
            "title" => "Teacher Updated",
            "message" => "Teacher updated successfully"
        ];
    } else {

        $_SESSION['toast'] = [
            "type" => "error",
            "title" => "Error",
            "message" => "Something went wrong"
        ];
    }

    header("Location: teachers.php");
    exit();
}


// ================= ADD =================

$file_name = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];

$folder = "uploads/" . $file_name;

move_uploaded_file($tmp_name, $folder);

// Login Password
$plainPassword = "tea" . rand(1000, 9999);

$hashedPassword = password_hash(
    $plainPassword,
    PASSWORD_BCRYPT
);

// User Insert
$userSql = "
INSERT INTO users
(images,name,email,password,role)
VALUES
('$folder','$name','$email','$hashedPassword','teacher')
";

$conn->query($userSql);

$user_id = $conn->insert_id;


// Teacher Insert
$sql = "
INSERT INTO teachers(

    images,
    name,
    email,
    phone,
    gender,
    date_of_birth,
    address,
    qualification,
    experience_years,
    salary,
    status,
    marital_status,
    user_id,
    joining_date
)
VALUES(

    '$folder',
    '$name',
    '$email',
    '$phone',
    '$gender',
    '$date_of_birth',
    '$address',
    '$qualification',
    '$experience_years',
    '$salary',
    '$status',
    '$marital_status',
    '$user_id',
    '$joining_date'
)
";

$result = $conn->query($sql);

if ($result) {

    $_SESSION['toast'] = [
        "type" => "success",
        "title" => "Teacher Added",
        "message" => "Password: $plainPassword"
    ];
} else {

    $_SESSION['toast'] = [
        "type" => "error",
        "title" => "Error",
        "message" => "Something went wrong"
    ];
}

header("Location: teachers.php");
exit();
