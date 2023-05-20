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


	include('../config.php');
	include('../mysql.php');

//echo "<pre>";

function createScheduleArray($numRounds, $numTeams) {
	$s = array();

	if ($numRounds < 1) {
		$numRounds = 1;
	}

	for ($i = 0; $i < $numRounds; $i++) {
		$s = array_merge($s, createRoundRobin($numTeams));
	}
	return($s);
}


function createRoundRobin($n) {

	// if the number of teams aren't even, then even them up (ie the next highest even number by adding 1)
	if ($n % 2 != 0) {
		$n = $n + 1;
	}

	for ($r = 0; $r < $n - 1; $r++) {
		$s[$r][0] = 0 ;
		for ($i = 1; $i < $n; $i++) {
			$s[$r][$i] = (($r + $i - 1) % ( $n - 1) + 1);
		}
	}

	return ($s);
}


function createSchedule($numRounds, $numTeams) {

	$r = 0;
	$roundNum = 1;

	if ($numTeams % 2 != 0) {
		$n = $numTeams;
		$rounds = ($numTeams) * $numRounds;
	} else {
		$n = $numTeams - 1 ;
		$rounds = ($numTeams - 1) * $numRounds;
	}


	$schedule = createScheduleArray($numRounds,$numTeams);

	$scheduleArray[] = Array();

	for ($r = 0; $r < $rounds; $r++)
	{
		if (($r)  % ($numTeams - 1) == 0) {
			$roundNum++ ;
		}

//		echo $r . "\t";

		for ($i = 0; $i < $n / 2  ; $i++) {
			if ($n % 2 != 0) {
//				echo $schedule[$r][$i]  . ":" . $schedule[$r][$n - $i ] . "\t";
				$awayteam = $schedule[$r][$i];
				$hometeam = $schedule[$r][$n - $i];
			} else {
//				echo $schedule[$r][$i]  . ":" . $schedule[$r][$n - $i - 1] . "\t";
				$awayteam = $schedule[$r][$i];
				$hometeam = $schedule[$r][($n - $i) - 1];
			}

//			echo $rows[$awayteam]["TEAMNAME"] . ":" . $rows[$hometeam]["TEAMNAME"] . "\t\t\t";
//			echo $awayteam  . ":" . $hometeam . "\t";


			// switch the home/away teams around each time they play...
			if ($roundNum % 2 != 0) {
				$temp = $awayteam;
				$awayteam = $hometeam;
				$hometeam = $temp;
			}


			if (($numTeams % 2 != 0) & $awayteam != $numTeams & $hometeam != $numTeams) {
				$scheduleArray[$r][$i] = $awayteam . ":" . $hometeam;
			} else if ($numTeams % 2 == 0 ) {
				$scheduleArray[$r][$i] = $awayteam . ":" . $hometeam;
			}
     	}

    	echo "<br>";
	}

	return($scheduleArray);
}


function assignTeamsToSchedule($schedule, $teams, $prefix) {

	$i = 0;
	$r = 0;
	$scheduleInserts = array();

	foreach ($schedule as $roundNumber) {
		foreach ($roundNumber as $matchUp) {
			//echo $matchUp . "\n";
			$a = explode(":", $matchUp);

//			echo $teams[$a[0]]["TEAMNUM"] . " @ " . $teams[$a[1]]["TEAMNUM"] . "\n";

//			$scheduleInserts[$prefix . $r][$i] = "insert into schedule (HOME_TEAM, AWAY_TEAM, GAME_TYPE) values (\"" . $teams[$a[0]]["TEAMNUM"] . "\",\"" . $teams[$a[1]]["TEAMNUM"] . "\",\"0\");";

			$scheduleInserts[$prefix . $r][$i] = $teams[$a[0]]["TEAMNUM"] . ":" . $teams[$a[1]]["TEAMNUM"];

			$i++;
		}
		$r++;
		$i = 0;
	}

	return($scheduleInserts);
}



//print_r(createSchedule(2,6));




function scheduleDivision($play_count) {
	include("config.php");

	$insertStatement = array();

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$division = array("0","1","2","3");

	foreach ($division as $div) {
		$sql = "select * from teams where division = $div and teamnum < 29 ORDER BY RAND() ";
		$result = $db->sql_query($sql);
		$rowset = $db->sql_fetchrowset($result);

		$rowCount = $db->sql_numrows($result);

	//	print_r(createSchedule(1,$rowCount));

		$insertStatement = array_merge_recursive($insertStatement, assignTeamsToSchedule(createSchedule($play_count,$rowCount),$rowset, "D"));
	}

	return($insertStatement);
}

function scheduleConference($play_count) {
	include("config.php");

	$insertStatement = array();

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$conference = array("0","1");

	foreach ($conference as $conf) {
		$sql = "select * from teams where conference = $conf and teamnum < 29 ORDER BY RAND() ";
		$result = $db->sql_query($sql);
		$rowset = $db->sql_fetchrowset($result);

		$rowCount = $db->sql_numrows($result);

	//	print_r(createSchedule(1,$rowCount));

		$insertStatement = array_merge_recursive($insertStatement, assignTeamsToSchedule(createSchedule($play_count,$rowCount),$rowset, "C"));
	}

	return($insertStatement);
}

