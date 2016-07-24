<!DOCTYPE html>
<html>
<head>
	<title> MyFaceSpace: Login </title> 
</head>
<body>

<?php
session_start();
//to use CSS and header styles
require('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	?>

	<form method="post">

	Username? <input type="text" name="username" autofocus="autofocus"><br/>
	Password? <input type="password" name="password"><br/> <br/>

	<a href="create_account.php">Create an Account</a> <br/> <br/>

	<input type="submit" value="Login"> <br/>

	<!-- Create an account -- >
	</form>
	<?php 

}
else
{
	require('database.php');
	$mysqli = ConnectToDatabase();
	
	// Get the user's info from the Users table
	$sql = "SELECT * FROM Users WHERE username = '$_POST[username]'";
	
	$result = $mysqli->query($sql) or die("Error");
	
	// Modified if statement in index.php
	if ($result->num_rows == 0)
	{
		echo "Wrong username</br>";
		echo "<a href='login.php'>Login</a>"; 
	}
	else
	{
		$row = $result->fetch_assoc();
			
		// See if md5 of password is MD5 hash from the database
		if (md5($_POST['password']) == $row["password"])
		{
			//echo "Correct password!";
			
			// Set a login session variable
			$_SESSION["login"] = "true";
			
			// Save the username in a session var
			$_SESSION["username"] = $_POST['username'];
			
			// Redirect the user to the main page
			header("Location: index.php");
		}
		else
		{
			echo "Wrong Password</br>";
			echo "<a href='login.php'>Login</a>"; 
		}		
	}
}
?>
</body>
</html>