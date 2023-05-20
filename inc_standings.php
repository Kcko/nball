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

include('config.php');
include('mysql.php');

function westernConference($var) {
	return($var["CONFERENCE_NAME"] == "Western");
}

function easternConference($var) {
	return($var["CONFERENCE_NAME"] == "Eastern");
}

function createTeamImageURL($teamID) {
	echo "<img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\">\n";
}


function createTeamName($teamInfo) {
	echo $teamInfo["CITYNAME"] . "&nbsp" . $teamInfo["TEAMNAME"];
}



function createDivisionHeader($conference) {

$firstElement = current($conference);

$conf = substr($firstElement["CONFERENCE_NAME"],0,4);

echo "
	<table border=0 cellpadding=0 cellspacing=0 class=gSGTableStandings>

			<tr><td class=gSGSectionTitleStandings>
			<div class=gSGSectionTitleStandings>&nbsp;<img src=log_" . strtolower($conf) . "_sm.gif align=left /><p>" . $firstElement["CONFERENCE_NAME"] . " Conference</div></td>
			</tr>
	</table>
";


}

function createDivisionStandings($division, $gbLeader) {
	$c_division_name = "";
	
	foreach ($division as $team ) {
		if ($team["DIVISION_NAME"] != $c_division_name) {

			echo "<table border=0 cellpadding=0 cellspacing=0 class=gSGTableStandings width=100%>";
			echo "<tr class=gSGSectionColumnHeadingsStandings>";
			echo "<td NOWRAP align=left width=100 class=gSGSectionColumnHeadingsStandings><b>&nbsp;" . $team["DIVISION_NAME"] . "</b></td>";
			echo "<td NOWRAP align=right width=30 class=gSGSectionColumnHeadingsStandings><b>W</b></td>";
			echo "<td NOWRAP align=right width=30 class=gSGSectionColumnHeadingsStandings><b>L</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>%</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>HW</b></td>";
//			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>HL</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>RW</b></td>";
//			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>RL</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>PF</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>PA</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>%</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>GB</b></td>";
			echo "<td NOWRAP align=right width=5 class=gSGSectionColumnHeadingsStandings><b> </b></td>";
			echo "</tr>";

			
			$c_division_name = $team["DIVISION_NAME"];

		}


			$win_percent = sprintf("%01.3f", $team["WIN_PERCENT"]);
			$win_perc    = sprintf("%01.2f", $team["WIN_PERC"]);
			
			$gamesBehind = ($gbLeader - $team["GAME_DIFF"]) / 2;
			$gamesBehind == 0 ? $gamesBehind = "-" : $gamesBehind = $gamesBehind;

			echo "<tr>";
			echo "<td class=gSGRowEvenStatsGrid align=left> &nbsp;<a href=viewteam.php?teamID=" . $team["TEAMNUM"] .">" .  $team["CITYNAME"] . " " . $team["TEAMNAME"] . "</a></td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $team["TOTAL_WIN"] ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $team["TOTAL_LOSS"] ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $win_percent ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $team["HOME_WIN"] ."</td>";
//			echo "<td class=gSGRowEvenStatsGrid align=right> " . $team["GAME_DIFF"] ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $team["AWAY_WIN"] ."</td>";
//			echo "<td class=gSGRowEvenStatsGrid align=right> " . $team["AWAY_LOSS"] ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $team["POINTS_FOR"] ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $team["POINTS_AGAINST"] ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $win_perc ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . $gamesBehind ."</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> </td></tr>";


		if ($team["DIVISION_NAME"] != $c_division_name) {
			echo "</table>";
		}
	}


}

function createConferenceStandings($division, $gbLeader) {
	$c_division_name = "";
	
		echo "<table border=0 cellpadding=0 cellspacing=0 class=gSGTableStandings width=100%>";
		echo "<tr class=gSGSectionColumnHeadingsStandings>";
		echo "<td NOWRAP align=left width=100 class=gSGSectionColumnHeadingsStandings><b>&nbsp;</b></td>";
		echo "<td NOWRAP align=right width=30 class=gSGSectionColumnHeadingsStandings><b>W</b></td>";
		echo "<td NOWRAP align=right width=30 class=gSGSectionColumnHeadingsStandings><b>L</b></td>";
		echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>%</b></td>";
		echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>HW</b></td>";
		echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>RW</b></td>";
		echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>PF</b></td>";
		echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>PA</b></td>";
		echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>%</b></td>";
		echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>GB</b></td>";
		echo "<td NOWRAP align=right width=5 class=gSGSectionColumnHeadingsStandings><b> </b></td>";
		echo "</tr>";

	$i = 1;
	
	foreach ($division as $team ) {
		$win_percent = sprintf("%01.3f", $team["WIN_PERCENT"]);
		$win_perc    = sprintf("%01.2f", $team["WIN_PERC"]);
		$gamesBehind = ($gbLeader - $team["GAME_DIFF"]) /2 ;
		
		$gamesBehind == 0 ? $gamesBehind = "-" : $gamesBehind = $gamesBehind;

		if ($i <= 8) {
			$rowclass = "abc bgcolor=#FFFFDD";

		} else {

			$rowclass = "gSGRowEvenStatsGrid";
		}


		echo "<tr>";
		echo "<td class=$rowclass align=left> &nbsp;<a href=viewteam.php?teamID=" . $team["TEAMNUM"] .">" .  $team["CITYNAME"] . " " . $team["TEAMNAME"] . "</a></td>";
		echo "<td class=$rowclass align=right> " . $team["TOTAL_WIN"] ."</td>";
		echo "<td class=$rowclass align=right> " . $team["TOTAL_LOSS"] ."</td>";
		echo "<td class=$rowclass align=right> " . $win_percent ."</td>";
		echo "<td class=$rowclass align=right> " . $team["HOME_WIN"] ."</td>";
		echo "<td class=$rowclass align=right> " . $team["AWAY_WIN"] ."</td>";
		echo "<td class=$rowclass align=right> " . $team["POINTS_FOR"] ."</td>";
		echo "<td class=$rowclass align=right> " . $team["POINTS_AGAINST"] ."</td>";
		echo "<td class=$rowclass align=right> " . $win_perc ."</td>";
		echo "<td class=$rowclass align=right> " . $gamesBehind ."</td>";
		echo "<td class=$rowclass align=right> </td></tr>";

		$i++;
}
}



