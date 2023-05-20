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
	include('inc_lleaders.php');

	$seasonID = $seasonNumber + 1;
	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "SELECT SE.SEASON FROM season SE WHERE SEASON_ID = $seasonID";

	if ($seasonNumber == "") {
		$sql = "SELECT DISTINCT
		 SE.SEASON_ID
		,SE.SEASON
		,SH.GAME_DATE
		,SH.ROUND_NUM

		FROM SEASON SE 
		INNER JOIN SCHEDULE SH
		ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

		WHERE SH.GAME_DATE > CURDATE()
		ORDER BY GAME_DATE, ROUND_NUM
		LIMIT 1 ";
	}

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$currentSeason = $db->sql_fetchrow($result);

	$season = $currentSeason["SEASON"];

//	print_r($currentSeason);
	
	if ($seasonNumber == "") {
		$seasonID = $currentSeason["SEASON_ID"];
		$season = $currentSeason["SEASON"];
		$seasonNumber = $seasonID - 1;
		$roundDate = $currentSeason["GAME_DATE"];
		$round = $currentSeason["ROUND_NUM"] - 1;
		
	}

	$sql = "
		SELECT 	 PST.PLAYERID
				,PL.FNAME
				,PL.NAME
				,PST.TEAM_NUMBER 
				,PST.SCHEDULE_ID
				,PST.PLAYED_DATE
				,PST.MINS AS MINS
				,PST.POINTS AS POINTS
				,PST.REBOUNDS AS REBOUNDS
				,PST.BLOCKS AS BLOCKS
				,PST.ASSISTS AS ASSISTS
				,PST.STEALS AS STEALS
				,PST.FGA AS FGA
				,PST.FGM AS FGM
				,PST.FTA AS FTA
				,PST.FTM AS FTM
				,PST.TURNOVERS AS TURNOVERS
				,PST.GAME_EFF AS GAME_EFF
				,HOME_TEAM.TEAMNAME AS HOME_TEAM
				,HOME_TEAM.TEAMNUM AS HOME_TEAM_ID
				,AWAY_TEAM.TEAMNAME AS AWAY_TEAM
				,AWAY_TEAM.TEAMNUM AS AWAY_TEAM_ID

		FROM (SELECT	 
		 PS.PLAYERID
		,PS.TEAM_NUMBER 
		,PS.SCHEDULE_ID
		,SH.HOME_TEAM
		,SH.AWAY_TEAM
		,SH.PLAYED_DATE
		,PS.MINS AS MINS
		,PS.POINTS AS POINTS
		,PS.REBOUNDS AS REBOUNDS
		,PS.BLOCKS AS BLOCKS
		,PS.ASSISTS AS ASSISTS
		,PS.STEALS AS STEALS
		,PS.FGA AS FGA
		,PS.FGM AS FGM
		,PS.FTA AS FTA
		,PS.FTM AS FTM
		,PS.TURNOVERS AS TURNOVERS
		,(((POINTS + REBOUNDS + ASSISTS + STEALS + BLOCKS) - ((FGA - FGM) + (FTA - FTM) + TURNOVERS)) + 0.00) AS GAME_EFF
	
		FROM PLAYERSTATS PS
		INNER JOIN SCHEDULE SH
		ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
		AND PS.SCHEDULE_ID IN (
			SELECT SCHEDULE_ID 
			FROM SCHEDULE SH
			INNER JOIN SEASON SE
			ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND SE.SEASON_ID = $seasonID 
		)

		ORDER BY GAME_EFF DESC

		LIMIT 30
		) AS PST
		INNER JOIN PLAYERS PL
		ON PST.PLAYERID = PL.PLAYERID

		INNER JOIN TEAMS TM
		ON PL.TEAM = TM.TEAMNUM

		INNER JOIN TEAMS HOME_TEAM
		ON PST.HOME_TEAM = HOME_TEAM.TEAMNUM

		INNER JOIN TEAMS AWAY_TEAM
		ON PST.AWAY_TEAM = AWAY_TEAM.TEAMNUM
		ORDER BY GAME_EFF DESC, PST.PLAYED_DATE, PST.MINS
	";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$seasonTopEff = $db->sql_fetchrowset($result);
	
	$sql = "
		SELECT 	 PST.PLAYERID
				,PL.FNAME
				,PL.NAME
				,CASE WHEN PST.TEAM_NUMBER = HOME_TEAM.TEAMNUM THEN 2 ELSE 1 END AS TEAM_ORDER
				,PST.TEAM_NUMBER 
				,PST.SCHEDULE_ID
				,PST.PLAYED_DATE
				,PST.MINS AS MINS
				,PST.GAME_EFF AS GAME_EFF
				,PST.PLAYED
				,HOME_TEAM.TEAMNAME AS HOME_TEAM
				,HOME_TEAM.TEAMNUM AS HOME_TEAM_ID
				,AWAY_TEAM.TEAMNAME AS AWAY_TEAM
				,AWAY_TEAM.TEAMNUM AS AWAY_TEAM_ID
				,PST.HOME_SCORE AS HOME_TEAM_SCORE
				,PST.AWAY_SCORE AS AWAY_TEAM_SCORE
				
				

		FROM (SELECT	 
		 PS.PLAYERID
		,PS.TEAM_NUMBER 
		,PS.SCHEDULE_ID
		,SH.HOME_TEAM
		,SH.AWAY_TEAM
		,SH.HOME_SCORE
		,SH.AWAY_SCORE
		,SH.PLAYED_DATE
		,PS.PLAYED
		,PS.MINS AS MINS
		,(((POINTS + REBOUNDS + ASSISTS + STEALS + BLOCKS) - ((FGA - FGM) + (FTA - FTM) + TURNOVERS)) + 0.00) AS GAME_EFF
	
		FROM PLAYERSTATS PS
		INNER JOIN SCHEDULE SH
		ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
		AND SH.GAME_DATE = '$roundDate'
		AND SH.FORFEIT IS NULL
		AND SH.HOME_SCORE <> SH.AWAY_SCORE
		
		) AS PST
		INNER JOIN PLAYERS PL
		ON PST.PLAYERID = PL.PLAYERID

		INNER JOIN TEAMS HOME_TEAM
		ON PST.HOME_TEAM = HOME_TEAM.TEAMNUM

		INNER JOIN TEAMS AWAY_TEAM
		ON PST.AWAY_TEAM = AWAY_TEAM.TEAMNUM

		ORDER BY PST.SCHEDULE_ID, TEAM_ORDER, PST.TEAM_NUMBER, PST.PLAYED DESC, PST.GAME_EFF DESC, PST.MINS ASC

	";
	
	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$roundEff = $db->sql_fetchrowset($result);	

	$sql = "
		SELECT 	 '1' AS ROW_ORDER
				,PST.PLAYERID
				,PL.FNAME
				,PL.NAME
				,TM.TEAMNAME
				,PST.TEAM_NUMBER 
				,PST.MINS AS MINS
				,PST.POINTS AS POINTS
				,PST.REBOUNDS AS REBOUNDS
				,PST.BLOCKS AS BLOCKS
				,PST.ASSISTS AS ASSISTS
				,PST.STEALS AS STEALS
				,PST.FGA AS FGA
				,PST.FGM AS FGM
				,PST.FTA AS FTA
				,PST.FTM AS FTM
				,PST.TURNOVERS AS TURNOVERS
				,PST.GAME_EFF AS GAME_EFF

		FROM (SELECT	 
		 PS.PLAYERID
		,PS.TEAM_NUMBER 
		,PS.SCHEDULE_ID
		,SH.HOME_TEAM
		,SH.AWAY_TEAM
		,SH.PLAYED_DATE
		,PS.MINS AS MINS
		,PS.POINTS AS POINTS
		,PS.REBOUNDS AS REBOUNDS
		,PS.BLOCKS AS BLOCKS
		,PS.ASSISTS AS ASSISTS
		,PS.STEALS AS STEALS
		,PS.FGA AS FGA
		,PS.FGM AS FGM
		,PS.FTA AS FTA
		,PS.FTM AS FTM
		,PS.TURNOVERS AS TURNOVERS
		,(((POINTS + REBOUNDS + ASSISTS + STEALS + BLOCKS) - ((FGA - FGM) + (FTA - FTM) + TURNOVERS)) + 0.00) AS GAME_EFF
	
		FROM PLAYERSTATS PS
		INNER JOIN SCHEDULE SH
		ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
		AND SH.GAME_DATE = '$roundDate'
		AND SH.FORFEIT IS NULL
		AND SH.HOME_SCORE <> SH.AWAY_SCORE

		ORDER BY GAME_EFF DESC

		LIMIT 1
		) AS PST
		INNER JOIN PLAYERS PL
		ON PST.PLAYERID = PL.PLAYERID

		INNER JOIN TEAMS TM
		ON PL.TEAM = TM.TEAMNUM

