document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll('.checkbox-select input[type="checkbox"]');
    const products = document.querySelectorAll('.product');
    const noProductsMessage = document.querySelector('.no-products-message');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const selectedCategories = Array.from(document.querySelectorAll('.checkbox-select input[type="checkbox"]:checked'))
                .map(function(checkbox) {
                    return checkbox.value.trim().toLowerCase(); // Ensure lowercase and trim whitespace
                });

            let hasProducts = false;

            products.forEach(function(product) {
                const category = product.getAttribute('data-category').trim().toLowerCase(); // Ensure lowercase and trim whitespace

                // Check if no categories are selected or if product category matches any selected category
                if (selectedCategories.length === 0 || selectedCategories.includes('all') || selectedCategories.includes(category)) {
                    product.style.display = 'block';
                    hasProducts = true;
                } else {
                    product.style.display = 'none';
                }
            });

            if (!hasProducts) {
                noProductsMessage.style.display = 'block';
            } else {
                noProductsMessage.style.display = 'none';
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.querySelector('.search-bar');
    const products = document.querySelectorAll('.product');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();

        products.forEach(function(product) {
            const productName = product.getAttribute('data-name').toLowerCase();
            const productCategory = product.getAttribute('data-category').toLowerCase();

            if (productName.includes(searchTerm) || productCategory.includes(searchTerm)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    });
});


