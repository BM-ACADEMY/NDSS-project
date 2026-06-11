<?php
// Database credentials
// Database configuration
$servername = "localhost";
$username = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4"; // Your database password
$dbname = "u571038495_hasforal_ndss"; // Your database name


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $jobname = $_POST['jobname'];
    $jobopening = $_POST['jobopening'];
    $jobdescription = $_POST['jobdescription'];
    $salary = $_POST['salary'];
    $experience = $_POST['experience'];
    $location = $_POST['location'];
    $qualification = $_POST['qualification']; 

    // Insert query
    $sql = "INSERT INTO jobs (jobname, jobopening, jobdescription, salary,experience,location,qualification) 
            VALUES ('$jobname', '$jobopening', '$jobdescription', '$salary', '$experience', '$location', '$qualification')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
            exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>