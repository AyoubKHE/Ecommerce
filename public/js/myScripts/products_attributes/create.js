function removeOptionCard(optionNumber) {

    function rearrangeInputNumbers(from) {

        function insertNewDeleteOptionCardButton(i) {

            //! je crée un nouveau bouton de delete pour éviter le probleme d'Event Listener

            allOptionsCards[i].querySelector('span[id*="delete-option-"]').remove();

            let deleteOptionCardButton = document.createElement("span");
            deleteOptionCardButton.classList.add("btn", "btn-danger", "btn-sm");
            deleteOptionCardButton.id = `delete-option-${i + 1}`;
            deleteOptionCardButton.innerHTML = `
                <i class="fas fa-trash" aria-hidden="true"></i>
            `

            deleteOptionCardButton.addEventListener("click", function () {
                allOptionsCards[i].remove();

                rearrangeInputNumbers(i + 1);

                allOptionsCount -= 1;
            })

            allOptionsCards[i].querySelector('input[id*="option-"]').insertAdjacentElement("afterend", deleteOptionCardButton);
        }

        let allOptionsCards = document.querySelectorAll('div[id*="option-card-"]');
        for (let i = from - 1; i < allOptionsCards.length; i++) {

            allOptionsCards[i].id = `option-card-${i + 1}`;

            allOptionsCards[i].querySelector('label[id*="label-option-"]').id = `label-option-${i + 1}`;
            allOptionsCards[i].querySelector('label[id*="label-option-"]').innerHTML = `valeur ${i + 1}`;

            allOptionsCards[i].querySelector('input[id*="option-"]').id = `option-${i + 1}`;
            allOptionsCards[i].querySelector('input[id*="option-"]').name = `option_${i + 1}`;

            // allOptionsCards[i].querySelector('span[id*="delete-option-"]').id = `delete-option-${i + 1}`;

            insertNewDeleteOptionCardButton(i);

        }
    }

    document.getElementById(`option-card-${optionNumber}`).remove();
    rearrangeInputNumbers(optionNumber);
    allOptionsCount -= 1;
}

let allOptionsInputs = [...document.querySelectorAll('input[name*="option_"]')]; // convertir en array
let originaleOptions = allOptionsInputs.map((attributeInput) => {
    return attributeInput.value;
})

let allOptionsCount = originaleOptions.length;

//!------------------------------------------------------------------------------------------------------------------------

let AllDeleteAttributeOptionsButtons = document.querySelectorAll('span[id*="delete-option-"]');

AllDeleteAttributeOptionsButtons.forEach(function (deleteAttributeOptionButton) {
    deleteAttributeOptionButton.addEventListener("click", function () {

        const optionNumber = Number(deleteAttributeOptionButton.id.split("-")[2]);
        removeOptionCard(optionNumber);
    })
})

//!------------------------------------------------------------------------------------------------------------------------

let addNewAttributeOptionButton = document.getElementById("add-new-option");

addNewAttributeOptionButton.addEventListener("click", function () {

    function insertTheOptionCardOnPage() {
        let optionCardElement = document.createElement('div');

        optionCardElement.classList.add("d-flex");
        optionCardElement.classList.add("flex-column");
        optionCardElement.style.marginRight = "30px";
        optionCardElement.id = `option-card-${currentOptionNumber}`;

        optionCardElement.innerHTML = `
            <label for="" style="padding-left: 50px" id="label-option-${currentOptionNumber}">valeur ${currentOptionNumber}:</label>
            <div class="d-flex align-items-center" style="gap: 10px">
                <input type="text" id="option-${currentOptionNumber}" name="option_${currentOptionNumber}" class="form-control" style="width: 150px">
                <span class="btn btn-danger btn-sm" id="delete-option-${currentOptionNumber}">
                    <i class="fas fa-trash"></i>
                </span>
            </div>
        `

        addNewAttributeOptionButton.insertAdjacentElement("beforebegin", optionCardElement);
    }

    function addEventListenerToDeleteOptionButton() {
        let deleteOptionButton = document.getElementById(`delete-option-${currentOptionNumber}`);
        deleteOptionButton.addEventListener("click", function () {
            removeOptionCard(currentOptionNumber);
        })
    }

    allOptionsCount += 1;

    let currentOptionNumber = allOptionsCount;

    insertTheOptionCardOnPage();

    addEventListenerToDeleteOptionButton();
})



