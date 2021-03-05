<?php

// This script is called by every other script (via require_once)
// It starts the session and displays a different set of menu links depending on whether the user is logged in or not...
// ... And, if they are logged in, whether or not they are the admin
// It also reads in the credentials for our database connection from credentials.php

// database connection details:
// Calling the credentials.php file
require_once "credentials.php";

// our helper functions
include_once "helper.php";


// here we are either starting or restarting the session
session_start();

// if statement for session loggedinskeleton
if (isset($_SESSION['loggedInSkeleton'])) {
    // This person is already logged in 
    // display the logged in menu options
    echo <<<_END
<!DOCTYPE html>
<html>
<body>
<a href='about.php'>about</a>
<a href='set_profile.php'>set profile</a>
<a href='show_profile.php'>show profile</a>
<a href='browse_profiles.php'>browse profiles</a>
<!---<a href='global_feed.php'>global feed</a> --->
<a href='messages.php'>Messages</a>
<a href='chart.php'>Chart</a>
<a href='create_data.php'>Create Data</a>
<a href='libraries.php'>video sharing</a>
<a href='Beginners_guide.php'>Beginners Guide</a>

<a href='sign_out.php'>sign out ({$_SESSION['username']})</a>
_END;
    // an extra bit on the menu will be included if the admin has logged in
    // only admings can see this data
    if ($_SESSION['username'] == "admin") {
        echo " <a href='developer_tools.php'>developer tools</a>";
    } // close if statement for username == admin
} // close if statement for session loggedinskeleton
else // otherwise
    {
    // This person is not logged in
    // show the logged out menu options
    echo <<<_END
<!DOCTYPE html>
<html>
<body>
<a href='about.php'>about</a>
<a href='sign_up.php'>sign up</a>
<a href='sign_in.php'>sign in</a>
_END;
} // close else
echo <<<_END
<br>
<h1>2CWK50: A Social Network</h1>
_END;
?>