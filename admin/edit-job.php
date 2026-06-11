<?php
// Initialize the session
include_once "./config/dbconnect.php";
session_start();

// Check if the user is logged in (if required), otherwise redirect to the login page
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
//     header("location: login.php");
//     exit;
// }

// Get course ID from URL
if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']);
} else {
    die("Invalid course ID.");
}

// Fetch course details based on ID
$sql = "SELECT * FROM jobs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated job details from the form
    $jobname = $_POST['jobname'];
    $jobdescription = $_POST['jobdescription'];
    $jobopening = $_POST['jobopening'];
    $experience = $_POST['experience'];
    $location = $_POST['location'];
    $salary =$_POST['salary'];
    $qualification= $_POST['qualification'];

    // Update job details in the database
    $update_sql = "UPDATE jobs SET jobname = ?, jobdescription = ?, jobopening = ?, experience = ?, location = ?, salary = ?, qualification = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    
    // Bind the updated values correctly
    $stmt->bind_param("sssssssi", $jobname, $jobdescription, $jobopening, $experience, $location, $salary, $qualification, $course_id);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "Job updated successfully!";
        // Redirect to the dashboard or another page after success
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating job: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!-- HTML Form -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Job</h2>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class="form-group">
            <label for="jobname">Job Name:</label>
            <input type="text" id="jobname" name="jobname" class="form-control" value="<?php echo htmlspecialchars($course['jobname']); ?>" required>
        </div>

        <div class="form-group">
            <label for="jobdescription">Job Description:</label>
            <textarea id="jobdescription" name="jobdescription" rows="3" class="form-control" required><?php echo htmlspecialchars($course['jobdescription']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="jobopening">No. of Openings:</label>
            <input type="text" id="jobopening" name="jobopening" class="form-control" value="<?php echo htmlspecialchars($course['jobopening']); ?>" required>
        </div>

        <div class="form-group">
            <label for="jobopening">salary:</label>
            <input type="text" id="salary" name="salary" class="form-control" value="<?php echo htmlspecialchars($course['salary']); ?>" required>
        </div>


        <div class="form-group">
            <label for="jobopening">qualification:</label>
            <input type="text" id="qualification" name="qualification" class="form-control" value="<?php echo htmlspecialchars($course['qualification']); ?>" required>
        </div>

        <div class="form-group">
            <label for="experience">Experience:</label>
            <input type="text" id="experience" name="experience" class="form-control" value="<?php echo htmlspecialchars($course['experience']); ?>" required>
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($course['location']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Job</button>
    </form>
</div>
</body>
</html>
