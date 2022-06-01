let cart = document.getElementById("cart");
let place_order_button = document.getElementById('place_order_button');


function init() {
    let ids = Object.keys(sessionStorage);
    for (let i = 0; i < ids.length; i++) {
        addToCart(parseInt(ids[i]));
    }
    document.body.style.opacity = "1";
}

function createCartBlock(id) {
    let product_data = products[id];
    let {name, image_path, price} = product_data;
    let quantity = parseInt(sessionStorage.getItem(id.toString()));
    let block = `<div id="cart-product-${id}" class="cart-product">
                        <img class="cart-image" src="${image_path}" alt="">
                        <div class="cart-product-info mx-4">
                            <p class="fw-bold">${name}</p>
                            <p class="fw-light">${price} руб.</p>
                            <ul id="quantity-selector" class="pagination mt-3">
                                <li style="cursor: pointer" class="page-item">
                                    <a onclick="decrementValue(${id});" class="page-link btn-primary">-</a>
                                </li>
                                <li class="page-item disabled">
                                    <input id="quantity-${id}" name="quantity-${id}" style="width: 60px; text-align: center"
                                           type="number" class="page-link btn-primary"
                                           value="${quantity}">
                                </li>
                                <li style="cursor: pointer" class="page-item">
                                    <a onclick="incrementValue(${id});" class="page-link btn-primary">+</a>
                                </li>
                            </ul>
                            <p id="final_product_price_${id}" class="fs-4">${quantity * price} рублей</p>
                            <button onclick="deleteFromCart(${id})" class="btn btn-outline-danger">Удалить из корзины</button>
                        </div>
                        <hr>
                    </div>`;
    cart.innerHTML += block;
    updateCartPrice();
}

function deleteCartBlock(id) {
    let block = document.getElementById(`cart-product-${id}`);
    block.parentNode.removeChild(block);
    updateCartPrice();
}

function addToCart(id) {
    if (!sessionStorage.getItem(id.toString())) {
        sessionStorage.setItem(id.toString(), '1');
    }
    createCartBlock(id);

    let addToCartButton = document.getElementById(`addToCart-${id}`);
    addToCartButton.className = 'btn btn-danger';
    addToCartButton.innerHTML = 'Удалить из корзины';
    addToCartButton.onclick = () => {deleteFromCart(id)};

    if (isCartEmpty()) {
        place_order_button.className = 'btn btn-success disabled';
    } else {
        place_order_button.className = 'btn btn-success';
    }
}

function deleteFromCart(id) {
    sessionStorage.removeItem(id.toString());
    deleteCartBlock(id);

    let addToCartButton = document.getElementById(`addToCart-${id}`);
    addToCartButton.className = 'btn btn-success';
    addToCartButton.innerHTML = 'Добавить в корзину';
    addToCartButton.onclick = () => {addToCart(id)};

    if (isCartEmpty()) {
        place_order_button.className = 'btn btn-success disabled';
    } else {
        place_order_button.className = 'btn btn-success';
    }
}

function isCartEmpty() {
    let ids = Object.keys(sessionStorage);
    return ids.length !== 0;
}

function incrementValue(id) {
    let value = parseInt(document.getElementById(`quantity-${id}`).value);
    value = isNaN(value) ? 1 : value;
    value++;
    if (value > 10) {
        value = 10;
    } else if (value < 1) {
        value = 1;
    }
    sessionStorage.setItem(id.toString(), value.toString());
    document.getElementById(`quantity-${id}`).value = value;
    let fpp = document.getElementById(`final_product_price_${id}`);
    fpp.innerHTML = `${value * products[id].price} рублей`;
    updateCartPrice();
}

function decrementValue(id) {
    let value = parseInt(document.getElementById(`quantity-${id}`).value);
    value = isNaN(value) ? 1 : value;
    value--;
    if (value > 10) {
        value = 10;
    } else if (value < 1) {
        value = 1;
    }
    sessionStorage.setItem(id.toString(), value.toString());
    document.getElementById(`quantity-${id}`).value = value;
    let fpp = document.getElementById(`final_product_price_${id}`);
    fpp.innerHTML = `${value * products[id].price} рублей`;
    updateCartPrice();
}

function updateCartPrice() {
    let prices = document.querySelectorAll('[id^="final_product_price_"]');
    let sum = 0;
    for (let i = 0; i < prices.length; i++) {
        let block_price = parseInt(prices[i].innerHTML.match(/\d{1,10}/)[0]);
        sum += block_price;
    }

    let final_price = document.getElementById('final_price');
    final_price.innerHTML = `${sum} рублей`;

    let cart_counter = document.getElementById('cart_counter');
    let count = 0;
    let ids = Object.keys(sessionStorage);
    for (let i = 0; i < ids.length; i++) {
        count += parseInt(sessionStorage.getItem(ids[i]));
    }
    cart_counter.innerHTML = count.toString();
}

function clearCart() {
    let ids = Object.keys(sessionStorage);
    for (let i = 0; i < ids.length; i++) {
        deleteFromCart(parseInt(ids[i]))
    }
}

function printSS() {
    let keys = Object.keys(sessionStorage);

    for (let i = 0; i < keys.length; i++) {
        console.log(`${keys[i]} => ${sessionStorage.getItem(keys[i])}\n`);
    }
}