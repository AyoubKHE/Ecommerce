localStorage.setItem("ability", "read_products");

function showProductInformationsForm() {

    document.getElementById("product-informations-form").style.display = "block";
    document.getElementById("product-informations-link").classList.add("active");


    document.getElementById("product-variations-form").style.display = "none";
    document.getElementById("product-variations-link").classList.remove("active");
}

function showProductVariationsForm() {

    document.getElementById("product-variations-form").style.display = "block";
    document.getElementById("product-variations-link").classList.add("active");

    document.getElementById("product-informations-form").style.display = "none";
    document.getElementById("product-informations-link").classList.remove("active");
}



let allRelatedYesRadioButtons = document.querySelectorAll('input[id*="related_yes"]');
if (allRelatedYesRadioButtons.length !== 0) {

    allRelatedYesRadioButtons.forEach(relatedYes => {
        relatedYes.addEventListener("click", function () {
            const idNumber = relatedYes.id.split("_")[2];
            document.getElementById("active_yes_" + idNumber).disabled = false;
            document.getElementById("active_no_" + idNumber).disabled = false;
        })
    });
}


let allRelatedNoRadioButtons = document.querySelectorAll('input[id*="related_no"]');

if (allRelatedNoRadioButtons.length !== 0) {
    allRelatedNoRadioButtons.forEach(relatedNo => {
        relatedNo.addEventListener("click", function () {
            const idNumber = relatedNo.id.split("_")[2];
            document.getElementById("active_yes_" + idNumber).disabled = true;
            document.getElementById("active_no_" + idNumber).disabled = true;
        })
    });
}



//!-----------------------------------------------------------------------------------------------------------------------------------

let productActiveNoRadioButton = document.getElementById("product-active-no");

if (productActiveNoRadioButton !== null) {
    productActiveNoRadioButton.addEventListener("click", function () {
        let allActiveNoRadioButtons = document.querySelectorAll('input[id*="active_no"]');
        allActiveNoRadioButtons.forEach(function (activeNoRadioButton) {
            activeNoRadioButton.checked = true;
        })
    })
}


let productActiveYesRadioButton = document.getElementById("product-active-yes");

if (productActiveYesRadioButton !== null) {
    productActiveYesRadioButton.addEventListener("click", function () {
        let allActiveYesRadioButtons = document.querySelectorAll('input[id*="active_yes"]');
        allActiveYesRadioButtons.forEach(function (activeYesRadioButton) {
            const idNumber = activeYesRadioButton.id.split("_")[2];
            if (document.getElementById("related_yes_" + idNumber).checked) {
                activeYesRadioButton.checked = true;
            }
        })
    })
}



//!-----------------------------------------------------------------------------------------------------------------------------------

function loadImageFileOnIMGTag(file, idNumber) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
        let image = document.getElementById("product-image-" + idNumber)
        image.src = reader.result;
    };
}

function replaceOldFileInput(idNumber) {
    if (document.getElementsByName("product_image_" + idNumber)[0].files.length !== 0) {

        document.getElementsByName("product_image_" + idNumber)[0].remove();

        let input = document.createElement("input");
        input.name = "product_image_" + idNumber;
        input.type = "file";
        input.className = "form-control";
        document.getElementById("product-image-" + idNumber).insertAdjacentElement("afterend", input);

        input.addEventListener("change", manageChangeEventOnProductImageFileInput);
    }
}


