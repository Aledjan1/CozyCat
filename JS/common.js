// Open login form and hide register form
function openLogin() {
    document.getElementById("loginForm").style.display = "block";
    document.getElementById("registerForm").style.display = "none";
}

// Open register form and hide login form
function openRegister() {
    document.getElementById("registerForm").style.display = "block";
    document.getElementById("loginForm").style.display = "none";
}

// Close login form
function closeLogin() {
    document.getElementById("loginForm").style.display = "none";
}

// Close register form
function closeRegister() {
    document.getElementById("registerForm").style.display = "none";
}

// Open cart popup and load cart items
function openCart() {
    document.getElementById("cart").style.display = "block";
    loadCart();
}

// Close cart popup
function closeCart() {
    document.getElementById("cart").style.display = "none";
}

// Show or hide the search box
function toggleSearch() {
    document.getElementById("searchBox").classList.toggle("active");
}

// Show or hide favorites box
// If the box opens, load favorite products
function toggleFavorites() {
    let box = document.getElementById("favoritesBox");
    // Hide favorites popup if it is already open
    if (box.style.display === "block") {
        box.style.display = "none";
    } else {
        box.style.display = "block";// Show favorites popup
        loadFavorites();// Load favorite products
    }
}

// Close favorites box
function closeFavorites() {
    document.getElementById("favoritesBox").style.display = "none";// Hide favorites popup
}

// Switch between light and dark theme
// Save selected theme in localStorage
function toggleTheme() {
    document.body.classList.toggle("dark"); // Add or remove dark class on the body

     // Save dark theme if it is active
    if(document.body.classList.contains('dark')) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light"); // Save light theme if dark theme is not active
    }
}

// Load saved theme when the page opens
document.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem("theme") === "dark") { // Check if dark theme was saved before
        document.body.classList.add("dark"); // Apply dark theme
    }
})

// Product data used for the live search.
// Each object has product name, category and link.
const products = [
    { name: "Wooden House", category: "Indoor Houses", url: "products.php?search=Wooden%20House" },
    { name: "Wicker House", category: "Indoor Houses", url: "products.php?search=Wicker%20House" },
    { name: "Felt Cave", category: "Indoor Houses", url: "products.php?search=Felt%20Cave" }, 
    { name: "Modern Cube", category: "Modern Houses", url: "products.php?search=Modern%20House" },
    {name: "Outdoor House", category: "Outdoor Houses", url: "products.php?search=Outdoor%20House" },
    {name: "Luxury House", category: "Luxury Houses", url: "products.php?search=Luxury%20House"}
];

// Search products while the user is typing
function liveSearch() {
     // Get search input and results container
    let input = document.getElementById("siteSearchInput");
    let resultsBox = document.getElementById("searchResults");

     // Stop if search input or results box does not exist
    if(!input || !resultsBox) return;

    // Get search text and clear previous results
    let searchText = input.value.toLowerCase();
    resultsBox.innerHTML = ""; // Clear old search results before showing new ones

    // Stop the function if the search field is empty
    if (searchText.length === 0) return;

    // Find products by name or category
    let filteredProducts = products.filter(function(product) {
        return product.name.toLowerCase().includes(searchText) ||
        product.category.toLowerCase().includes(searchText);
    });

    // Show message if no products were found
    if (filteredProducts.length === 0) {
        resultsBox.innerHTML = "<p>No result found</p>";
        return
    }

    // Show found products in the search results box
    filteredProducts.forEach(function(product) {
        resultsBox.innerHTML += `
            <a href="${product.url}">
                <strong>${product.name}</strong><br>
                <small>${product.category}</small>
            </a>
        `;
    });
}

// Reload the page if it was restored from browser cache.
// This helps show fresh cart, login and favorite data.
window.addEventListener("pageshow", function(event) {
    if (event.persisted) { // Check if the page came from browser history cache
        window.location.reload();  // Reload the page
    }
});

// Handle clicks on favorite heart buttons.
// This works for all product cards because the click is listened on the document.
document.addEventListener("click", function(event) {
    let heart = event.target.closest(".favorite_btn"); // Find the closest favorite button from the clicked element

    // Stop if the clicked element is not a favorite button
    if (!heart) return;

    // Prevent default link behavior and stop event bubbling
    event.preventDefault();
    event.stopPropagation();

    // Get product ID from the clicked favorite button
    let productID = heart.dataset.productId;

    // Send product ID to PHP to add or remove it from favorites
    fetch("toggle_favorite.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded" // Send selected product ID to the server
        },
        body: "productID=" + productID // Send selected product ID to the server
    })
    .then(response => response.text())
    .then(result => {
        result = result.trim(); // Remove extra spaces from PHP response

        // If user is not logged in, open login form
        if (result === "login-required") {
            openLogin();
            return;
        }

        // If product was added, show filled heart
        if (result === "added") {
            heart.textContent = "❤️";
            heart.classList.add("active");
        } else {
            heart.textContent = "♡";
            heart.classList.remove("active");
        }

        // Refresh favorites popup content
        loadFavorites();
    });
});

