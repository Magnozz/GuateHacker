<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php

session_start();

if(!isset($_SESSION["count"]))
	{
		$_SESSION["count"] = 1;
	}
else
{
	$_SESSION["count"] ++;
}

echo "Page views: $_SESSION[count]";

?>

</body>
</html>