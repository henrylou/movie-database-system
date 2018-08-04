<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<font color="black" face="Palatino">
<head>
	<title>Actor Information</title>
	<h1 align="center">Actor Information</h1>
</head>

<body background="./search.jpg">
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
<?php
$db = mysqli_connect('localhost', 'cs143', '', 'CS143'); // TEST-->CS143 / submission
if($db->connect_errno > 0) die('Unable to connect to database [' . $db->connect_error . ']');
$db_id = trim($_GET["id"]);
if ($db_id == "") echo '<p align="center">Please input your keywords below</p>';
else {
	// echo "<h2>Actor Information: </h2>";
	echo '<table align="center" cellpadding="1px">';
	$rs_actor = $db->query("SELECT last, first, sex, dob, dod FROM Actor WHERE id = $db_id;") or die(mysql_error());
	$arr = mysqli_fetch_array($rs_actor);
	$last = $arr["last"];
	$first = $arr["first"];
	$sex = $arr["sex"];
	$dob = $arr["dob"];
	echo "<tr><td>Name: $first $last </td></tr>";
	echo "<tr><td>Sex: $sex </td></tr>";
	echo "<tr><td>Date of Birth: $dob </td></tr>";
	if ($arr["dod"]!="") {
		$tmp = $arr["dod"];
		echo "<tr><td>Date of Death: $tmp</td></tr>";
	}
	echo '</table>';
	$rs_actor->free();

	echo '<h2 align="center">Acted as </h2>';

    $rs_movie = $db->query("SELECT MA.role,M.title,M.year,M.id
                           FROM MovieActor MA, Movie M
                           WHERE MA.mid=M.id AND MA.aid=$db_id
                           ORDER BY M.year DESC;") or die(mysql_error());
	echo '<table align="center" cellpadding="1px">';
	while ($arr = mysqli_fetch_array($rs_movie)) {
		$role = $arr["role"];
		$title = $arr["title"];
		$year = $arr["year"];
		$id = $arr["id"];
	    echo "<tr><td>\"$role\" in <a href=\"./B2.php?id=$id\" style=\"color:grey;\">$title ($year)</a></td></tr>";
	}
	echo "</table>";
	$rs_movie->free();
}
$db->close();
?>

<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<p align="center">
	    <label class="field" for="search">Search: </label>
	    <input type="text" name="search" size="20" value="<?php echo htmlspecialchars($_GET['search']);?>" placeholder="search">
		<div style="clear:both;padding:5px;" align="center"><input type="submit" value="Search"></div>
</p>
</form>

<?php
$get_search = $_GET["search"];
if ($get_search != "") {
	header("Location: ./S1.php?search=$get_search");
	exit;
}
?>

</body>
</font>
</html>
