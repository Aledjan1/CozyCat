<?php 
    session_start();

    $pageTitle = "About";
    $activePage = "about";
    $pageCss = "CSS/about.css";
    $pageJs = "";

    include "includes/header.php";
?>

<section class="about_section">
    <div class="about_content">
        <div class="about_left">
            <div class="about_text">
                <h2>About CozyCat Homes<img src="images/paw.png" alt="cat paw" class="paws"></h2>
                <p>We are small business with a big love for cats. Our mission is to create high-quality, stylish and comfortable cat houses that make every cat feel safe and happy.</p>
            </div>
            <div class="about_content_item">
                <div class="about_item">
                    <div class="about_icon">🔰</div>
                    <div>
                        <h3>Our Mission</h3>
                        <p>To provide the best homes for happy cats.</p>
                    </div>
                </div>
                <div class="about_item">
                    <div class="about_icon">🛡️</div>
                    <div>
                        <h3>Quality Materials</h3>
                        <p>We use safe, durable and eco-friendly materials.</p>
                    </div>
                </div>
                <div class="about_item">
                <div class="about_icon">❤️</div>
                <div>
                    <h3>Made with Love</h3>
                    <p>Every product is designed with care and attention.</p>
                </div>
                </div>
                <div class="about_item">
                <div class="about_icon">🚚</div>
                <div>
                    <h3>Fast Delivery</h3>
                    <p>Quick and reliable shipping across the UK.</p>
                </div>
                </div>
            </div>
        </div>
        <div class="about_image">
            <img src="images/about_cat_house.png" alt="Cat inside wooden cat house">
        </div>
    </div>
</section>
<section class="about_contact_section">
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
    <div class="about_contact_us">
        <h3>Contact Us<img src="images/paw.png" alt="cat paw" class="paws"></h3>
        <form action="contact_submit.php" method="POST">
            <div class="form_row">
                <input type="text" name="name" placeholder="Your name" required>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" placeholder="Message" required></textarea>
            <button type="submit"> Send Message ✈</button>
        </form>
    </div>
</section>
<?php 
    include "includes/footer.php";
?>