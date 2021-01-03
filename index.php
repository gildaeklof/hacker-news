<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php';
?>
<main>
    <article>
        <h1><?php echo $config['title']; ?></h1>
        <?php if (isset($_SESSION['user'])) : ?>
            <h5>Welcome, <?php echo $_SESSION['user']['username']; ?>!</h5>
        <?php else : ?>
            <h5><a href="/login.php">Log in</a> for the best experience!</h5>
        <?php endif; ?>

        <?php if (isset($_SESSION['user'])) : ?>
            <h3>Create a new post</h3>
            <form action="/app/posts/store.php" method="post">
                <div class="form-group">
                    <label for="new-title">Title</label>
                    <input class="form-control" type="text" name="new-title" id="title">
                    <small class="form-text text-muted">Add a title to your post.</small>
                </div><!-- /form-group -->

                <div class="form-group">
                    <label for="new-url">Url</label>
                    <input class="form-control" type="text" name="new-url" id="url">
                    <small class="form-text text-muted">Add a url to your post.</small>
                </div><!-- /form-group -->

                <div class="form-group">
                    <label for="new-description">Description</label>
                    <textarea class="form-control" rows="3" name="new-description" id="description"></textarea>
                    <small class="form-text text-muted">Add a description to your post.</small>
                </div><!-- /form-group -->
                <button type="submit" class="btn btn-dark">Create post</button>
            </form>
    </article>
<?php endif; ?>
<article>
    <h2>New posts</h2>
    <?php
    $posts = getNewPosts($database); ?>
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
                        <button type="button" class="btn btn-primary">
                            Upvote <span class="badge badge-light">3</span>
                        </button>
                        <a href="/comments.php?id=<?= $post['id'] ?>" class="btn btn-dark">Comments</a>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <?php if ($post['user_id'] === $_SESSION['user']['id']) : ?>
                                <form action="/app/posts/delete.php" method="post">
                                    <input type="hidden" id="delete-post" name="delete-post" value="<?= $post['id'] ?>"></input>
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete post</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</article>


<?php require __DIR__ . '/sections/footer.php'; ?>