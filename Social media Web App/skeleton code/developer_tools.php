<!--- Adding stylesheet --->
<style>
<?php include 'stylesheet.css'; ?>
</style>

<?php
// You need to add code to this script to implement the developer tools
// Notice that the code not only checks whether the user is logged in, but also whether they are the admin, before it displays the page content
// You can implement all the developer tools functionality from this script, or...
// ... You may wish to add admin-only features to other pages as well - e.g., global_feed.php (where a simple example has been included)

// execute the header script:
require_once "header.php";
// calling the header.php file
include_once "header.php";

// if statment for session when logged into skeleton
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be logged in order to view the page.
	echo "You must be logged in to view this page.<br>";
} // close if statment
else // otherwise
{
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message)
    // if username is admin you will then see the content if not you won't see the content. as you would need to be an admin in order to see it. 
	if ($_SESSION['username'] == "admin")
	{
        // print statment
		echo "Implement the developer tools here... See the assignment specification for more details.<br>";
	} // close if statment
	else // otherwise
	{
        // print statement
		echo "You don't have permission to view this page...<br>"; // print message
	} /// close else
} // close else

// Finishing off the HTML for this page, by calling the footer page
require_once "footer.php";
?>