// Load favorite products from PHP and show them in the favorites popup.
function loadFavorites() {
    fetch("favorites_list.php") // Request favorites HTML from the server
    .then(response => response.text())
    .then(data => {
        document.querySelector(".favorite_content").innerHTML = data; // Put received HTML inside favorites popup
    });
}

// Handle clicks on Add to Cart buttons.
document.addEventListener("click", function(event) {
    let button = event.target.closest(".add_cart_btn"); // Find the closest add-to-cart button from the clicked element
    
    // Stop if the clicked element is not an add-to-cart button
    if (!button) return;

    // Prevent default link behavior and stop parent click events
    event.preventDefault();
    event.stopPropagation();

    // Get product ID from the clicked button
    let productID = button.dataset.productId;

    // Send product ID to PHP to add it to the cart
    fetch("add_to_cart.php", {
        method: "POST",
        headers: {
            "Content-Type":"application/x-www-form-urlencoded" // Send data in normal form format
        },
        body:"productID=" + productID // Send selected product ID to the server
    })
    .then(response => response.text())
    .then(count => { // Update cart counter in the header
         document.querySelector(".cart_count").textContent = count;

        button.innerHTML = "✅ In Basket"; // Change button text after product is added
        button.style.background = "#4CAF50"; // Change button colour to show success
        button.disabled = true;  // Disable button to prevent duplicate adding from the same card
    });
});

// Load cart items from PHP and show them in the cart popup.
function loadCart() {
    fetch("cart_list.php")  // Request cart HTML from the server
    .then(response => response.text())
    .then(data => { // Put received HTML inside cart popup
        document.querySelector(".cart_content").innerHTML = data;
    });
}

// Handle plus and minus buttons inside the cart.
// This changes product quantity in the cart.
document.addEventListener("click", function(event) {
    let btn = event.target.closest(".cart_qty_btn");  // Find the closest quantity button from the clicked element

    if (!btn) return; // Stop if the clicked element is not a quantity button

    event.preventDefault(); // Prevent default button or link behavior

    let productID = btn.dataset.productId; // Get product ID from the quantity button
    let action = btn.dataset.action; // Get action: increase or decrease

    // Send product ID and action to PHP to update the cart
    fetch("update_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded" // Send data in normal form format
        },
        body: "productID=" + productID + "&action=" + action  // Send selected product ID and action to the server
    })
    .then(response => response.text())
    .then(count => {  // Find cart counter in the header
        let cartCounter = document.querySelector(".cart_count");

        if (cartCounter) {  // Update cart counter if it exists
            cartCounter.textContent = count;
        }

        loadCart(); // Reload cart popup after quantity change
    });
});

// Handle Add to Cart button inside the favorites popup.
document.addEventListener("click", function(event) {
    let addBtn = event.target.closest(".favorite_add_cart"); // Find the clicked add-to-cart button inside favorites

    if (!addBtn) return; // Stop if the clicked element is not this button

    event.preventDefault(); // Prevent default button or link behavior

    let productID = addBtn.dataset.productId; // Get product ID from the favorites add button

    // Send product ID to PHP to add it to the cart
    fetch("add_to_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded" // Send data in normal form format
        },
        body: "productID=" + productID // Send selected product ID to the server
    })
    .then(response => response.text())
    .then(count => { // Update cart counter in the header
        document.querySelector(".cart_count").textContent = count;
        addBtn.textContent = "✅ Added"; // Change button text after adding
    });
});

// Handle remove button inside the favorites popup.
document.addEventListener("click", function(event) {
    let removeBtn = event.target.closest(".favorite_remove");  // Find the clicked remove button inside favorites

    if (!removeBtn) return; // Stop if the clicked element is not a remove button

    event.preventDefault();  // Prevent default button or link behavior

    let productID = removeBtn.dataset.productId; // Get product ID from the remove button

    // Send product ID to PHP to remove it from favorites
    fetch("toggle_favorite.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded" // Send data in normal form format
        },
        body: "productID=" + productID  // Send selected product ID to the server
    })
    .then(response => response.text())
    .then(() => {  // Reload favorites popup after removing product
        loadFavorites();

        // Find the heart icon for the same product on the page
        let heart = document.querySelector('.favorite_btn[data-product-id="' + productID + '"]');
        // Reset heart icon if product card exists on the page
        if (heart) {
            heart.textContent = "♡";
            heart.classList.remove("active");
        }
    });
});

// Open login form automatically if login error exists in the URL.
window.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);  // Read URL parameters

     // Check if URL contains login=error
    if (params.get("login") === "error") {
        document.getElementById("loginForm").style.display = "flex";
    }
});


