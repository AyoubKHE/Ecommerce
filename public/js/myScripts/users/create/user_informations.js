function showUserInformationsForm() {

    document.getElementById("user-informations-form").style.display = "block";
    document.getElementById("user-informations-link").classList.add("active");


    document.getElementById("user-permissions-form").style.display = "none";
    document.getElementById("user-permissions-link").classList.remove("active");
}

function showUserPermissionsForm() {

    document.getElementById("user-permissions-form").style.display = "block";
    document.getElementById("user-permissions-link").classList.add("active");

    document.getElementById("user-informations-form").style.display = "none";
    document.getElementById("user-informations-link").classList.remove("active");
}

document.getElementById("user-role-select").addEventListener("change", function () {
    if (this.value === "admin") {
        document.getElementById("user-permissions-link").classList.add("disabled");
    }
    else {
        document.getElementById("user-permissions-link").classList.remove("disabled");
    }
})
