<!DOCTYPE html>
<html>
  <head>
    <title>Setting up databases</title>
  </head>
<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>
  <body>

<?php
// calling the header.php file
require_once "header.php";

// Creating the database (currently called "skeleton"
// Creating all the tables I will need inside my database, for example, Members, Profiles, Posts and Freinds.
// I have also created suitable test data for each of those tables 

// calling the credentials file
require_once "credentials.php";

// I have used the procedural mysqli calls

// connecting to the host
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful (error) message if there was an error.
if (!$connection) {
    die("Connection failed: " . $mysqli_connect_error);
} // close connection

// Building a statement to create a new database
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data has been returned, I eould then just test for true(success)/false(failure)
if (mysqli_query($connection, $sql)) {
    echo "Database created successfully, or already exists<br>";
} // close if statment for mysqli_query.
else // otherwise return error message
    {
    die("Error creating database: " . mysqli_error($connection));
} // close else statment

// Connecting to the database
mysqli_select_db($connection, $dbname);

///////////////////////////////////////////
////////////// MEMBERS TABLE //////////////
///////////////////////////////////////////

// if there's an old version of the table, then drop it
$sql = "DROP TABLE IF EXISTS members";

// If no data has been returned, I will just test for true(success)/false(failure)
if (mysqli_query($connection, $sql)) {
    echo "Dropped existing table: members<br>";
} // close if  statement mysqli_query 
else // otherwise reutrn error message
    {
    die("Error checking for existing table: " . mysqli_error($connection));
} // close else

// Creating the members table
$sql = "CREATE TABLE members (username VARCHAR(16), password VARCHAR(16), PRIMARY KEY(username))";

// If no data has been returned, then just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
    echo "Table created successfully: members<br>";
} //  close if statement mysqli_query
else // otherwise return error message
    {
    die("Error creating table: " . mysqli_error($connection));
} // close else

// Putting some data in the members table:
// Creating the user logins and passwords for the different users
$usernames[] = 'barryg';
$passwords[] = 'letmein';
$usernames[] = 'mandyb';
$passwords[] = 'abc123';
$usernames[] = 'mathman';
$passwords[] = 'secret95';
$usernames[] = 'brianm';
$passwords[] = 'test';
$usernames[] = 'a';
$passwords[] = 'test';
$usernames[] = 'b';
$passwords[] = 'test';
$usernames[] = 'c';
$passwords[] = 'test';
$usernames[] = 'd';
$passwords[] = 'test';
$usernames[] = 'dhanyaal';
$passwords[] = 'dhani786';
$usernames[] = 'dhanyaal123';
$passwords[] = '123456';
// creating account for the admin
$usernames[] = 'admin';
$passwords[] = 'secret';



// looping through the arrays and adding rows to the table
for ($i = 0; $i < count($usernames); $i++) {
    // creating query to insert rows into the table
    $sql = "INSERT INTO members (username, password) VALUES ('$usernames[$i]', '$passwords[$i]')";
    
    // If no data rhas been eturned, then just test for true(success)/false(failure)
    if (mysqli_query($connection, $sql)) {
        echo "row inserted<br>"; // print message "row has been inserted"
    } // close if statement for mysqli_query
    else // otherwise, return error message
        {
        die("Error inserting row: " . mysqli_error($connection));
    } // close else
}

////////////////////////////////////////////
////////////// PROFILES TABLE //////////////
////////////////////////////////////////////

// if there's an old version of the profiles table, then drop it:
$sql = "DROP TABLE IF EXISTS profiles";

// If no data has been returned, then just test for true(success)/false(failure)
if (mysqli_query($connection, $sql)) {
    echo "Dropped existing table: profiles<br>";
} // close if statement mysqli_query
else // otherwise, return an error
    {
    die("Error checking for existing table: " . mysqli_error($connection));
} // close else

// Creating the profiles table
$sql = "CREATE TABLE profiles (username VARCHAR(16), firstname VARCHAR(40), lastname VARCHAR(50), pets TINYINT, email VARCHAR(50), dob DATE, PRIMARY KEY (username))";

