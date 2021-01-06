<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['current-email'], $_POST['current-password'])) {
    $email = filter_var($_POST['current-email'], FILTER_SANITIZE_EMAIL);

    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['login']['current-email'] = $email;
    $_SESSION['login']['current-password'] = $password;

    if (!$user) {
        $_SESSION['errors'] = "The email is not registered.";
        unset($_SESSION['login']['current-email']);
        redirect('/login.php');
    }

    if (password_verify($_POST['current-password'], $user['password'])) {
        unset($user['password']);
        $_SESSION['user'] = $user;
    } else {
        $_SESSION['errors'] = "Incorrect password.";
        redirect('/login.php');
    }
}
unset($_SESSION['login']);
redirect('/index.php');
