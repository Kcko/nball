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

$playerLoadErrors = "";
$gameLoadErrors = "";

class GameStats {
	var $strTeam;
	var $strTeamID;
	var $strPoints;
	var $strBenchScoring;
	var $strFGA;
	var $strFGM;
	var $strFGP;
	var $str3PA;
	var $str3PM;
	var $str3PP;
	var $strFTA;
	var $strFTM;
	var $strFTP;
	var $strReb;
	var $strOReb;
	var $strDReb;
	var $strBlocks;
	var $strSteals;
	var $strAssists;
	var $strTO;
	var $strFouls;
}

class PlayerStats {
	var $strTeam;
	var $strTeamID;	
	var $strPlayerID;
	var $strRosterPos;
	var $strPos;
	var $strNo;
	var $strName;
	var $strPts;
	var $strMins;       
	var $strFGA;        
	var $strFGM;        
	var $strFGP;
	var $str3PA;        
	var $str3PM;        
	var $str3PP;
	var $strFTA;       
	var $strFTM;        
	var $strFTP;
	var $strOReb;       
	var $strDReb;       
	var $strRebs;       
	var $strBlk;        
	var $strStl;        
	var $strAst;        
	var $strTO;         
	var $strFouls;      
	var $strPlayed;
}

function createGameStatObj($fileName, $HomeTeamName, $HomeTeamID, $AwayTeamName, $AwayTeamID) {
	$i = 0;
	$homeTeamStats = New GameStats;
	$awayTeamStats = New GameStats;
	
	global $gameLoadErrors ;

	$handle = fopen ($fileName, "r");
	$buffer = fgets($handle, 4096); // get gamestat header

//	echo $HomeTeamName;
//	echo $AwayTeamName;

	$fileEntireGame = trim(substr($buffer,0,19));
	$fileAwayTeamName = trim(substr($buffer,19,17));
	$fileHomeTeamName = trim(substr($buffer,36,19));

	if ($fileEntireGame!= "Entire Game") {
//		die ("invalid file");
		$gameLoadErrors .= "<br>invalid game stats file";
		return;
	}

	if ($fileHomeTeamName != $HomeTeamName) {
//		die ("invalid team file " . $HomeTeamName . "-" . $fileHomeTeamName );
		$gameLoadErrors .= "<br>invalid team in gamestats file $HomeTeamName - $fileHomeTeamName";
		return;
	}

	if ($fileAwayTeamName != $AwayTeamName) {
//		die ("invalid team file " . $AwayTeamName . "-" . $fileAwayTeamName );
		$gameLoadErrors .= "<br>invalid team in gamestats file $AwayTeamName - $fileAwayTeamName";
		return;
	}

	$buffer = fgets($handle, 4096); // get blank
	if (trim($buffer) != "") {
		$gameLoadErrors = "<br>invalid file";
		return;
	}

	$homeTeamStats->strTeam = $fileHomeTeamName;
	$homeTeamStats->strTeamID = $HomeTeamID;

	$awayTeamStats->strTeam = $fileAwayTeamName;
	$awayTeamStats->strTeamID = $AwayTeamID;


// Points
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strPoints = trim(substr($buffer,19,17));
	$homeTeamStats->strPoints = trim(substr($buffer,36,19));

// Bench
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strBenchScoring = trim(substr($buffer,19,17));
	$homeTeamStats->strBenchScoring = trim(substr($buffer,36,19));

// FG
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$strFG = split("/",trim(substr($buffer,19,17)));
	$awayTeamStats->strFGM = $strFG[0];
	$awayTeamStats->strFGA = $strFG[1];

	$strFG = split("/",trim(substr($buffer,36,19)));
	$homeTeamStats->strFGM = $strFG[0];
	$homeTeamStats->strFGA = $strFG[1];

// FG %
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strFGP = trim(substr($buffer,19,17));
	$homeTeamStats->strFGP = trim(substr($buffer,36,19));

// 3P
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$str3P = split("/",trim(substr($buffer,19,17)));
	$awayTeamStats->str3PM = $str3P[0];
	$awayTeamStats->str3PA = $str3P[1];
	$str3P = split("/",trim(substr($buffer,36,19)));
	$homeTeamStats->str3PM = $str3P[0];
	$homeTeamStats->str3PA = $str3P[1];

// 3P%
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->str3PP = trim(substr($buffer,19,17));
	$homeTeamStats->str3PP = trim(substr($buffer,36,19));

// FT
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));

	$strFT = split("/",trim(substr($buffer,19,17)));
	$awayTeamStats->strFTM = $strFT[0];
	$awayTeamStats->strFTA = $strFT[1];

	$strFT = split("/",trim(substr($buffer,36,19)));
	$homeTeamStats->strFTM = $strFT[0];
	$homeTeamStats->strFTA = $strFT[1];

