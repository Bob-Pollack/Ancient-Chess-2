<?php 

ini_set('display_errors', 1); 
error_reporting(E_ALL); 

$connx = mysql_connect("localhost", "liq3", "ch355tw0"); 
if (!$connx) {
	die("<br />DB connection failed: " . mysql_error()); 
}

mysql_select_db("chesstwo", $connx);

$gameid = "'1'";

if (isset($_GET['command']) && $_GET['command'] == 'reset') {
	$gamestate = '3333aPa7bPb7cPc7dPd7ePe7fPf7gPg7hPh7iNg8jNb8lBc8mBf8nRa8oRh8pKd8qQe8APa2BPb2CPc2DPd2EPe2FPf2GPg2HPh2INg1JNb1LBc1MBf1NRa1ORh1PKd1QQe1';
	mysql_query("UPDATE `games` SET `gamestate`='$gamestate' WHERE `id`=$gameid"); 
	die('gamestate:'.$gamestate);
}

$result = mysql_query("SELECT * FROM games WHERE id=$gameid");
if (!$result) {	
	die("<br />Query failed: ". mysql_error());
}

$row = mysql_fetch_array($result);
$gamestate = $row['gamestate'];
if (isset($_GET['command']) && $_GET['command'] == 'move' && isset($_GET['move']) && $_GET['move'] != 'undefined') {
	movePiece($_GET['move']);
}

if (isset($_GET['command']) && $_GET['command'] == 'duel') {
	if ($_GET['team'] == 'black') {
		$gamestate[2] = $gamestate[2] - $_GET['stones'];	
	}
	else {
		$gamestate[3] = $gamestate[3] - $_GET['stones'];	
	}
}

		

function movePiece($piece) {
	global $gamestate;
	$moveTo = substr($piece,2);
	$type = $piece[1];
	$id = $piece[0];
	$chrpos = strpos($gamestate, $moveTo);
	if ($chrpos !== false) {
		$gamestate = substr($gamestate, 0, $chrpos-2).substr($gamestate, $chrpos+2);
	}
	$chrpos = strpos($gamestate, $id.$type);
	$gamestate[$chrpos+3] = $moveTo[1];
	$gamestate[$chrpos+2] = $moveTo[0];
}


echo "gamestate:".$gamestate;

mysql_query("UPDATE `games` SET `gamestate`='$gamestate' WHERE `id`=$gameid"); 

mysql_close($connx);
?>
