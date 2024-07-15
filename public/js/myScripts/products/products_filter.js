//! validation de nom de la produit____________________________________________________________________________________________________

let productName = document.getElementById("product-name");

let epProductName = document.getElementById("ep-product-name");

let epProductNameText = document.getElementById("ep-product-name-text");

function isStringContainsOnlyLetters(input) {
    let regex = /^[a-zA-Zé\s]+$/;
    return regex.test(input);
}

productName.addEventListener("blur", function () {

    if (productName.value !== "") {
        if (productName.value.length > 255) {
            productName.parentElement.className = productName.parentElement.className.replace('col-10', 'col-9');
            epProductName.style.display = "inline";
            epProductNameText.textContent = "Le nom du produit ne doit pas excéder 255 caractères.";
            epProductNameText.style.width = "230px";
        }
        else if (!isStringContainsOnlyLetters(productName.value)) {

            productName.parentElement.className = productName.parentElement.className.replace('col-10', 'col-9');
            epProductName.style.display = "inline";
            epProductNameText.textContent = "Saisissez un Nom de produit valide : seules les lettres latines sont autorisées";
            epProductNameText.style.width = "230px";
        }
        else {
            productName.parentElement.className = productName.parentElement.className.replace('col-9', 'col-10');
            epProductName.style.display = "none";
            epProductNameText.textContent = "";
        }
    }
    else {
        productName.parentElement.className = productName.parentElement.className.replace('col-9', 'col-10');
        epProductName.style.display = "none";
        epProductNameText.textContent = "";
    }
})




//! validation de date de création____________________________________________________________________________________________________

function creationDateValidation(event) {
    let createdAtFrom = new Date(createdAtDateFrom.value + 'T' + createdAtTimeFrom.value);
    let createdAtTo = new Date(createdAtDateTo.value + 'T' + createdAtTimeTo.value);

    let epCreatedAtFrom = document.getElementById("ep-created-at-from");
    let epCreatedAtFromText = document.getElementById("ep-created-at-from-text");

    let epCreatedAtTo = document.getElementById("ep-created-at-to");
    let epCreatedAtToText = document.getElementById("ep-created-at-to-text");


    if (createdAtFrom.getTime() > createdAtTo.getTime()) {

        epCreatedAtFrom.style.display = "inline";
        epCreatedAtTo.style.display = "inline";

        epCreatedAtFromText.textContent = "Veuillez vérifier la date saisie : la date de début (De) doit précéder la date de fin (À).";
        epCreatedAtToText.textContent = "Veuillez vérifier la date saisie : la date de début (De) doit précéder la date de fin (À).";

        epCreatedAtFromText.style.width = "230px";
        epCreatedAtToText.style.width = "230px";
    }
    else {
        epCreatedAtFrom.style.display = "none";
        epCreatedAtTo.style.display = "none";

        epCreatedAtFromText.textContent = "";
        epCreatedAtToText.textContent = "";
    }
}

let createdAtDateFrom = document.getElementById("created-at-date-from");
let createdAtTimeFrom = document.getElementById("created-at-time-from");

let createdAtDateTo = document.getElementById("created-at-date-to");
let createdAtTimeTo = document.getElementById("created-at-time-to");

createdAtDateFrom.addEventListener("blur", creationDateValidation)
createdAtTimeFrom.addEventListener("blur", creationDateValidation)
createdAtDateTo.addEventListener("blur", creationDateValidation)
createdAtTimeTo.addEventListener("blur", creationDateValidation)




//! validation de date de mis à jour____________________________________________________________________________________________________

function updateDateValidation(event) {
    let updatedAtFrom = new Date(updatedAtDateFrom.value + 'T' + updatedAtTimeFrom.value);
    let updatedAtTo = new Date(updatedAtDateTo.value + 'T' + updatedAtTimeTo.value);

    let epUpdatedAtFrom = document.getElementById("ep-updated-at-from");
    let epUpdatedAtFromText = document.getElementById("ep-updated-at-from-text");

    let epUpdatedAtTo = document.getElementById("ep-updated-at-to");
    let epUpdatedAtToText = document.getElementById("ep-updated-at-to-text");


    if (updatedAtFrom.getTime() > updatedAtTo.getTime()) {

        epUpdatedAtFrom.style.display = "inline";
        epUpdatedAtTo.style.display = "inline";

        epUpdatedAtFromText.textContent = "Veuillez vérifier la date saisie : la date de début (De) doit précéder la date de fin (À).";
        epUpdatedAtToText.textContent = "Veuillez vérifier la date saisie : la date de début (De) doit précéder la date de fin (À).";

        epUpdatedAtFromText.style.width = "230px";
        epUpdatedAtToText.style.width = "230px";
    }
    else {
        epUpdatedAtFrom.style.display = "none";
        epUpdatedAtTo.style.display = "none";

        epUpdatedAtFromText.textContent = "";
        epUpdatedAtToText.textContent = "";
    }
}

