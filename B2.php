<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<font color="black" face="Palatino">
<head>
	<title>Movie Information</title>
	<h1 align="center">Movie Information</h1>
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
	$rs_movie = $db->query("SELECT title, year, rating, company FROM Movie WHERE id = $db_id") or die(mysql_error());
	$arr = mysqli_fetch_array($rs_movie);
	$title = $arr["title"];
	$year = $arr["year"];
	$rating = $arr["rating"];
	$company = $arr["company"];

	echo '<table align="center" cellpadding="1px">';
	echo "<tr><td>Title: $title";
	if ($year != "") echo " ($year)";
	echo '</td></tr>';

	echo "<tr><td>Producer: $company</td></tr>";
	echo "<tr><td>Rating: $rating</td></tr>";

	$rs_movie->free();
	$rs_movie = $db->query("SELECT D.last,D.first,D.dob
                            FROM MovieDirector MD, Director D
                            WHERE MD.mid = $db_id AND MD.did = D.id;") or die(mysql_error());
	echo "<tr><td>Director: ";
	$temp = mysqli_num_rows($rs_movie);
    if ($temp != 0) {
		$t = 0;
		while ($arr = mysqli_fetch_array($rs_movie)) {
            $first = $arr["first"];
			$last = $arr["last"];
			$dob = $arr["dob"];

            if ($t == 0) $t = 1;
    	    else echo ", ";

    	    echo "$first $last ($dob) </td></tr>";
    	}
    }
    else {
        echo "N/A </td></tr>";
	}

	$rs_movie->free();
	$rs_movie = $db->query("SELECT genre FROM MovieGenre MG WHERE mid=$db_id;") or die(mysql_error());
	echo "<tr><td>Genre: ";
	$temp = mysqli_num_rows($rs_movie);
	if ($temp != 0) {
	    $t = 0;
	    while ($arr = mysqli_fetch_array($rs_movie)) {
            $genre = $arr["genre"];
            if ($t == 0) $t = 1;
            else echo ", ";

            echo "$genre";
        }
    }
    else {
        echo "N/A";
    }
	echo "</td><tr></table>";
    $rs_movie->free();

    echo '<h2 align="center">Actors involved </h2>';
    $rs_movie = $db->query("SELECT A.id,A.last,A.first,MA.role
                            FROM Actor A, MovieActor MA
                            WHERE MA.mid = $db_id AND MA.aid = A.id;") or die(mysql_error());

	echo '<table align="center" cellpadding="1px">';
    while ($arr = mysqli_fetch_array($rs_movie)) {
        $first = $arr["first"];
        $last = $arr["last"];
        $id = $arr["id"];
        $role = $arr["role"];
        echo "<tr><td><a href=\"./B1.php?id=$id\" style=\"color:grey;\">$first $last</a> acted as \"$role\"</td><tr>";
    }
	echo "</table>";
    $rs_movie->free();

    echo '<h2 align="center">User Reviews </h2>';
	echo '<table align="center" cellpadding="1px">';
    $rs_movie = $db->query("SELECT SUM(rating), COUNT(rating) FROM Review WHERE mid = $db_id;") or die(mysql_error());
    $arr = mysqli_fetch_row($rs_movie);

    if ($arr[0] == 0 && $arr[1] == 0) {
        echo "<tr><td>No review now. ";
        echo "<a href=\"I3.php?movie=$db_id&ref=1\" style=\"color:grey;\">Add your review</a></td></tr>";
    }
    else {
        $avg = $arr[0] / $arr[1];
        $num = $arr[1];
        echo "<tr><td>Average Score: $avg/5 by $num review(s). ";
        echo "<a href=\"I3.php?movie=$db_id&ref=1\" style=\"color:grey;\">Add your review</a></td></tr>";
    }
    $rs_movie->free();
    echo "<tr><td>All Comments in Details: </td></tr>";
    $rs_movie = $db->query("SELECT time, name, rating, comment
                            FROM Review
                            WHERE mid = $db_id
                            ORDER BY time DESC") or die(mysql_error());
    while ($arr = mysqli_fetch_array($rs_movie)) {
        $time = $arr["time"];
	    $name = $arr["name"];
	    $rating = $arr["rating"];
	    $comment = $arr["comment"];
	    if ($name == "") $name = "Anonymous";
		if ($comment == "") $comment = "This person did not mention anything";
	    echo "<tr><td>$time, $name, $rating star(s)</td></tr>";
		echo "<tr><td>$comment</td></tr>";
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
</p>

<div style="clear:both;padding:5px;" align="center"><input type="submit" value="Search"></div>
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
