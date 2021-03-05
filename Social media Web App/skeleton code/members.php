<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>


<?php
// members.php file to show all members

// should we show the set profile form?:
$show_profile_form = false;
// message to output to user:
$message           = "";

if (!isset($_SESSION['loggedInSkeleton'])) {
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
} else {
    echo "<div class='main'>";
    
    if (isset($_GET['view'])) {
        $view = sanitise($_GET['view']);
        
        if ($view == $username)
            $name = "Your";
        else
            $name = "$view's";
        
        echo "<h3>$name Profile</h3>";
        show_profile($view);
        echo "<a class='button' href='messages.php?view=$view'>" . "View $name messages</a><br><br>";
        die("</div></body></html>");
    }
    
    if (isset($_GET['add'])) {
        $add = sanitise($_GET['add']);
        
        $result = queryMysql("SELECT * FROM friends WHERE username='$add' AND friend='$username'");
        if (!$result->num_rows)
            queryMysql("INSERT INTO friends VALUES ('$add', '$username')");
    } elseif (isset($_GET['remove'])) {
        $remove = sanitise($_GET['remove']);
        queryMysql("DELETE FROM friends WHERE username='$remove' AND friend='$username'");
    }
    
    $result = queryMysql("SELECT username FROM rnmembers ORDER BY username");
    $num    = $result->num_rows;
    
    echo "<h3>Other Members</h3><ul>";
    
    for ($j = 0; $j < $num; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row['username'] == $usernames)
            continue;
        
        echo "<li><a href='members.php?view=" . $row['username'] . "'>" . $row['usernaeme'] . "</a>";
        $follow = "follow";
        
        $result1 = queryMysql("SELECT * FROM friends WHERE
      username='" . $row['username'] . "' AND friend='$username'");
        $t1      = $result1->num_rows;
        $result1 = queryMysql("SELECT * FROM friends WHERE
      username='$username' AND friend='" . $row['username'] . "'");
        $t2      = $result1->num_rows;
        
        if (($t1 + $t2) > 1)
            echo " &harr; is a mutual friend";
        elseif ($t1)
            echo " &larr; you are following";
        elseif ($t2) {
            echo " &rarr; is following you";
            $follow = "username";
        }
        
        if (!$t1)
            echo " [<a href='members.php?add=" . $row['username'] . "'>$follow</a>]";
        else
            echo " [<a href='members.php?remove=" . $row['username'] . "'>drop</a>]";
    }
}



// finish of the HTML for this page:
require_once "footer.php";
?>