<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<?php if (isset($_SESSION['user'])) : ?>
    <?php $userid = $_SESSION['user']['id'];
    $posts = getPostsByUser($database, $userid); ?>
    <article>
        <?php foreach ($posts as $post) : ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?= $post['title']; ?></h4>
                            <h6 class="card-title-2"><?= $post['author']; ?></h6>
                            <p class="card-text"><?= $post['description']; ?></p>
                            <a href="<?= $post['link']; ?>" class="btn btn-dark"><?= $post['link']; ?></a>
                            <small class="form-text text-muted"><?= $post['date']; ?></small>
                            <form action="/app/posts/delete.php" method="post">
                                <input type="hidden" id="delete-post" name="delete-post" value="<?= $post['id'] ?>"></input>
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete post</button>
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