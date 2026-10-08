/* =========================================================
   CRAFT NEST - FRONTEND JAVASCRIPT
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    /* -----------------------------------------
       Smooth navigation
       ----------------------------------------- */

    const navLinks = document.querySelectorAll(
        '.nav-container a[href^="#"]'
    );

    navLinks.forEach(function (link) {

        link.addEventListener("click", function (event) {

            const targetId = this.getAttribute("href");

            if (targetId === "#") {
                return;
            }

            const target = document.querySelector(targetId);

            if (target) {
                event.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }

        });

    });


    /* -----------------------------------------
       Product image error handling
       ----------------------------------------- */

    const productImages = document.querySelectorAll(
        'main > table img'
    );

    productImages.forEach(function (image) {

        image.addEventListener("error", function () {

            this.style.display = "none";

        });

    });


    /* -----------------------------------------
       Search box
       ----------------------------------------- */

    const searchInput = document.querySelector(
        '.search-container input'
    );

    const searchButton = document.querySelector(
        '.search-container button'
    );

    if (searchInput && searchButton) {

        searchButton.addEventListener("click", function () {

            const searchText = searchInput.value.trim();

            if (searchText === "") {
                searchInput.focus();
                return;
            }

            /*
             * We are not changing your backend search functionality.
             * This only gives feedback until a search page/function
             * is connected.
             */

            console.log("Searching for:", searchText);

        });

        searchInput.addEventListener("keydown", function (event) {

            if (event.key === "Enter") {

                searchButton.click();

            }

        });

    }


    /* -----------------------------------------
       Button hover / click effect
       ----------------------------------------- */

    const buttons = document.querySelectorAll("button");

    buttons.forEach(function (button) {

        button.addEventListener("click", function () {

            this.classList.add("clicked");

            setTimeout(() => {
                this.classList.remove("clicked");
            }, 150);

        });

    });

});