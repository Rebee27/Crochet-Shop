document.addEventListener("DOMContentLoaded", function () {
    // Get the modal
    var modal = document.getElementById("modal");

    // Get the button that opens the modal
    var addButton = document.querySelector(".add-prod-bttn");

    // Get the <span> element that closes the modal
    var closeBtn = document.querySelector(".prod-close");

    // When the user clicks on the button, open the modal
    addButton.onclick = function () {
        modal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    closeBtn.onclick = function () {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

});
