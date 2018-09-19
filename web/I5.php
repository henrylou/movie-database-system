<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<font color="black" face="Palatino">
<head>
	<title>Add Movie Director Relation</title>
	<h1 align="center">Add Movie Director Relation</h1>
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

	        $rs_movie = $db->query("SELECT id, title, year FROM Movie ORDER BY title;") or die(mysql_error());
	        while ($arr = mysqli_fetch_array($rs_movie)) {
	              $id = $arr["id"];
	              $title = $arr["title"];
	              $year = $arr["year"];
	              echo "<option value=$id>$title ($year) </option>";
	        }
	        $rs_movie->free();
	        ?>
	    </SELECT>
	</td></tr>

	<tr><td>
	    <label class="field" for="director">Director: </label>
	    <SELECT NAME="director">
	    <?php
	    $rs_director = $db->query("SELECT id, first, last, dob FROM Director ORDER BY first ASC;") or die(mysql_error());
	    while ($arr = mysqli_fetch_array($rs_director)) {
	    	$id = $arr["id"];
	    	$first = $arr["first"];
	    	$last = $arr["last"];
	    	$dob = $arr["dob"];
	    	echo "<option value=$id>$first $last ($dob) </option>";
	    }
	    $rs_director->free();
	    ?>
	    </SELECT>
	</td><tr>
	<tr><td>
		<div style="clear:both;padding:5px;" align="center"><input type="submit" value="Add"></div>
	</td></tr>
</table>
</form>

<?php
$mid = $_GET["movie"];
$did = $_GET["director"];
echo '<p align="center">';
if ($mid == "" && $did == "") {}
else {
    if ($db->query("INSERT INTO MovieDirector VALUES ('$mid','$did');")) {
        echo "Movie (id: $mid) and director (id: $did) has been linked successfully!";
    }
    else {
        echo "Movie (id: $mid) and director (id: $did) has already been linked before.";
    }
}
echo '</p>';
$db->close();
?>

</body>
</font>
</html>