// FT%
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strFTP = trim(substr($buffer,19,17));
	$homeTeamStats->strFTP = trim(substr($buffer,36,19));

// Reb
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strReb = trim(substr($buffer,19,17));
	$homeTeamStats->strReb = trim(substr($buffer,36,19));

// OReb
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strOReb = trim(substr($buffer,19,17));
	$homeTeamStats->strOReb = trim(substr($buffer,36,19));

// DReb
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strDReb = trim(substr($buffer,19,17));
	$homeTeamStats->strDReb = trim(substr($buffer,36,19));

// Blocks
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strBlocks = trim(substr($buffer,19,17));
	$homeTeamStats->strBlocks = trim(substr($buffer,36,19));

// Steals
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strSteals = trim(substr($buffer,19,17));
	$homeTeamStats->strSteals = trim(substr($buffer,36,19));

// Assists
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strAssists = trim(substr($buffer,19,17));
	$homeTeamStats->strAssists = trim(substr($buffer,36,19));

// Turnovers
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strTO = trim(substr($buffer,19,17));
	$homeTeamStats->strTO = trim(substr($buffer,36,19));

// Fouls
	$buffer = fgets($handle, 4096); 
	$fileEntireGame = trim(substr($buffer,0,19));
	$awayTeamStats->strFouls = trim(substr($buffer,19,17));
	$homeTeamStats->strFouls = trim(substr($buffer,36,19));

	fclose ($handle);

	$c["home"] = $homeTeamStats;
	$c["away"] = $awayTeamStats;

	return $c;
}



function createPlayerStatObj($fileName, $teamName, $teamID) {
	global $gameLoadErrors;
	$i = 0;
	
	$a = New PlayerStats;	
	$b[] = "";

	$handle = fopen ($fileName, "r");
	$buffer = fgets($handle, 4096); // get current game
	if (trim($buffer) != "Current Game") {
		//die ("invalid file");
		$gameLoadErrors .= "<br>invalid playerstats file: $teamName";
		return;
	}
	$buffer = fgets($handle, 4096); // get team name
	$strTeam = trim($buffer);
	if ($strTeam != $teamName) {
		//die ("invalid team file " . $teamName);
		$gameLoadErrors .= "<br>invalid team playerstats file: $teamName";
		return;
	}


	$buffer = fgets($handle, 4096); // get blank
	if (trim($buffer) != "") {
		//die ("invalid file");
		$gameLoadErrors .= "<br>invalid team playerstats file: $teamName";
		return;
	}

	$buffer = fgets($handle, 4096); // get headings
	if (trim($buffer) != "Pos.   No.   Name                 Pts        Mins       FGM        FGA        FG%        3PM        3PA        3P%        FTM        FTA        FT%        OReb       DReb       Rebs       Blk        Stl        Ast        TO         Fouls") {
		//die ("invalid file");
		$gameLoadErrors .= "<br>invalid team playerstats file: $teamName";
		return;
		
	}

	$buffer = fgets($handle, 4096); // get blank
	if (trim($buffer) != "") {
		//die ("invalid file");
		$gameLoadErrors .= "<br>invalid team playerstats file: $teamName";
		return;
	}


	while (!feof ($handle) & $i <= 11) {

		$buffer = fgets($handle, 4096); // get stats

		$a->strTeam = $strTeam;
		$a->strTeamID = $teamID;
		$a->strPos = trim(substr($buffer,0,7)); 
		$a->strNo = trim(substr($buffer,7,6)); 
		$a->strName = trim(substr($buffer,13,21)); 
		
		if (substr($a->strName,1,1) != ".") {
		
			$a->strName = ". " . $a->strName;
		
		}
		$a->strPts = trim(substr($buffer,34,11)); 
		$a->strMins = trim(substr($buffer,45,11)); 
		$a->strPlayed = 1;
		if ($a->strMins == 0) {
			$a->strPlayed = 0;
		}
		$a->strFGM = trim(substr($buffer,56,11)); 
		$a->strFGA = trim(substr($buffer,67,11)); 
		$a->strFGP = trim(substr($buffer,78,11)); 
		$a->str3PM = trim(substr($buffer,89,11)); 
		$a->str3PA = trim(substr($buffer,100,11)); 
		$a->str3PP = trim(substr($buffer,111,11)); 
		$a->strFTM = trim(substr($buffer,122,11)); 
		$a->strFTA = trim(substr($buffer,133,11)); 
		$a->strFTP = trim(substr($buffer,144,11)); 
		$a->strOReb = trim(substr($buffer,155,11)); 
		$a->strDReb = trim(substr($buffer,166,11)); 
		$a->strRebs = trim(substr($buffer,177,11)); 
		$a->strBlk = trim(substr($buffer,188,11)); 
		$a->strStl = trim(substr($buffer,199,11)); 
		$a->strAst = trim(substr($buffer,210,11)); 
		$a->strTO = trim(substr($buffer,221,11)); 
		$a->strFouls = trim(substr($buffer,232,11));

		$getPlayerIDResult = getPlayerID($a->strName, $teamID, $a->strNo);

		$a->strPlayerID = $getPlayerIDResult[0];
		$a->strRosterPos = $getPlayerIDResult[1];

		if ($a->strPlayerID != "99999") {
			$b[$i] = $a;
			$i++;   
		}
		$a = "";
		//echo $buffer . "<br>";
	}
	fclose ($handle);

//	echo "<pre>";
//	print_r($b);
//	echo "</pre>";

	return $b;
}

