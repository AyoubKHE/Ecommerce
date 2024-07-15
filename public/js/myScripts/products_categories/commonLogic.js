localStorage.setItem("ability", "read_productsCategories");

let allRelatedYesRadioButtons = document.querySelectorAll('input[id*="related_yes"]');

allRelatedYesRadioButtons.forEach(relatedYes => {
    relatedYes.addEventListener("click", function () {
        const idNumber = relatedYes.id.split("_")[2];
        document.getElementById("active_yes_" + idNumber).disabled = false;
        document.getElementById("active_no_" + idNumber).disabled = false;
    })
});

let allRelatedNoRadioButtons = document.querySelectorAll('input[id*="related_no"]');

allRelatedNoRadioButtons.forEach(relatedNo => {
    relatedNo.addEventListener("click", function () {
        const idNumber = relatedNo.id.split("_")[2];
        document.getElementById("active_yes_" + idNumber).disabled = true;
        document.getElementById("active_no_" + idNumber).disabled = true;
    })
});

//!-----------------------------------------------------------------------------------------------------------------------------------

let productActiveNoRadioButton = document.getElementById("category-active-no");

productActiveNoRadioButton.addEventListener("click", function () {
    let allActiveNoRadioButtons = document.querySelectorAll('input[id*="active_no"]');
    allActiveNoRadioButtons.forEach(function (activeNoRadioButton) {
        activeNoRadioButton.checked = true;
    })
})

let productActiveYesRadioButton = document.getElementById("category-active-yes");
productActiveYesRadioButton.addEventListener("click", function () {
    let allActiveYesRadioButtons = document.querySelectorAll('input[id*="active_yes"]');
    allActiveYesRadioButtons.forEach(function (activeYesRadioButton) {
        const idNumber = activeYesRadioButton.id.split("_")[2];
        if (document.getElementById("related_yes_" + idNumber).checked) {
            activeYesRadioButton.checked = true;
        }
    })
})

//!-----------------------------------------------------------------------------------------------------------------------------------
