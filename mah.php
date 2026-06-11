<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require 'vendor/autoload.php'; // Adjust the path as necessary

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $phoneNumber = $_POST['phoneNumber'];
    $position = $_POST['position'];
    $experienceLevel = $_POST['experienceLevel'];

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["resume"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a valid format
    if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
        echo "Sorry, only PDF, DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO job_applications (full_name, phone_number, position, experience_level, resume) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullName, $phoneNumber, $position, $experienceLevel, $target_file);
            
            if ($stmt->execute()) {
                // Send email using PHPMailer
                $mail = new PHPMailer(true); // Create a new PHPMailer instance

                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                    $mail->SMTPAuth = true;
                    $mail->Username = 'connect.ndss@gmail.com'; // Your Gmail address
                    $mail->Password = ' pfzf vfem rcmb jbjv'; // Your Gmail password (or app-specific password)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                    $mail->Port = 587; // TCP port to connect to

                    //Recipients
                    $mail->setFrom('connect.ndss@gmail.com');
                    $mail->addAddress('connect.ndss@gmail.com', 'Recipient Name'); // Add a recipient

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = "New Job Application: " . $position;
                    $mail->Body    = "
                    <html>
                    <head>
                        <title>Job Application</title>
                    </head>
                    <body>
                        <p>New application received:</p>
                        <p><strong>Full Name:</strong> $fullName</p>
                        <p><strong>Phone Number:</strong> $phoneNumber</p>
                        <p><strong>Position Applied For:</strong> $position</p>
                        <p><strong>Experience Level:</strong> $experienceLevel</p>
                        <p><strong>Resume:</strong> <a href='$target_file'>View Resume</a></p>
                    </body>
                    </html>
                    ";
                    $mail->AltBody = "New application received:\nFull Name: $fullName\nPhone Number: $phoneNumber\nPosition Applied For: $position\nExperience Level: $experienceLevel\nResume: $target_file";

                    $mail->send();
                    header("Location: thankyou.php");
                    exit(); // Exit to prevent further execution
                } catch (Exception $e) {
                    echo "Application submitted successfully, but the email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
