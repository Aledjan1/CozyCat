// Get mobile menu elements from the page
const menuToggle = document.querySelector(".menu_toggle");
const mobileMenu = document.querySelector(".mobile_menu");
const mobileOverlay = document.querySelector(".mobile_overlay");
const mobileClose = document.querySelector(".mobile_close");

// Open the mobile menu when the menu button is clicked
menuToggle.addEventListener("click", function() {
    mobileMenu.classList.add("active");  // Show mobile menu
    mobileOverlay.classList.add("active");  // Show dark background overlay
});

// Close the mobile menu when the close button is clicked
mobileClose.addEventListener("click", function() {
    mobileMenu.classList.remove("active"); // Hide mobile menu
    mobileOverlay.classList.remove("active"); // Hide dark background overlay
});

// Close the mobile menu when the overlay is clicked
mobileOverlay.addEventListener("click", function() {
    mobileMenu.classList.remove("active"); // Hide mobile menu
    mobileOverlay.classList.remove("active"); // Hide dark background overlay
});

// Close the mobile menu from other functions
// This function can be called from menu links
function closeMobileMenu () {
    mobileMenu.classList.remove("active"); // Hide mobile menu
    mobileOverlay.classList.remove("active"); // Hide dark background overlay
}