<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add this inside the <head> section of your HTML file -->
<!-- Add this inside the <head> section of your HTML file -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>
<body>
    



<?php
// Database configuration
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



// SQL query to fetch course data
$sql = "SELECT * FROM jobs";
$result = $conn->query($sql);
?>
    <div class="container mt-5">
        <div class="row">
            <!-- Main Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Manage job</h3>
                    </div>
                    <div class="card-body">
                        <!-- Courses Table -->
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>job Name</th>
                                    <th>job Description</th>
                                    <th>Opening position</th>
                                    <th>Salary</th>
                                    <th>Experience</th>
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
                                        echo "<td>" . htmlspecialchars($row['jobname']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['jobdescription']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['jobopening']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['experience']) . "</td>";
                                       
                                        
                                        echo "<td>";
                                       
                                       
                                        echo "<a href='edit-job.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm'>
                                        <i class='fas fa-edit'></i> 
                                      </a>";
                                echo "<a href='job-delet.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this course?\");'>
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
