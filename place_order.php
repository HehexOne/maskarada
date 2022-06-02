<?php
require('db_connection.php');
require('utils.php');

if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address'])) {
    $comm = "";
    if (isset($_POST['comment'])) {
        $comm = $_POST['comment'];
    }

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($name && $phone && $address) {
        $uid = $_SESSION['user_id'];

        $query = "INSERT INTO Orders(user_id, receiver_name, receiver_phone, receiver_address, comments) VALUES ($uid, '$name', '$phone', '$address', '$comm')";
        execute($query);

        $order_id = execute_r("SELECT MAX(id) as `id` FROM Orders WHERE user_id=$uid")[0]['id'];

        $res = getProductsInCart();

        foreach ($res as $row) {
            $product_id = $row['id'];
            $q = $row['quantity'];
            execute("INSERT INTO ProductInOrder(order_id, product_id, quantity) VALUES ($order_id, $product_id, $q)");
        }

        clearCart();
        redirect("success_order.php?order_id=$order_id");
    } else {
        redirect('landing.php?error=1');
    }
    exit();
}

redirect('landing.php?error=1');