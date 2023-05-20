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


function createPlayerImageURL($playerID) {
	$playerIDFormatted = sprintf("%04d", $playerID);
	$playerImageName = "player_" . $playerIDFormatted;

	echo "<img src=\"images/players/" . $playerImageName . ".jpg\" ></img>\n";
}


	include('config.php');
	include('mysql.php');
	include('inc_player.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "
		SELECT	 PL.*
				,SE.SEASON_DESC
				,TM.TEAMNUM
				,TM.CITYNAME
				,TM.TEAMNAME
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
			ON PL.PLAYERID IN (1,6)
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

			GROUP BY 1,2,3,4,5,6 order by PL.PLAYERID
	";

	if ( !($result = $db->sql_query($sql)) ) {
	}

	$row = $db->sql_fetchrowset($result);
//	echo "<PRE>";
//	print_r($row);
//	echo "</pre>";


$ratingsTypes = array(
				array("FGPBASE"
					 ,"THREEPTBAS"
					 ,"FTPBASE"
					 ,"DNKABILITY"
					 ,"DSHOOTRANG"
					 ,"INSIDESC"
					 ,"OREABILITY"
					 ,"JUMP"
					 ,"DSTRENGTH"
					 ,"QUICK"
					 ,"SPEED"
					 ,"BALABILITY"
					 ,"DRIBBLE"
					 ,"OFFABILITY"
					 ,"DREABILITY"
					 ,"STLABILITY"
					 ,"BLKABILITY"
					 ,"DEFABILITY")

			   ,array("FG"
					 ,"3PT"
					 ,"FT"
					 ,"Dunk"
					 ,"Range"
					 ,"Ins. Score"
					 ,"O. Reb"
					 ,"Jump"
					 ,"Stregth"
					 ,"Quick"
					 ,"Speed"
					 ,"Pass"
					 ,"Dribble"
					 ,"O. Aware"
					 ,"D. Reb"
					 ,"Steal"
					 ,"Block"
					 ,"D. Aware"));
					 
	$playerCompare = array();
	$rowCount = count($row);
	$rownum = 0;
	foreach ($row as $value) {

		foreach ($ratingsTypes[0] as $rtgType) {
			$playerCompare[$rtgType][$rownum] = $value[$rtgType];
		}


		$playerName[$rownum] = $value["FNAME"] . " " . $value["NAME"];
		if ($value["TEAMNUM"] < 29) {
			$teamName[$rownum] = $value["CITYNAME"] . " " . $value["TEAMNAME"];
		} else {
			$teamName[$rownum] = $value["CITYNAME"];
		}
		$playerID[$rownum] = $value["PLAYERID"];
		$playerWeight[$rownum] = $value["WEIGHT"];
		$playerHeight[$rownum] = intval($value["HEIGHT"] / 12) . "-" . $value["HEIGHT"] % 12 ;
		$playerPosition[$rownum] = $value["POSITION_NAME_SHORT"];
		$playerRating[$rownum] = $value["OVERALLRTG"];
		$playerName[$rownum] = $value["FNAME"] . " " . $value["NAME"];
		$playerImageName[$rownum] = strtolower(strtr($playerName[$rownum]," ","_"));
		$playerName[$rownum] = $value["FNAME"] . "<br>" . $value["NAME"];
		$rownum++;
	}

//	print_r($playerCompare);
//	echo "</pre>";
/*
	$playerName = $row["FNAME"] . " " . $row["NAME"];
	$teamName = $row["CITYNAME"] . " " . $row["TEAMNAME"];
	
	$playerWeight = $row["WEIGHT"];
	$playerHeight = intval($row["HEIGHT"] / 12) . "-" . $row["HEIGHT"] % 12 ;
	$playerPosition = $row["POSITION_NAME_SHORT"];

	$playerRating = $row["OVERALLRTG"];
	
	$playerImageName = strtolower(strtr($playerName," ","_"));
*/	
	
	
?>


<html>
<head>
<base target="LambertWindow">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="nbav2.css" rel="stylesheet" type="text/css">
<link href="nbaOld.css" rel="stylesheet" type="text/css">
<link href="players.css" rel="stylesheet" type="text/css">

</head>

<body bgcolor=#ffffff text=#000000 link=#003399 vlink=#003399 marginwidth=0 leftmargin=0 marginheight=0 topmargin=0">
	<table border=0 cellpadding=0 cellspacing=0 width=<? echo $rowCount * 125; ?> >
		<tr>
		<td valign=top>
				 <table border="0" cellspacing="0" class="playerInfoGridPlayerInfoBorders" >
				 	<tr><td width=125>&nbsp;</td>
							<? 
								for ($i = 0; $i < $rowCount; $i++) {
									echo "<td width=125 align=middle valign=top>";
									echo "<div class=\"playerInfoHeadingPlayerInfoBorders\"><b>$playerName[$i]</b></div>";
									echo "<div class=\"playerInfoStatsPlayerInfoBorders\">$teamName[$i]</div>";
									echo "</td>";
								}
							?>
					</tr>
					<tr><td>&nbsp;</td>

							<? 
								for ($i = 0; $i < $rowCount; $i++) {

				 					echo "<td align=middle valign=top height=110>";
				 					
				 					createPlayerImageURL($playerID[$i]);
									echo "</td>";
								}
							?>

					</tr>
					<tr><td></td></tr>
					<tr>
					<td colspan=<? echo $rowCount + 1; ?> valign="top" align="center" class="gSGSectionTitleStatsPlayerGrid"><b>Player Ratings</td></tr>

					<? 
						$i = 0;
						$j = 0;
						$ratingsCount = count($ratingsTypes[0]);
						//"gSGRowOdd";
						//"gSGRowEven";
						$rowclass = "gSGRowEven";
						for ($j = 0; $j < $ratingsCount; $j++) {
							$ratingsDesc = $ratingsTypes[1][$j];
							echo "<tr align=center><td align=left class=$rowclass><b>$ratingsDesc </b></td>";
							
							for ($i = 0; $i < $rowCount; $i++) {
								$ratingsStat = $playerCompare[$ratingsTypes[0][$j]][$i];
								echo "<td class=$rowclass>$ratingsStat</td>";
							}
							echo "</tr>";
							$rowclass == "gSGRowEven" ? $rowclass = "gSGRowOdd" :	$rowclass = "gSGRowEven";	

						}
					?>

					<tr align="center"><td>&nbsp;</td>
					<? 
						for ($i = 0; $i < $rowCount; $i++) {
							$removePlayerID = $playerID[$i];
							echo "<td class=gSGRowOdd><b><a href=removefromcompare.php?playerID=$removePlayerID>Remove</a></b></td>\n";
						}
					?>
					</tr>

				</table>

</td>
		</tr>
	</table>
</body>
</html>















