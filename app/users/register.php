<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['new-email'], $_POST['new-username'], $_POST['new-password-1'], $_POST['new-password-2'])) {
    // Need to add eroor messages if stuff already exists
    $email = filter_var($_POST['new-email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['new-username'], FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['new-password-1'], PASSWORD_BCRYPT);
    $passwordConf = $_POST['new-password-1'];

    $query = 'INSERT INTO users (email, username, password) VALUES (:email, :username, :password)';
    $statement = $database->prepare($query);

    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->execute();
}
redirect('/login.php');
