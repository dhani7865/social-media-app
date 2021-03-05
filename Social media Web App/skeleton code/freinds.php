<!--- Adding stylesheet --->
<style>
<?php include 'stylesheet.css'; ?>
</style>

<?php // friends.php
// execute header.php file and helper.php file
  require_once 'header.php';
  require_once 'helper.php';
  

// should we show the set profile form?
// showing profile form as boolean value as false
$show_profile_form = false;
// message to output to user
$message = "";
// if statement for when logged in skeleton
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be logged in, in order to see the page
	echo "You must be logged in to view this page.<br>";
} // close if statment
else // otherwise
{
  if (isset($_GET['view'])) $view = sanitise($_GET['view']); // if statment to view all freinds and sanitise view
  else                      $view = $username; // otherwise view usernames
	// if statment for view username
  if ($view == $username)
  {
    $name1 = $name2 = "Your"; // print names
    $name3 =          "You are"; // print third name
  } // close if statment for view usernames
  else // otherwise
  {
    $name1 = "<a href='members.php?view=$view'>$view</a>'s"; // creating link to members.php file
    $name2 = "$view's"; // view name
    $name3 = "$view is"; // view third name
  } // close else

  echo "<div class='main'>"; // print message

  // Uncomment this line if you wish the user�s profile to show here
  // showProfile($view);

  $followers = array(); // creating array for followers
  $following = array(); // creating array for following

  $result = queryMysql("SELECT * FROM friends WHERE username='$view'"); // creating query
  $num    = $result->num_rows; // print number of rows
  
  // creating for loop
  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row           = $result->fetch_array(MYSQLI_ASSOC); // print result
    $followers[$j] = $row['friend']; // print all freinds that you have followed
  } // close for loop

  $result = queryMysql("SELECT * FROM friends WHERE friend='$view'"); // creating query
  $num    = $result->num_rows; // print number of rows
  
  // creating for loop
  for ($j = 0 ; $j < $num ; ++$j)
  {
      $row           = $result->fetch_array(MYSQLI_ASSOC);  // print result
      $following[$j] = $row['username']; // print all usernames that you have followed
  } // close for loop

  $mutual    = array_intersect($followers, $following); // all users who have mutual freinds
  $followers = array_diff($followers, $mutual); // all users that are followers
  $following = array_diff($following, $mutual); // all users that are following
  $friends   = FALSE;  // creating boolean value for freinds and setting it to false

  if (sizeof($mutual))
  {
    echo "<span class='subhead'>$name2 mutual friends</span><ul>";
    foreach($mutual as $friends)
      echo "<li><a href='members.php?view=$friends'>$friends</a>";
    echo "</ul>";
    $friends = TRUE;
  }

  if (sizeof($followers))
  {
    echo "<span class='subhead'>$name2 followers</span><ul>";
    foreach($followers as $friends)
      echo "<li><a href='members.php?view=$friends'>$friends</a>";
    echo "</ul>";
    $friends = TRUE;
  }

  if (sizeof($following))
  {
    echo "<span class='subhead'>$name3 following</span><ul>";
    foreach($following as $friends)
      echo "<li><a href='members.php?view=$friends'>$friends</a>";
    echo "</ul>";
    $friends = TRUE;
  }

  if (!$friends) echo "<br>You don't have any friends yet.<br><br>";

  echo "<a class='button' href='messages.php?view=$view'>" .
       "View $name2 messages</a>";
}
// finish of the HTML for this page:
require_once "footer.php";
?>

    </div><br>
  </body>
</html>