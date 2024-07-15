let searchInput = document.getElementById('search_by_brand_name');

searchInput.addEventListener("input", function () {

    fetchPage(1, "search", searchInput.value);

    localStorage.setItem("searchInputValue", searchInput.value);

    currentMode = "search";
})


