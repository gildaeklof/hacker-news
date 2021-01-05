<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['edit-content'], $_POST['post-id'], $_POST['comment-id'])) {
    $content = filter_var($_POST['edit-content'], FILTER_SANITIZE_STRING);
    $userid = $_SESSION['user']['id'];
    $id = $_POST['comment-id'];

    editComment($database, $content, $id, $userid);
    $_SESSION['errors'] = "Your comment was edited.";
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
