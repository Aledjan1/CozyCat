// Get filter button and sidebar elements
const filterBtn = document.querySelector(".filter_top_btn");
const sidebarFilter = document.querySelector(".sidebar_filter");

// Enable mobile filter toggle if both elements exist
if (filterBtn && sidebarFilter) {
    // Show or hide the filter sidebar when button is clicked
    filterBtn.addEventListener("click", function () {
        sidebarFilter.classList.toggle("active"); // Toggle active class on the filter sidebar
    });
}

