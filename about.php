<?php 
    // Start session
    session_start(); 

    // Set page settings
    $pageTitle = "About";
    $activePage = "about";
    $pageCss = "CSS/about.css";
    $pageJs = "";

    // Include header
    include "includes/header.php";
?>
<!-- About section -->
<section class="about_section">
    <!-- Main content -->
    <div class="about_content">
        <!-- Text and features -->
        <div class="about_left">
            <!-- About description -->
            <div class="about_text">
                <h2>About CozyCat Homes<img src="images/paw.png" alt="cat paw" class="paws"></h2>
                <p>We are small business with a big love for cats. Our mission is to create high-quality, stylish and comfortable cat houses that make every cat feel safe and happy.</p>
            </div>
            <!-- Company highlights -->
            <div class="about_content_item">
                <!-- Mission -->
                <div class="about_item">
                    <div class="about_icon">🔰</div>
                    <div>
                        <h3>Our Mission</h3>
                        <p>To provide the best homes for happy cats.</p>
                    </div>
                </div>
                <!-- Materials -->
                <div class="about_item">
                    <div class="about_icon">🛡️</div>
                    <div>
                        <h3>Quality Materials</h3>
                        <p>We use safe, durable and eco-friendly materials.</p>
                    </div>
                </div>
                <!-- Product quality -->
                <div class="about_item">
                <div class="about_icon">❤️</div>
                <div>
                    <h3>Made with Love</h3>
                    <p>Every product is designed with care and attention.</p>
                </div>
                </div>
                <!-- Delivery -->
                <div class="about_item">
                <div class="about_icon">🚚</div>
                <div>
                    <h3>Fast Delivery</h3>
                    <p>Quick and reliable shipping across the UK.</p>
                </div>
                </div>
            </div>
        </div>
         <!-- About image -->
        <div class="about_image">
            <img src="images/about_cat_house.png" alt="Cat inside wooden cat house">
        </div>
    </div>
</section>
<!-- Contact section -->
<section class="about_contact_section">
    <!-- Location map -->
    <div class="about_find_us">
        <h3>Find Us<img src="images/paw.png" alt="cat paw" class="paws"></h3>
        <iframe
            src="https://www.google.com/maps?q=London%20UK&output=embed"
            width="100%"
            height="280px"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>
    <!-- Contact form -->
    <div class="about_contact_us">
        <h3>Contact Us<img src="images/paw.png" alt="cat paw" class="paws"></h3>
        <!-- Send message form -->
        <form action="contact_submit.php" method="POST">
            <!-- Name and email -->
            <div class="form_row">
                <input type="text" name="name" placeholder="Your name" required>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <!-- Subject -->
            <input type="text" name="subject" placeholder="Subject" required>
            <!-- Message -->
            <textarea name="message" placeholder="Message" required></textarea>
            <!-- Submit button -->
            <button type="submit"> Send Message ✈</button>
        </form>
    </div>
</section>
<?php 
    // Include footer
    include "includes/footer.php";
?>