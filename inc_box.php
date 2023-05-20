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

function createTeamImageURL($teamID, $score) {
	echo "<BR>";
	echo "<a href=viewteam.php?teamID=$teamID><img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\"></a>\n";
	echo "<BR>";

//	echo "<img border=0 src=\"http://www.nba.com/" . $teamName .  "/images/" . $teamName . "_logo.gif\">\n";
//	echo "<img src=\"http://www.nba.com/media/nba/" . $teamName .  ".gif\">\n";	
//	echo "<img src=\"http://www.nba.com/media/" . $teamName . "_logo.gif\">\n";
//
}

function createGameBoxScore($teamStats) {
	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 class=gScGTable>";
	echo "<tr>";
	echo "  <td width=33% class=gSGSectionColumnHeadingsStatsGrid align=middle><b>" . $teamStats["AWAY_TEAMNAME"] . "</b></td>";
	echo "  <td width=33% class=gSGSectionColumnHeadingsStatsGrid align=middle><b>&nbsp;</b></td>";
	echo "  <td width=33% class=gSGSectionColumnHeadingsStatsGrid align=middle><b>" . $teamStats["HOME_TEAMNAME"] . "</b></td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["AWAY_POINTS"] . "</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>Points</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["HOME_POINTS"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["AWAY_BENCH"] . "</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>Bench Scoring</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["HOME_BENCH"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" . $teamStats["AWAY_FGM"] . "/" . $teamStats["AWAY_FGA"] . "</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>Field Goals</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" . $teamStats["HOME_FGM"] . "/" . $teamStats["HOME_FGA"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["AWAY_FGP"] . "</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>Field Goal %</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["HOME_FGP"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" . $teamStats["AWAY_3PM"] . "/" . $teamStats["AWAY_3PA"] . "</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>3 Point FG</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" . $teamStats["HOME_3PM"] . "/" . $teamStats["HOME_3PA"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["AWAY_3PP"] . "</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>3 Point %</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["HOME_3PP"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" . $teamStats["AWAY_FTM"] . "/" . $teamStats["AWAY_FTA"] . "</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>Free Throws</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" . $teamStats["HOME_FTM"] . "/" . $teamStats["HOME_FTA"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["AWAY_FTP"] . "</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>Free Throw %</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["HOME_FTP"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["AWAY_REB"] . "</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>Rebounds</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["HOME_REB"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["AWAY_OREB"] . "</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>Off. Rebounds</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["HOME_OREB"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["AWAY_DREB"] . "</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>Def. Rebounds</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["HOME_DREB"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["AWAY_BLOCKS"] . "</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>Blocks</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["HOME_BLOCKS"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["AWAY_STEALS"] . "</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>Steals</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["HOME_STEALS"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["AWAY_ASSISTS"] . "</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>Assists</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["HOME_ASSISTS"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["AWAY_TURNOVERS"] . "</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>Turnovers</td>";
	echo "  <td valign=top class=gSGRowEvenStatsGrid align=middle>" .$teamStats["HOME_TURNOVERS"] . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["AWAY_FOULS"] . "</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>Fouls</td>";
	echo "  <td valign=top class=gSGRowOddStatsGrid align=middle>" .$teamStats["HOME_FOULS"] . "</td>";
	echo "</tr>";
	echo "</table>";
}


function createPlayerStats($PlayerStats, $TeamName) {


//	echo "<pre>";
//	print_r($PlayerStats);
//	echo "</pre>";

//Pos.   No.   Name                 Pts        Mins       FGM        FGA        FG%        3PM        
//3PA        3P%        FTM        FTA        FT%        OReb       DReb       Rebs       Blk        
//Stl        Ast        TO         Fouls      

	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 class=gScGTable>";
	echo "<tr>";
	echo "<td class=gSGSectionTitleStatsGridOne colSpan=15><b>$TeamName</b></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=6><b></b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=3 align=middle><b>REBOUNDS</b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=6><b></b></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td width=150 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>&nbsp;PLAYER</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>POS</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>MIN</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FGM-A</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>3GM-A</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FTM-A</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>OFF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>DEF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TOT</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>BLK</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>AST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>ST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TO</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PTS</b></td>";
	echo "</tr>";


	$rowclass = "gSGRowEvenStatsGrid";
	
	foreach ($PlayerStats as $value) {

		$playerName = trim($value["FNAME"] . " " . $value["NAME"]); 

		
		if ($value["ROSTERPOS"] < 5) {
		
			$playerName = strtoupper($playerName);
			$playerName = "<B>$playerName</B>";
			
		}

		echo "<tr>";

		switch ($value["PLAYED"]) {
		case 1 :

			echo "<td class=$rowclass align=left>&nbsp;&nbsp;<a href=viewplayer.php?playerID=" . $value["PLAYERID"] . ">$playerName</a></td>";
			echo "<td class=$rowclass align=middle> " . $value["POSITION_NAME_SHORT"] . "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["MINS"] . "</td>";

			echo "<td class=$rowclass align=middle>&nbsp;" . $value["FGM"] . "-" . $value["FGA"] .  "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["3PM"] . "-" . $value["3PA"] .  "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["FTM"] . "-" . $value["FTA"] .  "</td>";

			echo "<td class=$rowclass align=middle>&nbsp;" . $value["OREBOUNDS"] . "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["DREBOUNDS"] . "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["REBOUNDS"] . "</td>";

			echo "<td class=$rowclass align=middle>&nbsp;" . $value["BLOCKS"] . "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["ASSISTS"] . "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["FOULS"] . "</td>";

			echo "<td class=$rowclass align=middle>&nbsp;" . $value["STEALS"] . "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["TURNOVERS"] . "</td>";
			echo "<td class=$rowclass align=middle>&nbsp;" . $value["POINTS"] . "</td>";

			break;		

		case 0 :
			echo "<td class=$rowclass align=left>&nbsp;&nbsp;<a href=viewplayer.php?playerID=" . $value["PLAYERID"] . ">$playerName</a></td>";
			echo "<td class=$rowclass align=middle> " . $value["POSITION_NAME_SHORT"] . "</td>";
			echo "<td class=$rowclass align=middle colspan=13>&nbsp;DNP</td>";
			break;
		}

		echo "</tr>";
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
	
	}

	echo "<tr>";
	echo "<td class=$rowclass colSpan=15><b>&nbsp;</b></td>";
	echo "</tr>";


	echo "</table>";
}

function createPlayerStatsSQL($scheduleID, $teamID) {

	$sql = "
	SELECT	 PLR.FNAME
		,PLR.NAME
		,PLR.ROSTERPOS
		,PST.*
		,POS.*

	FROM PLAYERSTATS PST

	INNER JOIN PLAYERS PLR
	ON PST.PLAYERID = PLR.PLAYERID

	INNER JOIN POSITION POS
	ON PLR.POSITION = POS.POSITION

	WHERE	PST.SCHEDULE_ID = $scheduleID
	AND	PST.TEAM_NUMBER = $teamID
	ORDER BY PST.ROSTERPOS";

	return($sql);
}


function createGameStatsSQL($scheduleID) {
		$sql = "
	SELECT	 TMH.TEAMNAME AS HOME_TEAMNAME
		,TMH.CITYNAME2 AS HOME_CITYNAME
		,TMH.TEAMNUM AS HOME_TEAMNUM
		,TMH.IMAGENAME AS HOME_IMAGENAME
		,GSH.POINTS AS HOME_POINTS
		,GSH.BENCH_SCORING AS HOME_BENCH
		,GSH.FGA AS HOME_FGA
		,GSH.FGM AS HOME_FGM
		,GSH.FGP AS HOME_FGP
		,GSH.3PA AS HOME_3PA
		,GSH.3PM AS HOME_3PM
		,GSH.3PP AS HOME_3PP
		,GSH.FTA AS HOME_FTA
		,GSH.FTM AS HOME_FTM
		,GSH.FTP AS HOME_FTP
		,GSH.REBOUNDS AS HOME_REB
		,GSH.OREBOUNDS AS HOME_OREB
		,GSH.DREBOUNDS AS HOME_DREB
		,GSH.BLOCKS AS HOME_BLOCKS
		,GSH.STEALS AS HOME_STEALS
		,GSH.ASSISTS AS HOME_ASSISTS
		,GSH.TURNOVERS AS HOME_TURNOVERS
		,GSH.FOULS AS HOME_FOULS

		,TMA.TEAMNAME AS AWAY_TEAMNAME
		,TMA.CITYNAME2 AS AWAY_CITYNAME
		,TMA.TEAMNUM AS AWAY_TEAMNUM
		,TMA.IMAGENAME AS AWAY_IMAGENAME
		,GSA.POINTS AS AWAY_POINTS
		,GSA.BENCH_SCORING AS AWAY_BENCH
		,GSA.FGA AS AWAY_FGA
		,GSA.FGM AS AWAY_FGM
		,GSA.FGP AS AWAY_FGP
		,GSA.3PA AS AWAY_3PA
		,GSA.3PM AS AWAY_3PM
		,GSA.3PP AS AWAY_3PP
		,GSA.FTA AS AWAY_FTA
		,GSA.FTM AS AWAY_FTM
		,GSA.FTP AS AWAY_FTP
		,GSA.REBOUNDS AS AWAY_REB
		,GSA.OREBOUNDS AS AWAY_OREB
		,GSA.DREBOUNDS AS AWAY_DREB
		,GSA.BLOCKS AS AWAY_BLOCKS
		,GSA.STEALS AS AWAY_STEALS
		,GSA.ASSISTS AS AWAY_ASSISTS
		,GSA.TURNOVERS AS AWAY_TURNOVERS
		,GSA.FOULS AS AWAY_FOULS

	FROM	SCHEDULE SH
	INNER JOIN GAMESTATS GSH
	ON SH.SCHEDULE_ID = GSH.SCHEDULE_ID
	AND SH.HOME_TEAM = GSH.TEAM_NUMBER

	INNER JOIN TEAMS TMH
	ON TMH.TEAMNUM = GSH.TEAM_NUMBER

	INNER JOIN GAMESTATS GSA
	ON SH.SCHEDULE_ID = GSA.SCHEDULE_ID
	AND SH.AWAY_TEAM = GSA.TEAM_NUMBER

	INNER JOIN TEAMS TMA
	ON TMA.TEAMNUM = GSA.TEAM_NUMBER

	WHERE	SH.SCHEDULE_ID = $scheduleID	
	";

	return($sql);
}




?>


