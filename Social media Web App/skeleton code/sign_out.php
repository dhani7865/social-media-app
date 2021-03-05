<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>

<?php

// The main job of this script is to end the user's session 


// execute the header script:
require_once "header.php";
// calling the header.php file
include_once "header.php";

// creating if statment to creating session for logged in skeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // f the user isn't logged in, display a message saying they must be logged in, in order to see the page
    echo "You must be logged in to view this page.<br>";
} // close if statment
else // otherwise
    {
    // If the user clicked to logout, destroy the session data
    // first clear the session superglobal array
    $_SESSION = array();
    // Then setting the cookie that holds the session ID
    setcookie(session_name(), "", time() - 2592000, '/');
    // Destroy the session
    session_destroy(); // destroy session
    // Print message to tell the user that they have been logged out.
    // If they have been logged out it will tell them to sign in
    echo "You have successfully logged out, please <a href='sign_in.php'>click here</a><br>"; //print success message
} // close else statment

// Finishing off the HTML for this page, by calling the footer page
require_once "footer.php";
?>