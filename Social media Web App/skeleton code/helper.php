<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>

<?php

// This script holds the sanitisation function that we pass all our user data to
// This script holds the validation functions that double-check our user data is valid
// Some of the functions used by set_profile.php have been hidden in helper2.php and left as a lab exercise

// include extra server-side validation functions for email, petsßßß and date (left as a lab exercise):
//require_once "helper2.php";

// function to sanitise (clean) user data:
function sanitise($str, $connection)
{
    if (get_magic_quotes_gpc()) {
        // just in case server is running an old version of PHP with "magic quotes" running:
        $str = stripslashes($str);
    }
    // escape any dangerous characters, e.g. quotes:
    $str = mysqli_real_escape_string($connection, $str);
    // ensure any html code is safe by converting reserved characters to entities:
    $str = htmlentities($str);
    // return the cleaned string:
    return $str;
} // close function for sanitise

// if the data is valid return an empty string, if the data is invalid return a help message for validate string
function validateString($field, $minlength, $maxlength)
{
    if (strlen($field) < $minlength) {
        // wasn't a valid length, return a help message:        
        return "Minimum length: " . $minlength;
    } elseif (strlen($field) > $maxlength) {
        // wasn't a valid length, return a help message:
        return "Maximum length: " . $maxlength;
    }
    // data was valid, return an empty string:
    return "";
} // close function validate string

// if the data is valid return an empty string, if the data is invalid return a help message
function validateInt($field, $min, $max)
{
    // see PHP manual for more info on the options: http://php.net/manual/en/function.filter-var.php
    $options = array(
        "options" => array(
            "min_range" => $min,
            "max_range" => $max
        )
    );
    
    if (!filter_var($field, FILTER_VALIDATE_INT, $options)) {
        // wasn't a valid integer, return a help message:
        return "Not a valid number (must be whole and in the range: " . $min . " to " . $max . ")";
    }
    // data was valid, return an empty string:
    return "";
} // close function for validate int

// validating email
// if the data is valid return an empty string, if the data is invalid return a help message
function validateEmail($email, $minlength, $maxlength)
{
    // creating email variable to check the length of the email
    $email  = 'garahasgcdotrrriefvdqvegtartfhpnlwizanrhcqirnqllicyjhttvdylvkqccpljzrgledgqpjbttgwbqwgtkytkjxtufqcermdywzthceowyurrlmvvbiljraidwnmznazymwcjdozfaauzcnlwsxqfzgpzbsru1234567890ukxzqsvowzhnwnzzdzokhcffkpdvwycpcmxdknjvaakqjgjkvtqctpkhvgmeytsypkrfozeljsochfjvlszrwutiq';
    // creating the lengths of the email
    // if you  increase $domain or $com, it fails
    // ength of domain can go up to 254.
    $local  = substr($email, 0, 64);
    $domain = substr($email, 0, 63);
    $com    = substr($email, 0, 63);
    
    $email = $local . '@' . $domain . '.' . $com;
    
    // ! ! not
    // uf statement for filter var which would validatebthe email
    // if its valid email, it will return valid email
    // if its not valid email it will return invalid email
    // The filter_var() function filters a variable with the specified filter (FILTER_VALIDATE_EMAIL)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "This email is Invalid."; // print error message
    }
    // data was valid, return empty string:
    return "";
} // close function validate email


// if the data is valid return an empty string, if the data is invalid return a help message
// validating dob
// http://php.net/manual/en/function.checkdate.php
// filter_var is a variable with a specified filter
// creating function for validateDate
// to  test server side;
// shttp://localhost/skeleton%20code/set_profile.php?noval=y
function validateDate($field)
{
    
    // I have used the checkdate() function (because filter_var can't validate dates)
    // I have got these 3 parameters out of the data that comes back from your html4 format
    // variables for date and setting it a date
    //$date = '2011-12-25';
    // THE PHP EXPLODE() FUNCTION SPLITS UP THE DATE THAT COMES BACK FROM THE HTML5 FORM INTO A DAY, MONTH AND YEAR
    // also created an arrray to store the date
    $date  = array();
    $date  = explode("-", $field);
    // the different date fields in the correct order
    $year  = $date[0];
    $month = $date[1];
    $day   = $date[2];
    
    
    // CHECKDATE ACCEPTS 3 PARAMETERS: A DAY, A MONTH, AND A YEAR (BUT NOT NECESSARILY IN THAT ORDER)
    if (!checkdate($month, $day, $year)) { //echo "invalid Date Of Birth, PLEASE ENTER DOB IN DD-MM-Y FORMAT!";
        return "Valid Date"; // data was valid, return Valid date
    } else {
        // THIS WOULD THEN RETURN AN ERROR
        return "invalid Date Of Birth, PLEASE ENTER DOB IN DD-MM-Y FORMAT!";
    } // close else
} // close function
?>