

<style>
    .ctas{
        width: 80%;
    margin: 100px auto;
    background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(assets/img/15286.jpg);
    background-size: cover;
    border-radius: 10px;
    text-align: center;
    padding: 250px 0;
    }
</style>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4382H0DQZP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-4382H0DQZP');
</script>

<?php include 'header.php'; ?> 
<?php include 'db.php'; ?> 

<div class="loader js-preloader">
            <img src="assets/img/logo.webp" width="102" height="40" >
          
        </div> 

        <div class="breadcrumb-wrap bg-f br-1">
            <div class="container">
                <div class="breadcrumb-title">
                    <h2>Carrer Page</h2>
                    <ul class="breadcrumb-menu list-style">
                        <li><a href="index.html">Home </a></li>
                        <li>Carrer Page</li>
                    </ul>
                </div>
            </div>
        </div>

        <section id="jobs">
    <div class="container">
        <h5 class="text-center">RECENT JOB UPDATES</h5> <br>

        <?php
        $sql = "SELECT * FROM jobs";
        $result = $conn->query($sql);
        ?>
        
        <?php
        // Check if there are any results from the database
        if ($result->num_rows > 0) {
            // Loop through the results and display them in the HTML
            while ($row = $result->fetch_assoc()) {
                echo '<div class="company-details">';
                echo '<div class="job-update">';
                echo '<h4><strong>' . htmlspecialchars($row["jobname"]) . '</strong></h4>';
                
                echo '<p><strong>Qualification</strong> <i class="fa fa-angle-double-right"></i> ' . htmlspecialchars($row["qualification"]) . '</p>';
                echo '<i class="fa fa-briefcase"></i><span>' . htmlspecialchars($row["experience"]) . '</span><br>';
                echo '<i class="fa fa-inr"></i><span class="price">' . htmlspecialchars($row["salary"]) . '</span><br>';
                echo '<i class="fa fa-map-marker"></i><span class="location">' . htmlspecialchars($row["location"]) . '</span>';
                echo '<p><strong>Description</strong> <i class="fa fa-angle-double-right"></i> ' . htmlspecialchars($row["jobdescription"]) . '</p>';
                echo '</div>';
                echo '<div class="apply-btn">';
                echo '<button type="button" class="btn btn-primary applyBtn" data-jobname="' . htmlspecialchars($row["jobname"]) . '">Apply</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No job updates available.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</section>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1 id="modalTitle">Job Form</h1>
     
        <form action="job.php" method="POST" enctype="multipart/form-data" id="survey-form">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required><br><br>

            <label for="phoneNumber">Phone Number:</label>
            <input type="text" id="phoneNumber" name="phoneNumber" required><br><br>

            <label for="position">Position Applied For:</label>
            <input type="text" id="position" name="position" required readonly><br><br>

            <label for="experienceLevel">Experience Level:</label>
            <select id="experienceLevel" name="experienceLevel" required>
                <option value="Fresher">Fresher</option>
                <option value="1-2 Years">1-2 Years</option>
                <option value="3-5 Years">3-5 Years</option>
                <option value="5+ Years">5+ Years</option>
            </select><br><br>

            <label for="resume">Upload Resume (PDF or Word):</label>
            <input type="file" id="resume" name="resume" accept=".pdf, .doc, .docx" required><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</div>

    <section class="ctas">
      <h1>
       Be part of a team that powers industries. Apply now!
      </h1>
                            <div class="cta-btn">
                              
                                <a href="contact.php" class="btn-three">Join Our Team</a>
                            </div>
    </section>

<?php include 'footer.php'; ?>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Get all "Apply" buttons
    var applyButtons = document.getElementsByClassName("applyBtn");

    // Loop through all apply buttons and add click event
    Array.from(applyButtons).forEach(function(btn) {
        btn.onclick = function() {
            // Set the job name in the modal
            document.getElementById("modalTitle").textContent = "Applying for: " + btn.getAttribute('data-jobname');
            document.getElementById("position").value = btn.getAttribute('data-jobname'); // Set position in the form
            modal.style.display = "block"; // Show the modal
        }
    });

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4382H0DQZP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-4382H0DQZP');
</script>
