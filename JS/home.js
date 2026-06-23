// Slider data for banner images, titles and descriptions.
// Each object represents one slide.
let slides = [
    {
        image: "images/banner1.png",
        title: "Cozy homes for happy cats",
        text: "Stylish, comfortable and safe cat houses.",
        position: "right center"
    },
    {
        image: "images/banner2.png",
        title: "A cozy hideaway for your best friend",
        text: "Warm, soft and comfortable spaces where your cat can relax.",
        position: "right center"
    },
    {
        image: "images/banner3.png",
        title: "A purr-fect place for every cat",
        text: "Thoughtfully designed for comfort, security and sweet dreams",
        position: "right center"
    }
];

let currentSlide = 0; // Store the current slide index.

// Display the selected slide on the banner.
function showSlide(index) {
    // Get banner elements from the page
    let banner = document.querySelector(".banner");
    let title = document.getElementById("bannerTitle");
    let text = document.getElementById("bannerText");

     // Stop if banner elements do not exist
    if (!banner || !title || !text) {
        return;
    }

    banner.style.backgroundImage = `url('${slides[index].image}')`;  // Change banner background image
    banner.style.backgroundPosition = slides[index].position; // Set image position
    title.textContent = slides[index].title; // Update banner title
    text.textContent = slides[index].text; // Update banner description
}

// Move to the next slide.
function nextSlide() {
    currentSlide++; // Increase current slide index

    // Return to the first slide after the last one
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide(currentSlide);  // Display the new slide
}

// Move to the previous slide.
function prevSlide() {
    currentSlide--;  // Decrease current slide index

     // Go to the last slide if current index becomes negative
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide(currentSlide);  // Display the new slide
}

// Initialize slider when the page is loaded.
document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector(".banner")) {
        showSlide(currentSlide);  // Show the first slide
        setInterval(nextSlide, 3000);  // Automatically switch slides every 3 seconds
    }
});




