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
<body class="is-flex is-justify-content-space-between is-flex-direction-column">

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
<h1 style="margin-top: 150px" class="display-5 text-center mb-5">Личный кабинет</h1>

<div class="container mb-5">
    <div class="card">
        <div class="card-body">
            <h3 style="color: #5e3d34" class="card-title">alice-wonderland@mail.ru</h3>
            <p class="card-subtitle text-success">Регистрация: 2022-03-04 10:14:23</p>
            <a class="btn btn-outline-danger mt-3" href="/logout">Выход из аккаунта</a>
            <hr>
            <h4 class="mb-5">Ваши заказы</h4>
            <a class="lk-order-link" href="#">
                <div>
                    <h5>🗒 Заказ #322332</h5>
                    <p>ℹ Дата: 2022-03-04 12:10:01 | Итог: 9995 рублей</p>
                </div>
                <div class="d-none d-lg-block d-md-block">
                    <p class="display-6">➜</p>
                </div>
            </a>
            <hr style="opacity: 0.15">
        </div>
    </div>
</div>
<!-- MAIN -->

<!-- FOOTER -->

<div class="container">
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Обратная связь</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Поставщикам</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Вакансии</a></li>
        </ul>
        <p class="text-center text-muted">© 2022 MASKARADA</p>
    </footer>
</div>

<!-- FOOTER -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>
</html>