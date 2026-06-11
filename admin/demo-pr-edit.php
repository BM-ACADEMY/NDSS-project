<?php
include_once "./config/dbconnect.php";
session_start();

// Validate and fetch project ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $project_id = intval($_GET['id']);
} else {
    header("Location: dashboard.php?error=invalid_id");
    exit;
}

// Fetch existing project data
$sql = "SELECT * FROM details_project WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    die("Project not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect all form data
    $title = $_POST['title'] ?? '';
    $description1 = $_POST['description1'] ?? '';
    $description2 = $_POST['description2'] ?? '';
    $title2 = $_POST['title2'] ?? '';
    $project_name = $_POST['project_name'] ?? '';
    $location = $_POST['location'] ?? '';
    $solution_provided = $_POST['solution_provided'] ?? '';
    $industry = $_POST['industry'] ?? '';
    $project_timeline = $_POST['project_timeline'] ?? '';
    $key_requirements = $_POST['key_requirements'] ?? '';
    $title3 = $_POST['title3'] ?? '';
    $description3 = $_POST['description3'] ?? '';
    $title4 = $_POST['title4'] ?? '';
    $description4 = $_POST['description4'] ?? '';
    $challenge1 = $_POST['challenge1'] ?? '';
    $challengedesc1 = $_POST['challengedesc1'] ?? '';
    $challenge2 = $_POST['challenge2'] ?? '';
    $challengedesc2 = $_POST['challengedesc2'] ?? '';
    $challenge3 = $_POST['challenge3'] ?? '';
    $challengedesc3 = $_POST['challengedesc3'] ?? '';
    $challenge4 = $_POST['challenge4'] ?? '';
    $challengedesc4 = $_POST['challengedesc4'] ?? '';
    $title5 = $_POST['title5'] ?? '';
    $description5 = $_POST['description5'] ?? '';
    
        $title6 = $_POST['title6'] ?? '';
    
    $generator_model = $_POST['generator_model'] ?? '';
    $power_output = $_POST['power_output'] ?? '';
    $fuel_type = $_POST['fuel_type'] ?? '';
    $emission_standards = $_POST['emission_standards'] ?? '';
    $noise_level = $_POST['noise_level'] ?? '';
    $special_features = $_POST['special_features'] ?? '';
    $installation_specifics = $_POST['installation_specifics'] ?? '';
       $titlebox1 = $_POST['titlebox1'] ?? '';
              $titlebox2 = $_POST['titlebox2'] ?? '';
                     $titlebox3 = $_POST['titlebox3'] ?? '';
                            $titlebox4 = $_POST['titlebox4'] ?? '';
                                   $titlebox5 = $_POST['titlebox5'] ?? '';

    // Handle image uploads - only 6 images (image to image6)
    $imageFields = ['image', 'image2', 'image3', 'image4', 'image5', 'image6'];
    $uploadedImages = [];
    $uploadDir = "uploads/";

    foreach ($imageFields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $filename = basename($_FILES[$field]['name']);
            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES[$field]['tmp_name'], $targetFile)) {
                $uploadedImages[$field] = $filename;
            } else {
                echo "Failed to upload $field<br>";
                $uploadedImages[$field] = $project[$field]; // Keep old image on failure
            }
        } else {
            $uploadedImages[$field] = $project[$field]; // Keep old image if no new one
        }
    }

    // Update query - 37 fields + 1 ID = 38 total parameters
    $update_sql = "UPDATE details_project SET 
        title = ?, description1 = ?, description2 = ?, title2 = ?, project_name = ?, 
        location = ?, solution_provided = ?, industry = ?, project_timeline = ?, 
        key_requirements = ?, title3 = ?, description3 = ?, title4 = ?, description4 = ?, 
        challenge1 = ?, challengedesc1 = ?, challenge2 = ?, challengedesc2 = ?, 
        challenge3 = ?, challengedesc3 = ?, challenge4 = ?, challengedesc4 = ?, 
        title5 = ?, description5 = ?, title6 = ?, generator_model = ?, power_output = ?, 
        fuel_type = ?, emission_standards = ?, noise_level = ?, special_features = ?, 
        installation_specifics = ?, titlebox1 = ?,titlebox2 = ?,titlebox3 = ?,titlebox4 = ?,titlebox5 = ?, image = ?, image2 = ?, image3 = ?, image4 = ?, 
        image5 = ?, image6 = ? 
        WHERE id = ?";

    $stmt = $conn->prepare($update_sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Collect all bind params in order
    $bind_params = [
        $title, $description1, $description2, $title2, $project_name,
        $location, $solution_provided, $industry, $project_timeline,
        $key_requirements, $title3, $description3, $title4, $description4,
        $challenge1, $challengedesc1, $challenge2, $challengedesc2,
        $challenge3, $challengedesc3, $challenge4, $challengedesc4,
        $title5, $description5, $title6, $generator_model, $power_output,
        $fuel_type, $emission_standards, $noise_level, $special_features,
        $installation_specifics,$titlebox1,$titlebox2,$titlebox3,$titlebox4,$titlebox5,
        $uploadedImages['image'], $uploadedImages['image2'], $uploadedImages['image3'], 
        $uploadedImages['image4'], $uploadedImages['image5'], $uploadedImages['image6'],
        $project_id
    ];

    // Replace NULLs with empty strings for safe binding
    $bind_params = array_map(function($v) {
        return $v === null ? '' : $v;
    }, $bind_params);

    // 37 strings and 1 integer (project_id)
    $types = str_repeat('s', 43) . 'i';
    $stmt->bind_param($types, ...$bind_params);

    // Execute statement
    if ($stmt->execute()) {
        header("Location: dashboard.php?success=project_updated");
        exit;
    } else {
        echo "Error updating project: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
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
    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($project['title']) ?>" required>
        </div>

        <div class="form-group">
            <label for="description1">Description 1:</label>
            <textarea id="description1" name="description1" class="form-control" rows="3" required><?= htmlspecialchars($project['description1']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="description2">Description 2:</label>
            <input type="text" id="description2" name="description2" class="form-control" value="<?= htmlspecialchars($project['description2']) ?>" required>
        </div>

        <div class="form-group">
            <label for="title2">Title 2:</label>
            <input type="text" id="title2" name="title2" class="form-control" value="<?= htmlspecialchars($project['title2']) ?>" required>
        </div>

        <div class="form-group">
            <label for="project_name">Project Name:</label>
            <input type="text" id="project_name" name="project_name" class="form-control" value="<?= htmlspecialchars($project['project_name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" class="form-control" value="<?= htmlspecialchars($project['location']) ?>">
        </div>

        <div class="form-group">
            <label for="solution_provided">Solution Provided:</label>
            <input type="text" id="solution_provided" name="solution_provided" class="form-control" value="<?= htmlspecialchars($project['solution_provided']) ?>" required>
        </div>

        <div class="form-group">
            <label for="industry">Industry:</label>
            <input type="text" id="industry" name="industry" class="form-control" value="<?= htmlspecialchars($project['industry']) ?>" required>
        </div>

        <div class="form-group">
            <label for="project_timeline">Project Timeline:</label>
            <input type="text" id="project_timeline" name="project_timeline" class="form-control" value="<?= htmlspecialchars($project['project_timeline']) ?>" required>
        </div>

        <div class="form-group">
            <label for="key_requirements">Key Requirements:</label>
            <input type="text" id="key_requirements" name="key_requirements" class="form-control" value="<?= htmlspecialchars($project['key_requirements']) ?>" required>
        </div>

        <div class="form-group">
            <label for="title3">Title 3:</label>
            <input type="text" id="title3" name="title3" class="form-control" value="<?= htmlspecialchars($project['title3']) ?>" required>
        </div>

        <div class="form-group">
            <label for="description3">Description 3:</label>
            <input type="text" id="description3" name="description3" class="form-control" value="<?= htmlspecialchars($project['description3']) ?>" required>
        </div>

        <div class="form-group">
            <label for="title4">Title 4:</label>
            <input type="text" id="title4" name="title4" class="form-control" value="<?= htmlspecialchars($project['title4']) ?>" required>
        </div>

        <div class="form-group">
            <label for="description4">Description 4:</label>
            <input type="text" id="description4" name="description4" class="form-control" value="<?= htmlspecialchars($project['description4']) ?>" required>
        </div>

        <div class="form-group">
            <label for="challenge1">Challenge 1:</label>
            <input type="text" id="challenge1" name="challenge1" class="form-control" value="<?= htmlspecialchars($project['challenge1']) ?>" required>
        </div>

        <div class="form-group">
            <label for="challengedesc1">Challenge Description 1:</label>
            <input type="text" id="challengedesc1" name="challengedesc1" class="form-control" value="<?= htmlspecialchars($project['challengedesc1']) ?>" required>
        </div>

        <div class="form-group">
            <label for="challenge2">Challenge 2:</label>
            <input type="text" id="challenge2" name="challenge2" class="form-control" value="<?= htmlspecialchars($project['challenge2']) ?>" required>
        </div>

        <div class="form-group">
            <label for="challengedesc2">Challenge Description 2:</label>
            <input type="text" id="challengedesc2" name="challengedesc2" class="form-control" value="<?= htmlspecialchars($project['challengedesc2']) ?>" required>
        </div>

        <div class="form-group">
            <label for="challenge3">Challenge 3:</label>
            <input type="text" id="challenge3" name="challenge3" class="form-control" value="<?= htmlspecialchars($project['challenge3']) ?>" required>
        </div>

        <div class="form-group">
            <label for="challengedesc3">Challenge Description 3:</label>
            <input type="text" id="challengedesc3" name="challengedesc3" class="form-control" value="<?= htmlspecialchars($project['challengedesc3']) ?>" required>
        </div>

        <div class="form-group">
            <label for="challenge4">Challenge 4:</label>
            <input type="text" id="challenge4" name="challenge4" class="form-control" value="<?= htmlspecialchars($project['challenge4']) ?>" required>
        </div>

        <div class="form-group">
            <label for="challengedesc4">Challenge Description 4:</label>
            <input type="text" id="challengedesc4" name="challengedesc4" class="form-control" value="<?= htmlspecialchars($project['challengedesc4']) ?>" required>
        </div>

        <div class="form-group">
            <label for="title5">Title 5:</label>
            <input type="text" id="title5" name="title5" class="form-control" value="<?= htmlspecialchars($project['title5']) ?>" required>
        </div>

        <div class="form-group">
            <label for="description5">Description 5:</label>
            <input type="text" id="description5" name="description5" class="form-control" value="<?= htmlspecialchars($project['description5']) ?>" required>
        </div>

        <div class="form-group">
            <label for="generator_model">Generator Model:</label>
            <input type="text" id="generator_model" name="generator_model" class="form-control" value="<?= htmlspecialchars($project['generator_model']) ?>" required>
        </div>

        <div class="form-group">
            <label for="power_output">Power Output:</label>
            <input type="text" id="power_output" name="power_output" class="form-control" value="<?= htmlspecialchars($project['power_output']) ?>" required>
        </div>

        <div class="form-group">
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" id="fuel_type" name="fuel_type" class="form-control" value="<?= htmlspecialchars($project['fuel_type']) ?>" required>
        </div>

        <div class="form-group">
            <label for="emission_standards">Emission Standards:</label>
            <input type="text" id="emission_standards" name="emission_standards" class="form-control" value="<?= htmlspecialchars($project['emission_standards']) ?>" required>
        </div>

        <div class="form-group">
            <label for="noise_level">Noise Level:</label>
            <input type="text" id="noise_level" name="noise_level" class="form-control" value="<?= htmlspecialchars($project['noise_level']) ?>" required>
        </div>

        <div class="form-group">
            <label for="special_features">Special Features:</label>
            <input type="text" id="special_features" name="special_features" class="form-control" value="<?= htmlspecialchars($project['special_features']) ?>" required>
        </div>

        <div class="form-group">
            <label for="installation_specifics">Installation Specifics:</label>
            <input type="text" id="installation_specifics" name="installation_specifics" class="form-control" value="<?= htmlspecialchars($project['installation_specifics']) ?>" required>
        </div>
        
             <div class="form-group">
            <label for="title6">title6:</label>
            <input type="text" id="title6" name="title6" class="form-control" value="<?= htmlspecialchars($project['title6']) ?>" required>
        </div>


                <div class="form-group">
            <label for="titlebox1">titlebox1:</label>
            <input type="text" id="titlebox1" name="titlebox1" class="form-control" value="<?= htmlspecialchars($project['titlebox1']) ?>" required>
        </div>        <div class="form-group">
            <label for="titlebox2">Installation Specifics:</label>
            <input type="text" id="titlebox2" name="titlebox2" class="form-control" value="<?= htmlspecialchars($project['titlebox2']) ?>" required>
        </div>        <div class="form-group">
            <label for="titlebox3">Installation Specifics:</label>
            <input type="text" id="titlebox3" name="titlebox3" class="form-control" value="<?= htmlspecialchars($project['titlebox3']) ?>" required>
        </div>        <div class="form-group">
            <label for="titlebox4">Installation Specifics:</label>
            <input type="text" id="titlebox4" name="titlebox4" class="form-control" value="<?= htmlspecialchars($project['titlebox4']) ?>" required>
        </div>        <div class="form-group">
            <label for="titlebox5">Installation Specifics:</label>
            <input type="text" id="titlebox5" name="titlebox5" class="form-control" value="<?= htmlspecialchars($project['titlebox5']) ?>" required>
        </div>
        <?php
        // Show only 9 image upload fields (image to image9)
        $imageFields = ['image', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8', 'image9'];
        foreach ($imageFields as $field) {
            echo '
            <div class="form-group">
                <label for="' . $field . '">' . ucfirst($field) . ' (leave empty to keep current):</label>
                <input type="file" id="' . $field . '" name="' . $field . '" class="form-control">
                <small>Current image: ' . htmlspecialchars($project[$field] ?? 'No image') . '</small>
            </div>';
        }
        ?>

        <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
</div>
</body>
</html>