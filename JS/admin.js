const themeToggle = document.getElementById("themeToggle");

if (themeToggle) {
    if (localStorage.getItem("adminTheme") === "dark") {
        document.body.classList.add("dark");
    }

    themeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark");

        if (document.body.classList.contains("dark")) {
            localStorage.setItem("adminTheme", "dark");
        } else {
            localStorage.setItem("adminTheme", "light");
        }
    });
}