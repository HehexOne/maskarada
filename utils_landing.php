<?php
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

function catalogueCardLanding($id, $name, $subtitle, $image_path, $price): void
{
    echo "<div class='catalogue-card card'>
                <a style='text-decoration: none; color: #323232; cursor: pointer;' onclick='openProductModal($id);'>
                    <div class='card-image-wrapper d-flex justify-content-center align-items-center'>
                        <img class='card-image' src='$image_path'>
                    </div>
                    <div class='card-body'>
                        <h5 class='card-title'>$name</h5>
                        <h6 class='card-subtitle mb-2 text-muted'>$subtitle</h6>
                        <p class='price-tag fw-light card-text'>$price руб.</p>
                </a><br>
                <a onclick='addToCart($id)' id='addToCart-$id' class='btn btn-success'>Добавить в корзину</a>
            </div>
        </div>";
}

function getProductsJsonScript(): void
{
    echo "<script> let products = {";
    $res = execute_r("SELECT id, name, subtitle, image_path, price, description FROM Products");

    foreach ($res as $row) {
        $id = $row['id'];
        $name = $row['name'];
        $subtitle = $row['subtitle'];
        $image_path = $row['image_path'];
        $price = $row['price'];
        $description = $row['description'];

        echo "$id : {'id': $id, 'name': `$name`, 'subtitle': `$subtitle`, 'image_path': `$image_path`, 'price': $price, 'description': `$description`},";
    }

    echo "}; </script>";
}
