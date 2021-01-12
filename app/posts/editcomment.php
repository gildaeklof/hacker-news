<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['edit-content'], $_POST['post-id'], $_POST['comment-id'])) {
    $content = filter_var($_POST['edit-content'], FILTER_SANITIZE_STRING);
    $userid = $_SESSION['user']['id'];
    $id = $_POST['comment-id'];
    $postid = $_POST['post-id'];

    editComment($database, $content, $id, $userid);
    $_SESSION['success'] = "Your comment was edited.";
}
redirect('/comments.php?id=' . $postid);
