let btnChange = document.getElementById("change");

let eye = document.getElementById("eye");

eye.addEventListener("click", function() {

    let inptPassword = document.getElementById("input-password");
    if (eye.getAttribute("class") == "fa fa-eye") {
        eye.setAttribute("class", "fa fa-eye-slash");
        inptPassword.type = "text";
    } else {
        eye.setAttribute("class", "fa fa-eye");
        inptPassword.type = "password";
    }

})

