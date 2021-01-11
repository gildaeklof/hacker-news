<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php';

$id = $_SESSION['user']['id'];
$user = getUserId($database, $id);
?>
<?php if (isset($_SESSION['user'])) : ?>
    <h1><?= $user['username']; ?>'s profile</h1>
    <div class="card mb-3" style="max-width: 570px;">
        <div class="row g-0 center-mobile">
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
    <a href="/editprofile.php" class="btn btn-dark">Edit profile</a>
<?php endif; ?>

<?php if (isset($_SESSION['posts'], $_SESSION['user'])) : ?>
    <?php
    $userid = $_SESSION['user']['id'];
    $posts = getPostsByUser($database, $userid); ?>

    <article>
        <p class="error"><?php alert(); ?></p>
        <button value="unhide" class="btn btn-dark show-button">Create a new post</button>

        <form class="post-form formhidden" action="/app/posts/store.php" method="post">
            <button type="button" value="hide" class="btn btn-dark hide-button cancel-button">Cancel</button>
            <div class="form-group">
                <label for="new-title">Title</label>
                <input class="form-control" type="text" name="new-title" id="title" required>
                <small class="form-text text-muted">Add a title to your post.</small>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="new-url">Url</label>
                <input class="form-control" type="text" name="new-url" id="url" required>
                <small class="form-text text-muted">Add a url to your post.</small>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="new-description">Description</label>
                <textarea class="form-control" rows="3" name="new-description" id="description" required></textarea>
                <small class="form-text text-muted">Add a description to your post.</small>
            </div><!-- /form-group -->
            <button value="hide" type="submit" class="btn btn-dark hide-button">Create post</button>
        </form>

        <?php foreach ($posts as $post) : ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?= $post['title']; ?></h4>
                            <h6 class="card-title-2"><?= $post['author']; ?></h6>
                            <p class="card-text"><?= $post['description']; ?></p>
                            <a class="post-link" href="<?= $post['link']; ?>" class="btn btn-dark"><?= sanitizeLink($post['link']); ?></a>
                            <small class="form-text text-muted"><?= $post['date']; ?></small>

                            <form action="/editpost.php?id=<?= $post['id'] ?>" method="post">
                                <button type="submit" name="update" class="btn btn-dark btn-sm post-div-button">Edit post</button>
                            </form>

                            <form action="/app/posts/delete.php" method="post">
                                <input type="hidden" id="delete-post" name="delete-post" value="<?= $post['id'] ?>"></input>
                                <button type="submit" name="delete" class="btn btn-danger btn-sm post-div-button">Delete post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </article>
<?php else : ?>
    <h5>Please <a href="/login.php">log in</a> to see your posts.</h5>
<?php endif; ?>

<?php require __DIR__ . '/sections/footer.php'; ?>