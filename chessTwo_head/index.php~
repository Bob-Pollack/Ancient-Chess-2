<html>
<title>Chess 2</title>
<body><h1>CHESS TWO</h1>


<?php
			echo "POSTS: <br />";
			foreach($_POST as $field=>$value) {
			   if($value !="") {
				echo "You chose $value <br />";
			   }
			}
			echo "GETS: <br />";
			foreach($_GET as $field=>$value) {
			   if($value !="") {
				echo "You chose $value <br />";
			   }
			}





			$whoseTurn=$_GET["turn"];
			//echo "Your mother was a hampster with a P in it.";
			echo "<br />";

			// 0=white
			// 1=black
			//$whoseTurn=1;
			//
			//
			//
			echo "";
			if ($whoseTurn == 0){
				echo "It is White's turn.";
			} else {
				echo "It is Black's turn.";
			}


		/*	
		 */
	$boardArray = array( array(1,2,3,4,5,6,7,8),
					     array(9,10,11,12,13,14,15,16),
					     array(0,0,0,0,0,0,0,0),
					     array(0,0,0,0,0,0,0,0),
					     array(0,0,0,0,0,0,0,0),
					     array(0,0,0,0,0,0,0,0),
						 array(17,18,19,20,21,22,23,24),
					     array(25,26,27,28,29,30,31,32)
				 ); 
			
			echo "<br />boardArray[1][1] is " . $boardArray[1][1];

			//$boardArray 
			//
			//
			//
			//
			//
			//
			//
			// Getting information
			
		?>
	
	
<form action="temporarilyBored_v16.php" method="POST">
Play game (color): <input type="text" name="turn" />
<input type="submit" />
</form> 

POST <?php echo $_POST["turn"]; ?>!<br />

Welcome!


<!--
<form action="chesstwo.php" method="post">
Name: <input type="text" name="fname" />
<input type="submit" />
</form> 


Welcome <?php echo $_POST["fname"]; ?>!<br />
-->
       <form action="index.php" method="POST">
       <select name="setType">
       <option>Animals</option>
       <option>Nemesis</option>
       <option>Vanilla</option>
       </select>
       <input type="submit" value="Choose yer set">
       </form>



		
		<script type="text/javascript">
			// JavaScript can be used here!
			//alert('JAVAJAVASCRIPT!');

		</script>



<?php
	$serverName = "localhost";
	$databaseName = "my_db";
	$user = "root";
	$password = "chesstwo";
	echo "<br />About to connect to mySQL...";
	// mysql_connect(servername,username,password); 
	$con = mysql_connect("localhost",$user,$password);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

// some code
	// create a database
	if (mysql_query("CREATE DATABASE " . $databaseName,$con)) {
	  echo "<br />Database created";
	} else {
	  echo "<br />Error creating database: " . mysql_error();
	}

	// select the database
	mysql_select_db($databaseName, $con);
	
	// create a table
	// make the gameID the primary key
	$sql = "CREATE TABLE games (
		gameID int NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(gameID),
		P1 varchar(15),
		P2 varchar(15),
		whoseTurn int,
		P1_stones int,
		P2_stones int
	)";

	// Execute the statement above to create the table
	mysql_query($sql,$con);



	// close the mysql connection
	mysql_close($con); 

?>


</body></html>