function createStandingsSQL() {


$sql = "

SELECT	 (COALESCE(HOME_WIN,0) + COALESCE(AWAY_WIN,0)) - (COALESCE(HOME_LOSS,0) + COALESCE(AWAY_LOSS,0)) as GAME_DIFF
		,TM.TEAMNUM
		,TM.TEAMNAME
		,TM.CITYNAME
		,CO.CONFERENCE_NAME
		,DI.DIVISION_NAME
		,COALESCE(HOME_WIN,0) AS HOME_WIN
		,COALESCE(AWAY_WIN,0) AS AWAY_WIN
		,COALESCE(HOME_WIN,0) + COALESCE(AWAY_WIN,0) AS TOTAL_WIN
		,COALESCE(HOME_LOSS,0) AS HOME_LOSS
		,COALESCE(AWAY_LOSS,0) AS AWAY_LOSS
		,COALESCE(HOME_LOSS,0) + COALESCE(AWAY_LOSS,0) AS TOTAL_LOSS
		,COALESCE(((COALESCE(HOME_WIN  + 0.00,0.00)  + COALESCE(AWAY_WIN + 0.00,0.00) ) / (COALESCE(HOME_LOSS + 0.00,0.00) + COALESCE(AWAY_LOSS + 0.00,0.00) + COALESCE(HOME_WIN + 0.00,0.00) + COALESCE(AWAY_WIN + 0.00,0.00))) + 0.00,0.00) AS WIN_PERCENT 
		,COALESCE(HOME_FORFEIT_COUNT,0) + COALESCE(AWAY_FORFEIT_COUNT,0) AS TOTAL_FORFEIT_COUNT
		,COALESCE(HOME_TEAM_HOME_POINTS,0) + COALESCE(AWAY_TEAM_AWAY_POINTS,0) AS POINTS_FOR
		,COALESCE(HOME_TEAM_AWAY_POINTS,0) + COALESCE(AWAY_TEAM_HOME_POINTS,0) AS POINTS_AGAINST
		,COALESCE((((COALESCE(HOME_TEAM_HOME_POINTS + 0.00,0.00) + COALESCE(AWAY_TEAM_AWAY_POINTS + 0.00,0.00)) / (COALESCE(HOME_TEAM_AWAY_POINTS + 0.00,0.00) + COALESCE(AWAY_TEAM_HOME_POINTS + 0.00,0.00))) ) + 0.00,0.00) AS WIN_PERC
	
	FROM TEAMS TM
	LEFT JOIN
	(SELECT   HOME_TEAM
		,SUM(CASE WHEN HOME_SCORE > AWAY_SCORE THEN '1' ELSE '0' END) AS HOME_WIN
		,SUM(CASE WHEN HOME_SCORE < AWAY_SCORE OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS HOME_LOSS
		,SUM(AWAY_SCORE) AS HOME_TEAM_AWAY_POINTS
		,SUM(HOME_SCORE) AS HOME_TEAM_HOME_POINTS
		,SUM(CASE WHEN (HOME_TEAM = FORFEIT) OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS HOME_FORFEIT_COUNT
	FROM SCHEDULE SH
	WHERE SH.PLAYED = 1 AND SH.GAME_TYPE = 0 
AND SH.SCHEDULE_ID IN (
			SELECT SCHEDULE_ID 
			FROM SCHEDULE SH
			INNER JOIN SEASON SE
			ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
	)	GROUP BY 1
	) AS HOME_GAME
	ON HOME_GAME.HOME_TEAM = TM.TEAMNUM
	

	LEFT JOIN
	(SELECT   AWAY_TEAM
		,SUM(CASE WHEN HOME_SCORE < AWAY_SCORE THEN '1' ELSE '0' END) AS AWAY_WIN
		,SUM(CASE WHEN HOME_SCORE > AWAY_SCORE OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS AWAY_LOSS
		,SUM(AWAY_SCORE) AS AWAY_TEAM_AWAY_POINTS
		,SUM(HOME_SCORE) AS AWAY_TEAM_HOME_POINTS
		,SUM(CASE WHEN (AWAY_TEAM = FORFEIT) OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS AWAY_FORFEIT_COUNT

	FROM SCHEDULE SH
	WHERE SH.PLAYED = 1 AND SH.GAME_TYPE = 0 
	AND SH.SCHEDULE_ID IN (
				SELECT SCHEDULE_ID 
				FROM SCHEDULE SH
				INNER JOIN SEASON SE
				ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
				AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
	)
	
	GROUP BY 1
	) AS AWAY_GAME
	ON AWAY_GAME.AWAY_TEAM = TM.TEAMNUM

	LEFT JOIN CONFERENCE CO
	ON CO.CONFERENCE = TM.CONFERENCE

	LEFT JOIN DIVISION DI
	ON DI.DIVISION = TM.DIVISION
	
	WHERE TM.TEAMNUM < 29
ORDER BY CO.CONFERENCE, DI.DIVISION, WIN_PERCENT DESC, TOTAL_FORFEIT_COUNT ASC, WIN_PERC DESC, TOTAL_WIN DESC, TM.TEAMNUM
";

return ($sql);

}


function createStandingsSeasonSQL($seasonID) {

$sql = "

SELECT	 (COALESCE(HOME_WIN,0) + COALESCE(AWAY_WIN,0)) - (COALESCE(HOME_LOSS,0) + COALESCE(AWAY_LOSS,0)) as GAME_DIFF
		,TM.TEAMNUM
		,TM.TEAMNAME
		,TM.CITYNAME
		,CO.CONFERENCE_NAME
		,DI.DIVISION_NAME
		,COALESCE(HOME_WIN,0) AS HOME_WIN
		,COALESCE(AWAY_WIN,0) AS AWAY_WIN
		,COALESCE(HOME_WIN,0) + COALESCE(AWAY_WIN,0) AS TOTAL_WIN
		,COALESCE(HOME_LOSS,0) AS HOME_LOSS
		,COALESCE(AWAY_LOSS,0) AS AWAY_LOSS
		,COALESCE(HOME_LOSS,0) + COALESCE(AWAY_LOSS,0) AS TOTAL_LOSS
		,COALESCE(((COALESCE(HOME_WIN  + 0.00,0.00)  + COALESCE(AWAY_WIN + 0.00,0.00) ) / (COALESCE(HOME_LOSS + 0.00,0.00) + COALESCE(AWAY_LOSS + 0.00,0.00) + COALESCE(HOME_WIN + 0.00,0.00) + COALESCE(AWAY_WIN + 0.00,0.00))) + 0.00,0.00) AS WIN_PERCENT 
		,COALESCE(HOME_FORFEIT_COUNT,0) + COALESCE(AWAY_FORFEIT_COUNT,0) AS TOTAL_FORFEIT_COUNT
		,COALESCE(HOME_TEAM_HOME_POINTS,0) + COALESCE(AWAY_TEAM_AWAY_POINTS,0) AS POINTS_FOR
		,COALESCE(HOME_TEAM_AWAY_POINTS,0) + COALESCE(AWAY_TEAM_HOME_POINTS,0) AS POINTS_AGAINST
		,COALESCE((((COALESCE(HOME_TEAM_HOME_POINTS + 0.00,0.00) + COALESCE(AWAY_TEAM_AWAY_POINTS + 0.00,0.00)) / (COALESCE(HOME_TEAM_AWAY_POINTS + 0.00,0.00) + COALESCE(AWAY_TEAM_HOME_POINTS + 0.00,0.00))) ) + 0.00,0.00) AS WIN_PERC
	
	FROM TEAMS TM
	LEFT JOIN
	(SELECT   HOME_TEAM
		,SUM(CASE WHEN HOME_SCORE > AWAY_SCORE THEN '1' ELSE '0' END) AS HOME_WIN
		,SUM(CASE WHEN HOME_SCORE < AWAY_SCORE OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS HOME_LOSS
		,SUM(AWAY_SCORE) AS HOME_TEAM_AWAY_POINTS
		,SUM(HOME_SCORE) AS HOME_TEAM_HOME_POINTS
		,SUM(CASE WHEN (HOME_TEAM = FORFEIT) OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS HOME_FORFEIT_COUNT
	FROM SCHEDULE SH
	WHERE SH.PLAYED = 1 AND SH.GAME_TYPE = 0 
AND SH.SCHEDULE_ID IN (
			SELECT SCHEDULE_ID 
			FROM SCHEDULE SH
			INNER JOIN SEASON SE
			ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND SE.SEASON_ID = $seasonID
	)	GROUP BY 1
	) AS HOME_GAME
	ON HOME_GAME.HOME_TEAM = TM.TEAMNUM
	

	LEFT JOIN
	(SELECT   AWAY_TEAM
		,SUM(CASE WHEN HOME_SCORE < AWAY_SCORE THEN '1' ELSE '0' END) AS AWAY_WIN
		,SUM(CASE WHEN HOME_SCORE > AWAY_SCORE OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS AWAY_LOSS
		,SUM(AWAY_SCORE) AS AWAY_TEAM_AWAY_POINTS
		,SUM(HOME_SCORE) AS AWAY_TEAM_HOME_POINTS
		,SUM(CASE WHEN (AWAY_TEAM = FORFEIT) OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS AWAY_FORFEIT_COUNT

	FROM SCHEDULE SH
	WHERE SH.PLAYED = 1 AND SH.GAME_TYPE = 0 
	AND SH.SCHEDULE_ID IN (
				SELECT SCHEDULE_ID 
				FROM SCHEDULE SH
				INNER JOIN SEASON SE
				ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
				AND SE.SEASON_ID = $seasonID
	)
	
	GROUP BY 1
	) AS AWAY_GAME
	ON AWAY_GAME.AWAY_TEAM = TM.TEAMNUM

	LEFT JOIN CONFERENCE CO
	ON CO.CONFERENCE = TM.CONFERENCE

	LEFT JOIN DIVISION DI
	ON DI.DIVISION = TM.DIVISION
	
	WHERE TM.TEAMNUM < 29
ORDER BY CO.CONFERENCE, DI.DIVISION, WIN_PERCENT DESC, TOTAL_FORFEIT_COUNT ASC, WIN_PERC DESC, TOTAL_WIN DESC, TM.TEAMNUM
";

return ($sql);

}

function createConfStandingsSeasonSQL($seasonID) {

$sql = "

SELECT	 (COALESCE(HOME_WIN,0) + COALESCE(AWAY_WIN,0)) - (COALESCE(HOME_LOSS,0) + COALESCE(AWAY_LOSS,0)) as GAME_DIFF
		,COALESCE(((COALESCE(HOME_WIN  + 0.00,0.00)  + COALESCE(AWAY_WIN + 0.00,0.00) ) / (COALESCE(HOME_LOSS + 0.00,0.00) + COALESCE(AWAY_LOSS + 0.00,0.00) + COALESCE(HOME_WIN + 0.00,0.00) + COALESCE(AWAY_WIN + 0.00,0.00))) + 0.00,0.00) AS WIN_PERCENT 
		,COALESCE(HOME_FORFEIT_COUNT,0) + COALESCE(AWAY_FORFEIT_COUNT,0) AS TOTAL_FORFEIT_COUNT
		,COALESCE((((COALESCE(HOME_TEAM_HOME_POINTS + 0.00,0.00) + COALESCE(AWAY_TEAM_AWAY_POINTS + 0.00,0.00)) / (COALESCE(HOME_TEAM_AWAY_POINTS + 0.00,0.00) + COALESCE(AWAY_TEAM_HOME_POINTS + 0.00,0.00))) ) + 0.00,0.00) AS WIN_PERC
		,TM.TEAMNUM
		,TM.TEAMNAME
		,TM.CITYNAME
		,CO.CONFERENCE_NAME
		,DI.DIVISION_NAME
		,COALESCE(HOME_WIN,0) AS HOME_WIN
		,COALESCE(AWAY_WIN,0) AS AWAY_WIN
		,COALESCE(HOME_WIN,0) + COALESCE(AWAY_WIN,0) AS TOTAL_WIN
		,COALESCE(HOME_LOSS,0) AS HOME_LOSS
		,COALESCE(AWAY_LOSS,0) AS AWAY_LOSS
		,COALESCE(HOME_LOSS,0) + COALESCE(AWAY_LOSS,0) AS TOTAL_LOSS
		,COALESCE(HOME_TEAM_HOME_POINTS,0) + COALESCE(AWAY_TEAM_AWAY_POINTS,0) AS POINTS_FOR
		,COALESCE(HOME_TEAM_AWAY_POINTS,0) + COALESCE(AWAY_TEAM_HOME_POINTS,0) AS POINTS_AGAINST

	
	FROM TEAMS TM
	LEFT JOIN
	(SELECT   HOME_TEAM
		,SUM(CASE WHEN HOME_SCORE > AWAY_SCORE THEN '1' ELSE '0' END) AS HOME_WIN
		,SUM(CASE WHEN HOME_SCORE < AWAY_SCORE OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS HOME_LOSS
		,SUM(AWAY_SCORE) AS HOME_TEAM_AWAY_POINTS
		,SUM(HOME_SCORE) AS HOME_TEAM_HOME_POINTS
		,SUM(CASE WHEN (HOME_TEAM = FORFEIT) OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS HOME_FORFEIT_COUNT
		
	FROM SCHEDULE SH
	WHERE SH.PLAYED = 1 AND SH.GAME_TYPE = 0 
AND SH.SCHEDULE_ID IN (
			SELECT SCHEDULE_ID 
			FROM SCHEDULE SH
			INNER JOIN SEASON SE
			ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND SE.SEASON_ID = $seasonID
	)	GROUP BY 1
	) AS HOME_GAME
	ON HOME_GAME.HOME_TEAM = TM.TEAMNUM
	

	LEFT JOIN
	(SELECT   AWAY_TEAM
		,SUM(CASE WHEN HOME_SCORE < AWAY_SCORE THEN '1' ELSE '0' END) AS AWAY_WIN
		,SUM(CASE WHEN HOME_SCORE > AWAY_SCORE OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS AWAY_LOSS
		,SUM(AWAY_SCORE) AS AWAY_TEAM_AWAY_POINTS
		,SUM(HOME_SCORE) AS AWAY_TEAM_HOME_POINTS
		,SUM(CASE WHEN (AWAY_TEAM = FORFEIT) OR (HOME_SCORE = 0 AND AWAY_SCORE = 0) THEN '1' ELSE '0' END) AS AWAY_FORFEIT_COUNT


	FROM SCHEDULE SH
	WHERE SH.PLAYED = 1 AND SH.GAME_TYPE = 0 
	AND SH.SCHEDULE_ID IN (
				SELECT SCHEDULE_ID 
				FROM SCHEDULE SH
				INNER JOIN SEASON SE
				ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
				AND SE.SEASON_ID = $seasonID
	)
	
	GROUP BY 1
	) AS AWAY_GAME
	ON AWAY_GAME.AWAY_TEAM = TM.TEAMNUM

	LEFT JOIN CONFERENCE CO
	ON CO.CONFERENCE = TM.CONFERENCE

	LEFT JOIN DIVISION DI
	ON DI.DIVISION = TM.DIVISION
	
	WHERE TM.TEAMNUM < 29
ORDER BY CO.CONFERENCE, WIN_PERCENT DESC, TOTAL_FORFEIT_COUNT ASC, WIN_PERC DESC, TOTAL_WIN DESC, TM.TEAMNUM
";

return ($sql);

}

function createScoreBoardTeams($homeTeam, $homeTeamID, $homeTeamScore, $awayTeam, $awayTeamID, $awayTeamScore, $scheduleID, $gameDate, $playedDate) {
	$homeTeamArrow = "";
	$awayTeamArrow = "";

	if ($playedDate != "" & $homeTeamScore > $awayTeamScore) {
		$homeTeamArrow = "<img width=8 height=10  src=gameArrow.gif>";
		$awayTeamArrow = "<img width=8 height=10  src=blank.gif>";

	} else if ($playedDate != "" & $homeTeamScore < $awayTeamScore) {
		$awayTeamArrow = "<img width=8 height=10  src=gameArrow.gif>";
		$homeTeamArrow = "<img width=8 height=10  src=blank.gif>";
	}

	echo "<table cellspacing=0 cellpadding=0 border=0 width=100%>";
	echo "<tr><TD width=1 class=liveScoresInsideBoxColor rowspan=7></TD>";
	echo "	<td class=liveScoresInsideBoxColor colspan=2 width=170></td>";
	echo "	<TD width=1 class=liveScoresInsideBoxColor rowspan=7></TD></tr>";
	echo "<tr><td noWrap width=90 class=liveScoresCellRow1>$awayTeamArrow<a class=liveScoresTeamLink href=viewteam.php?teamID=$awayTeamID>$awayTeam</a></td>";
	echo "	<td class=liveScoresCellRow1 align=right>$awayTeamScore&nbsp;</td>";
	echo "</tr><tr>";
	echo "	<td noWrap class=liveScoresCellRow1>$homeTeamArrow<a class=liveScoresTeamLink href=viewteam.php?teamID=$homeTeamID>$homeTeam</a></td>";
	echo "	<td class=liveScoresCellRow1 align=right>$homeTeamScore&nbsp;</td>";
	echo "</tr><tr>";
	echo "	<td height=1 class=liveScoresInsideBoxColor colspan=2></td>";
	echo "</tr><tr>";

	if ($playedDate == "") {
		echo "	<td colspan=2  align=center class=liveScoresCellRow2><small>". date("d/m/Y", strtotime($gameDate)) . "</small></td>";
	} else {
		echo "	<td colspan=2  align=center class=liveScoresCellRow2><a class=liveScoresLink href=viewboxscore.php?scheduleID=$scheduleID>Boxscore</a></td>";
	}

	echo "</tr><tr><TD width=1 class=liveScoresInsideBoxColor colspan=2></TD>";
	echo "</tr><tr><TD width=1 colspan=2></TD>";	
	echo "</tr><tr><TD width=1 colspan=2></TD>";		
	echo "</tr></table>";
}

function createScoreBoard($scoreBoard) {

	echo "<table width=100% border=0 cellpadding=0 cellspacing=0>";
	echo "<TR><TD colspan=3 class=cBTopPlayerInfoBordersGrid>Scoreboard</TD><TD class=cBTopPlayerInfoBordersGrid></TD>	";
	echo "</TR>";
	echo "<TR>";
	echo "	<td width=1 bgcolor=#000000></td>";
	echo "	<td valign=top bgcolor=#FFFFFF>";
	echo "	 <TABLE cellspacing=0 cellpadding=3 width=100% border=0>";

	echo "<TR><TD  valign=top>";

	foreach ($scoreBoard as $gameScore) {
		createScoreBoardTeams($gameScore["HOME_TEAMNAME"], $gameScore["HOME_TEAMNUM"], $gameScore["HOME_SCORE"], $gameScore["AWAY_TEAMNAME"], $gameScore["AWAY_TEAMNUM"], $gameScore["AWAY_SCORE"], $gameScore["SCHEDULE_ID"], $gameScore["GAME_DATE"], $gameScore["PLAYED_DATE"]);
	} 

	if (count($scoreBoard) == 0) {	
		echo "<table cellspacing=0 cellpadding=0 border=0 width=100%>";
		echo "<tr><TD noWrap class=liveScoresCellRow1 rowspan=7>No games played</TD>";
		echo "</tr></table>";
	}

	echo "</td></TR>";
	echo "	</TABLE>";
	echo "	</td>";
	echo "	<td width=1 bgcolor=#000000></td>";
	echo "</tr><tr><td height=1 colspan=3 bgcolor=#000000></td>";
	echo "</tr></table>";
}



function createNightlyLeaderSQL($statType) {

$sql = "

	SELECT	
			 PLR.FNAME
			,PLR.NAME
			,PLR.PLAYERID
			,TM.ABBREV
			,TM.TEAMNUM
			,PST.$statType
		FROM 
		(SELECT * FROM SCHEDULE ORDER BY PLAYED_DATE DESC, SCHEDULE_ID LIMIT 27)AS SH


		INNER JOIN PLAYERSTATS PST
		ON SH.SCHEDULE_ID = PST.SCHEDULE_ID
		AND PST.PLAYED = 1

		AND PST.SCHEDULE_ID IN (
			SELECT SCHEDULE_ID 
			FROM SCHEDULE SH
			INNER JOIN SEASON SE
			ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		)	

		INNER JOIN PLAYERS PLR
		ON PST.PLAYERID = PLR.PLAYERID

		INNER JOIN TEAMS TM
		ON TM.TEAMNUM = PLR.TEAM

		INNER JOIN POSITION POS
		ON PLR.POSITION = POS.POSITION

		order by PST.$statType DESC, PST.MINS, PLAYED_DATE DESC, SH.SCHEDULE_ID ASC
	LIMIT 5
";

	return($sql);

}


function createNightlyLeaders(){
	include('config.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$statArray = array("POINTS","REBOUNDS","ASSISTS","STEALS","BLOCKS");


	echo "<table width=100% border=0 cellpadding=0 cellspacing=0>";
	echo "<TR><TD colspan=3 class=cBTopPlayerInfoBordersGrid>Last 27 Leaders</TD><TD class=cBTopPlayerInfoBordersGrid></TD>	";
	echo "</TR>";
	echo "<TR>";
	echo "	<td width=1 bgcolor=#000000></td>";
	echo "	<td valign=top bgcolor=#FFFFFF>";
	echo "	 <TABLE cellspacing=0 cellpadding=3 width=100% border=0>";

	echo "<TR><TD  valign=top>";

	foreach ($statArray as $statType) {
		$sql = createNightlyLeaderSQL($statType);
	
		if ( !($result = $db->sql_query($sql)) )
		{
			echo "failed";
		}
		$row = $db->sql_fetchrowset($result);
		createNightlyLeadersStat($statType,$row);
	}

	echo "</td></TR>";
	echo "	</TABLE>";
	echo "	</td>";
	echo "	<td width=1 bgcolor=#000000></td>";
	echo "</tr><tr><td height=1 colspan=3 bgcolor=#000000></td>";
	echo "</tr></table>";
}



function createNightlyLeadersStat($statName, $playerList) {
	echo "<TABLE cellSpacing=0 cellPadding=0 width=100% border=0>";
	echo "<TR>";
	echo "	<TD class=nightlyLeadersTitle>&nbsp;$statName </TD>";
	echo "</TR>";
	echo "<TR>";
	echo "	<TD vAlign=top>";
	echo "		<TABLE cellSpacing=0 cellPadding=0 width=100% border=0>";

	foreach ($playerList as $playerInfo) {
		$playerName = trim(substr($playerInfo["FNAME"],0,1) . " " . $playerInfo["NAME"]);
		$playerID = $playerInfo["PLAYERID"];
		$teamID = $playerInfo["TEAMNUM"];
		$teamAbbr = $playerInfo["ABBREV"];
		$statCount = $playerInfo[$statName];
	
		echo "		<TR>";
		echo "		<TD class=nightlyLeadersData><a class=liveScoresLink href=viewplayer.php?playerID=$playerID>&nbsp;$playerName</A></TD>";
		echo "		<TD align=middle class=nightlyLeadersData width=25> <a class=liveScoresLink href=viewteam.php?teamID=$teamID>$teamAbbr</A></TD>";
		echo "		<TD align=middle class=nightlyLeadersData width=15>$statCount </TD>";
		echo "		</TR>";
	}
	
	if (count($playerList) == 0) {
		echo "		<TR>";
		echo "		<TD align=middle class=nightlyLeadersData colspan=3>No Games Played</TD>";
		echo "		</TR>";
	}
	echo "		</TABLE>";
	echo "	</TD>";
	echo "</TR>";
	echo "</TABLE>";
}


function createSeasonList($seasonList) {

	echo "<form id=teambox><select onchange=\"javascript:if( options[selectedIndex].value != 'Season') document.location = options[selectedIndex].value\" name=\"url\">";
	echo "<OPTION selected>Season</option>";
	foreach($seasonList as $season) {
		$seasonID = $season["SEASON_ID"];
		$seasonDesc = $season["SEASON"];
		echo "<OPTION value=\"viewstandings.php?seasonID=$seasonID\">$seasonDesc</option>";
	}
	echo "</select></form>";

}

function createConfSeasonList($seasonList) {

	echo "<form id=teambox><select onchange=\"javascript:if( options[selectedIndex].value != 'Season') document.location = options[selectedIndex].value\" name=\"url\">";
	echo "<OPTION selected>Season</option>";
	foreach($seasonList as $season) {
		$seasonID = $season["SEASON_ID"];
		$seasonDesc = $season["SEASON"];
		echo "<OPTION value=\"viewstandings.php?seasonID=$seasonID&viewType=conf\">$seasonDesc</option>";
	}
	echo "</select></form>";

}




function createDailyConferenceStandings($eastern, $eastGamesBehind, $western, $westGamesBehind) {


echo "
<table cellspacing=0 cellpadding=0 border=0 width=100%> 
<tr> 
	<td class=gSGSectionColumnHeadingsStandings align=left colspan=3> <div class=cBTitle>CONFERENCE STANDINGS</div></td> 
</tr> 
<tr> 
	<td class=cBSide nowrap=nowrap width=1><br /></td> 
	<td valign=top align=left width=100% height=100%> 
		<table> 
    	<tr> 
			<td valign=top align=middle><img height=65 src=log_east_sm.gif width=65 /> </td> 
			<td valign=top rowspan=2><img height=1 src=blank.gif width=4 /></td> 
			<td valign=top align=middle><img height=65 src=log_west_sm.gif width=65 /> </td> 
		</tr> 
		<tr> 
			<td valign=top align=left>
				<table class=gSGTableStatsGrid cellspacing=0 cellpadding=0 width=291 border=0> 
					<tr class=gSGSectionColumnHeadingsStatsGrid> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=left width=95><b>&nbsp; Eastern</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=25><b>W</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=25><b>L</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=45><b>PCT</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=25><b>F</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=25><b>GB&nbsp;</b></td> 
					</tr> ";
                    
					$rowclass = "gSGRowEvenStatsGrid";

					foreach ($eastern as $team ) {
						$win_percent = sprintf("%01.3f", $team["WIN_PERCENT"]);
						$gamesBehind = ($eastGamesBehind - $team["GAME_DIFF"]) /2 ;
						$forfeits = $team["TOTAL_FORFEIT_COUNT"];

						$gamesBehind == 0 ? $gamesBehind = "-" : $gamesBehind = $gamesBehind;
                    
						echo "<tr> ";
						echo "  <td class=$rowclass align=left> &nbsp;<a href=viewteam.php?teamID=" . $team["TEAMNUM"] .">" .  $team["CITYNAME"] . " " . $team["TEAMNAME"] . "</a></td> ";
						echo "  <td class=$rowclass align=right>" . $team["TOTAL_WIN"] ."</td> ";
						echo "  <td class=$rowclass align=right>" . $team["TOTAL_LOSS"] ."</td> ";
						echo "  <td class=$rowclass align=right>$win_percent</td> ";
						echo "  <td class=$rowclass align=right>$forfeits</td> ";
						echo "  <td class=$rowclass align=right>$gamesBehind&nbsp;</td> ";
						echo "</tr> ";

						$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	
					}
			echo "
				</table> 
			</td> 
			<td valign=top align=right>
				<table class=gSGTableStatsGrid cellspacing=0 cellpadding=0 width=291 border=0> 
				<tr class=gSGSectionColumnHeadingsStatsGrid> 
					<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=left width=95><b>&nbsp; Western</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=25><b>W</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=25><b>L</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=45><b>PCT</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=25><b>F</b></td> 
						<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=25><b>GB&nbsp;</b></td> 
				</tr> ";
					$rowclass = "gSGRowEvenStatsGrid";

					foreach ($western as $team ) {
						$win_percent = sprintf("%01.3f", $team["WIN_PERCENT"]);
						$gamesBehind = ($westGamesBehind - $team["GAME_DIFF"]) /2 ;
						$forfeits = $team["TOTAL_FORFEIT_COUNT"];

						$gamesBehind == 0 ? $gamesBehind = "-" : $gamesBehind = $gamesBehind;
                    
						echo "<tr> ";
						echo "  <td class=$rowclass align=left> &nbsp;<a href=viewteam.php?teamID=" . $team["TEAMNUM"] .">" .  $team["CITYNAME"] . " " . $team["TEAMNAME"] . "</a></td> ";
						echo "  <td class=$rowclass align=right>" . $team["TOTAL_WIN"] ."</td> ";
						echo "  <td class=$rowclass align=right>" . $team["TOTAL_LOSS"] ."</td> ";
						echo "  <td class=$rowclass align=right>$win_percent</td> ";
						echo "  <td class=$rowclass align=right>$forfeits</td> ";
						echo "  <td class=$rowclass align=right>$gamesBehind&nbsp;</td> ";
						echo "</tr> ";

						$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	
					}


	echo "
				</table> 
			</td> 
		</tr> 
		<tr> 
			<td class=gSGSectionFooter colspan=3><!--   &nbsp;x-Clinched Playoff Berth | <br> &nbsp;e-Clinched Eastern Conference | a-Clinched Atlantic Division | c-Clinched Central Division | <br> &nbsp;w-Clinched Western Conference | m-Clinched Midwest Division | p-Clinched Pacific Division --></td> 
		</tr> 
        </table>
	</td> 
	<td class=cBSide nowrap=nowrap width=0><br></td> 
</tr> 
<tr> 
	<td class=cBBottom colspan=3 height=0><img height=1 src=blank.gif></td> 
</tr> 
</table> ";

}

function createDailyGameRecap($scoreBoard) {
echo "
<table cellspacing=0 cellpadding=0 width=100% border=0> 
<tr> 
	<td class=gSGSectionColumnHeadingsStandings align=left colspan=3 height=1> <div class=cBTitle>PLAYED GAMES</div></td> 
</tr> 
<tr> 
	<td class=cBSide nowrap=nowrap width=1><br /></td> 
	<td class=cBComp valign=top align=left height=100%> 
		<table class=gSGTableStatsGrid cellspacing=0 cellpadding=0 width=294 border=0> 
		<tr class=gSGSectionColumnHeadingsStatsGrid> 
			<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=left width=120><b>&nbsp; FINAL</b></td> 
			<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=middle width=70><b>BOX SCORE</b></td> 
			<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=90><b>HIGH SCORER</b></td> 
		</tr> ";

	if (count($scoreBoard) == 0 ) {
		echo "<tr> ";
		echo "	<td class=gSGRowEvenStatsGrid valign=top align=middle colspan=3>&nbsp;<b>NO GAMES PLAYED</b></td> ";
		echo "</tr> ";
	}

	$rowclass = "gSGRowEvenStatsGrid";

	foreach ($scoreBoard as $gameScore) {
		//echo "<pre>";
		//print_r($gameScore);

		$HOME_ABBREV = $gameScore["HOME_ABBREV"];
		$HOME_SCORE = $gameScore["HOME_SCORE"];
		$AWAY_ABBREV = $gameScore["AWAY_ABBREV"];
		$AWAY_SCORE = $gameScore["AWAY_SCORE"];
		$SCHEDULE_ID = $gameScore["SCHEDULE_ID"];
		$PLAYERID = $gameScore["PLAYERID"];
		$PLAYERNAME = $gameScore["NAME"];
		$POINTS = $gameScore["POINTS"];
		$OT = $gameScore["OVERTIME"];

		switch ($OT) {
			case 0: $OT = "";
				break;

			case 1: $OT = "OT";
				break;
		
			default: $OT = $OT. "OT";
		}

		
//		$OT > 0 ? $OT = $OT . "OT": $OT = "";

		if ($SCHEDULE_ID != $prevSchedID) {
			echo "<tr> ";
			echo "	<td class=$rowclass valign=top align=left>&nbsp;<b>$AWAY_ABBREV $AWAY_SCORE @ $HOME_ABBREV $HOME_SCORE </b><small>$OT</small></td> ";
			echo "	<td class=$rowclass valign=top align=middle><a class=gSGBoxScoreLink href=viewboxscore.php?scheduleID=$SCHEDULE_ID>Box Score</a></td> ";
			echo "	<td class=$rowclass valign=top align=right><a class=gSGPlayerLink href=viewplayer.php?playerID=$PLAYERID><b>$PLAYERNAME</b> </a>($POINTS)</td> ";
			echo "</tr> ";
		} else {
			$rowclass = $prevRowClass;
			echo "<tr> ";
			echo "	<td class=$rowclass valign=top align=left>&nbsp;</td> ";
			echo "	<td class=$rowclass valign=top align=middle>&nbsp;</td> ";
			echo "	<td class=$rowclass valign=top align=right><a class=gSGPlayerLink href=viewplayer.php?playerID=$PLAYERID><b>$PLAYERNAME</b> </a>($POINTS)</td> ";
			echo "</tr> ";
		}

		$prevSchedID = $gameScore["SCHEDULE_ID"];
		$prevRowClass = $rowclass;
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	
	} 


echo "
		</table>
	</td> 
	<td class=cBSide nowrap=nowrap width=1><br /></td> 
</tr> 
<tr> 
	<td class=cBBottom colspan=3 height=1><img height=1 src=blank.gif></td> 
</tr> 
</table> 
";

}

function createDailyUpcomingGames($scoreBoard) {
echo "
<table cellspacing=0 cellpadding=0 width=100% border=0> 
<tr> 
	<td class=gSGSectionColumnHeadingsStandings align=left colspan=3 height=1> <div class=cBTitle>UPCOMING GAMES</div></td> 
</tr> 
<tr> 
	<td class=cBSide nowrap=nowrap width=1><br /></td> 
	<td class=cBComp valign=top align=left height=100%> 
		<table class=gSGTableStatsGrid cellspacing=0 cellpadding=0 width=294 border=0> 
		<tr class=gSGSectionColumnHeadingsStatsGrid> 
			<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=left width=150><b>&nbsp; GAME</b></td> 
			<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=middle width=10><b>&nbsp;</b></td> 
			<td class=gSGSectionColumnHeadingsStatsGrid nowrap=nowrap align=right width=58><b>&nbsp;</b></td> 
		</tr> ";

	if (count($scoreBoard) == 0 ) {
		echo "<tr> ";
		echo "	<td class=gSGRowEvenStatsGrid valign=top align=middle colspan=3>&nbsp;<b>ROUND OVER</b></td> ";
		echo "</tr> ";
	}

	$rowclass = "gSGRowEvenStatsGrid";

	foreach ($scoreBoard as $gameScore) {
		//echo "<pre>";
		//print_r($gameScore);

		$HOME_TEAMNAME = $gameScore["HOME_TEAMNAME"];
		$HOME_SCORE = $gameScore["HOME_SCORE"];
		$HOME_TEAMNUM = $gameScore["HOME_TEAMNUM"];
		$AWAY_TEAMNAME = $gameScore["AWAY_TEAMNAME"];
		$AWAY_SCORE = $gameScore["AWAY_SCORE"];
		$AWAY_TEAMNUM = $gameScore["AWAY_TEAMNUM"];

		$SCHEDULE_ID = $gameScore["SCHEDULE_ID"];
		$subScore = "<a href=admin\submitscore.php?SCHEDULE_ID=$SCHEDULE_ID&HOME_TEAMNUM=$HOME_TEAMNUM&AWAY_TEAMNUM=$AWAY_TEAMNUM>Submit Score</a>"  ;

//<a href=viewteam.php?teamID=$HOME_TEAMNUM>$HOME_TEAMNAME</a>

		echo "<tr> ";
		echo "	<td class=$rowclass valign=top align=left>&nbsp;<a href=viewteam.php?teamID=$AWAY_TEAMNUM>$AWAY_TEAMNAME</a> at <a href=viewteam.php?teamID=$HOME_TEAMNUM>$HOME_TEAMNAME</a></td> ";
		echo "	<td class=$rowclass valign=top align=middle>&nbsp;</td> ";
		echo "	<td class=$rowclass valign=top align=right>$subScore &nbsp;</td> ";
		echo "</tr> ";

		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	
	} 


echo "
		</table>
	</td> 
	<td class=cBSide nowrap=nowrap width=1><br /></td> 
</tr> 
<tr> 
	<td class=cBBottom colspan=3 height=1><img height=1  src=blank.gif /></td> 
</tr> 
</table> 
";

}


function createLeagueLeadersSQL($statType) {
	$sql = "
		SELECT 	 PL.FNAME
			,PL.NAME
			,TM.ABBREV
			,TM.TEAMNUM
			,PS.PLAYERID
			,PS.STAT_PG
		FROM (
		SELECT	 PS.PLAYERID AS PLAYERID
			,SUM(PS.$statType) as STATS_TOTAL
			,SUM(PS.$statType + 0.00) / (SUM(PS.PLAYED) + 0.00) as STAT_PG
			,SUM(PS.PLAYED) as GAME_COUNT

		FROM PLAYERSTATS PS

		INNER JOIN SCHEDULE SH
		ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
		AND PS.PLAYED = 1

		INNER JOIN SEASON SE
		ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		GROUP BY 1

		ORDER BY STAT_PG DESC, STATS_TOTAL
		LIMIT 5) AS PS

		INNER JOIN PLAYERS PL
		ON PS.PLAYERID = PL.PLAYERID

		INNER JOIN TEAMS TM
		ON PL.TEAM = TM.TEAMNUM

		ORDER BY PS.STAT_PG DESC, PS.STATS_TOTAL DESC, PS.GAME_COUNT, PL.NAME, PL.FNAME
	";
	return $sql;

}


function createLeagueLeaders() {
	include('config.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
	
	$statArray = array("POINTS","REBOUNDS","ASSISTS","STEALS");

	foreach ($statArray as $statType) {
		$sql = createLeagueLeadersSQL($statType);
	
		if ( !($result = $db->sql_query($sql)) )
		{
			echo "failed";
		}
		$row = $db->sql_fetchrowset($result);

		$LL[] = $row;
	}

echo "<TABLE cellSpacing=0 cellPadding=0 border=0> 
    <TR> 
      <TD> <TABLE cellSpacing=0 cellPadding=0 border=0> 
            <TR> 
              <TD class=cBSpacing colSpan=3><IMG height=1 src=blank.gif></TD> 
            </TR> 
            <TR> 
              <TD class=gSGSectionColumnHeadingsStandings colSpan=3> <DIV class=cBTitle>LEADERS</DIV></TD> 
            </TR> 
            <TR> 
              <TD class=cBSide noWrap><BR></TD> 
              <TD class=cBComp vAlign=top align=left width=100% height=100%> <TABLE cellSpacing=0 cellPadding=0 width=600> 
                    <TR> 
                      <TD vAlign=top align=left>
                        <TABLE class=gSGTableStatsGrid cellSpacing=0 cellPadding=0 width=298 border=0> 
                            <TR class=gSGSectionColumnHeadingsStatsGrid> 
                              <TD class=gSGSectionColumnHeadingsStatsGrid noWrap align=left width=200><B>&nbsp; POINTS</B></TD> 
                              <TD class=gSGSectionColumnHeadingsStatsGrid noWrap align=left width=25><B>AVG</B></TD> 
                            </TR> ";
							$i = 0;

							$rowclass = "gSGRowEvenStatsGrid";
				
							foreach ($LL[0] as $ScoreRow) {
							
								$playerID = $ScoreRow["PLAYERID"];
								$statPG = sprintf("%1.2f",  $ScoreRow["STAT_PG"]);
								$playerName = trim($ScoreRow["FNAME"] . " " . $ScoreRow["NAME"]); 
								$teamAbbrev = $ScoreRow["ABBREV"];
								$teamID = $ScoreRow["TEAMNUM"];
								$i++;
	                            echo "<TR> ";
	                            echo "  <TD class=$rowclass align=left width=200>&nbsp; <B>$i</B> <A class=gSGPlayerLink href=viewplayer.php?playerID=$playerID>$playerName</A> (<A class=gSGTeamLink href=viewteam.php?teamID=$teamID>$teamAbbrev</A>) </TD> ";
	                            echo "  <TD class=$rowclass align=left width=25>$statPG</TD> ";
	                            echo "</TR> ";
	                            
	                            $rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	

							}
echo "
                        </TABLE> 
</TD> 
                      <TD vAlign=top align=right>
                        <TABLE class=gSGTableStatsGrid cellSpacing=0 cellPadding=0 width=298 border=0> 
                            <TR class=gSGSectionColumnHeadingsStatsGrid> 
                              <TD class=gSGSectionColumnHeadingsStatsGrid noWrap align=left width=200><B>&nbsp; REBOUNDS</B></TD> 
                              <TD class=gSGSectionColumnHeadingsStatsGrid noWrap align=left width=25><B>AVG</B></TD> 
                            </TR> ";
							$i = 0;
				
							$rowclass = "gSGRowEvenStatsGrid";

							foreach ($LL[1] as $ScoreRow) {
							
								$playerID = $ScoreRow["PLAYERID"];
								$statPG = sprintf("%1.2f",  $ScoreRow["STAT_PG"]);
								$playerName = trim($ScoreRow["FNAME"] . " " . $ScoreRow["NAME"]); 
								$teamAbbrev = $ScoreRow["ABBREV"];
								$teamID = $ScoreRow["TEAMNUM"];
								$i++;
	                            echo "<TR> ";
	                            echo "  <TD class=$rowclass align=left width=200>&nbsp; <B>$i</B> <A class=gSGPlayerLink href=viewplayer.php?playerID=$playerID>$playerName</A> (<A class=gSGTeamLink href=viewteam.php?teamID=$teamID>$teamAbbrev</A>) </TD> ";
	                            echo "  <TD class=$rowclass align=left width=25>$statPG</TD> ";
	                            echo "</TR> ";
	                            $rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	

							}
echo "


                        </TABLE> 
</TD> 
                    </TR> 
                    <TR> 
                      <TD vAlign=top align=left>
                        <TABLE class=gSGTableStatsGrid cellSpacing=0 cellPadding=0 width=298 border=0> 
                            <TR class=gSGSectionColumnHeadingsStatsGrid> 
                              <TD class=gSGSectionColumnHeadingsStatsGrid noWrap align=left width=200><B>&nbsp; ASSISTS</B></TD> 
                              <TD class=gSGSectionColumnHeadingsStatsGrid noWrap align=left width=25><B>APG</B></TD> 
                            </TR> 

";
							$i = 0;
				
							$rowclass = "gSGRowEvenStatsGrid";

							foreach ($LL[2] as $ScoreRow) {
								$playerID = $ScoreRow["PLAYERID"];
								$statPG = sprintf("%1.2f",  $ScoreRow["STAT_PG"]);
								$playerName = trim($ScoreRow["FNAME"] . " " . $ScoreRow["NAME"]); 
								$teamAbbrev = $ScoreRow["ABBREV"];
								$teamID = $ScoreRow["TEAMNUM"];
								$i++;
	                            echo "<TR> ";
	                            echo "  <TD class=$rowclass align=left width=200>&nbsp; <B>$i</B> <A class=gSGPlayerLink href=viewplayer.php?playerID=$playerID>$playerName</A> (<A class=gSGTeamLink href=viewteam.php?teamID=$teamID>$teamAbbrev</A>) </TD> ";
	                            echo "  <TD class=$rowclass align=left width=25>$statPG</TD> ";
	                            echo "</TR> ";
	                            $rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	
							}
echo "


                        </TABLE> 
</TD> 
                      <TD vAlign=top align=right>
                        <TABLE class=gSGTableStatsGrid cellSpacing=0 cellPadding=0 width=298 border=0> 
                            <TR class=gSGSectionColumnHeadingsStatsGrid> 
                              <TD class=gSGSectionColumnHeadingsStatsGrid noWrap align=left width=200><B>&nbsp; STEALS</B></TD> 
                              <TD class=gSGSectionColumnHeadingsStatsGrid noWrap align=left width=25><B>SPG</B></TD> 
                            </TR> ";
							$i = 0;
							$rowclass = "gSGRowEvenStatsGrid";
				
							foreach ($LL[3] as $ScoreRow) {
							
								$playerID = $ScoreRow["PLAYERID"];
								$statPG = sprintf("%1.2f",  $ScoreRow["STAT_PG"]);
								$playerName = trim($ScoreRow["FNAME"] . " " . $ScoreRow["NAME"]); 
								$teamAbbrev = $ScoreRow["ABBREV"];
								$teamID = $ScoreRow["TEAMNUM"];
								$i++;
	                            echo "<TR> ";
	                            echo "  <TD class=$rowclass align=left>&nbsp; <B>$i</B> <A class=gSGPlayerLink href=viewplayer.php?playerID=$playerID>$playerName</A> (<A class=gSGTeamLink href=viewteam.php?teamID=$teamID>$teamAbbrev</A>) </TD> ";
	                            echo "  <TD class=$rowclass align=left>$statPG</TD> ";
	                            echo "</TR> ";
	                            $rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	
							}
echo "


                        </TABLE> 
</TD> 
                    </TR> 
                    <TR> 
                      <TD class=gSGSectionFooter align=middle colSpan=2><B><A href=viewstats.php?stat_type=POINTS&stat_view=PG>League Leaders</A> </B>| <B><A href=viewstats.php?stat_type=POINTS&stat_view=TPG>Team Stats </A></B></TD> 
                    </TR> 
                </TABLE></TD> 
              <TD class=cBSide noWrap><BR></TD> 
            </TR> 
            <TR> 
              <TD class=cBBottom colSpan=3><IMG height=1 src=blank.gif></TD> 
            </TR> 
        </TABLE></TD> 
    </TR> 
</TABLE> 



";
}

?>


