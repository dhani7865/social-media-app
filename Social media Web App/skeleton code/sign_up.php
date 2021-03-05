<head>
    <h1>Sign up</h1>
  </head>


<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>

<?php

// The main job of this script is to create INSERT statement to add the submitted username and password to the database
// client-side validation using "password","text" inputs and "required","maxlength" attributes.
// we sanitise the user's credentials - see helper.php (included via header.php) for the sanitisation function
// we validate the user's credentials - see helper.php (included via header.php) for the validation functions
// The rule for validating; return an empty string if the data is valid.
// ..otherwise return a help message saying what is wrong with the data.
// if validation of any field fails then we display the help messages (see previous) when re-displaying the form

// execute the header script:
require_once "header.php";
// this would execute (call) the helper.php file
include_once "helper.php";

// creating cookies for this page and giving it a certain expiring time 
// cookie name and value - cookie for username
$cookie_username = "username"; // setting cookie name for the username
$Value           = "1"; // cookie value
// setting the cookie and the expiry time.
setcookie($cookie_username, $Value, time() + (43200 * 30), "/"); // 43200 = 30 minutes expiry time

// creating function to set the cookie
if (!isset($_COOKIE[$cookie_username])) {
    // if the cookie isnt set print message out saying "cookie isn't set"
    echo "Cookie which is named '" . $cookie_username . "' Cookie isn't set!";
} else { // close if statement or cookie username; otherwise return message saying cookie has been set.
    echo "Cookie '" . $cookie_username . "' The cookie has been set!<br>";
    // also printing out the value of the cookie.
    echo "The value of the cookie is: " . $_COOKIE[$cookie_username];
} // close else statment

// With a cookie the data/information isn't stored on the users computer
// setting the cookie name and value - cookie for password
$cookie_password = "password"; // setting cookie name for the password
setcookie($cookie_password, "7", time() + (43200 * 30), "/"); // 43200 = 30 minutes expiry time for the password

// creating function to set the cookie
if (!isset($_COOKIE[$cookie_password])) {
    // if the cookie isnt set print message saying "cookie isn't set"
    echo "The cookie named '" . $cookie_password . "' Cookie isn't set!";
} else { // otherwise close the if statement for setting the cookie for the password
    // otherwise print message saying cookie has been set
    echo "Cookie is:  '" . $cookie_password . "' The cookie has been set!<br>";
} // close else statment


// default values we show in the form
$username     = "";
$password     = "";
// strings to hold any validation error messages
$username_val = "";
$password_val = "";

// should we show the signup form?:
$show_signup_form = false;
// message to output to user: 
$message          = "";

// creating if statement to create session for logged in skeleton
if (isset($_SESSION['loggedInSkeleton'])) {
    // If the user is already logged in, just display a message; telling them to log in to view the page.
    echo "You are already logged in, please log out first<br>";
} // close if statment
elseif (isset($_POST['username'])) // creating else if for username
    {
    // user just tried to sign up: 
    // connect directly to our database (notice 4th argument) we need the connection for sanitisation
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to know, so allow this exit
    if (!$connection) {
        // if connection fails print message out saying "connecton failed" or send sqli connec error
        die("Connection failed: " . $mysqli_connect_error);
    } // close if statment for connection failed
    
    
    // SANITISATION (see helper.php for the function definition) 
    // take copies of the credentials the user submitted, and sanitise (clean) them: 
    $username = sanitise($_POST['username'], $connection);
    $password = sanitise($_POST['password'], $connection);
    
    // VALIDATION (see helper.php for the function definitions) 
    // Validating the different data (both strings must be between 1 and 16 characters long)
    // (reasons: we don't want empty credentials, and we used VARCHAR(16) in the database table).
    // validate username and password
    $username_val = validateString($username, 1, 16);
    $password_val = validateString($password, 1, 16);
    
    // concatenate all the validation results together ($errors will only be empty if ALL the data is valid)
    $errors = $username_val . $password_val;
    
    // check that all the validation tests have been passed before going to the database
    if ($errors == "") {
        
        // try to insert the new details
        // creating query to insert everything into the members table along with the values.
        $query  = "INSERT INTO members (username, password) VALUES ('$username', '$password');";
        // print the result
        $result = mysqli_query($connection, $query);
        
        // If there has been no data returned, we just test for true(success)/false(failure)
        if ($result) {
            // show a successful signup message
            $message = "Signup was successful, please sign in<br>";
        } // close if statement for result
        else // otherwise
            {
            // show the form: 
            $show_signup_form = true;
            // show an unsuccessful signup message
            $message          = "Sign up failed, please try again<br>";
        } // close else      
    } // close if statement for errors
    else // otherwise
        {
        // If the validation has failed, show the form again with guidance
        $show_signup_form = true;
        // SHowing an unsuccessful signup message
        $message          = "Sign up failed, please check the errors shown above and try again<br>";
    } // close else
    
    // close the connection 
    mysqli_close($connection);
} // close else if for usernames
else // otherwise
    {
    // show the signup form 
    $show_signup_form = true;
} // close else

//  Creating if statement o show the form
// in order to sign up the user would need to input there username and password and then they will be advised to log in using the username and password, which they created when signing up.
// version without client side validation.
if ($show_signup_form) {
    echo <<<_END
<form action="sign_up.php" method="post">
  Please choose a username and password:<br>
  Username: <input type="text" name="username" value="$username">
  <br>
  Password: <input type="password" name="password" value="$password">
  <br>
  <input type="submit" value="Submit">
</form>    
_END;
} else {
    // Creating if statement to show the form that allows users to sign up.
    // we use an HTTP POST request to avoid their password appearing in the URL:    
    // version with client side validation
    echo <<<_END
<form action="sign_up.php" method="post">
  Please choose a username and password:<br>
  Username: <input type="text" name="username" maxlength="16" value="$username" required> $username_val
  <br>
  Password: <input type="password" name="password" maxlength="16" value="$password" required> $password_val
  <br>
  <input type="submit" value="Submit">
</form>    
_END;
} // close of statement to show the sign up form

// Displaying the message to the user
echo $message;

// Finishing off the HTML for this page, by calling the footer page
require_once "footer.php";
?>

  </body>
</html>