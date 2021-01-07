<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<article>
    <h1>Login</h1>
    <p class="error"><?php alert(); ?></p>

    <form action="app/users/login.php" method="post">
        <div class="form-group">
            <label for="current-email">Email</label>
            <input class="form-control" type="email" name="current-email" id="email" placeholder="" value="<?php
                                                                                                            if (isset($_SESSION['login']['current-email'])) {
                                                                                                                echo $_SESSION['login']['current-email'];
                                                                                                                unset($_SESSION['login']['current-email']);
                                                                                                            }
                                                                                                            ?>" required>
            <small class="form-text text-muted">Please provide your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="current-password">Password</label>
            <input class="form-control" type="password" name="current-password" id="password" value="<?php
                                                                                                        if (isset($_SESSION['login']['current-password'])) {
                                                                                                            echo $_SESSION['login']['current-password'];
                                                                                                            unset($_SESSION['login']['current-password']);
                                                                                                        }
                                                                                                        ?>" required>
            <small class="form-text text-muted">Please provide your password.</small>
            <button type="submit" class="btn btn-dark post-div-button" name="login_user">Login</button>
        </div><!-- /form-group -->
    </form>

    <small class="form-text text-muted">Don't have an account?</small>
    <a class="btn btn-dark post-div-button" href="/newaccount.php" role="button">Create a new account</a>
</article>

<?php require __DIR__ . '/sections/footer.php'; ?>