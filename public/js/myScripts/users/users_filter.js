
let btnApply = document.getElementById("apply");

btnApply.addEventListener("click", function () {

    function buildFilter() {

        let filter = {};

        if(document.getElementById("user-id").value !== "") {
            filter["id"] = document.getElementById("user-id").value;
        }

        if(document.getElementById("username").value !== "") {
            filter["username"] =  "%" + document.getElementById("username").value + "%";
        }

        if(document.getElementById("user-first-name").value !== "") {
            filter["first_name"] =  "%" + document.getElementById("user-first-name").value + "%";
        }

        if(document.getElementById("user-last-name").value !== "") {
            filter["last_name"] =  "%" + document.getElementById("user-last-name").value + "%";
        }

        if(document.getElementById("user-email").value !== "") {
            filter["email"] = "%" + document.getElementById("user-email").value + "%";
        }

        if(document.getElementById("user-phone").value !== "") {
            filter["phone"] = "%" + document.getElementById("user-phone").value + "%";
        }

        if(document.getElementById("created-by-username").value !== "All") {
            filter["added_by"] = document.getElementById("created-by-username").value
        }

        if(document.getElementById("user-role").value !== "All") {
            filter["role"] = document.getElementById("user-role").value
        }

        if(document.getElementById("yes").checked) {
            filter["is_active"] = 1;
        }
        else if(document.getElementById("no").checked) {
            filter["is_active"] = 0;
        }

        filter["birth_date"] = {
            "from" : document.getElementById("birth-date-from").value,
            "to" : document.getElementById("birth-date-to").value
        }

        filter["created_at"] = {
            "from" : document.getElementById("created-at-date-from").value + ' ' + document.getElementById("created-at-time-from").value,
            "to" : document.getElementById("created-at-date-to").value + ' ' + document.getElementById("created-at-time-to").value
        }

        filter["updated_at"] = {
            "from" : document.getElementById("updated-at-date-from").value + ' ' + document.getElementById("updated-at-time-from").value,
            "to" : document.getElementById("updated-at-date-to").value + ' ' + document.getElementById("updated-at-time-to").value
        }


        // filter["last_login"] = {
        //     "from" : document.getElementById("last-login-date-from").value + ' ' + document.getElementById("last-login-time-from").value,
        //     "to" : document.getElementById("last-login-date-to").value + ' ' + document.getElementById("last-login-time-to").value
        // }

        return filter;

    }


    let filter = buildFilter();

    localStorage.setItem("filter", JSON.stringify(filter));

    let modal = document.getElementById("makeFilter");
    let modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();

    fetchPage(1, "filter", filter, localStorage.getItem("ability"));

    currentMode = "filter";

})


