<?php include 'header.php'; ?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4382H0DQZP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-4382H0DQZP');
</script>

<?php
// Include database connection
include 'db.php';
// SQL query to fetch product details


$query = "SELECT * FROM poster ORDER BY created_at DESC";



// Execute the query and store the result
$result = $conn->query($query);

// Initialize an array to store the products (courses)
$courses = [];

if ($result->num_rows > 0) {
    // Fetch all rows and store them in the $courses array
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
} else {
    echo "No products found.";
}
?>


<style>


/* For image and video items */
.media-item {
    width: 100%;  /* Make images and videos responsive */
    object-fit: cover; /* Ensures content fills the space properly */
}

/* Adjust video size */
.video-fluid {
    width: 100%;

    object-fit: cover;
}


/* For smaller screens, reduce the height */
@media (max-width: 768px) {
    .media-item {
        height: 200px; /* Adjust for smaller screens */
    }

    .video-fluid {
        height: 200px;
    }

    .img-fluid {
        height: 200px;
    }
}
</style>
<section class="photo-gallery pb-75 pt-100" style="padding-top:150px;">
    <div class="section-title-one text-center mb-30 pt-100">
        <h2>Our Blog</h2>
    </div>
    <div class="container">
        <div class="">

            <!-- Image and Poster Section -->
            <div class="col-12">
                <h3>Image and Posters</h3>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    $imageCount = 0;
                    foreach ($courses as $course):
                        $mediaPath = "./admin/" . htmlspecialchars($course['post_media']);
                        $mediaFileType = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));

                        // Check if the file is an image
                        if (in_array($mediaFileType, ['jpg', 'jpeg', 'png', 'gif']) && $imageCount < 50):
                            $imageCount++; // Limit to 4 images
                            ?>
                            <div class="col mb-4">
                                <img src="<?php echo $mediaPath; ?>" alt="course-img" class="media-item img-fluid">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Video Section -->
            <div class="col-12 mt-4">
                <h3>Videos</h3>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <?php
                    $videoCount = 0;
                    foreach ($courses as $course):
                        $mediaPath = "./admin/" . htmlspecialchars($course['post_media']);
                        $mediaFileType = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));

                        // Check if the file is a video
                        if (in_array($mediaFileType, ['mp4', 'mov']) && $videoCount < 4):
                            $videoCount++; // Limit to 4 videos
                            ?>
                            <div class="col mb-4">
                                <video controls class="media-item video-fluid">
                                    <source src="<?php echo $mediaPath; ?>" type="video/<?php echo $mediaFileType; ?>">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>




<?php include 'footer.php'; ?>