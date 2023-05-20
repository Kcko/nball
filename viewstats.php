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

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	if ($stat_type == "") { 
		$stat_type = "POINTS";
		$stat_view = "PG";
	}


	$sql = "select STAT_SQL, STAT_NAME, STAT_RANK, STAT_TOPIC from STATS_SQL where STAT_TYPE = \"$stat_type\" and STAT_VIEW = \"$stat_view\"";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$playerStatsSQL = $db->sql_fetchrow($result);

	$sql = $playerStatsSQL["STAT_SQL"];
	$stat_type = $playerStatsSQL["STAT_NAME"];
	$stat_rank = $playerStatsSQL["STAT_RANK"];
	$stat_topic = $playerStatsSQL["STAT_TOPIC"];

/*	$limit = 50;

	switch ($stat_type) {
	
		case "DOUBLE" : 
			$sql = createLeagueLeadersSQLDouble($stat_type, $limit);
			break;
	
		case "TRIPLE" : 
			$sql = createLeagueLeadersSQLDouble($stat_type, $limit);
			break;
			
		case "EFFICIENCY" : 
			$sql = createLeagueLeadersEfficiency($limit);
			break;
			
		default: 
			$sql = createLeagueLeadersSQL($stat_type, $limit);
	}
*/

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$playerStats = $db->sql_fetchrowset($result);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE>League Leaders</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewStats">
<div id="mainbox">
<div id="topheading">League Leaders</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">
<? 
//	createLeagueLeadersImage($playerStats[0], $stat_view);
	include('statsfinder.php');
	createLeagueLeaders($playerStats, $stat_type, $stat_view); 
?>
</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
