function removeOptionCard(optionNumber) {

    function changeOnUserInterface() {

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

                let inputIdInDatabase = allOptionsCards[i].querySelector('input[name*="-id-in-database"]');
                if(inputIdInDatabase !== null) {
                    inputIdInDatabase.name = `option-${i + 1}-id-in-database`;
                }

                allOptionsCards[i].querySelector('label[id*="label-option-"]').id = `label-option-${i + 1}`;
                allOptionsCards[i].querySelector('label[id*="label-option-"]').innerHTML = `valeur ${i + 1}`;

                allOptionsCards[i].querySelector('input[id*="option-"]').id = `option-${i + 1}`;
                allOptionsCards[i].querySelector('input[id*="option-"]').name = `option_${i + 1}`;

                // allOptionsCards[i].querySelector('span[id*="delete-option-"]').id = `delete-option-${i + 1}`;

                insertNewDeleteOptionCardButton(i);

            }
        }

        document.getElementById(`option-card-${optionNumber}`).remove();
        allOptionsCount -= 1;

        rearrangeInputNumbers(optionNumber);


        alert("L'attribut est bien été supprimer");
    }

    function changeOnUserInterfaceAndDatabase() {

        let optionIDInDatabase = document.querySelector(`input[name*="option-${optionNumber}-id-in-database"]`).value;

        axios({
            method: "DELETE",
            url: `http://127.0.0.1:8000/api/products-attributes-options/${optionIDInDatabase}`,
        })
            .then((response) => {
                console.log(response);

                originaleOptions = originaleOptions.filter((option) => option !== document.getElementById(`option-${optionNumber}`).value);

                changeOnUserInterface();

            })
            .catch((error) => {
                console.log(error);
                if (error.status === 401 || error.status === 403) {
                    window.location = "login";
                }
                else {

                    if(error.response.data.message.split(":")[0] === "SQLSTATE[23000]") {
                        alert("La suppression de l'option a échoué, Il peut que vous utilisez cette option dans l'un de vos variations de produit.");
                    }
                    else {
                        alert("La suppression de l'option a échoué, réessayer plus tard.");
                    }

                }

            })
    }

    if (optionNumber <= originaleOptions.length) {

        if(originaleOptions.length === 1) {
            alert("Il faut que l attribut possède au moins une seule valeur ou plus");
            return;
        }

        changeOnUserInterfaceAndDatabase();
    }
    else {

        changeOnUserInterface();
    }

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




