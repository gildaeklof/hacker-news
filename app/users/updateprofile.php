<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_SESSION['user']['id'];
$user = getUserId($database, $id);

//upload avatar
if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    $name = $avatar['name'];
    $username = $user['username'];
    $avatarname = "$username-$name";

    if (!in_array($avatar['type'], ['image/jpeg', 'image/png'])) {
        $_SESSION['errors'] = "The uploaded file type is not allowed.";
    }

    if ($avatar['size'] > 2097152) {
        $_SESSION['errors'] = "The uploaded file exceeded the filesize limit.";
    }

    if (!$_SESSION['errors']) {
        $destination = __DIR__ . "/uploads/$username-$name";
        move_uploaded_file($avatar['tmp_name'], $destination);

        changeProfileImg($database, $id, $avatarname);
        $_SESSION['errors'] = "The file was successfully uploaded!";
        redirect('/profile.php');
    }
}

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
    } else {
        changeEmail($database, $id, $email);
        $_SESSION['errors'] = "Your email was updated.";
        unset($_SESSION['update']);
        redirect('/profile.php');
    }
}

//update username
if (isset($_POST['update-username'])) {
    $username = filter_var($_POST['update-username'], FILTER_SANITIZE_STRING);

    $_SESSION['errors'] = [];
    $_SESSION['update']['update-username'] = $username;

    existUsername($database, $username);
    if ($_SESSION['usernameexist']['username'] === $username) {

        $_SESSION['errors'] = "The username is taken.";
        unset($_SESSION['update']['update-username']);
        redirect('/profile.php');
    } else {
        changeUsername($database, $id, $username);
        $_SESSION['errors'] = "Your username was updated.";
        unset($_SESSION['update']);
        redirect('/profile.php');
    }
}

//update bio
if (isset($_POST['update-bio'])) {
    $bio = filter_var($_POST['update-bio'], FILTER_SANITIZE_STRING);
    $_SESSION['update']['update-bio'] = $bio;
    if (strlen($bio) <= 250) {
        changeBio($database, $id, $bio);
        $_SESSION['errors'] = "Your bio was updated.";
        redirect('/profile.php');
    } else {
        $_SESSION['errors'] = "Your bio can be a maximum of 250 characters.";
        redirect('/profile.php');
    }
}

//update password
if (isset($_POST['update-password-1'], $_POST['update-password-2'])) {
    $password = $_POST['update-password-1'];
    $passwordConf = $_POST['update-password-2'];

    $_SESSION['update']['update-password-1'] = $password;
    $_SESSION['update']['update-password-2'] = $passwordConf;

    if ($password !== $passwordConf) {
        $_SESSION['errors'] = "The passwords do not match.";
        unset($_SESSION['update']['update-password-1'], $_SESSION['update']['update-password-2']);

        redirect('/profile.php');
    }
    changePassword($database, $id, $password);
    $_SESSION['errors'] = "Your password was updated";
    unset($_SESSION['update']);
    redirect('/profile.php');
}
