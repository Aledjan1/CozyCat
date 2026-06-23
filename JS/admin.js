// Get the theme toggle button from the page
const themeToggle = document.getElementById("themeToggle");

// Run theme logic only if the button exists
if (themeToggle) {
    // Load the saved theme from localStorage
    if (localStorage.getItem("adminTheme") === "dark") {
        document.body.classList.add("dark");
    }
    // Switch between light and dark mode when clicked
    themeToggle.addEventListener("click", function () {
        // Add or remove the dark class
        document.body.classList.toggle("dark");

        // Save the selected theme in localStorage
        if (document.body.classList.contains("dark")) {
            localStorage.setItem("adminTheme", "dark");
        } else {
            localStorage.setItem("adminTheme", "light");
        }
    });
}