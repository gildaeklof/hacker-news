<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['comment_id'], $_POST['reply'])) {
    $comment_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);
    $userid = $_SESSION['user']['id'];
    $reply = filter_var($_POST['reply'], FILTER_SANITIZE_STRING);
    $author = $_SESSION['user']['username'];
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);



    addReply($database, $comment_id, $userid, $reply, $author);
    redirect('/comments.php?id=' . $post_id);
}
