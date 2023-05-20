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

	$sql = "delete from playerstats where schedule_id = $gameID";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>create new table failed";
		exit; 
	} else {
		echo "<br>game $gameID - playerstats reset";
	}


	$sql = "delete from gamestats where schedule_id = $gameID";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>create new table failed";
		exit; 
	} else {
		echo "<br>game $gameID - gamestats reset";
	}

	$sql = "update schedule	set played = 0, home_score = 0, away_score = 0, played_date = NULL, played_time = 0, overtime = 0 where schedule_id = $gameID";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>create new table failed";
		exit; 
	} else {
		echo "<br>game $gameID - schedule reset";
	}

}


function CreateBox () {
	echo "<form action=\"deletegame.php\" method=\"GET\" >reset this game:<br>";
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

