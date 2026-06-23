<!-- Site footer -->
<footer class="footer">
    <!-- Footer main content -->
    <div class="footer_container">
         <!-- Footer logo and copyright -->
        <div class="footer_logo">
            <div class="footer_brand">
                <img src="images/animal-shelter.png" alt="CozyCat logo">
                <div class="footer_logo">
                    <h2>Cozy<span style="color:#DB5C69">Cat</span></h2>
                    <p><img src="images/paw.png" alt="cats paws" class="paws">HOMES<img src="images/paw.png" alt="cats paws" class="paws"></p>
                </div>
            </div>
            <p class="copyright">© 2026 CozyCat Homes.<br>
                All rights reserved.</p>
        </div>
        <!-- Main navigation links -->
        <div class="footer_col">
            <h3>Quick Links</h3>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="about.php">About</a>
            <a href="care.php">Care</a>
        </div>
         <!-- Customer service links -->
        <div class="footer_col">
            <h3>Customer Service</h3>
            <a href="#">Shipping & Delivery</a>
            <a href="#">Returns</a>
            <a href="#">FAQs</a>
            <a href="#">Terms & Conditions</a>
        </div>
         <!-- Contact information -->
        <div class="footer_col">
            <h3>Contact Us</h3>
            <p>📧 info@cozycathomes.co.uk</p>
            <p>📞 +44 1234 567890</p>
            <p>📍 123 Cat Lane, London, UK</p>
        </div>
         <!-- Social media links -->
        <div class="footer_col">
            <h3>Follow Us</h3>
            <div class="social_icons">
                <a href="https://www.instagram.com/"><img src="images/instagram.png" alt="Instagram" class="icon"></a>
                <a href="https://www.facebook.com/"><img src="images/facebook.png" alt="Facebook"  class="icon"></a>
                <a href="https://www.pinterest.com/"><img src="images/printerest.png" alt="Pinterest"  class="icon"></a>
            </div>
        </div>
    </div>
    <!-- Footer bottom text -->
    <div class="footer_bottom">
        © 2026 CozyCat Homes. All rights reserved. 🐾
    </div>
</footer>
</div>
<!-- Login popup form -->
<form id="loginForm" class="popup" action="auth/login.php" method="POST">
    <!-- Login popup content -->
    <div class="popup_content auth_box">
        <!-- Close login popup button -->
        <span onclick="closeLogin()" class="close">✖️</span>
        <div class="user_icon">👤</div>
            <h2>Login</h2>
            <!-- Login error message from session -->
            <?php if (isset($_SESSION['login_error'])): ?>
                <p class="login_error">
                    <?php
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                    ?>
                 </p>
            <?php endif; ?>
            <!-- Login email and password fields -->
        <div class="input_box">
            <span>✉️</span>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input_box">
            <span>🔒</span>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <a href="#" class="forgot">Forgot password</a>
        <button type="submit" class="auth_btn">Login</button>   
    </div>
</form>
<!-- Register popup form -->
<form id="registerForm" class="popup" action="auth/register.php" method="POST">
    <!-- Register popup content -->
    <div class="popup_content auth_box">
        <!-- Close register popup button -->
        <span onclick="closeRegister()" class="close">✖️</span>
        <!-- Register user fields -->
        <div class="user_icon">👤</div>
        <h2>Register</h2>
        <div class="input_box">
            <span>👤</span>
            <input type="text" name="name" placeholder="First name" required>
        </div>
        <div class="input_box">
            <span>👤</span>
            <input type="text" name="lastname" placeholder="Last name" required>
        </div>
        <div class="input_box">
            <span>✉️</span>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input_box">
            <span>🔒</span>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="auth_btn">Sign up</button>
    </div>
</form>
<!-- Cart popup -->
<div id="cart" class="cart_box">
     <!-- Cart content -->
    <div class="cart_content">
        <!-- Close cart popup button -->
        <span onclick="closeCart()" class="close">✖️</span>
         <!-- Cart items will be shown here -->
        <h2>Your Cart</h2>
        <p>No items yet</p>
    </div>
</div>
<!-- Main JavaScript files -->
<script src="JS/common.js"></script>
<script src="JS/menu.js"></script>
<!-- Page-specific JavaScript file -->
<?php  if (!empty($pageJs)): ?>
    <script src="<?php echo $pageJs; ?>"></script>
<?php endif; ?>
</body>
</html>
