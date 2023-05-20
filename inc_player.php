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


function createTeamImageURL($teamID) {
//	echo "<a href=viewteam.php?teamID=$teamID><img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\"></a>\n";
	if ($teamID < 29) {
		echo "<a href=viewteam.php?teamID=$teamID><img border=0 src=\"images/teams/" . trim($teamID) . "_logo.gif\"></a>\n";
	}
}

function createPlayerCurrentSeasonStatsBreakdown($playerStats) {

//print_r($playerStats) ;

	
	$SEASON = $playerStats["SEASON"];
	$PTS = $playerStats["POINTS"];
	$REB = $playerStats["REBOUNDS"];
	$AST = $playerStats["ASSISTS"];
	$STL = $playerStats["STEALS"];
	$BLK = $playerStats["BLOCKS"];
	$FGA = $playerStats["FGA"];
	$FGM = $playerStats["FGM"];
	$FTA = $playerStats["FTA"];
	$FTM = $playerStats["FTM"];
	$TO  = $playerStats["TURNOVERS"];
	$G   = $playerStats["GAME_COUNT"];

	$PPG = 0;
	$APG = 0;
	$SPG = 0;
	$BPG = 0;
	$RPG = 0;
	$EFF = 0;

	if ($G > 0) {

		$PPG = sprintf("%2.2f", $PTS / $G);
		$APG = sprintf("%2.2f", $AST / $G);
		$SPG = sprintf("%2.2f", $STL / $G);
		$BPG = sprintf("%2.2f", $BLK / $G);
		$RPG = sprintf("%2.2f", $REB / $G);
		$EFF = (($PTS + $REB + $AST + $STL + $BLK) - (($FGA - $FGM) + ($FTA - $FTM) + $TO)) / $G;
		$EFF = sprintf("%1.2f", $EFF);
		if ($EFF >= 0) {
			$EFF  = "+" . $EFF;
		}
	}
	
echo "
	<TABLE height=90 cellSpacing=1 cellPadding=0 width=\"100\" bgColor=#ffffff border=0>
	<TBODY>
	<TR>
	<TD class=gSGSectionTitleStatsGrid vAlign=center align=middle colSpan=2><B>$SEASON<BR>Statistics</B></TD>
	</TR>
	<TR>
	<TD class=gSGSectionTitleStatsGrid><B>&nbsp;PPG</B></TD>
	<TD class=gSGSectionTitleStatsGrid align=center>$PPG</TD>
	</TR>
	<TR>
	<TD class=gSGSectionTitleStatsGrid><B>&nbsp;RPG</B></TD>
	<TD class=gSGSectionTitleStatsGrid align=center>$RPG</TD>
	</TR>
	<TR>
	<TD class=gSGSectionTitleStatsGrid><B>&nbsp;APG</B></TD>
	<TD class=gSGSectionTitleStatsGrid align=center>$APG</TD>
	</TR>
	<TR>
	<TD class=gSGSectionTitleStatsGrid><B>&nbsp;BPG</B></TD>
	<TD class=gSGSectionTitleStatsGrid align=center>$BPG</TD>
	</TR>
	<TR>
	<TD class=gSGSectionTitleStatsGrid><B>&nbsp;EFF</B></TD>
	<TD class=gSGSectionTitleStatsGrid align=center>$EFF</TD>
	</TR>
	</TBODY>
	</TABLE>\n";

}

function createPlayerImageURL($playerID) {
	$playerIDFormatted = sprintf("%04d", $playerID);
	$playerImageName = "player_" . $playerIDFormatted;

	echo "<img src=\"images/players/" . $playerImageName . ".jpg\" ></img>\n";
}

function nbacomPlayerImageURL($playerID) {
	$playerIDFormatted = sprintf("%04d", $playerID);
	$playerImageName = "player_" . $playerIDFormatted;

	echo "<img src=\"images/players/" . $playerImageName . ".jpg\" ></img>\n";
}


function DobToAge($DOB) {
       //explode $DOB to an array for easy processing.
       $DOBArray = explode("-", $DOB);

       // Get today's year, month and day
       $TodayDay = date('d');
       $TodayMonth = date('m');
       $TodayYear = date('Y');

       // The logic
       if (($TodayMonth > $DOBArray[1]) || (($TodayMonth == $DOBArray) && ($TodayDay >= $DOBArray[2])))
       {$Age = $TodayYear - $DOBArray[0];}
       else {$Age = $TodayYear - $DOBArray[0] - 1;}

       // return the age
       return $Age;
} 

function createPlayerInformation($playerInfo) {

	$POSITION = $playerInfo["POSITION_NAME_SHORT"];
//	$YEARSEXP = $playerInfo["YEARSEXP"];
	
	$playerInfo["YEARSEXP"] == 0 ? $YEARSEXP = "R": $YEARSEXP = $playerInfo["YEARSEXP"];
	
	$HEIGHT = intval($playerInfo["HEIGHT"] / 12) . "-" . $playerInfo["HEIGHT"] % 12;
	$WEIGHT = $playerInfo["WEIGHT"] ." lbs";
	$SALARY = "$" . trim(number_format($playerInfo["SALARY"]));
	$CONTRACT = $playerInfo["YRSREMAIN"] . " / " . $playerInfo["YRSSIGNED"];
	$DOB = $playerInfo["BIRTHDATE"];
	$AGE = DobToAge($DOB);

//	echo "<div id=PlayerInformation>";
//	echo "Position: " . $playerInfo["POSITION_NAME_SHORT"] . "<br>";
//	echo "Years Pro: " . $playerInfo["YEARSEXP"] . "<br>";
//	echo "Height: " . intval($playerInfo["HEIGHT"] / 12) . "-" . $playerInfo["HEIGHT"] % 12 . "<br>";
//	echo "Weight: " . $playerInfo["WEIGHT"] ." lbs <br>";
//	echo "</div>\n";
	echo "
	<DIV class=playerInfoStatsPlayerInfoBorders>Position:&nbsp;
	<SPAN class=playerInfoValuePlayerInfoBorders>$POSITION</SPAN></DIV>
	<DIV class=playerInfoStatsPlayerInfoBorders>Years Pro:
	<SPAN class=playerInfoValuePlayerInfoBorders>$YEARSEXP</SPAN></DIV>
	<DIV class=playerInfoStatsPlayerInfoBorders>Age:
	<SPAN class=playerInfoValuePlayerInfoBorders>$AGE</SPAN></DIV>
	<DIV class=playerInfoStatsPlayerInfoBorders>Height:
	<SPAN class=playerInfoValuePlayerInfoBorders>$HEIGHT</SPAN></DIV>
	<DIV class=playerInfoStatsPlayerInfoBorders>Weight:
	<SPAN class=playerInfoValuePlayerInfoBorders>$WEIGHT</SPAN></DIV>
	<DIV class=playerInfoStatsPlayerInfoBorders>Salary:
	<SPAN class=playerInfoValuePlayerInfoBorders>$SALARY</SPAN></DIV>	
	<DIV class=playerInfoStatsPlayerInfoBorders>Contract:
	<SPAN class=playerInfoValuePlayerInfoBorders>$CONTRACT</SPAN></DIV>";	
}

function createPlayerCompareLink($playerID) {

echo "<a href=addtocompare.php?playerID=$playerID>add to comparison</a>";

}

