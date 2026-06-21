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

let currentSlide = 0;

function showSlide(index) {
    let banner = document.querySelector(".banner");
    let title = document.getElementById("bannerTitle");
    let text = document.getElementById("bannerText");

    if (!banner || !title || !text) {
        return;
    }

    banner.style.backgroundImage = `url('${slides[index].image}')`;
    banner.style.backgroundPosition = slides[index].position;
    title.textContent = slides[index].title;
    text.textContent = slides[index].text;
}

function nextSlide() {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide(currentSlide);
}

document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector(".banner")) {
        showSlide(currentSlide);
        setInterval(nextSlide, 3000);
    }
});




