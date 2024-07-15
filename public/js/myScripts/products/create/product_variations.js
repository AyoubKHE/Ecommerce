function createAttributeContainer(attribute, optionsContainer, variationNumber) {
    let attributeContainer = document.createElement("div");
    attributeContainer.id = `container-attribute-${attribute}-${variationNumber}`;
    attributeContainer.classList.add("d-flex", "flex-column", "align-items-center");
    optionsContainer.appendChild(attributeContainer);

    let attributeLabel = document.createElement("label");
    attributeLabel.textContent = attribute;
    attributeContainer.appendChild(attributeLabel);

    let select = document.createElement("select");
    select.classList.add("form-select");
    select.style.width = "150px";
    select.name = `variations[${variationNumber - 1}][options][${attribute}]`;
    select.id = `options-select-${attribute}-${variationNumber}`;
    attributeContainer.appendChild(select);

    let defaultOption = document.createElement("option");
    defaultOption.value = "N/A";
    defaultOption.selected = true;
    defaultOption.textContent = "Choisir ici...";
    select.appendChild(defaultOption);

    for (let option of attributesAndOptions[attribute]) {
        let optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.textContent = option;
        select.appendChild(optionElement);
    }
}

//!-------------------------------------------------------------------------------------------------------------------------------------


let choosedAttributesCount = 0;

document.getElementById("attributes-select").addEventListener("change", function () {

    function addNewAttributeDivToChoosedAttributesContainer(attributeNumber, attributeName) {

        function addEventListenerToDeleteAttributeButton() {

            function rearrangeInputNumbers(from) {

                function insertNewDeleteAttributeButton(i) {

                    //! je crée un nouveau bouton de delete pour éviter le probleme d'Event Listener

                    allAttributesCards[i].querySelector('span[id*="delete-attribute-"]').remove();

                    let deleteAttributeButton = document.createElement("span");
                    deleteAttributeButton.classList.add("btn", "btn-danger", "btn-sm");
                    deleteAttributeButton.id = `delete-attribute-${i + 1}`;
                    deleteAttributeButton.innerHTML = `
                        <i class="fa fa-times" aria-hidden="true"></i>
                    `

                    deleteAttributeButton.addEventListener("click", function () {
                        allAttributesCards[i].remove();

                        rearrangeInputNumbers(i + 1);

                        choosedAttributesCount -= 1;

                        let attributeName = allAttributesCards[i].querySelector('input[id*="attribute-"]').value;

                        allAttributeNameOptionsSelect = document.querySelectorAll(`div[id*="container-attribute-${attributeName}-"]`)
                        allAttributeNameOptionsSelect.forEach(function (attributeNameOptionsSelect) {
                            attributeNameOptionsSelect.remove();
                        })
                    })

                    allAttributesCards[i].querySelector('input[id*="attribute-"]').insertAdjacentElement("afterend", deleteAttributeButton);
                }

                let allAttributesCards = document.querySelectorAll('div[id*="attribute-card-"]');
                for (let i = from - 1; i < allAttributesCards.length; i++) {

                    allAttributesCards[i].id = `attribute-card-${i + 1}`;

                    allAttributesCards[i].querySelector('input[id*="attribute-"]').id = `attribute-${i + 1}`;

                    insertNewDeleteAttributeButton(i);

                }
            }

            document.getElementById(`delete-attribute-${attributeNumber}`).addEventListener("click", function () {

                document.getElementById(`attribute-card-${attributeNumber}`).remove();

                rearrangeInputNumbers(attributeNumber);

                choosedAttributesCount -= 1;

                allAttributeNameOptionsSelect = document.querySelectorAll(`div[id*="container-attribute-${attributeName}-"]`)
                allAttributeNameOptionsSelect.forEach(function (attributeNameOptionsSelect) {
                    attributeNameOptionsSelect.remove();
                })

            })
        }

        let newAttributeDiv = document.createElement("div");

        newAttributeDiv.classList.add("d-flex");
        newAttributeDiv.style.marginRight = "30px";
        newAttributeDiv.style.marginBottom = "10px";

        newAttributeDiv.id = `attribute-card-${attributeNumber}`; //

        newAttributeDiv.innerHTML = `
            <div class="d-flex align-items-center" style="gap: 10px">

                <input type="text" id="attribute-${attributeNumber}" name="choosed_attributes[]" class="form-control"
                    style="width: 100px; height: 30px" value="${attributeName}">

                <span class="btn btn-danger btn-sm" id="delete-attribute-${attributeNumber}">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>

            </div>
        `

        document.getElementById("choosed-attributes-container").appendChild(newAttributeDiv);

        addEventListenerToDeleteAttributeButton();

    }

    function isAttributeAddedBefore(attributeName) {

        let allChoosedAttributes = document.querySelectorAll('input[id*="attribute-"]');

        for (const choosedAttribute of allChoosedAttributes) {
            if (choosedAttribute.value === attributeName) {
                return true;
            }
        }

        return false;
    }

    if (this.value === "N/A") {
        return;
    }


    if (!isAttributeAddedBefore(this.value)) {

        addNewAttributeDivToChoosedAttributesContainer(choosedAttributesCount + 1, this.value);
        choosedAttributesCount += 1;

        if(variationsCount === 0) {
            return;
        }

        attribute = this.value;

        let allOptionsContainers = document.querySelectorAll('div[id*="options-container-"]')

        if (attribute in attributesAndOptions) {

            allOptionsContainers.forEach(function (optionsContainer) {

                variationNumber = optionsContainer.id.split('-')[2];

                createAttributeContainer(attribute, optionsContainer, variationNumber);
            })

        }
        else {
            new Promise((resolve, reject) => {

                allOptionsContainers.forEach(function (optionsContainer) {

                    optionsContainer.innerHTML += `
                        <div class="spinner-border" role="status" style="margin-left: 10px; margin-right: 10px; margin-top: 20px">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    `
                })

                axios({
                    method: "GET",
                    url: `http://127.0.0.1:8000/api/products-attributes/${attribute}/options`,
                })
                    .then(response => {

                        console.log(response);

                        attributesAndOptions[attribute] = response.data.productOptions;

                        console.log(Object.keys(attributesAndOptions).length);

                        resolve();
                    })
                    .catch((error) => {

                        reject(error);
                    })
            })
                .then(() => {

                    allOptionsContainers.forEach(function (optionsContainer) {

                        variationNumber = optionsContainer.id.split('-')[2];

                        optionsContainer.getElementsByClassName("spinner-border")[0].remove();

                        createAttributeContainer(attribute, optionsContainer, variationNumber);
                    })

                })
                .catch((error) => {

                    console.log(error);
                    if (error.status === 401 || error.status === 403) {
                        window.location = "login";
                    }
                    else {
                        alert("Y a un problème dans le systeme. Veuillez contacter l'admin !");
                    }
                })
        }
    }


    this.value = "N/A";


})

