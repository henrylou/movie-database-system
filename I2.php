<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<font color="black" face="Palatino">
<head>
	<title>Add New Movie</title>
	<h1 align="center">Add New Movie</h1>
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
<p>
<table align="center" cellpadding="5px">
<tr><td>
	<label class="field" for="title">Title: </label>
	<input type="text" name="title" size="20" maxlength="100" value="<?php echo htmlspecialchars($_GET['text']);?>" placeholder="Title">
</td></tr>
<tr><td>
	<label class="field" for="year">Year: </label>
	<input type="text" name="year" size="10" maxlength="4" value="<?php echo htmlspecialchars($_GET['year']);?>" placeholder="YYYY">
</td></tr>
<tr><td>
	<label class="field" for="company">Company: </label>
	<input type="text" name="company" size="20" maxlength="50" value="<?php echo htmlspecialchars($_GET['company']);?>" placeholder="Company">
</td></tr>
<tr><td>
	<label class="field" for="rating">Rating: </label>
	<SELECT NAME="rating">
	<OPTION SELECTED>G</OPTION>
	<OPTION>NC-17</OPTION>
	<OPTION>PG</OPTION>
	<OPTION>PG-13</OPTION>
	<OPTION>R</OPTION>
	<OPTION>surrendere</OPTION>
	</SELECT>
</td></tr>
<tr><td>
    <label class="field" for="genre">Genre: </label>
    <table style="width:30em;border:0px;">
        <tr>
            <td><input type="checkbox" name="genre[]" value="Action">Action</input></td>
            <td><input type="checkbox" name="genre[]" value="Adult">Adult</input></td>
            <td><input type="checkbox" name="genre[]" value="Adventure">Adventure</input></td>
            <td><input type="checkbox" name="genre[]" value="Animation">Animation</input></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="genre[]" value="Comedy">Comedy</input></td>
            <td><input type="checkbox" name="genre[]" value="Crime">Crime</input></td>
            <td><input type="checkbox" name="genre[]" value="Documentary">Documentary</input></td>
            <td><input type="checkbox" name="genre[]" value="Drama">Drama</input></td>
    	</tr>
        <tr>
            <td><input type="checkbox" name="genre[]" value="Family">Family</input></td>
            <td><input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input></td>
            <td><input type="checkbox" name="genre[]" value="Horror">Horror</input></td>
            <td><input type="checkbox" name="genre[]" value="Musical">Musical</input></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="genre[]" value="Mystery">Mystery</input></td>
            <td><input type="checkbox" name="genre[]" value="Romance">Romance</input></td>
            <td><input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input></td>
            <td><input type="checkbox" name="genre[]" value="Short">Short</input></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="genre[]" value="Thriller">Thriller</input></td>
            <td><input type="checkbox" name="genre[]" value="War">War</input></td>
            <td><input type="checkbox" name="genre[]" value="Western">Western</input></td>
        </tr>
    </table>
</td></tr>
<tr><td>
	<div style="clear:both;padding:5px;" align="center"><input type="submit" value="Add"></div>
</td></tr>
</table>
</p>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $title = trim($_GET['title']);
    $company = trim($_GET['company']);
    $year = $_GET['year'];
    $rating = $_GET['rating'];
    $genre = $_GET['genre'];

    $db = mysqli_connect('localhost', 'cs143', '', 'CS143'); // TEST-->CS143 / submission

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
	echo '<p align="center">';

    if ($title == '' && $company == '' && $year == '' && $genre == '') {
		echo 'Please fill the form above.';
	}
    else if ($title == '') die('Title cannot be empty!');
    else if ($company == '') die('Company cannot be empty!');
    else if ($year == '' || $year <= 1000 || $year >= 2300) die('Production year is invalid.');
    else {
        $rs_maxid = $db->query("SELECT id FROM MaxMovieID;") or die(mysql_error());
        $arr = mysqli_fetch_array($rs_maxid);
    	$new_maxid = $arr[0] + 1;
		$rs_maxid->free();

    	$query = "INSERT INTO Movie VALUES ('$new_maxid', '$title', '$year', '$rating', '$company');";
    	$db->query($query) or die('Unable to insert new movie');

    	for ($i = 0; $i < count($genre); $i++) {
    		$query = "INSERT INTO MovieGenre VALUES ('$new_maxid', '$genre[$i]');";
            $db->query($query) or die(mysql_error());
    	}

    	$db->query("UPDATE MaxMovieID SET id = $new_maxid;") or die(mysql_error());
    	echo "$title (id: $new_maxid) has been inserted successfully!";

		echo '</p>';
    }
    $db->close();
}
?>

</body>
</font>
</html>
