<?php
require('db_connection.php');
require('utils.php');

login_required();

$uid = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    redirect('index.php');
    exit();
}

$product_id = $_GET['id'];

if (!is_numeric($product_id)) {
    redirect('index.php');
}

try {
    $res = execute_r("SELECT * FROM Products WHERE id=$product_id")[0];
} catch (Exception $e) {
    redirect('index.php');
    exit();
}

if (isset($_POST['command'])) {
    $cmd = $_POST['command'];
    if ($cmd == 'add_to_cart') {
        if (isset($_POST['quantity']) && is_numeric($_POST['quantity'])) {
            $qnt = $_POST['quantity'];
            execute("INSERT INTO ProductInCart(cart_id, product_id, quantity) VALUES ((SELECT id FROM UserCart WHERE user_id=$uid LIMIT 1), $product_id, $qnt);");
        }
    } else if ($cmd == 'delete_from_cart') {
        execute("DELETE ProductInCart FROM ProductInCart WHERE product_id=$product_id AND cart_id=(SELECT id FROM UserCart WHERE user_id=$uid LIMIT 1);");
    }
}

$cart_count = getCartCount();
$product_in_cart = getQuantity($product_id);

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
                    <button id="cart_counter" class="page-link btn-primary" href=""><?php echo $cart_count ?></button>
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
                    <p style="font-size: 35px" class="price-tag fw-light card-text"><?php echo $res['price']; ?>
                        рублей</p>
                    <?php
                    if ($product_in_cart == 0) {
                        ?>
                        <form action="" method="post">
                            <input type="hidden" name="command" id="command" value="add_to_cart">
                            <button type="submit" class="btn btn-success">Добавить в корзину</button>
                            <ul id="quantity-selector" class="pagination mt-3">
                                <li class="page-item">
                                    <a onclick="decrementValue();" class="page-link btn-primary">-</a>
                                </li>
                                <li class="page-item disabled">
                                    <input id="quantity" name="quantity" style="width: 60px; text-align: center"
                                           type="number"
                                           min="1" max="10" class="page-link btn-primary" value="1">
                                </li>
                                <li class="page-item">
                                    <a onclick="incrementValue();" class="page-link btn-primary">+</a>
                                </li>
                            </ul>
                        </form>
                    <?php } else { ?>
                        <form action="" method="post">
                            <input type="hidden" name="command" id="command" value="delete_from_cart">
                            <button type="submit" class="btn btn-outline-danger">Удалить из корзины</button>
                            <ul id="quantity-selector" class="pagination mt-3">
                                <li class="page-item disabled">
                                    <a onclick="decrementValue();" class="page-link btn-primary">-</a>
                                </li>
                                <li class="page-item disabled">
                                    <input id="quantity" name="quantity" style="width: 60px; text-align: center"
                                           type="number" class="page-link btn-primary"
                                           value="<?php echo $product_in_cart ?>">
                                </li>
                                <li class="page-item disabled">
                                    <a onclick="incrementValue();" class="page-link btn-primary">+</a>
                                </li>
                            </ul>
                        </form>
                    <?php } ?>
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
<script>
    function incrementValue() {
        let value = parseInt(document.getElementById('quantity').value);
        value = isNaN(value) ? 1 : value;
        value++;
        if (value > 10) {
            value = 10;
        } else if (value < 1) {
            value = 1;
        }
        document.getElementById('quantity').value = value;
    }

    function decrementValue() {
        let value = parseInt(document.getElementById('quantity').value);
        value = isNaN(value) ? 1 : value;
        value--;
        if (value > 10) {
            value = 10;
        } else if (value < 1) {
            value = 1;
        }
        document.getElementById('quantity').value = value;
    }
</script>
<?php yandex_metrika();?>
</body>
</html>