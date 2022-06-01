<?php
require('utils.php');

login_required();

$_SESSION['user_id'] = null;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maskarad</title>
    <link rel="shortcut icon" href="static/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="static/style.css">
</head>
<body id="login-body" style="min-height: 100vh">

<div class="container">
    <div class="card-image-wrapper d-flex justify-content-center align-items-center">
        <img style="width: 90%; max-width: 300px" src="static/logo-header.png">
    </div>
    <h1 style="color: #5e3d34" class="text-center">Производится выход...</h1>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
<script>
    setTimeout(()=>{
        window.location.href = 'index.php';
    }, 2000);
</script>
</body>
</html>
