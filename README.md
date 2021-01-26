# Hacker News

Big Christmas project. The website is supposed to be a "clone" of hackernews.com. The project is built with PHP, SQL, HTML, and Javascript.

## Extra features

- As a user I'm able to delete my account along with all posts, upvotes and comments.

## Installation

1. Clone this repository.
2. Open a local host server.
3. Visit the projects index.php page.
4. Have fun!

## Testers

1. Rikard Segerkvist
2. Simon Lindstedt

## Code review

1. Hide profile link while no user is logged in, since it basically acts as a second login button.
   (/sections/navigation.php line 22)

2. Maybe change the upvote button to a link when the user is not logged in, without sending any data via post.
   (/index.php line 78)

3. Display a warning when deleting post and profile.
   (/index.php line 89 and editprofile.php line 83)

4. Removing the old image from uploads when a user updates their profile-picture or delete their account (might I suggest `unlink()` ?).

5. Error message doesn't trigger for filesize, likely due to ’$\_FILES’ not being set properly when image is too big for some reason. Try changing your php.ini. Or it might just be my system, who knows :(
   (regarding /app/users/updateprofile.php comment line 24)

6. I would name `$_POST` update-password/new-password 1 and 2 to password and password-conf for clarity.
   (/app/users/updateprofile.php line 97 & 98)

7. Checking for empty input in places where the input can not be empty with (`empty()` for instance!). I'm able to effectivly brick my account by entering no input in the change email field and then submitting (in general on all places where a call to a database is made and the data can't be empty).

8. I would probably make functions checking things return bool-values, and making the code act on that information.

9. In all functions calling the database I would add some sort of failstate, should the database fail for some reason.

10. Adding void as return type for all functions not returning any values.

11. No need of returning `$_SESSION` from any function since it's a global variable! (At least no reason that I can think of).

12. When creating a new post I'm able to add a string of any kind into the url field. I would add type="url" to all inputfields where url's are being submitted and checking for valid urls via php.

13. The votes tab in the posts table doesn't seem to do anything.

14. Adding a .gitignore for files not wanted in your repo (like .DS_Store for instance!).

All around fantastic work 🔥

By Simon Lindstedt

## New features by:

- Emil Pettersson

