<?php 

// connect the database
$connection = mysql_connect(dbhost, $dbuser, $dbpass, $dbname);

// if statment, if the connection fails, we would to need know and allow this exit
if (!$connection)
{
	die("The connection has failed: ". $nysql_connect__error);
} // close if statment for connection



// check if the form has been submitted
if (isset($_GET['username'])) {
	$username = $_GET['username'];
	$password = $_GET['password'];
	$name = $_GET['name'];

	// creating connection to the localhost
	mysql_connect("localhost","root","") or die ("Cannot connect to the server");
	// selecting the database
	mysql_select_db($connection, "skeleton") or die ("Cannot connect to the dataabse");
	
	// selecting the query for the query for the database
	// selecting the query for the query for the database
	$sql = "SELECT * FROM profiles;
	// print the result
	$result = $connection->query($sql);
	
	if (mysql_num_rows($sqlQuery != 1) {
		die ("That username could not be found!")
	} // close if statment

	// while statment for sql fetch array
	while($row = mysql_fetch_array($userquery, MYSQL_ASSOC)) {
			$firstname = $row ['firstname'];
			$lastname = $row ['lastname'];
			$pets = $row ['pets'];
			$email = $row ['email'];
			$dob = $row ['dob'];
			} // close while loop
			
			// if statment to check if the dbusername and username are same
			if ($username != $dbusername) {
				die ("There is an error, Please try again!");
			} // close if statment for the same usernames

		echo $firstname:
		echo $lastname:
		a profile<br />
		
		<table>
			<tr><td>firstname:</td><td>
			echo $firstname: </td></tr>
			<tr><td>lastname:</td><td>
			echo $lastname: </td></tr>
			<tr><td>pets:</td><td>
			echo $pets: </td></tr>
			<tr><td>email:</td><td>
			echo $email: </td></tr>
			<tr><td>dob:</td><td>
			echo $dob: </td></tr>
		</table>
		
} else die ("You need to specify a username, password and name!");
?>