<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<article>
    <h1>Create a new account</h1>
    <!--remove errors somehow? and somehow display appropriately-->
    <div>
        <?php if (isset($_SESSION['errors'])) : ?>
            <p class="error"> <?php alert();
                                unset($_SESSION['errors']); ?></p>
        <?php endif; ?>
    </div>

    <form action="/app/users/register.php" method="post">
        <div class="form-group">
            <label for="new-email">Email</label>
            <input class="form-control" type="email" name="new-email" id="email" placeholder="" value="<?php
                                                                                                        if (isset($_SESSION['register']['new-email'])) {
                                                                                                            echo $_SESSION['register']['new-email'];
                                                                                                            unset($_SESSION['register']['new-email']);
                                                                                                        }
                                                                                                        ?>" required>
            <small class="form-text text-muted">Please provide an email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="new-username">Username</label>
            <input class="form-control" type="username" name="new-username" id="username" placeholder="" value="<?php
                                                                                                                if (isset($_SESSION['register']['new-username'])) {
                                                                                                                    echo $_SESSION['register']['new-username'];
                                                                                                                    unset($_SESSION['register']['new-username']);
                                                                                                                }
                                                                                                                ?>" required>
            <small class="form-text text-muted">Please choose a username.</small>
        </div>
        <div class="form-group">
            <label for="new-password-1">Password</label>
            <input class="form-control" type="password" name="new-password-1" id="password" value="<?php
                                                                                                    if (isset($_SESSION['register']['new-password-1'])) {
                                                                                                        echo $_SESSION['register']['new-password-1'];
                                                                                                        unset($_SESSION['register']['new-password-1']);
                                                                                                    }
                                                                                                    ?>" required>
            <small class="form-text text-muted">Please choose a password.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="new-password-2">Confirm your password</label>
            <input class="form-control" type="password" name="new-password-2" id="password" value="<?php
                                                                                                    if (isset($_SESSION['register']['new-password-2'])) {
                                                                                                        echo $_SESSION['register']['new-password-2'];
                                                                                                        unset($_SESSION['register']['new-password-2']);
                                                                                                    }
                                                                                                    ?>" required>
            <small class="form-text text-muted">Please confirm your password.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="new-bio">Biography</label>
            <input class="form-control" type="text" name="new-bio" id="bio" value="<?php
                                                                                    if (isset($_SESSION['register']['new-bio'])) {
                                                                                        echo $_SESSION['register']['new-bio'];
                                                                                        unset($_SESSION['register']['new-bio']);
                                                                                    }
                                                                                    ?>">
            <small class="form-text text-muted">Tell us something about yourself! You can update your bio later.</small>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-dark">Create account</button>

    </form>
</article>

<?php require __DIR__ . '/sections/footer.php'; ?>