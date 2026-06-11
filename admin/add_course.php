<?php
// Database configuration
// Database configuration
$servername = "localhost";
$username = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4"; // Your database password
$dbname = "u571038495_hasforal_ndss"; // Your database name


// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $genset = $conn->real_escape_string($_POST['genset']);
    $powerrating = $conn->real_escape_string($_POST['powerrating']);
    $phase = $conn->real_escape_string($_POST['phase']);
    $voltage = $conn->real_escape_string($_POST['voltage']);
    $current = $conn->real_escape_string($_POST['current']);
    $grossenginekw = $conn->real_escape_string($_POST['grossenginekw']);
    $grossenginehp = $conn->real_escape_string($_POST['grossenginehp']);
    $dimension = $conn->real_escape_string($_POST['dimension']);
    $integral = $conn->real_escape_string($_POST['integral']);
    $dgdry = $conn->real_escape_string($_POST['dgdry']);
    
    // Handling image upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create directory if it doesn't exist
    }

    // Handle Product Image Upload
    $product_image = $target_dir . basename($_FILES["product_image"]["name"]);
    $uploadOk = true;

    // Validate the uploaded product image
    $imageFileType = strtolower(pathinfo($product_image, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);

    if ($check === false) {
        echo "Product image is not an image.";
        $uploadOk = false;
    }

    // Check file size (optional limit, e.g., 5MB)
    if ($_FILES["product_image"]["size"] > 5000000) {
        echo "Sorry, your product image file is too large.";
        $uploadOk = false;
    }

    // Allow only certain file formats (jpg, png, jpeg, gif)
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif', 'webp'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = false;
    }

    // Proceed with moving the file if validations pass
    if ($uploadOk && move_uploaded_file($_FILES["product_image"]["tmp_name"], $product_image)) {
        // Handling brochure upload
        $brochure = null; // Default to null
        if (!empty($_FILES["broucher"]["name"])) {
            $brochure = $target_dir . basename($_FILES["broucher"]["name"]);
            $brochureFileType = strtolower(pathinfo($brochure, PATHINFO_EXTENSION));

            // Validate the brochure file type (optional)
            if (in_array($brochureFileType, ['pdf', 'doc', 'docx'])) {
                move_uploaded_file($_FILES["broucher"]["tmp_name"], $brochure);
            } else {
                echo "Sorry, only PDF, DOC, and DOCX files are allowed for brochures.";
            }
        }

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO product (title, description, genset, powerrating, phase, voltage, current, grossenginekw, grossenginehp, dimension, integral, dgdry, product_image, broucher) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssss", $title, $description, $genset, $powerrating, $phase, $voltage, $current, $grossenginekw, $grossenginehp, $dimension, $integral, $dgdry, $product_image, $brochure);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading the product image.";
    }
}

$conn->close();
?>
