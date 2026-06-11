


<?php
// Database configuration
$servername = "localhost";
$username = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4"; // Use your own database password
$dbname = "u571038495_hasforal_ndss";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $client_name= $conn->real_escape_string($_POST['client_name']);
    
    // Handling image upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create directory if it doesn't exist
    }

    $client_image = $target_dir . basename($_FILES["client_image"]["name"]);
    $uploadOk = true;

    // Validate the uploaded file (check size, file type)
    $imageFileType = strtolower(pathinfo($client_image, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["client_image"]["tmp_name"]);

    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = false;
    }

    // Check file size (optional limit, e.g., 5MB)
    if ($_FILES["client_image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = false;
    }

    // Allow only certain file formats (jpg, png, jpeg, gif)
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = false;
    }

    // If file is valid, move the file to the target directory
    if ($uploadOk && move_uploaded_file($_FILES["client_image"]["tmp_name"], $client_image)) {
        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO client (client_name, client_image) VALUES (?, ?)");
        $stmt->bind_param("ss", $client_name, $client_image);

        if ($stmt->execute()) {
            echo "New poster added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading the image.";
    }
}

$conn->close();
?>
