

<?php
// Database configuration
$servername = "localhost";
$username = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4"; // Your database password
$dbname = "u571038495_hasforal_ndss"; // Your database name
// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $headline = $_POST['headline'];
    $subheadline = $_POST['subheadline'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Check if image file is a valid image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO projects (image, date, headline, subheadline) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $target_file, $date, $headline, $subheadline);
            
            // Execute the statement
            if ($stmt->execute()) {
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}

// Close the database connection
$conn->close();
?>



                  