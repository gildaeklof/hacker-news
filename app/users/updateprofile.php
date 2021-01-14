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

    $accepted = ['image/jpeg', 'image/jpg', 'image/png'];

    if (!in_array($avatar['type'], $accepted)) {
        $_SESSION['errors'] = "The uploaded file type is not allowed.";
        redirect('/editprofile.php');
    }
    //error doesn't work
    if ($avatar['size'] > 2097152) {
        $_SESSION['errors'] = "The uploaded file exceeded the filesize limit.";
        redirect('/editprofile.php');
    }

    if (!$_SESSION['errors']) {
        $destination = __DIR__ . "/uploads/$username-$name";
        move_uploaded_file($avatar['tmp_name'], $destination);

        changeProfileImg($database, $id, $avatarname);
        $_SESSION['success'] = "The file was successfully uploaded!";
        redirect('/editprofile.php');
    }
}

//update email
if (isset($_POST['update-email'])) {
    $email = filter_var($_POST['update-email'], FILTER_SANITIZE_EMAIL);

    $_SESSION['update']['update-email'] = $email;

    existEmail($database, $email);
    if ($_SESSION['emailexist']['email'] === $email) {
        $_SESSION['errors'] = "The email is already registered.";
        unset($_SESSION['update']['update-email']);
        redirect('/editprofile.php');
    } else {
        changeEmail($database, $id, $email);
        $_SESSION['success'] = "Your email was updated.";
        unset($_SESSION['update']);
        redirect('/editprofile.php');
    }
}

//update username
if (isset($_POST['update-username'])) {
    $username = filter_var($_POST['update-username'], FILTER_SANITIZE_STRING);

    $_SESSION['update']['update-username'] = $username;

    existUsername($database, $username);
    if ($_SESSION['usernameexist']['username'] === $username) {
        $_SESSION['errors'] = "The username is taken.";
        unset($_SESSION['update']['update-username']);
        redirect('/editprofile.php');
    } else {
        changeUsername($database, $id, $username);
        $_SESSION['success'] = "Your username was updated.";
        unset($_SESSION['update']);
        redirect('/editprofile.php');
    }
}

//update bio
if (isset($_POST['update-bio'])) {
    $bio = filter_var($_POST['update-bio'], FILTER_SANITIZE_STRING);
    $_SESSION['update']['update-bio'] = $bio;
    if (strlen($bio) <= 250) {
        changeBio($database, $id, $bio);
        $_SESSION['success'] = "Your bio was updated.";
        redirect('/editprofile.php');
    } else {
        $_SESSION['errors'] = "Your bio can be a maximum of 250 characters.";
        redirect('/editprofile.php');
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

        redirect('/editprofile.php');
    }
    changePassword($database, $id, $password);
    $_SESSION['success'] = "Your password was updated";
    unset($_SESSION['update']);
    redirect('/editprofile.php');
}
