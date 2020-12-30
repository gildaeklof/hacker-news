<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php';

$id = $_SESSION['user']['id'];
$user = getUserId($database, $id);
?>

<article>
    <h1>Your profile</h1>
    <br>
    <?php if (isset($_SESSION['user'])) : ?>
        <h5>Email: <br><?php echo $user['email']; ?></h5>
        <h5>Username: <br><?php echo $user['username']; ?></h5>
        <h5>Bio: <br><?php echo $user['bio']; ?></h5>
    <?php endif; ?>
    <br>
    <p class="success"><?php alert(); ?></p>
    <form action="/app/users/updateprofile.php" method="post">
        <div class="form-group">
            <label for="new-email">Change email</label>
            <input class="form-control" type="email" name="update-email" id="email" placeholder="">
            <small class="form-text text-muted">Please provide a new email address.</small>
            <button type="submit" class="btn btn-dark">Update email</button>
        </div><!-- /form-group -->
    </form>
    <br>
    <form action="/app/users/updateprofile.php" method="post">
        <div class="form-group">
            <label for="new-username">Change username</label>
            <input class="form-control" type="username" name="update-username" id="username" placeholder="">
            <small class="form-text text-muted">Please choose a new username.</small>
            <button type="submit" class="btn btn-dark">Update username</button>
        </div>
    </form>
    <br>
    <form action="/app/users/updateprofile.php" method="post">
        <div class="form-group">
            <label for="new-bio">Update bio</label>
            <input class="form-control" type="text" name="update-bio" id="bio">
            <small class="form-text text-muted">Tell us something about yourself!</small>
            <button type="submit" class="btn btn-dark">Update bio</button>
        </div><!-- /form-group -->
    </form>
    <br>
    <form action="/app/users/updatepassword.php" method="post">
        <div class="form-group">
            <label for="new-password-1">Change password</label>
            <input class="form-control" type="password" name="update-password-1" id="password">
            <small class="form-text text-muted">Please choose a password.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="new-password-2">Confirm your new password</label>
            <input class="form-control" type="password" name="update-password-2" id="password">
            <small class="form-text text-muted">Please confirm your new password.</small>
            <button type="submit" class="btn btn-dark">Update password</button>
        </div><!-- /form-group -->
    </form>
</article>
<?php require __DIR__ . '/sections/footer.php'; ?>