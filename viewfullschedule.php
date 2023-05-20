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
	include('inc_subscore.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	if ($round == "" or $seasonID == "") {
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

		if ( !($result = $db->sql_query($sql)) ) {
			echo "failed";
		}

		$currentSeason = $db->sql_fetchrow($result);

		$seasonID = $currentSeason["SEASON_ID"];
		$season = $currentSeason["SEASON"];
		$seasonNumber = $seasonID - 1;
		$roundDate = $currentSeason["GAME_DATE"];
		$round = $currentSeason["ROUND_NUM"];

	}

		$sql = "SELECT DISTINCT
		 SE.SEASON_ID
		,SH.ROUND_NUM

		FROM SEASON SE 
		INNER JOIN SCHEDULE SH
		ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

		WHERE SE.SEASON_ID = $seasonID
		ORDER BY ROUND_NUM";

		if ( !($result = $db->sql_query($sql)) ) {
			echo "failed";
		}

		$currentRounds = $db->sql_fetchrowset($result);



/*	
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
			,GAME_TYPE
			
		FROM	schedule SH

		INNER JOIN teams TH
		ON SH.HOME_TEAM = TH.TEAMNUM

		INNER JOIN teams TA
		ON SH.AWAY_TEAM = TA.TEAMNUM

		WHERE (TH.TEAMNUM = $teamID or TA.TEAMNUM = $teamID)
		and SH.GAME_TYPE = 0		
			AND SH.SCHEDULE_ID IN (
				SELECT SCHEDULE_ID 
				FROM SCHEDULE SH
				INNER JOIN SEASON SE
				ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
				AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			)
		order by SCHEDULE_ID, GAME_DATE";
*/

	$sql = "
		SELECT	 DISTINCT SH.SCHEDULE_ID as SCHEDULE_ID 
			,TH.TEAMNAME as HOME_TEAMNAME
			,TH.TEAMNUM as HOME_TEAMNUM
			,TH.ABBREV as HOME_ABBREV
			,TA.TEAMNAME as AWAY_TEAMNAME
			,TA.TEAMNUM as AWAY_TEAMNUM
			,TA.ABBREV as AWAY_ABBREV
			,SH.HOME_SCORE as HOME_SCORE
			,SH.AWAY_SCORE as AWAY_SCORE
			,SH.PLAYED_DATE
			,SH.GAME_DATE
			,SH.PLAYED
			,SH.ROUND_NUM
			,SH.FORFEIT
			,SH.OVERTIME
			,PSTP.POINTS as POINTS_COUNT
			,PLP.PLAYERID as POINTS_PLAYERID
			,PLP.NAME as POINTS_NAME
			,PSTR.REBOUNDS as REBOUNDS_COUNT
			,PLR.PLAYERID as REBOUNDS_PLAYERID
			,PLR.NAME as REBOUNDS_NAME
			
		FROM	schedule SH
		INNER JOIN SEASON SE
		ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND SE.SEASON_ID = $seasonID
		AND SH.ROUND_NUM = $round

		INNER JOIN teams TH
		ON SH.HOME_TEAM = TH.TEAMNUM
	
		INNER JOIN teams TA
		ON SH.AWAY_TEAM = TA.TEAMNUM

		LEFT JOIN PLAYERSTATS PSTP
		ON PSTP.SCHEDULE_ID = SH.SCHEDULE_ID
		AND PSTP.POINTS = (SELECT MAX(POINTS) FROM PLAYERSTATS WHERE SCHEDULE_ID = SH.SCHEDULE_ID)
		AND SH.FORFEIT IS NULL
		AND SH.HOME_SCORE <> SH.AWAY_SCORE	
		
		LEFT JOIN PLAYERS PLP
		ON PSTP.PLAYERID = PLP.PLAYERID

		LEFT JOIN PLAYERSTATS PSTR
		ON PSTR.SCHEDULE_ID = SH.SCHEDULE_ID
		AND PSTR.REBOUNDS = (SELECT MAX(REBOUNDS) FROM PLAYERSTATS WHERE SCHEDULE_ID = SH.SCHEDULE_ID)
		AND SH.FORFEIT IS NULL
		AND SH.HOME_SCORE <> SH.AWAY_SCORE
		
		LEFT JOIN PLAYERS PLR
		ON PSTR.PLAYERID = PLR.PLAYERID
		
		order by SH.GAME_DATE, SH.PLAYED DESC, SH.PLAYED_DATE, SH.PLAYED_TIME, SH.SCHEDULE_ID ASC, PLP.PLAYERID, PLR.PLAYERID

		";
	$result = $db->sql_query($sql);
	$rowset = $db->sql_fetchrowset($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE><? echo $row["FNAME"] . " " . $row["NAME"]?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewFullSchedule">
<div id="mainbox">
<div id="topheading">Players</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">


<? //createScheduleTeamDropDown(); ?>
<? 	createSchedule($rowset,$currentRounds); ?>


</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
