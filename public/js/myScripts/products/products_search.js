let searchInput = document.getElementById('search_by_product_name');

searchInput.addEventListener("input", function () {

    fetchPage(1, "search", searchInput.value, localStorage.getItem("ability"));

    localStorage.setItem("searchInputValue", searchInput.value);

    currentMode = "search";
})


