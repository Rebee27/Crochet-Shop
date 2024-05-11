// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btns = document.querySelectorAll(".see-more-bttn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

function generateStarRating(rating) {
  var stars = '';
  for (var i = 1; i <= 5; i++) {
    if (i <= rating) {
      stars += '<i class="fas fa-star"></i>';
    } else {
      stars += '<i class="far fa-star"></i>';
    }
  }
  return stars;
}


// When the user clicks on the button, open the modal
btns.forEach(function(btn) {
  btn.onclick = function() {
      modal.style.display = "block";
      var productName = this.parentElement.dataset.name;
      var productDescription = this.parentElement.dataset.description;
      var productRating = parseInt(this.parentElement.dataset.rating);
      var productPrice = this.parentElement.dataset.price;
      var productCategory = this.parentElement.dataset.category;
      var productImageSrc = this.parentElement.querySelector('img').src;

      var starRatingHTML = generateStarRating(productRating);

      // Insert data into modal
      document.getElementById("modal-product-name").innerText = productName;
      document.getElementById("modal-product-description").innerText = productDescription;
      document.getElementById("modal-product-category").innerText = productCategory;
      document.getElementById("modal-product-rating").innerHTML = starRatingHTML;
      document.getElementById("modal-product-price").innerText = "$" + productPrice;
      document.getElementById("modal-product-image").src = productImageSrc;
  }
});



// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
