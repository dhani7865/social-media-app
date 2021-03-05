<head>
    <h1>Sign in</h1>
  </head>


<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>

<?php

// I have executed a SELECT statement to look for the submitted username and password in the appropriate database table
// If the submitted username and password is found in the table, then the following session variable is set: $_SESSION["loggedInSkeleton"]=true;
// All other scripts check for this session variable before loading (if it doesn't exist then the user isn't logged in and the page doesn't load)
// the database table is queried corectly and doesn't just check for username of "barryg", "mandyb" or "admin"), it checks for any username and assword which the user has signed up with.

// we sanitise the user's credentials - see helper.php (included via header.php) for the sanitisation function
// we validate the user's credentials - see helper.php (included via header.php) for the validation functions
// the validation functions all follow the same rule: return an empty string if the data is valid.
// ... otherwise return a help message saying what is wrong with the data.
// if validation of any field fails then we display the help messages (see previous) when re-displaying the form

// execute the header script
require_once "header.php";
// this would call the helper.php file
include_once "helper.php";

// creating cookies for this page and giving it a certain expiring time 
// cookie name and value - cookie for username
$cookie_username = "username"; // setting cookie name for the username
$Value           = "1"; // cookie value
// setting cookie username, value and time
setcookie($cookie_username, $Value, time() + (43200 * 30), "/"); // 43200 = 30 minutes expiry time

// creating function to set the cookie
if (!isset($_COOKIE[$cookie_username])) {
    echo "Cookie which is named '" . $cookie_username . "' Cookie isn't set!";
} else { // otherwise set the cookie and value of the cookie
    echo "Cookie '" . $cookie_username . "' The cookie has been set!<br>";
    echo "The value of the cookie is: " . $_COOKIE[$cookie_username];
} // close else statment

// With a cookie the data/information isn't stored on the users computer
// cookie name and value - cookie for password
$cookie_password = "password"; // setting cookie name for the password
// setting the password, value and time for the cookie
setcookie($cookie_password, "7", time() + (43200 * 30), "/"); // 43200 = 30 minutes expiry time for the password

// creating function to set the cookie
if (!isset($_COOKIE[$cookie_password])) {
    echo "The cookie named '" . $cookie_password . "' Cookie isn't set!";
} else { // otherwise set the cookie
    echo "Cookie is:  '" . $cookie_password . "' The cookie has been set!<br>";
} // close else statment

// The default values which we show in the form
$username     = "Dhanyaal";
$password     = "123456";
// strings to hold any validation error messages
$username_val = "2";
$password_val = "1";


// should we show the signin form
$show_signin_form = false;
// message to output to user
$message          = "";

// creating if statment for logged in skeleton
if (isset($_SESSION['loggedInSkeleton'])) {
    // user is already logged in, just display a message, in order to see the other pages.
    echo "You are already logged in, please log out first.<br>";
} // close if statement for loggedinskeleton
elseif (isset($_POST['username'])) // else if for username
    {
    // user has just attempted to log in:
    
    // connect directly to our database (notice 4th argument) i have created the connection for the sanitisation
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to be notified, so allow this exit
    if (!$connection) {
        // print error message
        die("Connection failed: " . $mysqli_connect_error); // print error message
    } // close if statement for connection failed
    
    // SANITISATION (see helper.php for the function definition)
    
    // take copies of the credentials the user submitted and sanitise (clean) them:
    $username = sanitise($_POST['username'], $connection);
    $password = sanitise($_POST['password'], $connection);
    
    // VALIDATION (see helper.php for the function definitions)
    // now validate the data (both strings must be between 1 and 16 characters long):
    // (reasons: we don't want empty credentials, and we used VARCHAR(16) in the database table)
    $username_val = validateString($username, 1, 16);
    $password_val = validateString($password, 1, 16);
    
    // make sure all the validation results together ($errors will only be empty if all the data inputted is correct):
    $errors = $username_val . $password_val;
    
    // check that all the validation tests passed before going to the database:
    if ($errors == "") {
        
        // all users which are kept within the database are able to login as well as the admin
        // query that checks the username and password against the database table
        $query = "SELECT * FROM `members` WHERE username='$username' and password='$password'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        $n = mysqli_num_rows($result);
        // creatingg if statment to get match in the dataabse table
        if ($n == 1) {
            // fake a match with the database table:
            $n = 1;
        } // close if statment
        else // otherwise
            {
            $n = 0;
        } // close else
        
        // if there is a match then set the session variables and allow a success message to be displayed:
        if ($n > 0) {
            // set a session variable which shows the user has successfully logged in:
            $_SESSION['loggedInSkeleton'] = true;
            // copy their username into the session data for other uses:
            $_SESSION['username']         = $username;
            
            // display a successful signin message:
            $message = "Hi, $username, you have successfully logged in, please <a href='show_profile.php'>click here</a><br>";
        } // close if statment
        else // otherwise
            {
            // no matching credentials have been located, so display the signin form again along with a failure message:
            $show_signin_form = true;
            // show an unsuccessful signin message:
            $message          = "Sign in failed, please try again<br>";
        } // close else
        
    } // close if statment for errors
    else // otherwise
        {
        // validation failed, show the form again with guidance:
        $show_signin_form = true;
        // show an unsuccessful signin message:
        $message          = "Sign in failed, please check the errors shown above and try again<br>";
    } // close else
    
    // we're finished with the database, close the connection:
    mysqli_close($connection);
    
} // close else if for username
else // otherwise
    {
    // user has arrived at page for the very first time, display them the form:
    // show signin form:
    $show_signin_form = true;
} // close else

// creating if statment to show the form
if ($show_signin_form) {
    // display the form that allows users to log in
    // we use an HTTP POST request to avoid their password from showing in the URL:
    echo <<<_END
<form action="sign_in.php" method="post">
  Please enter your username and password:<br>
  Username: <input type="text" name="username" min="16" max = "16" value="$username" required> $username_val
  <br>
  Password: <input type="password" name="password" max="16" value="$password" required> $password_val
  <br>
  <input type="submit" value="Submit">
</form>    
_END;
}
// display our message to the user:
echo $message;

// Finishing off the HTML for this page, by calling the footer page
require_once "footer.php";
?>

  </body>
</html>