let updatedAtDateFrom = document.getElementById("updated-at-date-from");
let updatedAtTimeFrom = document.getElementById("updated-at-time-from");

let updatedAtDateTo = document.getElementById("updated-at-date-to");
let updatedAtTimeTo = document.getElementById("updated-at-time-to");

updatedAtDateFrom.addEventListener("blur", updateDateValidation)
updatedAtTimeFrom.addEventListener("blur", updateDateValidation)
updatedAtDateTo.addEventListener("blur", updateDateValidation)
updatedAtTimeTo.addEventListener("blur", updateDateValidation)


//! validation de la description de la produit____________________________________________________________________________________________________

let productDescription = document.getElementById("product-description");

let epProductDescription = document.getElementById("ep-product-description");

let epProductDescriptionText = document.getElementById("ep-product-description-text");

productDescription.addEventListener("blur", function () {

    if (productDescription.value !== "") {
        if (productDescription.value.length > 65535) {
            productDescription.parentElement.className = productDescription.parentElement.className.replace('col-12', 'col-11');
            epProductDescription.style.display = "inline";
            epProductDescriptionText.textContent = "La description de la produit ne doit pas excéder 65535 caractères.";
            epProductDescriptionText.style.width = "230px";
        }
        else {
            productDescription.parentElement.className = productDescription.parentElement.className.replace('col-11', 'col-12');
            epProductDescription.style.display = "none";
            epProductDescriptionText.textContent = "";
        }
    }
    else {
        productDescription.parentElement.className = productDescription.parentElement.className.replace('col-11', 'col-12');
        epProductDescription.style.display = "none";
        epProductDescriptionText.textContent = "";
    }
})




//! configurer le boutton apply_________________________________________________________________________________________________________

let btnApply = document.getElementById("apply");

btnApply.addEventListener("click", function () {

    function buildFilter() {

        let filter = {};

        if(document.getElementById("product-id").value !== "") {
            filter["id"] = document.getElementById("product-id").value;
        }

        if(document.getElementById("product-name").value !== "") {
            filter["name"] =  "%" + document.getElementById("product-name").value + "%";
        }

        if(document.getElementById("product-description").value !== "") {
            filter["description"] = "%" + document.getElementById("product-description").value + "%";
        }

        if(document.getElementById("yes").checked) {
            filter["is_active"] = 1;
        }
        else if(document.getElementById("no").checked) {
            filter["is_active"] = 0;
        }

        if(document.getElementById("brand-name").value !== "All") {
            filter["brand_name"] = document.getElementById("brand-name").value
        }

        filter["created_at"] = {
            "from" : document.getElementById("created-at-date-from").value + ' ' + document.getElementById("created-at-time-from").value,
            "to" : document.getElementById("created-at-date-to").value + ' ' + document.getElementById("created-at-time-to").value
        }

        filter["updated_at"] = {
            "from" : document.getElementById("updated-at-date-from").value + ' ' + document.getElementById("updated-at-time-from").value,
            "to" : document.getElementById("updated-at-date-to").value + ' ' + document.getElementById("updated-at-time-to").value
        }

        if(document.getElementById("product-category-name").value !== "All") {
            filter["product_category_name"] = document.getElementById("product-category-name").value
        }

        if(document.getElementById("created-by-username").value !== "All") {
            filter["added_by"] = document.getElementById("created-by-username").value
        }

        filter["price"] = {
            "from" : document.getElementById("price-from").value,
            "to" : document.getElementById("price-to").value
        }

        filter["rating"] = {
            "from" : document.getElementById("rating-from").value,
            "to" : document.getElementById("rating-to").value
        }

        if(document.getElementById("include-null-rating").checked) {
            filter["include_null_rating"] = 1;
        }
        else {
            filter["include_null_rating"] = 0;
        }

        return filter;
    }

    function isValidData() {
        let allErrorProvidersText = document.querySelectorAll(".my-tooltiptext");
        for (let i = 0; i < allErrorProvidersText.length; i++) {
            if (allErrorProvidersText[i].textContent.trim() !== "") {
                alert("Une erreur s'est produite dans le processus. Veuillez vérifier les détails pour identifier la ou les erreurs spécifiques.");
                return false;
            }
        }
        return true;
    }

    if(isValidData()) {
        let filter = buildFilter();

        localStorage.setItem("filter", JSON.stringify(filter));

        let modal = document.getElementById("makeFilter");
        let modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        fetchPage(1, "filter", filter, searchInput.value, localStorage.getItem("ability"));

        currentMode = "filter";
    }

})


