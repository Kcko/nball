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

function createTeamImageURL($teamID) {
	echo "<img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\">\n";
}

function createPlayerImageURL($playerID) {
	$playerIDFormatted = sprintf("%04d", $playerID);
	$playerImageName = "player_" . $playerIDFormatted;

	echo "<img src=\"images/players/" . $playerImageName . ".jpg\" >";
}

function createLeagueLeadersList($playerStats, $statName, $statView) {

	echo "<TABLE class=gSGTableStatsGridOne cellSpacing=0 cellPadding=1 width=100% border=0>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=6><DIV class=gSGSectionTitleStatsGridOne>&nbsp;<B>$statName</B></DIV></TD>";
	echo "	</TR>";
	echo "	<TR class=gSGSectionColumnHeadingsStatsGridOne>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=15><B>&nbsp;</B></TD>";

	switch (trim($statView)) {
		case "TOT" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>PER GAME</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>TOTAL</B></TD>";
			break;
		case "ATOT" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>PER GAME</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>TOTAL</B></TD>";
			break;
		case "TOTB" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>&nbsp;</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>&nbsp;</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>TOTAL</B></TD>";
			break;
		case "EFF" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>&nbsp;</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>TOTAL</B></TD>";
			break;
		case "AEFF" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>&nbsp;</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>TOTAL</B></TD>";
			break;
		case "PER" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>M-A</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>PERCENT</B></TD>";
			break;
		case "PT" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>TOT-MINS</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>PER 28</B></TD>";
			break;
		case "APT" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>TOT-MINS</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>PER 28</B></TD>";
			break;
		case "TPG" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;TEAM</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>TOTAL</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>PER GAME</B></TD>";
			break;
		case "TOPG" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;TEAM</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>TOTAL</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>PER GAME</B></TD>";
			break;
		case "TDPG" : 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;TEAM</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>FOR</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>AGAINST</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>DIFF PG</B></TD>";
			break;
		default: 
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=240><B>&nbsp;PLAYER</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=40><B>G</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>TOTAL</B></TD>";
			echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=60><B>PER GAME</B></TD>";
	}

	echo "	</TR>";

	$playerRank = 1;

	$rowclass = "gSGRowEvenStatsGrid" ;
	
	
	if (count($playerStats) == 0) {
	echo "	<TR>";
	echo "	  <TD class=$rowclass colSpan=6 align=middle><B>No Games Played</B></TD>";
	echo "	</TR>";
	
	
	}
	
	
	foreach ($playerStats as $value) {

	$PLAYER_NAME = "<a href=viewplayer.php?playerID=" . $value["PLAYERID"] . ">" . $value["FNAME"] . "&nbsp;" . $value["NAME"] . "</a>";

	$teamLink = "<a href=viewteam.php?teamID=" . $value["TEAMNUM"] .">" . $value["CITYNAME"] . "&nbsp;" . $value["TEAMNAME"] . "</a>" ;	
	$G    = $value["GAME_COUNT"];

	$TOTAL = $value["STATS_TOTAL"];
	$PERGAME = sprintf("%1.2f",  $value["STAT_PG"]);


		echo "	<TR>";
		echo "	  <TD width=15 class=$rowclass>&nbsp;$playerRank.</TD>";
		switch($statView) {
			case "TPG" :
				echo "	  <TD width=240 class=$rowclass>&nbsp;$teamLink</TD>";
				break;
			case "TOPG" :
				echo "	  <TD width=240 class=$rowclass>&nbsp;$teamLink</TD>";
				break;
			case "TDPG" :
				echo "	  <TD width=240 class=$rowclass>&nbsp;$teamLink</TD>";
				break;
			default :
				echo "	  <TD width=240 class=$rowclass>&nbsp;$PLAYER_NAME ($teamLink)</TD>";
		}				

		switch (trim($statView)) {
			case "TOT" : 

				$TOTAL = $value["STAT_PG"];
				$PERGAME = sprintf("%1.2f",  $value["STATS_TOTAL"]);
				echo "	  <TD width=40 class=$rowclass align=middle>$G</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$PERGAME</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$TOTAL</TD>";
				break;
			case "TOTB" : 
				echo "	  <TD width=40 class=$rowclass align=middle>&nbsp;</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>&nbsp;</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$TOTAL</TD>";
				break;
			case "EFF" : 
				$PERGAME = sprintf("%1.2f",  $value["STAT_PG"]);
				if ($PERGAME >= 0) {
					$PERGAME = "+" . $PERGAME;
				}
				echo "	  <TD width=40 class=$rowclass align=middle>$G</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>&nbsp;</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$PERGAME</TD>";
				break;
			case "PER" :
				$PERGAME = sprintf("%1.3f",  $value["STAT_PG"]);
				$STATS_TOTAL = $value["STATS_TOTAL"];
				$STATS_TOTAL_1 = $value["STATS_TOTAL_1"];
				echo "	  <TD width=40 class=$rowclass align=middle>$G</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$STATS_TOTAL_1-$STATS_TOTAL</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$PERGAME</TD>";
				break;
			case "PT" :
				$PERGAME = sprintf("%1.2f",  $value["STAT_PG"]);
				$STATS_TOTAL = $value["STATS_TOTAL_1"];
				$STATS_TOTAL_1 = $value["STATS_TOTAL"];
				echo "	  <TD width=40 class=$rowclass align=middle>$G</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$STATS_TOTAL_1-$STATS_TOTAL</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$PERGAME</TD>";
				break;
			case "TDPG" : 
				$PERGAME = sprintf("%1.2f",  $value["STAT_PG"]);
				if ($PERGAME >= 0) {
					$PERGAME = "+" . $PERGAME;
				}
				$PERGAME1 = sprintf("%1.2f",  $value["STAT_PG_1"]);
				$PERGAME2 = sprintf("%1.2f",  $value["STAT_PG_2"]);

				
				echo "	  <TD width=40 class=$rowclass align=middle>$G</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$PERGAME1</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$PERGAME2</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$PERGAME</TD>";
				break;


			default: 
				echo "	  <TD width=40 class=$rowclass align=middle>$G</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$TOTAL</TD>";
				echo "	  <TD width=60 class=$rowclass align=middle>$PERGAME</TD>";
		}

		echo "	</TR>";
		$playerRank++;
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	
	}
		

	echo "</TABLE>";
}

