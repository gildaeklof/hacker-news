<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php';

$id = $_SESSION['user']['id'];
$user = getUserId($database, $id);
?>
<?php if (isset($_SESSION['user'])) : ?>
    <article>
        <h1><?= $user['username']; ?>'s profile</h1>
        <br>
        <h5>Email: <br><?= $user['email']; ?></h5>
        <h5>Username: <br><?= $user['username']; ?></h5>
        <h5>Bio: <br><?= $user['bio']; ?></h5>
    <?php endif; ?>
    <br>
    <p class="error"><?php alert(); ?></p>
    <form action="/app/users/updateprofile.php" method="post">
        <div class="form-group">
            <label for="new-email">Change email</label>
            <input class="form-control" type="email" name="update-email" id="email" value="<?php
                                                                                            if (isset($_SESSION['update']['update-email'])) {
                                                                                                echo $_SESSION['update']['update-email'];
                                                                                                unset($_SESSION['update']['update-email']);
                                                                                            }
                                                                                            ?>">
            <small class="form-text text-muted">Please provide a new email address.</small>
            <button type="submit" class="btn btn-dark">Update email</button>
        </div><!-- /form-group -->
    </form>
    <br>
    <form action="/app/users/updateprofile.php" method="post">
        <div class="form-group">
            <label for="new-username">Change username</label>
            <input class="form-control" type="username" name="update-username" id="username" value="<?php
                                                                                                    if (isset($_SESSION['update']['update-username'])) {
                                                                                                        echo $_SESSION['update']['update-username'];
                                                                                                        unset($_SESSION['update']['update-username']);
                                                                                                    }
                                                                                                    ?>">
            <small class="form-text text-muted">Please choose a new username.</small>
            <button type="submit" class="btn btn-dark">Update username</button>
        </div>
    </form>
    <br>
    <form action="/app/users/updateprofile.php" method="post">
        <div class="form-group">
            <label for="new-bio">Update bio</label>
            <textarea class="form-control" rows="3" name="update-bio" id="bio" value="<?php
                                                                                        if (isset($_SESSION['update']['update-bio'])) {
                                                                                            echo $_SESSION['update']['update-bio'];
                                                                                            unset($_SESSION['update']['update-bio']);
                                                                                        }
                                                                                        ?>"></textarea>
            <small class="form-text text-muted">Tell us something about yourself!</small>
            <button type="submit" class="btn btn-dark">Update bio</button>
        </div><!-- /form-group -->
    </form>
    <br>
    <form action="/app/users/updateprofile.php" method="post">
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
    <br>
    <h4>DANGER ZONE</h4>
    <form action="/app/users/deleteuser.php" method="post">
        <div class="form-group">
            <label for="delete-user">Delete account</label>
            <small class="form-text text-muted">Are you sure you want to delete your account? There's no going back from this.</small>
            <button type="submit" class="btn btn-danger">Delete account</button>
        </div><!-- /form-group -->
    </form>
    </article>
    <?php require __DIR__ . '/sections/footer.php'; ?>