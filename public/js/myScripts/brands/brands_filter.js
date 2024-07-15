//! validation de nom de la marque____________________________________________________________________________________________________

let brandName = document.getElementById("brand-name");

let epBrandName = document.getElementById("ep-brand-name");

let epBrandNameText = document.getElementById("ep-brand-name-text");

function isStringContainsOnlyLetters(input) {
    let regex = /^[a-zA-Zé\s]+$/;
    return regex.test(input);
}

brandName.addEventListener("blur", function () {

    if (brandName.value !== "") {
        if (brandName.value.length > 255) {
            brandName.parentElement.className = brandName.parentElement.className.replace('col-10', 'col-9');
            epBrandName.style.display = "inline";
            epBrandNameText.textContent = "Le nom de la marque ne doit pas excéder 255 caractères.";
            epBrandNameText.style.width = "230px";
        }
        else if (!isStringContainsOnlyLetters(brandName.value)) {

            brandName.parentElement.className = brandName.parentElement.className.replace('col-10', 'col-9');
            epBrandName.style.display = "inline";
            epBrandNameText.textContent = "Saisissez un Nom de marque valide : seules les lettres latines sont autorisées";
            epBrandNameText.style.width = "230px";
        }
        else {
            brandName.parentElement.className = brandName.parentElement.className.replace('col-9', 'col-10');
            epBrandName.style.display = "none";
            epBrandNameText.textContent = "";
        }
    }
    else {
        brandName.parentElement.className = brandName.parentElement.className.replace('col-9', 'col-10');
        epBrandName.style.display = "none";
        epBrandNameText.textContent = "";
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



//! validation de quantité de produits____________________________________________________________________________________________________

function quantityOfProductsValidation(event) {

    if(event.target.value === "") {
        event.target.value = 0
    }

    let epQuantityOfProductsFrom = document.getElementById("ep-quantity-of-products-from");
    let epQuantityOfProductsFromText = document.getElementById("ep-quantity-of-products-from-text");

    let epQuantityOfProductsTo = document.getElementById("ep-quantity-of-products-to");
    let epQuantityOfProductsToText = document.getElementById("ep-quantity-of-products-to-text");

    if (Number(quantityOfProductsFrom.value) > Number(quantityOfProductsTo.value)) {
        epQuantityOfProductsFrom.style.display = "inline";
        epQuantityOfProductsTo.style.display = "inline";

        epQuantityOfProductsFromText.textContent = "Veuillez vérifier les quantités saisies : la quantité initiale (De) doit être inférieure ou égale à la quantité finale (À)."
        epQuantityOfProductsToText.textContent = "Veuillez vérifier les quantités saisies : la quantité initiale (De) doit être inférieure ou égale à la quantité finale (À)."

        epQuantityOfProductsFromText.style.width = "230px";
        epQuantityOfProductsToText.style.width = "230px";
    }
    else {
        epQuantityOfProductsFrom.style.display = "none";
        epQuantityOfProductsTo.style.display = "none";

        epQuantityOfProductsFromText.textContent = "";
        epQuantityOfProductsToText.textContent = "";
    }

}

let quantityOfProductsFrom = document.getElementById("quantity-of-products-from");
let quantityOfProductsTo = document.getElementById("quantity-of-products-to");

quantityOfProductsFrom.addEventListener("blur", quantityOfProductsValidation)
quantityOfProductsTo.addEventListener("blur", quantityOfProductsValidation)


//! validation de la description de la marque____________________________________________________________________________________________________

let brandDescription = document.getElementById("brand-description");

let epBrandDescription = document.getElementById("ep-brand-description");

let epBrandDescriptionText = document.getElementById("ep-brand-description-text");

brandDescription.addEventListener("blur", function () {

    if (brandDescription.value !== "") {
        if (brandDescription.value.length > 65535) {
            brandDescription.parentElement.className = brandDescription.parentElement.className.replace('col-12', 'col-11');
            epBrandDescription.style.display = "inline";
            epBrandDescriptionText.textContent = "La description de la marque ne doit pas excéder 65535 caractères.";
            epBrandDescriptionText.style.width = "230px";
        }
        else {
            brandDescription.parentElement.className = brandDescription.parentElement.className.replace('col-11', 'col-12');
            epBrandDescription.style.display = "none";
            epBrandDescriptionText.textContent = "";
        }
    }
    else {
        brandDescription.parentElement.className = brandDescription.parentElement.className.replace('col-11', 'col-12');
        epBrandDescription.style.display = "none";
        epBrandDescriptionText.textContent = "";
    }
})




//! configurer le boutton apply_________________________________________________________________________________________________________

let btnApply = document.getElementById("apply");

btnApply.addEventListener("click", function () {

    function buildFilter() {

        let filter = {};

        if(document.getElementById("brand-id").value !== "") {
            filter["id"] = document.getElementById("brand-id").value;
        }

        if(document.getElementById("brand-name").value !== "") {
            filter["name"] =  "%" + document.getElementById("brand-name").value + "%";
        }

        if(document.getElementById("brand-description").value !== "") {
            filter["description"] = "%" + document.getElementById("brand-description").value + "%";
        }

        if(document.getElementById("yes").checked) {
            filter["is_active"] = 1;
        }
        else if(document.getElementById("no").checked) {
            filter["is_active"] = 0;
        }

        filter["created_at"] = {
            "from" : document.getElementById("created-at-date-from").value + ' ' + document.getElementById("created-at-time-from").value,
            "to" : document.getElementById("created-at-date-to").value + ' ' + document.getElementById("created-at-time-to").value
        }

        filter["updated_at"] = {
            "from" : document.getElementById("updated-at-date-from").value + ' ' + document.getElementById("updated-at-time-from").value,
            "to" : document.getElementById("updated-at-date-to").value + ' ' + document.getElementById("updated-at-time-to").value
        }

        if(document.getElementById("created-by-username").value !== "All") {
            filter["added_by"] = document.getElementById("created-by-username").value
        }

        filter["quantity_of_products"] = {
            "from" : document.getElementById("quantity-of-products-from").value,
            "to" : document.getElementById("quantity-of-products-to").value
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

        fetchPage(1, "filter", filter);

        currentMode = "filter";
    }

})


