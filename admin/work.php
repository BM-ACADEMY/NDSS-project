<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndss</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add this inside the <head> section of your HTML file -->
<!-- Add this inside the <head> section of your HTML file -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>
<body>
    
<?php
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

// Check if the user is logged in, if not then redirect them to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated course details
    $course_id = $_POST['id'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $regular_price = $_POST['regular_price'];
    $discount_price = $_POST['discount_price'];
    $category = $_POST['category'];
    $requirements = $_POST['requirements'];
    $what_will_learn = $_POST['what_will_learn'];
    $description = $_POST['description'];
    $course_overall_lesson = $_POST['course_overall_lesson'];
    $language = $_POST['language'];
    $rating = $_POST['rating'];

    // Handle course image upload if a new image is provided
    if (!empty($_FILES["course_image"]["name"])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $course_image = $target_dir . basename($_FILES["course_image"]["name"]);
        if (move_uploaded_file($_FILES["course_image"]["tmp_name"], $course_image)) {
            // Update course image
        } else {
            die("Error uploading file.");
        }
    } else {
        // Use existing image if no new image is uploaded
        $course_image = $_POST['current_image'];
    }

    // Update course details in the database
    $update_sql = "UPDATE courses SET title = ?, about = ?, regular_price = ?, discount_price = ?, category = ?, requirements = ?, what_will_learn = ?, description = ?, course_overall_lesson = ?, course_image = ?, language = ?, rating = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssddssssssssi", $title, $about, $regular_price, $discount_price, $category, $requirements, $what_will_learn, $description, $course_overall_lesson, $course_image, $language, $rating, $course_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Course updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// SQL query to fetch course data
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>
    <div class="container mt-5">
        <div class="row">
            <!-- Main Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Manage products</h3>
                    </div>
                    <div class="card-body">
                        <!-- Courses Table -->
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Product Description</th>
                                    <th>product Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Check if there are any results
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                        echo "<td><img src='" . htmlspecialchars($row['product_image']) . "' alt='Product Image' style='width: 100px; height: auto;'></td>";
                                        
                                        echo "<td>";
                                       
                                       
                                        echo "<a href='edit-course.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm'>
                                        <i class='fas fa-edit'></i> 
                                      </a>";
                                echo "<a href='delete_course.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this course?\");'>
                                        <i class='fas fa-trash-alt'></i> 
                                      </a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No courses found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editCourseForm" enctype="multipart/form-data" action="" method="POST">
          <input type="hidden" id="edit_id" name="id" value="<?php echo htmlspecialchars($course['title']); ?>">
          <div class="form-group">
            <label for="edit_title">Course Title:</label>
            <input type="text" id="edit_title" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit_about">Course About:</label>
            <textarea id="edit_about" name="about" rows="4" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label for="edit_regular_price">Regular Price:</label>
            <input type="number" id="edit_regular_price" name="regular_price" class="form-control" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="edit_discount_price">Discount Price:</label>
            <input type="number" id="edit_discount_price" name="discount_price" class="form-control" step="0.01">
          </div>
          <div class="form-group">
            <label for="edit_category">Category:</label>
            <input type="text" id="edit_category" name="category" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit_requirements">Course Requirements:</label>
            <textarea id="edit_requirements" name="requirements" rows="3" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="edit_what_will_learn">What Will Be Learned:</label>
            <textarea id="edit_what_will_learn" name="what_will_learn" rows="3" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="edit_description">Course Description:</label>
            <textarea id="edit_description" name="description" rows="3" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label for="edit_course_overall_lesson">Course Overall Lesson:</label>
            <input type="text" id="edit_course_overall_lesson" name="course_overall_lesson" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit_language">Language:</label>
            <input type="text" id="edit_language" name="language" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit_rating">Rating:</label>
            <input type="text" id="edit_rating" name="rating" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit_course_image">Course Image:</label>
            <input type="file" id="edit_course_image" name="course_image" class="form-control-file">
            <small>Current Image: <span id="current_image"></span></small>
          </div>
          <button type="submit" class="btn btn-primary">Update Course</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
    $('#editCourseModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); 
        var id = button.data('id');
        var title = button.data('title');
        var about = button.data('about');
        var regular_price = button.data('regular_price');
        var discount_price = button.data('discount_price');
        var category = button.data('category');
        var requirements = button.data('requirements');
        var what_will_learn = button.data('what_will_learn');
        var description = button.data('description');
        var course_overall_lesson = button.data('course_overall_lesson');
        var language = button.data('language');
        var rating = button.data('rating');
        var course_image = button.data('course_image');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_title').val(title);
        modal.find('#edit_about').val(about);
        modal.find('#edit_regular_price').val(regular_price);
        modal.find('#edit_discount_price').val(discount_price);
        modal.find('#edit_category').val(category);
        modal.find('#edit_requirements').val(requirements);
        modal.find('#edit_what_will_learn').val(what_will_learn);
        modal.find('#edit_description').val(description);
        modal.find('#edit_course_overall_lesson').val(course_overall_lesson);
        modal.find('#edit_language').val(language);
        modal.find('#edit_rating').val(rating);
        modal.find('#current_image').val(course_image);
        modal.find('#display_current_image').text(course_image);
    });
});
</script>
    
    <!-- jQuery, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
