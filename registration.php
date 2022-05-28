<?php
require('db_connection.php');
require('utils.php');

unauthorized_required();

if (isset($_POST['mail']) && isset($_POST['pswd']) && isset($_POST['pswdrpt'])) {
    $mail = $_POST['mail'];
    $pswd = $_POST['pswd'];
    $pswdrpt = $_POST['pswdrpt'];

    if ($pswd != $pswdrpt) {
        redirect('register.php?error=1');
    }

    $pswd_hash = hash("sha256", $pswd);
    try {
        $query = "INSERT INTO Users(email, password_hash) VALUES ('$mail', '$pswd_hash')";
        execute($query);
        $res = execute_r("SELECT id FROM Users WHERE email='$mail'");
        if ($res) {
            $uid = $res[0]['id'];
            $_SESSION['user_id'] = $uid;
            execute("INSERT INTO UserCart(user_id) VALUES ($uid)");
            redirect('index.php');
        } else {
            redirect('register.php?error=1');
        }
    } catch (Exception $e) {
        redirect('register.php?error=1');
    }
}
