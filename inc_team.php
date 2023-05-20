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

/***************************************************************************/

/***************************************************************************/
function createTeamImageURL($teamID) {
	echo "<img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\">\n";
}


/***************************************************************************/

/***************************************************************************/
function createTeamName($teamInfo) {
	if ($teamInfo["TEAMNUM"] < 29) {
		return $teamInfo["CITYNAME"] . "&nbsp;" . $teamInfo["TEAMNAME"];
	} else {
		return $teamInfo["CITYNAME"];
	}
}

/***************************************************************************/

/***************************************************************************/
function createPlayerCompareLink($playerID) {
	echo "<a class=liveScoresLink href=addtocompare.php?playerID=$playerID><small>+</small></a>";
}

/***************************************************************************/

/***************************************************************************/
function createTeamLineup($teamInfo, $teamID, $sortOrder) {
/*
	echo "
	<table border=0 cellpadding=0 cellspacing=0 >
	<tr><td class=gSGSectionTitle colspan=8><div class=gSGSectionTitle>&nbsp; Roster</div></td></tr>
	<tr class=gSGSectionColumnHeadings>
	<td NOWRAP align=left width=35 class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=NUMBER>NUM</a></b></td>
	<td NOWRAP align=left width=150 class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=ROSTERPOS>PLAYER</a></b></td>
	<td NOWRAP align=left width=40 class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=POSITION>POS</a></b></td>
	<td NOWRAP align=left width=40 class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=HEIGHT>HT</a></b></td>
	<td NOWRAP align=left width=40 class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=WEIGHT>WT</a></b></td>
	<td NOWRAP align=left width=130 class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=DRAFTYEAR>DRAFT INFO</a></b></td>
	<td NOWRAP align=left width=40 class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=OVERALLRTG>RTG</a></b></td>
	<td NOWRAP align=left width=30 class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=YEARSEXP>YRS</a></b></td>
	</tr>
	";
*/
	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 >";
	echo "<tr><td class=gSGSectionTitle colspan=10><div class=gSGSectionTitle>&nbsp; Roster</div></td></tr>";
	echo "<tr class=gSGSectionColumnHeadings>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=NUMBER>NUM</a></b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=ROSTERPOS>PLAYER</a></b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=POSITION>POS</a></b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=HEIGHT>HT</a></b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=WEIGHT>WT</a></b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=DRAFTYEAR>DRAFT INFO</a></b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=OVERALLRTG>RTG</a></b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=YEARSEXP>YRS</a></b></td>";
	if ($teamID < 29) {
		echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=YRSREMAIN>CON</a></b></td>";
		echo "<td NOWRAP align=right class=gSGSectionColumnHeadings><b><a href=viewteam.php?teamID=$teamID&sortOrder=SALARY>SAL</a></b></td>";
	}		
	echo "</tr>";	
	
	$totalSalary = 0;
	$totalRatings = 0;
	$totalPlayers = count($teamInfo);
	foreach ($teamInfo as $value) {

		if ($sortOrder == "ROSTERPOS") {
			if ($value["ROSTERPOS"] == 5 and $value["TEAMNUM"] < 29) {	echo "<tr><td class=gSGSectionColumnHeadings colspan=10>&nbsp;BENCH</td></tr>";}
			if ($value["ROSTERPOS"] == 12 and $value["TEAMNUM"] < 29) { echo "<tr><td class=gSGSectionColumnHeadings colspan=10>&nbsp;IR</td></tr>";}
		}
		echo "<tr><td class=gSGRowEvenStatsGrid align=left>&nbsp;" . $value["NUMBER"] . "</td>";

		$playerName = trim($value["FNAME"] . " " . $value["NAME"]); 
		$playerID = $value["PLAYERID"];

		echo "<td class=gSGRowEvenStatsGrid align=left><a href=viewplayer.php?playerID=$playerID>" . $playerName . "</a> "; 
		createPlayerCompareLink($playerID); 
		echo "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . $value["POSITION_NAME_SHORT"] . "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . intval($value["HEIGHT"] / 12) . "-" . $value["HEIGHT"] % 12  . "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . $value["WEIGHT"] . "</td>";

		if ($value["DOVERALL"] > 0) {
			$DRAFTINFO = "Pick " . $value["DOVERALL"] . " by " . $value["DRAFTEDBY"];
		} else {
			$DRAFTINFO = "Never drafted";
		}
		echo "<td class=gSGRowEvenStatsGrid align=left>$DRAFTINFO</td>";

		$value["YEARSEXP"] == 0 ? $YEARSEXP = "R" : $YEARSEXP = $value["YEARSEXP"];

		echo "<td class=gSGRowEvenStatsGrid align=left> " . $value["OVERALLRTG"] . "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . $YEARSEXP ."</td>";

		if ($teamID < 29) {
			echo "<td class=gSGRowEvenStatsGrid align=left> " . $value["YRSREMAIN"]. "/" . $value["YRSSIGNED"] . "</td>";
			echo "<td class=gSGRowEvenStatsGrid align=right> " . trim(number_format($value["SALARY"])) ."</td></tr>";
			$totalSalary += $value["SALARY"];
			$totalRatings += $value["OVERALLRTG"];
		}
	}

		if ($teamID < 29) {
			echo "<tr class=gSGSectionColumnHeadings>";
			echo "<td NOWRAP align=right class=gSGSectionColumnHeadings colspan=10>" . number_format($totalSalary) . "</td>";
			echo "</tr>";	
		}		
	echo "</table>";

}

