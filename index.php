<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>
<?php alerts(); ?>

<main>
    <article>

        <h1 class="display-2"><?php echo $config['title']; ?></h1>

        <?php if (isset($_SESSION['user'])) : ?>
            <h2>Welcome, <?php echo $_SESSION['user']['username']; ?>!</h2>
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
                    <input class="form-control" type="url" name="new-url" id="url" required>
                    <small class="form-text text-muted">Add a url to your post.</small>
                </div><!-- /form-group -->

                <div class="form-group">
                    <label for="new-description">Description</label>
                    <textarea class="form-control" rows="3" name="new-description" id="description"></textarea>
                    <small class="form-text text-muted">Add a description to your post.</small>
                </div><!-- /form-group -->
                <button value="hide" type="submit" class="btn btn-dark hide-button">Create post</button>
            </form>
        <?php else : ?>
            <h5><a class="login-link" href="/login.php">Log in</a> for the best experience!</h5>
        <?php endif; ?>
    </article>


    <article class="new-posts-page">

        <h2>New posts</h2>
        <div class="order-by">
            <a class="order-link" href="/index.php">New posts</a>
            <p class="order-link">|</p>
            <a class="order-link" href="/popular.php">Most upvoted posts</a>
        </div>

        <?php $posts = getNewPosts($database); ?>
        <?php foreach ($posts as $post) : ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body shadow-sm bg-white rounded">
                            <h4 class="card-title"><?= $post['title']; ?></h4>
                            <h6 class="card-title-2"><?= $post['author']; ?></h6>
                            <p class="card-text"><?= $post['description']; ?></p>
                            <a class="post-link" href="<?= $post['link']; ?>"><?= sanitizeLink($post['link']); ?></a>
                            <small class="form-text text-muted"><?= $post['date']; ?></small>
                            <span>Upvotes: </span>
                            <span class="vote-number" data-id="<?= $post['id']; ?>"><?= getUpvotes($database, $post['id']) ?></span>

                            <?php if (isset($_SESSION['user'])) : ?>
                                <form class="upvote" action="/app/posts/upvote.php" method="post">
                                    <input type="hidden" name="upvote" id="post-id" value="<?= $post['id']; ?>"></input>
                                    <?php if (!existUpvote($database, $post['id'], $_SESSION['user']['id'])) : ?>
                                        <button style="background-color: grey;" value="submit" type="submit" class="upvote-button" data-id="<?= $post['id']; ?>"></button>
                                    <?php else : ?>
                                        <button style="background-color: cornflowerblue;" value="submit" type="submit" class="upvote-button" data-id="<?= $post['id']; ?>"></button>
                                    <?php endif; ?>
                                </form>
                            <?php else : ?>
                                <form action="/login.php" method="post">
                                    <input type="hidden" name="upvote" id="post-id" value="<?= $post['id']; ?>"></input>
                                    <button style="background-color: grey;" value="submit" type="submit" class="upvote-button" data-id="<?= $post['id']; ?>"></button>
                                </form>

                            <?php endif; ?>

                            <?php $commentcount = getCommentCount($database, $post['id']); ?>
                            <a href="/comments.php?id=<?= $post['id'] ?>" class="btn btn-dark btn-sm post-div-button">Comments <span class="badge bg-light text-dark"><?= $commentcount; ?></span></a>
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