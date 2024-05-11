document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded and parsed');

    var links = document.querySelectorAll('.admin-navbar a');
    links.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            var target = this.getAttribute('href');

            var sections = document.querySelectorAll('.main-container-admin section');
            sections.forEach(function (section) {
                section.style.display = 'none';
            });

            document.querySelector(target).style.display = 'block';

            document.querySelector('.main-container-admin').classList.remove('show-products', 'show-users', 'show-orders');
            if (target === '#products') {
                document.querySelector('.main-container-admin').classList.add('show-products');
            } else if (target === '#users') {
                document.querySelector('.main-container-admin').classList.add('show-users');
            } else if (target === '#orders') {
                document.querySelector('.main-container-admin').classList.add('show-orders');
            }
                      
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    var saveUserButtons = document.querySelectorAll('.edit-user-bttn');
    saveUserButtons.forEach(function (button) {
        button.addEventListener('click', function () {

            var userId = button.getAttribute('data-user-id');

            var username = button.parentElement.parentElement.querySelector('input[name="username"]').value;
            var firstName = button.parentElement.parentElement.querySelector('input[name="first_name"]').value;
            var secondName = button.parentElement.parentElement.querySelector('input[name="second_name"]').value;
            var email = button.parentElement.parentElement.querySelector('input[name="email"]').value;
            var userType = button.parentElement.parentElement.querySelector('select[name="user_type').value;

            // Trimitem datele către server folosind XMLHttpRequest sau Fetch API
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert('User information updated successfully!');
                    } else {
                        console.error('Error: ' + xhr.status);
                    }
                }
            };
            xhr.send('user_id=' + userId + '&username=' + encodeURIComponent(username) + '&first_name=' + encodeURIComponent(firstName) + '&second_name=' + encodeURIComponent(secondName) + '&email=' + encodeURIComponent(email) + '&user_type=' + encodeURIComponent(userType));
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {

    var saveProductButtons = document.querySelectorAll('.edit-product-bttn');
    saveProductButtons.forEach(function (button) {
        button.addEventListener('click', function () {

            var productId = button.getAttribute('data-product-id');

            var name = button.parentElement.parentElement.querySelector('input[name="name"]').value;
            var price = button.parentElement.parentElement.querySelector('input[name="price"]').value;
            var category = button.parentElement.parentElement.querySelector('select[name="category').value;
            var description = button.parentElement.parentElement.querySelector('input[name="description"]').value;
            var short_description = button.parentElement.parentElement.querySelector('input[name="short_description"]').value;
            var rating = button.parentElement.parentElement.querySelector('input[name="rating"]').value.trim();

            // Trimitem datele către server folosind XMLHttpRequest sau Fetch API
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert('Product information updated successfully!');
                    } else {
                        console.error('Error: ' + xhr.status);
                        alert("Error: " + xhr.status);
                    }
                }
            };
            xhr.send('product_id=' + productId + '&name=' + encodeURIComponent(name) + '&price=' + encodeURIComponent(price) + '&category=' + encodeURIComponent(category) + '&description=' + encodeURIComponent(description) + '&short_description=' + encodeURIComponent(short_description) + '&rating=' + encodeURIComponent(rating));
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {

    var saveProductButtons = document.querySelectorAll('.edit-order-bttn');
    saveProductButtons.forEach(function (button) {
        button.addEventListener('click', function () {

            var order_id = button.getAttribute('data-order-id');

            var user_id = button.parentElement.parentElement.querySelector('input[name="user_id"]').value;
            var user_name = button.parentElement.parentElement.querySelector('input[name="user_name"]').value;
            var user_email = button.parentElement.parentElement.querySelector('input[name="user_email').value;
            var user_phone = button.parentElement.parentElement.querySelector('input[name="user_phone"]').value;
            var user_address = button.parentElement.parentElement.querySelector('input[name="user_address"]').value;
            var payment_method = button.parentElement.parentElement.querySelector('select[name="payment_method"]').value.trim();
            var product_ids = button.parentElement.parentElement.querySelector('input[name="product_ids"]').value;
            var total = button.parentElement.parentElement.querySelector('input[name="total"]').value;

            // Trimitem datele către server folosind XMLHttpRequest sau Fetch API
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert('Order information updated successfully!');
                    } else {
                        console.error('Error: ' + xhr.status);
                        alert("Error: " + xhr.status);
                    }
                }
            };
            xhr.send('order_id=' + order_id + '&user_id=' + encodeURIComponent(user_id) + '&user_name=' + encodeURIComponent(user_name) + 
            '&user_email=' + encodeURIComponent(user_email) + '&user_phone=' + encodeURIComponent(user_phone) + '&user_address=' + 
            encodeURIComponent(user_address) + '&payment_method=' + encodeURIComponent(payment_method) + '&product_ids=' + 
            encodeURIComponent(product_ids) + '&total=' + encodeURIComponent(total));
        });
    });
});
