<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<?php $id = $_GET['id'];
$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
} ?>

<main>
    <a href="<?= $previous ?>" class="btn btn-dark">Back</a>
    <?php if (isset($_SESSION['posts'])) : ?>
        <?php $post = getPostsById($database, $id);
        $comments = getCommentsByPostId($database, $id); ?>
        <p class="error"><?php alert(); ?></p>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= $post['title']; ?></h4>
                        <h6 class="card-title-2"><?= $post['author']; ?></h6>
                        <p class="card-text"><?= $post['description']; ?></p>
                        <a class="post-link" href="<?= $post['link']; ?>" class="btn btn-dark"><?= $post['link']; ?></a>
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

                            <?php else : ?>

                                <form action="/login.php" method="post">
                                    <input type="hidden" name="upvote" id="post-id" value="<?= $post['id']; ?>"></input>
                                    <button type="submit" class="btn btn-primary btn-sm post-div-button">Upvotes<span class="badge bg-secondary"><?= $upvotes; ?></span></button>
                                </form>

                            <?php endif; ?>

                            <div class="comment-section">
                                <h6>Comments</h6>
                                <?php foreach ($comments as $comment) : ?>
                                    <div class="comment-section">
                                        <small class="form-text text-muted"><?= $comment['author']; ?> commented:</small>
                                        <p class="comment"><?= $comment['content']; ?> </p>
                                    </div>

                                    <?php if (isset($_SESSION['user'])) : ?>
                                        <?php if ($comment['user_id'] === $_SESSION['user']['id']) : ?>
                                            <form action="/app/posts/editcomment.php" method="post">
                                                <textarea rows="2" class="form-control" type="comment" name="edit-content" id="edit-content"><?= $comment['content']; ?></textarea>
                                                <input type="hidden" id="comment-id" name="comment-id" value="<?= $comment['id']; ?>"></input>
                                                <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>
                                                <button type="submit" name="edit-comment" class="btn btn-dark btn-sm post-div-button">Save changes</button>
                                            </form>
                                            <form action="/app/posts/deletecomment.php" method="post">
                                                <input type="hidden" id="delete-comment" name="delete-comment" value="<?= $comment['id'] ?>"></input>
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm post-div-button">Delete comment</button>
                                            </form>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <?php if (isset($_SESSION['user'])) : ?>
                                <form action="/app/posts/newcomment.php" method="post">
                                    <textarea rows="2" class="form-control" type="comment" name="comment" id="comment"></textarea>
                                    <input type="hidden" id="post-id" name="post-id" value="<?= $post['id'] ?>"></input>
                                    <button type="submit" name="new-comment" class="btn btn-dark btn-sm comment-button">Add comment</button>
                                </form>

                            <?php else : ?>
                                <a href="/login.php">Log in to upvote and add comments!</a>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</main>