function createLeagueLeadersSQL($statsType,$limit) {

	$sql = "
	SELECT 	 PL.FNAME
		,PL.NAME
		,TM.CITYNAME
		,TM.TEAMNAME
		,TM.TEAMNUM
		,PS.PLAYERID
		,PS.STATS_TOTAL
		,PS.STAT_PG
		,PS.GAME_COUNT

	FROM (
	SELECT	 PS.PLAYERID AS PLAYERID
		,SUM(PS.$statsType) as STATS_TOTAL
		,SUM(PS.$statsType + 0.00) / (COUNT(*) + 0.00) as STAT_PG
		,COUNT(*) as GAME_COUNT

	FROM PLAYERSTATS PS

	INNER JOIN SCHEDULE SH
	ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
	AND PS.PLAYED = 1

	INNER JOIN SEASON SE
	ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

	GROUP BY 1

	ORDER BY STAT_PG DESC, STATS_TOTAL
	LIMIT $limit) AS PS

	INNER JOIN PLAYERS PL
	ON PS.PLAYERID = PL.PLAYERID

	INNER JOIN TEAMS TM
	ON PL.TEAM = TM.TEAMNUM

	ORDER BY PS.STAT_PG DESC, PS.STATS_TOTAL DESC, PS.GAME_COUNT, PL.NAME, PL.FNAME";

	return($sql);
}


