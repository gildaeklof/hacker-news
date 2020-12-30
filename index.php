<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/sections/header.php';
//$id = $_SESSION['user']['id'];
//$user = getUserId($database, $id);
?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <h5>Welcome, <?php echo $_SESSION['user']['username']; ?>!</h5>
    <?php else : ?>
        <h5>Log in for the best experience!</h5>
    <?php endif; ?>

    <p>Check it out.</p>
</article>

<?php require __DIR__ . '/sections/footer.php'; ?>