<?php
function redirect($url): void
{
    header("Location: $url");
}

function login_required(): void
{
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

function unauthorized_required(): void
{
    if (isset($_SESSION['user_id'])) {
        redirect('index.php');
    }
}

function catalogueCard($id, $name, $subtitle, $image_path, $price): void
{
    echo "<div class='catalogue-card card'>
                <a style='text-decoration: none; color: #323232' href='product.php?id=$id'>
                    <div class='card-image-wrapper d-flex justify-content-center align-items-center'>
                        <img class='card-image' src='$image_path'>
                    </div>
                    <div class='card-body'>
                        <h5 class='card-title'>$name</h5>
                        <h6 class='card-subtitle mb-2 text-muted'>$subtitle</h6>
                        <p class='price-tag fw-light card-text'>$price руб.</p>
                </a><br>";
    if (!isset($_SESSION['user_id'])) {
        echo "<a href='product.php?id=$id' class='btn btn-success'>Добавить в корзину</a>";
    } else {
        $qnt = getQuantity($id);
        if ($qnt != 0) {
            echo "<a href='product.php?id=$id' class='btn btn-outline-danger'>Удалить из корзины</a>";
        } else {
            echo "<a href='product.php?id=$id' class='btn btn-success'>Добавить в корзину</a>";
        }
    }
    echo "
            </div>
        </div>";
}


function printFooter(): void
{
    echo '<div class="container">
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Обратная связь</a></li>
<li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Поставщикам</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Вакансии</a></li>
        </ul>
        <p class="text-center text-muted">© 2022 MASKARADA</p>
    </footer>
</div>';
}


function getCartCount()
{
    if (!isset($_SESSION['user_id'])) {
        return 0;
    }
    $uid = $_SESSION['user_id'];
    $cart_count = execute_r("SELECT SUM(quantity) as `cart_sum` FROM ProductInCart
    INNER JOIN UserCart UC on ProductInCart.cart_id = UC.id
WHERE UC.user_id = $uid;")[0]['cart_sum'];

    if (!$cart_count) {
        $cart_count = 0;
    }

    updateCartLastModified();

    return $cart_count;
}

function getQuantity($product_id)
{
    $uid = $_SESSION['user_id'];
    $res = execute_r("SELECT quantity FROM ProductInCart
         INNER JOIN UserCart UC on ProductInCart.cart_id = UC.id
WHERE UC.user_id = $uid AND product_id = $product_id;");
    updateCartLastModified();
    if ($res) {
        return $res[0]['quantity'];
    } else {
        return 0;
    }
}


function updateCartLastModified()
{
    $uid = $_SESSION['user_id'];
    execute("UPDATE UserCart SET last_modified=NOW() WHERE user_id=$uid;");
}