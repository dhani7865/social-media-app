<h1>GLOBAL FEED</h1>

<?php

// Things to notice:
// It would reset the number of likes if a user changes their message
// I have used client-side validation using "number" input and "required","min","max" attributes.
// I have sanitise the user's feed (message) - see helper.php (included via header.php) for the sanitisation function
// I have validated the user's feed (message) - see helper.php (included via header.php) for the validation functions
// I have created function for validateDate, in te helper.php to validate the date. 
// The main job of this script is to execute an UPDATE or INSERT statement to set the user's message
// (A user can sign up without specifying a message, so there may or may not be a message to update)

// Executing the header script
require_once "header.php";


// Executing and calling the different files in order for the messages to be displayed
// Show messages would show the recent message which has been nputted by the user
// Recent_messages would show the 5 recent messages
// All messages would show all the messages in the table which the users have inputted.
require_once "show_messages.php";
require_once "recent_messages.php";
require_once "all_messages.php";



// Feed is a default value which we would show in the form
$feed          = "";
// Creating string to hold any validation error message
$feed_val      = "";
// should we show the set messages form?:
$show_set_form = false;
// message to output to user
$message       = "";
// the min and max numbers we will allow 
// between -/+ 2 billion, which our database table can comfortably hold with a BIGINT, 
// HTML5 can validate on the client-side, and should be big enough for most users.
// quotation mark specifies a string, to specify integer we don't use the quotation
$maxlength     = 200; // maximum message length up to  200
$minlength     = 0; // minimum length of the messages is set to 0

// Creating if statement to create session for when the user is logged in
if (!isset($_SESSION['loggedInSkeleton'])) {
    // If the user isn't logged in, display a message saying they must be, in order to visit the site
    echo "You must be logged in to view this page.<br>";
} // close if statement
// else statement to post a feed
elseif (isset($_POST['feed'])) {
    // a little extra text that only the admin will see!:
    if ($_SESSION['username'] == "admin") {
        echo "[admin sees more!]<br>";
    }
    // user just tried to update their feed (message)
    // connect directly to our database (notice 4th argument) we need the connection for sanitisation, otherwise display mysql error
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die(mysql_error());
    
    // if the connection fails, we would need to know, so allow this exit
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    } // close if statement for connection
    
    
    // SANITISATION (see helper.php for the function definition)
    // Take a copy of the feed the user submitted and sanitise (clean)
    // Post is pair of the value
    // feed has to match with the user input in the form e.g. name = "feed"
    $feed = sanitise($_POST['feed'], $connection);
    
    // VALIDATION (see helper.php for the function definitions)
    // Now validate the data (int must be between +/- 2 billion)
    $feed_val = validateString($feed, $minlength, $maxlength);
    
    // Concatenate all the validation results together ($errors will only be empty if ALL the data is valid)
    // val = validate
    // feed_val is stored in errors
    $errors = $feed_val;
    
    // Check that all the validation tests are passed before going to the database
    if ($errors == "") {
        //echo "Hello - ready to add to the database <br>";
        // read their username from the session:
        $username = $_SESSION["username"];
        
        // Now write their new post to our database table.
        
        // Check to see if this user already had a message
        // Creating query to select all messages from the posts table
        $query = "SELECT message FROM posts WHERE username='$username'";
        
        // this query would return the data/result ($result is an identifier), otherwise return an sql error
        $result = mysqli_query($connection, $query) or die(mysql_error());
        
        //echo "Hello - query sent <br>";
        
        // how many rows came back? (can only be 1 or 0 because username is the primary key in our table)
        $n = mysqli_num_rows($result);
        
        // if there was a match then UPDATE their message, otherwise INSERT it to the table
        if ($n > 0) {
            // Creating an UPDATE to update the mssage in the database (we use SYSDATE() to get the current server time)
            $query = "UPDATE posts SET message='$feed',updated=SYSDATE(),likes=0 WHERE username='$username'";
            
            //echo "$query<br>";
            // this query would return the data/result, otherwise return mysql error
            $result = mysqli_query($connection, $query) or die(mysql_error());
        } // close if statement
        else // otherwise
            {
            // I have used a INSERT to insert all columns to the database (we use SYSDATE() to get the current server time)
            $query = "INSERT INTO posts (username, message, updated) VALUES ('$username', $feed, SYSDATE())";
            // this query would return the data/result, otherwise return an error message
            $result = mysqli_query($connection, $query) or die(mysql_error());
        } // close else
        
        // If no data has been returned, then we just test for true(success)/false(failure)
        if ($result) {
            // SHowing a successful update message
            $message = "Post successfully updated<br>";
        } // close if statement for result
        else // otherwise return an error message if update failed
            {
            // Showing an unsuccessful update message
            $message = "Update failed<br>";
        } // close else
    } // close if statement errors
    else // otherwise show the form if validation has failed
        {
        // validation failed, show the form again with guidance
        $show_set_form = true;
        // Showing an unsuccessful update message
        $message       = "Update failed, please check the errors shown above and try again<br>";
    } // close else
    
    // we're finished with the database, close the connection
    mysqli_close($connection);
    
} // close if statement session for logged in skeleton
else // otherwise show the form
    {
    // arrived at the page for the first time, just show the form
    $show_set_form = true;
} // close else

// creating if statement to show the form
if ($show_set_form) {
    // show the form that allows users to log in
    //  I have used an HTTP POST request to avoid the password appearing in the URL
    if (isset($_GET['noval'])) // creating if statement to get the post of the user
        {
        // a version WITHOUT client-side validation so that we can test server-side validation
        echo <<<_END
<!--- This HTML code specifies that the form data will be submitted to the messages.php --->
<!--- using the post method to post whatever the user has inputted --->
<form action="messages.php?noval=y" method="post">
  Enter your new post:<br>
  <input type="text" name="feed" value="$feed"> $feed_val
  <br>
  <input type="submit" value="Submit">
</form>    
_END;
    } // close if statement for noval
    else {
        // This is the form with the client side validation
        // This HTML code specifies that the form data will be submitted to the messages.php
        // using the post method to post whatever the user has inputted
        echo <<<_END
<form action="messages.php" method="post">
  Enter your new post:<br>
    <input type="text" name="feed" min="$minlength" max="$maxlength" value="$feed" required> $feed_val
  <br>
  <input type="submit" value="Submit">
</form>    
_END;
    } // close else statement to get the post
} // close if statement to show the form

// Display the message to the user
echo $message;

// Finishing off the HTML for this page, by calling the footer page
require_once "footer.php";
?>