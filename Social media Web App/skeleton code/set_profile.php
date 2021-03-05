<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>

<h1>SET PROFILE</h1>


<?php

// The main job of this script is to execute an INSERT or UPDATE statement to create or update a user's profile information.
// ... but only once the data the user supplied has been validated on the client-side, and then sanitised ("cleaned") and validated again on the server-side
// Both sign_up.php and sign_in.php do client-side validation, followed by sanitisation and validation again on the server-side
// HTML5 can validate all the profile data on the client-side
// The PHP functions in helper.php will allow you to sanitise the data on the server-side and validate the fields.
// ... but you'll also need to add some new PHP functions of your own to validate email addresses and dates
// $_POST is an array of variables 
/*
All data which is sent from a form with the POST method would be invisible to others and all names/values would be
embedded within the body of the HTTP request.
*/

// execute the header script:
require_once "header.php";
// this would call the helper.php file
include_once "helper.php";

// default values we show in the form
$firstname     = "Dhanyaal";
$lastname      = "Rashid";
$pets          = "none";
$email         = "dh11any@hotmail.com";
$dob           = "09-07-1995";
// strings to hold any validation error messages
$firstname_val = "";
$lastname_val  = "";
$pets_val      = "";
$email_val     = "";
$dob_val       = "";


// should we show the set profile form?:
// also setting a boolean value as false for show_profile_form
$show_profile_form = false;
// message to output to user
$message           = "";
$maxlength         = 200; // maximum length up to  200
$minlength         = 0; // minimum  of the email is set to 0

