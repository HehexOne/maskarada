<?php
require('db_connection.php');
require('utils.php');
?>
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
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Каталог</a></li>
                <li class="nav-item"><a class="nav-link" href="tracking.php">Отслеживание</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">Контакты</a></li>
            </ul>
            <ul class="pagination mt-3">
                <li class="page-item disabled">
                    <button id="cart_counter" class="page-link btn-primary" href=""><?php echo getCartCount(); ?></button>
                </li>
                <li class="page-item"><a class="page-link btn-success text-success" href="cart.php">Корзина</a></li>
                <li class="page-item"><a class="page-link btn-success" href="account.php">👤</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- HEADER -->

<!-- MAIN -->
<div id="promo-block" class="container py-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
        <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h1 style="color: #4f352d" class="display-5 fw-bold lh-1">MASKARADA</h1>
            <p class="lead">Онлайн-магазин всего на свете по лучшим ценам и с лучшими поставщиками, рекомендую,
                кстати</p>
        </div>
        <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg d-none d-lg-block">
            <img class="rounded-lg-3" src="https://neoils.com/wp-content/uploads/shutterstock_642569911-2048x1365.jpg"
                 alt="" width="720">
        </div>
    </div>
</div>

<h1 class="display-5 text-center mb-5 mt-4">Каталог</h1>

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
        catalogueCard($row['id'], $row['name'], $row['subtitle'], $row['image_path'], $row['price']);
        echo "</div>";
        $counter += 1;
    }
    echo str_repeat("<div class='col-md-4'></div>", (3 - ($counter % 3)));
    echo "</div>";

    ?>
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