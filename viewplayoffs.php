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
	include("config.php");
	include("mysql.php");
	include('inc_playoffs.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from season where not (curdate() between season_sdte and season_edte) order by season_id desc";
	$result = $db->sql_query($sql);
	$seasons = $db->sql_fetchrowset($result);

	$lastSeasonID = $seasons[0]["SEASON_ID"];
	
	if ($seasonID == "") {
		$seasonID = $lastSeasonID;
	}


$sql = "select	 teams.TEAMNUM
		,teams.CITYNAME2 as TEAMNAME
		,teams.CITYNAME
		,conference.CONFERENCE_NAME
		,division.DIVISION_NAME
		,coalesce(HOME_WIN,0) as HOME_WIN
		,coalesce(AWAY_WIN,0) as AWAY_WIN
		,coalesce(HOME_WIN,0) + coalesce(AWAY_WIN,0) as TOTAL_WIN
		,coalesce(HOME_LOSS,0) as HOME_LOSS
		,coalesce(AWAY_LOSS,0) as AWAY_LOSS
		,coalesce(HOME_LOSS,0) + coalesce(AWAY_LOSS,0) as TOTAL_LOSS
		,coalesce(((coalesce(HOME_WIN  + 0.00,0.00)  + coalesce(AWAY_WIN + 0.00,0.00) ) / (coalesce(HOME_LOSS + 0.00,0.00) + coalesce(AWAY_LOSS + 0.00,0.00) + coalesce(HOME_WIN + 0.00,0.00) + coalesce(AWAY_WIN + 0.00,0.00))) + 0.00,0.00) as WIN_PERCENT 
		,coalesce(HOME_TEAM_HOME_POINTs,0) + coalesce(AWAY_TEAM_AWAY_POINTs,0) as POINTS_FOR
		,coalesce(HOME_TEAM_AWAY_POINTs,0) + coalesce(AWAY_TEAM_HOME_POINTs,0) as POINTS_AGAINST
		,coalesce((((coalesce(HOME_TEAM_HOME_POINTs + 0.00,0.00) + coalesce(AWAY_TEAM_AWAY_POINTs + 0.00,0.00)) / (coalesce(HOME_TEAM_AWAY_POINTs + 0.00,0.00) + coalesce(AWAY_TEAM_HOME_POINTs + 0.00,0.00))) ) + 0.00,0.00) as WIN_PERC

	
	from teams
	inner join conference
	on conference.conference = teams.conference
	inner join division
	on division.division = teams.division
	
	left join
	(select   home_team
		,sum(case when home_score > away_score then '1' else '0' end) as HOME_WIN
		,sum(case when home_score < away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as HOME_LOSS
		,sum(away_score) as HOME_TEAM_AWAY_POINTs
		,sum(home_score) as HOME_TEAM_HOME_POINTs

	from schedule where played = 1 and game_type = 0 
		AND SCHEDULE_ID IN (
					SELECT SCHEDULE_ID 
					FROM SCHEDULE SH
					INNER JOIN SEASON SE
					ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
					AND SE.SEASON_ID = $seasonID
		)

	
	group by 1) as home_game
	on home_game.home_team = teamnum
	

	left join
	(select   away_team
		,sum(case when home_score < away_score then '1' else '0' end) as AWAY_WIN
		,sum(case when home_score > away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as AWAY_LOSS
		,sum(away_score) as AWAY_TEAM_AWAY_POINTs
		,sum(home_score) as AWAY_TEAM_HOME_POINTs
	

	from schedule  where played = 1 and game_type = 0 
		AND SCHEDULE_ID IN (
					SELECT SCHEDULE_ID 
					FROM SCHEDULE SH
					INNER JOIN SEASON SE
					ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
					AND SE.SEASON_ID = $seasonID
		)

	
	group by 1) as away_game
	on away_game.away_team = teamnum
	
	where teamnum < 29
	
	
order by teams.conference, win_percent desc, WIN_PERC desc, total_win desc, teamnum";

$result = $db->sql_query($sql);
$rowset = $db->sql_fetchrowset($result);



$sql = "select	 teams.TEAMNUM
		,teams.CITYNAME2 as TEAMNAME
		,teams.CITYNAME
		,conference.CONFERENCE_NAME
		,division.DIVISION_NAME
		,coalesce(HOME_WIN,0) as HOME_WIN
		,coalesce(AWAY_WIN,0) as AWAY_WIN
		,coalesce(HOME_WIN,0) + coalesce(AWAY_WIN,0) as TOTAL_WIN
		,coalesce(HOME_LOSS,0) as HOME_LOSS
		,coalesce(AWAY_LOSS,0) as AWAY_LOSS
		,coalesce(HOME_LOSS,0) + coalesce(AWAY_LOSS,0) as TOTAL_LOSS
	
	from teams
	inner join conference
	on conference.conference = teams.conference
	inner join division
	on division.division = teams.division
	
	left join
	(select   home_team
		,game_type	
		,sum(case when home_score > away_score then '1' else '0' end) as HOME_WIN
		,sum(case when home_score < away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as HOME_LOSS
		,sum(away_score) as HOME_TEAM_AWAY_POINTs
		,sum(home_score) as HOME_TEAM_HOME_POINTs

	from schedule where played = 1 
		AND SCHEDULE_ID IN (
					SELECT SCHEDULE_ID 
					FROM SCHEDULE SH
					INNER JOIN SEASON SE
					ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
					AND SE.SEASON_ID = $seasonID
		)

	
	
	group by 1,2) as home_game
	on home_game.home_team = teamnum
	and home_game.game_type = 1 
	

	left join
	(select   away_team
		,game_type
		,sum(case when home_score < away_score then '1' else '0' end) as AWAY_WIN
		,sum(case when home_score > away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as AWAY_LOSS
		,sum(away_score) as AWAY_TEAM_AWAY_POINTs
		,sum(home_score) as AWAY_TEAM_HOME_POINTs

	

	from schedule where played = 1 and game_type = 1 
			AND SCHEDULE_ID IN (
						SELECT SCHEDULE_ID 
						FROM SCHEDULE SH
						INNER JOIN SEASON SE
						ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
						AND SE.SEASON_ID = $seasonID
			)
	

	group by 1,2) as away_game
	on away_game.away_team = teamnum
	and away_game.game_type = 1 
	
	where teamnum < 29
order by teamnum";

$resultR1 = $db->sql_query($sql);
$rowsetR1 = $db->sql_fetchrowset($resultR1);

$sql = "select	 teams.TEAMNUM
		,teams.CITYNAME2 as TEAMNAME
		,teams.CITYNAME
		,conference.CONFERENCE_NAME
		,division.DIVISION_NAME
		,coalesce(HOME_WIN,0) as HOME_WIN
		,coalesce(AWAY_WIN,0) as AWAY_WIN
		,coalesce(HOME_WIN,0) + coalesce(AWAY_WIN,0) as TOTAL_WIN
		,coalesce(HOME_LOSS,0) as HOME_LOSS
		,coalesce(AWAY_LOSS,0) as AWAY_LOSS
		,coalesce(HOME_LOSS,0) + coalesce(AWAY_LOSS,0) as TOTAL_LOSS
	
	from teams
	inner join conference
	on conference.conference = teams.conference
	inner join division
	on division.division = teams.division
	
	left join
	(select   home_team
		,game_type	
		,sum(case when home_score > away_score then '1' else '0' end) as HOME_WIN
		,sum(case when home_score < away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as HOME_LOSS
		,sum(away_score) as HOME_TEAM_AWAY_POINTs
		,sum(home_score) as HOME_TEAM_HOME_POINTs

	from schedule where played = 1 
			AND SCHEDULE_ID IN (
						SELECT SCHEDULE_ID 
						FROM SCHEDULE SH
						INNER JOIN SEASON SE
						ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
						AND SE.SEASON_ID = $seasonID
			)
	

	group by 1,2) as home_game
	on home_game.home_team = teamnum
	and home_game.game_type = 2
	

	left join
	(select   away_team
		,game_type
		,sum(case when home_score < away_score then '1' else '0' end) as AWAY_WIN
		,sum(case when home_score > away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as AWAY_LOSS
		,sum(away_score) as AWAY_TEAM_AWAY_POINTs
		,sum(home_score) as AWAY_TEAM_HOME_POINTs

	

	from schedule where played = 1 and game_type = 2 
			AND SCHEDULE_ID IN (
						SELECT SCHEDULE_ID 
						FROM SCHEDULE SH
						INNER JOIN SEASON SE
						ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
						AND SE.SEASON_ID = $seasonID
			)
	

	group by 1,2) as away_game
	on away_game.away_team = teamnum
	and away_game.game_type = 2 
	
	where teamnum < 29
order by teamnum";

$resultR2 = $db->sql_query($sql);
$rowsetR2 = $db->sql_fetchrowset($resultR2);

$sql = "select	 teams.TEAMNUM
		,teams.CITYNAME2 as TEAMNAME
		,teams.CITYNAME
		,conference.CONFERENCE_NAME
		,division.DIVISION_NAME
		,coalesce(HOME_WIN,0) as HOME_WIN
		,coalesce(AWAY_WIN,0) as AWAY_WIN
		,coalesce(HOME_WIN,0) + coalesce(AWAY_WIN,0) as TOTAL_WIN
		,coalesce(HOME_LOSS,0) as HOME_LOSS
		,coalesce(AWAY_LOSS,0) as AWAY_LOSS
		,coalesce(HOME_LOSS,0) + coalesce(AWAY_LOSS,0) as TOTAL_LOSS
	
	from teams
	inner join conference
	on conference.conference = teams.conference
	inner join division
	on division.division = teams.division
	
	left join
	(select   home_team
		,game_type	
		,sum(case when home_score > away_score then '1' else '0' end) as HOME_WIN
		,sum(case when home_score < away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as HOME_LOSS
		,sum(away_score) as HOME_TEAM_AWAY_POINTs
		,sum(home_score) as HOME_TEAM_HOME_POINTs

	from schedule where played = 1 
		AND SCHEDULE_ID IN (
					SELECT SCHEDULE_ID 
					FROM SCHEDULE SH
					INNER JOIN SEASON SE
					ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
					AND SE.SEASON_ID = $seasonID
		)

	
	
	group by 1,2) as home_game
	on home_game.home_team = teamnum
	and home_game.game_type = 3
	

	left join
	(select   away_team
		,game_type
		,sum(case when home_score < away_score then '1' else '0' end) as AWAY_WIN
		,sum(case when home_score > away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as AWAY_LOSS
		,sum(away_score) as AWAY_TEAM_AWAY_POINTs
		,sum(home_score) as AWAY_TEAM_HOME_POINTs

	

	from schedule where played = 1 and game_type = 3 
		AND SCHEDULE_ID IN (
					SELECT SCHEDULE_ID 
					FROM SCHEDULE SH
					INNER JOIN SEASON SE
					ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
					AND SE.SEASON_ID = $seasonID
		)

	
	group by 1,2) as away_game
	on away_game.away_team = teamnum
	and away_game.game_type = 3
	
	where teamnum < 29
order by teamnum";

$resultR3 = $db->sql_query($sql);
$rowsetR3 = $db->sql_fetchrowset($resultR3);

$sql = "select	 teams.TEAMNUM
		,teams.CITYNAME2 as TEAMNAME
		,teams.CITYNAME
		,conference.CONFERENCE_NAME
		,division.DIVISION_NAME
		,coalesce(HOME_WIN,0) as HOME_WIN
		,coalesce(AWAY_WIN,0) as AWAY_WIN
		,coalesce(HOME_WIN,0) + coalesce(AWAY_WIN,0) as TOTAL_WIN
		,coalesce(HOME_LOSS,0) as HOME_LOSS
		,coalesce(AWAY_LOSS,0) as AWAY_LOSS
		,coalesce(HOME_LOSS,0) + coalesce(AWAY_LOSS,0) as TOTAL_LOSS
	
	from teams
	inner join conference
	on conference.conference = teams.conference
	inner join division
	on division.division = teams.division
	
	left join
	(select   home_team
		,game_type	
		,sum(case when home_score > away_score then '1' else '0' end) as HOME_WIN
		,sum(case when home_score < away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as HOME_LOSS
		,sum(away_score) as HOME_TEAM_AWAY_POINTs
		,sum(home_score) as HOME_TEAM_HOME_POINTs

	from schedule where played = 1 
		AND SCHEDULE_ID IN (
					SELECT SCHEDULE_ID 
					FROM SCHEDULE SH
					INNER JOIN SEASON SE
					ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
					AND SE.SEASON_ID = $seasonID
		)

	
	group by 1,2) as home_game
	on home_game.home_team = teamnum
	and home_game.game_type = 4
	

	left join
	(select   away_team
		,game_type
		,sum(case when home_score < away_score then '1' else '0' end) as AWAY_WIN
		,sum(case when home_score > away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as AWAY_LOSS
		,sum(away_score) as AWAY_TEAM_AWAY_POINTs
		,sum(home_score) as AWAY_TEAM_HOME_POINTs

	

	from schedule where played = 1 and game_type = 4 
		AND SCHEDULE_ID IN (
					SELECT SCHEDULE_ID 
					FROM SCHEDULE SH
					INNER JOIN SEASON SE
					ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
					AND SE.SEASON_ID = $seasonID
		)

	
	group by 1,2) as away_game
	on away_game.away_team = teamnum
	and away_game.game_type = 4
	
	where teamnum < 29
order by teamnum";

$resultR4 = $db->sql_query($sql);
$rowsetR4 = $db->sql_fetchrowset($resultR4);


	$PlayOffSeeds[] = buildEasternSeeds($rowset);
	$PlayOffSeeds[] = buildWesternSeeds($rowset);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewPlayoffs">
<div id="mainbox">
<div id="topheading">Standings</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">

<?
	createSeasonList($seasons);

	$PlayoffsRound1Results[0] = createPlayoffsRound1($PlayOffSeeds[0],$rowsetR1, "#214299", $seasonID);
	$PlayoffsRound1Results[1] = createPlayoffsRound1($PlayOffSeeds[1],$rowsetR1, "#b10041", $seasonID);
	$PlayoffsRound2Results[] = createPlayoffsRound2($PlayoffsRound1Results[0],$rowsetR2, "#214299", $seasonID);
	$PlayoffsRound2Results[] = createPlayoffsRound2($PlayoffsRound1Results[1],$rowsetR2, "#b10041", $seasonID);

	$PlayoffsRound3Results[] = createPlayoffsRound3($PlayoffsRound2Results[0],$rowsetR3, "#214299", $seasonID);
	$PlayoffsRound3Results[] = createPlayoffsRound3($PlayoffsRound2Results[1],$rowsetR3, "#b10041", $seasonID);

	createPlayoffsRound4($PlayoffsRound3Results[0],$PlayoffsRound3Results[1],$rowsetR4, "#B0A400", $seasonID);
?>


</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>