// if statment for logged in skeleton
if (!isset($_SESSION['loggedInSkeleton'])) {
    // user isn't logged in, display a message saying they must be logged in in order to see the page.
    echo "You must be logged in to view this page.<br>";
} // close if  statment
elseif (isset($_POST['firstname'])) // else  if for firstname
    {
    // user just tried to update their profile
    // connect directly to our database we need the connection for sanitisation
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to know, so allow this exit
    if (!$connection) {
        // printing out an error message if the connection fails
        die("Connection failed: " . $mysqli_connect_error);
    } // close if statment for connection failed
    
    // SANITISATION
    //$str = sanitise($str, $connection);
    // santisation for the first name and creating connection
    $firstname = sanitise($_POST['firstname'], $connection);
    // santisation for the lastname and creating connection
    $lastname  = sanitise($_POST['lastname'], $connection);
    // santisation for the pets and creating connection
    $pets      = sanitise($_POST['pets'], $connection);
    // santisation for the email and creating connection
    $email     = sanitise($_POST['email'], $connection);
    // santisation for the dob and creating connection
    $dob       = sanitise($_POST['dob'], $connection);
    
    // post the firstname, lastname, pets, email and dob
    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $pets      = $_POST['pets'];
    $email     = $_POST['email'];
    $dob       = $_POST['dob'];
    
    // VALIDATION
    // Validating the data (both strings must be between 1 and 16 characters long)
    // I have used VARCHAR(16) in the database table)
    // validating the firstname, lastname, pets, email and dob
    $firstname_val = validateString($firstname, 1, 16);
    $lastname_val  = validateString($lastname, 1, 16);
    $pets_val      = validateInt($pets, 0, 128);
    $email_val     = validateEmail($email, 1, 50); // validateEmail()
    $dob_val       = validateDate($dob, 1, 10); // validateDate() - validating the dob
    
    // concatenate all the validation results together ($errors will only be empty if ALL the data is valid)
    $errors = $firstname_val . $lastname_val . $pets_val . $email_val . $dob_val;
    
    
    $errors = ""; // creating variable for  errors
    // check that all the validation tests passed before going to the database
    if ($errors == "") {
        // read their username from the session
        $username = $_SESSION["username"];
        
        // Now write the new data to our database table.
        // check to see if this user already had a message
        // select everything from profiles table and checking for matching username
        $query = "SELECT * FROM profiles WHERE username='$username'";
        
        // this query can return data ($result is an identifier)
        $result = mysqli_query($connection, $query);
        
        // how many rows came back? (can only be 1 or 0 because username is the primary key in the table)
        $n = mysqli_num_rows($result);
        
        // if there was a match then UPDATE the profile data, otherwise INSERT it:
        if ($n > 0) {
            // I have created an UPDATE, to update the dataabse
            $query  = "UPDATE profiles SET firstname='$firstname',lastname='$lastname',pets=$pets,email='$email',dob='$dob' WHERE username='$username'";
            $result = mysqli_query($connection, $query); // print result        
        } // close if statment
        else // otherwise
            {
            // I have created an INSERT to insert rows into the database and the values
            $query  = "INSERT INTO profiles (username,firstname,lastname,pets,email,dob) VALUES ('$username','$firstname','$lastname',$pets,'$email','$dob')";
            $result = mysqli_query($connection, $query); // print the result    
        } // close else
        
        // If no data has been returned, then just test for true(success)/false(failure)
        if ($result) {
            // showing a successful update message
            $message = "Profile successfully updated<br>";
        } // close if statment for result
        else // otherwise
            {
            // showing the set profile form
            $show_profile_form = true;
            // show an unsuccessful update message:
            $message           = "Update failed<br>";
        } // close else
    } // close if statment for errors
    else // otherwise
        {
        // validation failed, show the form again with guidance
        $show_profile_form = true;
        // show an unsuccessful update message
        $message           = "Update failed, please check the errors above and try again<br>";
    } // close else
    
    // close the connection
    mysqli_close($connection);
} // close else
else // otherwise
    {
    // arrived at the page for the first time, show any data already in the table
    // read the username from the session
    $username = $_SESSION["username"];
    
    // Reading their profile data from the table.
    // connect directly to our database (notice 4th argument)
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // if the connection fails, we need to know, so allow this exit
    if (!$connection) {
        // print out conection failed
        die("Connection failed: " . $mysqli_connect_error);
    } // close if statement for connection failed
    
    // check for a row in our profiles table with a matching username
    //  creating sql query to select everything from profiles where usernames
    $query = "SELECT * FROM profiles WHERE username='$username'";
    
    // this query can return data, for example, the $result is an identifier:
    $result = mysqli_query($connection, $query);
    
    // only 1 or 0 rows can be returned because username is the primary key in our table):
    $n = mysqli_num_rows($result);
    
    // if there was a match then extract their profile data
    if ($n > 0) {
        // use the identifier to fetch one row as an associative array.
        //  Elements are named after columns
        $row       = mysqli_fetch_assoc($result);
        // Extracting the different profile data for use in the HTML
        $firstname = $row['firstname'];
        $lastname  = $row['lastname'];
        $pets      = $row['pets'];
        $email     = $row['email'];
        $dob       = $row['dob'];
    }
    
    // show the set profile form
    $show_profile_form = true;
    
    // close the connection
    mysqli_close($connection);
    
} // close else
// input the ! (not) for the server side)
// creating form for set profile
// allowing the user to input the different fields
// it also shows calender for the user to select there dob
if ($show_profile_form) {
    if (isset($_GET['noval'])) {
        // version without client side validation
        echo <<<_END
<form action="set_profile.php" method="post">
  Update your profile info:<br>
  First name: <input type="text" name="firstname" value="$firstname">  firstname_val
  <br>
  Last name: <input type="text" name="lastname" value="$lastname">  lastname_val
  <br>
  Pets: <input type="text" name="pets" value="$pets"> echo $pets_val
  <br>
  Email address: <input type="text" name="email" value="$email"> email_val
  <br>
  Date of birth: <input type="text" name="dob" value="$dob"> dob_val
  <br>
  <input type="submit" value="Submit">
</form>    
_END;
    } else {
        // a version WITH client-side validation
        echo <<<_END
   <form action="set_profile.php" method="post">
    Update your profile info:<br>
    First name: <input type="text" name="firstname" maxlength="16" value="$firstname" required> $firstname_val
    <br>
    Last name: <input type="lastname" name="lastname" maxlength="16" value="$lastname" required> $lastname_val
    <br>
    Pets: <input type="pets" name="pets" maxlength="128" value="$pets" required> $pets_val
    <br>
    Email address:: <input type="email" name="email" maxlength="50" value="$email" required> $email_val
    <br>
    Date of birth: <input id="date" type="date" name="dob"  value="$dob" required> $dob_val
    <br>
    <input type="submit" value="Submit">
    </form>    
_END;
    }
}


// display our message to the user
echo $message;

// Finishing off the HTML for this page, by calling the footer page
require_once "footer.php";
?>