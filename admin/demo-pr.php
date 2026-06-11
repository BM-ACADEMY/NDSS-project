<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = false;
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection
    $mysqli = new mysqli("localhost", "u571038495_hasforal_ndss", "cJfP~J^=4", "u571038495_hasforal_ndss");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Improved image upload function
    function uploadImage($inputName) {
        if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
            error_log("Upload error or no file uploaded for $inputName");
            return null;
        }

        $uploadDir = __DIR__ . '/uploads/';
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                error_log("Failed to create upload directory");
                return null;
            }
        }

        // Generate unique filename
        $ext = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img_') . '.' . $ext;
        $targetPath = $uploadDir . $filename;

        // Check if file is an actual image
        $check = getimagesize($_FILES[$inputName]['tmp_name']);
        if ($check === false) {
            error_log("File is not an image");
            return null;
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
            return $filename;
        } else {
            error_log("Failed to move uploaded file");
            return null;
        }
    }

    // Process all images
    $images = [];
    $imageFields = ['image','image2','image3','image4','image5','image6','image7','image8','image9'];
    
    foreach ($imageFields as $field) {
        $images[$field] = uploadImage($field);
        if ($images[$field]) {
            error_log("Successfully uploaded $field: " . $images[$field]);
        }
    }

    // Prepare SQL statement
    $stmt = $mysqli->prepare("
        INSERT INTO details_project (
            image, title, description1, description2, title2, project_name, location, 
            solution_provided, industry, project_timeline, key_requirements,
            title3, description3, image2, image3, title4, description4,
            challenge1, challengedesc1, challenge2, challengedesc2,
            challenge3, challengedesc3, challenge4, challengedesc4,
            title5, description5, image4, generator_model, power_output, fuel_type,
            emission_standards, noise_level, special_features, installation_specifics,
            title6, image5, image6, image7, image8, image9,
            titlebox1, titlebox2, titlebox3, titlebox4, titlebox5
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    // Bind parameters
    $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssss",
        $images['image'], 
        $_POST['title'], 
        $_POST['description1'], 
        $_POST['description2'], 
        $_POST['title2'],
        $_POST['project_name'], 
        $_POST['location'], 
        $_POST['solution_provided'], 
        $_POST['industry'], 
        $_POST['project_timeline'], 
        $_POST['key_requirements'],
        $_POST['title3'], 
        $_POST['description3'], 
        $images['image2'], 
        $images['image3'], 
        $_POST['title4'], 
        $_POST['description4'],
        $_POST['challenge1'], 
        $_POST['challengedesc1'], 
        $_POST['challenge2'], 
        $_POST['challengedesc2'],
        $_POST['challenge3'], 
        $_POST['challengedesc3'], 
        $_POST['challenge4'], 
        $_POST['challengedesc4'],
        $_POST['title5'], 
        $_POST['description5'], 
        $images['image4'], 
        $_POST['generator_model'], 
        $_POST['power_output'], 
        $_POST['fuel_type'],
        $_POST['emission_standards'], 
        $_POST['noise_level'], 
        $_POST['special_features'], 
        $_POST['installation_specifics'],
        $_POST['title6'], 
        $images['image5'], 
        $images['image6'], 
        $images['image7'], 
        $images['image8'], 
        $images['image9'],
        $_POST['titlebox1'], 
        $_POST['titlebox2'], 
        $_POST['titlebox3'], 
        $_POST['titlebox4'], 
        $_POST['titlebox5']
    );

    // Execute and handle result
    if ($stmt->execute()) {
        $success = true;
        $projectId = $mysqli->insert_id;
        error_log("Successfully inserted project with ID: $projectId");
    } else {
        $errorMsg = "Database error: " . $stmt->error;
        error_log($errorMsg);
    }

    $stmt->close();
    $mysqli->close();
}

// Redirect or display message