function createUploadBox($teamData, $HOME_TEAMNUM, $AWAY_TEAMNUM, $SCHEDULE_ID){
	echo "<form action=\"validatescore.php\" method=\"POST\" enctype=\"multipart/form-data\">
	Send these files:<br>";
	echo "HOME:" . $teamData[$HOME_TEAMNUM]["CITYNAME2"] . "<input name=\"userfile[]\" type=\"file\"><br>\n";
	echo "AWAY:" . $teamData[$AWAY_TEAMNUM]["CITYNAME2"] . "<input name=\"userfile[]\" type=\"file\"><br>\n";
	echo "Game stats<input name=\"userfile[]\" type=\"file\"><br>\n";
	echo "<input type=submit value=\"Send files\">\n";

	echo "<input name=SCHEDULE_ID type=hidden value=$SCHEDULE_ID><br>\n";
	echo "<input name=HOME_TEAMNUM type=hidden value=$HOME_TEAMNUM><br>\n";
	echo "<input name=AWAY_TEAMNUM type=hidden value=$AWAY_TEAMNUM><br>\n";
	echo "<input name=HOME_TEAM type=hidden value=\"" . $teamData[$HOME_TEAMNUM]["CITYNAME2"] . "\"><br>\n";
	echo "<input name=AWAY_TEAM type=hidden value=\"" . $teamData[$AWAY_TEAMNUM]["CITYNAME2"] . "\"><br>\n";
	echo "</form>\n";

}

