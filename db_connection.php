<?php
try {
    $pdo = new PDO('mysql:host=rc1b-0v39lyyjg25sy9l1.mdb.yandexcloud.net;dbname=shop_db',
        'manager',
        '1234567890',
        array(
            PDO::MYSQL_ATTR_SSL_CA => 'database/CA.pem'
        ));
} catch (PDOException $e) {
    echo "<h3 style='color: red'>Не удалось подключиться к базе!</h3>";
    exit();
}


function execute_r($query)
{
    global $pdo;
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll();
}

function execute($query)
{
    global $pdo;
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $stmt->fetch();
}