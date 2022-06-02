<?php
require('db_connection.php');
require('utils.php');

login_required();

clearCart();

redirect('landing.php');
