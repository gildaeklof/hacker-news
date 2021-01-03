<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

//register functions
function existEmail($database, $email)
{
    $emailQuery = 'SELECT * FROM users WHERE email= :email';
    $statement = $database->prepare($emailQuery);

    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $emailExist = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['emailexist'] = $emailExist;

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
}

function existUsername($database, $username)
{
    $usernameQuery = 'SELECT * FROM users WHERE username= :username';
    $statement = $database->prepare($usernameQuery);

    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    $usernameExist = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['usernameexist'] = $usernameExist;

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
}

function regUser($database, $email, $username, $password, $bio)
{
    $query = 'INSERT INTO users (email, username, password, bio) VALUES (:email, :username, :password, :bio)';
    $statement = $database->prepare($query);

    $passwordEncrypt = password_hash($password, PASSWORD_BCRYPT);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $passwordEncrypt, PDO::PARAM_STR);
    $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
    $statement->execute();

    //logs in user after registration
    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $user;
}

//update functions
//
//fetch user by id
function getUserId($database, $id)
{
    $query = 'SELECT * FROM users WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        return $user;
    } else {
        return [];
    }
}

//update email
function changeEmail($database, $id, $email)
{
    $query = 'UPDATE users SET email = :email WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//update bio
function changeBio($database, $id, $bio)
{
    $query = 'UPDATE users SET bio = :bio WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//update username
function changeUsername($database, $id, $username)
{
    $query = 'UPDATE users SET username = :username WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//update password
function changePassword($database, $id, $password)
{
    $query = 'UPDATE users SET password = :password WHERE id = :id';
    $statement = $database->prepare($query);

    $passwordEncrypt = password_hash($password, PASSWORD_BCRYPT);
    $statement->bindParam(':password', $passwordEncrypt, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//post functions
//
//create post
function createPost($database, $userid, $title, $link, $description, $date, $author)
{
    $query = 'INSERT INTO posts (user_id, title, link, description, date, author) VALUES (:user_id, :title, :link, :description, :date, :author)';
    $statement = $database->prepare($query);

    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':link', $link, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':date', $date, PDO::PARAM_STR);
    $statement->bindParam(':author', $author, PDO::PARAM_STR);
    $statement->execute();
}

//get new posts
//order by date doesn't work?
function getNewPosts($database): array
{
    $query = 'SELECT * FROM posts ORDER BY id DESC';
    $statement = $database->prepare($query);

    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['posts'] = $posts;
    return $_SESSION['posts'];
}

//get posts by user
function getPostsByUser($database, $userid): array
{
    $query = 'SELECT * FROM posts WHERE user_id = :user_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$posts) {
        $_SESSION['errors'] = "You haven't posted anything yet.";
    }
    return $posts;
}

//get posts by id
function getPostsById($database, $id): array
{
    $query = 'SELECT * FROM posts WHERE id = :id';
    $statement = $database->prepare($query);

    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $posts = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['posts'] = $posts;
    return $_SESSION['posts'];
}

//edit post
function updatePost($database, $id, $userid, $title, $link, $description)
{
    $query = 'UPDATE posts SET title = :title, link = :link, description = :description WHERE id = :id AND user_id = :user_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':link', $link, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();
}

/*checks if like exists
function existUpvote($database, $id, $userid)
{
    $id = $_SESSION['posts']['id'];
    $userid = $_SESSION['user']['id'];

    $query = 'SELECT * FROM upvotes WHERE id = :id AND user_id = :user_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);

    $upvote = $statement->fetch(PDO::FETCH_ASSOC);

    if ($upvote) {
        return true;
    } else {
        return false;
    }
}

//get number of upvotes
function getUpvotes($database, $id)
{
    $id = $_SESSION['posts']['id'];
    $query = 'SELECT COUNT(*) FROM upvotes WHERE post_id = :post_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $upvotes = $statement->fetch(PDO::FETCH_ASSOC);
    return $upvotes['COUNT(*)'];
}*/

//delete post
function deletePost($database, $id, $userid)
{
    $id = $_POST['delete-post'];
    $userid = $_SESSION['user']['id'];
    $query = 'DELETE FROM posts WHERE id = :id AND user_id = :user_id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();
}

//comment functions
//
//get comments from post
function getCommentsByPostId($database, $id): array
{
    $query = 'SELECT * FROM comments WHERE post_id = :post_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($comments === false) {
        $comments = [];
    }
    return $comments;
}

//new comment
function addComment($database, $userid, $postid, $content, $author)
{
    $query = 'INSERT INTO comments (user_id, post_id, content, author) VALUES (:user_id, :post_id, :content, :author)';
    $statement = $database->prepare($query);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->bindParam(':post_id', $postid, PDO::PARAM_INT);
    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':author', $author, PDO::PARAM_STR);
    $statement->execute();
}

//delete comment doesn't work bajsssssss
function deleteComment($database, $id, $userid)
{
    $id = $_POST['delete-comment'];
    $userid = $_SESSION['user']['id'];
    $query = 'DELETE FROM comments WHERE id = :id AND user_id = :user_id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();
}

//delete account
function deleteUser($database, $id)
{
    $id = $_SESSION['user']['id'];
    $query = 'DELETE FROM users WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

//error function
function alert()
{
    if (isset($_SESSION['errors'])) {
        foreach ((array)$_SESSION['errors'] as $error) {
            echo $error;
            unset($_SESSION['errors']);
        }
    }
}
