<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['upvote'], $_SESSION['user']['id'])) {
    $postid = filter_var($_POST['upvote'], FILTER_SANITIZE_NUMBER_INT);
    $userid = $_SESSION['user']['id'];

    $query = 'SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id';
    $statement = $database->prepare($query);

    if (!$statement) {
        die(var_dump($database->errorinfo()));
    }

    $statement->bindParam(':post_id', $postid, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();

    $upvote = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$upvote) {
        upvotePost($database, $postid, $userid);
    } else {
        removeUpvote($database, $postid, $userid);
    }
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;

/* Returns the number of upvotes on the current post?:(
    $upvotes = countUpvotes($database, $postid);
    $upvotes = json_encode($upvotes);
    header('Content-Type: application/json');
    echo $upvotes;*/