// If no data has been returned, then just test for true(success)/false(failure)
if (mysqli_query($connection, $sql)) {
    echo "Table created successfully: profiles<br>";
} // close if statement mysqli_query
else // otherwise, return an error
    {
    die("Error creating table: " . mysqli_error($connection));
} // close else

// Putting data into the profiles table
// Creating the profile usernames, firstnames, lastnames, pets, emals and pets
$usernames    = array(); // clear this array, as it has already been used above
$usernames[]  = 'barryg';
$firstnames[] = 'Barry';
$lastnames[]  = 'Grimes';
$pets[]       = 5;
$emails[]     = 'baz_g@outlook.com';
$dobs[]       = '1961-09-25';
$usernames[]  = 'mandyb';
$firstnames[] = 'Mandy';
$lastnames[]  = 'Brent';
$pets[]       = 3;
$emails[]     = 'mb3@gmail.com';
$dobs[]       = '1988-05-20';
$usernames[]  = 'dhanyaal123';
$firstnames[] = 'dhanyaal';
$lastnames[]  = 'rashid';
$pets[]       = 0;
$emails[]     = 'dhanyaal@gmail.com';
$dobs[]       = '1995-07-09';
$usernames[]  = 'admin';
$firstnames[] = 'admin';
$lastnames[]  = 'rashid';
$pets[]       = 0;
$emails[]     = 'admin@gmail.com';
$dobs[]       = '1992-07-09';

// looping through the arrays and adding rows to the table
for ($i = 0; $i < count($usernames); $i++) {
    // creating query to insert rows into the profiles table
    $sql = "INSERT INTO profiles (username, firstname, lastname, pets, email, dob) VALUES ('$usernames[$i]', '$firstnames[$i]', '$lastnames[$i]', $pets[$i], '$emails[$i]', '$dobs[$i]')";
    
    // If no data has been returned, then just test for true(success)/false(failure)
    if (mysqli_query($connection, $sql)) {
        echo "row inserted<br>"; // prnt message row has been inserted
    } // close if statement for mysqli_query
    else {
        die("Error inserting row: " . mysqli_error($connection));
    } // close else
}

// creating posts table
////////////////////////////////////////////
////////////// POSTS TABLE //////////////
////////////////////////////////////////////

// if there's an old version of the posts table, then drop it
$sql = "DROP TABLE IF EXISTS posts";

// If no data has beenreturned, then just test for true(success)/false(failure)
if (mysqli_query($connection, $sql)) {
    echo "Dropped existing table: posts<br>";
} // close if statement for mysqli_query
else // otherwise, return an error message
    {
    die("Error checking for existing table: " . mysqli_error($connection));
} // close else

// Creating the posts table:
$sql = "CREATE TABLE posts ( username VARCHAR(16), message VARCHAR(160), updated DATETIME, likes INT DEFAULT 0, PRIMARY KEY (username))";

// If no data has been returned, then just test for true(success)/false(failure)
if (mysqli_query($connection, $sql)) {
    echo "Table created successfully: posts<br>";
} // close if statement for mysqli_query
else // otherwise return an error message
    {
    die("Error creating table: " . mysqli_error($connection));
} // close else

// Putting some data in the posts table:
// Inputting data into the posts table
$usernames   = array(); // clear this array (as we already used it above)
$usernames[] = 'barryg';
$messages[]  = 'hi';
$updates[]   = '2017/11/26 16:23:12';
$usernames[] = 'mandyb';
$messages[]  = 'How are you?';
$updates[]   = '2017/11/27 16:30:12';
$usernames[] = 'mathman';
$messages[]  = "good what about you?";
$updates[]   = '2017/11/27 16:35:00';
$usernames[] = 'brianm';
$messages[]  = 'What uni course you doing?';
$updates[]   = '2017/11/28 16:40:20';
$usernames[] = 'a';
$messages[]  = 'What football team do you support?';
$updates[]   = '2917/11/28 17:00:05';
$usernames[] = 'b';
$messages[]  = 'Man Utd what about you?';
$updates[]   = '2017/11/28 17:10:12';
$usernames[] = 'c';
$messages[]  = 'Same';
$updates[]   = '2017/11/28 17:15:12';
$usernames[] = 'd';
$messages[]  = 'I am doing software enginerring wbu';
$updates[]   = '2017/11/29 17:20:15';
$usernames[] = 'dhanyaal123';
$messages[]  = 'U ok';
$updates[]   = '2018/01/12 17:20:15';
$usernames[] = 'dhani123';
$messages[]  = '"a" how are you?';
$updates[]   = '2018/01/01 17:20:15';

