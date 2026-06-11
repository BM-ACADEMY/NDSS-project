<?php
// Initialize the session
include_once "./config/dbconnect.php";
session_start();

// Get course ID from URL
if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']);
} else {
    die("Invalid course ID.");
}

// Fetch course details based on ID
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated course details
    $title = $_POST['title'];
    $description = $_POST['description'];
    $genset = $_POST['genset'];
    $powerrating = $_POST['powerrating'];
    $phase = $_POST['phase'];
    $voltage = $_POST['voltage'];
    $current = $_POST['current'];
    $grossenginekw = $_POST['grossenginekw'];
    $grossenginehp = $_POST['grossenginehp'];
    $dimension = $_POST['dimension'];
    $integral = $_POST['integral'];
    $dgdry = $_POST['dgdry'];

    // Default to existing values
    $product_image = $course['product_image'];
    $broucher = $course['broucher'];

    // Handle product image upload
    if (!empty($_FILES["product_image"]["name"])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $new_product_image = $target_dir . basename($_FILES["product_image"]["name"]);

        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $new_product_image)) {
            $product_image = $new_product_image;
        } else {
            die("Error uploading image file.");
        }
    }

    // Handle brochure upload
    if (!empty($_FILES["broucher"]["name"])) {
        $brochure_target_dir = "uploads/";
        if (!is_dir($brochure_target_dir)) {
            mkdir($brochure_target_dir, 0755, true);
        }

        $new_brochure_name = uniqid('brochure_', true) . '-' . basename($_FILES["broucher"]["name"]);
        $new_brochure_path = $brochure_target_dir . $new_brochure_name;
        $brochureFileType = strtolower(pathinfo($new_brochure_path, PATHINFO_EXTENSION));

        if ($brochureFileType !== 'pdf') {
            die("Only PDF files are allowed for brochures.");
        }

        if (move_uploaded_file($_FILES["broucher"]["tmp_name"], $new_brochure_path)) {
            $broucher = $new_brochure_path;
        } else {
            die("Error uploading brochure file.");
        }
    }

    // Update the database
    $sql = "UPDATE product SET 
        title=?, 
        description=?, 
        genset=?, 
        powerrating=?, 
        phase=?, 
        voltage=?, 
        current=?, 
        grossenginekw=?, 
        grossenginehp=?, 
        dimension=?, 
        integral=?, 
        dgdry=?, 
        product_image=?, 
        broucher=? 
    WHERE id=?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('ssssssssssssssi', 
        $title, 
        $description, 
        $genset, 
        $powerrating, 
        $phase, 
        $voltage, 
        $current, 
        $grossenginekw, 
        $grossenginehp, 
        $dimension, 
        $integral, 
        $dgdry, 
        $product_image, 
        $broucher, 
        $course_id
    );

    if ($stmt->execute()) {
        echo "Product updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

    header("Location: dashboard.php");
    exit;
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Course</h2>
    <form enctype="multipart/form-data" action="" method="POST">
        <div class="form-group">
            <label for="title">Course Title:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($course['title']); ?>" >
        </div>

        <div class="form-group">
            <label for="description">Course Description:</label>
            <textarea id="description" name="description" rows="3" class="form-control"><?php echo htmlspecialchars($course['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="genset">Genset:</label>
            <input type="text" id="genset" name="genset" class="form-control" value="<?php echo htmlspecialchars($course['genset']); ?>" >
        </div>

        <div class="form-group">
            <label for="powerrating">Power Rating:</label>
            <input type="text" id="powerrating" name="powerrating" class="form-control" value="<?php echo htmlspecialchars($course['powerrating']); ?>" >
        </div>

        <div class="form-group">
            <label for="phase">No of Phase:</label>
            <input type="text" id="phase" name="phase" class="form-control" value="<?php echo htmlspecialchars($course['phase']); ?>" >
        </div>

        <div class="form-group">
            <label for="voltage">Voltage Range:</label>
            <input type="text" id="voltage" name="voltage" class="form-control" value="<?php echo htmlspecialchars($course['voltage']); ?>" >
        </div>

        <div class="form-group">
            <label for="current">Current Amps:</label>
            <input type="text" id="current" name="current" class="form-control" value="<?php echo htmlspecialchars($course['current']); ?>">
        </div>

        <div class="form-group">
            <label for="grossenginekw">Gross Engine (KWM):</label>
            <input type="text" id="grossenginekw" name="grossenginekw" class="form-control" value="<?php echo htmlspecialchars($course['grossenginekw']); ?>">
        </div>

        <div class="form-group">
            <label for="grossenginehp">Gross Engine (Hp):</label>
            <input type="text" id="grossenginehp" name="grossenginehp" class="form-control" value="<?php echo htmlspecialchars($course['grossenginehp']); ?>">
        </div>

        <div class="form-group">
            <label for="dimension">Dimension:</label>
            <input type="text" id="dimension" name="dimension" class="form-control" value="<?php echo htmlspecialchars($course['dimension']); ?>">
        </div>

        <div class="form-group">
            <label for="integral">Integral Fuel Tank:</label>
            <input type="text" id="integral" name="integral" class="form-control" value="<?php echo htmlspecialchars($course['integral']); ?>">
        </div>

        <div class="form-group">
            <label for="dgdry">Dg Dry Weight:</label>
            <input type="text" id="dgdry" name="dgdry" class="form-control" value="<?php echo htmlspecialchars($course['dgdry']); ?>">
        </div>  

        <div class="form-group">
            <label for="broucher">Brochure (PDF):</label>
            <input type="file" id="broucher" name="broucher" class="form-control-file" accept=".pdf">
        <?php if (!empty($course['broucher'])): ?>
    <a href="admin/<?php echo $course['broucher']; ?>" target="_blank">View Brochure</a>
<?php else: ?>
    <p>No brochure uploaded.</p>
<?php endif; ?>

        </div>  

        <div class="form-group">
            <label for="product_image">Course Image:</label>
            <input type="file" id="product_image" name="product_image" class="form-control-file" accept="image/*">
            <?php if (!empty($course['product_image'])): ?>
                <small>Current Image: <a href="<?php echo htmlspecialchars($course['product_image']); ?>" target="_blank">View Image</a></small>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Update Course</button>
    </form>
</div>
</body>
</html>
