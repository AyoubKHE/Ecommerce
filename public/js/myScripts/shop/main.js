let currentMode = "search";
localStorage.setItem("searchInputValue", "");


function fetchPage(link) {

    let table = document.getElementById(`products-table`);
    table.classList.add('d-flex');
    table.classList.add('align-items-center');
    table.classList.add('justify-content-center');
    table.style.height = '65vh';
    table.innerHTML = `
        <div div class="spinner-border" role = "status" >
            <span class="visually-hidden">Loading...</span>
        </div >
    `;

    productCategoryId = document.getElementById("product-category-id").value

    axios({
        method: "GET",
        url: link,
    })
        .then(response => {
            console.log(response);

            table.classList.remove('d-flex');
            table.classList.remove('align-items-center');
            table.classList.remove('justify-content-center');
            table.style.height = '';
            table.innerHTML = response.data.htmlView;

            if (response.data.refreshedToken !== null) {
                localStorage.setItem("access_token", response.data.refreshedToken);
            }

            let $allDeleteResourceButtons = document.getElementsByName("_token");

            $allDeleteResourceButtons.forEach(function (deleteResourceButton) {
                deleteResourceButton.value = localStorage.getItem("csrfToken");
            })


        })
        .catch((error) => {
            console.log(error);
            if (error.response.status === 401) {
                window.location = "/login";
            }
            else if (error.response.status === 403) {
                alert("Vous n avez pas la permission de faire ça");
            }
            else {
                alert("Y a un problème dans le systeme contacter l'admin");
            }
        })

}


document.addEventListener('click', function (e) {
    if (e.target.tagName === 'A' && e.target.closest('.pagination')) {
        e.preventDefault();
        // let page = new URL(e.target.href).searchParams.get('page');
        let link = e.target.href;
        if (currentMode === "search") {
            fetchPage(link);
        }
        // else if (currentMode === "filter") {
        //     fetchPage(page, "filter", JSON.parse(localStorage.getItem("filter")), localStorage.getItem("ability"));
        // }
    }
});
