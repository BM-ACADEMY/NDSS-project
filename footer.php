
<style>
    /* Carousel styles */
    .location-carousel {
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .carousel-slide {
        display: none;
    }

    .carousel-slide.active {
        display: block;
    }

   
    .location-item ion-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .carousel-nav {
        text-align: center;
        margin-top: 10px;
    }

    .carousel-nav button {
        background-color: transparent;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 10px;
        margin: 0 5px;
    }

    .carousel-nav button:hover {
        color: #007bff;
    }
</style>

<footer class="footer-wrap">
            <div class="container">
                <div class="row pt-100 pb-75">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <a href="index.php" class="footer-logo">
                                <img src="assets/img/logwhite.png" alt="Image" class="footlogo">
                            </a>
                           <p class="footer-description">
                               Powering Progress, Fueling Trust. 
                               NDSS – Your Reliable Partner for Diesel Generators, Sales, Service & Spares. Contact us for 24/7 support!
                               </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <h3 class="footer-widget-title">Quick Link</h3>
                            <ul class="footer-menu list-style">
                                <li>
                                    <a href="index.php">
                                        <i class="fa fa-angle-right"></i>
                                       Home
                                    </a>
                                </li>
                                <li>
                                    <a href="about.php">
                                        <i class="fa fa-angle-right"></i>
                                       About Us
                                    </a>
                                </li>
                                <li>
                                    <a href="product.php">
                                        <i class="fa fa-angle-right"></i>
                                       Products
                                    </a>
                                </li>
                                
                            
                                <li>
                                    <a href="contact.php">
                                        <i class="fa fa-angle-right"></i>
                                        Contact Us
                                    </a>
                                </li>
                                <li>
                                    <a href="Terms.php">
                                        <i class="fa fa-angle-right"></i>
                                        Terms & Conditions
                                    </a>
                                </li>
                                <li>
                                    <a href="privacy.php">
                                        <i class="fa fa-angle-right"></i>
                                       Privacy Policy
                                    </a>
                                </li>
                               
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <h3 class="footer-widget-title">Services</h3>
                            <ul class="footer-menu list-style">
                                <li>
                                    <a href="cleaningprocess.php">
                                        <i class="fa fa-angle-right"></i>
                                        Cleaning Process
                                    </a>
                                </li>
                                <li>
                                    <a href="maintance.php">
                                        <i class="fa fa-angle-right"></i>
                                        Maintenance
                                    </a>
                                </li>
                                <li>
                                    <a href="general.php">
                                        <i class="fa fa-angle-right"></i>
                                        General Inspection 
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php">
                                        <i class="fa fa-angle-right"></i>
                                        Lubrication Service
                                    </a>
                                </li>
                              
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="footer-widget">
        <h3 class="footer-widget-title">Contact</h3>
       
            <ul class="contact-info list-style">  
        <!-- Carousel container -->
        <div class="location-carousel">
            
                   <li>
                          <div class="carousel-slide">
                <!-- Third Location -->
                <div class="location-item">
                    <ion-icon name="location"></ion-icon>
                      <h6>Address</h6>
                    <p>Plot no : 15,16 & 17
Sadyapallam,
1 st cross street,
( Backside of Gundupalayam Mariamman temple )
Pondicherry- 605009.</p>
                </div>
            </div>
            <div class="carousel-slide">
                <!-- First Location -->
                <div class="location-item">
                    <ion-icon name="location"></ion-icon>
                     <h6>Address</h6>
                    <p>No.9/X1, Phase 3 Vallalar, Sathuvachari, Vellore - 632 009</p>
                </div>
            </div>
            <div class="carousel-slide">
                <!-- Second Location -->
                <div class="location-item">
                    <ion-icon name="location"></ion-icon>
                      <h6>Address</h6>
                    <p>No.21A, Poonamallee High Rd, Rajiv Nagar, Pallikuppam, Vanagaram, Chennai - 600077</p>
                </div>
            </div>
         
            </li>
        </div>

        <!-- Navigation buttons -->
  

        <!-- Contact Information -->
       
            <li>
                <ion-icon name="mail"></ion-icon>
                <h6>Email</h6>
                <a href="mailto:karthikj@ndsspondy.com"><span class="__cf_email__" data-cfemail="7e161b1212113e13110a1104501d1113">karthikj@ndsspondy.com</span></a>
            </li>
            <li>
                <ion-icon name="call"></ion-icon>
                <h6>Phone</h6>
                <a href="tel:+91 97860 09096">+91 97860 09096</a>
            </li>
        </ul>
    </div>
</div>

                </div>
            </div>
            <p class="copyright-text">
    <i class="ri-copyright-line"></i> 
    <span id="year"></span> Maintained by 
    <a href="https://www.ndsspondy.com/">Network Diesel Sales & Service | Reliable Power, Trusted Service</a>
</p>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>

        </footer>
        
        
        <script>
    let currentSlide = 0;

    function showSlide(index) {
        let slides = document.querySelectorAll('.carousel-slide');
        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }

        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === currentSlide) {
                slide.classList.add('active');
            }
        });
    }

    function moveSlide(direction) {
        showSlide(currentSlide + direction);
    }

    // Automatically show the first slide initially
    showSlide(currentSlide);

    // Optionally, set an interval to auto-slide every 5 seconds
    setInterval(() => {
        moveSlide(1);
    }, 5000);// Change slide every 5 seconds
</script>


