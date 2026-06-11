

<style>
    .location-text:not(:last-child) {
    border-bottom: 1px solid #cfcfcf;
    margin-bottom: 18px;
}

.location-text {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    cursor: pointer;
    flex-wrap: wrap;
}

.location-text p {
    font-size: 18px;
    padding-top: 4px;
    padding-bottom: 20px;
    margin-right: 10px;
    flex: 1 1 100%; /* Makes sure the text wraps in mobile view */
}

.location-text h4 {
    font-weight: 800;
}

.location-style {
    border: 5px solid #8cc63f;
    padding: 40px;
    border-radius: 22px;
    border-bottom-left-radius: 130px;
    width: 100%; /* Ensure it's full width in mobile */
    margin-bottom: 20px; /* Add margin between locations */
}

.location-text i {
    background-color: #f3f3f3;
    color: #737373;
    padding: 10px;
    border-radius: 50%;
    line-height: 1;
    font-size: 20px;
}

.location {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.location iframe {
    width: 100%;
    border-radius: 35px;
    height: 400px;
    margin-top: 30px;
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
}

@media (min-width: 768px) {
    .location {
        flex-wrap: nowrap;
    }

    .location-style {
        width: 35%;
    }

    .location iframe {
        width: 65%;
        height: 560px;
    }
}

@media (max-width: 767px) {
    .location-text {
        flex-direction: column; /* Stack the content vertically on smaller screens */
        align-items: flex-start;
    }

    .location-text i {
        margin-top: 10px; /* Add some space between the text and icon */
    }

    .location-style {
        padding: 20px;
    }
}

</style>


<section class="gap">
    <div class="container">
        <div class="heading">
            <img src="assets/img/heading-img.png" alt="heading-img">
            <p>Find Location</p>
            <h2>Find a Laundromat</h2>
        </div>
        <div class="location">
            <div class="location-style">
                <!-- Location Area #1 -->
                <div class="location-text" onclick="changeLocation('location1')">
                    <div>
                        <a href="javascript:void(0);"><h4>Location Area #1</h4></a>
                        <p>Town, new Fairground Rd, FL 3290 United States</p>
                    </div>
                    <i class="fa-solid fa-location-crosshairs"></i>
                </div>
                
                <!-- Location Area #2 -->
                <div class="location-text" onclick="changeLocation('location2')">
                    <div>
                        <a href="javascript:void(0);"><h4>Location Area #2</h4></a>
                        <p>Town, new Fairground Rd, FL 3290 United States</p>
                    </div>
                    <i class="fa-solid fa-location-crosshairs"></i>
                </div>
                
                <!-- Location Area #3 -->
                <div class="location-text" onclick="changeLocation('location3')">
                    <div>
                        <a href="javascript:void(0);"><h4>Location Area #3</h4></a>
                        <p>Town, new Fairground Rd, FL 3290 United States</p>
                    </div>
                    <i class="fa-solid fa-location-crosshairs"></i>
                </div>
                
                <!-- Location Area #4 -->
                <div class="location-text end" onclick="changeLocation('location4')">
                    <div>
                        <a href="javascript:void(0);"><h4>Location Area #4</h4></a>
                        <p>Town, new Fairground Rd, FL 3290 United States</p>
                    </div>
                    <i class="fa-solid fa-location-crosshairs"></i>
                </div>
            </div>
            
            <!-- Initial map iframe -->
            <iframe id="location-map" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14777.131289239378!2d80.1466098!3d13.0618793!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a528bb2f3a76eb7%3A0x5c455d1e9a6d121c!2sNetwork%20Diesel%20Sales%20and%20Service%20-%20Generator%20Rental%20%7C%20Generator%20Sales%20and%20Spares%20%7C%20Kirloskar%20Generator%20Dealers%20in%20Chennai!5e1!3m2!1sen!2sin!4v1732613380160!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
