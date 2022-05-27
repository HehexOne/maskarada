<?php
function redirect($url): void
{
    header("Location: $url");
}

function login_required(): void
{
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

function unauthorized_required(): void
{
    if (isset($_SESSION['user_id'])) {
        redirect('index.php');
    }
}