function createLeagueLeadersSQLDouble($statType,$limit) {
	switch(trim($statType)) {
		case "TRIPLE" : 
			$doubleType = 3; 
			break;
		case "DOUBLE" : 
			$doubleType = 2;
			break;
	}

	$sql = "

		SELECT * FROM
		(SELECT	 B.PLAYERID
			,TOT_POINTS + TOT_REBOUNDS + TOT_ASSISTS + TOT_STEALS + TOT_BLOCKS AS STATS_TOTALS
			,COUNT(*) as STATS_TOTAL
			
		FROM

		(
		SELECT 	 PS.PLAYERID
				,PS.SCHEDULE_ID
				,case when PS.POINTS >= 10 THEN 1 ELSE 0 end AS TOT_POINTS
				,case when PS.REBOUNDS >= 10 THEN 1 ELSE 0 end AS TOT_REBOUNDS
				,case when PS.ASSISTS >= 10 THEN 1 ELSE 0 end AS TOT_ASSISTS
				,case when PS.STEALS >= 10 THEN 1 ELSE 0 end AS TOT_STEALS
				,case when PS.BLOCKS >= 10 THEN 1 ELSE 0 end AS TOT_BLOCKS
				,COUNT(*) AS ACHIEVED

		FROM 	PLAYERSTATS PS

		INNER JOIN SCHEDULE SH
		ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
		AND PS.PLAYED = 1

		INNER JOIN SEASON SE
		ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

		WHERE PS.PLAYED = 1
		GROUP BY 1,2,3,4,5,6,7
		) AS B

		GROUP BY 1,2 LIMIT $limit ORDER BY STATS_TOTAL DESC) AS C

		INNER JOIN PLAYERS PL
		ON C.PLAYERID = PL.PLAYERID

		INNER JOIN TEAMS TM
		ON PL.TEAM = TM.TEAMNUM

		WHERE STATS_TOTALS = $doubleType
		";
	
	return($sql);
}

function createLeagueLeadersEfficiency($limit) {

	$sql = "
		SELECT * FROM (
		SELECT	 PLAYERID
			,(((POINTS + REBOUNDS + ASSISTS + STEALS + BLOCKS) - ((FGA - FGM) + (FTA - FTM) + TURNOVERS)) + 0.00) / GAME_COUNT AS STAT_PG
			,GAME_COUNT
		FROM (
		SELECT	 PLAYERID
			,SUM(POINTS) AS POINTS
			,SUM(REBOUNDS) AS REBOUNDS
			,SUM(BLOCKS) AS BLOCKS
			,SUM(ASSISTS) AS ASSISTS
			,SUM(STEALS) AS STEALS
			,SUM(FGA) AS FGA
			,SUM(FGM) AS FGM
			,SUM(FTA) AS FTA
			,SUM(FTM) AS FTM
			,SUM(TURNOVERS) AS TURNOVERS
			,COUNT(*) AS GAME_COUNT
		FROM PLAYERSTATS
		GROUP BY 1
		) AS B

		ORDER BY STAT_PG DESC
		LIMIT $limit) AS C

		INNER JOIN PLAYERS PL
		ON C.PLAYERID = PL.PLAYERID

		INNER JOIN TEAMS TM
		ON PL.TEAM = TM.TEAMNUM
		
		order by STAT_PG DESC
		
	";
	
	return($sql);
}