//!-------------------------------------------------------------------------------------------------------------------------------------

let attributesAndOptions = {};

let variationsCount = 0;

document.getElementById("add-new-variation-btn").addEventListener("click", function () {

    function addNewVariationToVariationsContainer(variationNumber) {

        function createVariationContainer() {

            function createDeleteVariationButton() {

                function rearrangeVariationsNumbers(from) {

                    function insertNewDeleteAttributeButton(i) {

                        //! j'ai crée un nouveau bouton de delete pour éviter le probleme d'Event Listener

                        allVariations[i].querySelector('span[id*="delete-variation-"]').remove();

                        let deleteAttributeButton = document.createElement("span");
                        deleteAttributeButton.classList.add("btn", "btn-danger", "btn-sm");
                        deleteAttributeButton.id = `delete-variation-${i + 1}`;
                        deleteAttributeButton.innerHTML = `
                            <i class="fas fa-trash" aria-hidden="true"></i>
                        `

                        deleteAttributeButton.addEventListener("click", function () {
                            allVariations[i].remove();

                            rearrangeVariationsNumbers(i + 1);

                            variationsCount -= 1;
                        })

                        allVariations[i].appendChild(deleteAttributeButton);
                    }

                    let allVariations = document.querySelectorAll('div[id*="variation-"]');
                    for (let i = from - 1; i < allVariations.length; i++) {

                        allVariations[i].id = `variation-${i + 1}`;

                        allVariations[i].querySelector('label[id*="variation-label-"]').id = `variation-label-${i + 1}`;
                        allVariations[i].querySelector('label[id*="variation-label-"]').innerHTML = `Variation ${i + 1}:`;

                        let allOptionsSelect = allVariations[i].querySelectorAll('select[id*="options-select-"]')
                        allOptionsSelect.forEach(function (optionsSelect) {
                            optionsSelect.id = optionsSelect.id.replace(/\d/, i + 1);

                            optionsSelect.name = optionsSelect.name.replace(/[\d]/, i);
                        })

                        allVariations[i].querySelector('input[id*="variation-price-"]').id = `variation-price-${i + 1}`;
                        allVariations[i].querySelector('input[id*="variation-price-"]').name = `variations[${i}][price]`;

                        allVariations[i].querySelector('input[id*="variation-quantity-in-stock-"]').id = `variation-quantity-in-stock-${i + 1}`;
                        allVariations[i].querySelector('input[id*="variation-quantity-in-stock-"]').name = `variations[${i}][quantity_in_stock]`;

                        allVariations[i].querySelector('input[id*="variation-active-yes-"]').id = `variation-active-yes-${i + 1}`;
                        allVariations[i].querySelector('input[id*="variation-active-yes-"]').name = `variations[${i}][is_active]`;

                        allVariations[i].querySelector('input[id*="variation-active-no-"]').id = `variation-active-no-${i + 1}`;
                        allVariations[i].querySelector('input[id*="variation-active-no-"]').name = `variations[${i}][is_active]`;

                        // allVariations[i].querySelector('span[id*="delete-variation-"]').id = `delete-variation-${i + 1}`;

                        insertNewDeleteAttributeButton(i);
                    }
                }

                let deleteButton = document.createElement("span");
                deleteButton.classList.add("btn", "btn-danger", "btn-sm");
                deleteButton.id = `delete-variation-${variationNumber}`;
                let deleteIcon = document.createElement("i");
                deleteIcon.classList.add("fas", "fa-trash");
                deleteButton.appendChild(deleteIcon);
                variation.appendChild(deleteButton);

                deleteButton.addEventListener("click", function () {

                    variation.remove();
                    rearrangeVariationsNumbers(variationNumber);
                    variationsCount -= 1;
                })

            }

            function createVariationInfomrations() {

                function createIsActiveVariationContainer() {
                    let activeContainer = document.createElement("div");
                    activeContainer.classList.add("d-flex", "flex-column", "align-items-center");

                    let activeLabel = document.createElement("label");
                    activeLabel.textContent = "Active:";
                    activeLabel.style.marginBottom = "9px";

                    let flexContainer = document.createElement("div");
                    flexContainer.classList.add("d-flex");

                    let activeYesContainer = document.createElement("div");
                    activeYesContainer.classList.add("form-check");
                    activeYesContainer.style.paddingLeft = "0";

                    let activeYesLabel = document.createElement("label");
                    activeYesLabel.classList.add("form-check-label");
                    activeYesLabel.style.marginLeft = "8px";
                    activeYesLabel.textContent = "Oui";

                    let activeYesInput = document.createElement("input");
                    activeYesInput.classList.add("form-check-input");
                    activeYesInput.id = `variation-active-yes-${variationNumber}`;
                    activeYesInput.type = "radio";
                    activeYesInput.name = `variations[${variationNumber - 1}][is_active]`;
                    activeYesInput.value = "1";
                    activeYesInput.checked = true;
                    activeYesInput.style.marginLeft = "5px";
                    activeYesContainer.appendChild(activeYesLabel);
                    activeYesContainer.appendChild(activeYesInput);

                    let activeNoContainer = document.createElement("div");
                    activeNoContainer.classList.add("form-check");
                    activeNoContainer.style.marginLeft = "20px";

                    let activeNoLabel = document.createElement("label");
                    activeNoLabel.classList.add("form-check-label");
                    activeNoLabel.textContent = "Non";

                    let activeNoInput = document.createElement("input");
                    activeNoInput.classList.add("form-check-input");
                    activeNoInput.id = `variation-active-no-${variationNumber}`;
                    activeNoInput.type = "radio";
                    activeNoInput.name = `variations[${variationNumber - 1}][is_active]`;
                    activeNoInput.value = "0";
                    activeNoContainer.appendChild(activeNoLabel);
                    activeNoContainer.appendChild(activeNoInput);

                    flexContainer.append(activeYesContainer);
                    flexContainer.append(activeNoContainer);
                    activeContainer.appendChild(activeLabel);
                    activeContainer.appendChild(flexContainer);
                    informationsContainer.appendChild(activeContainer);
                }

                function createQuantityInStockContaienr() {
                    let quantityContainer = document.createElement("div");
                    quantityContainer.classList.add("d-flex", "flex-column", "align-items-center");
                    let quantityLabel = document.createElement("label");
                    quantityLabel.textContent = "Qté dans le stock:";
                    let quantityInput = document.createElement("input");
                    quantityInput.type = "number";
                    quantityInput.name = `variations[${variationNumber - 1}][quantity_in_stock]`;
                    quantityInput.id = `variation-quantity-in-stock-${variationNumber}`;
                    quantityInput.classList.add("form-control");
                    quantityInput.style.width = "150px";
                    quantityContainer.appendChild(quantityLabel);
                    quantityContainer.appendChild(quantityInput);
                    informationsContainer.appendChild(quantityContainer);
                }

                function createPriceContainer() {
                    let priceContainer = document.createElement("div");
                    priceContainer.classList.add("d-flex", "flex-column", "align-items-center");
                    let priceLabel = document.createElement("label");
                    priceLabel.textContent = "Prix:";
                    let priceInput = document.createElement("input");
                    priceInput.type = "number";
                    priceInput.name = `variations[${variationNumber - 1}][price]`;
                    priceInput.id = `variation-price-${variationNumber}`;
                    priceInput.classList.add("form-control");
                    priceInput.style.width = "150px";
                    priceContainer.appendChild(priceLabel);
                    priceContainer.appendChild(priceInput);
                    informationsContainer.appendChild(priceContainer);
                }

                let informationsContainer = document.createElement("div");
                informationsContainer.classList.add("d-flex", "align-items-center", "flex-wrap");
                informationsContainer.style.gap = "10px";
                informationsContainer.style.border = "solid 2px #ced4da";
                informationsContainer.style.padding = "10px";
                informationsContainer.style.borderRadius = "10px";
                informationsContainer.style.maxWidth = "500px";
                variation.appendChild(informationsContainer);

                createPriceContainer();

                createQuantityInStockContaienr();

                createIsActiveVariationContainer();
            }

            function createVariationOptions() {

                // function createAttributeContainer(attribute) {
                //     let attributeContainer = document.createElement("div");
                //     attributeContainer.id = `container-attribute-${attribute}-${variationNumber}`;
                //     attributeContainer.classList.add("d-flex", "flex-column", "align-items-center");
                //     attributesContainer.appendChild(attributeContainer);

                //     let attributeLabel = document.createElement("label");
                //     attributeLabel.textContent = attribute;
                //     attributeContainer.appendChild(attributeLabel);

                //     let select = document.createElement("select");
                //     select.classList.add("form-select");
                //     select.style.width = "150px";
                //     select.name = `variations[${variationNumber - 1}][options][${attribute}]`;
                //     select.id = `options-select-${attribute}-${variationNumber}`;
                //     attributeContainer.appendChild(select);

                //     let defaultOption = document.createElement("option");
                //     defaultOption.value = "N/A";
                //     defaultOption.selected = true;
                //     defaultOption.textContent = "Choisir ici...";
                //     select.appendChild(defaultOption);

                //     for (let option of attributesAndOptions[attribute]) {
                //         let optionElement = document.createElement("option");
                //         optionElement.value = option;
                //         optionElement.textContent = option;
                //         select.appendChild(optionElement);
                //     }
                // }

                let attributesContainer = document.createElement("div");
                attributesContainer.id = `options-container-${variationNumber}`;
                attributesContainer.classList.add("d-flex", "align-items-center", "flex-wrap");
                attributesContainer.style.gap = "10px";
                attributesContainer.style.border = "solid 2px #ced4da";
                attributesContainer.style.padding = "10px";
                attributesContainer.style.borderRadius = "10px";
                attributesContainer.style.maxWidth = "700px";
                variation.appendChild(attributesContainer);

                for (let attribute in attributesAndOptions) {

                    createAttributeContainer(attribute, attributesContainer, variationNumber);
                }
            }

            function createVariationLabel() {
                let label = document.createElement("label");
                label.classList.add("form-label");
                label.id = `variation-label-${variationNumber}`;
                label.style.marginBottom = "-10px";
                label.textContent = `Variation ${variationNumber}:`;
                variation.appendChild(label);
            }

            let variation = document.createElement("div");
            variation.classList.add('d-flex', 'align-items-center');
            variation.id = `variation-${variationNumber}`;
            variation.style.gap = '20px';
            variation.style.marginBottom = '20px';

            createVariationLabel();

            createVariationOptions();

            createVariationInfomrations();

            createDeleteVariationButton();

            if (document.getElementsByClassName('spinner-border')[0] !== undefined) {
                document.getElementById("variations-container").innerHTML = "";
            }

            document.getElementById("variations-container").appendChild(variation);
        }

        createVariationContainer();

        // ! y a un probelem avec cette méthode
        // variation.innerHTML = `

        //     <label for="" class="form-label" style="margin-bottom: -10px">Variation ${variationNumber}:</label>

        //     <div class="d-flex align-items-center flex-wrap"
        //         style="gap: 10px; border: solid 2px #ced4da; padding: 10px; border-radius: 10px; max-width: 700px">
        // `

        // for (let attribute in attributesAndOptions) {

        //     variation.innerHTML += `
        //         <div class="d-flex flex-column align-items-center">

        //             <label for="">${attribute}:</label>

        //             <select name="options_select_${variationNumber}" id="options-select-${variationNumber}" class="form-select"
        //                 style="width: 150px">

        //                 <option value="N/A" selected>Choisir ici...</option>
        //     `

        //     for (let option in attributesAndOptions[attribute]) {

        //         variation.innerHTML += `
        //             <option value="${option}">${option}</option>
        //         `

        //     }

        //     variation.innerHTML += `
        //             </select>
        //         </div>
        //     `

        // }

        // variation.innerHTML += `
        //     </div>

        //     <div class="d-flex align-items-center flex-wrap"
        //         style="gap: 10px; border: solid 2px #ced4da; padding: 10px; border-radius: 10px; max-width: 500px">
        //         <div class="d-flex flex-column align-items-center">
        //             <label for="">Prix:</label>
        //             <input type="number" name="variation_price_${variationNumber}" class="form-control" style="width: 150px" />
        //         </div>

        //         <div class="d-flex flex-column align-items-center">
        //             <label for="">Qté dans le stock:</label>
        //             <input type="number" name="variation_quantity_in_stock_${variationNumber}" class="form-control"
        //                 style="width: 150px" />
        //         </div>

        //         <div class="d-flex flex-column align-items-center">

        //             <label for="" style="margin-bottom: 9px">Active:</label>
        //             <div class="d-flex">

        //                 <div class="form-check" style="padding-left: 0">
        //                     <label class="form-check-label" style="margin-left: 8px"
        //                         for="product-active-yes"> Oui </label>
        //                     <input class="form-check-input" id="product-active-yes-${variationNumber}" type="radio"
        //                         name="is_active_${variationNumber}" value="1" checked style="margin-left: 5px;" />
        //                 </div>
        //                 <div class="form-check" style="margin-left: 20px">
        //                     <label class="form-check-label" for="product-active-no">Non</label>
        //                     <input class="form-check-input" id="product-active-no-${variationNumber}" type="radio"
        //                         name="is_active_${variationNumber}" value="0" />
        //                 </div>


        //             </div>
        //         </div>

        //     </div>

        //     <span class="btn btn-danger btn-sm" id="delete-variation-${variationNumber}">
        //         <i class="fas fa-trash"></i>
        //     </span>
        // `

        // document.getElementById("variations-container").appendChild(variation);
    }


    let allChoosedAttributes = document.querySelectorAll('input[id*="attribute-"]');
    if (allChoosedAttributes.length === 0) {
        alert("Il faut d'abord choisir les attributs");
        return;
    }

    variationsCount += 1;

    if (Object.keys(attributesAndOptions).length === 0) {

        new Promise((resolve, reject) => {

            let variationsContainer = document.getElementById("variations-container");

            variationsContainer.innerHTML = `
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `
            variationsContainer.style.textAlign = "center";

            for (let i = 0; i < allChoosedAttributes.length; i++) {
                axios({
                    method: "GET",
                    url: `http://127.0.0.1:8000/api/products-attributes/${allChoosedAttributes[i].value}/options`,
                })
                    .then(response => {

                        console.log(response);

                        attributesAndOptions[allChoosedAttributes[i].value] = response.data.productOptions;

                        console.log(Object.keys(attributesAndOptions).length);

                        if (allChoosedAttributes.length - i === 1) {
                            resolve();
                        }

                    })
                    .catch((error) => {

                        reject(error);
                    })

            }
        })
            .then(() => {

                addNewVariationToVariationsContainer(variationsCount);

            })
            .catch((error) => {

                console.log(error);
                if (error.status === 401 || error.status === 403) {
                    window.location = "login";
                }
                else {
                    alert("Y a un problème dans le systeme. Veuillez contacter l'admin !");
                }
            })


    }
    else {

        addNewVariationToVariationsContainer(variationsCount);
    }

})
