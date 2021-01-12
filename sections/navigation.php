<div class="topnav">

    <a class="nav-link" href="/index.php">Hacker News</a>

    <a class="icon">
        <i class="fa fa-bars"></i>
    </a>

    <a class="nav-link" href="/index.php">Home</a>

    <a class="nav-link" href="/about.php">About</a>

    <?php if (isset($_SESSION['user'])) : ?>
        <a class="nav-link" href="/app/users/logout.php">Logout</a>
    <?php else : ?>
        <a class="nav-link" href="/login.php">Login</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user'])) : ?>
        <a class="nav-link" href="/profile.php">Profile</a>
    <?php else : ?>
        <a class="nav-link" href="/login.php">Profile</a>
    <?php endif; ?>

</div>