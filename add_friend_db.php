<!DOCTYPE html>
<html>
<head>
	<title> MyFaceSpace: Logout </title>
</head>
<body>
<?php
session_start();
//to use CSS and header styles
require('header.php');
require('database.php');
	$mysqli = ConnectToDatabase();

// If the user didn't login then redirect to login screen
if (!isset($_SESSION["login"]))
{
	header("Location: login.php");
	exit;
}

$username1 = $_SESSION["username"];
$username2 = $_GET['add'];

$sql = "INSERT INTO Friends VALUES ('$username1', '$username2')"; 

$result = $mysqli->query($sql) or
	    die("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");

header("Location: index.php");


?>

</body>	
</html>