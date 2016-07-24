<!-- http://taz.harding.edu/~msorrell1/My_FaceSpace/ -->

<!DOCTYPE html>
<html>
<head>
    <title> MyFaceSpace </title> 
</head>
<body>
<?php 

session_start();
require("header.php");

// If the user didn't login then redirect to login screen
if (!isset($_SESSION["login"]))
{
	header("Location: login.php");
	exit;
}

$username = $_SESSION["username"];

//Connect to database
$mysqli = new mysqli("localhost", "msorrell1", "H01550617", "msorrell1");
if($mysqli-> connect_errno)
	die("Failed to connect to database"); 

// Grab name, status, and time from database
$sql = "SELECT name, status, updatetime FROM Users WHERE username='$username'"; 

// Issue the query and output any error messages incurred
$result = $mysqli->query($sql) or
    die("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
 

 //Add user's image
echo "<img src=images/".$username.".jpg alt='userImage'>";
// Loop through all the rows returned by the query
$row = $result->fetch_row();
    //Call nicetime
    
    echo "<h1>$row[0]</h1> <p><strong>$row[1]</strong> ";
    $result = nicetime($row[2]);
    echo "<em>$result</em> </p> <br>";

//Get status    
?>
<form method= "POST" action="set_status.php">
<input type="text" name="status">
<input type="submit" value="Share"> </br>
</form>
<?php

//Get and List Friends
echo "</br> Your Friends: <br>";

$sqlFriends = "SELECT * FROM
 (SELECT u.username, u.name, u.status, u.updatetime FROM Users u, Friends f WHERE
 f.username1='$username' AND f.username2 = u.username UNION
 SELECT u.username, u.name, u.status, u.updatetime FROM Users u, Friends f WHERE
 f.username2='$username' AND f.username1 = u.username) temp ORDER BY updatetime DESC";

// Issue the query and output any error messages incurred
$result = $mysqli->query($sqlFriends) or
    die("Error executing query: ($mysqli->errno) $mysqli->error<br>SQL = $sql");

while ($row = $result->fetch_row())
{
    echo "<img src='images/$row[0]_thumb.jpg' atl='userThumbnail'>";
    echo "<strong>$row[1]</strong> $row[2] ";
    $time = nicetime($row[3]);
    if($time !== "No date provided")
    {
        echo "<em>$time</em>";
    }
    $remove= $row[0];
    ?>
    <form method="GET" action="remove_friend_db.php" id="rFriend">
    <input type="hidden" name="remove" value="<?php echo $remove ?>">
    <input type="submit" value="Remove Friend" id="removeFriend" onclick="return confirm('Are you sure you want to remove this friend');">
    </form>
    <?php
    echo "</br>";
}


//Time Function
function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date         = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}


?>
<a href ="edit_account.php">Edit Account</a></br>
<a href="add_friends.php">Add Friends</a></br>
<a href="logout.php">Logout</a></br>

</body>
</html>