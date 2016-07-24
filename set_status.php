<!DOCTYPE html>
<html>
<head>
	<title> MyFaceSpace: Set status </title>
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

require('database.php');
	$mysqli = ConnectToDatabase();


$status = $_POST["status"];
$username = $_SESSION["username"];

echo "$username <br>";
echo "$status <br>";


$sql = "UPDATE Users SET status='$status', updatetime=NOW() WHERE username='$username'";

// Issue the query and output any error messages incurred
$result = $mysqli->query($sql) or
    die("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");

header("Location: index.php");

?>
</body>	
</html>