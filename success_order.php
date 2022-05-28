<?php
require('db_connection.php');
require('utils.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
} else {
    redirect('account.php');
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
<body id="login-body" style="min-height: 100vh">

<div class="container d-flex justify-content-center align-items-center flex-column">
    <a href="index.php">
        <div class="card-image-wrapper d-flex justify-content-center align-items-center">
            <img style="width: 90%; max-width: 250px" src="static/logo-header.png">
        </div>
    </a>
    <h3 class="text-center text-success">Успешный заказ!</h3>
    <p class="fw-light small fst-italic">Заказ #<?php echo $order_id; ?></p>
    <p class="text-center">В ближайшее время наш менеджер свяжется с вами для подтверждения заказа</p>
    <a class="btn btn-success" href="account.php">Вернуться в личный кабинет</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>
</html>
