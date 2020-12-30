<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// Check if both email and password exists in the POST request.
if (isset($_POST['current-email'], $_POST['current-password'])) {
    $email = filter_var($_POST['current-email'], FILTER_SANITIZE_EMAIL);

    // Prepare, bind email parameter and execute the database query.
    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    // Fetch the user as an associative array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['login']['current-email'] = $email;
    $_SESSION['login']['current-password'] = $password;


    // If we couldn't find the user in the database, redirect back to the login
    // page with our custom redirect function.
    if (!$user) {
        $_SESSION['errors'] = "The email is not registered.";
        unset($_SESSION['login']['current-email']);
        redirect('/login.php');
    }

    // If we found the user in the database, compare the given password from the
    // request with the one in the database using the password_verify function.
    if (password_verify($_POST['current-password'], $user['password'])) {
        // If the password was valid we know that the user exists and provided
        // the correct password. We can now save the user in our session.
        // Remember to not save the password in the session!
        unset($user['password']);
        $_SESSION['user'] = $user;
    } else {
        $_SESSION['errors'] = "Incorrect password.";
        redirect('/login.php');
    }
}
unset($_SESSION['login']);

// We should put this redirect in the end of this file since we always want to
// redirect the user back from this file. We don't know
redirect('/index.php');
