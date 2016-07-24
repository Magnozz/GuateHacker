<!DOCTYPE html>
<html>
<head>
	<title> MyFaceSpace: Add Friends </title>
</head>
<body>
<?php
session_start();

//to use CSS and header styles
require('header.php');

// If the user didn't login then redirect to login screen
if (!isset($_SESSION["login"]))
{
	header("Location: login.php");
	exit;
}

if(!isset($_GET['search']))
{
	echo "Search for a Friend";
}
else
{
	require('database.php');
	$mysqli = ConnectToDatabase();

	$search = $_GET["search"];
	$username = $_SESSION["username"];

	//get list of all friends
	$friends = "SELECT username1 FROM Friends WHERE username2 = '$username' UNION SELECT username2 FROM Friends WHERE username1 = '$username'"; 

	// Issue the query and output any error messages incurred
	$result = $mysqli->query($friends) or
	    die("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");

	    //Put's friends into an associative array
    while($row = $result->fetch_row())
    {
    	$friend[$row[0]] = $row[0];
    	//echo "HI <br>";
    }
   //echo "<pre>";
	//print_r($friend);
	//echo "</pre>";

	//Search the Users databae 
	$sql = "SELECT * FROM Users WHERE name LIKE '%$search%' ORDER BY name";

	// Issue the query and output any error messages incurred
	$result = $mysqli->query($sql) or
	    die("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");

	while ($row = $result->fetch_row())
	{
		if($row[0]!==$username)
		{	
		    echo "<img src=images/".$row[0]."_thumb.jpg alt='imageID'> $row[2] $row[3]</br>";

		    //if NOT friend add friend link
		    // use GET to send friend request
		    if(!isset($friend[$row[0]]))
		    {
		    	$add= $row[0];
		    	?> 
		    	<form method="GET" action="add_friend_db.php">
		    	<input type="hidden" name="add" value="<?php echo $add ?>">
		    	<input type="submit" value="Add Friend">
		    	</form>
		    	<?php
		    }
		    echo"</br> </br>";
		}
		
	}
	

}


?>

<h1> Add a Friend </h1>

<form method="GET">
<input type="text" name="search">
<input type="submit" value="Search">
</form>

</body>	
</html>