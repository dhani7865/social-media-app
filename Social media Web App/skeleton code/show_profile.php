<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>

<h1>SHOW PROFILE</h1>


<?php

// The main job of this script is to execute a SELECT statement to find the user's profile information (then display it)

// execute the header script:
require_once "header.php";
// calling the header.php file
include_once "header.php";

// creating if sttament for logged in skeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // user isn't logged in, display a message saying they must be logged in in order to see the page
    echo "You must be logged in to view this page.<br>";
} // close if statment
else // otherwise
    {
    // user is already logged in, read their username from the session
    $username = $_SESSION["username"];
    
    // now reading their profile data from the table.
    
    // connecting directly to the database (notice 4th argument)
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to know, so allow this exit
    if (!$connection) {
        // if the connection fails return an error message
        die("Connection failed: " . $mysqli_connect_error); // print errror
    } // close if statment for connection failed
    
    // check for a row in our profiles table with a matching username
    //  creating query to select everything from the profiles table and checking matching username
    $query = "SELECT * FROM profiles WHERE username='$username'";
    
    // this query would return data. For example, $result is an identifier
    $result = mysqli_query($connection, $query);
    
    // only returns 1 or 0 rows because username is the primary key in our table)
    $n = mysqli_num_rows($result);
    
    // if there was a match then extract their profile data
    if ($n > 0) {
        // use the identifier to fetch one row as an associative array. The elements are named after columns
        $row = mysqli_fetch_assoc($result);
        // display their profile data
        echo "First name: {$row['firstname']}<br>";
        echo "Last name: {$row['lastname']}<br>";
        echo "Number of pets: {$row['pets']}<br>";
        echo "Email address: {$row['email']}<br>";
        echo "Date of birth: {$row['dob']}<br>";
    } // close if statement
    else // otherwise
        {
        // If there has been no match found, prompt the user to set up their profile
        echo "You still need to set up a profile!<br>";
    } // close else
    
    // close the connection:
    mysqli_close($connection);
    
} // close else

// Finishing off the HTML for this page, by calling the footer page
require_once "footer.php";
?>