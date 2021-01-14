<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>
<?php alerts(); ?>

<article>
    <h1>Login</h1>

    <form action="app/users/login.php" method="post">
        <div class="form-group">
            <label for="current-email">Email</label>
            <input class="form-control" type="email" name="current-email" id="email" value="<?= loginSession(); ?>" required>
            <small class="form-text">Please provide your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="current-password">Password</label>
            <input class="form-control" type="password" name="current-password" id="password" value="<?= loginSession(); ?>" required>
            <small class="form-text">Please provide your password.</small>
            <button type="submit" class="btn btn-dark post-div-button" name="login_user">Login</button>
        </div><!-- /form-group -->
    </form>

    <small class="form-text">Don't have an account?</small>
    <a class="btn btn-dark post-div-button" href="/newaccount.php" role="button">Create a new account</a>
</article>

<?php require __DIR__ . '/sections/footer.php'; ?>