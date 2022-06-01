<?php
require('db_connection_landing.php');
require('utils_landing.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maskarad</title>
    <link rel="shortcut icon" href="static/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="static/style_landing.css">
</head>
<body style="opacity: 0; transition: 0.5s;" onload="init()" class="is-flex is-justify-content-space-between is-flex-direction-column">

<!-- HEADER -->
<nav class="navbar fixed-top navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img id="header-image" src="static/logo-header.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse is-flex is-flex-direction-row justify-content-between align-items-center"
             id="navbarNavAltMarkup">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="#catalogue">Каталог</a></li>
                <li class="nav-item"><a class="nav-link" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#orderTracking">Отслеживание</a></li>
                <li class="nav-item"><a class="nav-link" href="#contacts">Контакты</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- HEADER -->

<!-- MODAL CART -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Корзина MASKARAD</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="cart">

                </div>
                <h3 id="final_price" style="padding: 20px" class="text-success">Итого: 0 рублей</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" id="place_order_button" class="btn btn-success disabled" data-bs-toggle="modal" data-bs-target="#orderModal">
                    Оформить заказ
                </button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL CART -->

<!-- MODAL ORDER -->

<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Оформление заказа</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="form-error" class="alert alert-danger d-none">Ошибка в заполнении формы, проверьте поля ещё раз</div>
                <form id="order_form">
                    <label class="form-label" for="name">Имя получателя</label><br>
                    <input type="text" class="form-control" name="name" minlength="2" id="name" required>
                    <p class="form-text">Ввести следует имя человека, который будет получать заказ</p>
                    <label class="form-label" for="phone">Номер мобильного телефона</label><br>
                    <input type="text" pattern="^((\+7|7|8)+([0-9]){10})$" class="form-control" name="phone" id="phone" required>
                    <p class="form-text">Телефон необходим для связи представителя магазина при подтверждении заказа, и курьера</p>
                    <label class="form-label" for="address">Адрес доставки</label><br>
                    <input type="text" class="form-control" name="address" id="address" required>
                    <p class="form-text">Проверьте адрес доставки. В случае ошибки, адрес можно будет поменять через поддержку.</p>
                    <label class="form-label" for="comment">Комментарий к заказу</label><br>
                    <input type="text" class="form-control" name="comment" id="comment">
                    <p class="form-text">Данный комментарий относится как к складским работникам, так и работникам
                        доставки</p>
                    <hr>
                    <p class="fw-light fst-italic small">Оформляя заказ, вы соглашаетесь с <a href="https://yandex.ru/support/marketplace/orders/dbs/requirements.php">правилами обработки заказов</a> и последующей <a href="https://yandex.ru/legal/taxi_corporate_delivery_terms/?lang=ru">доставкой товаров</a></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cartModal">
                    Назад
                </button>
                <button id="place-order-button" type="button" onclick="placeOrder()" class="btn btn-success">
                    Оформить заказ
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ORDER -->

<!-- MODAL ORDER RESULT -->

<div class="modal fade" id="orderResultModal" tabindex="-1" aria-labelledby="orderResultModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Результат</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="padding: 20px" id="result-body">
                    <h2 class="text-success">Заказ успешно оформлен!</h2>
                    <p id="order-id-text" class="fst-italic fw-light">Номер вашего заказа: 34</p>
                    <p>Скоро с вами свяжется администратор для уточнения деталей заказа</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ORDER RESULT -->

<!-- MODAL TRACKING -->

<div class="modal fade" id="orderTracking" tabindex="-1" aria-labelledby="orderTracking" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Отслеживание</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="padding: 20px" id="tracking-body-form">
                    <h4>Введите номер заказа</h4>
                    <input id="tracking_code" name="tracking_code" type="text" class="form-control" value="">
                    <button onclick="trackOrder()" class="btn btn-primary mt-2">Отследить</button>
                </div>
                <hr>
                <div style="padding: 20px" id="tracking-body">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TRACKING -->

<!-- MODAL PRODUCT -->

<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Товар</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="cart-product-${id}" class="cart-product">
                    <img class="cart-image" src="/static/data/farm-stay.png" alt="">
                    <div class="cart-product-info mx-4">
                        <p class="fw-bold">${name}</p>
                        <p class="fw-light">${subtitle}</p>
                        <p class="fw-light">${price} руб.</p>
                        <p class="fs-4">${description}</p>
                        <button id="product-modal-button" onclick="addToCartProduct(${id})" class="btn btn-outline-danger">Добавить в корзину</button>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PRODUCT -->

<!-- MAIN -->
<div id="promo-block" class="container py-5">
    <div style="background-image: url('/static/back.jpg');" class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
        <div style="color: white" class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h1 class="display-5 fw-bold lh-1">MASKARAD</h1>
            <p class="lead">Онлайн-магазин всего на свете по лучшим ценам и с лучшими поставщиками, рекомендую,
                кстати</p>
            <a class="btn btn-outline-success btn-lg" href="/index.php">Многостраничный сайт</a>
        </div>
    </div>
</div>

<h1 id="catalogue" class="display-5 text-center mb-5 mt-4">Каталог</h1>

<div class="container">
    <div class="row">
        <?php
        $res = execute_r("SELECT id, name, subtitle, image_path, price FROM Products");

        $counter = 0;

        foreach ($res as $row) {
            if ($counter % 3 == 0) {
                echo "</div><div class='row'>";
            }

            echo "<div class='col-md-4'>";
            catalogueCardLanding($row['id'], $row['name'], $row['subtitle'], $row['image_path'], $row['price']);
            echo "</div>";
            $counter += 1;
        }
        echo str_repeat("<div class='col-md-4'></div>", (3 - ($counter % 3)));
        echo "</div>";

        ?>
    </div>
</div>

<br><br><br>

<h1 id="contacts" class="display-5 text-center mb-5 mt-4">Контакты</h1>

<div class="container">
    <div class="row d-flex justify-content-center align-items-start">
        <div class="col-6 text-center">
            <h1 style="font-size: 26px" class="fw-bold">Почта</h1>
            <a href="mailto:hq@maskarad.ru" style="font-size: 32px; color: #323232"
               class="fw-light">hq@maskarad.ru</a><br><br>
            <h1 style="font-size: 26px" class="fw-bold">Телефон</h1>
            <a href="tel:+79619512312" style="font-size: 32px; color: #323232" class="fw-light">+7 (961)
                951-23-12</a><br><br>
            <h1 style="font-size: 26px" class="fw-bold">Адрес</h1>
            <a href="https://yandex.ru/maps/213/moscow/house/pushkinskaya_ploshchad_5/Z04YcAdlTEwPQFtvfXt3d35jYw==/"
               style="font-size: 32px; color: #323232" class="fw-light">г. Москва, ул. Пушкинская площадь, д. 5</a>
        </div>
    </div>
</div>
<!-- MAIN -->

<!-- FOOTER -->

<?php printFooter(); ?>

<!-- FOOTER -->

<a id="cart_button" data-bs-toggle="modal" data-bs-target="#cartModal">
    <p id="cart_counter">0</p>
    <img id="cart_icon" src="/static/cart.svg" alt="cart-icon">
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
<?php yandex_metrika(); getProductsJsonScript();?>
<script src="/static/jquery-3.6.0.js"></script>
<script src="/static/landing.min.js"></script>
</body>
</html>
