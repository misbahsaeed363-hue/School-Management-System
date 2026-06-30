<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

header("Content-Type: application/json");

// Check login

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized Access"
    ]);

    exit();
}

$user_id = $_SESSION['user_id'];

// Receive data

$phone = $conn->real_escape_string($_POST['phone']);
$address = $conn->real_escape_string($_POST['address']);


// ==========================
// Get current image
// ==========================

$getImage = "SELECT images
             FROM students
             WHERE user_id = '$user_id'";

$result = $conn->query($getImage);

$row = $result->fetch_assoc();

$imagePath = $row['images'];


// ==========================
// Upload new image if exists
// ==========================

if (
    isset($_FILES['profile_image']) &&
    $_FILES['profile_image']['error'] == 0
) {

    $folder = "uploads/student_images/";

    // Create unique filename

    $fileName = time() . "_" . basename($_FILES['profile_image']['name']);

    $targetPath = $folder . $fileName;

    // Upload image

    if (
        move_uploaded_file(
            $_FILES['profile_image']['tmp_name'],
            $_SERVER['DOCUMENT_ROOT'] .
            "/school_management_system/" .
            $targetPath
        )
    ) {

        // Delete old image (optional)

        if (
            !empty($imagePath) &&
            file_exists(
                $_SERVER['DOCUMENT_ROOT'] .
                "/school_management_system/" .
                $imagePath
            )
        ) {

            unlink(
                $_SERVER['DOCUMENT_ROOT'] .
                "/school_management_system/" .
                $imagePath
            );
        }

        // Save new path

        $imagePath = $targetPath;
    }
}


// ==========================
// Update student table
// ==========================

$updateStudent = "UPDATE students SET

                    phone = '$phone',
                    address = '$address',
                    images = '$imagePath'

                  WHERE user_id = '$user_id'";


// ==========================
// Execute student update
// ==========================

if ($conn->query($updateStudent)) {

    // ==========================
    // Update users table image
    // ==========================

    $updateUser = "UPDATE users SET

                        images = '$imagePath'

                    WHERE id = '$user_id'";

    $conn->query($updateUser);

    echo json_encode([
        "success" => true,
        "message" => "Profile updated successfully"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Failed to update profile"
    ]);
}

?>