function openLogin() {
    document.getElementById("loginForm").style.display = "block";
    document.getElementById("registerForm").style.display = "none";
}

function openRegister() {
    document.getElementById("registerForm").style.display = "block";
    document.getElementById("loginForm").style.display = "none";
}

function closeLogin() {
    document.getElementById("loginForm").style.display = "none";
}

function closeRegister() {
    document.getElementById("registerForm").style.display = "none";
}

function openCart() {
    document.getElementById("cart").style.display = "block";
    loadCart();
}

function closeCart() {
    document.getElementById("cart").style.display = "none";
}

function toggleSearch() {
    document.getElementById("searchBox").classList.toggle("active");
}

function toggleFavorites() {
    let box = document.getElementById("favoritesBox");
    if (box.style.display === "block") {
        box.style.display = "none";
    } else {
        box.style.display = "block";
        loadFavorites();
    }
}

function closeFavorites() {
    document.getElementById("favoritesBox").style.display = "none";
}

function toggleTheme() {
    document.body.classList.toggle("dark");

    if(document.body.classList.contains('dark')) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
    }
})

const products = [
    { name: "Wooden House", category: "Indoor Houses", url: "products.php?search=Wooden%20House" },
    { name: "Wicker House", category: "Indoor Houses", url: "products.php?search=Wicker%20House" },
    { name: "Felt Cave", category: "Indoor Houses", url: "products.php?search=Felt%20Cave" }, 
    { name: "Modern Cube", category: "Modern Houses", url: "products.php?search=Modern%20House" },
    {name: "Outdoor House", category: "Outdoor Houses", url: "products.php?search=Outdoor%20House" },
    {name: "Luxury House", category: "Luxury Houses", url: "products.php?search=Luxury%20House"}
];

function liveSearch() {
    let input = document.getElementById("siteSearchInput");
    let resultsBox = document.getElementById("searchResults");

    if(!input || !resultsBox) return;

    let searchText = input.value.toLowerCase();
    resultsBox.innerHTML = "";

    if (searchText.length === 0) return;


    let filteredProducts = products.filter(function(product) {
        return product.name.toLowerCase().includes(searchText) ||
        product.category.toLowerCase().includes(searchText);
    });

    if (filteredProducts.length === 0) {
        resultsBox.innerHTML = "<p>No result found</p>";
        return
    }

    filteredProducts.forEach(function(product) {
        resultsBox.innerHTML += `
            <a href="${product.url}">
                <strong>${product.name}</strong><br>
                <small>${product.category}</small>
            </a>
        `;
    });
}

window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});

document.addEventListener("click", function(event) {
    let heart = event.target.closest(".favorite_btn");

    if (!heart) return;

    event.preventDefault();
    event.stopPropagation();

    let productID = heart.dataset.productId;

    fetch("toggle_favorite.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "productID=" + productID
    })
    .then(response => response.text())
    .then(result => {
        result = result.trim();

        if (result === "login-required") {
            openLogin();
            return;
        }

        if (result === "added") {
            heart.textContent = "❤️";
            heart.classList.add("active");
        } else {
            heart.textContent = "♡";
            heart.classList.remove("active");
        }

        loadFavorites();
    });
});

function loadFavorites() {
    fetch("favorites_list.php")
    .then(response => response.text())
    .then(data => {
        document.querySelector(".favorite_content").innerHTML = data;
    });
}

document.addEventListener("click", function(event) {
    let button = event.target.closest(".add_cart_btn");
    
    if (!button) return;

    event.preventDefault();
    event.stopPropagation();

    let productID = button.dataset.productId;

    fetch("add_to_cart.php", {
        method: "POST",
        headers: {
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:"productID=" + productID
    })
    .then(response => response.text())
    .then(count => {
         document.querySelector(".cart_count").textContent = count;

         button.innerHTML = "✅ In Basket";
        button.style.background = "#4CAF50";
        button.disabled = true;
    });
});

function loadCart() {
    fetch("cart_list.php")
    .then(response => response.text())
    .then(data => {
        document.querySelector(".cart_content").innerHTML = data;
    });
}

// add and reduce items in a cart count
document.addEventListener("click", function(event) {
    let btn = event.target.closest(".cart_qty_btn");

    if (!btn) return;

    event.preventDefault();

    let productID = btn.dataset.productId;
    let action = btn.dataset.action;

    fetch("update_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "productID=" + productID + "&action=" + action 
    })
    .then(response => response.text())
    .then(count => {
        let cartCounter = document.querySelector(".cart_count");

        if (cartCounter) {
            cartCounter.textContent = count;
        }

        loadCart();
    });
});

//add items to Cart from Favorites box
document.addEventListener("click", function(event) {
    let addBtn = event.target.closest(".favorite_add_cart");

    if (!addBtn) return;

    event.preventDefault();

    let productID = addBtn.dataset.productId;

    fetch("add_to_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "productID=" + productID
    })
    .then(response => response.text())
    .then(count => {
        document.querySelector(".cart_count").textContent = count;
        addBtn.textContent = "✅ Added";
    });
});

//remove items from Favorites box
document.addEventListener("click", function(event) {
    let removeBtn = event.target.closest(".favorite_remove");

    if (!removeBtn) return;

    event.preventDefault();

    let productID = removeBtn.dataset.productId;

    fetch("toggle_favorite.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "productID=" + productID
    })
    .then(response => response.text())
    .then(() => {
        loadFavorites();

        let heart = document.querySelector('.favorite_btn[data-product-id="' + productID + '"]');
        if (heart) {
            heart.textContent = "♡";
            heart.classList.remove("active");
        }
    });
});

window.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);

    if (params.get("login") === "error") {
        document.getElementById("loginForm").style.display = "flex";
    }
});


