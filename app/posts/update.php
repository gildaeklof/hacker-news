<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['update-post'])) {
    $id = $_SESSION['posts']['id'];
    $userid = $_SESSION['user']['id'];
    $title = filter_var($_POST['update-title'], FILTER_SANITIZE_STRING);
    $link = filter_var($_POST['update-link'], FILTER_SANITIZE_URL);
    $description = filter_var($_POST['update-description'], FILTER_SANITIZE_STRING);

    updatePost($database, $id, $userid, $title, $link, $description);
    $_SESSION['success'] = "Your post was updated.";
    redirect('/profile.php');
}
