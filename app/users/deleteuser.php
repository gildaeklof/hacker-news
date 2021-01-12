<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST)) {
    $id = $_SESSION['user']['id'];
    deleteUser($database, $id);
    session_destroy();
    redirect('/index.php');
}
