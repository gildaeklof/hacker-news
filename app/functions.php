<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

function existEmail($database, $email)
{
    $emailQuery = 'SELECT * FROM users WHERE email= :email';
    $statement = $database->prepare($emailQuery);

    $statement->bindParam(':email', $email);
    $statement->execute();

    $emailExist = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['emailexist'] = $emailExist;

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
}

function existUsername($database, $username)
{
    $usernameQuery = 'SELECT * FROM users WHERE username= :username';
    $statement = $database->prepare($usernameQuery);

    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    $usernameExist = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['usernameexist'] = $usernameExist;

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
}

function regUser($database, $email, $username, $password, $bio)
{
    $query = 'INSERT INTO users (email, username, password, bio) VALUES (:email, :username, :password, :bio)';
    $statement = $database->prepare($query);

    $passwordEncrypt = password_hash($password, PASSWORD_BCRYPT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $passwordEncrypt, PDO::PARAM_STR);
    $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
    $statement->execute();
}

function alert()
{
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo $error;
        }
    }
}
