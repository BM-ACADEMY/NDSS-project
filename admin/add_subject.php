<?php

// Database connection
$host = 'localhost';
$username = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4"; // Your database password
$dbname = "u571038495_hasforal_ndss"; // Your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Get the name from the form
    $name = $_POST['subject_name'];

    // Handle the file upload (image or video)
    if (isset($_FILES['post_media']) && $_FILES['post_media']['error'] == 0) {
        $media = $_FILES['post_media'];
        $mediaName = $media['name'];
        $mediaTmpName = $media['tmp_name'];
        $mediaError = $media['error'];
        $mediaSize = $media['size'];

        // Define allowed file types (image and video)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov'];

        // Get the file extension
        $mediaExtension = strtolower(pathinfo($mediaName, PATHINFO_EXTENSION));

        // Check if the file type is allowed
        if (in_array($mediaExtension, $allowedExtensions)) {
            // Generate a unique file name to avoid overwriting
            $mediaNewName = uniqid('', true) . '.' . $mediaExtension;
            $mediaDestination = './uploads/' . $mediaNewName;

            // Move the file to the uploads directory
            if (move_uploaded_file($mediaTmpName, $mediaDestination)) {
                // Prepare the SQL query to insert the data into the database
                $query = "INSERT INTO poster (name, post_media) VALUES (?, ?)";
                $stmt = $conn->prepare($query);

                // Check if the prepared statement was successful
                if ($stmt === false) {
                    echo "Error in preparing the SQL query: " . $conn->error;
                    exit;
                }

                // Bind parameters and execute the query
                $stmt->bind_param("ss", $name, $mediaDestination);
                if ($stmt->execute()) {
                    echo "<script>alert('Data inserted successfully!'); window.location.href='index.html';</script>";
                } else {
                    echo "Error executing query: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error uploading the file. Please try again.";
            }
        } else {
            echo "Invalid file type. Only images and videos are allowed.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}

$conn->close();
?>
