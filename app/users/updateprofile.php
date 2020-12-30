<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_SESSION['user']['id'];
$user = getUserId($database, $id);

//update email
if (isset($_POST['update-email'])) {
    $email = filter_var($_POST['update-email'], FILTER_SANITIZE_EMAIL);

    $_SESSION['errors'] = [];
    $_SESSION['update']['update-email'] = $email;

    existEmail($database, $email);
    if ($_SESSION['emailexist']['email'] === $email) {

        $_SESSION['errors'] = "The email is already registered.";
        unset($_SESSION['update']['update-email']);
        redirect('/profile.php');
    }
    changeEmail($database, $id, $email);
    $_SESSION['errors'] = "Your email was updated.";
    unset($_SESSION['update']);
}

//update username
if (isset($_POST['update-username'])) {
    $username = filter_var($_POST['update-username'], FILTER_SANITIZE_EMAIL);

    $_SESSION['errors'] = [];
    $_SESSION['update']['update-username'] = $username;

    existUsername($database, $username);
    if ($_SESSION['usernameexist']['username'] === $username) {

        $_SESSION['errors'] = "The username is taken.";
        unset($_SESSION['update']['update-username']);
        redirect('/profile.php');
    }
    changeUsername($database, $id, $username);
    $_SESSION['errors'] = "Your username was updated.";
    unset($_SESSION['update']);
}

//update bio
if (isset($_POST['update-bio'])) {
    $bio = filter_var($_POST['update-bio'], FILTER_SANITIZE_STRING);
    changeBio($database, $id, $bio);
    $_SESSION['errors'] = "Your bio was updated.";
    redirect('/profile.php');
}

redirect('/profile.php');
