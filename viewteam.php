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
	include('inc_team.php');

	if ($sortOrder == "") {
		$sortOrder = "ROSTERPOS";
	}

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from players, teams, position where teams.teamnum = players.team and players.position = position.position and players.team = $teamID order by players.$sortOrder";
	$result = $db->sql_query($sql);
	$lineup = $db->sql_fetchrowset($result);


	$sql = "
		SELECT	 SH.SCHEDULE_ID as SCHEDULE_ID 
			,TH.TEAMNAME as HOME_TEAMNAME
			,TH.TEAMNUM as HOME_TEAMNUM
			,TA.TEAMNAME as AWAY_TEAMNAME
			,TA.TEAMNUM as AWAY_TEAMNUM
			,SH.HOME_SCORE as HOME_SCORE
			,SH.AWAY_SCORE as AWAY_SCORE
			,PLAYED_DATE
			,GAME_DATE
			,PLAYED
			,FORFEIT
		FROM	schedule SH
		INNER JOIN season SE
		ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

		INNER JOIN teams TH
		ON SH.HOME_TEAM = TH.TEAMNUM

		INNER JOIN teams TA
		ON SH.AWAY_TEAM = TA.TEAMNUM

		WHERE (TH.TEAMNUM = $teamID or TA.TEAMNUM = $teamID)
		order by SCHEDULE_ID, GAME_DATE" ;
	$result = $db->sql_query($sql);
	$teamSchedule = $db->sql_fetchrowset($result);



	$sql = "SELECT	 FNAME
				,NAME
				,PLAYERID
				,NUMBER
				,POSITION_NAME_SHORT
				,ROSTERPOS
				,SUM(PLAYED) as GAME_COUNT
				,SUM(STARTED_COUNT) AS STARTED_COUNT
				,SUM(POINTS) as POINTS
				,SUM(MINS) as MINS
				,SUM(FGA) as FGA
				,SUM(FGM) as FGM
				,SUM(3PA) as 3PA
				,SUM(3PM) as 3PM
				,SUM(FTA) as FTA
				,SUM(FTM) as FTM
				,SUM(OREBOUNDS) as OREB
				,SUM(DREBOUNDS) as DREB
				,SUM(REBOUNDS) as REB
				,SUM(BLOCKS) as BLOCKS
				,SUM(STEALS) as STEALS
				,SUM(ASSISTS) as ASSISTS
				,SUM(TURNOVERS) as TURNOVERS
				,SUM(FOULS) as FOULS

			FROM (
			SELECT 	 PL.FNAME
					,PL.NAME
					,PL.PLAYERID
					,PL.NUMBER
					,POS.POSITION_NAME_SHORT
					,PL.ROSTERPOS
					,CASE WHEN PST.ROSTERPOS < 5 AND PLAYED = 1 THEN 1 ELSE 0 END AS STARTED_COUNT
					,COALESCE(PST.PLAYED,0) AS PLAYED
					,COALESCE(PST.POINTS,0) AS POINTS
					,COALESCE(PST.MINS,0) AS MINS
					,COALESCE(PST.FGA,0) AS FGA
					,COALESCE(PST.FGM,0) AS FGM
					,COALESCE(PST.3PA,0) AS 3PA
					,COALESCE(PST.3PM,0) AS 3PM
					,COALESCE(PST.FTA,0) AS FTA
					,COALESCE(PST.FTM,0) AS FTM
					,COALESCE(PST.OREBOUNDS,0) AS OREBOUNDS
					,COALESCE(PST.DREBOUNDS,0) AS DREBOUNDS
					,COALESCE(PST.REBOUNDS,0) AS REBOUNDS
					,COALESCE(PST.BLOCKS,0) AS BLOCKS
					,COALESCE(PST.STEALS,0) AS STEALS
					,COALESCE(PST.ASSISTS,0) AS ASSISTS
					,COALESCE(PST.TURNOVERS,0) AS TURNOVERS
					,COALESCE(PST.FOULS,0) AS FOULS			
			
			FROM 	PLAYERS PL

			INNER JOIN POSITION POS
			ON PL.POSITION = POS.POSITION

			LEFT JOIN PLAYERSTATS PST
			ON PL.PLAYERID = PST.PLAYERID
			AND PST.SCHEDULE_ID NOT IN (SELECT SCHEDULE_ID FROM SCHEDULE WHERE FORFEIT IS NOT NULL)
			AND PST.SCHEDULE_ID IN (
				SELECT SCHEDULE_ID 
				FROM SCHEDULE SH
				INNER JOIN SEASON SE
				ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
				AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			)

			WHERE PL.TEAM = $teamID
			
			) AS A

			GROUP BY 1,2,3,4,5,6 ORDER BY ROSTERPOS";

	$result = $db->sql_query($sql);
	$currentseasonstats = $db->sql_fetchrowset($result);





