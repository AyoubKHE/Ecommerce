document.getElementById('default-product-image-1').checked = true;

//!-----------------------------------------------------------------------------------------------------------------------------------

function manageChangeEventOnProductImageFileInput(event) {
    const idNumber = event.target.name.split("_")[2];
    if (event.target.files.length === 0) {
        document.getElementById("default-product-image-" + idNumber).disabled = true;
    } else {

        document.getElementById("default-product-image-" + idNumber).disabled = false;

        loadImageFileOnIMGTag(event.target.files[0], idNumber);
    }
}

let allProductImagesFileInputs = document.querySelectorAll('input[name*="product_image_"]');

allProductImagesFileInputs.forEach(function (productImageFileInput) {
    productImageFileInput.addEventListener("change", manageChangeEventOnProductImageFileInput)
})

//!-----------------------------------------------------------------------------------------------------------------------------------



let AllDeleteImageButtons = document.querySelectorAll('span[id*="delete-product-image-"]');

AllDeleteImageButtons.forEach(function (deleteImageButton) {

    deleteImageButton.addEventListener("click", function () {

        const idNumber = deleteImageButton.id.split("-")[3];
        document.getElementById("product-image-" + idNumber).src = "http://127.0.0.1:8000/storage/empty_image.png";

        replaceOldFileInput(idNumber);
    })
})
