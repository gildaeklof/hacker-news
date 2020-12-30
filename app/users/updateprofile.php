<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_SESSION['user']['id'];

if (isset($_POST)) {
    $currentEmail = $_SESSION['user']['email'];
}

if (isset($_POST['update-email'])) {
    $email = filter_var($_POST['update-email'], FILTER_SANITIZE_EMAIL);

    if ($currentEmail === $email) {
        $_SESSION['errors'] = "Please provide a new email address.";
        redirect('/profile.php');
    } else {
        changeEmail($database, $id, $email);
        $_SESSION['errors'] = "Your email was updated.";
        redirect('/profile.php');
    }
}

if (isset($_POST['update-bio'])) {
    $bio = filter_var($_POST['update-bio'], FILTER_SANITIZE_STRING);
    changeBio($database, $id, $bio);
    $_SESSION['errors'] = "Your bio was updated.";
    redirect('/profile.php');
}

if (isset($_POST['update-username'])) {
    $username = filter_var($_POST['update-username'], FILTER_SANITIZE_STRING);
    changeUsername($database, $id, $username);
    $_SESSION['errors'] = "Your username was updated.";
    redirect('/profile.php');
}
