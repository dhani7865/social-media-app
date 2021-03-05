<?php
// we don't require headers, etc, as this is not a page that is accessed directly (no menu options woulld be needed)
// This is a stateless API and the caller wouldn't need to be logged in 
// We would need to check that the correct parameters have been supplied via a HTTP POST request
// Missing parameters, a failure to connect to the database, or no impact from the query cause error response codes to be returned
// otherwise we return a success response code along with the username that was updated
// 200 is ok responce code
// 400 is bad responce code

// calling the credentials.php file
include_once "../credentials.php";

// Creating variable called username to store the data we'll send back 
$response['username'] = "";

// If statement to post the username and message
if (!isset($_POST['username']) || !isset($_POST['message'])) {
    // Setting the kind of data we're sending back and an error response code
    header("Content-Type: application/json", NULL, 400);
    // and send:
    echo json_encode($response);
    // exit this script
    exit;
} // close if statement
else // otherwise post the username and message
    {
    $username = $_POST['username'];
    $message  = $_POST['message'];
} // close else

// copy the username into our response
$response['username'] = $username;

// connecting directly to our database (notice 4th argument) 
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// If the connection fails, return an internal server error
if (!$connection) {
    // set the kind of data we're sending back and an error response code
    header("Content-Type: application/json", NULL, 500);
    // send
    echo json_encode($response);
    // exit this script 
    exit;
} // close if statement for connection


// update the number of likes for this username/messages: 
// also creating query to update the table
$query = "UPDATE posts SET likes=likes+1 WHERE username='$username' AND message='$message'";

// no data, just true/false
$result = mysqli_query($connection, $query);

// If no data has been returned, we just test for true(success)/false(failure)
if ($result) {
    // did we actually change a row? 
    if (mysqli_affected_rows($connection) == 1) {
        // set the kind of data we're sending back and a success response code
        header("Content-Type: application/json", NULL, 201);
    } // close if statement for my sqli affected rows
    else // otherwise return bad responce code
        {
        // set the kind of data we're sending back and an error response code
        header("Content-Type: application/json", NULL, 400);
    } // close else
} // close if statement for results
else // otherwise
    {
    // something went wrong (e.g., user may have just changed their message) 
    // set the kind of data we're sending back and an error response code: 
    header("Content-Type: application/json", NULL, 400);
} // close else

// Close the connection after we have finished with the database
mysqli_close($connection);

// send: 
echo json_encode($response);

?>