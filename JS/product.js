const filterBtn = document.querySelector(".filter_top_btn");
const sidebarFilter = document.querySelector(".sidebar_filter");

if (filterBtn && sidebarFilter) {
    filterBtn.addEventListener("click", function () {
        sidebarFilter.classList.toggle("active");
    });
}

