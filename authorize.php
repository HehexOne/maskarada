<?php
require('db_connection.php');
require('utils.php');

unauthorized_required();

if (isset($_POST['mail']) && isset($_POST['pswd'])) {
    $mail = $_POST['mail'];
    $pswd = $_POST['pswd'];
    $pswd = hash("sha256", $pswd);
    try {
        $query = "SELECT id FROM Users WHERE email='$mail' AND password_hash='$pswd' LIMIT 1";
        $res = execute_r($query);
        if ($res) {
            $_SESSION['user_id'] = $res[0]['id'];
            redirect('index.php');
        } else {
            redirect('login.php?error=1');
        }
    } catch (Exception $e) {
        redirect('login.php?error=1');
    }
}

