<!DOCTYPE html>
<html>
<body>

<h1>Movie Database</h1>
<form METHOD="GET" action="query.php">
      		   <TEXTAREA name='query' ROWS=8 COLS=60></TEXTAREA> <br/>
		   	     		  <input type="submit" value="Submit"/> 
</form>
<h2>Query Result:</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
		// collect value of input field
		$query = $_GET['query']; 
		if (empty($query)) {
				
		} else {
				$db = mysqli_connect('localhost', 'cs143', '', 'CS143');

				if($db->connect_errno > 0){
					die('Unable to connect to database [' . $db->connect_error . ']');
				}
				
				if (!($result = $db->query($query))){
					$errmsg = $db->error;
					print "Query failed: $errmsg <br />";
					exit(1);
				}
				$column=mysqli_fetch_fields($result);
				
				foreach ($column as $val)
				{
				printf("     %s",$val->name);

				}
				print '</br>';
				
				if (mysqli_num_rows($result) > 0)   
					{  
						while($row = mysqli_fetch_row($result))   
						{  
							$num=count($row);
							foreach($row as $tmp){
								print "$tmp   ";
							}
							print "</br>";
						}  

					}  
				
				$result->free();
				$mysqli->close();
		}   
}
?>

</body>
</html>