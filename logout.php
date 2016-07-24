<!DOCTYPE html>
<html>
<head>
	<title> MyFaceSpace: Logout </title>
</head>
<body>
<?php

//to use CSS and header styles
require('header.php');

session_start();
session_destroy();

//Add link or redirect
echo "You have logged out!";
echo "<a href='login.php'>Login</a>";

?>


</body>	
</html>