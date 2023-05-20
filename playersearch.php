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

	include('config.php');
	include('mysql.php');
	include('inc_search.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE>Player Search</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewPlayer">
<div id="mainbox">
<div id="topheading">Player Search</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">

<?

	createSearchBox($HTTP_POST_VARS);
	if ($submit == 1) {
		$sql = createSQL($HTTP_POST_VARS);
		$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrowset($result);
		createTeamLineup($row);
	}



?>

</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>

