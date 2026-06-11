<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'db.php';

if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']);
} else {
    die("Invalid course ID.");
}

// Fetch the course from the database
$sql = "SELECT id, title, description, product_image FROM product WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $course_id);
$stmt->execute();
$stmt->bind_result($id, $title, $description, $product_image);

if ($stmt->fetch()) {
    $course = [
        'id' => $id,
        'title' => $title,
        'description' => $description,
        'product_image' => $product_image,
    ];
} else {
    die("Course not found.");
}

$stmt->close();

// Fetch technical specifications
$sql_specs = "SELECT genset, powerrating, phase, voltage, current, grossenginehp, grossenginekw, dimension, integral, dgdry FROM product WHERE id = ?";
$stmt = $conn->prepare($sql_specs);

if (!$stmt) {
    die("Preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $course_id);
$stmt->execute();
$stmt->bind_result($genset, $powerrating, $phase, $voltage, $current, $grossenginehp, $grossenginekw, $dimension, $integral, $dgdry);

if ($stmt->fetch()) {
    $technical_specs = [
        'genset' => $genset,
        'powerrating' => $powerrating,
        'phase' => $phase,
        'voltage' => $voltage,
        'current' => $current,
        'grossenginehp' => $grossenginehp,
        'grossenginekw' => $grossenginekw,
        'dimension' => $dimension,
        'integral' => $integral,
        'dgdry' => $dgdry,
    ];
} else {
    die("Technical specifications not found.");
}

$stmt->close();
$conn->close();
?>

<!-- Header Section End -->  

<?php include 'header.php'; ?>

<section id="services" class="services section-bg pt-250">
    <div class="container">
        <div class="row row-sm">
            <div class="col-md-6 _boxzoom">
                <div class="_product-images">
                    <div class="picZoomer">
                        <img src="./admin/<?php echo htmlspecialchars($course['product_image']); ?>" alt="course-img">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="_product-detail-content">
                    <p class="_p-name"><?php echo htmlspecialchars($course['title']); ?></p>
                    <div class="_p-price-box">
                        <div class="_p-features">
                            <span>Description About this product:</span>
                            <p><?php echo htmlspecialchars($course['description']); ?></p>
                        </div>
                        <ul class="spe_ul"></ul>
                        <div class="_p-qty-and-cart">
                            <div class="_p-add-cart">
                                <a href="https://api.whatsapp.com/send?phone=+919786009096&text=hi sir, How can help you?">
                                    <button class="btn-theme btn buy-btn" tabindex="0">Know More</button>
                                </a>
                                <a href="#broucher">
                                    <button class="btn-theme btn buy-btn" tabindex="0">Download Broucher</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="dealer-wrap pb-75">
    <div class="container">
        <div class="section-title-one text-center mb-30 pt-100">
            <h2>TECHNICAL SPECIFICATIONS</h2>
        </div>

        <div class="table-container">
            <table style="width:100%">
                <tr>
                    <td>Genset Model</td>
                    <td><?php echo htmlspecialchars($technical_specs['genset']); ?></td>
                </tr>
                <tr>
                    <td>Power Rating(kVA/KW)</td>
                    <td><?php echo htmlspecialchars($technical_specs['powerrating']); ?></td>
                </tr>
                <tr>
                    <td>NO Of Phase</td>
                    <td><?php echo htmlspecialchars($technical_specs['phase']); ?></td>
                </tr>
                <tr>
                    <td>Voltage RANGE(Volts)</td>
                    <td><?php echo htmlspecialchars($technical_specs['voltage']); ?></td>
                </tr>
                <tr>
                    <td>Current in Amps(1p/3p@0.8PF)</td>
                    <td><?php echo htmlspecialchars($technical_specs['current']); ?></td>
                </tr>
                <tr>
                    <td>Gross engine Power(HP)</td>
                    <td><?php echo htmlspecialchars($technical_specs['grossenginehp']); ?></td>
                </tr>
                <tr>
                    <td>Gross engine Power(kw)</td>
                    <td><?php echo htmlspecialchars($technical_specs['grossenginekw']); ?></td>
                </tr>
                <tr>
                    <td>Dimension LxWxH(mm)</td>
                    <td><?php echo htmlspecialchars($technical_specs['dimension']); ?></td>
                </tr>
                <tr>
                    <td>Integral Fuel tank capacity(Ltrs)</td>
                    <td><?php echo htmlspecialchars($technical_specs['integral']); ?></td>
                </tr>
                <tr>
                    <td>Dg Dry Weight(kg)</td>
                    <td><?php echo htmlspecialchars($technical_specs['dgdry']); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<section class="contact-us-wrap ptb-100" id="broucher">
    <div class="container">
        <div class="section-title-two text-center mb-30">
            <span>Contact Us</span>
            <h2>Get in touch to book a Diesel Generator</h2>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-6">
                <div class="contact-form">
            <form class="form-wrap" id="contactForm" action="process_form.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo isset($course['id']) ? $course['id'] : ''; ?>">
    
    <div class="form-group">
        <input type="text" name="name" placeholder="Name*" id="name" required>
    </div>
    
    <div class="form-group">
        <input type="email" name="email" id="email" required placeholder="Email*">
    </div>
    
    <div class="form-group">
        <input type="number" name="phone_number" id="phone_number" required placeholder="Phone Number*">
    </div>
    
    <button type="submit" class="btn-two">Download Brochure</button>
</form>



                </div>
            </div>
        </div>
    </div>
</section>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4382H0DQZP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-4382H0DQZP');
</script>


<?php include 'footer.php'; ?>
