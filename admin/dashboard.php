<?php

// Include the database configuration file
include_once "./config/dbconnect.php";
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Initialize count variables
$total_courses = 0;
$total_subjects = 0;
$total_jobs = 0;
$total_users = 0;
$total_applications = 0;

// Count courses
$sql_courses = "SELECT COUNT(*) AS total FROM product";
$result_courses = mysqli_query($conn, $sql_courses);
if ($result_courses) {
    $row = mysqli_fetch_assoc($result_courses);
    $total_courses = $row['total'];
}

// Count subjects
$sql_subjects = "SELECT COUNT(*) AS total FROM poster";
$result_subjects = mysqli_query($conn, $sql_subjects);
if ($result_subjects) {
    $row = mysqli_fetch_assoc($result_subjects);
    $total_subjects = $row['total'];
}

// Count jobs
$sql_jobs = "SELECT COUNT(*) AS total FROM jobs";
$result_jobs = mysqli_query($conn, $sql_jobs);
if ($result_jobs) {
    $row = mysqli_fetch_assoc($result_jobs);
    $total_jobs = $row['total'];
}

// ❗ Replace 'users' with your actual user table name after verifying
$user_table = "users";
$table_check = mysqli_query($conn, "SHOW TABLES LIKE '$user_table'");
if (mysqli_num_rows($table_check) == 1) {
    $sql_users = "SELECT COUNT(*) AS total FROM $user_table";
    $result_users = mysqli_query($conn, $sql_users);
    if ($result_users) {
        $row = mysqli_fetch_assoc($result_users);
        $total_users = $row['total'];
    }
} else {
    $total_users = "Table '$user_table' not found.";
}

