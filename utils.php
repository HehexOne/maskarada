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
        <p class="text-center text-muted">© 2022 MASKARAD</p>
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


function updateCartLastModified(): void
{
    $uid = $_SESSION['user_id'];
    execute("UPDATE UserCart SET last_modified=NOW() WHERE user_id=$uid;");
}

function getProductsInCart(): bool|array
{
    $uid = $_SESSION['user_id'];
    $query = "SELECT P.id as `id`,
       P.name as `name`,
       P.price as `price`,
       ProductInCart.quantity as `quantity`,
       P.image_path as `image_path`,
       (P.price * ProductInCart.quantity) as `final_price`
FROM ProductInCart
         INNER JOIN UserCart UC on ProductInCart.cart_id = UC.id
         INNER JOIN Products P on ProductInCart.product_id = P.id
WHERE UC.user_id = $uid;";
    return execute_r($query);
}

function getCartPrice()
{
    $uid = $_SESSION['user_id'];
    $query = "SELECT SUM(P.price * ProductInCart.quantity) as `final_price`
FROM ProductInCart
         INNER JOIN UserCart UC on ProductInCart.cart_id = UC.id
         INNER JOIN Products P on ProductInCart.product_id = P.id
WHERE UC.user_id = $uid;";

    updateCartLastModified();

    $res = execute_r($query)[0]['final_price'];
    if ($res) {
        return $res;
    } else {
        return 0;
    }
}

function clearCart(): void
{
    $uid = $_SESSION['user_id'];
    execute("DELETE ProductInCart FROM ProductInCart INNER JOIN UserCart UC on ProductInCart.cart_id = UC.id WHERE user_id=$uid;");
    updateCartLastModified();
}

function getAccountOrders(): bool|array
{
    $uid = $_SESSION['user_id'];
    $query = "SELECT Orders.id as `id`, Orders.date as `date`, SUM(PIO.quantity * P.price) as `price` FROM Orders
                INNER JOIN ProductInOrder PIO on Orders.id = PIO.order_id
                INNER JOIN Products P on PIO.product_id = P.id
WHERE user_id=$uid GROUP BY Orders.id, Orders.date ORDER BY date DESC;";

    return execute_r($query);
}

function getOrderInfo($order_id)
{
    $query = "SELECT Orders.id as `id`,
       Orders.date as `date`,
       receiver_name as `name`,
       receiver_phone as `phone`,
       receiver_address as `address`,
       comments as `comm`,
       OS.name as `status`,
       SUM(PIO.quantity * P.price) as `full_price`
FROM Orders
         INNER JOIN ProductInOrder PIO on Orders.id = PIO.order_id
         INNER JOIN Products P on PIO.product_id = P.id
    INNER JOIN OrderStatus OS on Orders.status_id = OS.id
WHERE Orders.id=$order_id GROUP BY Orders.id;";

    return execute_r($query)[0];
}

function getOrderProducts($order_id)
{
    $query = "SELECT P.id as `id`, image_path, name, quantity, price, price * quantity as `full_price`
FROM ProductInOrder
         INNER JOIN Products P on ProductInOrder.product_id = P.id
WHERE order_id=$order_id;";
    return execute_r($query);
}

function getUserIDbyOrderID($order_id)
{
    $query = "SELECT user_id FROM Orders WHERE id=$order_id";
    return execute_r($query)[0]['user_id'];
}

function yandex_metrika(): void
{
    echo '<!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(88943110, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/88943110" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->';
}
