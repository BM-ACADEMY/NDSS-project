



// Include the database connection
<?php

$server = "localhost";
$user = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4";
$db = "u571038495_hasforal_ndss";

$conn = mysqli_connect($server,$user,$password,$db);

if(!$conn) {
    die("Connection Failed:".mysqli_connect_error());
}



// Check if the course ID is provided
if (isset($_GET['id'])) {
    // Get the course ID from the URL
    $course_id = intval($_GET['id']);

    // Prepare the SQL delete statement
    $sql = "DELETE FROM product WHERE id = ?";

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $course_id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect back to the courses page with a success message
            header("Location: dashboard.php?message=Course+deleted+successfully");
            exit();
        } else {
            // Redirect back with an error message
            header("Location: dashboard.php?error=Failed+to+delete+course");
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect back with an error message if the statement couldn't be prepared
        header("Location: index.php?error=Failed+to+prepare+SQL+statement");
        exit();
    }
} else {
    // Redirect back with an error message if no ID is provided
    header("Location: index.php?error=No+course+ID+provided");
    exit();
}

// Close the database connection
$conn->close();
?>