//	echo "<pre>";
//	print_r($currentseasonstats);
//	echo "</pre>";
/*
	$sql = "
	SELECT	 TH.TEAMNAME as HOME_TEAMNAME
		,TH.TEAMNUM as HOME_TEAMNUM
		,TA.TEAMNAME as AWAY_TEAMNAME
		,TA.TEAMNUM as AWAY_TEAMNUM
		,SH.HOME_SCORE as HOME_SCORE
		,SH.AWAY_SCORE as AWAY_SCORE
		,GAME_DATE
		,PLAYED
		,SH.SCHEDULE_ID as SCHEDULE_ID
	FROM	SCHEDULE SH

	INNER JOIN TEAMS TH
	ON SH.HOME_TEAM = TH.TEAMNUM

	INNER JOIN TEAMS TA
	ON SH.AWAY_TEAM = TA.TEAMNUM

	AND (SH.HOME_TEAM = $teamID OR SH.AWAY_TEAM = $teamID ) order by GAME_DATE";


	$result = $db->sql_query($sql);
	$scheduleData = $db->sql_fetchrowset($result);
*/
	$sql = "
	
	select * from
	(SELECT  '1' as ROW_ORDER
			,SE.SEASON AS SEASON
			,CASE WHEN SH.GAME_TYPE = 0 THEN 0 ELSE 1 END as GAME_TYPE
			,SUM(SH.PLAYED) AS GAME_COUNT
			,SUM(GST.POINTS) AS POINTS
			,SUM(GST.BENCH_SCORING) AS BENCH_SCORING
			,SUM(GST.FGA) AS FGA
			,SUM(GST.FGM) AS FGM
			,SUM(GST.3PA) AS 3PA
			,SUM(GST.3PM) AS 3PM
			,SUM(GST.FTA) AS FTA
			,SUM(GST.FTM) AS FTM
			,SUM(GST.REBOUNDS) AS REB
			,SUM(GST.OREBOUNDS) AS OREB
			,SUM(GST.DREBOUNDS) AS DREB
			,SUM(GST.BLOCKS) AS BLOCKS
			,SUM(GST.STEALS) AS STEALS
			,SUM(GST.ASSISTS) AS ASSISTS
			,SUM(GST.TURNOVERS) AS TURNOVERS
			,SUM(GST.FOULS) AS FOULS

		FROM SEASON SE
		INNER JOIN SCHEDULE SH
		ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND (SH.HOME_TEAM = $teamID OR SH.AWAY_TEAM = $teamID)
		AND SH.HOME_SCORE <> SH.AWAY_SCORE
		AND (SH.HOME_SCORE > 0 AND SH.AWAY_SCORE > 0)

		INNER JOIN GAMESTATS GST
		ON GST.TEAM_NUMBER = $teamID
		AND GST.SCHEDULE_ID = SH.SCHEDULE_ID

		GROUP BY 1,2,3) as qry1

	UNION

	select * from 
	(SELECT  '2' as ROW_ORDER
			,'Team' AS SEASON
			,CASE WHEN SH.GAME_TYPE = 0 THEN 0 ELSE 1 END as GAME_TYPE
			,SUM(SH.PLAYED) AS GAME_COUNT
			,SUM(GST.POINTS) AS POINTS
			,SUM(GST.BENCH_SCORING) AS BENCH_SCORING
			,SUM(GST.FGA) AS FGA
			,SUM(GST.FGM) AS FGM
			,SUM(GST.3PA) AS 3PA
			,SUM(GST.3PM) AS 3PM
			,SUM(GST.FTA) AS FTA
			,SUM(GST.FTM) AS FTM
			,SUM(GST.REBOUNDS) AS REB
			,SUM(GST.OREBOUNDS) AS OREB
			,SUM(GST.DREBOUNDS) AS DREB
			,SUM(GST.BLOCKS) AS BLOCKS
			,SUM(GST.STEALS) AS STEALS
			,SUM(GST.ASSISTS) AS ASSISTS
			,SUM(GST.TURNOVERS) AS TURNOVERS
			,SUM(GST.FOULS) AS FOULS


		FROM SEASON SE
		INNER JOIN SCHEDULE SH
		ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND (SH.HOME_TEAM = $teamID OR SH.AWAY_TEAM = $teamID)
		AND SH.HOME_SCORE <> SH.AWAY_SCORE
		AND (SH.HOME_SCORE > 0 AND SH.AWAY_SCORE > 0)
		
		INNER JOIN GAMESTATS GST
		ON GST.TEAM_NUMBER = $teamID
		AND GST.SCHEDULE_ID = SH.SCHEDULE_ID

		GROUP BY 1,2,3	) as qry2

		
		";


	$result = $db->sql_query($sql);
	$seasonGameStats = $db->sql_fetchrowset($result);

//	echo "<pre>";
//	print_r($seasonGameStats);
//	echo "</pre>";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE><? echo createTeamName($lineup[0]); ?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewTeam">
<div id="mainbox">
<div id="topheading">Teams</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>\n
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">
<? 

	if ($teamID < 29) { 
		createTeamImageURL($lineup[0]["TEAMNUM"]);
		
	}
	
	echo createTeamName($lineup[0]);

	createTeamLineup($lineup,$teamID,$sortOrder);
                                                                    
	if ($teamID < 29) {

		createTeamStatsTotals($seasonGameStats);
		createPlayerStatsTotals($currentseasonstats);
		createTeamStatsAverages($seasonGameStats);
		createPlayerStatsAverages($currentseasonstats);
		createTeamSchedule($teamSchedule , $teamID);
	} 
?>
<? include('footer.php'); ?>
</div><!-- div:contentbox-->
</div><!-- div:box -->


</body>
</html>
