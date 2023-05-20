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
	
	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from players, teams, position where teams.teamnum = players.team and players.position = position.position order by name, fname";

	if ( !($result = $db->sql_query($sql)) ) {
//		message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrowset($result);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE>Playerlist</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewPlayerList">
<div id="mainbox">
<div id="topheading">Player List</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">

<?
	$c_name = "";
	$p_name = "";

	foreach ($row as $player) {
		$c_name = substr($player["NAME"],0,1);
		
		
		if ($c_name != $p_name) {

			if ($p_name != "") {
				echo "</div>";
			}

			echo "<div class=namelistBox>";
			echo "<b>$c_name</b><BR>";

			$p_name = $c_name;
		}

		if (trim($player["FNAME"]) == "") {
			$playerName = $player["NAME"];
		} else {
			$playerName = $player["NAME"] . "," . $player["FNAME"];
		}
		
		
		$playerID = $player["PLAYERID"];
		echo "<div id=playerlink><a href=viewplayer.php?playerID=$playerID>$playerName</a></div>";
	}

	
?>

</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
