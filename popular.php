<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<main>
    <article>

        <h1><?php echo $config['title']; ?></h1>

        <?php if (isset($_SESSION['user'])) : ?>
            <h5>Welcome, <?php echo $_SESSION['user']['username']; ?>!</h5>
            <p class="success"><?php alert(); ?></p>
            <button value="unhide" class="btn btn-dark show-button">Create a new post</button>

            <form class="post-form formhidden" action="/app/posts/store.php" method="post">
                <button type="button" value="hide" class="btn btn-dark cancel-button">Cancel</button>
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
    </article>

<?php else : ?>
    <h5><a href="/login.php">Log in</a> for the best experience!</h5>
<?php endif; ?>

<article>

    <h2>Most upvoted posts</h2>
    <div class="order-by">
        <a class="order-link" href="/index.php">New posts</a>
        <p class="order-link">|</p>
        <a class="order-link" href="/popular.php">Most upvoted posts</a>
    </div>

    <?php
    $posts = mostUpvoted($database); ?>
    <?php foreach ($posts as $post) : ?>
        <div class="row most-upvoted-posts">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= $post['title']; ?></h4>
                        <h6 class="card-title-2"><?= $post['author']; ?></h6>
                        <p class="card-text"><?= $post['description']; ?></p>
                        <a class="post-link" href="<?= $post['link']; ?>" class="btn btn-dark"><?= sanitizeLink($post['link']); ?></a>
                        <small class="form-text text-muted"><?= $post['date']; ?></small>
                        <?php $upvotes = getUpvotes($database, $post['id']); ?>

                        <?php if (isset($_SESSION['user'])) : ?>
                            <form action="/app/posts/upvote.php" method="post">
                                <input type="hidden" name="upvote" id="post-id" value="<?= $post['id']; ?>"></input>
                                <?php if (!existUpvote($database, $post['id'], $_SESSION['user']['id'])) : ?>
                                    <button value="<?= $post['id']; ?>" type="submit" name="upvote" class="btn btn-primary btn-sm post-div-button">Upvote<span class="badge bg-secondary"><?= $upvotes; ?></span></button>
                                <?php else : ?>
                                    <button value="<?= $post['id']; ?>" type="submit" name="upvote" class="btn btn-primary btn-sm post-div-button">Remove upvote<span class="badge bg-secondary"><?= $upvotes; ?></span></button>
                                <?php endif; ?>
                            </form>

                        <?php else : ?>

                            <form action="/login.php" method="post">
                                <input type="hidden" name="upvote" id="post-id" value="<?= $post['id']; ?>"></input>
                                <button type="submit" class="btn btn-primary btn-sm post-div-button">Upvotes<span class="badge bg-secondary"><?= $upvotes; ?></span></button>
                            </form>

                        <?php endif; ?>

                        <?php $commentcount = getCommentCount($database, $post['id']); ?>
                        <a href="/comments.php?id=<?= $post['id'] ?>" class="btn btn-dark btn-sm post-div-button">Comments<span class="badge bg-secondary"><?= $commentcount; ?></span></a>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <?php if ($post['user_id'] === $_SESSION['user']['id']) : ?>
                                <form action="/app/posts/delete.php" method="post">
                                    <input type="hidden" id="delete-post" name="delete-post" value="<?= $post['id'] ?>"></input>
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm post-div-button">Delete post</button>
                                </form>

                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</article>
</main>

<?php require __DIR__ . '/sections/footer.php'; ?>