/***************************************************************************/

/***************************************************************************/
function createTeamSchedule($teamSchedule, $teamID) {

	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 class=gScGTable>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=16><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Schedule</DIV></TD>";
	echo "	</TR>";
	echo "<tr>";
	echo "<td width=75.0 class=gSGSectionColumnHeadingsStatsGrid><b>&nbsp;Date</b></td>";
	echo "<td width=225.0 class=gSGSectionColumnHeadingsStatsGrid><b>Opponent</b></td>";
	echo "<td width=75.0 class=gSGSectionColumnHeadingsStatsGrid><b>Box Score</b></td>";
	echo "</tr>";

	$rowclass = "gSGRowEvenStatsGrid";
	$i = 1;

	foreach ($teamSchedule as $value) {

		$c_playedDate = $value["GAME_DATE"];

		if ($c_playedDate != $p_playedDate) {
		
			$formattedc_playedDate = date('l j M Y',strtotime($c_playedDate));
			
			echo "<tr>";
//			echo "<td class=gSGSectionColumnHeadingsStatsGrid colspan=3><b>&nbsp;Games To Be Played By 00:00 $formattedc_playedDate</b></td>";
			echo "<td class=gSGSectionColumnHeadingsStatsGrid colspan=3><b>&nbsp;Round $i </b></td>";
			echo "</tr>";
			
			$p_playedDate = $c_playedDate;
			$i++;
		}

		$p_rowclass = $rowclass;



	
		$scheduleID = $value["SCHEDULE_ID"];
		echo "<tr>";


		trim($value["PLAYED_DATE"]) == "" ? $gameDate = $value["GAME_DATE"] : $gameDate = $value["PLAYED_DATE"];

		echo "<td valign=top class=$rowclass>&nbsp;&nbsp;$gameDate</td>";

		
//		echo "<td valign=top class=$rowclass>&nbsp;&nbsp;" . $value["GAME_DATE"] . "</td>";

		$winLoss = "L";
		
		if ($value["HOME_TEAMNUM"] == $teamID & $value["HOME_SCORE"] > $value["AWAY_SCORE"]) {
			$winLoss = "W";
		}
		
		if ($value["AWAY_TEAMNUM"] == $teamID & $value["AWAY_SCORE"] > $value["HOME_SCORE"]) {
			$winLoss = "W";
		}
		
		if ($value["AWAY_SCORE"] == $value["HOME_SCORE"]) {
			$winLoss = "L";
		}
		

		$teamID == $value["HOME_TEAMNUM"] ? $teamPlayed = "Vs <a href=viewteam.php?teamID=" . $value["AWAY_TEAMNUM"] .">" . $value["AWAY_TEAMNAME"] . "</a>" : $teamPlayed = "@ <a href=viewteam.php?teamID=" . $value["HOME_TEAMNUM"] .">" . $value["HOME_TEAMNAME"] . "</a>" ;

		echo "<td valign=top class=$rowclass>" . $teamPlayed . "</td>";

		switch ($value["PLAYED"]) {
		   case 0:
			   $boxscore = "&nbsp;";
			   break;
		   case 1:
				if ($value["FORFEIT"] != "") {
					$boxscore = "FA";
					switch ($value["FORFEIT"]) {
						case $value["HOME_TEAMNUM"] :
							$boxscore = "<B>FH</B>";
							break;
						case $value["AWAY_TEAMNUM"] :
							$boxscore = "<B>FA</B>";
							break;
					}
					
					$boxscore = "$boxscore $winLoss&nbsp";
				} else if ($value["AWAY_SCORE"] == $value["HOME_SCORE"]) {
					$boxscore = "<B>FB</B> $winLoss&nbsp;";
				} else {
					$boxscore = $value["AWAY_SCORE"] . "-" . $value["HOME_SCORE"];
					$boxscore = "<a href=viewboxscore.php?scheduleID=". $value["SCHEDULE_ID"] .">$boxscore $winLoss&nbsp;</a>";
				}
		   
		   
//			   $teamID == $value["HOME_TEAMNUM"] ? $boxscore = $value["HOME_SCORE"] . "-" . $value["AWAY_SCORE"] : $boxscore = $value["AWAY_SCORE"] . "-" . $value["HOME_SCORE"];;
//			   $boxScoreLink = "<a href=viewboxscore.php?scheduleID=$scheduleID>$boxscore $winLoss&nbsp;</a>";
//			   $boxscore = $boxScoreLink;
			   break;
		   case 2:
			   $boxscore = "Awaiting " . $value["HOME_TEAMNAME"];
			   break;
		   case 3:
			   $boxscore = "Awaiting " . $value["AWAY_TEAMNAME"];
			   break;
		}

		echo "<td valign=top class=$rowclass>" . $boxscore . "</td>";
		echo "</tr>";
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";	
	}

	echo "</table>";
}


