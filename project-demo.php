<?php
include 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM details_project WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $project = $result->fetch_assoc();
} else {
    echo "No project found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Link of CSS files -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/flaticon_motoz.css">
        <link rel="stylesheet" href="assets/css/remixicon.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/odometer.min.css">
        <link rel="stylesheet" href="assets/css/aos.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <link rel="stylesheet" href="assets/css/dark-theme.css">
        
        <title>Ndss Generator</title>
        <link rel="icon" type="image/png" href="assets/img/favicon.webp">
    </head>
    <body>

        <div class="body_overlay"></div>

     

    
       <?php include 'header.php'; ?>
        
        <!-- Header Section End -->  

 <div class="blog-details-wrap ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <article>
                          <div class="post-img">
                           <img src="admin/uploads/<?php echo htmlspecialchars($project['image']); ?>" onerror="this.onerror=null;this.src='assets/img/default-image.png';" alt="Project Image">

                            </div>
                           
                         <h2><?= htmlspecialchars($project['title']) ?></h2>
                            <div class="post-para">
                                <p><?= nl2br(htmlspecialchars($project['description1'])) ?></p>
                                <p><?= nl2br(htmlspecialchars($project['description2'])) ?> </p>
                              
                              
                                <h3><?= htmlspecialchars($project['title2']) ?></h3>
                                <blockquote class="wp-block-quote">
                                   
                                    <p> 
                                        <table style="width:100%">
  <tr>
    <th>Project Name</th>
    <th><?= htmlspecialchars($project['project_name']) ?></th>
   
  </tr>
  <tr>
    <th>Location</th>
    <th><?= htmlspecialchars($project['location']) ?></th>
   
  </tr>
  <tr>
    <th>Solution Provided</th>
    <th> <?= htmlspecialchars($project['solution_provided']) ?></th>
   
  </tr>
  <tr>
    <th>Industry</th>
    <th> <?= htmlspecialchars($project['industry']) ?></th> 
  </tr>
  <tr>
    <th>Project Timeline </th>
    <th><?= htmlspecialchars($project['project_timeline']) ?> </th>
</tr>
<tr>
    <th> Key Requirements </th>
    <th><?= nl2br(htmlspecialchars($project['key_requirements'])) ?></th>
</tr>
  
 
</table></p>
                                </blockquote>
                                
                                <h3><?= htmlspecialchars($project['title3']) ?></h3>
                                <p><?= nl2br(htmlspecialchars($project['description3'])) ?></p>

                                <div class="mains">
                                <div class="container" id="containers"s>
     <div class="image-container">
  <?php if (!empty($project['image1'])): ?>
    <img
      class="image-before slider-image"
      src="admin/uploads/<?php echo htmlspecialchars($project['image1']); ?>"
      alt="color photo"
    />
  <?php endif; ?>

  <?php if (!empty($project['image2'])): ?>
    <img
      class="image-after slider-image"
      src="admin/uploads/<?php echo htmlspecialchars($project['image2']); ?>"
      alt="black and white"
    />
  <?php endif; ?>
</div>

        <!-- step="10" -->
        <input type="range" min="0"  max="100"  value="50"  aria-label="Percentage of before photo shown"  class="slider"/>
        <div class="slider-line" aria-hidden="true"></div>
        <div class="slider-button" aria-hidden="true">
          <svg  xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 256 256">
            <rect width="256" height="256" fill="none"></rect>
            <line  x1="128"  y1="40"
              x2="128"
              y2="216"
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="16"
            ></line>
            <line
              x1="96"
              y1="128"
              x2="16"
              y2="128"
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="16"
            ></line>
            <polyline
              points="48 160 16 128 48 96"
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="16"
            ></polyline>
            <line
              x1="160"
              y1="128"
              x2="240"
              y2="128"
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="16"
            ></line>
            <polyline
              points="208 96 240 128 208 160"
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="16"
            ></polyline>
          </svg>
        </div>
      </div>
</div>
                    
                                <h3><?= htmlspecialchars($project['title4']) ?></h3>

                                
                                <p><?= nl2br(htmlspecialchars($project['description4'])) ?></p>
                                <ul class="content-feature-list list-style mt-15">
                                    <li><i class="ri-checkbox-circle-line"></i>
                                    <strong>Challenge: </strong> <?= htmlspecialchars($project['challenge1']) ?> <br>
                                    <strong> Solution:</strong> <?= htmlspecialchars($project['challengedesc1']) ?>.

                                    </li>
                                    <li><i class="ri-checkbox-circle-line"></i>
                                     <strong>Challenge: </strong> <?= htmlspecialchars($project['challenge2']) ?> <br>
                                    <strong> Solution:</strong> <?= htmlspecialchars($project['challengedesc2']) ?>.            
                                   </li>
                                    <li>
                                      <i class="ri-checkbox-circle-line"></i>
 <strong>Challenge: </strong> <?= htmlspecialchars($project['challenge3']) ?> <br>
                                    <strong> Solution:</strong> <?= htmlspecialchars($project['challengedesc3']) ?>.
                                    </li>
                                    <li><i class="ri-checkbox-circle-line"></i>
 <strong>Challenge: </strong> <?= htmlspecialchars($project['challenge4']) ?> <br>
                                    <strong> Solution:</strong> <?= htmlspecialchars($project['challengedesc4']) ?>.
                                    </li>
                                    
                                </ul>
                            </div>
                        </article>


                        <div class="service-desc">
                          
                            <h4><?= htmlspecialchars($project['title5']) ?></h4>
                            <p><?= htmlspecialchars($project['description5']) ?></p>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="single-service-img mb-0">
                                        <img src="admin/uploads/<?php echo htmlspecialchars($project['image4']); ?>">
                                    </div>
                                </div>
                         <div class="col-md-8">
                             <table style="width:100%">
                                <tr>
                                 <th>Generator Model:</th>
                                 <th><?= htmlspecialchars($project['generator_model']) ?></th> </tr>
                                  <tr>
                                  <th>Power Output: </th>
                                  <th><?= htmlspecialchars($project['power_output']) ?></th> </tr>
                                   <tr>
                                    <th>Fuel Type</th>
                                     <th> <?= htmlspecialchars($project['fuel_type']) ?></th>
                                    </tr>
                                        <tr>
                                    <th>Emission Standards</th>
                                    <th> <?= htmlspecialchars($project['emission_standards']) ?></th> 
                                       </tr>
                                  <tr>
                                   <th>Noise Level </th>
                                 <th><?= htmlspecialchars($project['noise_level']) ?> </th>
                                   </tr>
                                <tr>
                                   <th> Special Features: </th>
                                 <th><?= htmlspecialchars($project['special_features']) ?> </th>
                               </tr>
                                     <tr>
                                      <th>Installation Specifics </th>
                               <th><?= htmlspecialchars($project['installation_specifics']) ?> </th>
                                </tr>
                                </table>
                                </div>
                            </div>
                        </div> <br> <br>

                        <h3><?= htmlspecialchars($project['title6']) ?></h3> 
                    
                        <div class="row justify-content-center">
                    <?php
$steps = [
      htmlspecialchars($project['titlebox1']),  
      htmlspecialchars($project['titlebox2']),
        htmlspecialchars($project['titlebox3']),
          htmlspecialchars($project['titlebox4']),
            htmlspecialchars($project['titlebox5']),

];



                    foreach ($steps as $step): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="listing-card-one">
                                <img src="admin/uploads/<?php echo htmlspecialchars($project['image5']); ?>" alt="Image">
                                <div class="listing-card-info">
                                    <h3><a><?= htmlspecialchars($step) ?></a></h3>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <h3>"What Our Client Says"</h3> 
                        <div class="author-box">
                            <div class="author-img">
                                <img src="assets/img/author-2.webp" alt="Image">
                            </div>
                            <h4>Wangda Project Manager</h4>
                            <p>NDSS's commitment to excellence and reliability ensured that our facility has the power it needs to operate without interruption. Their team’s expertise in handling this large-scale project was nothing short of impressive.</p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Details Section End -->


        

        <!-- Footer Section Start -->
        <?php include 'footer.php'; ?>
        <!-- Footer Section End -->
        
        <!-- Back-to-top button Start -->
        <div class="paginacontainer">	
            <div class="progress-wrap bounce">
                <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                    <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
                </svg>
            </div>
        </div> 
        <!-- Back-to-top button End -->
        <script>
            const container = document.querySelector('#containers');
document.querySelector('.slider').addEventListener('input', (e) => {
  container.style.setProperty('--position', `${e.target.value}%`);
})
</script>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4382H0DQZP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-4382H0DQZP');
</script>


        <!-- Link of JS files -->
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/form-validator.min.js"></script>
        <script src="assets/js/contact-form-script.js"></script>
        <script src="assets/js/aos.js"></script>
        <script src='https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js'></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/jquery.appear.js"></script>
        <script src="assets/js/odometer.min.js"></script>
        <script src="assets/js/fslightbox.js"></script>
        <script src="assets/js/tweenmax.min.js"></script>
        <script src="assets/js/main.js"></script>

    </body>

</html>