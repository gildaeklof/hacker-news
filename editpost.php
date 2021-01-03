<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php'; ?>

<?php $id = $_GET['id']; ?>
<main>
    <a href="/posts.php" class="btn btn-dark">Back</a>
    <?php if (isset($_SESSION['posts'])) : ?>
        <?php $post = getPostsById($database, $id); ?>
        <h4>Edit post<h4>
                <section>
                    <form action="/app/posts/update.php" method="post">
                        <div class="form-group">
                            <label for="update-title">Title</label>
                            <input class="form-control" type="title" name="update-title" id="update-title" value="<?= $post['title']; ?>">
                        </div><!-- /form-group -->
                        <div class="form-group">
                            <label for="update-link">Link</label>
                            <input class="form-control" type="link" name="update-link" id="update-link" value="<?= $post['link']; ?>">
                            <small class="form-text text-muted"></small>
                        </div><!-- /form-group -->
                        <div class="form-group">
                            <label for="update-description">Description</label>
                            <textarea rows="3" class="form-control" type="description" name="update-description" id="update-description"><?= $post['description']; ?></textarea>
                            <br>
                            <button name="update-post" type="submit" class="btn btn-dark">Update post</button>
                        </div><!-- /form-group -->
                    </form>
                </section>
            <?php endif; ?>
</main>

<?php require __DIR__ . '/sections/footer.php'; ?>