<?php

// we don't require headers, etc, as this is not a page that is accessed directly (no menu options needed)
// this is a stateless API and the caller doesn't need to be logged in
// we check that the correct parameter has been supplied via a HTTP GET request
// missing parameters, or a failure to connect to the database cause error response codes to be returned
// otherwise we return a success response code along with the last N messages to be set
// 200 is ok responce code
// 400 is bad responce code

// executing credentials.php file
include_once "../credentials.php";

// variables to store the data we'll send back
$thisRow = array();
$allRows = array();

// creating if statement to get the text
if (!isset($_GET['text'])) {
    // set the kind of data we're sending back and an error response code
    //The header()function lets us say what kind of data we’re sending back, and the HTTP status code
    // son_encode()converts associative array into JSON
    header("Content-Type: application/json", NULL, 400);
    // send
    echo json_encode($allRows);
    // exit this script
    exit;
} // Close if statement to get the text
else // otherwise get the text
    {
    $text = $_GET['text'];
} // close else

// Connecting directly to our database (notice 4th argument)
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// If the connection has failed, return an internal server error
if (!$connection) {
    // set the kind of data we're sending back and a failure code
    header("Content-Type: application/json", NULL, 500);
    // send:
    echo json_encode($allRows);
    // exit this script:
    exit;
} // close if statement for connection

// find the N most recently updated messages/text
// also creating query to select everything from the posts table and ordering the updated time and limiting the messages
$query = "SELECT * FROM posts ORDER BY updated DESC LIMIT $text";

// this query can return data and $result is an identifier
$result = mysqli_query($connection, $query);

// how many rows came back?:
$n = mysqli_num_rows($result);

// if we got any results then add them all into a big array
if ($n > 0) {
    // loop over all rows, adding them into the array
    for ($i = 0; $i < $n; $i++) {
        // fetch one row as an associative array, the elements are named after columns
        $thisRow   = mysqli_fetch_assoc($result);
        // and add it to the data we'll send back
        $allRows[] = $thisRow;
    } // close for loop
} // close if statement for n number of rows

// close the connection
mysqli_close($connection);

// set the kind of data we're sending back and a success code
header("Content-Type: application/json", NULL, 200);

// and send
echo json_encode($allRows);

?>