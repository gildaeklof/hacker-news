<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['delete-post'])) {
    deletePost($database, $id, $userid);
    $_SESSION['errors'] = "Your post was deleted.";
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
