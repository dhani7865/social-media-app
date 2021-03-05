<!--- Adding stylesheet --->
<style>
<?php include 'stylesheet.css'; ?>
</style>

<?php

// Things to notice:
// You need to add code to this script to implement the global feed
// A simple example has been included to show how you might display extra content/functionality to the admin

// execute the header script:
require_once "header.php";
include_once "helper.php";

// default value we show in the form: 
$messages = ""; 
// string to hold any validation error message: 
$messages_val = ""; 
// should we show the set favourite number form?: 
$show_set_form = false;
// message to output to user: 
$message = ""; 
// the minimum and maximum numbers we will allow  
// between -/+ 2 billion, which our database table can comfortably hold with a BIGINT,  
// HTML5 can validate on the client-side, and should be big enough for most users :-) 
$max_str = 200; 
$min_str = $max_str;

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
else
{
	// a little extra text that only the admin will see!:
	if ($_SESSION['username'] == "admin")
	{
		echo "[admin sees more!]<br>";
	}
	//echo "See the assignment specification for more details.<br>";
	
    // connect directly to our database (notice 4th argument) we need the connection for sanitisation: 
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname); 
	
	// if the connection fails, we need to know, so allow this exit: 
    if (!$connection) 
    { 
        die("Connection failed: " . $mysqli_connect_error); 
    }
    // SANITISATION (see helper.php for the function definition) 
    // take a copy of the value the user submitted and sanitise (clean): 
	if(isset($_POST['messages'])){
		$messages = sanitise($_POST['messages'], $connection);
}
	


    // VALIDATION (see helper.php for the function definitions) 
    // now validate the data (int must be between +/- 2 billion): 
    $messages_val = validateString($messages, $min_str, $max_str); 
     
    // concatenate all the validation results together ($errors will only be empty if ALL the data is valid): 
    $errors = $messages_val;
    
    // check that all the validation tests passed before going to the database: 
    if ($errors == "") 
    {     
        // read their username from the session: 
        $usernames = $_SESSION["username"]; 
         
        // now write their new posts to our database table... 
        // check to see if this user already had a post: 
        $query = "SELECT messages FROM posts WHERE username='$usernames'"; 
    
    	// this query can return data ($result is an identifier): 
        $result = mysqli_query($connection, $query); 
         
        // how many rows came back? (can only be 1 or 0 because username is the primary key in our table): 
        $n = mysqli_num_rows($result); 
        
        // if there was a match then UPDATE their posts, otherwise INSERT it: 
        if ($n > 0) 
        { 
            // we need an UPDATE (we use SYSDATE() to get the current server time): 
            $query = "UPDATE posts SET messages=$messages,posted=SYSDATE WHERE username='$usernames'"; 
            $result = mysqli_query($connection, $query);         
        }
        else 
        { 
            // we need an INSERT (we use SYSDATE() to get the current server time): 
            $query = "INSERT INTO posts (usernames, messages, posted, post_id) VALUES ('$usernames', $messages, SYSDATE, post_id)"; 
            $result = mysqli_query($connection, $query);     
        }
         // no data returned, we just test for true(success)/false(failure): 
        if ($result)  
        { 
            // show a successful update message: 
            $message = "Post successfully posted<br>"; 
        }  
        else 
        { 
            // show an unsuccessful update message: 
            $message = "Posted failed<br>"; 
        } 
    }
        else 
    { 
        // validation failed, show the form again with guidance: 
        $show_set_form = true; 
        // show an unsuccessful update message: 
        $message = "Update failed, please check the errors shown above and try again<br>"; 
    } 
     
    // we're finished with the database, close the connection: 
    mysqli_close($connection); 

}

if ($show_set_form)
{
// show the form that allows users to log in
// Note we use an HTTP POST request to avoid their password appearing in the URL:
if (isset($_GET['noval']))
	{
// a version WITHOUT client-side validation so that we can test server-side validation:
echo <<<_END
<form action="global_feed.php?noval=y" method="post">
  Enter your new post:<br>
  <input type="text" name="post" value=""> $messages_val
  <br>
  <input type="submit" value="Submit">
</form>	
_END;
	}
	else
	{
// a version WITH client-side validation:
echo <<<_END
<form action="global_feed.php" method="post">
  Enter your new post:<br>
	<input type="text" name="post" min="$min_str" max="$max_str" value="" required> $messages_val
  <br>
  <input type="submit" value="Submit">
</form>	
_END;
	} // close else
}

// display our message to the user:
echo $message;

// finish of the HTML for this page:
require_once "footer.php";
?>