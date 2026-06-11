<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Composer autoloader
require 'vendor/autoload.php';

$servername = "localhost";
$username = "u571038495_hasforal_ndss";
$password = "cJfP~J^=4"; // Your database password
$dbname = "u571038495_hasforal_ndss"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');

    // Validate
    if ($product_id <= 0 || empty($name) || empty($email)) {
        die("Error: Invalid form data.");
    }

    // Insert contact into database
    $stmt = $conn->prepare("INSERT INTO contacts (product_id, name, email, phone_number) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing contact insert: " . $conn->error);
    }

    $stmt->bind_param("isss", $product_id, $name, $email, $phone_number);
    if (!$stmt->execute()) {
        die("Error inserting contact: " . $stmt->error);
    }
    $stmt->close();

    // ✅ Send email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';             // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'connect.ndss@gmail.com';        // Your email
        $mail->Password   = 'pfzf vfem rcmb jbjv';          // Gmail App Password
        $mail->SMTPSecure = 'tls';                        // or 'ssl'
        $mail->Port       = 587;                          // 465 for 'ssl'

        $mail->setFrom('connect.ndss@gmail.com', 'ndss');      // Sender
        $mail->addAddress('connect.ndss@gmail.com');          // Receiver

        $mail->isHTML(true);
        $mail->Subject = 'New Brochure Request';
        $mail->Body    = "
            <h3>New Contact Request</h3>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone_number}</p>
        
        ";

        $mail->send();
        // Optional: echo or log message
    } catch (Exception $e) {
        echo "Mail Error: {$mail->ErrorInfo}";
    }

    // ✅ Fetch brochure path and serve it
    $stmt2 = $conn->prepare("SELECT broucher FROM product WHERE id = ?");
    if (!$stmt2) {
        die("Error preparing brochure query: " . $conn->error);
    }

    $stmt2->bind_param("i", $product_id);
    $stmt2->execute();
    $stmt2->bind_result($brochure_path);

    if ($stmt2->fetch()) {
        $stmt2->close();

        if (!empty($brochure_path)) {
            $full_path = __DIR__ . '/admin/' . $brochure_path;

            if (file_exists($full_path)) {
                // Serve PDF brochure
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . basename($brochure_path) . '"');
                header('Content-Length: ' . filesize($full_path));
                readfile($full_path);
                exit;
            } else {
                echo "Error: Brochure file not found at: <code>$full_path</code>";
            }
        } else {
            echo "Error: Brochure path is empty for product ID $product_id.";
        }
    } else {
        echo "Error: No matching product found.";
    }
}

$conn->close();
?>
