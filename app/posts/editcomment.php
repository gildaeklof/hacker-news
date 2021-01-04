<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['edit-content'])) {
    $content = filter_var($_POST['edit-content'], FILTER_SANITIZE_STRING);
    $id = $_POST['comment']['id'];
    $userid = $_SESSION['user']['id'];
}
