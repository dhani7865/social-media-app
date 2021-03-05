<?php

// The main job of this script is to execute a SELECT statement to find the user's message from the posts table

// execute the header script:
require_once "header.php";

// creating if statement to create session for logged in skeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // If the user isn't logged in, display a message saying they must be signed in, in order to view the page.
    echo "You must be logged in to view this page.<br>";
} // close if statement for session logged in skeleton
else // otherwise
    {
    // If the user is already logged in, read their username from the session
    $username = $_SESSION["username"];
    
    // Now reading their post from the table.
    
    // connect directly to our database (notice 4th argument):
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to know, so allow this exit
    if (!$connection) {
        // print message saying connection failed if the connection has failed
        die("Connection failed: " . $mysqli_connect_error);
    } // close if statement for connection
    
    // check for a row in our posts table with a matching username
    // creating query to select the message and updated row from the posts table
    $query = "SELECT message, updated FROM posts WHERE username='$username'";
    
    // this query can return data ($result is an identifier)
    // print the reuslt from the query
    $result = mysqli_query($connection, $query);
    
    // Only 1 or 0 rows can be returned because username is the primary key in our table)
    $n = mysqli_num_rows($result);
    
    // if there was a match then extract their message
    if ($n > 0) {
        // use the identifier to fetch one row as an associative array, elements which are named after columns
        $row     = mysqli_fetch_assoc($result);
        // extract their message and the time it was set for use in the HTML
        $message = $row['message'];
        $updated = $row['updated'];
        
        // show their message and the updated time:
        echo "<b>HERE IT IS: $message</b><br><br>Last updated: $updated<br>";
    } // close if statement for matching row
    else // otherwise
        {
        // If there has been no match found, prompt the user to set up their message:
        echo "You still need to set a post!<br>";
    } // close else statement
    
    // close the connection:
    mysqli_close($connection);
    
} // close else
?>