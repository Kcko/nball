<?
/***************************************************************************
 *                            -------------------
 *   copyright            : (C) The NBA Live League Project
 *   www                  : http://nball.sourceforge.net
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

include("../mysql.php");

function UpdateGame($gameID) {
	include("../config.php");

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from schedule where schedule_id = $gameID";

	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>can't find schedule";
		exit; 
	} else {
		echo "<br>game retrieved";
	}

	$game = $db->sql_fetchrow($result);
	print_r($game);
	
	$played = $game["PLAYED"];
	
	if ($played == 0) {

		$homeTeam = $game["AWAY_TEAM"];
		$awayTeam = $game["HOME_TEAM"];

		$sql = "update schedule	set HOME_TEAM = $homeTeam, AWAY_TEAM = $awayTeam where schedule_id = $gameID";
		echo $sql;
		
		if ( !($result = $db->sql_query($sql)) ) {
			echo "<br>update failed";
			exit; 
		} else {
			echo "<br>game $gameID - swap complete";
		}
	} else {

		echo "game already played, teams cannont be swapped";
	
	}

}


function CreateBox () {
	echo "<form action=\"swapteams.php\" method=\"GET\"> swap home/away team:<br>";
	echo "ID: <input name=\"gameID\" type=\"text\"><br>\n";
	echo "<input type=submit value=\"Reset Game\">\n";
	echo "</form>\n";
}


//UpdatePlayerRosters("players.dbf");

switch ($gameID) {
	case '': 
		CreateBox();
		break;

	default:
		UpdateGame($gameID);

}




?>

