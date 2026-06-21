const menuToggle = document.querySelector(".menu_toggle");
const mobileMenu = document.querySelector(".mobile_menu");
const mobileOverlay = document.querySelector(".mobile_overlay");
const mobileClose = document.querySelector(".mobile_close");

menuToggle.addEventListener("click", function() {
    mobileMenu.classList.add("active");
    mobileOverlay.classList.add("active");
});

mobileClose.addEventListener("click", function() {
    mobileMenu.classList.remove("active");
    mobileOverlay.classList.remove("active");
});

mobileOverlay.addEventListener("click", function() {
    mobileMenu.classList.remove("active");
    mobileOverlay.classList.remove("active");
});

function closeMobileMenu () {
    mobileMenu.classList.remove("active");
    mobileOverlay.classList.remove("active");
}