function scheduleLeague($play_count) {
	include("config.php");

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);


	$sql = "select * from teams where teamnum < 29 ORDER BY RAND() ";
	$result = $db->sql_query($sql);
	$rowset = $db->sql_fetchrowset($result);

	$rowCount = $db->sql_numrows($result);

//	print_r(createSchedule(1,$rowCount));


	$insertStatement = assignTeamsToSchedule(createSchedule($play_count,$rowCount),$rowset, "L");
	return($insertStatement);
}



/***************************************************************************/
/*	Function CreateInsertStatements
/***************************************************************************/


function CreateDatedSchedule($LeagueSchedule, $StartDate, $DaysBetweenRounds, $GamesPerRound) {
	$NewLeagueSchedule = array();
	$arrRoundLeagueSchedule = array();

	$totalRounds = count($LeagueSchedule);
	$RoundDate = strtotime($StartDate);
	$totalRoundNumber = 0;
	$newRoundNumber = 0;

	$RoundDate = strtotime(date('Y-m-d',$RoundDate) . " + $DaysBetweenRounds day");

	for ($i = 0; $i < $totalRounds; $i) {
		$arrRoundLeagueSchedule = array();

//		echo "Round $newRoundNumber : ";
//		echo date('Y-m-d',$RoundDate);
//		echo "\n";
		$FormattedRoundDate = date('Y-m-d',$RoundDate);


		$RoundDate = strtotime(date('Y-m-d',$RoundDate) . " + $DaysBetweenRounds day");

		for ($gamesPerRoundCounter = 0; $gamesPerRoundCounter < $GamesPerRound; $gamesPerRoundCounter++) {
			if ($i < $totalRounds) {
//				echo $totalRoundNumber . "-" . $gamesPerRoundCounter . "<br>";

				 $arrRoundLeagueSchedule = array_merge_recursive($arrRoundLeagueSchedule, CreateInsertStatements($LeagueSchedule[$totalRoundNumber], $FormattedRoundDate, $newRoundNumber));

			}
			$NewLeagueSchedule[$newRoundNumber] = $arrRoundLeagueSchedule;
			$i++;
			$totalRoundNumber++;
		}
		$newRoundNumber++;
		echo "<BR>";

	}

//	print_r($NewLeagueSchedule);
	return($NewLeagueSchedule);
}

function CreateInsertStatements($arrRound, $roundDate, $roundNumber) {
	$i = 0;
	$roundNumber++;

	$arrInsertStatement = array();

	foreach ($arrRound as $matchUp) {
		$a = explode(":", $matchUp);

		$arrInsertStatement[$i] = "insert into schedule (GAME_DATE, HOME_TEAM, AWAY_TEAM, GAME_TYPE, ROUND_NUM) values (\"$roundDate\",\"" . $a[0] . "\",\"" . $a[1] . "\",\"0\",\"$roundNumber\");";
		$i++;
	}

	return($arrInsertStatement);
}


function CreateRegularSeason($SeasonStartDate, $DaysBetweenRounds, $GamesPerRound, $division, $conference, $league) {
	include("config.php");
	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$LeagueSchedule = array();




	if ($conference > 0) {

		$LeagueSchedule = scheduleConference($conference);
	}

	if ($division > 0) {
		$LeagueSchedule = array_merge($LeagueSchedule, scheduleDivision($division));
	}

	if ($league > 0) {
		$LeagueSchedule = array_merge($LeagueSchedule, scheduleLeague($league));
	}


	$LeagueSchedule = array_values($LeagueSchedule);

	shuffle($LeagueSchedule);
	shuffle($LeagueSchedule);
	shuffle($LeagueSchedule);
	shuffle($LeagueSchedule);
	shuffle($LeagueSchedule);

//	print_r($LeagueSchedule);


	$LeagueSchedule = CreateDatedSchedule($LeagueSchedule, $SeasonStartDate, $DaysBetweenRounds, $GamesPerRound);

//	print_r($LeagueSchedule);

//	$sql = "TRUNCATE schedule ";
//	if ( !($result = $db->sql_query($sql)) ) {
//		echo "<br>failed";
//	}

//	foreach ($LeagueSchedule as $insertStatement) {
//		foreach ($insertStatement as $sql) {
//			if ( !($result = $db->sql_query($sql)) ) {
//				$errorMsg = $db->sql_error($result);
//				print_r($errorMsg);
//			}
//		}
//	}

//	$sql = "update schedule set played = 1, home_score = 100, away_score = 50";
//	if ( !($result = $db->sql_query($sql)) ) {
//		echo "<br>failed";
//	}


}


	$seasonStartDate = '2004-04-26';
	$daysBetweenRounds = 14;
	$gamesPerRound = 5;
	$intraDivisionGames = 0;
	$intraConferenceGames = 0;
	$intraLeagueGames = 1;

	CreateRegularSeason($seasonStartDate, $daysBetweenRounds, $gamesPerRound, $intraDivisionGames, $intraConferenceGames, $intraLeagueGames);

//	echo $seasonStartDate;

?>