<?php
require('db_connection_landing.php');

if (isset($_POST['text'])) {
    $data = json_decode($_POST['text'], true);
    $name = $data['name'];
    $phone = $data['phone'];
    $address = $data['address'];
    $comm = $data['comm'];
    $cart = $data['cart'];

    execute("INSERT INTO shop_db_landing.Orders(receiver_name, receiver_phone, receiver_address, comments) VALUES ('$name', '$phone', '$address', '$comm')");
    $order_id = execute_r("SELECT LAST_INSERT_ID() as `id`;")[0]['id'];

    $cart = preg_split("/;/", $cart);

    foreach ($cart as $cart_pair) {
        $pair = preg_split("/:/", $cart_pair);
        if (count($pair) == 2) {
            execute("INSERT INTO shop_db_landing.ProductInOrder(order_id, product_id, quantity) VALUES ($order_id, $pair[0], $pair[1]);");
        }
    }

    echo $order_id;
} else {
    echo '0';
}