/***************************************************************************/

/***************************************************************************/
function createPlayerStatsTotals($PlayerStats) {
	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 class=gScGTable>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=16><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Season Player Totals</DIV></TD>";
	echo "	</TR>";
	echo "<tr>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=7><b></b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=3 align=middle><b>REBOUNDS</b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=6><b></b></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td width=150 class=gSGSectionColumnHeadingsStatsGrid align=left><b>&nbsp;&nbsp;PLAYER</b></td>";
//	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>POS</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>G</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>GS</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>MIN</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FGM-A</b></td>";
//	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FG%</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>3GM-A</b></td>";
//	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>3P%</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FTM-A</b></td>";
//	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FT%</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>OFF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>DEF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TOT</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>BLK</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>AST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>ST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TO</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PTS</b></td>";
	echo "</tr>";

	$rowclass = "gSGRowEvenStatsGrid";

	foreach ($PlayerStats as $value) {
		echo "<tr>";
		$playerName = trim($value["FNAME"] . " " . $value["NAME"]); 
		
		$FGA = $value["FGA"];
		$FGM = $value["FGM"];
		if ($FGA > 0) {	$FGP = sprintf("%01.3f", $FGM/$FGA) ;} else {	$FGP = sprintf("%01.3f", 0) ;}

		$TPA = $value["3PA"];
		$TPM = $value["3PM"];
		if ($TPA > 0) {	$TPP = sprintf("%01.3f", $TPM/$TPA) ;} else {	$TPP = sprintf("%01.3f", 0) ;}

		$FTA = $value["FTA"];
		$FTM = $value["FTM"];
		if ($FTA > 0) {	$FTP = sprintf("%01.3f", $FTM/$FTA); } else { $FTP = sprintf("%01.3f", 0);}		
		
		echo "<td class=$rowclass align=left>&nbsp;&nbsp;<a href=viewplayer.php?playerID=" . $value["PLAYERID"] . ">$playerName</a></td>";
//		echo "<td class=$rowclass align=middle> " . $value["POSITION_NAME_SHORT"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["GAME_COUNT"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["STARTED_COUNT"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["MINS"] . "</td>";
		echo "<td class=$rowclass align=middle>$FGM-$FGA</td>";
//		echo "<td class=$rowclass align=middle>$FGP</td>";
		echo "<td class=$rowclass align=middle>$TPM-$TPA</td>";
//		echo "<td class=$rowclass align=middle>$TPP</td>";
		echo "<td class=$rowclass align=middle>$FTM-$FTA</td>";
//		echo "<td class=$rowclass align=middle>$FTP</td>";
		echo "<td class=$rowclass align=middle>" . $value["OREB"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["DREB"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["REB"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["BLOCKS"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["ASSISTS"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["FOULS"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["STEALS"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["TURNOVERS"] . "</td>";
		echo "<td class=$rowclass align=middle>" . $value["POINTS"] . "</td>";

		echo "</tr>";
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
	}
	echo "</table>";
}

/***************************************************************************/

/***************************************************************************/
function createPlayerStatsAverages($PlayerStats) {
	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 class=gScGTable>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=16><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Season Player Averages</DIV></TD>";
	echo "	</TR>";
	echo "<tr>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=7><b></b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=3 align=middle><b>REBOUNDS</b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=6><b></b></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td width=150 class=gSGSectionColumnHeadingsStatsGrid align=left><b>&nbsp;&nbsp;PLAYER</b></td>";
//	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>POS</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>G</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>GS</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>MIN</b></td>";
//	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FGM-A</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FG%</b></td>";
//	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>3PM-A</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>3P%</b></td>";
//	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FTM-A</b></td>";
	echo "<td width=51 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FT%</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>OFF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>DEF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TOT</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>BLK</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>AST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>ST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TO</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PTS</b></td>";
	echo "</tr>";
	$rowclass = "gSGRowEvenStatsGrid";

	foreach ($PlayerStats as $value) {

		$FTP = 0;
		$TPP = 0;
		$FGP = 0;
		$playerName = trim($value["FNAME"] . " " . $value["NAME"]); 
		$playerID = $value["PLAYERID"];
		$positionName = $value["POSITION_NAME_SHORT"];
		$gameCount = $value["GAME_COUNT"];


		$SEASON_DESC = $value["SEASON_DESC"];
		$TEAM_ABBREV = $value["ABBREV"];
		$G = $value["GAME_COUNT"];
		$GS = $value["STARTED_COUNT"]; 

		$FGA = $value["FGA"];
		$FGM = $value["FGM"];
		if ($FGA > 0) {	$FGP = sprintf("%01.3f", $FGM/$FGA) ;} else {	$FGP = sprintf("%01.3f", 0) ;}

		$TPA = $value["3PA"];
		$TPM = $value["3PM"];
		if ($TPA > 0) {	$TPP = sprintf("%01.3f", $TPM/$TPA) ;} else {	$TPP = sprintf("%01.3f", 0) ;}

		$FTA = $value["FTA"];
		$FTM = $value["FTM"];
		if ($FTA > 0) {	$FTP = sprintf("%01.3f", $FTM/$FTA); } else { $FTP = sprintf("%01.3f", 0);}

		if ($G > 0) {
			$MINS = sprintf("%01.1f", $value["MINS"]  / $G );
			$ORB = sprintf("%01.1f", $value["OREB"]  / $G );
			$DRB = sprintf("%01.1f", $value["DREB"]  / $G );
			$REB = sprintf("%01.1f", $value["REB"]  / $G );
			$AST = sprintf("%01.1f", $value["ASSISTS"]  / $G );
			$STL = sprintf("%01.1f", $value["STEALS"]  / $G );
			$BLK = sprintf("%01.1f", $value["BLOCKS"]  / $G );
			$TO  = sprintf("%01.1f", $value["TURNOVERS"]  / $G );
			$PF  = sprintf("%01.1f", $value["FOULS"]  / $G );
			$PTS = sprintf("%01.1f", $value["POINTS"]  / $G );
		} else {
			$MINS = sprintf("%01.1f", $value["MINS"]);
			$ORB = sprintf("%01.1f", $value["OREB"]);
			$DRB = sprintf("%01.1f", $value["DREB"]);
			$REB = sprintf("%01.1f", $value["REB"]);
			$AST = sprintf("%01.1f", $value["ASSISTS"]);
			$STL = sprintf("%01.1f", $value["STEALS"]);
			$BLK = sprintf("%01.1f", $value["BLOCKS"]);
			$TO  = sprintf("%01.1f", $value["TURNOVERS"]);
			$PF  = sprintf("%01.1f", $value["FOULS"]);
			$PTS = sprintf("%01.1f", $value["POINTS"]);
		}

		echo "	<TR>";
		echo "	  <TD class=$rowclass>&nbsp;&nbsp;<a href=viewplayer.php?playerID=$playerID>$playerName</a></TD>";
//		echo "	  <TD class=$rowclass align=middle>$positionName</TD>";
		echo "	  <TD class=$rowclass align=middle>$G</TD>";
		echo "	  <TD class=$rowclass align=middle>$GS</TD>";
		echo "	  <TD class=$rowclass align=middle>$MINS</TD>";
//		echo "	  <TD class=$rowclass align=middle>$FGM-$FGA</TD>";
		echo "	  <TD class=$rowclass align=middle>$FGP</TD>";
//		echo "	  <TD class=$rowclass align=middle>$TPM-$TPA</TD>";
		echo "	  <TD class=$rowclass align=middle>$TPP</TD>";
//		echo "	  <TD class=$rowclass align=middle>$FTM-$FTA</TD>";
		echo "	  <TD class=$rowclass align=middle>$FTP</TD>";
		echo "	  <TD class=$rowclass align=middle>$ORB</TD>";
		echo "	  <TD class=$rowclass align=middle>$DRB</TD>";
		echo "	  <TD class=$rowclass align=middle>$REB</TD>";
		echo "	  <TD class=$rowclass align=middle>$BLK</TD>";
		echo "	  <TD class=$rowclass align=middle>$AST</TD>";
		echo "	  <TD class=$rowclass align=middle>$PF</TD>";
		echo "	  <TD class=$rowclass align=middle>$STL</TD>";
		echo "	  <TD class=$rowclass align=middle>$TO</TD>";
		echo "	  <TD class=$rowclass align=middle>$PTS</TD>";
		echo "	</TR>";
	
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
	}
	echo "</table>";
}

/***************************************************************************/

/***************************************************************************/
function createTeamStatsTotals ($PlayerStats) {
	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 class=gScGTable>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=18><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Season Team Totals</DIV></TD>";
	echo "	</TR>";
	echo "<tr>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=5><b></b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=3 align=middle><b>REBOUNDS</b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=7><b></b></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td width=150 class=gSGSectionColumnHeadingsStatsGrid align=left><b>&nbsp;&nbsp;SEASON</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>G</b></td>";
	echo "<td width=61 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FGM-A</b></td>";
	echo "<td width=61 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>3GM-A</b></td>";
	echo "<td width=61 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FTM-A</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>OFF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>DEF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TOT</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>BLK</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>AST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>ST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TO</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>BNCH</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PTS</b></td>";
	echo "</tr>";

	$rowclass = "gSGRowEvenStatsGrid";

	foreach ($PlayerStats as $value) {
		echo "<tr>";

		$b1 = "";
		$b2 = "";
		
		$SEASON = $value["SEASON"];
		if ($value["GAME_TYPE"] == 1) {
			$SEASON .= " Playoffs";
		} else {
			if ($value["ROW_ORDER"] == 2) {
				$b1 = "<B>";
				$b2 = "</B>";
			}
		}


		$FGA = $value["FGA"];
		$FGM = $value["FGM"];
		if ($FGA > 0) {	$FGP = sprintf("%01.3f", $FGM/$FGA) ;} else {	$FGP = sprintf("%01.3f", 0) ;}

		$TPA = $value["3PA"];
		$TPM = $value["3PM"];
		if ($TPA > 0) {	$TPP = sprintf("%01.3f", $TPM/$TPA) ;} else {	$TPP = sprintf("%01.3f", 0) ;}

		$FTA = $value["FTA"];
		$FTM = $value["FTM"];
		if ($FTA > 0) {	$FTP = sprintf("%01.3f", $FTM/$FTA); } else { $FTP = sprintf("%01.3f", 0);}		
		
		echo "<td class=$rowclass align=left>$b1&nbsp;&nbsp;$SEASON$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["GAME_COUNT"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1$FGM-$FGA$b2</td>";
		echo "<td class=$rowclass align=middle>$b1$TPM-$TPA$b2</td>";
		echo "<td class=$rowclass align=middle>$b1$FTM-$FTA$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["OREB"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["DREB"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["REB"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["BLOCKS"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["ASSISTS"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["FOULS"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["STEALS"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["TURNOVERS"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["BENCH_SCORING"] . "$b2</td>";
		echo "<td class=$rowclass align=middle>$b1" . $value["POINTS"] . "$b2</td>";

		echo "</tr>";
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
	}
	echo "</table>";
}


/***************************************************************************/

/***************************************************************************/
function createTeamStatsAverages($PlayerStats) {
	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 class=gScGTable>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=15><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Season Team Averages</DIV></TD>";
	echo "	</TR>";
	echo "<tr>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=5><b></b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=3 align=middle><b>REBOUNDS</b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colSpan=7><b></b></td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td width=150 class=gSGSectionColumnHeadingsStatsGrid align=left><b>&nbsp;&nbsp;SEASON</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>G</b></td>";
	echo "<td width=61 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FG%</b></td>";
	echo "<td width=61 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>3G%</b></td>";
	echo "<td width=61 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>FT%</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>OFF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>DEF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TOT</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>BLK</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>AST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PF</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>ST</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>TO</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>BNCH</b></td>";
	echo "<td width=31 class=gSGSectionColumnHeadingsStatsGrid align=middle><b>PTS</b></td>";
	echo "</tr>";
	$rowclass = "gSGRowEvenStatsGrid";

	foreach ($PlayerStats as $value) {

		$FTP = 0;
		$TPP = 0;
		$FGP = 0;
		$playerName = trim($value["FNAME"] . " " . $value["NAME"]); 
		$playerID = $value["PLAYERID"];
		$positionName = $value["POSITION_NAME_SHORT"];
		$gameCount = $value["GAME_COUNT"];


		$SEASON = $value["SEASON"];

		$b1 = "";
		$b2 = "";
		
		$SEASON = $value["SEASON"];
		if ($value["GAME_TYPE"] == 1) {
			$SEASON .= " Playoffs";
		} else {
			if ($value["ROW_ORDER"] == 2) {
				$b1 = "<B>";
				$b2 = "</B>";
			}
		}

		
		$G    = $value["GAME_COUNT"];

		$FGA = $value["FGA"];
		$FGM = $value["FGM"];
		if ($FGA > 0) {	$FGP = sprintf("%01.3f", $FGM/$FGA) ;} else {	$FGP = sprintf("%01.3f", 0) ;}

		$TPA = $value["3PA"];
		$TPM = $value["3PM"];
		if ($TPA > 0) {	$TPP = sprintf("%01.3f", $TPM/$TPA) ;} else {	$TPP = sprintf("%01.3f", 0) ;}

		$FTA = $value["FTA"];
		$FTM = $value["FTM"];
		if ($FTA > 0) {	$FTP = sprintf("%01.3f", $FTM/$FTA); } else { $FTP = sprintf("%01.3f", 0);}

		if ($G > 0) {
			$MINS = sprintf("%01.1f", $value["MINS"]  / $G );
			$ORB = sprintf("%01.1f", $value["OREB"]  / $G );
			$DRB = sprintf("%01.1f", $value["DREB"]  / $G );
			$REB = sprintf("%01.1f", $value["REB"]  / $G );
			$AST = sprintf("%01.1f", $value["ASSISTS"]  / $G );
			$STL = sprintf("%01.1f", $value["STEALS"]  / $G );
			$BLK = sprintf("%01.1f", $value["BLOCKS"]  / $G );
			$TO  = sprintf("%01.1f", $value["TURNOVERS"]  / $G );
			$PF  = sprintf("%01.1f", $value["FOULS"]  / $G );
			$BNCHPTS = sprintf("%01.1f", $value["BENCH_SCORING"]  / $G );
			$PTS = sprintf("%01.1f", $value["POINTS"]  / $G );
		} else {
			$MINS = sprintf("%01.1f", $value["MINS"]);
			$ORB = sprintf("%01.1f", $value["OREB"]);
			$DRB = sprintf("%01.1f", $value["DREB"]);
			$REB = sprintf("%01.1f", $value["REB"]);
			$AST = sprintf("%01.1f", $value["ASSISTS"]);
			$STL = sprintf("%01.1f", $value["STEALS"]);
			$BLK = sprintf("%01.1f", $value["BLOCKS"]);
			$TO  = sprintf("%01.1f", $value["TURNOVERS"]);
			$PF  = sprintf("%01.1f", $value["FOULS"]);
			$BNCHPTS = sprintf("%01.1f", $value["BENCH_SCORING"]);
			$PTS= sprintf("%01.1f", $value["POINTS"]);
		}

		echo "	<TR>";
		echo "	  <TD class=$rowclass>$b1&nbsp;&nbsp;$SEASON$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$G$b2</TD>";

		echo "	  <TD class=$rowclass align=middle>$b1$FGP$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$TPP$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$FTP$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$ORB$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$DRB$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$REB$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$BLK$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$AST$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$PF$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$STL$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$TO$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$BNCHPTS$b2</TD>";
		echo "	  <TD class=$rowclass align=middle>$b1$PTS$b2</TD>";
		echo "	</TR>";
	
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
	}
	echo "</table>";
}


function searchPlayers($teamInfo) {

	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 >";
	echo "<tr><td class=gSGSectionTitle colspan=11><div class=gSGSectionTitle>&nbsp; Roster</div></td></tr>";
	echo "<tr class=gSGSectionColumnHeadings>";
	echo "<td NOWRAP align=left width=35 class=gSGSectionColumnHeadings><b>NUM</b></td>";
	echo "<td NOWRAP align=left width=150 class=gSGSectionColumnHeadings><b>PLAYER</b></td>";
	echo "<td NOWRAP align=left width=35 class=gSGSectionColumnHeadings><b>POS</b></td>";
	echo "<td NOWRAP align=left width=35 class=gSGSectionColumnHeadings><b>HT</b></td>";
	echo "<td NOWRAP align=left width=35 class=gSGSectionColumnHeadings><b>WT</b></td>";
	echo "<td NOWRAP align=left width=90 class=gSGSectionColumnHeadings><b>DRAFT INFO</b></td>";
	echo "<td NOWRAP align=left width=30 class=gSGSectionColumnHeadings><b>RTG</b></td>";
	echo "<td NOWRAP align=left width=30 class=gSGSectionColumnHeadings><b>YRS</b></td>";
	echo "<td NOWRAP align=left width=30 class=gSGSectionColumnHeadings><b>CON</b></td>";
	echo "<td NOWRAP align=left width=30 class=gSGSectionColumnHeadings><b>TEAM</b></td>";
	echo "<td NOWRAP align=right width=100 class=gSGSectionColumnHeadings><b>SAL</b></td>";
	echo "</tr>";	
	
	$totalSalary = 0;
	$totalRatings = 0;
	$totalPlayers = count($teamInfo);
	foreach ($teamInfo as $value) {

		if ($sortOrder == "ROSTERPOS") {
			if ($value["ROSTERPOS"] == 5 and $value["TEAMNUM"] < 29) {	echo "<tr><td class=gSGSectionColumnHeadings colspan=10>&nbsp;BENCH</td></tr>";}
			if ($value["ROSTERPOS"] == 12 and $value["TEAMNUM"] < 29) { echo "<tr><td class=gSGSectionColumnHeadings colspan=10>&nbsp;IR</td></tr>";}
		}
		echo "<tr><td class=gSGRowEvenStatsGrid align=left>&nbsp;" . $value["NUMBER"] . "</td>";

		$playerName = trim($value["FNAME"] . " " . $value["NAME"]); 
		$playerID = $value["PLAYERID"];

		echo "<td class=gSGRowEvenStatsGrid align=left><a href=viewplayer.php?playerID=$playerID>" . $playerName . "</a> "; 
		createPlayerCompareLink($playerID); 
		echo "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . $value["POSITION_NAME_SHORT"] . "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . intval($value["HEIGHT"] / 12) . "-" . $value["HEIGHT"] % 12  . "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . $value["WEIGHT"] . "</td>";

		if ($value["DOVERALL"] > 0) {
			$DRAFTINFO = "Pick " . $value["DOVERALL"] . " by " . $value["DRAFTEDBY"];
		} else {
			$DRAFTINFO = "Never drafted";
		}
		echo "<td class=gSGRowEvenStatsGrid align=left>$DRAFTINFO</td>";

		$value["YEARSEXP"] == 0 ? $YEARSEXP = "R" : $YEARSEXP = $value["YEARSEXP"];

		echo "<td class=gSGRowEvenStatsGrid align=left> " . $value["OVERALLRTG"] . "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . $YEARSEXP ."</td>";
		echo "<td class=gSGRowEvenStatsGrid align=left> " . $value["YRSREMAIN"]. "/" . $value["YRSSIGNED"] . "</td>";
		echo "<td class=gSGRowEvenStatsGrid align=right> " . $value["ABBREV"] ."</td>";
		echo "<td class=gSGRowEvenStatsGrid align=right> " . trim(number_format($value["SALARY"])) ."</td></tr>";

	}

	echo "</table>";

}

?>