function createLeagueLeaders($playerStats, $stat_type, $stat_view) {


createLeagueLeadersList($playerStats, $stat_type, $stat_view); 
/*
	echo "<TABLE cellSpacing=0 cellPadding=0 width=100% border=0>";
	echo "  <TBODY>";
	echo "	<TR>";
	echo "	  <TD vAlign=top align=left width=35%>";
	echo "		<TABLE class=playerInfoGridPlayerInfoBorders width=100% border=1>";
	echo "		  <TBODY>";
	echo "			<TR>";
	echo "			  <TD class=gSGSectionTitleStatsGrid vAlign=top width=100%>";
	echo "			  <TABLE class=gSGSectionTitleStatsGrid cellPadding=0 width=100% border=0>";
	echo "				  <TBODY>";
	echo "					<TR>";
	echo "					  <TD class=gSGSectionTitleStatsGrid vAlign=top width=70%>";
							createLeagueLeadersList($playerStats, $stat_type, $stat_view); 
	echo "                  </TD>";
	echo "					</TR>";
	echo "				  </TBODY>";
	echo "			  </TABLE></TD>";
	echo "			</TR>";
	echo "		  </TBODY>";
	echo "		</TABLE></TD>";
	echo "	</TR>";
	echo "  </TBODY>";
	echo "</TABLE>	";
*/
}


