<?php
require('db_connection_landing.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $order_id = $_GET['id'];

    $order_res = execute_r("SELECT Orders.id,
       date,
       receiver_name    as `name`,
       receiver_phone   as `phone`,
       receiver_address as `address`,
       comments         as `comm`,
       OS.name          as `status`,
       SUM(P.price * PIO.quantity) as `final_price`
FROM shop_db_landing.Orders
         INNER JOIN shop_db_landing.OrderStatus OS on Orders.status_id = OS.id
         INNER JOIN shop_db_landing.ProductInOrder PIO on Orders.id = PIO.order_id
         INNER JOIN shop_db_landing.Products P on PIO.product_id = P.id
WHERE Orders.id = $order_id GROUP BY Orders.id;");

    if ($order_res) {
        $order_res = $order_res[0];
        ?>
        <div class='alert alert-success'><?php echo $order_res['status']; ?></div>
        <hr>
        <p>Имя получателя: <?php echo $order_res['name']; ?></p>
        <p>Телефон получателя: <?php echo $order_res['phone']; ?></p>
        <p>Адрес доставки: <?php echo $order_res['address']; ?></p>
        <p>Дата заказа: <?php echo $order_res['date']; ?></p>
        <p>Комментарий: <?php echo $order_res['comm']; ?></p>
        <hr>
        <?php

        $res = execute_r("SELECT P.id                    as `id`,
       P.name                  as `name`,
       P.image_path            as `image_path`,
       P.price                 as `price`,
       ProductInOrder.quantity as `quantity`,
       P.price * ProductInOrder.quantity as `full_price`
FROM shop_db_landing.ProductInOrder
         INNER JOIN shop_db_landing.Products P on ProductInOrder.product_id = P.id
WHERE order_id = $order_id;");

        if (!$res) {
            echo '<div id="tracking_error" class="alert alert-warning">Технические проблемы с выводом товаров для данного заказа...</div>';
            return;
        }

        foreach ($res as $row) {
            ?>
            <div class="position-block is-flex is-flex-direction-row justify-content-start align-items-start">
                <img class="tracking-image" src="<?php echo $row['image_path']; ?>">
                <div class="tracking-position-info mt-2">
                    <h5><?php echo $row['name']; ?></h5>
                    <p style="color:gray;">(<?php echo $row['quantity']; ?> штук(а) | <?php echo $row['price']; ?> руб.)</p>
                    <p class="price-tag fw-light text-dark"><?php echo $row['full_price']; ?> руб.</p>
                </div>
            </div>
            <hr>
        <?php } ?>
        <h3>Итог: <?php echo $order_res['final_price']; ?> рублей</h3>
        <?php

    } else {
        echo '<div id="tracking_error" class="alert alert-danger">Такого заказа не существует!</div>';
    }
} else {
    echo '<div id="tracking_error" class="alert alert-danger">Неверный номер заказа!</div>';
}