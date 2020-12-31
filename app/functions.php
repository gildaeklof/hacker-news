<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

//register functions
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

    //logs in user after registration
    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $user;
}

//update functions
//
//fetch user by id
function getUserId($database, $id)
{
    $query = 'SELECT * FROM users WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        return $user;
    } else {
        return [];
    }
}

//update email
function changeEmail($database, $id, $email)
{
    $query = 'UPDATE users SET email = :email WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//update bio
function changeBio($database, $id, $bio)
{
    $query = 'UPDATE users SET bio = :bio WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//update username
function changeUsername($database, $id, $username)
{
    $query = 'UPDATE users SET username = :username WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//update password
function changePassword($database, $id, $password)
{
    $query = 'UPDATE users SET password = :password WHERE id = :id';
    $statement = $database->prepare($query);

    $passwordEncrypt = password_hash($password, PASSWORD_BCRYPT);
    $statement->bindParam(':password', $passwordEncrypt, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//delete account
function deleteUser($database, $id)
{
    $id = $_SESSION['user']['id'];
    $query = 'DELETE FROM users WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//error function
function alert()
{
    if (isset($_SESSION['errors'])) {
        foreach ((array)$_SESSION['errors'] as $error) {
            echo $error;
            unset($_SESSION['errors']);
        }
    }
}
