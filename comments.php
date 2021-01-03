<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<?php $id = $_GET['id']; ?>

<main>
    <a href="/index.php" class="btn btn-dark">Back</a>
    <?php if (isset($_SESSION['posts'])) : ?>
        <?php $post = getPostsById($database, $id);
        $comments = getCommentsByPostId($database, $id); ?>
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
                        <div class="comment-section">
                            <?php foreach ($comments as $comment) : ?>
                                <article class="comments">
                                    <small class="form-text text-muted"><?= $comment['author']; ?> commented:</small>
                                    <p class="comment"><?= $comment['content']; ?> </p>
                                </article>
                                <?php if (isset($_SESSION['user'])) : ?>
                                    <?php if ($comment['user_id'] === $_SESSION['user']['id']) : ?>
                                        <form action="/app/posts/deletecomment.php" method="post">
                                            <input type="hidden" id="delete-comment" name="delete-comment" value="<?= $post['id'] ?>"></input>
                                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete comment</button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <form action="/app/posts/newcomment.php" method="post">
                            <textarea rows="2" class="form-control" type="comment" name="comment" id="comment"></textarea>
                            <input type="hidden" id="post-id" name="post-id" value="<?= $post['id'] ?>"></input>
                            <br>
                            <button type="submit" name="new-comment" class="btn btn-dark btn-sm">Add comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</main>