// counting the different rows and echoing out hte row numbers
echo count($usernames) . "<br>";
echo count($messages) . "<br>";
echo count($updates) . "<br>";

// looping through the arrays and adding rows to the table
for ($i = 0; $i < count($usernames); $i++) {
    // creating query to insert rows into the posts table
    $sql = "INSERT INTO posts (username, message, updated) VALUES ('$usernames[$i]', '$messages[$i]', '$updates[$i]')";
    
    // If no data has been returned, then just test for true(success)/false(failure)
    if (mysqli_query($connection, $sql)) {
        echo "row inserted<br>"; // print row inserted
    } // close if statement mysqli_query
    else // otherwise, return an error message
        {
        die("Error inserting row: " . mysqli_error($connection));
    } //  close else
}

// freinds table
////////////////////////////////////////////
////////////// freinds TABLE //////////////
////////////////////////////////////////////
// if there's an old version of the freinds table, then drop it
$sql = "DROP TABLE IF EXISTS freinds";

// §If no data has been returned, then just test for true(success)/false(failure)
if (mysqli_query($connection, $sql)) {
    echo "Dropped existing table: freinds<br>";
} // close if statement for mysqli_query
else // otherwise return error message
    {
    die("Error checking for existing table: " . mysqli_error($connection));
} // close else

// Creating thr freinds table
$sql = "CREATE TABLE freinds (usernames VARCHAR(16), freind VARCHAR(16))";

// If no data has been returned, then just test for true(success)/false(failure)
if (mysqli_query($connection, $sql)) {
    echo "Table created successfully: freinds<br>";
} // close ifn statement for mysqli_query
else // otherwise return error message
    {
    die("Error creating table: " . mysqli_error($connection));
} // close else

// put some data in the freinds table
// input usernames and freinds to the table
$usernames   = array(); // clear this array, as it has already been used
$usernames[] = 'barryg';
$freind[]    = 'barryg';
$usernames[] = 'mandyb';
$freind[]    = 'mandyb';
$usernames[] = 'mathman';
$freind[]    = 'mathman';
$usernames[] = 'brianm';
$freind[]    = 'brianm';
$usernames[] = 'a';
$freind[]    = 'a';
$usernames[] = 'b';
$freind[]    = 'b';
$usernames[] = 'c';
$freind[]    = 'c';
$usernames[] = 'd';
$freind[]    = 'd';
$usernames[] = 'dhanyaal123';
$freind[]    = 'dhanyaal123';

// counting the rows
echo count($usernames) . "<br>";
echo count($freind) . "<br>";



// looping through the arrays and adding rows to the table
for ($i = 0; $i < count($usernames); $i++) {
    // creating query to insert rows into the freinds table
    $sql = "INSERT INTO freinds (usernames, freind) VALUES ('$usernames[$i]', '$freind[$i]')";
    
    // if no data has been returned, then just test for true(success)/false(failure)
    if (mysqli_query($connection, $sql)) {
        echo "row inserted<br>"; // row has been inserted
    } // close if  statement for mysqli_query
    else // otherwise reutrn error message
        {
        die("Error inserting row: " . mysqli_error($connection));
    } // close else
}



// we're finished, close the connection:
mysqli_close($connection);
?>
   <br>...done.
  </body>
</html>