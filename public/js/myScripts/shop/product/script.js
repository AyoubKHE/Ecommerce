
let productId = document.getElementById("product_id").value;

let productVariations = null;

document.addEventListener("DOMContentLoaded", function () {

    axios({
        method: "GET",
        url: `http://127.0.0.1:8000/api/product/${productId}/variations`,
    })
        .then(response => {

            console.log(response);
            productVariations = response.data.productVariations;
        })
        .catch((error) => {
            console.log(error);
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

