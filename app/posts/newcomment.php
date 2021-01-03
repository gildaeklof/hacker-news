<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['comment'], $_POST['post-id'])) {
    $postid = filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT);
    $userid = $_SESSION['user']['id'];
    $content = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
    $author = $_SESSION['user']['username'];

    addComment($database, $userid, $postid, $content, $author);
    redirect('/comments.php?id=' . $postid);
}
