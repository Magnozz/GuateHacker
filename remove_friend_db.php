<!DOCTYPE html>
<html>
<head>
	<title> MyFaceSpace: Remove Friends </title>
</head>
<body>
<?php	
session_start();
// If the user didn't login then redirect to login screen
if (!isset($_SESSION["login"]))
{
	header("Location: login.php");
	exit;
}

$username1 = $_SESSION["username"];
$username2 = $_GET["remove"];

require('database.php');
	$mysqli = ConnectToDatabase();

//Delete the friendship
$sql = "DELETE FROM Friends WHERE (username1='$username1' AND username2='$username2') OR
 (username1='$username2' AND username2='username1')";

// Issue the query and output any error messages incurred
$result = $mysqli->query($sql) or
    die("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
 
header("Location: index.php");

?>
</body>	
</html>