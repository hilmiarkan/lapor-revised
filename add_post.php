<?php
include 'db.php';
session_start();

// Directory where uploaded images will be saved
$target_dir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $is_anonymous = isset($_POST['checkboxName']) ? 1 : 0;
    $user_id = $_SESSION['login_user'];  // Changing 'user_id' to 'login_user'.

    // The path to the image file
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Variable to check if the upload process should continue
    $uploadOk = 1;

    // Get the file extension of the uploaded file
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if the upload process should continue
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // The image has been uploaded.

            $sql = "INSERT INTO laporan (title, content, is_anonymous, user_id, created_at, updated_at, status, imagepath) 
                    VALUES ('$title', '$content', '$is_anonymous', '$user_id', NOW(), NOW(), 'diverifikasi', '$target_file')";
            if (!$conn->query($sql)) {
                die('Error: ' . $conn->error);
            } else {
                header("Location: dashboard_masyarakat.php");  // Redirect user to dashboard after submit.
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$sql = "SELECT laporan.*, users.name
        FROM laporan 
        LEFT JOIN users ON laporan.user_id = users.id
        ORDER BY laporan.created_at DESC";
$result = $conn->query($sql);
?>
