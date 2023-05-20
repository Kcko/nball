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
	include('inc_standings.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from season order by season_id desc";
	$result = $db->sql_query($sql);
	$seasons = $db->sql_fetchrowset($result);

	if ($seasonID == "") {
		$sql = "select SEASON_ID from season where curdate() between season_sdte and season_edte";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$seasonID = $row["SEASON_ID"];
	}

	$sql = createStandingsSeasonSQL($seasonID);

	if ($viewType == "conf") {
		$sql = createConfStandingsSeasonSQL($seasonID);
	}

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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewStandings">
<div id="mainbox">
<div id="topheading">Standings</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">

<?

	switch ($viewType) {
		case "conf" :
			createConfSeasonList($seasons);
			createDivisionHeader($eastern);
			createConferenceStandings($eastern, $eastGamesBehind);
			createDivisionHeader($western);
			createConferenceStandings($western, $westGamesBehind);
			break;
	
		default: 
			createSeasonList($seasons);
			createDivisionHeader($eastern);
			createDivisionStandings($eastern, $eastGamesBehind);
			createDivisionHeader($western);
			createDivisionStandings($western, $westGamesBehind);
	}
	
?>


</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
