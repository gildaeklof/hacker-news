<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

//register functions
//
//checks if email is already registered
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

//checks if username is already registered
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

//register user
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

//delete account
function deleteUser($database, $id)
{
    $query = 'DELETE FROM users WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $query = 'DELETE FROM comments WHERE user_id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $query = 'DELETE FROM upvotes WHERE user_id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $query = 'DELETE FROM posts WHERE user_id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
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

//update profile picture
function changeProfileImg($database, $id, $avatarname)
{
    $query = 'UPDATE users SET avatar = :avatar WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindParam(':avatar', $avatarname, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
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

//prettify urls
function sanitizeLink($link): string
{
    return (string) preg_replace("#^[^:/.]*[:/]+#i", "", $link);
}

//get new posts
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
    $query = 'SELECT * FROM posts WHERE user_id = :user_id ORDER BY id DESC';
    $statement = $database->prepare($query);

    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

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

    $query = 'DELETE FROM comments WHERE post_id = :id AND user_id = :user_id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();

    $query = 'DELETE FROM upvotes WHERE post_id = :id AND user_id = :user_id';
    $statement = $database->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();
}

//upvote functions
//
//checks if upvote exists
function existUpvote($database, $postid, $userid)
{
    $query = 'SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id';
    $statement = $database->prepare($query);

    if (!$statement) {
        die(var_dump($database->errorinfo()));
    }

    $statement->bindParam(':post_id', $postid, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();

    $upvote = $statement->fetch(PDO::FETCH_ASSOC);

    if ($upvote) {
        return true;
    } else {
        return false;
    }
}

//add upvote
function upvotePost($database, $postid, $userid)
{
    $query = 'INSERT INTO upvotes (post_id, user_id) VALUES (:post_id, :user_id)';
    $statement = $database->prepare($query);

    $statement->bindParam(':post_id', $postid, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();
}

//remove upvote
function removeUpvote($database, $postid, $userid)
{
    $query = 'DELETE FROM upvotes WHERE user_id = :user_id AND post_id = :post_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':post_id', $postid, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();
}

//get number of upvotes
function getUpvotes($database, $id): int
{
    $query = 'SELECT COUNT(*) FROM upvotes WHERE post_id = :post_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $upvotes = $statement->fetch(PDO::FETCH_ASSOC);
    return (int) $upvotes["COUNT(*)"];
}

//fetch posts with most to least upvotes
function mostUpvoted($database): array
{
    $query = 'SELECT posts.id, posts.user_id, posts.title, posts.link, posts.description, posts.date, posts.author, upvotes.post_id FROM posts INNER JOIN upvotes on posts.id = upvotes.post_id GROUP BY post_id ORDER BY COUNT(*) DESC';
    $statement = $database->prepare($query);
    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
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

//Emil
// Get comment replies from comments
function getCommentReplyByCommentId($database, $commentid): array
{
    $query = 'SELECT * FROM comments_reply WHERE comment_id = :comment_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':comment_id', $commentid, PDO::PARAM_INT);
    $statement->execute();

    $commentreply = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($commentreply === false) {
        $commentreply = [];
    }
    return $commentreply;
}

//Emil
//Add new reply

function addReply($database, $comment_id, $user_id,  $comment_reply, $author)
{
    $query = 'INSERT INTO comments_reply (user_id, comment_id, comment_reply, author) VALUES (:user_id, :comment_id, :comment_reply, :author)';
    $statement = $database->prepare($query);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    $statement->bindParam(':comment_reply', $comment_reply, PDO::PARAM_STR);
    $statement->bindParam(':author', $author, PDO::PARAM_STR);
    $statement->execute();
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

//delete comment
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

//edit comment
function editComment($database, $content, $id, $userid)
{
    $query = 'UPDATE comments SET content = :content WHERE id = :id AND user_id = :user_id';
    $statement = $database->prepare($query);
    $statement->bindParam(':content', $content, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userid, PDO::PARAM_INT);
    $statement->execute();
}

//get number of comments
function getCommentCount($database, $id): int
{
    $query = 'SELECT COUNT(*) FROM comments WHERE post_id = :post_id';
    $statement = $database->prepare($query);

    $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $commentcount = $statement->fetch(PDO::FETCH_ASSOC);
    return (int) $commentcount["COUNT(*)"];
}

//error and success function
function alerts(): void
{
    if (isset($_SESSION['errors'])) {
        echo "<p class=\"error\">" . $_SESSION['errors'] . "</p>";
        unset($_SESSION['errors']);
    }

    if (isset($_SESSION['success'])) {
        echo "<p class=\"success\">" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
}


//sessions
function loginSession(): void
{
    if (isset($_SESSION['login']['current-email'])) {
        echo $_SESSION['login']['current-email'];
        unset($_SESSION['login']['current-email']);
    }
    if (isset($_SESSION['login']['current-password'])) {
        echo $_SESSION['login']['current-password'];
        unset($_SESSION['login']['current-password']);
    }
}


function registerEmail(): void
{
    if (isset($_SESSION['register']['new-email'])) {
        echo $_SESSION['register']['new-email'];
        unset($_SESSION['register']['new-email']);
    }
}

function registerUsername(): void
{
    if (isset($_SESSION['register']['new-username'])) {
        echo $_SESSION['register']['new-username'];
        unset($_SESSION['register']['new-username']);
    }
}

function registerPassword(): void
{
    if (isset($_SESSION['register']['new-password-1'])) {
        echo $_SESSION['register']['new-password-1'];
        unset($_SESSION['register']['new-password-1']);
    }
}

function registerConfirm(): void
{
    if (isset($_SESSION['register']['new-password-2'])) {
        echo $_SESSION['register']['new-password-2'];
        unset($_SESSION['register']['new-password-2']);
    }
}

function registerBio(): void
{
    if (isset($_SESSION['register']['new-bio'])) {
        echo $_SESSION['register']['new-bio'];
        unset($_SESSION['register']['new-bio']);
    }
}
