<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<?php $id = $_GET['id'];
alerts(); ?>

<main>
    <?php if (isset($_SESSION['posts'])) : ?>
        <?php $post = getPostsById($database, $id);
        $comments = getCommentsByPostId($database, $id); ?>
        <a class="btn btn-dark back-button" href="/index.php">Back to new posts</a><a class="btn btn-dark back-button" href="/popular.php">Back to most upvoted</a>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body shadow-sm bg-white rounded">
                        <h4 class="card-title"><?= $post['title']; ?></h4>
                        <h6 class="card-title-2"><?= $post['author']; ?></h6>
                        <p class="card-text"><?= $post['description']; ?></p>
                        <a class="post-link" href="<?= $post['link']; ?>" class="btn btn-dark"><?= sanitizeLink($post['link']); ?></a>
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

                        <div class="comment-section">
                            <h6 class="comment-h6">Comments:</h6>
                            <?php foreach ($comments as $comment) : ?>
                                <div class="comment-section alert alert-secondary">
                                    <small class="form-text text-muted"><?= $comment['author']; ?> commented:</small>
                                    <p class="comment"><?= $comment['content']; ?> </p>
                                </div>

                                <!-- Emils changes   Upvote -->
                                <form action="/app/posts/commentupvote.php" method="post">
                                    <input type="hidden" name="commentid" value="<?= $comment['id']; ?>"></input>
                                    <input type="hidden" name="post_id" value="<?= $post['id']; ?>"></input>

                                    <?php

                                    $statement = $database->prepare('SELECT * FROM comment_upvote WHERE user_id = :userid AND comment_id = :comment_id');
                                    $statement->bindParam(':userid', $_SESSION['user']['id'], PDO::PARAM_INT);
                                    $statement->bindParam(':comment_id', $comment['id'], PDO::PARAM_INT);
                                    $statement->execute();

                                    $likes = $statement->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php if (empty($likes)) : ?>

                                        <button style="background-color: grey;" name="upvote" value="submit" type="submit">Like comment</button>

                                    <?php else : ?>
                                        <button style="background-color: green;" name="upvote" value="submit" type="submit">Like comment</button>

                                    <?php endif; ?>
                                </form>


                                <!-- Emils changes with comment reply -->
                                <?php $commentreply = getCommentReplyByCommentId($database, $comment['id']); ?>

                                <?php foreach ($commentreply as $reply) : ?>
                                    <div class="comment-section">
                                        <small class="form-text text-muted"><?= $reply['author']; ?> replied:</small>
                                        <p class="comment"><?= $reply['comment_reply']; ?> </p>
                                    </div>
                                <?php endforeach; ?>

                                <?php if (isset($_SESSION['user'])) : ?>
                                    <form action="/app/posts/newreply.php" method="post">
                                        <textarea rows="2" class="form-control col-6" name="reply"></textarea>
                                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>"></input>
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>"></input>

                                        <button type="submit" name="new-reply" class="btn btn-dark btn-sm comment-button">Add reply</button>
                                    </form>

                                <?php else : ?>
                                    <a class="login-link" href="/login.php">Log in to upvote and add comments!</a>
                                <?php endif; ?>


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
                            <?php if (!$comments) : ?>
                                <small class="text-muted">No comments yet...</small>
                            <?php endif; ?>
                        </div>

                        <?php if (isset($_SESSION['user'])) : ?>
                            <form action="/app/posts/newcomment.php" method="post">
                                <textarea rows="2" class="form-control" type="comment" name="comment" id="comment"></textarea>
                                <input type="hidden" id="post-id" name="post-id" value="<?= $post['id'] ?>"></input>
                                <button type="submit" name="new-comment" class="btn btn-dark btn-sm comment-button">Add comment</button>
                            </form>

                        <?php else : ?>
                            <a class="login-link" href="/login.php">Log in to upvote and add comments!</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</main>

<?php require __DIR__ . '/sections/footer.php'; ?>