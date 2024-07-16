
let productId = document.getElementById("product_id").value;

let productVariations = null;

document.addEventListener("DOMContentLoaded", function () {

    axios({
        method: "GET",
        url: `http://127.0.0.1:8000/api/product/${productId}/variations`,
    })
        .then(response => {

            console.log(response);
            productVariations = response.data.productVariations;
        })
        .catch((error) => {
            console.log(error);
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

let enabledRadioButtons = {};

let allAttributesRadioButtons = document.querySelectorAll('input[name*="attribute"]');

let selectedOptions = {};

allAttributesRadioButtons.forEach(function (attributeRadioButton) {
    attributeRadioButton.addEventListener("change", function () {
        let attributeName = this.name.split("-")[1];
        let attributeOption = this.value;

        let enabledRadioButtons = {};

        selectedOptions[attributeName] = attributeOption;


        productVariations.forEach(function (variation) {

            let currentVariationAttributesOptions = "";

            for (const attribute_option of variation.attributes_options_pivot) {
                if (attribute_option.attribute.name == attributeName) {
                    currentVariationAttributesOptions = attribute_option.option.value;
                    break;
                }
            }

            if (currentVariationAttributesOptions == attributeOption) {
                for (const attribute_option of variation.attributes_options_pivot) {
                    if (attribute_option.attribute.name != attributeName) {

                        if (!(attribute_option.attribute.name in enabledRadioButtons)) {
                            enabledRadioButtons[attribute_option.attribute.name] = [];
                        }

                        if (!enabledRadioButtons[attribute_option.attribute.name].includes(attribute_option.option.value)) {
                            enabledRadioButtons[attribute_option.attribute.name].push(attribute_option.option.value);
                        }
                    }
                }
            }

        })

        console.log(enabledRadioButtons)

    })
})
