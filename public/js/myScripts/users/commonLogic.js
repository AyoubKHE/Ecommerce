
let allCheckboxesPermissionsAll = document.querySelectorAll('input[id*="all-permissions-"]')

allCheckboxesPermissionsAll.forEach(function (checkboxPermissionAll) {

    checkboxPermissionAll.addEventListener("change", function () {

        let appropriateResource = checkboxPermissionAll.id.split("-")[2];

        if(checkboxPermissionAll.checked === true) {

            let ressourceCheckboxes = document.querySelectorAll(`input[id*="-permission-${appropriateResource}"]`);
            ressourceCheckboxes.forEach(function (ressourceCheckbox) {
                ressourceCheckbox.disabled = true;
                ressourceCheckbox.checked = false;
            })

            document.querySelector(`input[id*="nothing-permissions-${appropriateResource}"]`).disabled = true;
            document.querySelector(`input[id*="nothing-permissions-${appropriateResource}"]`).checked = false;
        }
        else {
            let ressourceCheckboxes = document.querySelectorAll(`input[id*="-permission-${appropriateResource}"]`);
            ressourceCheckboxes.forEach(function (ressourceCheckbox) {
                ressourceCheckbox.disabled = false;
            })

            document.querySelector(`input[id*="nothing-permissions-${appropriateResource}"]`).disabled = false;
        }
    })


})



//!----------------------------------------------------------------------------------------------------------------------------

let allCheckboxesPermissionsNothing = document.querySelectorAll('input[id*="nothing-permissions-"]')

allCheckboxesPermissionsNothing.forEach(function (checkboxPermissionNothing) {

    checkboxPermissionNothing.addEventListener("change", function () {

        let appropriateResource = checkboxPermissionNothing.id.split("-")[2];

        if(checkboxPermissionNothing.checked === true) {

            let ressourceCheckboxes = document.querySelectorAll(`input[id*="-permission-${appropriateResource}"]`);
            ressourceCheckboxes.forEach(function (ressourceCheckbox) {
                ressourceCheckbox.disabled = true;
                ressourceCheckbox.checked = false;
            })

            document.querySelector(`input[id*="all-permissions-${appropriateResource}"]`).disabled = true;
            document.querySelector(`input[id*="all-permissions-${appropriateResource}"]`).checked = false;
        }
        else {
            let ressourceCheckboxes = document.querySelectorAll(`input[id*="-permission-${appropriateResource}"]`);
            ressourceCheckboxes.forEach(function (ressourceCheckbox) {
                ressourceCheckbox.disabled = false;
            })

            document.querySelector(`input[id*="all-permissions-${appropriateResource}"]`).disabled = false;
        }
    })


})


//!---------------------------------------------------------------------------------------------------------------------------

let allPermissionsCheckboxes = document.querySelectorAll('input[id*="-permission"]');

allPermissionsCheckboxes.forEach(function (permissionCheckbox) {
    permissionCheckbox.addEventListener("change", function () {
        let permissionOption = this.id.split("-")[0];
        let permissionResource = this.id.split("-")[2];

        let permissionOldValue = Number(document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value);

        if(this.checked === true) {

            if(permissionOption === "nothing") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = 0;
            }
            else if(permissionOption === "read") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = permissionOldValue + 1;
            }
            else if(permissionOption === "add") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = permissionOldValue + 2;
            }
            else if(permissionOption === "update") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = permissionOldValue + 4;
            }
            else if(permissionOption === "delete") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = permissionOldValue + 8;
            }
            else if(permissionOption === "all") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = -1;
            }
        }
        else {
            if(permissionOption === "read") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = permissionOldValue - 1;
            }
            else if(permissionOption === "add") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = permissionOldValue - 2;
            }
            else if(permissionOption === "update") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = permissionOldValue - 4;
            }
            else if(permissionOption === "delete") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = permissionOldValue - 8;
            }
            else if(permissionOption === "all") {
                document.querySelector(`input[name*="permissions[${permissionResource}]"]`).value = 0;
            }
        }
    })
})
