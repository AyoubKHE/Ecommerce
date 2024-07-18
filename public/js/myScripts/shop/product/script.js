
let productId = document.getElementById("product_id").value;

let enabledRadioButtons = {};

// let selectedOptions = {};

let allAttributesRadioButtons = document.querySelectorAll('input[name*="attribute"]');

// document.querySelectorAll('input[name*="attribute"]:checked')

allAttributesRadioButtons.forEach(function (attributeRadioButton) {
    attributeRadioButton.addEventListener("change", function () {

        document.getElementById("variation-more-details").innerHTML = "";

        let attributeName = this.name.split("-")[1];
        let attributeOption = this.value;

        let enabledRadioButtons = {};

        // selectedOptions[attributeName] = attributeOption;

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

                function prepareEnabledRadioButtonsObject() {

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
                }

                function modifiyAttributesRadioButtons() {
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
                }

                function manageUI() {

                    url = `http://127.0.0.1:8000/api/product/${productId}/variations?`;

                    selectedOptions.forEach(function (selectedOption) {
                        let attributeName = selectedOption.name.split("-")[1];
                        let attributeOption = selectedOption.value;

                        url += `${attributeName}=${attributeOption}&`
                    })

                    document.getElementById("variation-more-details").innerHTML = `
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    `

                    axios({
                        method: "GET",
                        url: url,
                    })
                        .then(response => {

                            // document.getElementById('product-price').innerHTML.trim().split(' ')[0]

                            let productVariation = response.data.productVariations[0];

                            document.getElementById("variation-more-details").innerHTML = `
                                <h4 style="color: green; font-family: 'remixicon'">${productVariation.quantity_in_stock} en stock</h4>
                            `

                            let productPrice = document.getElementById('product-price').innerHTML.trim().split(' ')[0];

                            if (productPrice != productVariation.price) {
                                document.getElementById("variation-more-details").innerHTML += `
                                    <h3 style="color: #db1a2a; font-family: cursive;">Prix spécial pour cette variation : ${productVariation.price} DA</h3>
                                `
                            }

                            document.getElementById("quantity-of-variation").min = 1;
                            document.getElementById("quantity-of-variation").max = productVariation.quantity_in_stock;

                            document.getElementById("variation-id").value = productVariation.id;


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

                }

                document.getElementById("spinner-container").innerHTML = "";

                let productVariations = response.data.productVariations;

                prepareEnabledRadioButtonsObject();

                modifiyAttributesRadioButtons();

                let attributesCount = document.querySelectorAll('small[id*="attribute-label-"]').length;

                let selectedOptions = document.querySelectorAll('input[name*="attribute"]:checked');

                if (selectedOptions.length == attributesCount) {
                    manageUI();
                } else {
                    document.getElementById("variation-id").value = "";
                }

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

    document.getElementById("variation-more-details").innerHTML = "";

    document.getElementById("variation-id").value = "";

    let allAttributesRadioButtonsContainers = document.querySelectorAll('div[id*="container-attribute-"]');

    allAttributesRadioButtonsContainers.forEach(function (attributesRadioButtonContainer) {
        attributesRadioButtonContainer.style.opacity = "1";

        attributesRadioButtonContainer.children[0].disabled = false;
        attributesRadioButtonContainer.children[0].checked = false;
    })
})



let cartForm = document.getElementById('cart-form');

cartForm.addEventListener('submit', function (event) {

    event.preventDefault();

    let variation_id = document.getElementById("variation-id").value;

    if (variation_id != "") {
        cartForm.submit();
    } else {
        alert('Veuillez renseignez toutes les options');
    }
});










