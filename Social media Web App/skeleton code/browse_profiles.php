<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>
<!--- Creating a title for this page --->
<h1>USER PROFILES</h2>

<?php

// At the beginning you will need to input code to this script, which will allow users to browse other user profiles
// Echoing out all the other usernames

// execute the header script
require_once "header.php";
// execute the credentials script
require_once "credentials.php";

// creating if statement for logged in skeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // user isn't logged in, display a message saying they must be logged in
    echo "User must be logged in to view this page.<br>";
} // close if statment
else // otherwise
    {
    // echoing the files would be required to run this page
    // displaying the files which would run on this page
    
    // The user search is carried out to display all the profiles from the users_profiles.php file
    require_once "users_profiles.php";
    
    // here we are checking for a form submission, by creating if statment to get the username
    if (isset($_GET['username'])) {
        $username   = $_GET['username']; // get the username
        // creating db connection
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        // if the connection has failed,the users would need to be informed. therefore, allow this exit
        if (!$connection) {
            // print error message "Connection failed"
            die("Connection failed: " . $mysqli_connect_error); // connection failed
        } // close if statement for connection
        
        //if connection has failed, error messages would appear on the screen
        mysqli_select_db($connection, "skeleton") or die("error");
        
        // Creating connection along with a query to receive data from the database
        $query = mysqli_query($connection, "SELECT * FROM Profiles WHERE username= '$username'") or die("error");
        // if no usernames exist, an error message will appear on the screen
        if (mysqli_num_rows($query) != 1) {
            // print error message saying username doesn't exist
            die("username doesnt exist");
        } // close if satment
        
        // This is used to identify each row as an array, by creating while loop
        while ($row = mysqli_fetch_array($query, MYSQL_ASSOC)) {
            // Creating a while loop to extract all users data/information
            $firstname = $row['firstname'];
            $lastname  = $row['lastname'];
            $pets      = $row['pets'];
            $email     = $row['email'];
            $dob       = $row['dob'];
        } // close while loop
        
        // Close connection
        mysqli_close($connection);
        
        // This displays all the user data of each individual user
        echo <<<_END
<!--- creating heading for the firstname, lastname, pets, Email and DOB --->
<h2> $firstname $lastname's Profile </h2>
        <!--- creating table --->
        Firstname: $firstname <br>
        Lastname:  $lastname <br>
        Pets: $pets <br>
        Email: $email <br>
        DOB: $dob <br>
    </table>   <!--- close table ---> 
_END;
    } // Close if statment to get usernames
} // close if statment for logged in skeleton

// Finishing off the HTML for this page, by calling the footer page
require_once "footer.php";
?>