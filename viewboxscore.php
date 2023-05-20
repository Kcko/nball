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
	include('inc_box.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = createGameStatsSQL($scheduleID);

	$result = $db->sql_query($sql);
	$rowset = $db->sql_fetchrow($result);
//	print_r($rowset);

	$sql = createPlayerStatsSQL($scheduleID, $rowset["HOME_TEAMNUM"]);
	$result = $db->sql_query($sql);
	$homePlayerStats = $db->sql_fetchrowset($result);

//	echo "<pre>";
//	print_r($homePlayerStats);
//	echo "</pre>";

	$sql = createPlayerStatsSQL($scheduleID, $rowset["AWAY_TEAMNUM"]);
	$result = $db->sql_query($sql);
	$awayPlayerStats = $db->sql_fetchrowset($result);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE><? echo $rowset["AWAY_TEAMNAME"] . " @ " . $rowset["HOME_TEAMNAME"]?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewBoxscore">
<div id="mainbox">
<div id="topheading">Players</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">

<div id="awayTeamLogo"><? createTeamImageURL($rowset["AWAY_TEAMNUM"], $rowset["AWAY_POINTS"]); 	?></div><!-- div: awayTeamLogo -->	
<div id="gameStatsTable"><? createGameBoxScore($rowset); ?></div> <!-- div: gameStatsTable -->
<div id="homeTeamLogo"><? createTeamImageURL($rowset["HOME_TEAMNUM"], $rowset["HOME_POINTS"]); ?></div><!-- div: homeTeamLogo -->


<div id="playerStatsAway"><? createPlayerStats($awayPlayerStats, $rowset["AWAY_TEAMNAME"]); ?> </div>
<div id="playerStatsHome"><? createPlayerStats($homePlayerStats, $rowset["HOME_TEAMNAME"]); ?> </div>



</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