function createLeagueLeaderSelection($stat_type) {
	include('config.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from stats order by stat_rank";

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$statsTypes = $db->sql_fetchrowset($result);


echo "
		<div class=statsFinderBackground>
        <table class=statsFinderTable cellspacing=0 cellpadding=0 border=0 width=100%>
        <form name=TheForm style=margin: 0 action=viewstats.php method=GET>
        <tr>
		<td class=statsFinderBackground nowrap width=10><br></td>
        
        <td class=statsFinderBackground>Select a Topic</td>
        <td class=statsFinderBackground>&nbsp;</td>
        <td class=statsFinderBackground>&nbsp;</td>
        <td class=statsFinderBackground>&nbsp;</td>
        
        </tr>
        <tr>
		<td class=statsFinderBackground nowrap width=10><br></td>
        <td class=statsFinderBackground>

		<SELECT name=stat_type onchange=\"javascript:if( options[selectedIndex].value != 'Teams') document.location = 'viewstats.php?stat_type=' + options[selectedIndex].value\">
		
        
        ";
        
       	foreach ($statsTypes as $value) {
       		
       		$selected = ( $stat_type == $value["STAT_TYPE"] ) ? ' selected="selected"' : '';
			echo "<option value=". $value["STAT_TYPE"] ." $selected>&nbsp;" . $value["STAT_NAME"] ."</option>";
       	
       	}

        
echo "        
        </select>
        </td>
        <td class=statsFinderBackground>
        
        &nbsp;
        
        </td>
        <td class=statsFinderBackground>
        </td>
        <td class=statsFinderBackground>
        <input type=submit value=GO >
        </td>
        </tr>
        </form>
        </table></div>

";

}

function createLeagueLeadersImage($playerStats, $statView) {

	if (count($playerStats) == 0) {
		echo "&nbsp;";
		return;
	}

	switch($statView) {
		case "TPG" :
			$teamID = strtolower($playerStats["TEAMNUM"]);		
			echo "<img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\">\n";			
			break;
		case "TOPG" :
			$teamID = strtolower($playerStats["TEAMNUM"]);		
			echo "<img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\">\n";
			break;
		case "TDPG" :
			$teamID = strtolower($playerStats["TEAMNUM"]);
			echo "<img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\">\n";
			break;
		default:
			$playerIDFormatted = sprintf("%04d", $playerStats["PLAYERID"]);
			$imageName = "images/players/act_player_" . $playerIDFormatted . ".jpg";
			echo "<img src=\"$imageName\">\n";

	}
}


function efficiencyRecap($players, $season) {

	$currentSeason = $season;
	$rowCount = count($players);
	if ($rowCount == 0) {
		$rowCount = "";
	}
	
	echo "<table class=gSGTableStatsGridOne width=100% cellspacing=0 cellpadding=1 border=0 >";
	echo "<tr>";
	echo "	<td class=gSGSectionTitleStatsGridOne align=center colspan=13><b>$currentSeason -  $rowCount MOST EFFICIENT REGULAR SEASON PERFORMANCES</b></td>";
	echo "</tr>";
	echo "<tr>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>&nbsp;PLAYER</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>DATE</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>OPP</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>MIN</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>FGM-A</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>FTM-A</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>REB</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>AST</td>"; 
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>ST</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>BS</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>TO</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne>PTS</td>";
	echo "	<td class=gSGSectionColumnHeadingsStatsGridOne align=right>EFF</td>";
	echo "</tr>";
	$rowclass = "gSGRowEvenStatsGrid" ;

	if (count($players) == 0) {
		echo "<tr>";
		echo "	<td class=$rowclass align=center colspan=13>no stats available</td>";
		echo "</tr>";
	}

	foreach ($players as $player) {
	
		$playerName = trim($player["FNAME"] . " " . $player["NAME"]);
		$playerID = $player["PLAYERID"];
		$MIN = $player["MINS"];
		$FGM = $player["FGM"];
		$FGA = $player["FGA"];
		$FTM = $player["FTM"];
		$FTA = $player["FTA"];
		$REB = $player["REBOUNDS"];
		$AST = $player["ASSISTS"];
		$STL = $player["STEALS"];
		$BLK = $player["BLOCKS"];
		$TO = $player["TURNOVERS"];
		$PTS = $player["POINTS"];
		$EFF = sprintf("%1.0f", $player["GAME_EFF"]);
		
		$playerTeam = $player["ABBREV"];
		$playerTeamID = $player["TEAM_NUMBER"];
		
		$gameDate = $player["PLAYED_DATE"];
		$scheduleID = $player["SCHEDULE_ID"];
		$gameHomeTeamID = $player["HOME_TEAM_ID"];
		$gameAwayTeamID = $player["AWAY_TEAM_ID"];
	
		if ($gameHomeTeamID == $playerTeamID) {
			$againstTeam = $player["AWAY_TEAM"];
			$againstTeamID = $player["AWAY_TEAM_ID"];
			$vs = "vs ";
		} else {
			$againstTeam = $player["HOME_TEAM"];
			$againstTeamID = $player["HOME_TEAM_ID"];
			$vs = "@ ";
		}
		
		echo "<tr>";
		echo "	<td class=$rowclass>&nbsp;<a href=viewplayer.php?playerID=$playerID>$playerName</a> $playerTeam</td>";
		echo "	<td class=$rowclass><a href=viewboxscore.php?scheduleID=$scheduleID>$gameDate</a></td>";
		echo "	<td class=$rowclass>$vs <a href=viewteam.php?teamID=$againstTeamID>$againstTeam</a></td>";
		echo "	<td class=$rowclass>$MIN</td>";
		echo "	<td class=$rowclass>$FGM-$FGA</td>";
		echo "	<td class=$rowclass>$FTM-$FTA</td>";
		echo "	<td class=$rowclass>$REB</td>";
		echo "	<td class=$rowclass>$AST</td>";
		echo "	<td class=$rowclass>$STL</td>";
		echo "	<td class=$rowclass>$BLK</td>";
		echo "	<td class=$rowclass>$TO</td>";
		echo "	<td class=$rowclass>$PTS</td>";

		if ($EFF >= 0) {
			$EFF = "+" . $EFF;
		}
		echo "	<td class=$rowclass>$EFF</td>";
		echo "</tr>";

		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	

	}

	echo "</table>";
}



function efficiencyRoundRecap($players) {

	$scheduleFirstTime = TRUE;
	$teamFirstTime = TRUE;

	$scheduleAlign = "gameBoxLeft";
	$teamAlign = "teamLeft";

	$i = 1;

	foreach ($players as $player) {

		$playerName = trim(substr($player["FNAME"],0,1) . " " . $player["NAME"]);
		$playerID = $player["PLAYERID"];
		$MIN = $player["MINS"];
		$EFF = sprintf("%1.0f", $player["GAME_EFF"]);
		$scheduleID = $player["SCHEDULE_ID"];
		$awayTeamName = $player["AWAY_TEAM"];
		$homeTeamName = $player["HOME_TEAM"];
		$awayTeamID = $player["AWAY_TEAM_ID"];
		$homeTeamID = $player["HOME_TEAM_ID"];
		$awayTeamScore = $player["AWAY_TEAM_SCORE"];
		$homeTeamScore = $player["HOME_TEAM_SCORE"];
		$boxScore = "<a href=viewboxscore.php?scheduleID=$scheduleID>Box Score</a>";
		
		if ($EFF >= 0) {
			$EFF = "+" . $EFF;
		}

		if ($player["PLAYED"] == 0) {
			$MIN = "DNP";
			$EFF = "&nbsp;";
		}

		// EACH SCHEDULE ID
		$c_ScheduleID = $player["SCHEDULE_ID"];
		if ($c_ScheduleID != $p_ScheduleID) {
			if (!$scheduleFirstTime) {
				$c_TeamID = "";
				$p_TeamID = "";
				echo "</div>\n";
			}
			echo "<div class=$scheduleAlign>\n";
//			echo "<span id=teamImageLeft><img src=images/teams/" . $awayTeamID ."_small_logo.gif></span>\n";
//			echo "<span id=teamImageRight><img src=images/teams/" . $homeTeamID ."_small_logo.gif></span>\n";
//			echo "<span id=scores>";
//			echo "$awayTeamScore\n";
//			echo "$boxScore\n";
//			echo "$homeTeamScore\n";
//			echo "</span>";
			echo "
			<table cellpadding=0 width=100% border=0 cellspacing=0>
				<tr height=85>
					<td align=center><img src=images/teams/" . $awayTeamID ."_small_logo.gif></td>
					<td align=center>vs</td>
					<td align=center><img src=images/teams/" . $homeTeamID . "_small_logo.gif></td>
				</tr>
				<tr bgcolor=#527cba>
					<td align=center><div style=color:#ffffff>$awayTeamName &nbsp;$awayTeamScore</div></td>
					<td align=center style=color:#ffffff>$boxScore</td>
					<td align=center><div style=color:#ffffff>$homeTeamName &nbsp;$homeTeamScore</div></td>
				</tr>
			</table>
			";
			
			
			$scheduleFirstTime = FALSE;
			$p_ScheduleID = $c_ScheduleID;
			$scheduleAlign == "gameBoxLeft" ? $scheduleAlign = "gameBoxRight" : $scheduleAlign = "gameBoxLeft" ; 
		}

		// EACH GAME
		$c_TeamID = $player["TEAM_NUMBER"];
		if ($c_TeamID != $p_TeamID) {
			//echo "<table border=1>";
			echo "<span id=$teamAlign>\n";
			echo "<table cellspacing=0 cellpadding=1 width=143 border=0>\n";
			echo "<tr class=secHeader><td class=secHeader>Player</td><td class=secHeader>MIN</td><td class=secHeader>EFF</td></tr>\n";
			
			$teamFirstTime = FALSE;
			$p_TeamID = $c_TeamID;
			
			$teamAlign == "teamLeft" ? $teamAlign = "teamRight" : $teamAlign = "teamLeft" ; 
			
		}

//		echo "<br>$i<br>";

		echo "<tr>\n";
		echo "<td><a class=gSGPlayerLink href=viewplayer.php?playerID=$playerID>$playerName</a></td>\n";
		echo "<td>$MIN</td>\n";
		echo "<td>$EFF</td>\n";
		echo "</tr>\n";

		$i++;
		
		if ($i > 12) {
			$i = 1;
			echo "</table>\n";
			echo "</span>\n";
		}
		
	}
	echo "</div>\n";
}

function efficiencyRoundPlayerRecap($players) {

foreach ($players as $player) {
		$playerName = trim($player["FNAME"] . " " . $player["NAME"]);
		$playerID = $player["PLAYERID"];
		if ($player["ROW_ORDER"] == 1) {
			$MIN = sprintf("%1.0f", $player["MINS"]);
			$FGM = $player["FGM"];
			$FGA = $player["FGA"];
			$FTM = $player["FTM"];
			$FTA = $player["FTA"];
			$REB = sprintf("%1.0f", $player["REBOUNDS"]);
			$AST = sprintf("%1.0f", $player["ASSISTS"]);
			$STL = sprintf("%1.0f", $player["STEALS"]);
			$BLK = sprintf("%1.0f", $player["BLOCKS"]);
			$TO =  sprintf("%1.0f", $player["TURNOVERS"]);
			$PTS = sprintf("%1.0f", $player["POINTS"]);
			$EFF = sprintf("%1.0f", $player["GAME_EFF"]);
			$HEADING = "ROUND LEADER";
		} else {
			$MIN = sprintf("%1.01f", $player["MINS"]);
			$FGM = $player["FGM"];
			$FGA = $player["FGA"];
			$FTM = $player["FTM"];
			$FTA = $player["FTA"];
			$REB = sprintf("%1.01f", $player["REBOUNDS"]);
			$AST = sprintf("%1.01f", $player["ASSISTS"]);
			$STL = sprintf("%1.01f", $player["STEALS"]);
			$BLK = sprintf("%1.01f", $player["BLOCKS"]);
			$TO =  sprintf("%1.01f", $player["TURNOVERS"]);
			$PTS = sprintf("%1.01f", $player["POINTS"]);
			$EFF = sprintf("%1.01f", $player["GAME_EFF"]);
			$HEADING = "ROUND AVERAGE LEADER";
		}
		
		$playerTeam = $player["ABBREV"];
		$playerTeamID = $player["TEAM_NUMBER"];
		
		$gameDate = $player["PLAYED_DATE"];
		$scheduleID = $player["SCHEDULE_ID"];
		$gameHomeTeamID = $player["HOME_TEAM_ID"];
		$gameAwayTeamID = $player["AWAY_TEAM_ID"];
	
		$playerTeam = $player["TEAMNAME"];


echo "
	<table cellpadding=0 border=0 cellspacing=0>
		<tr><TD class=cBSpacing colSpan=3><img src=blank.gif height=1></td></tr>
		<tr><TD class=cBSide noWrap><br></td>
			<td><table cellpadding=1 cellspacing=0 border=0	 width=240 height=150>
		<tr class=secHeader><td colspan=2 align=center><strong>$HEADING</strong></td></tr>	
		<tr><td colspan=2 align=center></td></tr>
		<tr><td align=center>";

createPlayerImageURL($playerID);

echo "</td>
		<td width=70% align=center class=statTextLarge>
		<div class=statNumLarge><b>+ $EFF</div>$playerName</b><br><div class=statTextLAM align=center>$playerTeam</div></td>
		</tr>
		<tr>
		<td colspan=2><table cellpadding=0 cellspacing=0 border=0 width= 100%>
		<tr class=secHeader>
			<td>MIN</td>
			<td>FGM-A</td>
			<td>FTM-A</td>
			<td>REB</td>
			<td>AST</td>
			<td>ST</td>
			<td>BS</td>
			<td>TO</td>
			<td>PTS</td>
		</tr>
		<tr>
			<td class=statTextTop>$MIN</td>
			<td class=statTextTop>$FGM-$FGA</td>
			<td class=statTextTop>$FTM-$FTA</td>
			<td class=statTextTop>$REB</td>
			<td class=statTextTop>$AST</td>
			<td class=statTextTop>$STL</td>
			<td class=statTextTop>$BLK</td>
			<td class=statTextTop>$TO</td>
			<td class=statTextTop>$PTS</td>
		</tr>
		</table></td></tr></table></td>
		<TD class=cBSide noWrap><br></td>
		</tr>
		<tr><TD class=cBBottom colSpan=3><img src=blank.gif height=1></td></tr>
		</table>";
	}
}

?>

