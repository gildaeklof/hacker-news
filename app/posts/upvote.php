<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

header('Content-Type: application/json');

if (isset($_POST['upvote'])) {
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
        $voteCount = getUpvotes($database, $postid);
        $status = "upvote";
        $response = [
            'voteCount' => $voteCount,
            'status' => $status
        ];

        echo json_encode($response);
    } else {
        removeUpvote($database, $postid, $userid);
        $voteCount = getUpvotes($database, $postid);
        $status = "unvote";
        $response = [
            'voteCount' => $voteCount,
            'status' => $status
        ];
        echo json_encode($response);
    }
    /*$upvoteInt = getUpvotes($database, $postid);
    $upvotes = json_encode($upvoteInt);*/
}
