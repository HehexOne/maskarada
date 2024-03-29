<?php
require('db_connection.php');
require('utils.php');

unauthorized_required();
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
    <link rel="stylesheet" href="static/style.css">
</head>
<body id="login-body" style="min-height: 100vh">

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <a href="index.php">
                <div class="card-image-wrapper">
                    <img style="width: 100%" src="static/logo-header.png">
                </div>
            </a>
            <h2 class="mt-3">Вход</h2>
            <p class="fw-light fst-italic small">Чтобы продолжить, необходимо авторизироваться</p><br>
            <?php
            if (isset($_GET['error'])) {
                echo "<div class='alert alert-danger'>Проверьте правильность введённых данных</div>";
            }
            ?>
            <form action="authorize.php" method="post">
                <label class="form-label" for="mail">Почта</label><br>
                <input class="form-control" name="mail" id="mail" minlength="8" maxlength="64" type="email" required><br>
                <label class="form-label" for="pswd">Пароль</label><br>
                <input class="form-control" name="pswd" id="pswd" minlength="8" maxlength="32" type="password" required><br>
                <button style="width: 100%" class="btn btn-success mt-3">Войти</button>
                <a href="register.php" style="width: 100%" class="btn btn-outline-success mt-2">Создать аккаунт</a>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
<?php yandex_metrika();?>
</body>
</html>