<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<font color="black" face="Palatino">
<head>
	<title>Add New Actor or Director</title>
	<h1 align="center">Add New Actor or Director</h1>
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
<table align="center" cellpadding="10px">
<tr><td>
    <label class="field" for="type">Type: </label>
    <input type="radio" name="type" value="Actor" checked>Actor
    <input type="radio" name="type" value="Director">Director
</td></tr>
<tr><td>
    <label class="field" for="first">First Name: </label>
    <input type="text" name="first" size="20" maxlength="20" value="<?php echo htmlspecialchars($_GET['first']);?>" placeholder="First Name">
</td></tr>
<tr><td>
    <label class="field" for="last">Last Name: </label>
    <input type="text" name="last" size="20" maxlength="20" value="<?php echo htmlspecialchars($_GET['last']);?>" placeholder="Last Name">
</td></tr>
<tr><td>
    <label class="field" for="sex">Sex: </label>
    <input type="radio" name="sex" value="Male" checked>Male
    <input type="radio" name="sex" value="Female">Female
</td></tr>
<tr><td>
    <label class="field" for="dob">Date of Birth: </label>
    <input type="text" name="dob" size="15" maxlength="8" value="<?php echo htmlspecialchars($_GET['dob']);?>" placeholder="YYYYMMDD"> (YYYYMMDD)
</td></tr>
<tr><td>
    <label class="field" for="dod">Date of Death: </label>
    <input type="text" name="dod" size="15" maxlength="8" value="<?php echo htmlspecialchars($_GET['dod']);?>" placeholder="YYYYMMDD"> (leave blank if N/A)
</td></tr>
<tr><td>
	<div style="clear:both;padding:5px;" align="center"><input type="submit" value="Add"></div>
</td></tr>
</table>
</p>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $type = trim($_GET['type']);
    $first = trim($_GET['first']);
    $last = trim($_GET['last']);
    $sex = trim($_GET['sex']);
    $dob = trim($_GET['dob']);
    $dod = trim($_GET['dod']);
    $dob_date = date_parse($dob);
    $dod_date = date_parse($dod);

    $db = mysqli_connect('localhost', 'cs143', '', 'CS143'); // TEST-->CS143 / submission

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    if ($first == "" && $last == "" && $dob == "" && $dod == "") echo '<p align="center">Please fill the form Above.</p>';
    else if ($first == "") die('<p align="center">First name cannot be empty!</p>');
    else if ($last == "") die('<p align="center">Last name cannot be empty!</p>');
    else if ($dob == "" || !checkdate($dob["month"], $dob["day"], $dob["year"])) die('<p align="center">Date of Birth is invalid!</p>');
    else if ($dod != "" && !checkdate($dod["month"], $dod["day"], $dod["year"])) die('<p align="center">Date of Death is invalid!</p>');
    else {
    	$rs_maxid = $db->query("SELECT id FROM MaxPersonID;") or die(mysql_error());
        $arr = mysqli_fetch_array($rs_maxid);
    	$new_maxid = $arr[0] + 1;
		$rs_maxid->free();

    	if ($type == 'Actor') {
    		if ($dod == "") {
    			$query = "INSERT INTO Actor VALUES('$new_maxid',
					'$last', '$first', '$sex', '$dob', NULL);";
    		}
            else {
                $query = "INSERT INTO Actor VALUES('$new_maxid',
					'$last', '$first', '$sex', '$dob','$dod');";
    		}
    	} else if ($type == 'Director') {
            if ($dod == "") {
    		    $query = "INSERT INTO Director VALUES('$new_maxid',
					'$last', '$first', '$sex', '$dob', NULL);";
    		}
            else {
                $query = "INSERT INTO Director VALUES('$new_maxid',
					'$last', '$first', '$sex', '$dob', '$dod');";
    		}
    	}
		echo '<p align="center">';
		$db->query($query) or die(mysql_error());
		$db->query("UPDATE MaxPersonID SET id = $new_maxid;") or die(mysql_error());
    	echo "$type $first $last (ID: $new_maxid) has been inserted successfully!";
		echo "</p>";
    }
    $db->close();
}
?>

</font>
</body>
</html>