// Count job applications
$sql_applications = "SELECT COUNT(*) AS total FROM job_applications";
$result_applications = mysqli_query($conn, $sql_applications);
if ($result_applications) {
    $row = mysqli_fetch_assoc($result_applications);
    $total_applications = $row['total'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndss Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Custom CSS -->
    
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
             
               
                <li class="nav-item"> 
                <p><a href="logout.php" class="nav-link">Logout</a></p>
                </li>
            </ul>
        </div>
    </nav>

    <h2 class="text-center"> Welcome to <?php echo htmlspecialchars($_SESSION["username"]); ?> </h2>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
            <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-dashboard-list" data-toggle="list" href="#list-dashboard" role="tab" aria-controls="dashboard">Dashboard</a>
        <a class="list-group-item list-group-item-action" id="list-slider-list" data-toggle="list" href="#list-slider" role="tab" aria-controls="students">Hero Slider</a>
        <a class="list-group-item list-group-item-action" id="list-sliderview-list" data-toggle="list" href="#list-sliderview" role="tab" aria-controls="students">Slider View</a>
        <a class="list-group-item list-group-item-action" id="list-add-course-list" data-toggle="list" href="#list-add-course" role="tab" aria-controls="add-course">Add Product</a>
        <a class="list-group-item list-group-item-action" id="list-students-list" data-toggle="list" href="#list-students" role="tab" aria-controls="students">Product View</a>
        <a class="list-group-item list-group-item-action" id="list-partner-list" data-toggle="list" href="#list-partner" role="tab" aria-controls="students">Our Partners</a>
        <a class="list-group-item list-group-item-action" id="list-manage-courses-list" data-toggle="list" href="#list-lesson" role="tab" aria-controls="list-lesson">Job</a>
        <a class="list-group-item list-group-item-action" id="list-job-list" data-toggle="list" href="#list-job" role="tab" aria-controls="students">Job Description</a>
        <a class="list-group-item list-group-item-action" id="list-project-list" data-toggle="list" href="#list-project" role="tab" aria-controls="students">project</a>
        
                <a class="list-group-item list-group-item-action" id="project-view" data-toggle="list" href="#project-edit-view" role="tab" aria-controls="students">project-view</a>
                
                <a class="list-group-item list-group-item-action" id="demo-details-add" data-toggle="list" href="#demo-details" role="tab" aria-controls="students">project-details</a>
                                <a class="list-group-item list-group-item-action" id="demo-details-view" data-toggle="list" href="#demo-detailsview" role="tab" aria-controls="students">project-details-view</a>
        <a class="list-group-item list-group-item-action" id="list-manage-courses-list" data-toggle="list" href="#list-manage-courses" role="tab" aria-controls="manage-courses">Daily Post</a>
     
        
    </div>
</div>

            <!-- Main Panel -->
            <div class="col-md-9">
                <div class="tab-content" id="nav-tabContent">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="list-dashboard" role="tabpanel" aria-labelledby="list-dashboard-list">
                        <div class="card">
                            <div class="card-header">
                                <h3>Dashboard</h3>
                            </div>
                         
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body">Total product</div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <h5><?php echo $total_courses; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning text-white mb-4">
                                            <div class="card-body">Total post</div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <h5><?php echo $total_subjects; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-success text-white mb-4">
                                            <div class="card-body">Total job</div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <h5><?php echo $total_jobs; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-success text-white mb-4">
                                            <div class="card-body">Total job Apply</div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <h5><?php echo $total_jobs; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Course Tab -->
                    <div class="tab-pane fade" id="list-add-course" role="tabpanel" aria-labelledby="list-add-course-list">
                        <div class="card">
                            <div class="card-header">
                                <h3>Add Product</h3>
                            </div>
                            <div class="card-body">
                            <form enctype='multipart/form-data' action="add_course.php" method="POST">
    <div class="form-group">
        <label for="title">Product Name:</label>
        <input type="text" id="title" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Product Description:</label>
        <textarea id="description" name="description" rows="3" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="genset">Genset Model Name:</label>
        <input type="text" id="genset" name="genset" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="phase">No of Phase:</label>
        <input type="text" id="phase" name="phase" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="powerrating">Power Rating:</label>
        <input type="text" id="powerrating" name="powerrating" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="voltage">Voltage Range:</label>
        <input type="text" id="voltage" name="voltage" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="current">Current Amps:</label>
        <input type="text" id="current" name="current" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="grossenginekw">Gross Engine (KWM):</label>
        <input type="text" id="grossenginekw" name="grossenginekw" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="grossenginehp">Gross Engine (Hp):</label>
        <input type="text" id="grossenginehp" name="grossenginehp" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="dimension">Dimension:</label>
        <input type="text" id="dimension" name="dimension" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="integral">Integral Fuel Tank:</label>
        <input type="text" id="integral" name="integral" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="dgdry">Dg Dry Weight:</label>
        <input type="text" id="dgdry" name="dgdry" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="broucher">Brochure:</label>
        <input type="file" id="broucher" name="broucher" class="form-control-file">
    </div>
    <div class="form-group">
        <label for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="product_image" class="form-control-file" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success">Add Product</button>
</form>

                            </div>
                        </div>
                    </div>
                    <!-- Manage Courses Tab -->


                    <div class="tab-pane fade" id="list-lesson" role="tabpanel" aria-labelledby="list-lesson-list">
                        <div class="card">
                            <div class="card-header">
                                <h3>Add Job Details</h3>
                            </div>
                            <div class="card-body">
                                <!-- Course Table -->
                                <form id="lesson-form" action="add_lesson.php" method="post">
                                    <div class="form-group">
                                        <label for="courseName">Job Name</label>
                                        <input type="text" id="jobname" name="jobname" required class="form-control">
                     
                                    </div>
                                    <div class="form-group">
                                        <label for="courseDescription">No.of.opening</label>
                                        <input type="text" id="jobopening" name="jobopening" required class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="courseDescription">Job Description</label>
                                        <input type="text" id="jobdescription" name="jobdescription" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="courseDescription">Salary</label>
                                        <input type="text" id="salary" name="salary" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="courseDescription">Experience</label>
                                        <input type="text" id="experience" name="experience" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="courseDescription">Location</label>
                                        <input type="text" id="location" name="location" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="courseDescription">Experience</label>
                                        <input type="text" id="qualification" name="qualification" required class="form-control">
                                    </div>

                                    <div id="lesson-container"> </div>
                                    <button type="submit" class="btn btn-success">Add job</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="list-job" role="tabpanel" aria-labelledby="list-job-list">
                    <?php include 'job.php';?>

                      </div>


                      <div class="tab-pane fade" id="list-partner" role="tabpanel" aria-labelledby="list-partner-list">
                        <div class="card">
                            <div class="card-header">
                                <h3>Our Client</h3>
                            </div>
                            <div class="card-body">
                                <!-- Course Table -->
                                <form id="subject-form" enctype="multipart/form-data" action="partner.php" method="post">
                                
                                    <div class="form-group">
                                        <label for="courseDescription">Poster Name</label>
                                        <textarea class="form-control" id="client_name" name="client_name" rows="3" placeholder="Enter client name"></textarea>
                                    </div>
                                    <div class="form-group">
                        <label for="course_image">Poster Image:</label>
                        <input type="file" id="client_image" name="client_image" class="form-control-file" accept="image/*" required>
                    </div>
                                  
                            
                                    <button type="submit" class="btn btn-success">Add client</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
<div class="tab-pane fade" id="list-manage-courses" role="tabpanel" aria-labelledby="list-manage-courses-list">
    <div class="card">
        <div class="card-header">
            <h3>Daily Poster</h3>
        </div>
        <div class="card-body">
            <!-- Poster Upload Form -->
            <form id="poster-form" enctype="multipart/form-data" action="add_subject.php" method="POST">
                <div class="form-group">
                    <label for="subject_name">Poster Name</label>
                    <textarea class="form-control" id="subject_name" name="subject_name" rows="3" placeholder="Enter Poster Name"></textarea>
                </div>
                <div class="form-group">
                    <label for="post_media">Poster Image or Video:</label>
                    <input type="file" id="post_media" name="post_media" class="form-control-file" accept="image/*,video/*" required>
                </div>
                <button type="submit" class="btn btn-success" name="submit">Add Post</button>
            </form>
        </div>
    </div>
</div>
 

                    <div class="tab-pane fade" id="list-slider" role="tabpanel" aria-labelledby="list-slider-list">
                        <div class="card">
                            <div class="card-header">
                                <h3>Hero Slider</h3>
                            </div>
                            <div class="card-body">
                                <!-- Course Table -->
                                <form id="subject-form" enctype="multipart/form-data" action="slider.php" method="post">
                                
                                    <div class="form-group">
                                        <label for="courseDescription">Slider Headname</label>
                                        <textarea class="form-control" id="slider_name" name="slider_name" rows="3" placeholder="Enter HeaderName"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="courseDescription">Slider Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                     <label for="course_image">Slider Image:</label>
                                      <input type="file" id="slider_image" name="slider_image" class="form-control-file" accept="image/*" required>
                                   </div>

                                  
                            
                                    <button type="submit" class="btn btn-success">Add Post</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>


           <div class="tab-pane fade" id="project-edit-view" role="tabpanel" aria-labelledby="project-view">
                      
                            
                      <?php include 'project-view.php';?>
                    
                </div>


   <div class="tab-pane fade" id="demo-details" role="tabpanel" aria-labelledby="demo-details-add">
                      
                      
                      
                      
                            
                      <?php include 'demo-pr.php';?>
                    
                </div>
                  <div class="tab-pane fade" id="demo-detailsview" role="tabpanel" aria-labelledby="demo-details-view">
                      
                            
                      <?php include 'demo-pr-view.php';?>
                    
                </div>




                    <div class="tab-pane fade" id="list-sliderview" role="tabpanel" aria-labelledby="list-sliderview-list">
                      
                            
                      <?php include 'sliderview.php';?>
                    
                </div>

                    <div class="tab-pane fade" id="list-students" role="tabpanel" aria-labelledby="list-students-list">
                            
                      <?php include 'work.php';?>  
                </div>

                <div class="tab-pane fade" id="list-project" role="tabpanel" aria-labelledby="list-project-list">
                            
                         
                        <div class="card">
                            <div class="card-header">
                                <h3>Add project</h3>
                            </div>
                            <div class="card-body">


                            <form action="project.php" method="POST" enctype="multipart/form-data">
        <label for="image">Project Image:</label>
        <input type="file" id="image" name="image" required class="form-control">

        <label for="date">Project Date:</label>
        <input type="date" id="date" name="date" required class="form-control"><br><br>

        <label for="headline">Project Headline:</label>
        <input type="text" id="headline" name="headline" required class="form-control"><br><br>

        <label for="subheadline">Project Subheadline:</label>
        <input type="text" id="subheadline" name="subheadline" required class="form-control"><br><br>

        <input type="submit" value="Submit Project">
    </form>

                            </div>
                        </div>
                      </div>


                </div>
            </div>
        </div>
    </div>
  
    <!-- jQuery, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>
</html
