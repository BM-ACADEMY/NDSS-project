<?php
// Database connection details
$server = "localhost";
$user = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4";
$db = "u571038495_hasforal_ndss";

// Create connection
$conn = mysqli_connect($server, $user, $password, $db);

// Check connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Check if 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. No slider ID provided.");
}

$slider_id = intval($_GET['id']);

// Get the image file path before deleting
$sql = "SELECT slider_image FROM slider WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $slider_id);
$stmt->execute();
$stmt->bind_result($slider_image);

if ($stmt->fetch()) {
    // Delete the image file if it exists
    if (!empty($slider_image) && file_exists($slider_image)) {
        unlink($slider_image);
    }
}
$stmt->close();

// Delete the record from the database
$delete_sql = "DELETE FROM slider WHERE id = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("i", $slider_id);

if ($stmt->execute()) {
    // Redirect back to dashboard with success message
    header("Location: dashboard.php?msg=deleted");
    exit;
} else {
    die("Error deleting slider: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
