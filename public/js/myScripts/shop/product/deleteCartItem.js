let allDeleteCartItemButtons = document.querySelectorAll('i[id*="delete-cart-item-"]');

allDeleteCartItemButtons.forEach(function (deleteCartItemButton) {

    deleteCartItemButton.addEventListener("click", function () {

        let cart_id = this.id.split("-")[3];
        let productVariation_id = this.id.split("-")[4];

        this.innerHTML = `
            <div class="spinner-border text-info" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `
        this.classList.remove("ri-close-line");

        axios({
            method: "DELETE",
            url: `http://127.0.0.1:8000/api/cart-item/${cart_id}-${productVariation_id}`,
        })
            .then(response => {
                
                let cartItemsCountSpan = document.getElementById("cart-items-count");
                cartItemsCountSpan.innerHTML = Number(cartItemsCountSpan.innerHTML) - 1;

                let itemPrice = Number(document.getElementById(`item-price-${cart_id}-${productVariation_id}`).innerHTML.trim().split(" ")[0]);

                let cartTotalPrice = document.getElementById(`cart-total-price`);

                cartTotalPrice.innerHTML = (Number(cartTotalPrice.innerHTML.trim().split(" ")[0]) - itemPrice) + " DA";

                document.getElementById(`cart-item-${cart_id}-${productVariation_id}`).remove();


            })
            .catch((error) => {
                console.log(error);

                this.innerHTML = "";
                this.classList.add("ri-close-line");

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
    })
})


// document.querySelectorAll('button[id*="delete-cart-item"]')