function createSchedule($teamSchedule, $currentRounds) {

	foreach($currentRounds as $round) {
		$roundNumber = $round["ROUND_NUM"];
		$seasonID = $round["SEASON_ID"];

		echo "<a href=viewfullschedule.php?round=$roundNumber&seasonID=$seasonID>$roundNumber</a> &nbsp;";
	}


	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 class=gScGTable>";

	$rowclass = "gSGRowEvenStatsGrid";

	$c_playedDate = "";
	$p_playedDate = "";
	$i = 1;

	foreach ($teamSchedule as $value) {

		$c_playedDate = $value["GAME_DATE"];

		if ($c_playedDate != $p_playedDate) {
		
			$formattedc_playedDate = date('l j M Y',strtotime($c_playedDate));
			
			
			switch ($value["GAME_TYPE"]) {
			
				case 1:	$playOffType = "Playoffs - Conference Quarter Final";
						break;
				case 2: $playOffType = "Playoffs - Conference Semi Final";
						break;
				case 3: $playOffType = "Playoffs - Conference Final";
						break;
				case 4: $playOffType = "Playoffs - Season Final";
						break;
			}

			if ($value["GAME_TYPE"] > 0) {
				echo "<tr>";
				echo "<td class=gSGSectionColumnHeadingsStatsGrid colspan=3 align=center><b>&nbsp;$playOffType</b></td>";
				echo "</tr>";
				$roundNumber = "";
			} else {
				$roundNum = $value["ROUND_NUM"];
				$roundNumber = "Round $roundNum - ";
			}
			
			echo "<tr>";
			echo "<td class=gSGSectionColumnHeadingsStatsGrid colspan=5><b>&nbsp;$roundNumber Games To Be Played By 00:00 $formattedc_playedDate</b></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td width=75 class=gSGSectionColumnHeadingsStatsGrid><b>&nbsp;Date </b></td>";
			echo "<td width=225 class=gSGSectionColumnHeadingsStatsGrid><b>Opponent</b></td>";
			echo "<td width=100 class=gSGSectionColumnHeadingsStatsGrid><b>Box Score</b></td>";
			echo "<td width=100 class=gSGSectionColumnHeadingsStatsGrid><b>High Pts</b></td>";
			echo "<td width=100 class=gSGSectionColumnHeadingsStatsGrid><b>High Reb</b></td>";
			echo "</tr>";
			$p_playedDate = $c_playedDate;
			$i++;
		}

//		$p_rowclass = $rowclass;
/*
		if (!$value["PLAYED"] & $c_playedDate <= date("Y-m-d", mktime())) {
			$p_rowclass = $rowclass;
			$rowclass = $rowclass . "Missed";
		}
*/
		if ($prevSchedID == $value["SCHEDULE_ID"]) {
			$rowclass = $p_rowclass; 
		}

		echo "<tr>";
		
		$playedDate = $value["PLAYED_DATE"];
		
		if ($value["PLAYED_DATE"] == $prevPlayedDate) {
			$playedDate = "";
		}

		echo "<td valign=top class=$rowclass>&nbsp;&nbsp;$playedDate</td>";

		$OT = $value["OVERTIME"];

		switch ($OT) {
			case 0: $OT = "";
				break;

			case 1: $OT = "OT";
				break;
		
			default: $OT = $OT. "OT";
		}



		$teamPlayed = "<a href=viewteam.php?teamID=" . $value["AWAY_TEAMNUM"] .">" . $value["AWAY_TEAMNAME"] . "</a>". " @ " . "<a href=viewteam.php?teamID=" . $value["HOME_TEAMNUM"] .">" . $value["HOME_TEAMNAME"] . "</a>" ;
		
		if ($prevSchedID == $value["SCHEDULE_ID"]) {
			$teamPlayed = "&nbsp;";
		}

		echo "<td valign=top class=$rowclass >" . $teamPlayed . "</td>";

		switch ($value["PLAYED"]) {
			case 0:
				$boxscore = "<a href=admin\submitscore.php?SCHEDULE_ID=" . $value["SCHEDULE_ID"] . "&HOME_TEAMNUM=" . $value["HOME_TEAMNUM"] . "&AWAY_TEAMNUM=" . $value["AWAY_TEAMNUM"] . ">Submit Score</a>"  ;
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
					$boxscore = "<B>FB</B>";
				} else {
					$boxscore = $value["AWAY_SCORE"] . "-" . $value["HOME_SCORE"] . " $OT";
					$boxscore = "<a href=viewboxscore.php?scheduleID=". $value["SCHEDULE_ID"] .">$boxscore</a>";
				}

				break;
		}

		if ($prevSchedID == $value["SCHEDULE_ID"]) {
			$boxscore = "&nbsp;";
		}

		echo "<td valign=top class=$rowclass>" . $boxscore . "</td>";

		$HighPtsCount = $value["POINTS_COUNT"];
		$HighPtsPlayerID = $value["POINTS_PLAYERID"];
		$HighPtsPlayerName = $value["POINTS_NAME"];
		
		$HighRebCount = $value["REBOUNDS_COUNT"];
		$HighRebPlayerID = $value["REBOUNDS_PLAYERID"];
		$HighRebPlayerName = $value["REBOUNDS_NAME"];

		$HighPts = "<a href=viewplayer.php?playerID=$HighPtsPlayerID>$HighPtsPlayerName</a> $HighPtsCount";
		$HighRebs = "<a href=viewplayer.php?playerID=$HighRebPlayerID>$HighRebPlayerName</a> $HighRebCount";

		if ($prevSchedID == $value["SCHEDULE_ID"] & $prevHighPtsPlayerID == $HighPtsPlayerID) {
			$HighPts = "&nbsp;";
		}

		if ($prevSchedID == $value["SCHEDULE_ID"] & $prevHighRebPlayerID == $HighRebPlayerID) {
			$HighRebs = "&nbsp;";
		}

		echo "<td valign=top class=$rowclass> $HighPts </td>";
		echo "<td valign=top class=$rowclass> $HighRebs </td>";
		echo "</tr>";

		$prevSchedID = $value["SCHEDULE_ID"];
		$prevHighPtsPlayerID = $HighPtsPlayerID;
		$prevHighRebPlayerID = $HighRebPlayerID;
		$prevPlayedDate = $value["PLAYED_DATE"];

		$p_rowclass = $rowclass;
		$rowclass == "gSGRowEvenStatsGrid" ? $rowclass = "gSGRowOddStatsGrid" :	$rowclass = "gSGRowEvenStatsGrid";
	}

	echo "</table>";
}

