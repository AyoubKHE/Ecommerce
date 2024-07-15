
allCheckboxesPermissionsAll.forEach(function (checkboxPermissionAll) {
    let appropriateResource = checkboxPermissionAll.id.split("-")[2];

    if (checkboxPermissionAll.checked === true) {

        let ressourceCheckboxes = document.querySelectorAll(`input[id*="-permission-${appropriateResource}"]`);
        ressourceCheckboxes.forEach(function (ressourceCheckbox) {
            ressourceCheckbox.disabled = true;
            ressourceCheckbox.checked = false;
        })

        document.querySelector(`input[id*="nothing-permissions-${appropriateResource}"]`).disabled = true;
        document.querySelector(`input[id*="nothing-permissions-${appropriateResource}"]`).checked = false;
    }
})


allCheckboxesPermissionsNothing.forEach(function (checkboxPermissionNothing) {

    let appropriateResource = checkboxPermissionNothing.id.split("-")[2];

    if (checkboxPermissionNothing.checked === true) {

        let ressourceCheckboxes = document.querySelectorAll(`input[id*="-permission-${appropriateResource}"]`);
        ressourceCheckboxes.forEach(function (ressourceCheckbox) {
            ressourceCheckbox.disabled = true;
            ressourceCheckbox.checked = false;
        })

        document.querySelector(`input[id*="all-permissions-${appropriateResource}"]`).disabled = true;
        document.querySelector(`input[id*="all-permissions-${appropriateResource}"]`).checked = false;
    }


})

