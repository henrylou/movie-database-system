<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<font color="black" face="Palatino">
<head>
	<title>Add Movie Comment</title>
	<h1 align="center">Add Movie Comment</h1>
</head>

<body background="./home.jpg">
	<table align="center" cellpadding="10px">
	<tr>
		<td><a href="I1.php">Add New Actor or Director</a></td>
		<td><a href="I2.php">Add New Movie</a></td>
		<td><a href="I3.php">Add New Movie Review</a></td>
		<td><a href="I4.php">Add New Actor to Movie</a></td>
	</tr>
	<tr>
		<td><a href="I5.php">Add New Director to Movie</a></td>
		<td><a href="B1.php">Show Actor Information</a></td>
		<td><a href="B2.php">Show Movie Information</a></td>
		<td><a href="S1.php">Search</a></td>
	</tr>
	</table>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table align="center" cellpadding="10px">
<tr><td>
<label class="field" for="movie">Movie: </label>
<SELECT NAME="movie">
    <?php
    $db = mysqli_connect('localhost', 'cs143', '', 'CS143'); // TEST-->CS143 / submission
    if($db->connect_errno > 0) die('Unable to connect to database [' . $db->connect_error . ']');

    if ($_GET["ref"] == 1) {
    	$movie = $_GET["movie"];
    	$rs_movie = $db->query("SELECT id, title, year FROM Movie WHERE id=$movie;") or die(mysql_error());
    	$arr = mysqli_fetch_array($rs_movie);
    	$id = $arr["id"];
    	$title = $arr["title"];
    	$year = $arr["year"];
    	echo "<option value=$id>$title ($year) </option>";
    }
    else {
        $rs_movie = $db->query("SELECT id, title, year FROM Movie ORDER BY title;") or die(mysql_error());
        while ($arr = mysqli_fetch_array($rs_movie)) {
            $id = $arr["id"];
        	$title = $arr["title"];
        	$year = $arr["year"];
        	echo "<option value=$id>$title ($year) </option>";
        }
    }
    $rs_movie->free();
    $db->close();
    ?>
</SELECT>
</td></tr>

<tr><td>
<label class="field" for="rating">Rating: </label>
<SELECT NAME="rating">
    <OPTION value=5 SELECTED>5 Stars</OPTION>
    <OPTION value=4>4 Stars</OPTION>
    <OPTION value=3>3 Stars</OPTION>
    <OPTION value=2>2 Stars</OPTION>
    <OPTION value=1>1 Star</OPTION>
</SELECT>
</td></tr>
<tr><td>
<label class="field" for="name">Name: </label>
<input type="text" name="name" size="20" maxlength="20" value="<?php echo htmlspecialchars($_GET['name']);?>" placeholder="User Name">
</td></tr>
<tr><td>
<label class="field" for="comment">Comment: </label>
<TEXTAREA style="vertical-align: top;" name='comment' maxlength="400" ROWS=8 COLS=60 placeholder="Leave your comment here (Max: 400)"><?php echo htmlspecialchars($_GET['comment']);?></TEXTAREA>
</td></tr>
<tr><td>
	<div style="clear:both;padding:5px;" align="center"><input type="submit" value="Rate"></div>
</td></tr>
</table>
</form>

<?php
$mid = $_GET["movie"];
$rating = $_GET["rating"];
$name = trim($_GET["name"]);
$comment = trim($_GET["comment"]);
$time = date('Y-m-d G:i:s');

echo '<p align="center">';

if ($mid == "" && $rating == "" && $name == "" && $comment == "") echo "Please fill the form above.";
else {
    $db = mysqli_connect('localhost', 'cs143', '', 'CS143'); // TEST-->CS143 / submission
    if($db->connect_errno > 0) die('Unable to connect to database [' . $db->connect_error . ']');

	$db->query("INSERT INTO Review VALUES ('$name', '$time',
        '$mid', '$rating', '$comment');") or die(mysql_error());
	echo "Thanks for your comment!";

    $db->close();
}
echo '</p>';
?>

</body>
</font>
</html>
