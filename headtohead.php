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
	include('inc_player.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "
		SELECT	 SE.SEASON_DESC
				,TM.TEAMNUM
				,PL.PLAYERID
				,PL.FNAME 
				,PL.NAME
				,TM.CITYNAME
				,TM.TEAMNAME
				,PL.HEIGHT
				,PL.WEIGHT
				,PL.OVERALLRTG 
				,POS.POSITION_NAME_SHORT
				,SUM(PS.MINS) AS MINS
				,SUM(PS.FGA) AS FGA
				,SUM(PS.FGM) AS FGM
				,SUM(PS.3PA) AS 3PA
				,SUM(PS.3PM) AS 3PM
				,SUM(PS.FTA) AS FTA
				,SUM(PS.FTM) AS FTM
				,SUM(PS.OREBOUNDS) AS OREB
				,SUM(PS.DREBOUNDS) AS DREB
				,SUM(PS.REBOUNDS) AS REB
				,SUM(PS.BLOCKS) AS BLOCKS
				,SUM(PS.STEALS) AS STEALS
				,SUM(PS.ASSISTS) AS ASSISTS
				,SUM(PS.TURNOVERS) AS TURNOVERS
				,SUM(PS.FOULS) AS FOULS
				,SUM(PS.POINTS) AS POINTS
				,SUM(PS.PLAYED) AS GAME_COUNT
				,SUM(CASE WHEN PS.ROSTERPOS < 5 THEN 1 ELSE 0 END) AS START_COUNT


			FROM SEASON SE
			INNER JOIN PLAYERS PL
			ON PL.PLAYERID = $playerID
			AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			
			INNER JOIN POSITION POS
			ON PL.POSITION = POS.POSITION

			LEFT JOIN TEAMS TM
			ON PL.TEAM = TM.TEAMNUM

			LEFT JOIN PLAYERSTATS PS
			ON PS.PLAYERID = PL.PLAYERID

			LEFT  JOIN SCHEDULE SH
			ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
			AND SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND SH.GAME_TYPE = 0

			GROUP BY 1,2,3,4,5,6,7,8,9,10,11
	";

	if ( !($result = $db->sql_query($sql)) ) {
	}

	$row = $db->sql_fetchrow($result);
//	echo "<PRE>";
//	print_r($row);
//	echo "</pre>";
	
	
	$playerName = $row["FNAME"] . " " . $row["NAME"];
	$teamName = $row["CITYNAME"] . " " . $row["TEAMNAME"];
	
	$playerWeight = $row["WEIGHT"];
	$playerHeight = intval($row["HEIGHT"] / 12) . "-" . $row["HEIGHT"] % 12 ;
	$playerPosition = $row["POSITION_NAME_SHORT"];

	$playerRating = $row["OVERALLRTG"];
	
	$playerIDFormatted = sprintf("%04d", $playerID);
	$playerImageName = "player_" . $playerIDFormatted;
	
	$FTP = 0;
	$TPP = 0;
	$FGP = 0;


	$G    = $row["GAME_COUNT"];
	$MINS = sprintf("%01.2f", $row["MINS"]  / $G );

	$FGA = $row["FGA"];
	$FGM = $row["FGM"];
	if ($FGA > 0) {	$FGP = sprintf("%01.2f", $FGM/$FGA) ;} else {	$FGP = sprintf("%01.2f", 0) ;}

	$TPA = $row["3PA"];
	$TPM = $row["3PM"];
	if ($TPA > 0) {	$TPP = sprintf("%01.2f", $TPM/$TPA) ;} else {	$TPP = sprintf("%01.2f", 0) ;}

	$FTA = $row["FTA"];
	$FTM = $row["FTM"];
	if ($FTA > 0) {	$FTP = sprintf("%01.2f", $FTM/$FTA); } else { $FTP = sprintf("%01.2f", 0);}



	$PTS = $row["POINTS"];
	$REB = $row["REB"];
	$AST = $row["ASSISTS"];
	$STL = $row["STEALS"];
	$BLK = $row["BLOCKS"];

	$TO  = $row["TURNOVERS"];
	$PF  = $row["FOULS"];

	$EFF = (($PTS + $REB + $AST + $STL + $BLK) - (($FGA - $FGM) + ($FTA - $FTM) + $TO)) / $G;
	$EFF = sprintf("%1.2f", $EFF);
	if ($EFF >= 0) {
		$EFF  = "+" . $EFF;
	}


	$ORB = sprintf("%01.1f", $row["OREB"]  / $G );
	$DRB = sprintf("%01.1f", $row["DREB"]  / $G );
	$REB = sprintf("%01.1f", $row["REB"]  / $G );
	$AST = sprintf("%01.1f", $row["ASSISTS"]  / $G );
	$STL = sprintf("%01.1f", $row["STEALS"]  / $G );
	$BLK = sprintf("%01.1f", $row["BLOCKS"]  / $G );
	$TO  = sprintf("%01.1f", $row["TURNOVERS"]  / $G );
	$PF  = sprintf("%01.1f", $row["FOULS"]  / $G );
	$PTS = sprintf("%01.1f", $row["POINTS"]  / $G );
?>


<html>
<head>
<base target="LambertWindow">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<LINK href="nball.css" type=text/css rel=stylesheet>

</head>

<body bgcolor=#ffffff text=#000000 link=#003399 vlink=#003399 marginwidth=0 leftmargin=0 marginheight=0 topmargin=0>
	<table border=0 cellpadding=0 cellspacing=0 width=210>
		<tr>
		<td valign=top>
				 <table border="0" cellspacing="0" class="playerInfoGridPlayerInfoBorders" width="100%">
				 	<tr>
				 		<td valign="top" height="110">
							<img border="0" height=90 width=65 src="images/players/<? echo $playerImageName; ?>.jpg">

						</td>
						<td align="left" valign="top">
							<div class="playerInfoHeadingPlayerInfoBorders"><b><? echo $playerName?></b></div>
							<div class="playerInfoStatsPlayerInfoBorders"><? echo $teamName?></div>
							<div class="playerInfoStatsPlayerInfoBorders">Position:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerPosition;?></span></div>
							<div class="playerInfoStatsPlayerInfoBorders">Height:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerHeight;?> </span> Weight:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerWeight ?></span></div>
							<div class="playerInfoStatsPlayerInfoBorders">Overall Rating:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerRating; ?></span></div>
							<div align="bottom">
									<a class="playerInfoValuePlayerInfoBordersLink" href="viewplayer.php?playerID=<?echo $playerID;?>" >Player file</a> |
									<a class="playerInfoValuePlayerInfoBordersLink" href="viewteam.php?teamID=<?echo $row["TEAMNUM"];?>" >Team stats</a></div>

						</td>
					</tr>
					<tr><td></td></tr>
					<tr>
					<td colspan=2 valign="top" align="center" class="gSGSectionTitleStatsPlayerGrid"><b>2003-04 Statistics</td></tr>
					<tr align="center"><td class="gSGRowEven"><b>PPG</b></td><td class="gSGRowEven"><? echo $PTS; ?></td></tr>
					<tr align="center"><td class="gSGRowOdd"><b>RPG</b></td><td class="gSGRowOdd"><? echo $REB; ?></td></tr>
					<tr align="center"><td class="gSGRowEven"><b>APG</b></td><td class="gSGRowEven"><? echo $AST; ?></td></tr>
					<tr align="center"><td class="gSGRowOdd"><b>SPG</b></td><td class="gSGRowOdd"><? echo $STL; ?></td></tr>
					<tr align="center"><td class="gSGRowEven"><b>BPG</b></td><td class="gSGRowEven"><? echo $BLK; ?></td></tr>
					<tr align="center"><td class="gSGRowOdd"><b>FG%</b></td><td class="gSGRowOdd"><? echo $FGP; ?></td></tr>
					<tr align="center"><td class="gSGRowEven"><b>FT%</b></td><td class="gSGRowEven"><? echo $FTP; ?></td></tr>
					<tr align="center"><td class="gSGRowOdd"><b>3P%</b></td><td class="gSGRowOdd"><? echo $TPP; ?></td></tr>
					<tr align="center"><td class="gSGRowEven"><b>MPG</b></td><td class="gSGRowEven"><? echo $MINS; ?></td></tr>
					<tr align="center"><td class="gSGRowOdd"><b>EFF</b></td><td class="gSGRowOdd"><? echo $EFF; ?></td></tr>

				</table>

</td>
		</tr>
	</table>

</body></html>

</body>
</html>