function createPlayerRatings($playerInfo) {
	$playerRatings = array();
	$playerRatings[] = array($playerInfo["OVERALLRTG"], "ORTG");
	$playerRatings[] = array($playerInfo["FGPBASE"], "FG");
	$playerRatings[] = array($playerInfo["THREEPTBAS"], "3PT");
	$playerRatings[] = array($playerInfo["FTPBASE"], "FT");
	$playerRatings[] = array($playerInfo["DNKABILITY"], "DNK");
	$playerRatings[] = array($playerInfo["STLABILITY"], "STL");
	$playerRatings[] = array($playerInfo["BLKABILITY"], "BLK");
	$playerRatings[] = array($playerInfo["OREABILITY"], "OREB");
	$playerRatings[] = array($playerInfo["DREABILITY"], "DREB");
	$playerRatings[] = array($playerInfo["BALABILITY"], "PAS");
	$playerRatings[] = array($playerInfo["OFFABILITY"], "OFF");
	$playerRatings[] = array($playerInfo["DEFABILITY"], "DEF");
	$playerRatings[] = array($playerInfo["SPEED"], "SPE");
	$playerRatings[] = array($playerInfo["QUICK"], "QUI");
	$playerRatings[] = array($playerInfo["JUMP"], "JUM");
	$playerRatings[] = array($playerInfo["DRIBBLE"], "DRI");
	$playerRatings[] = array($playerInfo["DSHOOTRANG"] . "'" , "RNG"); //'
	$playerRatings[] = array($playerInfo["INSIDESC"], "INS");

	echo "<TABLE class=gSGTableStatsGridOne cellSpacing=0 cellPadding=1 width=100% border=0>";
	echo "  <TBODY>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=18><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Player Ratings</DIV></TD>";
	echo "	</TR>";
	echo "	<TR class=gSGSectionColumnHeadingsStatsGridOne>";
	foreach ($playerRatings as $rating) {
		echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=center><B>$rating[1]</B></TD>";
	}
	echo "	</TR>";

	echo "	<TR>";
	foreach ($playerRatings as $rating) {
		echo "	  <TD class=gSGRowEvenStatsGridOne align=center>$rating[0]</TD>";
	}
	echo "	</TR>";
	echo "</TABLE>";
}


function createPlayerNameNumber($playerInfo) {
	echo $playerInfo["FNAME"] . "&nbsp;" . $playerInfo["NAME"] . "&nbsp;|&nbsp;" . $playerInfo["NUMBER"];
}


