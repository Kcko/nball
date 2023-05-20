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
	include('inc_team.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * 
from award awd
inner join award_win aww
on awd.award_id = aww.award_id

inner join season se
on se.season_id = aww.season_id
and se.season_id = 1

left join players pl
on pl.playerid = aww.player_id
and awd.award_type = 1

left join teams tm
on tm.teamnum = aww.player_id
and awd.award_type = 2

order by awd.award_id, pl.name, pl.fname

";


	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrowset($result);

	//print_r($row);


//	echo "<pre>";
//	print_r($seasonGameStats);
//	echo "</pre>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE><? echo $row["FNAME"] . " " . $row["NAME"]?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK href="nball.css" type=text/css rel=stylesheet>
<SCRIPT src="nball.js" type=text/javascript></SCRIPT>
</head>
<body id="viewAwards">
<div id="mainbox">
<div id="topheading">Players</div>
<div id="blackspacer"><center><img src=logo.gif></img></center><br>
<div id="box"><? include("menu.php"); ?>
</div></div>
<div id="contentbox">
<? 
	$c_awardDesc = "";
	$p_awardDesc = "";

	foreach ($row as $player) {
		$c_awardDesc = $player["AWARD_DESC"];
		if ($c_awardDesc != $p_awardDesc) {
			echo "<b>$c_awardDesc</b><BR>";
			$p_awardDesc = $c_awardDesc;
		}

		switch ($player["AWARD_TYPE"]) {
			case 1:
				echo $player["FNAME"] . " " . $player["NAME"] . "<BR>";
				break;
			case 2:
				echo $player["CITYNAME"] . " " . $player["TEAMNAME"] . "<BR>";
				break;
		}

	}
?>

</div><!-- div:contentbox-->
</div><!-- div:box -->
<? include('footer.php'); ?>
</body>
</html>
