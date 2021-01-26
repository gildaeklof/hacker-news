<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

//print_r($_SESSION);

if (isset($_POST['upvote'])) {

    $comment_id = $_POST['commentid'];
    $postid = $_POST['post_id'];

    $userid = $_SESSION['user']['id'];

    $statement = $database->prepare('SELECT * FROM comment_upvote WHERE user_id = :userid AND comment_id = :comment_id');
    $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
    $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    $statement->execute();

    $likes = $statement->fetch(PDO::FETCH_ASSOC);

    if (empty($likes)) {

        $statement = $database->prepare('INSERT INTO comment_upvote (user_id, comment_id) VALUES (:userid, :comment_id)');

    }else {

        $statement = $database->prepare('DELETE FROM comment_upvote WHERE user_id = :userid AND comment_id = :comment_id');

    }

    $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
    $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);

    $statement->execute();

    redirect('/../comments.php?id=' . $postid);
}