function createPlayerCurrentSeasonStats($playerID) {
	include('config.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "
SELECT	 	 'A' AS ROW_ORDER
		,SEASON_DESC
		,ABBREV
		,SE.SEASON_SDTE
		,MAX(SH.GAME_DATE) AS GAME_DATE
		,SUM(MINS) AS MINS
		,SUM(FGA) AS FGA
		,SUM(FGM) AS FGM
		,SUM(3PA) AS 3PA
		,SUM(3PM) AS 3PM
		,SUM(FTA) AS FTA
		,SUM(FTM) AS FTM
		,SUM(OREBOUNDS) AS OREB
		,SUM(DREBOUNDS) AS DREB
		,SUM(REBOUNDS) AS REB
		,SUM(BLOCKS) AS BLOCKS
		,SUM(STEALS) AS STEALS
		,SUM(ASSISTS) AS ASSISTS
		,SUM(TURNOVERS) AS TURNOVERS
		,SUM(FOULS) AS FOULS
		,SUM(POINTS) AS POINTS
		,SUM(PS.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PS.ROSTERPOS < 5 AND PS.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT


	FROM SEASON SE
	INNER JOIN PLAYERS PL
	ON PL.PLAYERID = $playerID
	AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

	LEFT JOIN PLAYERSTATS PS
	ON PS.PLAYERID = PL.PLAYERID
	AND PS.SCHEDULE_ID IN (
		SELECT SCHEDULE_ID 
		FROM SCHEDULE SH
		INNER JOIN SEASON SE
		ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
	)
	

	LEFT JOIN TEAMS TM
	ON PS.TEAM_NUMBER = TM.TEAMNUM

	LEFT  JOIN SCHEDULE SH
	ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
	AND SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
	AND SH.GAME_TYPE = 0

	GROUP BY 1,2,3,4


UNION

	SELECT	'B' AS ROW_ORDER
		,SEB.SEASON_DESC
		,'--' AS ABBREV
		,SEB.SEASON_SDTE
		,MAX(SHB.GAME_DATE) AS GAME_DATE
		,SUM(PSB.MINS) AS MINS
		,SUM(PSB.FGA) AS FGA
		,SUM(PSB.FGM) AS FGM
		,SUM(PSB.3PA) AS 3PA
		,SUM(PSB.3PM) AS 3PM
		,SUM(PSB.FTA) AS FTA
		,SUM(PSB.FTM) AS FTM
		,SUM(PSB.OREBOUNDS) AS OREB
		,SUM(PSB.DREBOUNDS) AS DREB
		,SUM(PSB.REBOUNDS) AS REB
		,SUM(PSB.BLOCKS) AS BLOCKS
		,SUM(PSB.STEALS) AS STEALS
		,SUM(PSB.ASSISTS) AS ASSISTS
		,SUM(PSB.TURNOVERS) AS TURNOVERS
		,SUM(PSB.FOULS) AS FOULS
		,SUM(PSB.POINTS) AS POINTS
		,SUM(PSB.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PSB.ROSTERPOS < 5 THEN 1 ELSE 0 END) AS START_COUNT


	FROM SEASON SEB
	INNER JOIN PLAYERS PLB
	ON PLB.PLAYERID = $playerID
	AND CURDATE() BETWEEN SEB.SEASON_SDTE AND SEB.SEASON_EDTE

	LEFT JOIN PLAYERSTATS PSB
	ON PSB.PLAYERID = PLB.PLAYERID
	AND PSB.SCHEDULE_ID IN (
		SELECT SCHEDULE_ID 
		FROM SCHEDULE SH
		INNER JOIN SEASON SE
		ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
	)

	LEFT JOIN TEAMS TMB
	ON PSB.TEAM_NUMBER = TMB.TEAMNUM

	LEFT  JOIN SCHEDULE SHB
	ON PSB.SCHEDULE_ID = SHB.SCHEDULE_ID
	AND SHB.GAME_DATE BETWEEN SEB.SEASON_SDTE AND SEB.SEASON_EDTE
	AND SHB.GAME_TYPE = 0

	GROUP BY 1,2,3,4
	
	ORDER BY SEASON_SDTE, ROW_ORDER, GAME_DATE, GAME_COUNT, ABBREV ASC
	";
//	echo $sql;

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$playerStats = $db->sql_fetchrowset($result);

	$SEASON_DESC = $playerStats[0]["SEASON_DESC"];
	
//echo "<pre>";
//print_r($playerStats);

	echo "<TABLE class=gSGTableStatsGridOne cellSpacing=0 cellPadding=1 width=100% border=0>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=19><DIV class=gSGSectionTitleStatsGridOne>&nbsp;$SEASON_DESC Statistics</DIV></TD>";
	echo "	</TR>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne colSpan=10>&nbsp;</TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle colSpan=3><B>REBOUNDS PER GAME</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne colSpan=6>&nbsp;</TD>";
	echo "	</TR>";
	echo "	<TR class=gSGSectionColumnHeadingsStatsGridOne>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap><B>&nbsp; TEAM</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap><B>G</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap><B>GS</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>MPG</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>FGM-A</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>FG%</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>3PM-A</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>3P%</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>FTM-A</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>FT%</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>OFF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>DEF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>TOT</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>APG</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>SPG</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>BPG</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>TO</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>PF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle><B>PPG</B></TD>";
	echo "	</TR>";

//	$playerStats = $db->sql_fetchrowset($result);

	if (count($playerStats) > 0) {

		foreach ($playerStats as $value) {

			$FTP = 0;
			$TPP = 0;
			$FGP = 0;


			$SEASON_DESC = $value["SEASON_DESC"];
			$TEAM_ABBREV = $value["ABBREV"];
			$G    = $value["GAME_COUNT"];
			$GS = $value["START_COUNT"];
			$MINS = sprintf("%01.2f", $value["MINS"]  / $G );

			$FGA = $value["FGA"];
			$FGM = $value["FGM"];
			if ($FGA > 0) {	$FGP = sprintf("%01.3f", $FGM/$FGA) ;} else {	$FGP = sprintf("%01.3f", 0) ;}

			$TPA = $value["3PA"];
			$TPM = $value["3PM"];
			if ($TPA > 0) {	$TPP = sprintf("%01.3f", $TPM/$TPA) ;} else {	$TPP = sprintf("%01.3f", 0) ;}

			$FTA = $value["FTA"];
			$FTM = $value["FTM"];
			if ($FTA > 0) {	$FTP = sprintf("%01.3f", $FTM/$FTA); } else { $FTP = sprintf("%01.3f", 0);}

			$ORB = sprintf("%01.2f", $value["OREB"]  / $G );
			$DRB = sprintf("%01.2f", $value["DREB"]  / $G );
			$REB = sprintf("%01.2f", $value["REB"]  / $G );
			$AST = sprintf("%01.2f", $value["ASSISTS"]  / $G );
			$STL = sprintf("%01.2f", $value["STEALS"]  / $G );
			$BLK = sprintf("%01.2f", $value["BLOCKS"]  / $G );
			$TO  = sprintf("%01.2f", $value["TURNOVERS"]  / $G );
			$PF  = sprintf("%01.2f", $value["FOULS"]  / $G );
			$PTS = sprintf("%01.2f", $value["POINTS"]  / $G );




			if (count($playerStats) == 2 & $TEAM_ABBREV == "--") {
				break;
			}
			echo "	<TR>";
			echo "	  <TD class=gSGRowEvenStatsGridOne>&nbsp; &nbsp; $TEAM_ABBREV</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$G</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$GS</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$MINS</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$FGM-$FGA</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$FGP</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$TPM-$TPA</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$TPP</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$FTM-$FTA</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$FTP</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$ORB</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$DRB</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$REB</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$AST</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$STL</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$BLK</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$TO</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$PF</TD>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle>$PTS</TD>";
			echo "	</TR>";
		}
	} else {
			echo "	<TR>";
			echo "	  <TD class=gSGRowEvenStatsGridOne align=middle colspan=19><b>No Stats Available</b></TD>";
			echo "	</TR>";	
	
	}
		echo "</TABLE>";


}

function createPlayerCareerAverageStats($playerID) {
	include('config.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "
SELECT	 '1' AS ROW_ORDER
		,SEASON_DESC
		,SEASON
		,ABBREV
		,SE.SEASON_SDTE
		,MAX(SH.GAME_DATE) AS GAME_DATE
		,SUM(MINS) AS MINS
		,SUM(FGA) AS FGA
		,SUM(FGM) AS FGM
		,SUM(3PA) AS 3PA
		,SUM(3PM) AS 3PM
		,SUM(FTA) AS FTA
		,SUM(FTM) AS FTM
		,SUM(OREBOUNDS) AS OREB
		,SUM(DREBOUNDS) AS DREB
		,SUM(REBOUNDS) AS REB
		,SUM(BLOCKS) AS BLOCKS
		,SUM(STEALS) AS STEALS
		,SUM(ASSISTS) AS ASSISTS
		,SUM(TURNOVERS) AS TURNOVERS
		,SUM(FOULS) AS FOULS
		,SUM(POINTS) AS POINTS
		,SUM(PS.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PS.ROSTERPOS < 5 AND PS.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT

	FROM PLAYERS PL
	INNER JOIN PLAYERSTATS PS
	ON PS.PLAYERID = PL.PLAYERID
	AND PL.PLAYERID = $playerID

	INNER JOIN TEAMS TM
	ON PS.TEAM_NUMBER = TM.TEAMNUM

	INNER JOIN SCHEDULE SH
	ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
	AND SH.GAME_TYPE = 0

	INNER JOIN SEASON SE
	ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

	GROUP BY 1,2,3,4,5

UNION

	SELECT	'2' AS ROW_ORDER
		,SEB.SEASON_DESC
		,SEB.SEASON
		,'--' AS ABBREV
		,SEB.SEASON_SDTE
		,MAX(SHB.GAME_DATE) AS GAME_DATE
		,SUM(PSB.MINS) AS MINS
		,SUM(PSB.FGA) AS FGA
		,SUM(PSB.FGM) AS FGM
		,SUM(PSB.3PA) AS 3PA
		,SUM(PSB.3PM) AS 3PM
		,SUM(PSB.FTA) AS FTA
		,SUM(PSB.FTM) AS FTM
		,SUM(PSB.OREBOUNDS) AS OREB
		,SUM(PSB.DREBOUNDS) AS DREB
		,SUM(PSB.REBOUNDS) AS REB
		,SUM(PSB.BLOCKS) AS BLOCKS
		,SUM(PSB.STEALS) AS STEALS
		,SUM(PSB.ASSISTS) AS ASSISTS
		,SUM(PSB.TURNOVERS) AS TURNOVERS
		,SUM(PSB.FOULS) AS FOULS
		,SUM(PSB.POINTS) AS POINTS
		,SUM(PSB.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PSB.ROSTERPOS < 5 AND PSB.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT

	FROM PLAYERS PLB
	LEFT JOIN PLAYERSTATS PSB
	ON PSB.PLAYERID = PLB.PLAYERID
	AND PLB.PLAYERID = $playerID

	INNER JOIN TEAMS TMB
	ON PSB.TEAM_NUMBER = TMB.TEAMNUM

	INNER JOIN SCHEDULE SHB
	ON PSB.SCHEDULE_ID = SHB.SCHEDULE_ID
	AND SHB.GAME_TYPE = 0

	INNER JOIN SEASON SEB 
	ON SHB.GAME_DATE BETWEEN SEB.SEASON_SDTE AND SEB.SEASON_EDTE

	GROUP BY 1,2,3,4,5
	
UNION

	SELECT	'3' AS ROW_ORDER
		,''
		,'Career'
		,'' AS ABBREV
		,'2090-12-31'
		,MAX(SHB.GAME_DATE) AS GAME_DATE
		,SUM(PSB.MINS) AS MINS
		,SUM(PSB.FGA) AS FGA
		,SUM(PSB.FGM) AS FGM
		,SUM(PSB.3PA) AS 3PA
		,SUM(PSB.3PM) AS 3PM
		,SUM(PSB.FTA) AS FTA
		,SUM(PSB.FTM) AS FTM
		,SUM(PSB.OREBOUNDS) AS OREB
		,SUM(PSB.DREBOUNDS) AS DREB
		,SUM(PSB.REBOUNDS) AS REB
		,SUM(PSB.BLOCKS) AS BLOCKS
		,SUM(PSB.STEALS) AS STEALS
		,SUM(PSB.ASSISTS) AS ASSISTS
		,SUM(PSB.TURNOVERS) AS TURNOVERS
		,SUM(PSB.FOULS) AS FOULS
		,SUM(PSB.POINTS) AS POINTS
		,SUM(PSB.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PSB.ROSTERPOS < 5 AND PSB.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT

	FROM PLAYERS PLB
	LEFT JOIN PLAYERSTATS PSB
	ON PSB.PLAYERID = PLB.PLAYERID
	AND PLB.PLAYERID = $playerID

	INNER JOIN TEAMS TMB
	ON PSB.TEAM_NUMBER = TMB.TEAMNUM

	INNER JOIN SCHEDULE SHB
	ON PSB.SCHEDULE_ID = SHB.SCHEDULE_ID
	AND SHB.GAME_TYPE = 0

	INNER JOIN SEASON SEB 
	ON SHB.GAME_DATE BETWEEN SEB.SEASON_SDTE AND SEB.SEASON_EDTE

	GROUP BY 1,2,3,4,5

UNION

	SELECT	'4' AS ROW_ORDER
		,''
		,'Playoffs'
		,'' AS ABBREV
		,'2090-12-31'
		,MAX(SHB.GAME_DATE) AS GAME_DATE
		,SUM(PSB.MINS) AS MINS
		,SUM(PSB.FGA) AS FGA
		,SUM(PSB.FGM) AS FGM
		,SUM(PSB.3PA) AS 3PA
		,SUM(PSB.3PM) AS 3PM
		,SUM(PSB.FTA) AS FTA
		,SUM(PSB.FTM) AS FTM
		,SUM(PSB.OREBOUNDS) AS OREB
		,SUM(PSB.DREBOUNDS) AS DREB
		,SUM(PSB.REBOUNDS) AS REB
		,SUM(PSB.BLOCKS) AS BLOCKS
		,SUM(PSB.STEALS) AS STEALS
		,SUM(PSB.ASSISTS) AS ASSISTS
		,SUM(PSB.TURNOVERS) AS TURNOVERS
		,SUM(PSB.FOULS) AS FOULS
		,SUM(PSB.POINTS) AS POINTS
		,SUM(PSB.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PSB.ROSTERPOS < 5 AND PSB.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT

	FROM PLAYERS PLB
	LEFT JOIN PLAYERSTATS PSB
	ON PSB.PLAYERID = PLB.PLAYERID
	AND PLB.PLAYERID = $playerID

	INNER JOIN TEAMS TMB
	ON PSB.TEAM_NUMBER = TMB.TEAMNUM

	INNER JOIN SCHEDULE SHB
	ON PSB.SCHEDULE_ID = SHB.SCHEDULE_ID
	AND SHB.GAME_TYPE > 0

	INNER JOIN SEASON SEB 
	ON SHB.GAME_DATE BETWEEN SEB.SEASON_SDTE AND SEB.SEASON_EDTE

	GROUP BY 1,2,3,4,5
	
	ORDER BY SEASON_SDTE, ROW_ORDER, GAME_DATE, GAME_COUNT, ABBREV ASC
	";
//	echo $sql;

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$playerStats = $db->sql_fetchrowset($result);

	$SEASON_DESC = $playerStats[0]["SEASON_DESC"];
	
//echo "<pre>";
//print_r($playerStats);

	echo "<TABLE class=gSGTableStatsGridOne cellSpacing=0 cellPadding=1 width=100% border=0>";
	echo "  <TBODY>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=19><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Career Averages</DIV></TD>";
	echo "	</TR>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne colSpan=8>&nbsp;</TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle colSpan=3><B>REBOUNDS PER GAME</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne colSpan=6>&nbsp;</TD>";
	echo "	</TR>";
	echo "	<TR class=gSGSectionColumnHeadingsStatsGridOne>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=40><B>&nbsp;YEAR</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=35><B>&nbsp;TEAM</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=10><B>G</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=10><B>GS</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>MPG</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=45><B>FG%</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=49><B>3P%</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=51><B>FT%</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>OFF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>DEF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>TOT</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>APG</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>SPG</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=26><B>BPG</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=26><B>TO</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=29><B>PF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=41><B>PPG</B></TD>";
	echo "	</TR>";

//	$playerStats = $db->sql_fetchrowset($result);
	$rowclass = "gSGRowEvenStatsGrid";

	if (count($playerStats) == 0) {
		echo "	<TR>";
		echo "	  <TD align=center class=gSGRowOddStatsGrid colSpan=19>No Stats Available</TD>";
		echo "	</TR>";
	}

//	echo "<pre>";
//	print_r($playerStats);

	foreach ($playerStats as $value) {

		$FTP = 0;
		$TPP = 0;
		$FGP = 0;

		$SEASON_DESC = $value["SEASON_DESC"];
		$SEASON = $value["SEASON"];

		$TEAM_ABBREV = $value["ABBREV"];
		$G    = $value["GAME_COUNT"];
		$GS = $value["START_COUNT"];
		$MINS = sprintf("%01.2f", $value["MINS"]  / $G );

		$FGA = $value["FGA"];
		$FGM = $value["FGM"];
		if ($FGA > 0) {	$FGP = sprintf("%01.3f", $FGM/$FGA) ;} else {	$FGP = sprintf("%01.3f", 0) ;}

		$TPA = $value["3PA"];
		$TPM = $value["3PM"];
		if ($TPA > 0) {	$TPP = sprintf("%01.3f", $TPM/$TPA) ;} else {	$TPP = sprintf("%01.3f", 0) ;}

		$FTA = $value["FTA"];
		$FTM = $value["FTM"];
		if ($FTA > 0) {	$FTP = sprintf("%01.3f", $FTM/$FTA); } else { $FTP = sprintf("%01.3f", 0);}

		$ORB = sprintf("%01.2f", $value["OREB"]  / $G );
		$DRB = sprintf("%01.2f", $value["DREB"]  / $G );
		$REB = sprintf("%01.2f", $value["REB"]  / $G );
		$AST = sprintf("%01.2f", $value["ASSISTS"]  / $G );
		$STL = sprintf("%01.2f", $value["STEALS"]  / $G );
		$BLK = sprintf("%01.2f", $value["BLOCKS"]  / $G );
		$TO  = sprintf("%01.2f", $value["TURNOVERS"]  / $G );
		$PF  = sprintf("%01.2f", $value["FOULS"]  / $G );
		$PTS = sprintf("%01.2f", $value["POINTS"]  / $G );


		$rowOrderCount++;

		if ($rowOrderCount == 2 & $TEAM_ABBREV == "--") {
			$rowOrderCount = 0;
		} else {
			echo "	<TR>";
			$b1 = "";
			$b2 = "";

			switch($SEASON) {
			
				case "Career":
					$b1 = "<B>";
					$b2 = "</B>";
					echo "	  <TD class=$rowclass colspan=2>&nbsp; &nbsp;$b1$SEASON$b2</TD>";
					break;
				case "Playoffs" :
					echo "	  <TD class=$rowclass colspan=2>&nbsp; &nbsp;$SEASON</TD>";
					break;
				default:

					echo "	  <TD class=$rowclass>&nbsp; &nbsp;$SEASON</TD>";
					echo "	  <TD class=$rowclass>&nbsp; &nbsp;$TEAM_ABBREV</TD>";
			}


			echo "	  <TD class=$rowclass align=middle>$b1$G$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$GS$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$MINS$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$FGP$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$TPP$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$FTP$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$ORB$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$DRB$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$REB$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$AST$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$STL$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$BLK$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$TO$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$PF$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$PTS$b2</TD>";
			echo "	</TR>";
			
			$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
			
			if ($rowOrderCount > 2 & $TEAM_ABBREV == "--") {
				$rowOrderCount = 0;
			}
		}
	}

		echo "  </TBODY>";
		echo "</TABLE>";


}



function createPlayerCareerTotalStats($playerID) {
	include('config.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "
SELECT	 '1' AS ROW_ORDER
		,SEASON_DESC
		,SEASON
		,ABBREV
		,SE.SEASON_SDTE
		,MAX(SH.GAME_DATE) AS GAME_DATE
		,SUM(MINS) AS MINS
		,SUM(FGA) AS FGA
		,SUM(FGM) AS FGM
		,SUM(3PA) AS 3PA
		,SUM(3PM) AS 3PM
		,SUM(FTA) AS FTA
		,SUM(FTM) AS FTM
		,SUM(OREBOUNDS) AS OREB
		,SUM(DREBOUNDS) AS DREB
		,SUM(REBOUNDS) AS REB
		,SUM(BLOCKS) AS BLOCKS
		,SUM(STEALS) AS STEALS
		,SUM(ASSISTS) AS ASSISTS
		,SUM(TURNOVERS) AS TURNOVERS
		,SUM(FOULS) AS FOULS
		,SUM(POINTS) AS POINTS
		,SUM(PS.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PS.ROSTERPOS < 5 AND PS.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT

	FROM PLAYERS PL
	INNER JOIN PLAYERSTATS PS
	ON PS.PLAYERID = PL.PLAYERID
	AND PL.PLAYERID = $playerID

	INNER JOIN TEAMS TM
	ON PS.TEAM_NUMBER = TM.TEAMNUM

	INNER JOIN SCHEDULE SH
	ON PS.SCHEDULE_ID = SH.SCHEDULE_ID
	AND SH.GAME_TYPE = 0

	INNER JOIN SEASON SE
	ON SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE

	GROUP BY 1,2,3,4,5

UNION

	SELECT	'2' AS ROW_ORDER
		,SEB.SEASON_DESC
		,SEB.SEASON
		,'--' AS ABBREV
		,SEB.SEASON_SDTE
		,MAX(SHB.GAME_DATE) AS GAME_DATE
		,SUM(PSB.MINS) AS MINS
		,SUM(PSB.FGA) AS FGA
		,SUM(PSB.FGM) AS FGM
		,SUM(PSB.3PA) AS 3PA
		,SUM(PSB.3PM) AS 3PM
		,SUM(PSB.FTA) AS FTA
		,SUM(PSB.FTM) AS FTM
		,SUM(PSB.OREBOUNDS) AS OREB
		,SUM(PSB.DREBOUNDS) AS DREB
		,SUM(PSB.REBOUNDS) AS REB
		,SUM(PSB.BLOCKS) AS BLOCKS
		,SUM(PSB.STEALS) AS STEALS
		,SUM(PSB.ASSISTS) AS ASSISTS
		,SUM(PSB.TURNOVERS) AS TURNOVERS
		,SUM(PSB.FOULS) AS FOULS
		,SUM(PSB.POINTS) AS POINTS
		,SUM(PSB.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PSB.ROSTERPOS < 5 AND PSB.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT

	FROM PLAYERS PLB
	LEFT JOIN PLAYERSTATS PSB
	ON PSB.PLAYERID = PLB.PLAYERID
	AND PLB.PLAYERID = $playerID

	INNER JOIN TEAMS TMB
	ON PSB.TEAM_NUMBER = TMB.TEAMNUM

	INNER JOIN SCHEDULE SHB
	ON PSB.SCHEDULE_ID = SHB.SCHEDULE_ID
	AND SHB.GAME_TYPE = 0

	INNER JOIN SEASON SEB 
	ON SHB.GAME_DATE BETWEEN SEB.SEASON_SDTE AND SEB.SEASON_EDTE

	GROUP BY 1,2,3,4,5
	
UNION

	SELECT	'3' AS ROW_ORDER
		,''
		,'Career'
		,'' AS ABBREV
		,'2090-12-31'
		,MAX(SHB.GAME_DATE) AS GAME_DATE
		,SUM(PSB.MINS) AS MINS
		,SUM(PSB.FGA) AS FGA
		,SUM(PSB.FGM) AS FGM
		,SUM(PSB.3PA) AS 3PA
		,SUM(PSB.3PM) AS 3PM
		,SUM(PSB.FTA) AS FTA
		,SUM(PSB.FTM) AS FTM
		,SUM(PSB.OREBOUNDS) AS OREB
		,SUM(PSB.DREBOUNDS) AS DREB
		,SUM(PSB.REBOUNDS) AS REB
		,SUM(PSB.BLOCKS) AS BLOCKS
		,SUM(PSB.STEALS) AS STEALS
		,SUM(PSB.ASSISTS) AS ASSISTS
		,SUM(PSB.TURNOVERS) AS TURNOVERS
		,SUM(PSB.FOULS) AS FOULS
		,SUM(PSB.POINTS) AS POINTS
		,SUM(PSB.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PSB.ROSTERPOS < 5 AND PSB.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT

	FROM PLAYERS PLB
	LEFT JOIN PLAYERSTATS PSB
	ON PSB.PLAYERID = PLB.PLAYERID
	AND PLB.PLAYERID = $playerID

	INNER JOIN TEAMS TMB
	ON PSB.TEAM_NUMBER = TMB.TEAMNUM

	INNER JOIN SCHEDULE SHB
	ON PSB.SCHEDULE_ID = SHB.SCHEDULE_ID
	AND SHB.GAME_TYPE = 0

	INNER JOIN SEASON SEB 
	ON SHB.GAME_DATE BETWEEN SEB.SEASON_SDTE AND SEB.SEASON_EDTE

	GROUP BY 1,2,3,4,5

UNION

	SELECT	'4' AS ROW_ORDER
		,''
		,'Playoffs'
		,'' AS ABBREV
		,'2090-12-31'
		,MAX(SHB.GAME_DATE) AS GAME_DATE
		,SUM(PSB.MINS) AS MINS
		,SUM(PSB.FGA) AS FGA
		,SUM(PSB.FGM) AS FGM
		,SUM(PSB.3PA) AS 3PA
		,SUM(PSB.3PM) AS 3PM
		,SUM(PSB.FTA) AS FTA
		,SUM(PSB.FTM) AS FTM
		,SUM(PSB.OREBOUNDS) AS OREB
		,SUM(PSB.DREBOUNDS) AS DREB
		,SUM(PSB.REBOUNDS) AS REB
		,SUM(PSB.BLOCKS) AS BLOCKS
		,SUM(PSB.STEALS) AS STEALS
		,SUM(PSB.ASSISTS) AS ASSISTS
		,SUM(PSB.TURNOVERS) AS TURNOVERS
		,SUM(PSB.FOULS) AS FOULS
		,SUM(PSB.POINTS) AS POINTS
		,SUM(PSB.PLAYED) AS GAME_COUNT
		,SUM(CASE WHEN PSB.ROSTERPOS < 5 AND PSB.PLAYED = 1 THEN 1 ELSE 0 END) AS START_COUNT

	FROM PLAYERS PLB
	LEFT JOIN PLAYERSTATS PSB
	ON PSB.PLAYERID = PLB.PLAYERID
	AND PLB.PLAYERID = $playerID

	INNER JOIN TEAMS TMB
	ON PSB.TEAM_NUMBER = TMB.TEAMNUM

	INNER JOIN SCHEDULE SHB
	ON PSB.SCHEDULE_ID = SHB.SCHEDULE_ID
	AND SHB.GAME_TYPE > 0

	INNER JOIN SEASON SEB 
	ON SHB.GAME_DATE BETWEEN SEB.SEASON_SDTE AND SEB.SEASON_EDTE

	GROUP BY 1,2,3,4,5
	
	ORDER BY SEASON_SDTE, ROW_ORDER, GAME_DATE, GAME_COUNT, ABBREV ASC
	";
//	echo $sql;

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$playerStats = $db->sql_fetchrowset($result);

	$SEASON_DESC = $playerStats[0]["SEASON_DESC"];
	
//echo "<pre>";
//print_r($playerStats);

	echo "<TABLE class=gSGTableStatsGridOne cellSpacing=0 cellPadding=1 width=100% border=0>";
	echo "  <TBODY>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=19><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Career Totals</DIV></TD>";
	echo "	</TR>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne colSpan=8>&nbsp;</TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle colSpan=3><B>REBOUNDS PER GAME</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne colSpan=6>&nbsp;</TD>";
	echo "	</TR>";
	echo "	<TR class=gSGSectionColumnHeadingsStatsGridOne>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=40><B>&nbsp;YEAR</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=35><B>&nbsp;TEAM</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=10><B>G</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=10><B>GS</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>MIN</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=45><B>FGM-A</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=49><B>3PM-A</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=51><B>FTM-A</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>OFF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>DEF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>TOT</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>AST</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=31><B>STL</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=26><B>BLK</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=26><B>TO</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=29><B>PF</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap align=middle width=41><B>PTS</B></TD>";
	echo "	</TR>";

//	$playerStats = $db->sql_fetchrowset($result);
	$rowclass = "gSGRowEvenStatsGrid";

	if (count($playerStats) == 0) {
		echo "	<TR>";
		echo "	  <TD align=center class=gSGRowOddStatsGrid colSpan=19>No Stats Available</TD>";
		echo "	</TR>";
	}

	foreach ($playerStats as $value) {

		$FTP = 0;
		$TPP = 0;
		$FGP = 0;


		$SEASON_DESC = $value["SEASON_DESC"];
		$SEASON = $value["SEASON"];

		$TEAM_ABBREV = $value["ABBREV"];
		$G    = $value["GAME_COUNT"];
		$GS = $value["START_COUNT"];
		$MINS = $value["MINS"];

		$FGA = $value["FGA"];
		$FGM = $value["FGM"];

		$TPA = $value["3PA"];
		$TPM = $value["3PM"];

		$FTA = $value["FTA"];
		$FTM = $value["FTM"];

		$ORB = $value["OREB"];
		$DRB = $value["DREB"];
		$REB = $value["REB"];
		$AST = $value["ASSISTS"];
		$STL = $value["STEALS"];
		$BLK = $value["BLOCKS"];
		$TO  = $value["TURNOVERS"];
		$PF  = $value["FOULS"];
		$PTS = $value["POINTS"];

		$rowOrderCount++;

		if ($rowOrderCount == 2 & $TEAM_ABBREV == "--") {
			$rowOrderCount = 0;
		} else {
			echo "	<TR>";
			$b1 = "";
			$b2 = "";

			switch($SEASON) {
			
				case "Career":
					$b1 = "<B>";
					$b2 = "</B>";
					echo "	  <TD class=$rowclass colspan=2>&nbsp; &nbsp;$b1$SEASON$b2</TD>";
					break;
				case "Playoffs" :
					echo "	  <TD class=$rowclass colspan=2>&nbsp; &nbsp;$SEASON</TD>";
					break;
				default:

					echo "	  <TD class=$rowclass>&nbsp; &nbsp;$SEASON</TD>";
					echo "	  <TD class=$rowclass>&nbsp; &nbsp;$TEAM_ABBREV</TD>";
			}

			echo "	  <TD class=$rowclass align=middle>$b1$G$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$GS$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$MINS$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$FGM-$FGA$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$TPM-$TPA$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$FTM-$FTA$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$ORB$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$DRB$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$REB$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$AST$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$STL$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$BLK$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$TO$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$PF$b2</TD>";
			echo "	  <TD class=$rowclass align=middle>$b1$PTS$b2</TD>";
			echo "	</TR>";
			
			$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
			
			if ($rowOrderCount > 2 & $TEAM_ABBREV == "--") {
				$rowOrderCount = 0;
			}
			
		}
	}
	echo "  </TBODY>";
	echo "</TABLE>";
}

function createPlayerCurrentSeasonStatsLeaders(){

echo "
                        		<TABLE class=gSGTableStatsGridOne cellSpacing=0 cellPadding=0 border=0>
                                  <COLGROUP>
                                  <COL>
                                  <COL>
                                  <TBODY>
                                    <TR>
                                      <TD>&nbsp;Ranks #1 in the NBA in Assists Per Game (9.3)</TD>
                                      <TD>&nbsp;Ranks #9 in the NBA in Steals Per Game (1.7)</TD>
                                    <TR>
                                      <TD>&nbsp;Ranks #2 in the NBA in Assists (185.0)</TD>
                                      <TD>&nbsp;Ranks #11 in the NBA in Steals (34.0)</TD>
                                    <TR>
                                      <TD>&nbsp;Ranks #12 in the NBA in Assists Per Turnover (2.94)</TD>
                                      <TD>&nbsp;Ranks #6 in the NBA in Double-doubles (11.0)</TD>
                                    <TR>
                                      <TD>&nbsp;Ranks #1 in the NBA in Triple-doubles (4.0)</TD>
                                      <TD>&nbsp;Ranks #1 in the NBA in Assists Per 48 Minutes (11.8)</TD>
                                    <TR>
                                      <TD>&nbsp;Ranks #11 in the NBA in Total Turnovers (63.0)</TD>
                                      <TD>&nbsp;Ranks #17 in the NBA in Total Efficiency Points (427.0)</TD>
                                    <TR>
                                      <TD>&nbsp;Ranks #16 in the NBA in Efficiency Ranking (21.35)</TD>
                                      <TD>&nbsp;Ranks #18 in the NBA in Efficiency Ranking Per 48 Minutes (27.26)</TD>
                                    <TR>
                                      <TD>&nbsp;Ranks #7 in the NBA in Turnovers Per Game (3.15)</TD>
                                      <TD>&nbsp;</TD>
                                    </TR>
                                  </TBODY>
                                </TABLE>
";

}


function createPlayerCareerHigh($playerID) {
	include('config.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);


		$sql = "select * from SEASON SE where CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE";

		if ( !($result = $db->sql_query($sql)) ) {
			echo "failed";
		}

		$currentSeason = $db->sql_fetchrow($result);
		$seasonDesc = $currentSeason["SEASON"];
		

	$statType = array('POINTS','FGM','FGA','3PM','3PA','FTM','FTA','OREBOUNDS','DREBOUNDS','REBOUNDS','ASSISTS','STEALS','BLOCKS','MINS');
	$statDesc = array('Points'
						,'Field Goals Made'
						,'Field Goals Attempted'
						,'Three Point Field Goals Made'
						,'Three Point Field Goals Attempted'
						,'Free Throws Made'
						,'Free Throws Attempted'
						,'Offensive Rebounds'
						,'Defensive Rebounds'
						,'Total Rebounds'
						,'Assists'
						,'Steals'
						,'Blocks'
						,'Minutes Played');

	echo "<TABLE class=gSGTableStatsGridOne cellSpacing=0 cellPadding=0 width=100% border=0>";
	echo "  <TBODY>";
	echo "	<TR>";
	echo "	  <TD class=gSGSectionTitleStatsGridOne colSpan=3><DIV class=gSGSectionTitleStatsGridOne>&nbsp;Season Highs / Career Highs</DIV></TD>";
	echo "	</TR>";
	echo "	<TR class=gSGSectionColumnHeadingsStatsGridOne>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=200><B>&nbsp; </B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=200><B>$seasonDesc HIGHS</B></TD>";
	echo "	  <TD class=gSGSectionColumnHeadingsStatsGridOne noWrap width=200><B>CAREER HIGHS</B></TD>";
	echo "	</TR>";


	$i = 0;
	$rowclass = "gSGRowEvenStatsGrid";
	
	foreach ($statType as $stat) {

		$sql = "
			SELECT 	 MAX_STATS.STATHIGH
					,MAX_STATS.TEAMNAME
					,MAX_STATS.PLAYED_DATE
					,MAX_STATS.HOME_TEAM
					,MAX_STATS.AWAY_TEAM
					,MAX_STATS.TEAMNUM
					,MAX_STATS.TEAM_NUMBER


			FROM PLAYERS PL
			LEFT JOIN 
			(
			SELECT 	 PST.PLAYERID
				,PST.$stat AS STATHIGH
				,TE.TEAMNAME
				,SH.PLAYED_DATE
				,SH.HOME_TEAM
				,SH.AWAY_TEAM
				,PST.TEAM_NUMBER
				,TE.TEAMNUM

			FROM PLAYERSTATS PST

			INNER JOIN SCHEDULE SH
			ON PST.SCHEDULE_ID = SH.SCHEDULE_ID
			AND PST.PLAYERID = $playerID
			AND PST.$stat = (SELECT MAX($stat) FROM PLAYERSTATS WHERE PLAYERID = $playerID)
			AND SH.PLAYED = 1
			AND PST.PLAYED = 1
			INNER JOIN TEAMS TE
			ON SH.AWAY_TEAM = TE.TEAMNUM OR SH.HOME_TEAM = TE.TEAMNUM
			WHERE TE.TEAMNUM <> PST.TEAM_NUMBER
			) AS MAX_STATS
			ON MAX_STATS.PLAYERID = PL.PLAYERID
			WHERE PL.PLAYERID = $playerID
		";

		if ( !($result = $db->sql_query($sql)) ) {
			echo "failed";
		}

		$CareerHigh = $db->sql_fetchrow($result);
		
//		print_r($CareerHigh);


		$sql = "
			SELECT 	 MAX_STATS.STATHIGH
					,MAX_STATS.TEAMNAME
					,MAX_STATS.PLAYED_DATE
					,MAX_STATS.HOME_TEAM
					,MAX_STATS.AWAY_TEAM
					,MAX_STATS.TEAM_NUMBER

			FROM PLAYERS PL
			LEFT JOIN 
			(
			SELECT 	 PST.PLAYERID
				,PST.$stat AS STATHIGH
				,TE.TEAMNAME
				,SH.PLAYED_DATE
				,SH.HOME_TEAM
				,SH.AWAY_TEAM
				,PST.TEAM_NUMBER

			FROM PLAYERSTATS PST
			INNER JOIN SEASON SE
			ON PST.PLAYERID = $playerID
			AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			AND PST.SCHEDULE_ID IN (
				SELECT SCHEDULE_ID 
				FROM SCHEDULE SH
				INNER JOIN SEASON SE
				ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
				AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			)


			INNER JOIN SCHEDULE SH
			ON PST.SCHEDULE_ID = SH.SCHEDULE_ID
			AND PST.PLAYERID = $playerID
			AND PST.$stat = (SELECT MAX($stat) FROM PLAYERSTATS WHERE PLAYERID = $playerID
						AND SCHEDULE_ID IN (
							SELECT SCHEDULE_ID 
							FROM SCHEDULE SH
							INNER JOIN SEASON SE
							ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
							AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
						)
			
			)
			AND SH.PLAYED = 1
			AND PST.PLAYED = 1
			INNER JOIN TEAMS TE
			ON SH.AWAY_TEAM = TE.TEAMNUM OR SH.HOME_TEAM = TE.TEAMNUM
			WHERE TE.TEAMNUM <> PST.TEAM_NUMBER
			) AS MAX_STATS
			ON MAX_STATS.PLAYERID = PL.PLAYERID
			WHERE PL.PLAYERID = $playerID
			";

		if ( !($result = $db->sql_query($sql)) ) {
			echo "failed";
		}

		$SeasonHigh = $db->sql_fetchrow($result);
		
		$CareerteamName = $CareerHigh["TEAMNAME"];
		$CareerstatCount = $CareerHigh["STATHIGH"];
		$CareerstatDate = date("d/m/Y",strtotime($CareerHigh["PLAYED_DATE"]));
		$CareerstatTeamID = $CareerHigh["TEAM_NUMBER"];
		$CareerstatGameHomeTeamID = $CareerHigh["HOME_TEAM"];

		$SeasonteamName = $SeasonHigh["TEAMNAME"];
		$SeasonstatCount = $SeasonHigh["STATHIGH"];
		$SeasonstatDate = date("d/m/Y",strtotime($SeasonHigh["PLAYED_DATE"]));
		$SeasonstatTeamID = $SeasonHigh["TEAM_NUMBER"];
		$SeasonstatGameHomeTeamID = $SeasonHigh["HOME_TEAM"];

		$SeasonstatTeamID == $SeasonstatGameHomeTeamID ? $teamPlayed = "Vs" : $teamPlayed = "@";
	
		echo "<TR>";
		echo "  <TD class=$rowclass>&nbsp;$statDesc[$i]</TD>";
//		echo "  <TD class=$rowclass><B>$SeasonstatCount</B> @ $SeasonteamName $SeasonstatDate </TD>";
//		echo "  <TD class=$rowclass>&nbsp;</TD>";

		if ($SeasonstatCount == 0) {
			echo "  <TD class=$rowclass><B>0</B></TD>";
		} else {
			echo "  <TD class=$rowclass><B>$SeasonstatCount</B> $teamPlayed $SeasonteamName $SeasonstatDate </TD>";
		}

		$CareerstatTeamID == $CareerstatGameHomeTeamID ? $teamPlayed = "Vs" : $teamPlayed = "@";

		if ($CareerstatCount == 0) {
			echo "  <TD class=$rowclass><B>0</B></TD>";
		} else {
			echo "  <TD class=$rowclass><B>$CareerstatCount</B> $teamPlayed $CareerteamName $CareerstatDate </TD>";
		}


		echo "</TR>";
		
		$i++;
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
	}

	echo "  </TBODY>";
	echo "</TABLE>";
}


function createPlayerGameLog($playerID) {
	include('config.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "
		SELECT	SH.SCHEDULE_ID
				,SH.GAME_DATE
				,SH.PLAYED_DATE
				,SH.HOME_TEAM
				,SH.AWAY_TEAM
				,SH.HOME_SCORE
				,SH.AWAY_SCORE
				,SH.GAME_TYPE
				,SH.FORFEIT
				,PST.TEAM_NUMBER
				,PST.MINS
				,PST.FGA
				,PST.FGM
				,PST.3PA
				,PST.3PM
				,PST.FTA
				,PST.FTM
				,PST.OREBOUNDS
				,PST.DREBOUNDS
				,PST.REBOUNDS
				,PST.BLOCKS
				,PST.STEALS
				,PST.ASSISTS
				,PST.TURNOVERS
				,PST.FOULS
				,PST.POINTS
				,TMH.ABBREV AS HOME_ABBREV
				,TMA.ABBREV AS AWAY_ABBREV
				
		FROM	SEASON SE
		INNER JOIN SCHEDULE SH
		ON 	SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		AND CURDATE() BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
		
		INNER JOIN PLAYERSTATS PST
		ON	PST.SCHEDULE_ID = SH.SCHEDULE_ID
		AND	PST.PLAYERID = $playerID

		INNER JOIN TEAMS TMH
		ON	SH.HOME_TEAM = TMH.TEAMNUM

		INNER JOIN TEAMS TMA
		ON	SH.AWAY_TEAM = TMA.TEAMNUM

		ORDER BY SH.PLAYED_DATE, SH.PLAYED_TIME, SCHEDULE_ID DESC
	";
//	echo $sql;

	if ( !($result = $db->sql_query($sql)) ) {
		echo "failed";
	}

	$playerStats = $db->sql_fetchrowset($result);

//	$SEASON_DESC = $playerStats[0]["SEASON_DESC"];
	
//echo "<pre>";
//print_r($playerStats);


	echo "<table border=0 cellpadding=0 cellspacing=0 class=gSGTableStatsGrid width=100%>";
	echo "<tr><td class=gSGSectionTitleStatsGrid colspan=17><div class=gSGSectionTitleStatsGrid>&nbsp;Game Log</div></td></tr>";
	echo "<tr>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colspan=7>&nbsp;</td>";
	echo "<td NOWRAP align=center colspan=3 class=gSGSectionColumnHeadingsStatsGrid><b>REBOUNDS</b></td>";
	echo "<td class=gSGSectionColumnHeadingsStatsGrid colspan=6>&nbsp;</td>";
	echo "</tr>";
	echo "<tr class=gSGSectionColumnHeadingsStatsGrid>";
	echo "<td NOWRAP align=left width=35 class=gSGSectionColumnHeadingsStatsGrid><b>&nbsp;Date</b></td>";
	echo "<td NOWRAP class=gSGSectionColumnHeadingsStatsGrid><b>Opp</b></td>";
	echo "<td NOWRAP class=gSGSectionColumnHeadingsStatsGrid><b>Result</b></td>";
	echo "<td NOWRAP align=center width=25 class=gSGSectionColumnHeadingsStatsGrid><b>Min</b></td>";
	echo "<td NOWRAP align=left width=55 class=gSGSectionColumnHeadingsStatsGrid><b>&nbsp;FGM-A</b></td>";
	echo "<td NOWRAP align=left width=45 class=gSGSectionColumnHeadingsStatsGrid><b>3PM-A</b></td>";
	echo "<td NOWRAP align=right width=40 class=gSGSectionColumnHeadingsStatsGrid><b>FTM-A</b></td>";
	echo "<td NOWRAP align=right width=25 class=gSGSectionColumnHeadingsStatsGrid><b>OFF</b></td>";
	echo "<td NOWRAP align=center width=25 class=gSGSectionColumnHeadingsStatsGrid><b>DEF</b></td>";
	echo "<td NOWRAP align=center width=30 class=gSGSectionColumnHeadingsStatsGrid><b>TOT</b></td>";
	echo "<td NOWRAP align=center width=30 class=gSGSectionColumnHeadingsStatsGrid><b>AST</b></td>";
	echo "<td NOWRAP align=center width=30 class=gSGSectionColumnHeadingsStatsGrid><b>ST</b></td>";
	echo "<td NOWRAP align=center width=30 class=gSGSectionColumnHeadingsStatsGrid><b>BL</b></td>";
	echo "<td NOWRAP align=center width=30 class=gSGSectionColumnHeadingsStatsGrid><b>TO</b></td>";
	echo "<td NOWRAP align=center width=30 class=gSGSectionColumnHeadingsStatsGrid><b>PF</b></td>";
	echo "<td NOWRAP align=right width=30 class=gSGSectionColumnHeadingsStatsGrid><b>PTS</b></td>";
	echo "</tr>";


	$rowclass = "gSGRowEvenStatsGrid";

	if (count($playerStats) == 0) {
		echo "	<TR>";
		echo "	  <TD align=center class=gSGRowOddStatsGrid colSpan=16><b>No Stats Available</b></TD>";
		echo "	</TR>";
	}

	foreach ($playerStats as $game) {

		$playerTeamID = $game["TEAM_NUMBER"];
		$forfeitTeamID = trim($game["FORFEIT"]);
		$homeTeamID = $game["HOME_TEAM"];
		$homeTeamName = $game["HOME_ABBREV"];
		$homeTeamScore = $game["HOME_SCORE"];
		$awayTeamID = $game["AWAY_TEAM"];
		$awayTeamName = $game["AWAY_ABBREV"];
		$awayTeamScore = $game["AWAY_SCORE"];
		$gameDate = $game["PLAYED_DATE"];
		
		$formattedGameDate = date('j M',strtotime($gameDate));
		
		$scheduleID = $game["SCHEDULE_ID"];

		switch ($game["GAME_TYPE"]) {
			case 0 : 
				$gameType = "";
				break;
			default : 
				$gameType = "PLF";
				break;
		}

		$homeOrAway = "at";
		$playedTeamID = $homeTeamID;
		$playedTeamName = $homeTeamName;
		
		$result = $awayTeamScore . "-" . $homeTeamScore;

		if ($forfeitTeamID != "") {
			switch ($forfeitTeamID) {
				case $homeTeamID :
					$result = "FH";
					break;
				case $awayTeamID :
					$result = "FA";
					break;
			}
		} 

		$homeTeamScore == $awayTeamScore ? $result = "FB" : $result = $result;
		
		
		if ($playerTeamID == $homeTeamID) {
			$homeOrAway = "vs";
			$playedTeamID = $awayTeamID;
			$playedTeamName = $awayTeamName;
			$homeTeamScore > $awayTeamScore ? $winLoss = "W" : $winLoss = "L";
		} else {
			$homeTeamScore < $awayTeamScore ? $winLoss = "W" : $winLoss = "L";		
		}


		if ($forfeitTeamID == "" and $homeTeamScore != $awayTeamScore) {
			$boxScore = "<a class=gSGGameLinkStatsGrid href=viewboxscore.php?scheduleID=$scheduleID>$result $winLoss</a>";
		} else {
			$boxScore = "<b>$result</b> $winLoss";
		}

		$MINS = $game["MINS"];
		$FGA = $game["FGA"];
		$FGM = $game["FGM"];
		$TPA = $game["3PA"];
		$TPM = $game["3PM"];
		$FTA = $game["FTA"];
		$FTM = $game["FTM"];
		$OREB = $game["OREBOUNDS"];
		$DREB = $game["DREBOUNDS"];
		$REB = $game["REBOUNDS"];
		$AST = $game["ASSISTS"];
		$STL = $game["STEALS"];
		$BLK = $game["BLOCKS"];
		$TO  = $game["TURNOVERS"];
		$PF  = $game["FOULS"];
		$PTS = $game["POINTS"];
	

		if ($forfeitTeamID == "" and $homeTeamScore != $awayTeamScore) {
			echo "<tr>";
			echo "<TD class=$rowclass align=left>&nbsp$formattedGameDate</TD>";
			echo "<TD class=$rowclass align=left>&nbsp;$homeOrAway <a class=gSGTeamLinkStatsGrid href=viewteam.php?teamID=$playedTeamID>$playedTeamName</a> $gameType</TD>";
			echo "<TD class=$rowclass>$boxScore</TD>";
			echo "<TD class=$rowclass align=center >$MINS</TD>";
			echo "<TD class=$rowclass align=left>$FGM-$FGA</TD>";
			echo "<TD class=$rowclass>$TPM-$TPA</TD>";
			echo "<TD class=$rowclass>$FTM-$FTA</TD>";
			echo "<TD class=$rowclass align=center>$OREB</TD>";
			echo "<TD class=$rowclass align=center>$DREB</TD>";
			echo "<TD class=$rowclass align=center>$REB</TD>";
			echo "<TD class=$rowclass align=center>$AST</TD>";
			echo "<TD class=$rowclass align=center>$STL</TD>";
			echo "<TD class=$rowclass align=center>$BLK</TD>";
			echo "<TD class=$rowclass align=center>$TO</TD>";
			echo "<TD class=$rowclass align=center>$PF</TD>";
			echo "<TD class=$rowclass align=center>$PTS</TD>";
			echo "</tr>";
		} else {
			echo "<tr>";
			echo "<TD class=$rowclass align=left>&nbsp$formattedGameDate</TD>";
			echo "<TD class=$rowclass align=left>$homeOrAway <a class=gSGTeamLinkStatsGrid href=viewteam.php?teamID=$playedTeamID>$playedTeamName</a> $gameType</TD>";
			echo "<TD class=$rowclass>$boxScore</TD>";
			echo "<TD class=$rowclass align=center colspan=13>DNP</TD>";			
			echo "</tr>";
		}

		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
	
	}



echo "</table>";


}

function createPlayerAwards($awardsList) {

	foreach ($awardsList as $award) {
		$season = $award["SEASON"];
		$awardName = $award["AWARD_DESC"];
	
		echo "$season $awardName <br>";
	
	
	}


}

?>



