
        <footer class="footer">
            <div class="footer_container">
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
                <div class="footer_col">
                    <h3>Quick Links</h3>
                    <a href="index.php">Home</a>
                    <a href="products.php">Products</a>
                    <a href="about.php">About</a>
                    <a href="care.php">Care</a>
                </div>
                <div class="footer_col">
                    <h3>Customer Service</h3>
                    <a href="#">Shipping & Delivery</a>
                    <a href="#">Returns</a>
                    <a href="#">FAQs</a>
                    <a href="#">Terms & Conditions</a>
                </div>
                <div class="footer_col">
                    <h3>Contact Us</h3>
                    <p>📧 info@cozycathomes.co.uk</p>
                    <p>📞 +44 1234 567890</p>
                    <p>📍 123 Cat Lane, London, UK</p>
                </div>
                <div class="footer_col">
                    <h3>Follow Us</h3>
                    <div class="social_icons">
                        <a href="https://www.instagram.com/"><img src="images/instagram.png" alt="Instagram" class="icon"></a>
                        <a href="https://www.facebook.com/"><img src="images/facebook.png" alt="Facebook"  class="icon"></a>
                        <a href="https://www.pinterest.com/"><img src="images/printerest.png" alt="Pinterest"  class="icon"></a>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                © 2026 CozyCat Homes. All rights reserved. 🐾
            </div>
        </footer>
    </div>
    <form id="loginForm" class="popup" action="auth/login.php" method="POST">
        <div class="popup_content auth_box">
            <span onclick="closeLogin()" class="close">✖️</span>
            <div class="user_icon">👤</div>
                <h2>Login</h2>
                <?php if (isset($_SESSION['login_error'])): ?>
                     <p class="login_error">
                        <?php
                            echo $_SESSION['login_error'];
                            unset($_SESSION['login_error']);
                         ?>
                    </p>
                <?php endif; ?>
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
    <form id="registerForm" class="popup" action="auth/register.php" method="POST">
        <div class="popup_content auth_box">
            <span onclick="closeRegister()" class="close">✖️</span>
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
    <div id="cart" class="cart_box">
            <div class="cart_content">
                <span onclick="closeCart()" class="close">✖️</span>
                <h2>Your Cart</h2>
                <p>No items yet</p>
            </div>
        </div>
    <script src="JS/common.js"></script>
    <script src="JS/menu.js"></script>
    <?php  if (!empty($pageJs)): ?>
        <script src="<?php echo $pageJs; ?>"></script>
    <?php endif; ?>
</body>
</html>