UNION 

			SELECT 	 '2' AS ROW_ORDER
					,PST.PLAYERID
					,PL.FNAME
					,PL.NAME
					,TM.TEAMNAME
					,PST.TEAM_NUMBER 
					,PST.MINS / PST.PLAYED AS MINS
					,PST.POINTS / PST.PLAYED AS POINTS
					,PST.REBOUNDS / PST.PLAYED AS REBOUNDS
					,PST.BLOCKS / PST.PLAYED AS BLOCKS
					,PST.ASSISTS / PST.PLAYED  AS ASSISTS
					,PST.STEALS / PST.PLAYED AS STEALS
					,PST.FGA AS FGA
					,PST.FGM AS FGM
					,PST.FTA AS FTA
					,PST.FTM AS FTM
					,PST.TURNOVERS / PST.PLAYED AS TURNOVERS
					,PST.GAME_EFF AS GAME_EFF
	
			FROM (SELECT	 
			 PS.PLAYERID
			,PS.TEAM_NUMBER 
			,SUM(PS.MINS) AS MINS
			,SUM(PS.POINTS) AS POINTS
			,SUM(PS.REBOUNDS) AS REBOUNDS
			,SUM(PS.BLOCKS) AS BLOCKS
			,SUM(PS.ASSISTS) AS ASSISTS
			,SUM(PS.STEALS) AS STEALS
			,SUM(PS.FGA) AS FGA
			,SUM(PS.FGM) AS FGM
			,SUM(PS.FTA) AS FTA
			,SUM(PS.FTM) AS FTM
			,SUM(PS.TURNOVERS) AS TURNOVERS
			,SUM(PS.PLAYED) as PLAYED
			,(((SUM(POINTS) + SUM(REBOUNDS) + SUM(ASSISTS) + SUM(STEALS) + SUM(BLOCKS)) - ((SUM(FGA) - SUM(FGM)) + (SUM(FTA) - SUM(FTM)) + SUM(TURNOVERS))) + 0.00) / SUM(PS.PLAYED) AS GAME_EFF
		
			FROM PLAYERSTATS PS
			INNER JOIN SCHEDULE SH
			ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
			AND SH.GAME_DATE = '$roundDate'
			AND SH.FORFEIT IS NULL
			AND SH.HOME_SCORE <> SH.AWAY_SCORE
	
			GROUP BY 1,2
			ORDER BY GAME_EFF DESC
			
			LIMIT 1
			) AS PST
			INNER JOIN PLAYERS PL
			ON PST.PLAYERID = PL.PLAYERID
	
			INNER JOIN TEAMS TM
			ON PST.TEAM_NUMBER = TM.TEAMNUM
			
		ORDER BY ROW_ORDER ASC


	";
	
	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$roundEffPlayer = $db->sql_fetchrowset($result);	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE>Efficiency Recap</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewEffRecap">
<div id="mainbox">
<div id="topheading">Efficiency Recap</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">
<? 
	include('efffinder.php');
	include('effexplain.php');

	if (count($roundEff) > 0) {
		efficiencyRoundRecap($roundEff); 	
	}
	efficiencyRecap($seasonTopEff, $season); 
?>
</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
