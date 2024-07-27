let wilayasSelect = document.getElementById("wilayas-select");

wilayasSelect.addEventListener("change", function () {
    if (this.value != "") {

        let wilayaId = this.value;

        axios({
            method: "GET",
            url: `http://127.0.0.1:8000/api/wilaya/${wilayaId}/communes`,
        })
            .then(response => {
                console.log(response);

                let communesSelect = document.getElementById("communes-select");
                communesSelect.innerHTML = "";
                let communes = response.data.communes;

                let defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.innerHTML = "Veuillez sélectionner...";

                communesSelect.appendChild(defaultOption);

                for (const commune of communes) {

                    let option = document.createElement("option");
                    option.value = commune["id"];
                    option.innerHTML = commune["name"];

                    communesSelect.appendChild(option);
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

    }
})


let allShippingMethodsRadioButtons = document.querySelectorAll('input[id*="shipping-method-"]');

allShippingMethodsRadioButtons.forEach(function (shippingMethodRadioButton) {
    shippingMethodRadioButton.addEventListener("change", function () {
        console.log(this.getAttribute("data-price"));

        let shippingPrice = Number(this.getAttribute("data-price"));

        document.getElementById("shipping-price").innerHTML = shippingPrice + " DA";

        let subtotalPrice = Number(document.getElementById("sous-total").innerHTML.trim().split(" ")[0]);

        document.getElementById("price-total").innerHTML = subtotalPrice + shippingPrice + ".00 DA";
    })
})


document.addEventListener('DOMContentLoaded', function (event) {

    document.querySelectorAll('input[name="user_address"]').forEach((userAddressInput) => {
        userAddressInput.addEventListener("change", function () {

            if (this.value == "new_address") {
                document.getElementById("new-address-form").style.display = 'block';
            }else {
                document.getElementById("new-address-form").style.display = 'none';
            }
        });
    });
});
