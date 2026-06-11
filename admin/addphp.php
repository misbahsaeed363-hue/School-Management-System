<?php

session_start();

// connect db
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

// get values
$id = $_REQUEST['sid'];
$name = trim($_REQUEST['sname']);
$email = trim($_REQUEST['semail']);
$age = trim($_REQUEST['sage']);
$phone = trim($_REQUEST['sphone']);
$class = trim($_REQUEST['sclass']);
$address = trim($_REQUEST['saddress']);
$status = trim($_REQUEST['sstatus']);
$gender = $_REQUEST['sgender'];
$section = $_REQUEST['ssection'];

$error = [];

// NAME VALIDATION
if (empty($name)) {
        $error[] = "Name is required";
} elseif (strlen($name) < 3) {
        $error[] = "Name must be at least 3 characters";
}

// EMAIL VALIDATION
if (empty($email)) {
        $error[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Invalid email format";
}

// AGE VALIDATION
if (empty($age)) {
        $error[] = "Age is required";
} elseif (!filter_var($age, FILTER_VALIDATE_INT)) {
        $error[] = "Age must be a number";
}

// PHONE VALIDATION
if (empty($phone)) {
        $error[] = "Phone is required";
} elseif (!preg_match("/^[0-9]{11}$/", $phone)) {
        $error[] = "Phone must contain 11 digits";
}

// CLASS VALIDATION
if (empty($class)) {
        $error[] = "Please select a class";
}

// ADDRESS VALIDATION
if (empty($address)) {
        $error[] = "Address is required";
}

// GENDER VALIDATION
if (empty($gender)) {
        $error[] = "Please select gender";
}

// STATUS VALIDATION
if (empty($status)) {
        $error[] = "Please select status";
}

if (!empty($error)) {

        foreach ($error as $error) {
                echo $error . "<br>";
        }

        exit();
} else {

        if (!empty($_REQUEST['sid'])) {

                if (!empty($_REQUEST['sid'])) {

                        // FOR UPDATE DATA

                        if (!empty($_FILES['image']['name'])) {
                                $file_name = $_FILES['image']['name'];
                                $tmp_name = $_FILES['image']['tmp_name'];
                                $folder = "uploads/" . $file_name;
                                move_uploaded_file($tmp_name, $folder);
                        } else {
                                $folder = $_POST['old_image'];
                        }

                        $sql2 = "UPDATE students SET 
                        images='$folder',
                        name='$name',
                        age='$age',
                        email='$email',
                        phone='$phone',
                        gender='$gender',
                        address='$address',
                        section_id='$section',
                        status='$status'
                        WHERE sid='$id'";

                        $result2 = $conn->query($sql2);

                        $result = $conn->query("SELECT user_id FROM students WHERE sid='$id'");
                        $row = $result->fetch_assoc();
                        $user_id = $row['user_id'];

                        $conn->query("UPDATE users SET email='$email' WHERE id='$user_id'");

                        if ($result2) {

                                // session_start();
                                $_SESSION['toast'] = [
                                        "type" => "success",
                                        "title" => "Student Updated",
                                        "message" => "Student successfully added to database"
                                ];


                                header("Location: students.php");
                                exit();
                        } else {

                                // session_start();
                                $_SESSION['toast'] = [
                                        "type" => "error",
                                        "title" => "Error",
                                        "message" => "Something went wrong"
                                ];

                                header("Location: students.php");
                                exit();
                        }
                }
        } else {

                // for add data

                // For image info
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $tmp_name = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];

                $folder = "uploads/" . $file_name;

                move_uploaded_file($tmp_name, $folder);

                $plainPassword = "stu" . rand(1000, 9999);
                $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

                $userSql = "INSERT INTO users (name, email, password, role)
                VALUES ('$name', '$email', '$hashedPassword', 'student')";

                $conn->query($userSql);

                $user_id = $conn->insert_id;

                $sql = "INSERT INTO students(
                images, name, age, email, phone, gender, address, section_id, status, user_id
                )
                VALUES(
                '$folder', '$name', '$age', '$email', '$phone', '$gender', '$address', '$section', '$status', '$user_id'
                )";

                $result = $conn->query($sql);

                // FOR SHOW TOAST
                if ($result) {
                        // session_start();
                        $_SESSION['toast'] = [
                                "type" => "success",
                                "title" => "Student Added",
                                "message" => "Password: $plainPassword"
                        ];

                        header("Location: students.php");
                        exit();
                } else {

                        // session_start();
                        $_SESSION['toast'] = [
                                "type" => "error",
                                "title" => "Error",
                                "message" => "Something went wrong"
                        ];

                        header("Location: students.php");
                        exit();
                }


                // $sql = "INSERT INTO students(images, name, age, email, phone, gender, address, section_id, status)
                // VALUES('$folder', '$name', '$age', '$email', '$phone', '$gender', '$address', '$section', '$status')";

                // $result = $conn->query($sql);

                // FOR SHOW TOAST
                //         if ($result) {

                //                 session_start();
                //                 $_SESSION['toast'] = [
                //                         "type" => "success",
                //                         "title" => "Student Added",
                //                         "message" => "Student successfully added to database"
                //                 ];

                //                 header("Location: students.php");
                //                 exit();
                //         } else {

                //                 session_start();
                //                 $_SESSION['toast'] = [
                //                         "type" => "error",
                //                         "title" => "Error",
                //                         "message" => "Something went wrong"
                //                 ];

                //                 header("Location: index.php");
                //                 exit();
                //         }
        }
}
