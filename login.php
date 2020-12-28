<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<article>
    <h1>Login</h1>

    <form action="app/users/login.php" method="post">
        <div class="form-group">
            <label for="current-email">Email</label>
            <input class="form-control" type="email" name="current-email" id="email" placeholder="" required>
            <small class="form-text text-muted">Please provide the your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="current-password">Password</label>
            <input class="form-control" type="password" name="current-password" id="password" required>
            <small class="form-text text-muted">Please provide your password.</small>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-dark" name="login_user">Login</button>
        <small class="form-text text-muted">Don't have an account?</small>
        <a class="btn btn-dark" href="/newaccount.php" role="button">Create a new account</a>
    </form>
</article>

<?php require __DIR__ . '/sections/footer.php'; ?>