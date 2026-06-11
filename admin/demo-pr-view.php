

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

// SQL query to fetch slider data
$sql = "SELECT * FROM details_project"; // Ensure there's a sort_order column
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error); // Show error message
}
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<div class="container mt-5">
    <div class="row">
        <!-- Main Panel -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>project View Detail</h3>
                </div>
                <div class="card-body">
                    <!-- Sliders Table -->
                    <table class="table table-bordered" id="sortableTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Slider Headername</th>
                                <th>Slider Description</th>
                                <th>Slider Image</th>
                                <th>Slider Headername</th>
                                <th>Slider Description</th>
                                <th>Slider Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
// Check if there are any results
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-id='" . htmlspecialchars($row['id']) . "'>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description1']) . "</td>";
     echo "<td><img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Slider Image 1' style='max-width: 100px; height: auto;'></td>";

        echo "<td>" . htmlspecialchars($row['title2']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description4']) . "</td>";
        echo "<td><img src='uploads/" . htmlspecialchars($row['image2']) . "' alt='Slider Image 1' style='max-width: 100px; height: auto;'></td>";


        echo "<td>";
        echo "<a href='demo-pr-edit.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-primary btn-sm'>
                <i class='fas fa-edit'></i> 
              </a> ";
        echo "<a href='demo-pr-delete.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this slider?\");'>
                <i class='fas fa-trash-alt'></i> 
              </a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No sliders found</td></tr>";
}
?>

                        </tbody>
                    </table>
                    

                       <!-- Sliders Table -->
            
              
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


<!-- Include jQuery UI CSS -->

<?php
// Close the database connection
$conn->close();
?>
