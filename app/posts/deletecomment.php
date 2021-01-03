<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (isset($_POST['delete-comment'])) {
    deleteComment($database, $id, $userid);
}
redirect('/comments.php?id=' . $postid);