?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Project</title>
</head>
<style>
    .form-control {
    display: block;
    width: 
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.label {
    display: inline-block;
    margin-bottom: .5rem;
}
    </style>
<body>

<?php if ($success): ?>
    <p style="color: green;">✅ Project successfully uploaded!</p>
<?php elseif (!empty($errorMsg)): ?>
    <p style="color: red;">❌ <?= htmlspecialchars($errorMsg) ?></p>
<?php endif; ?>
<div style="border-style: ridge; padding:10px;">
<form action="" method="POST" enctype="multipart/form-data">
  <fieldset>
    <legend><h3>Basic Details</h3></legend>
    <label>Image 1:<br> <input type="file" name="image" class="form-control" style='width:246%;'></label><br><br>
    <label>Title: <br> <input type="text" name="title"class="form-control" style='width:379%;'></label><br>
    <label>Description 1:<br>  <textarea name="description1"class="form-control"  style='width:418%;'></textarea></label><br>
    <label>Description 2: <br> <textarea name="description2"class="form-control" style='width:418%;'></textarea></label><br>
  </fieldset>

  <fieldset>
    <legend><h3>Basic Details 2</h3></legend>
    <label>Title 2:<br>  <input type="text" name="title2"class="form-control" style='width:379%;' ></label><br>
    <label>Project Name: <br> <input type="text" name="project_name"class="form-control" style='width:379%;'></label><br>
    <label>Location:<br>  <input type="text" name="location"class="form-control" style='width:379%;'></label><br>
    <label>Solution Provided:<br>  <input type="text" name="solution_provided"class="form-control" style='width:379%;'></label><br>
    <label>Industry: <br> <input type="text" name="industry"class="form-control"  style='width:379%;'></label><br>
    <label>Project Timeline: <br> <input type="text" name="project_timeline"class="form-control" style='width:379%;'></label><br>
    <label>Key Requirements: <br> <textarea name="key_requirements"class="form-control"  style='width:418%;'></textarea></label><br>
  </fieldset>

  <fieldset>
    <legend><h3>Basic Details 3</h3></legend>
    <label>Title 3: <br>  <input type="text" name="title3"class="form-control" style='width:379%;'></label><br>
    <label>Description 3: <br> <textarea name="description3"class="form-control" style='width:418%;'></textarea></label><br>
    <label>Image 2:<br>  <input type="file" name="image2"class="form-control" style='width:246%;'></label><br>
    <label>Image 3: <br> <input type="file" name="image3"class="form-control" style='width:246%;'></label><br>
  </fieldset>

  <fieldset>
    <legend><h3>Challenges</h3></legend>
    <label>Title 4:<br>  <input type="text" name="title4"class="form-control" style='width:379%;'></label><br>
    <label>Description 4: <br> <textarea name="description4"class="form-control" style='width:418%;'></textarea></label><br>

    <label>Challenge 1: <br> <input type="text" name="challenge1"class="form-control" style='width:379%;'></label><br>
    <label>Challenge Desc 1: <br> <textarea name="challengedesc1"class="form-control" style='width:418%;'></textarea></label><br>

    <label>Challenge 2:<br>  <input type="text" name="challenge2"class="form-control" style='width:379%;'></label><br>
    <label>Challenge Desc 2: <br> <textarea name="challengedesc2"class="form-control" style='width:418%;'></textarea></label><br>

    <label>Challenge 3: <br> <input type="text" name="challenge3" class="form-control" style='width:379%;'></label><br>
    <label>Challenge Desc 3:<br>  <textarea name="challengedesc3" class="form-control" style='width:418%;'></textarea></label><br>

    <label>Challenge 4:<br>  <input type="text" name="challenge4"class="form-control" style='width:379%;'></label><br>
    <label>Challenge Desc 4:<br>  <textarea name="challengedesc4"class="form-control" style='width:418%;'></textarea></label><br>
  </fieldset>

  <fieldset>
    <legend><h3>Technical Specification</h3></legend>
    <label>Title 5:<br>  <input type="text" name="title5" class="form-control" style='width:379%;'></label><br>
    <label>Description 5: <br> <textarea name="description5" class="form-control" style='width:418%;'></textarea></label><br>
    <label>Image 4: <br> <input type="file" name="image4" class="form-control" style='width:246%;'> </label><br>
    <label>Generator Model: <br> <input type="text" name="generator_model" class="form-control" style='width:379%;'></label><br>
    <label>Power Output: <br> <input type="text" name="power_output" class="form-control" style='width:379%;'></label><br>
    <label>Fuel Type:<br>  <input type="text" name="fuel_type" class="form-control" style='width:379%;'></label><br>
    <label>Emission Standards:<br>  <input type="text" name="emission_standards" class="form-control" style='width:379%;'></label><br>
    <label>Noise Level:<br>  <input type="text" name="noise_level"class="form-control" style='width:379%;'></label><br>
    <label>Special Features:<br>  <textarea name="special_features"class="form-control" style='width:379%;'></textarea></label><br>
    <label>Installation Specifics:<br>  <textarea name="installation_specifics" class="form-control" style='width:379%;'></textarea></label><br>
  </fieldset>

  <fieldset>
    <legend><h3>Gallery & Extra</h3></legend>
    <label>Title 6: <input type="text" name="title6" class="form-control"></label><br>
    <label>Title Box 1:<br>  <input type="text" name="titlebox1" class="form-control" style='width:379%;'></label><br>
    <label>Title Box 2: <br> <input type="text" name="titlebox2"class="form-control" style='width:379%;'></label><br>
    <label>Title Box 3:<br>  <input type="text" name="titlebox3" class="form-control" style='width:379%;'></label><br>
    <label>Title Box 4: <br> <input type="text" name="titlebox4" class="form-control" style='width:379%;'></label><br>
    <label>Title Box 5:<br>  <input type="text" name="titlebox5"class="form-control" style='width:379%;'></label><br>

    <label>Image 5:<br>  <input type="file" name="image5"class="form-control" style='width:246%;'></label><br>
    <label>Image 6: <br> <input type="file" name="image6" class="form-control" style='width:246%;'></label><br>
    <label>Image 7: <br> <input type="file" name="image7" class="form-control" style='width:246%;'></label><br>
    <label>Image 8: <br> <input type="file" name="image8" class="form-control" style='width:246%;'></label><br>
    <label>Image 9: <br> <input type="file" name="image9" class="form-control" style='width:246%;'></label><br>
  </fieldset>

  <input type="submit" value="Submit">
</form>
</div>

</body>
</html>
