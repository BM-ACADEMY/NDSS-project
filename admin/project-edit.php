<?php
include_once "./config/dbconnect.php";
session_start();

if (isset($_GET['id'])) {
    $project_id = intval($_GET['id']);
} else {
    die("Invalid project ID.");
}

// Fetch project details
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();
$stmt->close();

if (!$project) {
    die("Project not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'] ?? '';
    $headline = $_POST['headline'] ?? '';
    $subheadline = $_POST['subheadline'] ?? '';  // Corrected name here
    $image = $project['image']; // Keep existing image by default

    // Handle new image upload if any
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $new_image_path = $target_dir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $new_image_path)) {
            $image = $new_image_path;
        } else {
            die("Error uploading image file.");
        }
    }

    // Update project in DB
    $sql = "UPDATE projects SET date = ?, headline = ?, subheadline = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('ssssi', $date, $headline, $subheadline, $image, $project_id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating project: " . $stmt->error;
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Project</h2>
    <form enctype="multipart/form-data" method="POST">
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" class="form-control"
                   value="<?php echo htmlspecialchars($project['date'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="headline">Headline:</label>
            <input type="text" id="headline" name="headline" class="form-control"
                   value="<?php echo htmlspecialchars($project['headline'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="subheadline">Subheadline:</label>
            <input type="text" id="subheadline" name="subheadline" class="form-control"
                   value="<?php echo htmlspecialchars($project['subheadline'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="image">Project Image:</label>
            <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
            <?php if (!empty($project['image'])): ?>
                <small>Current Image: <a href="<?php echo htmlspecialchars($project['image']); ?>" target="_blank">View Image</a></small>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
</div>
</body>
</html>
