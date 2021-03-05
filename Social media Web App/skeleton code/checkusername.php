<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>

<?php // checkuser.php
// execute the header script:
require_once "header.php";
// execute the helper script:
include_once "helper.php";

// creating if satment for logged in skeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // user isn't logged in, display message saying you must be logged in to view the page
    echo "You must be logged in to view this page.<br>";
} // close if statment for logged in skeleton
else // otherwise
    {
    // if statement to post username
    if (isset($_POST['username'])) {
        $username = sanitise($_POST['username']); // sanitise username
        // creating query
        // select everything from the members table where username
        $result   = queryMysql("SELECT * FROM rnmembers WHERE username='$username'"); /// creating query
        // if statement to check if username has been taken or not and print message
        if ($result->num_rows)
            echo "<span class='taken'>&nbsp;&#x2718; " . "This username is taken</span>";
        else // otherwise print out successs message
            echo "<span class='available'>&nbsp;&#x2714; " . "This username is available</span>";
    } // close if statment
} // close else

// finish of the HTML for this page:
require_once "footer.php";
?>