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
<div style="margin-top: 140px" class="container">
    <div style="flex-wrap: wrap-reverse" class="row">
        <div class="col">
            <div class="card-image-wrapper d-flex justify-content-center align-items-center">
                <img style="max-height: 400px; width: auto" src="static/store-lorem.png">
            </div>
        </div>
        <div class="col">
            <div class="card mb-5">
                <div class="card-body">
                    <h2 class="card-title">Lador маска для волос</h2>
                    <p class="card-subtitle">Для сухих и ломких волос</p>
                    <hr>
                    <p class="card-text">Восстанавливающая маска Lador Hydro LPP Treatment в объеме 150 мл.
                        предназначена для сухих и поврежденных волос. Оказывает укрепляющий эффект от корней до
                        кончиков. В состав маски входит широкий ассортимент питательных веществ для здоровья кожи и
                        волос. Средство содержит оптимальный баланс кислотности ph 5.5, улучшает состояние волос и кожи
                        головы, уменьшает ломкость, предотвращает появления перхоти и секущихся кончиков. Благодаря
                        коллагену и аминокислотному комплексу LPP волосы становятся более ровными, упругими, гладкими и
                        блестящими.</p>
                    <hr>
                    <p style="font-size: 35px" class="price-tag fw-light card-text">1999 рублей</p>
                    <button class="btn btn-success">Добавить в корзину</button>
                    <ul class="pagination mt-3">
                        <li class="page-item">
                            <button class="page-link btn-primary" href="">+</button>
                        </li>
                        <li class="page-item disabled">
                            <button class="page-link btn-primary" href="">1</button>
                        </li>
                        <li class="page-item">
                            <button class="page-link btn-primary" href="">-</button>
                        </li>
                    </ul>
                </div>
            </div>
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