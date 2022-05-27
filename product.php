<?php
require('db_connection.php');
require('utils.php');

if (!isset($_GET['id'])) {
    redirect('index.php');
    exit();
}

$product_id = $_GET['id'];

try {
    $res = execute_r("SELECT * FROM Products WHERE id=$product_id")[0];
} catch (Exception $e) {
    redirect('index.php');
    exit();
}
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
                <img style="max-height: 400px; width: auto" src="<?php echo $res['image_path']; ?>">
            </div>
        </div>
        <div class="col">
            <div class="card mb-5">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $res['name']; ?></h2>
                    <p class="card-subtitle"><?php echo $res['subtitle']; ?></p>
                    <hr>
                    <p class="card-text"><?php echo $res['description']; ?></p>
                    <hr>
                    <p style="font-size: 35px" class="price-tag fw-light card-text"><?php echo $res['price']; ?> рублей</p>
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

<?php printFooter(); ?>

<!-- FOOTER -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>
</html>