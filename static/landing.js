let cart = document.getElementById("cart");
let place_order_button = document.getElementById('place_order_button');

function isNumber(n) { return !isNaN(parseFloat(n)) && !isNaN(n - 0) }

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
    addToCartButton.onclick = () => {
        deleteFromCart(id)
    };

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
    addToCartButton.onclick = () => {
        addToCart(id)
    };

    if (isCartEmpty()) {
        place_order_button.className = 'btn btn-success disabled';
    } else {
        place_order_button.className = 'btn btn-success';
    }
}

function isCartEmpty() {
    let ids = Object.keys(sessionStorage);
    return ids.length === 0;
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
    final_price.innerHTML = `Итого: ${sum} рублей`;

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
        deleteFromCart(parseInt(ids[i]));
    }
}

function printSS() {
    let keys = Object.keys(sessionStorage);

    for (let i = 0; i < keys.length; i++) {
        console.log(`${keys[i]} => ${sessionStorage.getItem(keys[i])}\n`);
    }
}

function generateModalContent(id) {

    let {name, subtitle, price, description, image_path} = products[id];

    let content = `<div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Товар</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="cart-product-${id}" class="cart-product d-flex flex-column">
                    <div class="cart-product-info mx-4">
                        <p class="fw-bold">${name}</p>
                        <p class="fw-light">${subtitle}</p>
                        <p class="fw-light">${price} руб.</p>
                        <p class="fst-italic">${description}</p>
                    </div>
                    <img style="padding: 20px" class="product-image" src="${image_path}" alt="">
                </div>
            </div>
            <div class="modal-footer">`

    if (!sessionStorage.getItem(id.toString())) {
        content += `<button id="product-modal-button" onclick="buttonProductModal(${id});" class="btn btn-success">Добавить в корзину</button>`
    } else {
        content += `<button id="product-modal-button" onclick="buttonProductModal(${id});" class="btn btn-outline-danger">Удалить из корзины</button>`
    }

    content += `<button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Закрыть
                </button>
            </div>
        </div>
    </div>`;
    return content;
}

function openProductModal(id) {
    let pm = document.getElementById('productModal');

    pm.innerHTML = generateModalContent(id);

    $('#productModal').modal('show');
}

function buttonProductModal(id) {
    let quantity = sessionStorage.getItem(id.toString());

    if (!quantity) {
        addToCart(id);
    } else {
        deleteFromCart(id);
    }

    $('#productModal').modal('hide');
}

function placeOrder() {
    let error = false;

    let form_alert = $('#form-error')[0];
    form_alert.className = "alert alert-danger d-none";

    let place_order_button = $('#place-order-button')[0];
    place_order_button.disabled = true;

    let name_field = $('#name')[0];
    let phone_field = $('#phone')[0];
    let address_field = $('#address')[0];
    let comment_field = $('#comment')[0];

    let fields = [name_field, phone_field, address_field, comment_field];

    let name = name_field.value;
    let phone = phone_field.value;
    let address = address_field.value;
    let comment = comment_field.value;

    if (name.length < 2) {
        form_alert.innerHTML = 'Слишком короткое имя! (Менее двух символов)';
        error = true;
    } else if (name.length > 64) {
        form_alert.innerHTML = 'Слишком длинное имя! (Превышает 64 символа)';
        error = true;
    }

    if (address.length < 10) {
        form_alert.innerHTML = 'Нет корректного адреса доставки!';
        error = true;
    }

    if (!phone || phone.length !== 11) {
        form_alert.innerHTML = 'Введите корректный телефон (11 символов, начинается с 7 или 8)';
        error = true;
    }

    if (comment.length > 256) {
        form_alert.innerHTML = 'Слишком длинный комментарий! (Более 256 символов)';
        error = true;
    }

    let text = (name + phone + address + comment).toLowerCase();
    if (text.includes('drop database') || text.includes('drop table')) {
        form_alert.innerHTML = 'Произолшла ошибка в выполнении запроса!';
        error = true;
    }

    if (error) {
        form_alert.className = "alert alert-danger";
        place_order_button.disabled = false;
        return
    }

    fields.map((field) => {
        field.disabled = true;
        return field;
    })

    let cart_string = '';
    let cart_keys = Object.keys(sessionStorage);
    for (let i = 0; i < cart_keys.length; i++) {
        cart_string += `${cart_keys[i]}:${sessionStorage.getItem(cart_keys[i])};`
    }

    let sending_data = {
        'name': name,
        'address': address,
        'phone': phone,
        'comm': comment,
        'cart': cart_string
    }

    $.post('/place_order_landing.php', {text: JSON.stringify(sending_data)}, function (data) {
        if (isNumber(data) && parseInt(data) !== 0) {
            form_alert.className = "alert alert-danger d-none";
            let new_order_id = parseInt(data);
            let order_success_text = $('#order-id-text')[0];
            order_success_text.innerHTML = `Номер вашего заказа: ${new_order_id}`;
            $('#orderModal').modal('hide');
            $('#orderResultModal').modal('show');
        }
    });

    if (error) {
        form_alert.className = "alert alert-danger";
    }

    form_alert.innerHTML = 'Произолшла ошибка в создании заказа!';

    fields.map((field) => {
        field.value = '';
        field.disabled = false;
        return field;
    })
    place_order_button.disabled = false;

    clearCart();
}

function trackOrder() {
    let tracking_body = $('#tracking-body')[0];
    let track_code = $('#tracking_code')[0];

    if (!isNumber(track_code.value)){
        tracking_body.innerHTML = "<div id=\"tracking_error\" class=\"alert alert-danger d-none\">Неверный номер заказа!</div>";
        return;
    }

    $.get('/tracking_landing.php', {id: track_code.value}, function (data) {
        tracking_body.innerHTML = data;
    });
}