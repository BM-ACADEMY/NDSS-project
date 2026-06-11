<style>
/* Slide in from left */
@keyframes slideInLeft {
  0% {
    opacity: 0;
    transform: translateX(-100px);
  }
  100% {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Slide in from right */
@keyframes slideInRight {
  0% {
    opacity: 0;
    transform: translateX(100px);
  }
  100% {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Add animation classes */
.slide-left {
  animation: slideInLeft 1.2s ease forwards;
}

.slide-right {
  animation: slideInRight 1.2s ease forwards;
}

.parent {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(5, 1fr);
    gap: 8px;
}
    
.div1 {
    grid-column: span 5 / span 5;
}

.parent {
  width: 100%;
  padding: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f5f5f5;
}

.div1 {
  width: 100%;
  padding: 50px;
  background-color: white;
}

.div1 img {
  width: 100%;
  height: auto;
  display: block;
}

/* Responsive tweaks for small/mobile screens */
@media (max-width: 480px) {
  .div1 {
    padding: 5px;
    border: 1px solid #aaa;
    max-width: 100%; /* allow full width on very small screens */
  }

  .parent {
    padding: 5px;
  }
}
</style>

<?php include 'header.php'; ?>

<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap bg-f br-1">
    <div class="container">
        <div class="breadcrumb-title">
            <h2>About Us</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="index.html">Home </a></li>
                <li>About Us</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- About Section Start -->
<section class="about-wrap ptb-100 bg_ash">
    <div class="container">
        <div class="row align-items-center gx-5">
            <div class="col-lg-6">
                <div class="about-img-wrap">
                    <img src="assets/img/md.jpg_">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="content-title-two">
                        <h2>J.Karthikeyan <span> (Managing Director & Chairman)</span></h2>
                        <p>NETWORK DIESEL SALES & SERVICE is a firm started in 2003 with an amalgamation of over more than 18 years rich experience, dedicated service and ultimate customer satisfaction. The integral part is constituted with several years of thorough field knowledge, experience and exposure to various customers and fulfilled their needs to their utmost satisfaction level. Network Diesel Sales & Service is a Dealer of Greaves Cotton Ltd., from March 2011.</p>
                    </div> <br> 
                    <div>
                        <h2>Our Organization</h2>
                        <p>The business is driven by our 2 working partners, collectively they accumulated 18 years work experience in the Gen-Set Field. They are involved in the business development, procurement, project management and administration of the company. The management proactively gathers feedback, identifies changes in business environment, reviews work processes and communicates key learning points and company policy to all staff at regular meetings.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<div class="parent">
    <div class="div1">
        <img src="assets/img/Organization_Chart.jpg">
    </div>
</div>

<!-- Mission and Vision Section -->
<section class="about-wrap pt-100 pb-75" id="about">
    <div class="container">
        <div class="row align-items-center gx-5">
            <div class="col-lg-6">
                <img src="assets/img/ourmission.png" class="slide-left">
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="content-title-two slide-right">
                        <h2>Our Mission</h2>
                        <p>Our mission is to be the leading provider of diesel generators, offering exceptional sales, service, and rental options. We are committed to providing our customers with reliable and efficient solutions to their power needs, and to continuously improving our services to meet their evolving needs.</p>
                    </div> 
                </div>
            </div>
        </div>

        <div class="row align-items-center gx-5">
            <div class="col-lg-6 order-lg-1 order-2">
                <div class="about-content">
                    <div class="content-title-two slide-left">
                        <h2>Our Vision</h2>
                        <p>Our vision at NDSS-Network Diesel Sales & Service is to be the premier diesel generator sales, service, and rental company in the industry. We are committed to providing the highest quality products and services, backed by exceptional customer service and support. Our goal is to exceed the expectations of our clients, and to be a trusted partner in their success.</p>
                    </div> 
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-1">
                <img src="assets/img/visions.png" style="width: 400px;" class="slide-right">
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/form-validator.min.js"></script>
<script src="assets/js/contact-form-script.js"></script>
<script src="assets/js/aos.js"></script>
<script src='https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js'></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.appear.js"></script>
<script src="assets/js/fslightbox.js"></script>
<script src="assets/js/tweenmax.min.js"></script>
<script src="assets/js/main.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

<script>
// Add intersection observer for animations
document.addEventListener('DOMContentLoaded', function() {
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.slide-left, .slide-right');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateX(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(element => {
            // Set initial state
            element.style.opacity = 0;
            if (element.classList.contains('slide-left')) {
                element.style.transform = 'translateX(-100px)';
            } else if (element.classList.contains('slide-right')) {
                element.style.transform = 'translateX(100px)';
            }
            
            // Start observing
            observer.observe(element);
        });
    };

    animateOnScroll();
});
</script>