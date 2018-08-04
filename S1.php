<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<font color="black" face="Palatino">
<head>
	<title>Search Actor or Movie</title>
	<h1 align="center">Search Actor or Movie</h1>
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
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table align="center" cellpadding="10px">
	<tr><td>
    	<label class="field" for="search">Search: </label>
    	<input type="text" name="search" size="20" value="<?php echo htmlspecialchars($_GET['search']);?>" placeholder="search">
</td><td>
		<div style="clear:both;padding:5px;" align="center"><input type="submit" value="Search"></div>
	</td></tr>
</table>
</form>

<?php
$db = mysqli_connect('localhost', 'cs143', '', 'CS143'); // TEST-->CS143 / submission
if($db->connect_errno > 0) die('Unable to connect to database [' . $db->connect_error . ']');

$search = trim($_GET['search']);
$item = explode(' ', $search);

if (trim($search) == "") {}
else {
	echo '<h2 align="center">Matched Actors are </h2>';
	$query = "SELECT id,last,first,dob FROM Actor WHERE (first LIKE '%$item[0]%' OR last LIKE '%$item[0]%')";
	for ($i = 1; $i < count($item); $i++) {
		$tmp = $item[$i];
        $query .= "AND (first LIKE '%$tmp%' OR last LIKE '%$tmp%')";
        // echo $query;
	}
	$rs_search = $db->query($query) or die(mysql_error());
	echo '<table align="center">';
	while ($arr = mysqli_fetch_array($rs_search)) {
		$id = $arr["id"];
        $first = $arr["first"];
		$last = $arr["last"];
		$dob = $arr["dob"];
		echo "<tr><td><a href=\"./B1.php?id=$id\" style=\"color:black;\">$first $last ($dob)</a></td></tr>";
	}
	echo '</table>';
	$rs_search->free();

	echo "<br/>";

	echo '<h2 align="center">Matched Movies are </h2>';
	$query = "SELECT id,title,year FROM Movie WHERE (title LIKE '%$item[0]%')";
	for ($i = 1; $i < count($item); $i++) {
		$tmp = $item[$i];
		$query .= "AND (title LIKE '%$tmp%')";
	}
	$rs_search = $db->query($query) or die(mysql_error());
	echo '<table align="center">';
	while ($arr = mysqli_fetch_array($rs_search)) {
		$id = $arr["id"];
		$title = $arr["title"];
		$year = $arr["year"];
		echo "<tr><td><a href=\"./B2.php?id=$id\" style=\"color:black;\">$title ($year)</a></td></tr>";
	}
	echo '</table>';
	$rs_search->free();
}
$db->close();
?>

</body>
</font>
</html>
