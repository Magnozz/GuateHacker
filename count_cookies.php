<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php

if(!isset($_COOKIE['count']))
{
	$cookie = 1;
	setcookie('count', $cookie);
	echo "Page views: $cookie";
}
else
{
	$cookie = ++ $_COOKIE['count'];
	setcookie('count',$cookie);
	echo "Page views: $_COOKIE[count]";
}

?>

</body>
</html>