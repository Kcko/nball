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


	include('../config.php');
	include('../mysql.php');


	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from players, teams, position where teams.teamnum = players.team and players.position = position.position order by teamnum, name, fname";
	$result = $db->sql_query($sql);
	$playerList = $db->sql_fetchrowset($result);

	$sql = "select * from award";
	$result = $db->sql_query($sql);
	$awardList = $db->sql_fetchrowset($result);

	$seasonID = $HTTP_POST_VARS["seasonID"];


	$sql = "delete from award_win where season_id = $seasonID";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	
	foreach ($awardList as $award) {
		$awardID = $award["AWARD_ID"];
		$awardDesc = $award["AWARD_DESC"];

		$postVarIndex = "Award" . $awardID;
		
		if (count($HTTP_POST_VARS[$postVarIndex]) > 0 ) {
			foreach ($HTTP_POST_VARS[$postVarIndex] as $playerID) {
				echo "insert into award_win values($seasonID, $playerID, $awardID);\n";
				
				$sql = "insert into award_win values($seasonID, $awardID, $playerID);";
				echo $sql;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);				
			}
		}

	}

?>