<?php
    // Start session for user data and site features
    session_start();

    // Set page information for the header
    $pageTitle = "Care";
    $activePage = "care";
    $pageCss = "CSS/care.css";
    $pageJs = "";

    // Include the site header
    include "includes/header.php";
?>
<!-- Main care banner -->
<section class="care_banner">
    <div class="banner_content">
            <h2 class="banner_title">Cat House Care Guide<img src="images/paw.png" class="paws" alt="cats paws"></h2>
            <p class="banner_text">Simple tips to keep your cat's house clean,<br>
                safe and comfortable for years to come.</p>
        </div>
</section>
<!-- Main care rules -->
<section class="care_essentials">
    <h3>Care Essentials<img src="images/paw.png" class="paws" alt="cats paws"></h3>
    <div class="care_essential_text">
        <img src="images/brush.png" alt="clean brush" class="care_icon">
        <h4>1. Clean Regularly</h4>
        <p>Vacuum or brush the house<br>regularly to remove fur,<br> dust and dirt</p>
    </div>
    <div class="care_essential_text">
        <img src="images/protect.png" alt="sing protective shield" class="care_icon">
        <h4>2. Check for Damage</h4>
        <p>Inspect the house for any<br>damage or loose parts and<br>repair if needed.</p>
    </div>
    <div class="care_essential_text">
        <img src="images/drop.png" alt="water drop" class="care_icon">
        <h4>3. Keep It Dry</h4>
        <p> Place the house in a dry,<br>well-ventilated area to<br>prevent mold and odors.</p>
    </div>
    <div class="care_essential_text">
        <img src="images/house.png" alt="house" class="care_icon">
        <h4>4. Perfect Location</h4>
        <p>Keep the house in a quiet<br>warm spot where your cat<br>feels safe and relaxed.</p>
    </div>
</section>
<!-- Extra care information -->
<section class="care_tips">
    <!-- Cleaning tips for different materials -->
    <div class="care_material">
        <h3>Cleaning Different Materials<img src="images/paw.png" class="paws" alt="cats paws"></h3>

        <div class="care_material_item">
            <div class="care_material_icon">
                <img src="images/lumbers.png" alt="lumbers" class="care_icon">
            </div>
            <div>
                <h4>Wooden Houses</h4>
                <p>Wipe with a damp cloth and mild soap. Avoid soaking the wood.</p>
            </div>
        </div>

        <div class="care_material_item">
            <div class="care_material_icon">
                <img src="images/wicker_basket.png" alt="wicker basket" class="care_icon">
            </div>
            <div>
                <h4>Wicker Houses</h4>
                <p>Use a soft brush to remove dust. Keep away from excessive moisture.</p>
            </div>
        </div>

        <div class="care_material_item">
            <div class="care_material_icon">
                <img src="images/felt_house.png" alt="felt small house" class="care_icon">
            </div>
            <div>
                <h4>Felt Houses</h4>
                <p>Use a lint roller or soft brush. Spot clean stains gently.</p>
            </div>
        </div>
    </div>
     <!-- Additional care tips -->
    <div class="care_extra_tips">
        <h3>Extra Tips<img src="images/paw.png" class="paws" alt="cats paws"></h3>

        <div class="extra_tips">
            <div class="tip_icon">✓</div>
            <p>Add a soft blanket and wash it regularly.</p>
        </div>

        <div class="extra_tips">
            <div class="tip_icon">✓</div>
            <p>Air out the house every few weeks.</p>
        </div>

        <div class="extra_tips">
            <div class="tip_icon">✓</div>
            <p>Replace worn-out parts for your cat's safety and comfort.</p>
        </div>

        <div class="extra_tips">
            <div class="tip_icon">✓</div>
            <p>Every cat is different - observe what your cat loves!</p>
        </div>
    </div>
    <!-- Thank you message -->
    <div class="care_thank_you">
        <img src="images/care_cat_house.png" alt="Cat in a cat house">

        <div class="thank_you_text">
            <div class="heart_icon">❤️</div>
            <p>
                A well-cared-for home means a happy cat!<br>
                Thank you for choosing CozyCat Homes.
            </p>
        </div>
    </div>
</section>
<?php 
// Include the site footer
    include "includes/footer.php";
?>