function createTeamImageURL($teamID) {
	echo "<img border=0 src=\"../images/teams/" . trim($teamID) . "_logo.gif\">\n";
}

function loadGameStats($SCHEDULE_ID, $objGameStats, $objHomeTeamStats, $objAwayTeamStats) {

	include('config.php');

	global $playerLoadErrors;
	global $gameLoadErrors;

	if (trim($gameLoadErrors) <> "") {
		echo "<br>the files are incorrect : $gameLoadErrors<br>";
		return;
	}

	if (trim($playerLoadErrors) <> "") {
		echo "<br>players are missing from their teams:<br> $playerLoadErrors<br>";
		echo "<br><font color=red>this game cannot be loaded. Stats are invalid</a></font>";
		return;
	}


	$db1 = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	echo "<PRE>";
//	echo $SCHEDULE_ID;
	echo "<br><BR>";
//	print_r($objHomeTeamStats);
	echo "<br><BR>";
//	print_r($objAwayTeamStats);
	echo "<br><BR>";
//	print_r($objGameStats);
	echo "</PRE>";

//	$objGameStats["home"]->strTeam;
//	$objGameStats["away"]->strTeam;


	foreach ($objGameStats as $value) {
		$sql = "insert into gamestats values(" . 
		"\"" . $SCHEDULE_ID . "\""  . "," .
		"\"" . $value->strTeamID . "\""  . "," .
		"\"" . $value->strPoints . "\""  . "," .
		"\"" . $value->strBenchScoring . "\""  . "," .
		"\"" . $value->strFGA . "\""  . "," .
		"\"" . $value->strFGM . "\""  . "," .
		"\"" . $value->strFGP . "\""  . "," .
		"\"" . $value->str3PA . "\""  . "," .
		"\"" . $value->str3PM . "\""  . "," .
		"\"" . $value->str3PP . "\""  . "," .
		"\"" . $value->strFTA . "\""  . "," .
		"\"" . $value->strFTM . "\""  . "," .
		"\"" . $value->strFTP . "\""  . "," .
		"\"" . $value->strReb . "\""  . "," .
		"\"" . $value->strOReb . "\""  . "," .
		"\"" . $value->strDReb . "\""  . "," .
		"\"" . $value->strBlocks . "\""  . "," .
		"\"" . $value->strSteals . "\""  . "," .
		"\"" . $value->strAssists . "\""  . "," .
		"\"" . $value->strTO . "\""  . "," .
		"\"" . $value->strFouls . "\"" . ");"	;



		if ( !($result = $db1->sql_query($sql)) )
		{
			echo "<br><font color=red>game stats loading has failed (probably already there)</font><br>";
		} else {
		
			echo "<br>game stats loading complete<br>";
		}
	}



	$AWAY_SCORE = $objGameStats["away"]->strPoints;
	$HOME_SCORE = $objGameStats["home"]->strPoints;

	$currentTime = mktime();

	$PLAYED_DATE = date('Y-m-d',$currentTime);
	$PLAYED_TIME = date('Gi',$currentTime);
	echo $PLAYED_DATE . " " . $PLAYED_TIME;
	
	$FORFEIT = "NULL";
	if ($HOME_SCORE == 0 && $AWAY_SCORE == 1) {
		$FORFEIT = $objGameStats["home"]->strTeamID;
	} else if ($AWAY_SCORE == 0 && $HOME_SCORE == 1) {
		$FORFEIT = $objGameStats["away"]->strTeamID;
	}
	

	foreach ($objHomeTeamStats as $value) {
		$sql = "insert into playerstats values(" . 
		"\"" . $SCHEDULE_ID . "\""  . "," .
		"\"" . $value->strTeamID . "\""  . "," .
		"\"" . $value->strPlayerID . "\""  . "," .
		"\"" . $value->strRosterPos . "\""  . "," .
		"\"" . $value->strPts . "\""  . "," .
		"\"" . $value->strMins . "\""  . "," .
		"\"" . $value->strFGA . "\""  . "," .
		"\"" . $value->strFGM . "\""  . "," .
		"\"" . $value->strFGP . "\""  . "," .
		"\"" . $value->str3PA . "\""  . "," .
		"\"" . $value->str3PM . "\""  . "," .
		"\"" . $value->str3PP . "\""  . "," .
		"\"" . $value->strFTA . "\""  . "," .
		"\"" . $value->strFTM . "\""  . "," .
		"\"" . $value->strFTP . "\""  . "," .
		"\"" . $value->strOReb . "\""  . "," .
		"\"" . $value->strDReb . "\""  . "," .
		"\"" . $value->strRebs . "\""  . "," .
		"\"" . $value->strBlk . "\""  . "," .
		"\"" . $value->strStl . "\""  . "," .
		"\"" . $value->strAst . "\""  . "," .
		"\"" . $value->strTO . "\""  . "," .
		"\"" . $value->strFouls . "\"" . "," . 
		"\"" . $value->strPlayed . "\"" . ");"	;

		if ( !($result = $db1->sql_query($sql)) ) {
			echo "<br><font color=red>home team player stats failed loading $value->strPlayerID $value->strName (probably already there)</font><br>";
//			print_r($value);
		} else {
			echo "<br><font color=green>home player stats loaded $value->strPlayerID $value->strName</font><br>";
		}
	}

	$totalMins = 0;

	foreach ($objAwayTeamStats as $value) {
		
		$totalMins += $value->strMins;
	
		$sql = "insert into playerstats values(" . 
		"\"" . $SCHEDULE_ID . "\""  . "," .
		"\"" . $value->strTeamID . "\""  . "," .
		"\"" . $value->strPlayerID . "\""  . "," .
		"\"" . $value->strRosterPos . "\""  . "," .
		"\"" . $value->strPts . "\""  . "," .
		"\"" . $value->strMins . "\""  . "," .
		"\"" . $value->strFGA . "\""  . "," .
		"\"" . $value->strFGM . "\""  . "," .
		"\"" . $value->strFGP . "\""  . "," .
		"\"" . $value->str3PA . "\""  . "," .
		"\"" . $value->str3PM . "\""  . "," .
		"\"" . $value->str3PP . "\""  . "," .
		"\"" . $value->strFTA . "\""  . "," .
		"\"" . $value->strFTM . "\""  . "," .
		"\"" . $value->strFTP . "\""  . "," .
		"\"" . $value->strOReb . "\""  . "," .
		"\"" . $value->strDReb . "\""  . "," .
		"\"" . $value->strRebs . "\""  . "," .
		"\"" . $value->strBlk . "\""  . "," .
		"\"" . $value->strStl . "\""  . "," .
		"\"" . $value->strAst . "\""  . "," .
		"\"" . $value->strTO . "\""  . "," .
		"\"" . $value->strFouls . "\"" . "," . 
		"\"" . $value->strPlayed . "\"" . ");"	;
		
		if ( !($result = $db1->sql_query($sql)) ) {
			echo "<br><font color=red>away player stats failed loading $value->strPlayerID $value->strName (probably already there)</font><br>";
		} else {
			echo "<br><font color=green>away player stats loaded $value->strPlayerID $value->strName</font><br>";
		}

	}

	if ($totalMins <= 160 & $totalMins >= 150) {
		$totalMins = 160;
	}

	$totalMinsRem = $totalMins % 160;
	
	$totalMinsRem = $totalMinsRem / 25;
	
	$OVERTIME = round($totalMinsRem - 0.45);

	$sql = "update schedule set HOME_SCORE = \"$HOME_SCORE\"
			,AWAY_SCORE = \"$AWAY_SCORE\"
			,PLAYED = \"1\" 
			,PLAYED_DATE = \"$PLAYED_DATE\" 
			,PLAYED_TIME = \"$PLAYED_TIME\" 
			,FORFEIT = $FORFEIT
			,OVERTIME = $OVERTIME

			where SCHEDULE_ID = $SCHEDULE_ID;";

//	echo $sql;

	if ( !($result = $db1->sql_query($sql)) ) {
		echo "<br><font color=red>schedule update has failed (probably already there)</font><br>";
	} else {

		echo "<br>schedule update complete<br>";
	}
	
	
}

