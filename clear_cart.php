<?php
require('db_connection.php');
require('utils.php');

login_required();

$uid = $_SESSION['user_id'];

execute("DELETE ProductInCart FROM ProductInCart INNER JOIN UserCart UC on ProductInCart.cart_id = UC.id WHERE user_id=$uid;");

redirect('cart.php');
