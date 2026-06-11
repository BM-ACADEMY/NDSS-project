<?php
// Database configuration
include './config/dbconnect.php'; 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = $conn->real_escape_string($_POST['slider_name']);
    $description = $conn->real_escape_string($_POST['description']);
    
    // Handling media upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create directory if it doesn't exist
    }

    $slider_image = $target_dir . basename($_FILES["slider_image"]["name"]);
    $uploadOk = true;

    // Validate the uploaded file (check size, file type)
    $mediaFileType = strtolower(pathinfo($slider_image, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["slider_image"]["tmp_name"]) || strpos(mime_content_type($_FILES["slider_image"]["tmp_name"]), 'video/') === 0;

    if ($check === false) {
        echo "File is not a valid image or video.";
        $uploadOk = false;
    }

    // Check file size (optional limit, e.g., 10MB for videos)
    if ($_FILES["slider_image"]["size"] > 10000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = false;
    }

    // Allow only certain file formats (jpg, png, jpeg, gif, mp4, mov)
    if (!in_array($mediaFileType, ['jpg', 'png', 'jpeg', 'gif', 'mp4', 'mov'])) {
        echo "Sorry, only JPG, JPEG, PNG, GIF, MP4 & MOV files are allowed.";
        $uploadOk = false;
    }

    // If file is valid, move the file to the target directory
    if ($uploadOk && move_uploaded_file($_FILES["slider_image"]["tmp_name"], $slider_image)) {
        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO slider (name, slider_image,description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $slider_image, $description);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading the media.";
    }
}

$conn->close();

?>