function getPlayerID($playerName, $teamID, $playerNumber) {
	include('config.php');

	global $playerLoadErrors;

//	echo "<pre>";
//	echo "player : $playerName\n";
//	echo "team : $teamID\n";
//	echo "player number: $playerNumber \n\n";

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "SELECT PLAYERID, ROSTERPOS FROM players WHERE NUMBER = $playerNumber and team = $teamID AND CONCAT( substring( fname, 1, 1 ) , '. ', name ) = \"$playerName\"";
//	$sql = "SELECT PLAYERID FROM players WHERE team < 29 and CONCAT( substring( fname, 1, 1 ) , '. ', name ) = \"$playerName\"";

//echo $sql;

	if ( !($result = $db->sql_query($sql)) )
	{
		
	}

	$row = $db->sql_fetchrow($result);
	
//	print_r($row);
	
	$playerID = $row["PLAYERID"];
	$rosterPos = $row["ROSTERPOS"];

	if ($row["PLAYERID"] == "") {
		$playerID = 99999; 
		$playerLoadErrors .= "<br><b><font color=red>$playerName</font></b>";
	}
	return (array($playerID,$rosterPos));
}


function createScheduleTeamDropDown() {

	echo "<br>";
	echo "<SELECT style=\"width:120px;font:10px verdana, arial, sans-serif;text-decoration:none;background-color:#cccccc;\" name=url onchange=\"javascript:if( options[selectedIndex].value != 'Schedules') document.location = options[selectedIndex].value\">";
	echo "<OPTION selected>Teams</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=\">Full Schedule</option>";
//	echo "<OPTION value=\"viewfullschedule.php?teamID=playoffs1\">Playoffs Round 1</option>";
//	echo "<OPTION value=\"viewfullschedule.php?teamID=playoffs2\">Playoffs Round 2</option>";
//	echo "<OPTION value=\"viewfullschedule.php?teamID=playoffs3\">Playoffs Round 3</option>";
//	echo "<OPTION value=\"viewfullschedule.php?teamID=playoffs4\">Playoffs Round 4</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=0\">Atlanta</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=1\">Boston</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=2\">Chicago</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=3\">Cleveland</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=4\">Dallas</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=5\">Denver</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=6\">Detroit</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=7\">Golden State</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=8\">Houston</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=9\">Indiana</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=10\">LA Clippers</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=11\">LA Lakers</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=12\">Memphis</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=13\">Miami</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=14\">Milwaukee</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=15\">Minnesota</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=16\">New Jersey</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=17\">New Orleans</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=18\">New York</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=19\">Orlando</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=20\">Philadelphia</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=21\">Phoenix</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=22\">Portland</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=23\">Sacramento</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=24\">San Antonio</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=25\">Seattle</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=26\">Toronto</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=27\">Utah</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=28\">Washington</option>";
	echo "<OPTION value=\"viewfullschedule.php?teamID=Season0304\">Season 03-04</option>";
	echo "</select>";
	echo "</form>";
}



?>




