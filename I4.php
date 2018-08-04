<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<font color="black" face="Palatino">
<head>
	<title>Add Movie to Actor Relation</title>
	<h1 align="center">Add Movie to Actor Relation</h1>
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

		    $rs = $db->query("SELECT id, title, year FROM Movie ORDER BY title;") or die(mysql_error());
		    while ($arr = mysqli_fetch_array($rs)) {
		          $id = $arr["id"];
		          $title = $arr["title"];
		          $year = $arr["year"];
		          echo "<option value=$id>$title ($year) </option>";
		    }
		    $rs->free();
		    // $db->close()
		    ?>
		</SELECT>
	</td></tr>

	<tr><td>
	    <label class="field" for="actor">Actor: </label>
	    <SELECT NAME="actor">
	        <?php
	        $rs_actor = $db->query("SELECT id, first, last, dob FROM Actor ORDER BY first, last;") or die(mysql_error());
	        while ($arr = mysqli_fetch_array($rs_actor)) {
	        	$id = $arr["id"];
	        	$first = $arr["first"];
	        	$last = $arr["last"];
	        	$dob = $arr["dob"];
	        	echo "<option value=$id>$first $last ($dob) </option>";
	        }
	        $rs_actor->free();
	        ?>
	    </SELECT>
	</td></tr>

	</tr><td>
	    <label class="field" for="role">Role: </label>
	    <input type="text" name="role" size="20" maxlength="50" value="<?php echo htmlspecialchars($_GET['role']);?>" placeholder="Role">
	</td><tr>
	<tr><td>
		<div style="clear:both;padding:5px;" align="center"><input type="submit" value="Add"></div>
	</td></tr>
</table>
</form>

<?php
$role = trim($_GET["role"]);
$mid = $_GET["movie"];
$aid = $_GET["actor"];

echo '<p align="center">';
if ($mid == "" && $aid == "" && $role == "") {}
else {
	$db->query("INSERT INTO MovieActor VALUES ('$mid','$aid','$role');") or die(mysql_error());
	echo "Movie (id: $mid) and actor (id: $aid) has been linked successfully!";
}
echo "</p>";
$db->close();
?>

</body>
</font>
</html>
