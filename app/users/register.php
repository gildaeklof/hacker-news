<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['new-email'], $_POST['new-username'], $_POST['new-password-1'], $_POST['new-password-2'], $_POST['new-bio'])) {
    // Need to add eroor messages if stuff already exists
    $email = filter_var($_POST['new-email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['new-username'], FILTER_SANITIZE_STRING);
    //can't encrypt password here, then they won't match. will have to add it in functions.php
    $password = $_POST['new-password-1'];
    $passwordConf = $_POST['new-password-2'];
    $bio = $_POST['new-bio'];


    $_SESSION['register']['new-email'] = $email;
    $_SESSION['register']['new-username'] = $username;
    $_SESSION['register']['new-password-1'] = $password;
    $_SESSION['register']['new-password-2'] = $passwordConf;
    $_SESSION['register']['new-bio'] = $bio;

    existEmail($database, $email);
    if ($_SESSION['emailexist']['email'] === $email) {

        $_SESSION['errors'] = "The email is already registered.";
        unset($_SESSION['register']['new-email']);
        redirect('/../newaccount.php');
    }

    existUsername($database, $username);
    if ($_SESSION['usernameexist']['username'] === $username) {

        $_SESSION['errors'] = "The username is taken.";
        unset($_SESSION['register']['new-username']);
        redirect('/../newaccount.php');
    }

    if ($password !== $passwordConf) {
        $_SESSION['errors'] = "The passwords do not match.";
        unset($_SESSION['register']['new-password-1'], $_SESSION['register']['new-password-2']);

        redirect('/../newaccount.php');
    }

    regUser($database, $email, $username, $password, $bio);
    unset($_SESSION['register']);
}

redirect('/index.php');
