<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php';

$id = $_SESSION['user']['id'];
$user = getUserId($database, $id);
?>
<?php if (isset($_SESSION['user'])) : ?>
    <h1><?= $user['username']; ?>'s profile</h1>
    <div class="card mb-3" style="max-width: 570px;">
        <div class="row g-0">
            <div class="col-md-4 avatar-img">
                <?php if (!$user['avatar']) : ?>
                    <img src="/app/users/uploads/default.jpg" alt="Profile picture">
                <?php else : ?>
                    <img src="/app/users/uploads/<?= $user['avatar']; ?>" alt="Profile picture">
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['username']; ?></h5>
                    <p class="card-text"><?= $user['bio']; ?></p>
                    <p class="card-text"><small class="text-muted"><?= $user['email']; ?></small></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<br>
<p class="error"><?php alert(); ?></p>
<form action="/app/users/updateprofile.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="avatar" class="form-label">Upload a new profile picture.</label>
        <input class="form-control" type="file" name="avatar" id="avatar" accept=".jpg, .jpeg, .png" required>
    </div>
    <button type="submit" class="btn btn-dark">Update profile picture</button>
</form>
<br>
<form action="/app/users/updateprofile.php" method="post">
    <div class="form-group">
        <label for="new-email">Change email</label>
        <input class="form-control" type="email" name="update-email" id="email" value="<?= $user['email']; ?>">
        <small class="form-text text-muted">Please provide a new email address.</small>
        <button type="submit" class="btn btn-dark">Update email</button>
    </div><!-- /form-group -->
</form>
<br>
<form action="/app/users/updateprofile.php" method="post">
    <div class="form-group">
        <label for="new-username">Change username</label>
        <input class="form-control" type="username" name="update-username" id="username" value="<?= $user['username']; ?>">
        <small class="form-text text-muted">Please choose a new username.</small>
        <button type="submit" class="btn btn-dark">Update username</button>
    </div>
</form>
<br>
<form action="/app/users/updateprofile.php" method="post">
    <div class="form-group">
        <label for="new-bio">Update bio</label>
        <textarea class="form-control" rows="3" name="update-bio" id="bio" value=""><?= $user['bio']; ?></textarea>
        <small class="form-text text-muted">Tell us something about yourself!</small>
        <button type="submit" class="btn btn-dark">Update bio</button>
    </div><!-- /form-group -->
</form>
<br>
<form action="/app/users/updateprofile.php" method="post">
    <div class="form-group">
        <label for="new-password-1">Change password</label>
        <input class="form-control" type="password" name="update-password-1" id="password-1">
        <small class="form-text text-muted">Please choose a new password.</small>
    </div><!-- /form-group -->

    <div class="form-group">
        <label for="new-password-2">Confirm your new password</label>
        <input class="form-control" type="password" name="update-password-2" id="password-2">
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