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

function catalogueCard($id, $name, $subtitle, $image_path, $price): void
{
    echo "<div product-id='$id' class='catalogue-card card'>
                <a style='text-decoration: none; color: #323232' href='product.php?id=$id'>
                    <div class='card-image-wrapper d-flex justify-content-center align-items-center'>
                        <img class='card-image' src='$image_path'>
                    </div>
                    <div class='card-body'>
                        <h5 class='card-title'>$name</h5>
                        <h6 class='card-subtitle mb-2 text-muted'>$subtitle</h6>
                        <p class='price-tag fw-light card-text'>$price руб.</p>
                </a><br>
                <button class='btn btn-success'>Добавить в корзину</button>
                <ul class='pagination mt-3'>
                    <li class='page-item'>
                        <button class='page-link btn-primary' href=''>+</button>
                    </li>
                    <li class='page-item disabled'>
                        <button class='page-link btn-primary' href=''>1</button>
                    </li>
                    <li class='page-item'>
                        <button class='page-link btn-primary' href=''>-</button>
                    </li>
                </ul>
            </div>
        </div>";
}


function printFooter(): void
{
    echo '<div class="container">
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Обратная связь</a></li>
<li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Поставщикам</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Вакансии</a></li>
        </ul>
        <p class="text-center text-muted">© 2022 MASKARADA</p>
    </footer>
</div>';
}