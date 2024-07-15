let defaultImageNumber = document.querySelector('input[name="is_default"][checked]').id.split("-")[3];

let productImagesCount = document.querySelectorAll('input[name="is_default"]:not([disabled])').length;

//!-----------------------------------------------------------------------------------------------------------------------------------

function manageChangeEventOnProductImageFileInput(event) {
    const idNumber = event.target.name.split("_")[2];
    if (event.target.files.length === 0) {
        document.getElementById("default-product-image-" + idNumber).disabled = true;
    } else {

        document.getElementById("default-product-image-" + idNumber).disabled = false;

        loadImageFileOnIMGTag(event.target.files[0], idNumber);

        let deletedImageInput = document.querySelector('input[name="deleted_images_numbers[]"][value="' + (idNumber - 1) + '"]');
        if(deletedImageInput !== null) {

            deletedImageInput.remove();

        }
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

        function addDeletedImageInputToForm() {
            let updateForm = document.getElementById("product-informations-form");

            let input = document.createElement("input");
            input.name = "deleted_images_numbers[]";
            input.value = idNumber - 1;
            input.type = "hidden";
            updateForm.appendChild(input);
        }

        function updateDefaultImage() {

            let correspondingDefaultRadioButton = document.getElementById("default-product-image-" + idNumber);
            correspondingDefaultRadioButton.disabled = true;

            if (correspondingDefaultRadioButton.checked) {

                let firstDefaultInputNotDisabled = document.querySelectorAll('input[id*="default-product-image-"]:not([disabled])')[0];
                firstDefaultInputNotDisabled.checked = true;
                manageDefaultImageInputs(firstDefaultInputNotDisabled.id.split("-")[3]);
            }
        }

        const idNumber = deleteImageButton.id.split("-")[3];
        document.getElementById("product-image-" + idNumber).src = "http://127.0.0.1:8000/storage/empty_image.png";

        deletedImageInput = document.querySelector('input[name="deleted_images_numbers[]"][value="' + (idNumber - 1) + '"]');
        if (deletedImageInput !== null) {
            return;
        }

        if(idNumber <= productImagesCount) {
            addDeletedImageInputToForm();
        }

        replaceOldFileInput(idNumber);

        updateDefaultImage();
    })
})

//!-----------------------------------------------------------------------------------------------------------------------------------

function manageDefaultImageInputs(newDefaultImageNumber) {

    let AllDefaultImageInputs = document.querySelectorAll('input[name*="default_image"]');
    AllDefaultImageInputs.forEach(function (defaultImageInput) {
        defaultImageInput.remove();
    })
    if (newDefaultImageNumber != defaultImageNumber) {

        let updateForm = document.getElementById("product-informations-form");

        let old_default_image_input = document.createElement("input");
        old_default_image_input.name = "old_default_image";
        old_default_image_input.value = defaultImageNumber;
        old_default_image_input.type = "hidden";
        updateForm.appendChild(old_default_image_input);

        let new_default_image_input = document.createElement("input");
        new_default_image_input.name = "new_default_image";
        new_default_image_input.value = newDefaultImageNumber;
        new_default_image_input.type = "hidden";
        updateForm.appendChild(new_default_image_input);
    }
}

allIsDefaultImageRadioButtons = document.querySelectorAll('input[name="is_default"]')

allIsDefaultImageRadioButtons.forEach(function (isDefaultImageRadioButton) {
    isDefaultImageRadioButton.addEventListener("change", function () {
        manageDefaultImageInputs(this.id.split("-")[3]);
    })
})





