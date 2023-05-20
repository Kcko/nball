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

    error_reporting(E_ALL & ~E_NOTICE);

	include('header.php');
	include('config.php');
	include('mysql.php');
	include('inc_standings.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	/* work out the current season */
	$sql = "SELECT DISTINCT
	 SE.SEASON_ID
	,SE.SEASON

	FROM SEASON SE

	WHERE CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
	LIMIT 1 ";

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$currentSeason = $db->sql_fetchrow($result);

	$seasonID = $currentSeason["SEASON_ID"];
	$season = $currentSeason["SEASON"];
	$seasonNumber = $seasonID - 1;


	/* work out the current round */
	$sql = "SELECT DISTINCT
		 SE.SEASON_ID
		,SE.SEASON
		,SH.GAME_DATE
		,SH.ROUND_NUM

		FROM SEASON SE
		INNER JOIN SCHEDULE SH
		ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE


		WHERE SH.GAME_DATE > CURDATE()
		AND SE.SEASON_ID = $seasonID
		ORDER BY GAME_DATE, ROUND_NUM
		LIMIT 1";

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$currentSeason = $db->sql_fetchrow($result);

	$roundDate = $currentSeason["GAME_DATE"];
	$round = $currentSeason["ROUND_NUM"];

	$sql = createConfStandingsSeasonSQL($seasonID);

	$result = $db->sql_query($sql);
	$rowset = $db->sql_fetchrowset($result);

	$eastern = array_filter($rowset, "easternConference");
	$easternSorted = $eastern;
	rsort($easternSorted);
	$eastGamesBehind = $easternSorted[0]["GAME_DIFF"];

	$western = array_filter($rowset, "westernConference");
	$westernSorted = $western;
	rsort($westernSorted);
	$westGamesBehind = $westernSorted[0]["GAME_DIFF"];
/*
	$sql = "
		SELECT	 SH.SCHEDULE_ID as SCHEDULE_ID
			,TH.TEAMNAME as HOME_TEAMNAME
			,TH.TEAMNUM as HOME_TEAMNUM
			,TH.ABBREV as HOME_ABBREV
			,TA.TEAMNAME as AWAY_TEAMNAME
			,TA.TEAMNUM as AWAY_TEAMNUM
			,TA.ABBREV as AWAY_ABBREV
			,SH.HOME_SCORE as HOME_SCORE
			,SH.AWAY_SCORE as AWAY_SCORE
			,PLAYED_DATE
			,GAME_DATE
			,PLAYED
		FROM	schedule SH

		INNER JOIN teams TH
		ON SH.HOME_TEAM = TH.TEAMNUM

		INNER JOIN teams TA
		ON SH.AWAY_TEAM = TA.TEAMNUM

		where FORFEIT IS NULL
		AND SH.HOME_SCORE <> SH.AWAY_SCORE
		AND SH.PLAYED = 1
		AND SH.SCHEDULE_ID IN (
			SELECT SCHEDULE_ID
			FROM SCHEDULE SH
			INNER JOIN SEASON SE
			ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			WHERE SH.ROUND_NUM = $round
		)

		order by PLAYED_DATE DESC, PLAYED_TIME DESC, SCHEDULE_ID ASC
	";
*/
		$sql = "
		SELECT	 SH.SCHEDULE_ID as SCHEDULE_ID
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
			,SH.OVERTIME
			,PST.POINTS
			,PL.PLAYERID
			,PL.FNAME
			,PL.NAME
		FROM	schedule SH
		INNER JOIN SEASON SE
		ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND SH.ROUND_NUM = $round

		INNER JOIN teams TH
		ON SH.HOME_TEAM = TH.TEAMNUM

		INNER JOIN teams TA
		ON SH.AWAY_TEAM = TA.TEAMNUM

		INNER JOIN PLAYERSTATS PST
		ON PST.SCHEDULE_ID = SH.SCHEDULE_ID
		AND PST.POINTS = (SELECT MAX(POINTS) FROM PLAYERSTATS WHERE SCHEDULE_ID = SH.SCHEDULE_ID)

		INNER JOIN PLAYERS PL
		ON PST.PLAYERID = PL.PLAYERID

		WHERE FORFEIT IS NULL
		AND SH.HOME_SCORE <> SH.AWAY_SCORE
		AND SH.PLAYED = 1

		order by SH.PLAYED_DATE DESC, SH.PLAYED_TIME DESC, SH.SCHEDULE_ID ASC, PST.MINS

		";

	$result = $db->sql_query($sql);
	$rowset = $db->sql_fetchrowset($result);
	$scoreBoard= $rowset;


	$sql = "
		SELECT	 SH.SCHEDULE_ID as SCHEDULE_ID
			,TH.TEAMNAME as HOME_TEAMNAME
			,TH.TEAMNUM as HOME_TEAMNUM
			,TH.ABBREV as HOME_ABBREV
			,TA.TEAMNAME as AWAY_TEAMNAME
			,TA.TEAMNUM as AWAY_TEAMNUM
			,TA.ABBREV as AWAY_ABBREV
			,SH.HOME_SCORE as HOME_SCORE
			,SH.AWAY_SCORE as AWAY_SCORE
			,PLAYED_DATE
			,GAME_DATE
			,PLAYED

		FROM	schedule SH

		INNER JOIN teams TH
		ON SH.HOME_TEAM = TH.TEAMNUM

		INNER JOIN teams TA
		ON SH.AWAY_TEAM = TA.TEAMNUM

		where SH.PLAYED = 0
		AND SH.SCHEDULE_ID IN (
			SELECT SCHEDULE_ID
			FROM SCHEDULE SH
			INNER JOIN SEASON SE
			ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			WHERE SH.ROUND_NUM = $round
		)

		order by PLAYED_DATE DESC, PLAYED_TIME DESC, SCHEDULE_ID ASC

	";

	$result = $db->sql_query($sql);
	$rowset = $db->sql_fetchrowset($result);
	$schedule = $rowset;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body>
<div id="mainbox">
<div id="topheading">Standings</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">

<div class="marginBlock" style="width: 278px; margin: 3px ;">
	<?	createDailyConferenceStandings($easternSorted, $eastGamesBehind, $westernSorted, $westGamesBehind); ?>
</div>


<div class="marginBlock" style="width: 278px; margin: 3px;">
	<?	createLeagueLeaders(); ?>
</div>
<div class="marginBlock" style="float:left; width: 278px; margin: 3px ;">
<?	createDailyGameRecap($scoreBoard); ?>
</div>
<div class="marginBlock" style="float:right; width: 278px; margin: 3px ;">
<? 	createDailyUpcomingGames($schedule); ?>
</div>

</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
