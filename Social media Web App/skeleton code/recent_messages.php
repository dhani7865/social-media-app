<h1>RECENT MESSAGES</h1>


<?php

// The main job of this script is to request the N most recent messages from the API and display them in the table
// On a successful call to the API (recent.php) the jQuery deletes any old rows in the table and replaces them with the latest data
// The checkForPosts() function is called again regardless of success/failure
// Right-click and "inspect" in Chrome in order to see the JavaScript debug.

// execute the header script:
require_once "header.php";

// how many milliseconds to wait between updates
// setting the milliseconds.
$milliseconds = 5000;
// how many recent posts to display
// only 5 recent posts will be displayed in the table
$nrows        = 5;

// creating if statement to create session for logged in skeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // user isn't logged in, display a message saying they must be logged in order to view the page
    echo "You must be logged in to view this page.<br>";
} // close if statement for logged in skeleton
else // otherwise
    {
    // Creating CSS to make the table clearly visible, and jQuery to control updates
    // importing the javascript library
    // creating style to make the table visible usig css
    // creating the table called posts, to show the usernames, messages, updated times and the diferent likes
    
    // creating jquery to create function for checkForPosts
    // creating function for check for posts to check for the different pdates
    // as soon as the page is ready, start checking for updates
    // get json and calling the recent.php file from the api folder
    // creating function for done
    // debug message to help during development
    // remove the old table rows
    // loop through what we got and add it to the table (data is already a JavaScript object thanks to getJSON())
    // creating function for fails
    // debug message to help during development:
    // printing invalid message
    // creating function for always
    // printing message to the console saying the request has been completed.
    // call the checkForPosts function again after a brief pause
    
    
    echo <<<_END
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    

<style>
    table, th, td {border: 1px solid black; align: center;}
</style>

<table id='posts'>
<tr><th>Usernames</th><th>Messages</th><th>Updated</th><th>Likes</th></tr>
</table>
<script>
$(document).ready(function()
{    
    checkForPosts();
});

function checkForPosts(){
    $.getJSON('api/recent.php', {text: $nrows})
        .done(function(data) {
            console.log('request successful');
            
            $('.result').remove();
            
            $.each(data, function(index, message) {
                $('#posts').append("<tr class='result'><td>" + message.username + "</td><td>" + message.message + "</td><td>" + message.updated + "</td><td>" + message.likes + "</td></tr>");
            });
        })

        .fail(function(jqXHR) {
            console.log('request returned failure, HTTP status code ' + jqXHR.status);
        })

        .always(function() {
            console.log('request completed');
            setTimeout(checkForPosts, $milliseconds);
        });
} // elsoe else

</script>
_END;
    
} // close else
?>