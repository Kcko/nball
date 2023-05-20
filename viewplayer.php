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

	include('header.php');
	include('config.php');
	include('mysql.php');
	include('inc_player.php');

	
	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from players, teams, position where teams.teamnum = players.team and players.position = position.position and playerid = " . $playerID;

	if ( !($result = $db->sql_query($sql)) ) {
//		message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);


	$teamID = $row["TEAMNUM"];

	$sql = "

	SELECT 	 SEASON as SEASON
		,COALESCE(SUM(PS.POINTS),0) AS POINTS
		,COALESCE(SUM(PS.MINS),0) AS MINS
		,COALESCE(SUM(PS.REBOUNDS),0) AS REBOUNDS
		,COALESCE(SUM(PS.BLOCKS),0) AS BLOCKS
		,COALESCE(SUM(PS.STEALS),0) AS STEALS
		,COALESCE(SUM(PS.ASSISTS),0) AS ASSISTS
		,COALESCE(SUM(PS.FGA),0) AS FGA
		,COALESCE(SUM(PS.FGM),0) AS FGM
		,COALESCE(SUM(PS.FTA),0) AS FTA
		,COALESCE(SUM(PS.FTM),0) AS FTM
		,COALESCE(SUM(PS.TURNOVERS),0) AS TURNOVERS
		,COALESCE(SUM(PS.PLAYED),0) AS GAME_COUNT

	FROM SEASON SE
	INNER JOIN PLAYERS PL
	ON PL.PLAYERID = $playerID
	AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

	LEFT JOIN PLAYERSTATS PS
	ON PS.PLAYERID = PL.PLAYERID
	AND PS.SCHEDULE_ID IN (
		SELECT SCHEDULE_ID 
		FROM SCHEDULE SH
		INNER JOIN SEASON SE
		ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
	)
	
	LEFT JOIN TEAMS TM
	ON PS.TEAM_NUMBER = TM.TEAMNUM

	LEFT  JOIN SCHEDULE SH
	ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
	AND SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
	AND SH.GAME_TYPE = 0

	GROUP BY 1
	";


	if ( !($result = $db->sql_query($sql)) ) {
//		message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
		
//		print_r($result);
//		echo $sql;
	}

	$playerStats = $db->sql_fetchrow($result);
	
	$playerName = trim($row["FNAME"] . " " . $row["NAME"]);

	$sql = "select * 
		from award awd
		inner join award_win aww
		on awd.award_id = aww.award_id

		inner join season se
		on se.season_id = aww.season_id
		and se.season_id = 1

		where aww.player_id = $playerID

		order by se.season_id desc, awd.award_id
	";


	$result = $db->sql_query($sql);
	$awardsWon = $db->sql_fetchrowset($result);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE><? echo $row["FNAME"] . " " . $row["NAME"]?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewPlayer">
<div id="mainbox">
<div id="topheading">Players</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">

<?
echo "
	
<table border=0 cellpadding=0 cellspacing=0 width=100% height=100% align=center>
<tr>
<td class=gSGLinkStatsGridOne align=center><a class=tNBLinkPlayerNav href=viewplayer.php?playerID=$playerID>Season statistics</a></td>
<td class=gSGLinkStatsGridOne align=center><A class=tNBLinkPlayerNav href=viewplayer.php?playerID=$playerID&playerView=gameLog>Game-by-game stats</a></td>
</tr>
</table>
";

	createTeamImageURL($row["TEAMNUM"]);
	createPlayerNameNumber($row); 
	nbacomPlayerImageURL($playerID);
	createPlayerInformation($row);
	createPlayerAwards($awardsWon);
	createPlayerCurrentSeasonStatsBreakdown($playerStats);
	
	createPlayerCompareLink($playerID);

	createPlayerRatings($row);
	include("playercompare.php");

	switch ($playerView){
		case "gameLog" :
			createPlayerGameLog($playerID);
			break;
			
		default : 
			createPlayerCurrentSeasonStats($playerID);
			createPlayerCareerAverageStats($playerID);
			createPlayerCareerTotalStats($playerID);
			createPlayerCareerHigh($playerID);
	}
	
?>

</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
