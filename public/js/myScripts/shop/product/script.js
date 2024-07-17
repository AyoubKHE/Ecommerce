
let productId = document.getElementById("product_id").value;

let enabledRadioButtons = {};

let selectedOptions = {};

let allAttributesRadioButtons = document.querySelectorAll('input[name*="attribute"]');

allAttributesRadioButtons.forEach(function (attributeRadioButton) {
    attributeRadioButton.addEventListener("change", function () {



        let attributeName = this.name.split("-")[1];
        let attributeOption = this.value;

        let enabledRadioButtons = {};

        let lastSelected = {};
        lastSelected[attributeName] = attributeOption

        document.getElementById("spinner-container").innerHTML = `
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `

        axios({
            method: "GET",
            url: `http://127.0.0.1:8000/api/product/${productId}/variations?${attributeName}=${attributeOption}`,
        })
            .then(response => {

                document.getElementById("spinner-container").innerHTML = "";

                let productVariations = response.data.productVariations;

                console.log(productVariations);

                for (const productVariation of productVariations) {
                    productVariation.variation_options = productVariation.variation_options.split(", ");

                    for (const variation_option of productVariation.variation_options) {

                        let attributeName = variation_option.split("=")[0];
                        let attributeOption = variation_option.split("=")[1];

                        if (!(attributeName in lastSelected)) {

                            if (!(attributeName in enabledRadioButtons)) {
                                enabledRadioButtons[attributeName] = [];
                            }

                            if (!enabledRadioButtons[attributeName].includes(attributeOption)) {
                                enabledRadioButtons[attributeName].push(attributeOption);
                            }
                        }

                    }
                }

                let allAttributesRadioButtonsContainers = document.querySelectorAll('div[id*="container-attribute-"]');

                allAttributesRadioButtonsContainers.forEach(function (attributesRadioButtonContainer) {
                    let attributeName = attributesRadioButtonContainer.id.split("-")[2];
                    let attributeOption = attributesRadioButtonContainer.id.split("-")[3];

                    if (!(attributeName in lastSelected)) {
                        if (!enabledRadioButtons[attributeName].includes(attributeOption)) {
                            attributesRadioButtonContainer.style.opacity = "0.4";

                            attributesRadioButtonContainer.children[0].disabled = true;
                            attributesRadioButtonContainer.children[0].checked = false;
                        }
                        else {
                            attributesRadioButtonContainer.style.opacity = "1";

                            attributesRadioButtonContainer.children[0].disabled = false;
                        }
                    }


                })

            })
            .catch((error) => {
                console.log(error);

                document.getElementById("spinner-container").innerHTML = "";

                if (error.response.status === 401) {

                    window.location = "login";
                }
                else if (error.response.status === 403) {

                    alert("Vous n avez pas la permission de faire ça");
                }
                else {

                    alert("Y a un problème dans le systeme contacter l'admin");
                }
            })


    })
})


let resetFilterButton = document.getElementById("reset-filters");

resetFilterButton.addEventListener("click", function () {
    let allAttributesRadioButtonsContainers = document.querySelectorAll('div[id*="container-attribute-"]');

    allAttributesRadioButtonsContainers.forEach(function (attributesRadioButtonContainer) {
        attributesRadioButtonContainer.style.opacity = "1";

        attributesRadioButtonContainer.children[0].disabled = false;
        attributesRadioButtonContainer.children[0].checked = false;
    })
})










