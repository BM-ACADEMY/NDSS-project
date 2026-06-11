<?php
// Database connection details
$server = "localhost";
$user = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4";
$db = "u571038495_hasforal_ndss";

// Create a connection to MySQL
$conn = mysqli_connect($server, $user, $password, $db);

// Check the connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $slider_id = intval($_GET['id']);
} else {
    die("Invalid slider ID.");
}

// Fetch slider details based on ID
$sql = "SELECT * FROM slider WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $slider_id);
$stmt->execute();

// Bind the result variables
$stmt->bind_result($id, $name, $description, $slider_image);

// Fetch the result
if ($stmt->fetch()) {
    $slider = [
        'id' => $id,
        'name' => $name,
        'description' => $description,
        'slider_image' => $slider_image
    ];
} else {
    die("Slider not found.");
}

$stmt->close();

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated slider details from the form
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Handle the slider image upload (if a new one is uploaded)
    if (!empty($_FILES["slider_image"]["name"])) {
        $target_dir = "uploads/";

        // Create directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $slider_image = $target_dir . basename($_FILES["slider_image"]["name"]);

        // Check if file upload was successful
        if ($_FILES['slider_image']['error'] == UPLOAD_ERR_OK) {
            if (!move_uploaded_file($_FILES["slider_image"]["tmp_name"], $slider_image)) {
                die("Error uploading file.");
            }
        } else {
            die('Error uploading the file: ' . $_FILES['slider_image']['error']);
        }
    } else {
        // Use the existing image if no new image is uploaded
        $slider_image = $slider['slider_image'];  // Keep the existing image
    }

    // Update slider details in the database
    $update_sql = "UPDATE slider SET name = ?, description = ?, slider_image = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssi", $name, $description, $slider_image, $slider_id);

    if ($stmt->execute()) {
        // Redirect to the dashboard after a successful update
        header("Location: dashboard.php");
        exit;
    } else {
        die("Error: " . $stmt->error);
    }

    $stmt->close();
}
?>

<!-- HTML Form for Editing Slider -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slider</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Slider</h2>
  <form enctype="multipart/form-data" action="" method="POST">
    <div class="form-group">
        <label for="title">Slider Title:</label>
  <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($slider['name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Slider Description:</label>
         <textarea id="description" name="description" rows="3" class="form-control" required><?php echo htmlspecialchars($slider['slider_image']); ?></textarea>
    </div>

      <div class="form-group">
            <label for="slider_image">Slider Image:</label>
            <input type="file" id="slider_image" name="slider_image" class="form-control-file">
            <small>Current Image: <a<?php echo htmlspecialchars($slider['slider_image']); ?>" target="_blank"><?php echo htmlspecialchars($slider['description']); ?></a></small>
        </div>

    <button type="submit" class="btn btn-primary">Update Course</button>
</form>
</div>
</body>
</html>
