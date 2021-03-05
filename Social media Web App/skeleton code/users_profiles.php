<?php
// execute credentials.php
require_once "credentials.php";
//get db connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// if the connection fails, we need to know, so allow this exit
if (!$connection) {
    // print error message
    die("Connection failed: " . $mysqli_connect_error); // display error message
} // close if statment for connection failed
mysqli_select_db($connection, "skeleton") or die("error"); // select db called skeleton or print out error message

// Creating query for the database and retrieve all the profiles
// select everything from the profiles table
$sql = "SELECT * FROM profiles";

// query can return data 
// $result has been used to identify the data which has been returned
$result = $connection->query($sql);

// if there is a match then the data will be displayed on the screen
if ($result->num_rows > 0) {
    // a list is required of all the profiles
    // a $row is to identify when to show all results, by creating while loop
    while ($row = $result->fetch_assoc()) {
        // the row will be the usernames
        $username = $row["username"];
        
        //echoing all the usernames which are already created with a link to browse_profiles.php file from the skeleton code folder, when clicked will then show each of the users profiles.
        echo '<tr><td><a href="/skeleton code/browse_profiles.php?username=' . $username . '">' . $username . '</a><br /></td></tr>';
    } // close while loop
    // Close table
} // close if statment
else //otherwise
    {
    // if no profiles are displayed then show the message
    echo "0 results"; // print message no results found
} // close else
?>