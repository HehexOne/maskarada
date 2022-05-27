<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maskarada</title>
    <link rel="shortcut icon" href="static/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="static/style.css">
</head>
<body class="is-flex is-justify-content-space-between is-flex-direction-column align-items-center">

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
                <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Каталог</a></li>
                <li class="nav-item"><a class="nav-link" href="tracking.php">Отслеживание</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">Контакты</a></li>
            </ul>
            <ul class="pagination mt-3">
                <li class="page-item disabled">
                    <button class="page-link btn-primary" href="">1</button>
                </li>
                <li class="page-item"><a class="page-link btn-success text-success" href="cart.php">Корзина</a></li>
                <li class="page-item"><a class="page-link btn-success" href="account.php">👤</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- HEADER -->


<!-- MAIN -->

<div style="margin-top: 150px"
     class="container is-flex is-flex-direction-column justify-content-center align-items-center">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h2 style="color: #5e3d34" class="card-title">Корзина</h2>
                    <hr>
                    <button class="btn btn-outline-danger">Очистить корзину</button>
                    <hr>
                    <div class="position-block is-flex is-flex-direction-row justify-content-start align-items-start">
                        <a style="text-decoration: none; color: #323232" href="product.php"><img class="tracking-image"
                                                                                                  src="static/store-lorem.png"></a>
                        <div class="tracking-position-info mt-2">
                            <a style="text-decoration: none; color: #323232" href="product.php"><h5>Маска для
                                волос</h5></a>
                            <p style="color:gray;">1999 руб.</p>
                            <ul class="pagination">
                                <li class="page-item">
                                    <button class="page-link btn-primary">+</button>
                                </li>
                                <li class="page-item disabled">
                                    <button class="page-link btn-primary">5</button>
                                </li>
                                <li class="page-item">
                                    <button class="page-link btn-primary">-</button>
                                </li>
                            </ul>
                            <p class="price-tag fw-light text-dark">9995 руб.</p>
                        </div>
                    </div>
                    <hr>
                    <h3 class="text-success">Итог: 9995 рублей</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h2 style="color: #5e3d34" class="card-title">Оформление заказа</h2>
                    <hr>
                    <form action="" method="post">
                        <label class="form-label" for="name">Имя получателя</label><br>
                        <input type="text" class="form-control" name="name" id="name">
                        <p class="form-text">Ввести следует имя человека, который будет получать заказ</p>
                        <label class="form-label" for="phone">Номер телефона</label><br>
                        <input type="text" class="form-control" name="phone" id="phone">
                        <p class="form-text">Телефон необходим для связи представителя магазина при подтверждении заказа, и курьера</p>
                        <label class="form-label" for="address">Адрес доставки</label><br>
                        <input type="text" class="form-control" name="address" id="address">
                        <p class="form-text">Проверьте адрес доставки. В случае ошибки, адрес можно будет поменять через поддержку.</p>
                        <label class="form-label" for="comment">Комментарий к заказу</label><br>
                        <input type="text" class="form-control" name="comment" id="comment">
                        <p class="form-text">Данный комментарий относится как к складским работникам, так и работникам
                            доставки</p>
                        <hr>
                        <p class="fw-light fst-italic small">Оформляя заказ, вы соглашаетесь с <a href="https://yandex.ru/support/marketplace/orders/dbs/requirements.php">правилами обработки заказов</a> и последующей <a href="https://yandex.ru/legal/taxi_corporate_delivery_terms/?lang=ru">доставкой товаров</a></p>
                        <button style="width: 100%" class="btn btn-success">Оформить заказ</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN -->


<!-- FOOTER -->

<?php printFooter(); ?>

<!-- FOOTER -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>
</html>