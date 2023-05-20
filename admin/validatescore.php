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

	include('..\header.php');
	include ('..\inc_subscore.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from teams order by teamnum";
	$result = $db->sql_query($sql);
	$rowset = $db->sql_fetchrowset($result);

	$homeTeamStats = $_FILES['userfile']['tmp_name'][0];
	$awayTeamStats = $_FILES['userfile']['tmp_name'][1];
	$gameStats = $_FILES['userfile']['tmp_name'][2];

	if ($homeTeamStats == "" | $awayTeamStats == "" | $gameStats == "") {
		die("missing files");
	}

	if ($homeTeamStats && $awayTeamStats && $gameStats) {
		$objHomeTeamStats = createPlayerStatObj($homeTeamStats, $HOME_TEAM, $HOME_TEAMNUM);
		$objAwayTeamStats = createPlayerStatObj($awayTeamStats, $AWAY_TEAM, $AWAY_TEAMNUM);
		$objGameStats = createGameStatObj($gameStats, $HOME_TEAM, $HOME_TEAMNUM, $AWAY_TEAM, $AWAY_TEAMNUM);
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE>Submit Scores</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="../nball.css" type=text/css rel=stylesheet>
<SCRIPT src="../nball.js" type=text/javascript></SCRIPT>
<!--<META HTTP-EQUIV=Refresh CONTENT="10; URL=..\viewfullschedule.php">-->
</head>
<body id="subScores">
<div id="mainbox">
<div id="topheading">Submit Scores</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">

<?

	createTeamImageURL($AWAY_TEAMNUM); 
	echo "<font size=20>@</a></font>" ; 
	createTeamImageURL($HOME_TEAMNUM); 
	
	loadGameStats($SCHEDULE_ID, $objGameStats, $objHomeTeamStats, $objAwayTeamStats);	
	
?>
<br><br><center><a href=..\viewfullschedule.php> back to schedule </a></center><br>
</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('..\footer.php'); ?>
</body>
</html>
