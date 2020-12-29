<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<article>
    <h1>Your profile</h1>
    <br>
    <?php if (isset($_SESSION['user'])) : ?>
        <h5>Email: <br><?php echo $_SESSION['user']['email']; ?></h5>
        <h5>Username: <br><?php echo $_SESSION['user']['username']; ?></h5>
        <h5>Bio: <br><?php echo $_SESSION['user']['bio']; ?></h5>

        <form action="/app/users/updateprofile.php" method="post">
            <div class="form-group">
                <label for="new-email">Change email</label>
                <input class="form-control" type="email" name="new-email" id="email" placeholder="" required>
                <small class="form-text text-muted">Please provide a new email address.</small>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="new-username">Change username</label>
                <input class="form-control" type="username" name="new-username" id="username" placeholder="" required>
                <small class="form-text text-muted">Please choose a new username.</small>
            </div>
            <div class="form-group">
                <label for="new-password-1">Change password</label>
                <input class="form-control" type="password" name="new-password-1" id="password" required>
                <small class="form-text text-muted">Please choose a password.</small>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="new-password-2">Confirm your new password</label>
                <input class="form-control" type="password" name="new-password-2" id="password" required>
                <small class="form-text text-muted">Please confirm your new password.</small>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="new-bio">Update bio</label>
                <input class="form-control" type="text" name="new-bio" id="bio" required>
            </div><!-- /form-group -->
            <button type="submit" class="btn btn-dark">Update account</button>

        </form>
</article>
<?php endif; ?>

<?php require __DIR__ . '/sections/footer.php'; ?>