<h1>ALL MESSAGES</h1>

<?php

// Showing usernames and likes
// In order to like post, click the "+"
// We would only update the number of likes upon getting a successful reply from the server
// Multiple requests can be open at once, we use the username in the data that comes back to decide who to update
// Right-click and "inspect" in Chrome in order to see the JavaScript debug
// The main job of this script is to execute a SELECT statement to get and ORDER all the messages 

// execute the header script
require_once "header.php";

// creating if statment to create session for loggedInSKeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // Use isn't logged in, display a message saying they must be, in  order to visit the site
    echo "You must be logged in to view this page.<br>";
} // close if statement for session loggedinSKeleton
else // otherwise return an error message
    {
    // user is already logged in, read all the messages and display in a table
    
    // Connecting directly to the database (notice 4th argument)
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we would then need to know, so allow this exit
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    } // close if statment for connection
    
    // find all messages, ordered by their last update time (descending order)
    $query = "SELECT * FROM posts ORDER BY updated DESC";
    
    // this query can return data ($result is an identifier)
    $result = mysqli_query($connection, $query);
    
    // This would return the number of rows
    $n = mysqli_num_rows($result);
    
    // If we got some results then show them in a table
    if ($n > 0) {
        // CSS to make the table clearly visible, and jQuery to control updates
        echo <<<_END

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    

<style>
    table, th, td {border: 1px solid black; align: center;}
</style>

<script>
$(document).ready(function()
{
    $("#posts a").click(function(event) {
        // user just clicked a "like" link, prevent default behaviour
        event.preventDefault(); 
                
        // Creating a javascript object to hold the request data
        var request = {};
        request["username"] = $(this).data('username');
        request["message"] = $(this).data('message');
        // calling the like.php file and to hold request
        $.post('api/like.php', request)
        .done(function(data) {
            // debug message to help during development:
            console.log('request successful')
            
            // update the relevant user's likes number by one:
            var currentLikes = parseInt($('#' + data.username + ' .like').text(),10);
            var newLikes = currentLikes + 1;
            $('#' + data.username + ' .like').text(newLikes);
                
        })
        .fail(function(jqXHR) {
            // debug message to help during development
            console.log('request returned failure, HTTP status code ' + jqXHR.status);
        })
        .always(function() {
            // debug message to help during development
            console.log('request completed');
        });
    });
});
</script>

_END;
        // Printing out the table called posts to display the 7sernames, Messages, Updated and likes
        echo "<table id='posts'>";
        echo "<tr><th>Usernames</th><th>Messages</th><th>Updated</th><th>Likes</th><th></th></tr>";
        // loop over all rows, adding them into the table
        for ($i = 0; $i < $n; $i++) {
            $message = "";
            // fetch one row as an associative array (elements are named after columns)
            $row     = mysqli_fetch_assoc($result);
            
            // Reading the values out here to keep the HTML below more readable
            $username = $row['username'];
            $message  = $row['message'];
            $likes    = $row['likes'];
            $updated  = $row['updated'];
            
            // Adding it as a row in the table
            echo "<tr id='$username'>";
            echo "<td>$username</td>";
            echo "<td>$message</td>";
            echo "<td>$updated</td>";
            echo "<td class='like'>$likes</td>";
            echo "<td><a data-username='$username' data-message='$message'>+</a></td>";
            echo "</tr>";
        } // close for loop
        echo "</table>"; // close table
    } // close if statement for number of rows
    else // otherwise return error message
        {
        // no messages...:
        echo "no messages found<br>";
    } // close else
    
    // we're finished with the database, close the connection:
    mysqli_close($connection);
} // close if statment for session loggedinSKeleton
?>