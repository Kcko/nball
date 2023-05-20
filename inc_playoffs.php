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

function westernConference($var) {
	return($var["CONFERENCE_NAME"] == "Western");
}

function easternConference($var) {
	return($var["CONFERENCE_NAME"] == "Eastern");
}

function pacificDivision($var) {
	return($var["DIVISION_NAME"] == "Pacific");
}

function midwestDivision($var) {
	return($var["DIVISION_NAME"] == "Midwest");
}

function centralDivision($var) {
	return($var["DIVISION_NAME"] == "Central");
}

function atlanticDivision($var) {
	return($var["DIVISION_NAME"] == "Atlantic");
}

function buildEasternSeeds($rowset) {
	$easternConf = array_slice((array_filter($rowset, "easternConference")),0,8);
	$easternConfAtlantic = array_filter($easternConf, "atlanticDivision");
	$easternConfCentral = array_filter($easternConf, "centralDivision");

	$eastSeed[] = current($easternConf);
	unset($easternConf[0]);


	if (array_slice($easternConfAtlantic,0,1) == $eastSeed) {
		$eastSeed[] = current(array_slice($easternConfCentral,0,1));
		unset($easternConf[current(array_keys($easternConfCentral))]);

	} else {
		$eastSeed[] = current(array_slice($easternConfAtlantic,0,1));
		//current(array_keys($easternConfAtlantic));
		unset($easternConf[current(array_keys($easternConfAtlantic))]);	
	}

	foreach ($easternConf as $team) {
		$eastSeed[] = $team;
	}

	return($eastSeed);
}

function buildWesternSeeds($rowset) {
	$westernConf = array_slice((array_filter($rowset, "westernConference")),0,8);
	$westernConfPacific = array_filter($westernConf, "pacificDivision");
	$westernConfMidwest = array_filter($westernConf, "midwestDivision");

	$westSeed[] = current($westernConf);
	unset($westernConf[0]);

	if (array_slice($westernConfPacific,0,1) == $westSeed) {
		$westSeed[] = current(array_slice($westernConfMidwest,0,1));
		unset($westernConf[current(array_keys($westernConfMidwest))]);

	} else {
		$westSeed[] = current(array_slice($westernConfPacific,0,1));
		//current(array_keys($easternConfAtlantic));
		unset($westernConf[current(array_keys($westernConfPacific))]);	
	}

	foreach ($westernConf as $team) {
		$westSeed[] = $team;
	}

	return($westSeed);
}



function createDivisionStandings($division) {
	$c_division_name = "";

	$i = 1;
	foreach ($division as $team ) {
		
		if ($team["CONFERENCE_NAME"] != $c_division_name) {

			echo "<table border=0 cellpadding=0 cellspacing=0 class=gSGTableStandings width=100%>";
			echo "<tr class=gSGSectionColumnHeadingsStandings>";
			echo "<td NOWRAP align=left width=100 class=gSGSectionColumnHeadingsStandings><b>&nbsp;" . $team["CONFERENCE_NAME"] . "</b></td>";
			echo "<td NOWRAP align=right width=30 class=gSGSectionColumnHeadingsStandings><b>W</b></td>";
			echo "<td NOWRAP align=right width=30 class=gSGSectionColumnHeadingsStandings><b>L</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>%</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>HW</b></td>";
//			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>HL</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>RW</b></td>";
//			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>RL</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>PF</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>PA</b></td>";
			echo "<td NOWRAP align=right width=50 class=gSGSectionColumnHeadingsStandings><b>%</b></td>";
			echo "<td NOWRAP align=right width=5 class=gSGSectionColumnHeadingsStandings><b> </b></td>";
			echo "</tr>";

			
			$c_division_name = $team["CONFERENCE_NAME"];

		}


		$win_percent = sprintf("%01.3f", $team["WIN_PERCENT"]);
		$win_perc    = sprintf("%01.2f", $team["WIN_PERC"]);

		$i <= 8 ? $rowClass = "gSGRowOddStatsGrid" : $rowClass = "gSGRowEvenStatsGrid" ;
		
		echo "<tr>";
		echo "<td class=$rowClass align=left> &nbsp;<a href=viewteam.php?teamID=" . $team["TEAMNUM"] .">" .  $team["CITYNAME"] . " " . $team["TEAMNAME"] . "</a></td>";
		echo "<td class=$rowClass align=right> " . $team["TOTAL_WIN"] ."</td>";
		echo "<td class=$rowClass align=right> " . $team["TOTAL_LOSS"] ."</td>";
		echo "<td class=$rowClass align=right> " . $win_percent ."</td>";
		echo "<td class=$rowClass align=right> " . $team["HOME_WIN"] ."</td>";
//		echo "<td class=$rowClass align=right> " . $team["HOME_LOSS"] ."</td>";
		echo "<td class=$rowClass align=right> " . $team["AWAY_WIN"] ."</td>";
//		echo "<td class=$rowClass align=right> " . $team["AWAY_LOSS"] ."</td>";
		echo "<td class=$rowClass align=right> " . $team["POINTS_FOR"] ."</td>";
		echo "<td class=$rowClass align=right> " . $team["POINTS_AGAINST"] ."</td>";
		echo "<td class=$rowClass align=right> " . $win_perc ."</td>";
		echo "<td class=$rowClass align=right> </td></tr>";


		if ($team["CONFERENCE_NAME"] != $c_division_name) {
			echo "</table>";
		}
		$i++;
	}


}



function createStandingsSQL($conference) {


$sql = "

select	 teams.TEAMNUM
		,teams.CITYNAME2 as TEAMNAME
		,teams.CITYNAME
		,conference.CONFERENCE_NAME
		,division.DIVISION_NAME
		,coalesce(HOME_WIN,0) as HOME_WIN
		,coalesce(AWAY_WIN,0) as AWAY_WIN
		,coalesce(HOME_WIN,0) + coalesce(AWAY_WIN,0) as TOTAL_WIN
		,coalesce(HOME_LOSS,0) as HOME_LOSS
		,coalesce(AWAY_LOSS,0) as AWAY_LOSS
		,coalesce(HOME_LOSS,0) + coalesce(AWAY_LOSS,0) as TOTAL_LOSS
		,coalesce(((coalesce(HOME_WIN  + 0.00,0.00)  + coalesce(AWAY_WIN + 0.00,0.00) ) / (coalesce(HOME_LOSS + 0.00,0.00) + coalesce(AWAY_LOSS + 0.00,0.00) + coalesce(HOME_WIN + 0.00,0.00) + coalesce(AWAY_WIN + 0.00,0.00))) + 0.00,0.00) as WIN_PERCENT 
		,coalesce(HOME_TEAM_HOME_POINTs,0) + coalesce(AWAY_TEAM_AWAY_POINTs,0) as POINTS_FOR
		,coalesce(HOME_TEAM_AWAY_POINTs,0) + coalesce(AWAY_TEAM_HOME_POINTs,0) as POINTS_AGAINST
		,coalesce((((coalesce(HOME_TEAM_HOME_POINTs + 0.00,0.00) + coalesce(AWAY_TEAM_AWAY_POINTs + 0.00,0.00)) / (coalesce(HOME_TEAM_AWAY_POINTs + 0.00,0.00) + coalesce(AWAY_TEAM_HOME_POINTs + 0.00,0.00))) ) + 0.00,0.00) as WIN_PERC

	
	from teams
	inner join conference
	on conference.conference = teams.conference
	inner join division
	on division.division = teams.division
	
	left join
	(select   home_team
		,sum(case when home_score > away_score then '1' else '0' end) as HOME_WIN
		,sum(case when home_score < away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as HOME_LOSS
		,sum(away_score) as HOME_TEAM_AWAY_POINTs
		,sum(home_score) as HOME_TEAM_HOME_POINTs

	from schedule where played = 1 group by 1) as home_game
	on home_game.home_team = teamnum
	

	left join
	(select   away_team
		,sum(case when home_score < away_score then '1' else '0' end) as AWAY_WIN
		,sum(case when home_score > away_score or (home_score = 0 and away_score = 0) then '1' else '0' end) as AWAY_LOSS
		,sum(away_score) as AWAY_TEAM_AWAY_POINTs
		,sum(home_score) as AWAY_TEAM_HOME_POINTs
	

	from schedule where played = 1 group by 1) as away_game
	on away_game.away_team = teamnum
	
	where teamnum < 29
	and teams.conference = " . $conference . " 

order by win_percent desc, WIN_PERC desc, total_win desc, teamnum
";

return ($sql);

}

function createPlayoffsRound1($PlayOffSeeds, $rowsetR1, $bgColor, $seasonID) {
	$highSeed = 0;
	$lowSeed = 7;

	include("config.php");
	include("mysql.php");

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);	

//	print_r($rowsetR1);
	$resultsRound1 = array();
	
	for ($i = 0; $i <= 3; $i++) {
		$highSeedNum  = $PlayOffSeeds[$highSeed]["TEAMNUM"];
		$highSeedName = $PlayOffSeeds[$highSeed]["TEAMNAME"];
		$highSeedRank = $highSeed + 1;
		
		$highSeedWin = $rowsetR1[$highSeedNum]["TOTAL_WIN"];
		$highSeedLoss = $rowsetR1[$highSeedNum]["TOTAL_LOSS"];

		$lowSeedNum  = $PlayOffSeeds[$lowSeed]["TEAMNUM"];
		$lowSeedName = $PlayOffSeeds[$lowSeed]["TEAMNAME"];
		$lowSeedRank = $lowSeed + 1;

		if ($highSeedWin == 2) {
			$PlayOffSeeds[$highSeed]["SEED"] = $highSeedRank;
			$PlayOffSeeds[$highSeed]["GAMEDIFF"] = $highSeedWin - $highSeedLoss;
			$resultsRound1[$highSeedRank] = $PlayOffSeeds[$highSeed];

		} else if ($highSeedLoss == 2) {
			$PlayOffSeeds[$lowSeed]["SEED"] = $lowSeedRank;
			$PlayOffSeeds[$lowSeed]["GAMEDIFF"] = $highSeedLoss - $highSeedWin ;
			$resultsRound1[$lowSeedRank] = $PlayOffSeeds[$lowSeed];
		} 

		$gameResults = "&nbsp;";
		$boxScore = "";

		if ($highSeedWin > 0 or $highSeedLoss > 0) {

			$sql = "SELECT	 SH.SCHEDULE_ID as SCHEDULE_ID 
						,TH.CITYNAME2 as HOME_TEAMNAME
						,TH.TEAMNUM as HOME_TEAMNUM
						,TA.CITYNAME2 as AWAY_TEAMNAME
						,TA.TEAMNUM as AWAY_TEAMNUM
						,SH.HOME_SCORE as HOME_SCORE
						,SH.AWAY_SCORE as AWAY_SCORE
						,SH.FORFEIT AS FORFEIT
					FROM	schedule SH
					INNER JOIN teams TH
					ON SH.HOME_TEAM = TH.TEAMNUM
					INNER JOIN teams TA
					ON SH.AWAY_TEAM = TA.TEAMNUM
					WHERE (TH.TEAMNUM = $highSeedNum or TA.TEAMNUM = $highSeedNum)
					AND PLAYED = 1
					and GAME_TYPE = 1

					AND SCHEDULE_ID IN (
								SELECT SCHEDULE_ID 
								FROM SCHEDULE SH
								INNER JOIN SEASON SE
								ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
								AND SE.SEASON_ID = $seasonID
					)
					
					order by SCHEDULE_ID, GAME_DATE";

			$result = $db->sql_query($sql);
			$rowsetMatches = $db->sql_fetchrowset($result);
//		echo $sql;

//			print_r($rowsetMatches);

			foreach ($rowsetMatches as $value) {
				$boxScore = $value["AWAY_TEAMNAME"] . " " . $value["AWAY_SCORE"] . " @ " . $value["HOME_SCORE"] . " " . $value["HOME_TEAMNAME"];

				if ($value["FORFEIT"] != 0) {
					switch ($value["FORFEIT"]) {
						case $value["HOME_TEAMNUM"] :
							$boxScore = "Forfeit " . $value["HOME_TEAMNAME"];
							break;
						case $value["AWAY_TEAMNUM"] :
							$boxScore = "Forfeit " . $value["AWAY_TEAMNAME"];
							break;
					}

					$gameResults = $gameResults . "<a>$boxScore</a><br>";
				
				} else {
					$gameResults = $gameResults . "<a href=viewboxscore.php?scheduleID=". $value["SCHEDULE_ID"] .">$boxScore</a><br>";
				}
			}
		}

		echo "
			<TABLE cellSpacing=0 cellPadding=0 width=300 border=0>
			  <TBODY>
				<TR>
				  <TD bgColor=$bgColor colSpan=3 height=1><IMG height=1 src=blank.gif></TD>
				</TR>
				<TR>
				  <TD width=1 bgColor=$bgColor><IMG src=blank.gif width=1></TD>
				  <TD width=298> <TABLE cellSpacing=0 cellPadding=0 width=298 border=0>
					  <TBODY>
						<TR>
						  <TD bgcolor=$bgColor valign=top width=42 rowSpan=3><A href=viewteam.php?teamID=$highSeedNum><IMG src=images/playoffs_teamlogo_$highSeedNum.gif border=0></A></TD>
						  <TD valign=top width=214 bgColor=$bgColor> <DIV class=confHeader align=center>($highSeedRank) $highSeedName vs. ($lowSeedRank) $lowSeedName</DIV></TD>
						  <TD bgcolor=$bgColor valign=top width=42 rowSpan=3><A href=viewteam.php?teamID=$lowSeedNum><IMG src=images/playoffs_teamlogo_$lowSeedNum.gif border=0></A></TD>
						</TR>
						<TR>
						  <TD bgColor=#eeeeee> <DIV class=confTextWest align=center><a><b>$highSeedName $highSeedWin, $lowSeedName $highSeedLoss</b></a></DIV></TD>
						</TR>
						<TR>
						  <TD bgColor=#ffffff> <DIV class=confTextWest align=center>$gameResults</DIV></TD>
						</TR>
					  </TBODY>
					</TABLE></TD>
				  <TD width=1 bgColor=$bgColor><IMG src=blank.gif width=1></TD>
				<TR>
				  <TD bgColor=$bgColor colSpan=3 height=1><IMG height=1 src=blank.gif></TD>
				</TR>
				<TR>
				  <TD colSpan=3 height=5><IMG height=5 src=blank.gif></TD>
				</TR>
			  </TBODY>
			</TABLE>";
    
		$highSeed++;
		$lowSeed--;
	}
	
	return($resultsRound1);
}


function createPlayoffsRound2($PlayOffSeeds, $rowsetR2, $bgColor, $seasonID) {
//	print_r($PlayOffSeeds);

	include("config.php");
	include("mysql.php");
	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);	


	foreach($PlayOffSeeds as $team) {
	
		switch ($team["SEED"]) {
		//seeds 1,4,5,8
			case 1:	
				$Round2[0][0] = $team;
				break;
			case 8:
				$Round2[0][0] = $team;
				break;
			case 4:
				$Round2[0][1] = $team;
				break;
			case 5:
				$Round2[0][1] = $team;
				break;

		//seeds 2,3,6,7				
			case 2:
				$Round2[1][0] = $team;
				break;
			case 7:
				$Round2[1][0] = $team;
				break;
			case 3:
				$Round2[1][1] = $team;
				break;
			case 6:
				$Round2[1][1] = $team;
				break;
		}
	}
	
//	print_r($Round2);
	foreach ($Round2 as $Round2Matches) {
//	print_r($Round2Matches);

		if ($Round2Matches[0]["GAMEDIFF"] < $Round2Matches[1]["GAMEDIFF"]) {
		//	echo "team 2 won more";
				$tmp = $Round2Matches[0];
				$Round2Matches[0] = $Round2Matches[1];
				$Round2Matches[1] = $tmp;
				
		} else {
		//	echo "team 1 won more";

			if ($Round2Matches[0]["SEED"] > $Round2Matches[1]["SEED"]) {
				//echo "team 1 is a higher seed";
				$tmp = $Round2Matches[0];
				$Round2Matches[0] = $Round2Matches[1];
				$Round2Matches[1] = $tmp;
			}
		}
		$Round2tmp[] = $Round2Matches;
	}

	$Round2 = $Round2tmp;
	foreach($Round2 as $PlayOffSeeds) {
		$highSeed = 0;
		$lowSeed = 1;

		$highSeedNum  = $PlayOffSeeds[$highSeed]["TEAMNUM"];
		$highSeedName = $PlayOffSeeds[$highSeed]["TEAMNAME"];
		$highSeedRank = $PlayOffSeeds[$highSeed]["SEED"];
//		$highSeedImage = "<IMG src=images/playoffs_teamlogo_$highSeedNum.gif border=0>";
		$highSeedNum != "" ? $highSeedImage = "<A href=viewteam.php?teamID=$highSeedNum><IMG src=images/playoffs_teamlogo_$highSeedNum.gif border=0></A>" : $highSeedImage = "&nbsp;";

		$highSeedWin = $rowsetR2[$highSeedNum]["TOTAL_WIN"];
		$highSeedLoss = $rowsetR2[$highSeedNum]["TOTAL_LOSS"];

		$lowSeedNum  = $PlayOffSeeds[$lowSeed]["TEAMNUM"];
		$lowSeedName = $PlayOffSeeds[$lowSeed]["TEAMNAME"];
		$lowSeedRank = $PlayOffSeeds[$lowSeed]["SEED"];
		$lowSeedNum != "" ? $lowSeedImage = "<A href=viewteam.php?teamID=$lowSeedNum><IMG src=images/playoffs_teamlogo_$lowSeedNum.gif border=0></A>" : $lowSeedImage = "&nbsp;";

		if ($highSeedWin == 2) {
			$PlayOffSeeds[$highSeed]["SEED"] = $highSeedRank;
			$PlayOffSeeds[$highSeed]["GAMEDIFF"] = $highSeedWin - $highSeedLoss;
			$resultsRound2[$highSeedRank] = $PlayOffSeeds[$highSeed];

		} else if ($highSeedLoss == 2) {
			$PlayOffSeeds[$lowSeed]["SEED"] = $lowSeedRank;
			$PlayOffSeeds[$lowSeed]["GAMEDIFF"] = $highSeedLoss - $highSeedWin ;
			$resultsRound2[$lowSeedRank] = $PlayOffSeeds[$lowSeed];
		} 

		$gameResults = "&nbsp;";
		$boxScore = "";

		if ($highSeedWin > 0 or $highSeedLoss > 0) {

			$sql = "SELECT	 SH.SCHEDULE_ID as SCHEDULE_ID 
						,TH.CITYNAME2 as HOME_TEAMNAME
						,TH.TEAMNUM as HOME_TEAMNUM
						,TA.CITYNAME2 as AWAY_TEAMNAME
						,TA.TEAMNUM as AWAY_TEAMNUM
						,SH.HOME_SCORE as HOME_SCORE
						,SH.AWAY_SCORE as AWAY_SCORE
						,SH.FORFEIT AS FORFEIT
					FROM	schedule SH
					INNER JOIN teams TH
					ON SH.HOME_TEAM = TH.TEAMNUM
					INNER JOIN teams TA
					ON SH.AWAY_TEAM = TA.TEAMNUM
					WHERE (TH.TEAMNUM = $highSeedNum or TA.TEAMNUM = $highSeedNum)
					AND PLAYED = 1
					and GAME_TYPE = 2

					AND SCHEDULE_ID IN (
								SELECT SCHEDULE_ID 
								FROM SCHEDULE SH
								INNER JOIN SEASON SE
								ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
								AND SE.SEASON_ID = $seasonID
					)

					order by SCHEDULE_ID, GAME_DATE";

			$result = $db->sql_query($sql);
			$rowsetMatches = $db->sql_fetchrowset($result);
//		echo $sql;
//	echo "<pre>";
//			print_r($rowsetMatches);

			foreach ($rowsetMatches as $value) {
				$boxScore = $value["AWAY_TEAMNAME"] . " " . $value["AWAY_SCORE"] . " @ " . $value["HOME_SCORE"] . " " . $value["HOME_TEAMNAME"];

				if ($value["FORFEIT"] != 0) {
					switch ($value["FORFEIT"]) {
						case $value["HOME_TEAMNUM"] :
							$boxScore = "Forfeit " . $value["HOME_TEAMNAME"];
							break;
						case $value["AWAY_TEAMNUM"] :
							$boxScore = "Forfeit " . $value["AWAY_TEAMNAME"];
							break;
					}

					$gameResults = $gameResults . "<a>$boxScore</a><br>";
				
				} else {
					$gameResults = $gameResults . "<a href=viewboxscore.php?scheduleID=". $value["SCHEDULE_ID"] .">$boxScore</a><br>";
				}
			}
		}



		

		echo "
			<TABLE cellSpacing=0 cellPadding=0 width=300 border=0>
			  <TBODY>
				<TR>
				  <TD bgColor=$bgColor colSpan=3 height=1><IMG height=1 src=blank.gif></TD>
				</TR>
				<TR>
				  <TD width=1 bgColor=$bgColor><IMG src=blank.gif width=1></TD>
				  <TD width=298> <TABLE cellSpacing=0 cellPadding=0 width=298 border=0>
					  <TBODY>
						<TR>
						  <TD bgcolor=$bgColor valign=top width=42 rowSpan=3>$highSeedImage</TD>
						  <TD width=214 bgColor=$bgColor> <DIV class=confHeader align=center>($highSeedRank) $highSeedName vs. ($lowSeedRank) $lowSeedName</DIV></TD>
						  <TD bgcolor=$bgColor valign=top width=42 rowSpan=3>$lowSeedImage</TD>
						</TR>
						<TR>
						  <TD bgColor=#eeeeee> <DIV class=confTextWest align=center><a><b>$highSeedName $highSeedWin, $lowSeedName $highSeedLoss</b></a></DIV></TD>
						</TR>
						<TR>
						  <TD bgColor=#ffffff> <DIV class=confTextWest align=center>$gameResults</DIV></TD>
						</TR>
					  </TBODY>
					</TABLE></TD>
				  <TD width=1 bgColor=$bgColor><IMG src=blank.gif width=1></TD>
				<TR>
				  <TD bgColor=$bgColor colSpan=3 height=1><IMG height=1 src=blank.gif></TD>
				</TR>
				<TR>
				  <TD colSpan=3 height=5><IMG height=5 src=blank.gif></TD>
				</TR>
			  </TBODY>
			</TABLE>";
	}

//	print_r($resultsRound2);

	return($resultsRound2);
}


function createPlayoffsRound3($PlayOffSeeds, $rowsetR3, $bgColor, $seasonID) {
//	print_r($PlayOffSeeds);
//	echo "<pre>";
//	print_r($rowsetR3);
	include("config.php");
	include("mysql.php");
	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);	


	foreach($PlayOffSeeds as $team) {
	
		switch ($team["SEED"]) {
		//seeds 1,4,5,8
			case 1:	
				$Round3[0][0] = $team;
				break;
			case 8:
				$Round3[0][0] = $team;
				break;
			case 4:
				$Round3[0][0] = $team;
				break;
			case 5:
				$Round3[0][0] = $team;
				break;

		//seeds 2,3,6,7				
			case 2:
				$Round3[0][1] = $team;
				break;
			case 7:
				$Round3[0][1] = $team;
				break;
			case 3:
				$Round3[0][1] = $team;
				break;
			case 6:
				$Round3[0][1] = $team;
				break;
		}
	}
	
//	print_r($Round3);
	foreach ($Round3 as $Round3Matches) {
//	print_r($Round3Matches);

		if ($Round3Matches[0]["GAMEDIFF"] < $Round3Matches[1]["GAMEDIFF"]) {
		//	echo "team 2 won more";
				$tmp = $Round3Matches[0];
				$Round3Matches[0] = $Round3Matches[1];
				$Round3Matches[1] = $tmp;
				
		} else {
		//	echo "team 1 won more";

			if ($Round3Matches[0]["SEED"] > $Round3Matches[1]["SEED"]) {
				//echo "team 1 is a higher seed";
				$tmp = $Round3Matches[0];
				$Round3Matches[0] = $Round3Matches[1];
				$Round3Matches[1] = $tmp;
			}
		}
		$Round3tmp[] = $Round3Matches;
	}

	$Round3 = $Round3tmp;
	foreach($Round3 as $PlayOffSeeds) {
		$highSeed = 0;
		$lowSeed = 1;

		$highSeedNum  = $PlayOffSeeds[$highSeed]["TEAMNUM"];
		$highSeedName = $PlayOffSeeds[$highSeed]["TEAMNAME"];
		$highSeedRank = $PlayOffSeeds[$highSeed]["SEED"];
//		$highSeedImage = "<IMG src=images/playoffs_teamlogo_$highSeedNum.gif border=0>";
		$highSeedNum != "" ? $highSeedImage = "<A href=viewteam.php?teamID=$highSeedNum><IMG src=images/playoffs_teamlogo_$highSeedNum.gif border=0></A>" : $highSeedImage = "&nbsp;";

		$highSeedWin = $rowsetR3[$highSeedNum]["TOTAL_WIN"];
		$highSeedLoss = $rowsetR3[$highSeedNum]["TOTAL_LOSS"];

		$lowSeedNum  = $PlayOffSeeds[$lowSeed]["TEAMNUM"];
		$lowSeedName = $PlayOffSeeds[$lowSeed]["TEAMNAME"];
		$lowSeedRank = $PlayOffSeeds[$lowSeed]["SEED"];
		$lowSeedNum != "" ? $lowSeedImage = "<A href=viewteam.php?teamID=$lowSeedNum><IMG src=images/playoffs_teamlogo_$lowSeedNum.gif border=0></A>" : $lowSeedImage = "&nbsp;";

		if ($highSeedWin == 2) {
			$PlayOffSeeds[$highSeed]["SEED"] = $highSeedRank;
			$PlayOffSeeds[$highSeed]["GAMEDIFF"] = $highSeedWin - $highSeedLoss;
			$resultsRound3[] = $PlayOffSeeds[$highSeed];

		} else if ($highSeedLoss == 2) {
			$PlayOffSeeds[$lowSeed]["SEED"] = $lowSeedRank;
			$PlayOffSeeds[$lowSeed]["GAMEDIFF"] = $highSeedLoss - $highSeedWin ;
			$resultsRound3[] = $PlayOffSeeds[$lowSeed];
		} 

		$gameResults = "&nbsp;";
		$boxScore = "";

		if ($highSeedWin > 0 or $highSeedLoss > 0) {

			$sql = "SELECT	 SH.SCHEDULE_ID as SCHEDULE_ID 
						,TH.CITYNAME2 as HOME_TEAMNAME
						,TH.TEAMNUM as HOME_TEAMNUM
						,TA.CITYNAME2 as AWAY_TEAMNAME
						,TA.TEAMNUM as AWAY_TEAMNUM
						,SH.HOME_SCORE as HOME_SCORE
						,SH.AWAY_SCORE as AWAY_SCORE
						,SH.FORFEIT AS FORFEIT
					FROM	schedule SH
					INNER JOIN teams TH
					ON SH.HOME_TEAM = TH.TEAMNUM
					
					INNER JOIN teams TA
					ON SH.AWAY_TEAM = TA.TEAMNUM
					WHERE (TH.TEAMNUM = $highSeedNum or TA.TEAMNUM = $highSeedNum)
					AND PLAYED = 1
					and GAME_TYPE = 3

					AND SCHEDULE_ID IN (
								SELECT SCHEDULE_ID 
								FROM SCHEDULE SH
								INNER JOIN SEASON SE
								ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
								AND SE.SEASON_ID = $seasonID
					)

					order by SCHEDULE_ID, GAME_DATE";

			$result = $db->sql_query($sql);
			$rowsetMatches = $db->sql_fetchrowset($result);
//		echo $sql;
//	echo "<pre>";
//			print_r($rowsetMatches);

			foreach ($rowsetMatches as $value) {
				$boxScore = $value["AWAY_TEAMNAME"] . " " . $value["AWAY_SCORE"] . " @ " . $value["HOME_SCORE"] . " " . $value["HOME_TEAMNAME"];

				if ($value["FORFEIT"] != 0) {
					switch ($value["FORFEIT"]) {
						case $value["HOME_TEAMNUM"] :
							$boxScore = "Forfeit " . $value["HOME_TEAMNAME"];
							break;
						case $value["AWAY_TEAMNUM"] :
							$boxScore = "Forfeit " . $value["AWAY_TEAMNAME"];
							break;
					}

					$gameResults = $gameResults . "<a>$boxScore</a><br>";
				
				} else {
					$gameResults = $gameResults . "<a href=viewboxscore.php?scheduleID=". $value["SCHEDULE_ID"] .">$boxScore</a><br>";
				}
			}
		}



		

		echo "
			<TABLE cellSpacing=0 cellPadding=0 width=300 border=0>
			  <TBODY>
				<TR>
				  <TD bgColor=$bgColor colSpan=3 height=1><IMG height=1 src=blank.gif></TD>
				</TR>
				<TR>
				  <TD width=1 bgColor=$bgColor><IMG src=blank.gif width=1></TD>
				  <TD width=298> <TABLE cellSpacing=0 cellPadding=0 width=298 border=0>
					  <TBODY>
						<TR>
						  <TD bgcolor=$bgColor valign=top width=42 rowSpan=3>$highSeedImage</TD>
						  <TD width=214 bgColor=$bgColor> <DIV class=confHeader align=center>($highSeedRank) $highSeedName vs. ($lowSeedRank) $lowSeedName</DIV></TD>
						  <TD bgcolor=$bgColor valign=top width=42 rowSpan=3>$lowSeedImage</TD>
						</TR>
						<TR>
						  <TD bgColor=#eeeeee> <DIV class=confTextWest align=center><a><b>$highSeedName $highSeedWin, $lowSeedName $highSeedLoss</b></a></DIV></TD>
						</TR>
						<TR>
						  <TD bgColor=#ffffff> <DIV class=confTextWest align=center>$gameResults</DIV></TD>
						</TR>
					  </TBODY>
					</TABLE></TD>
				  <TD width=1 bgColor=$bgColor><IMG src=blank.gif width=1></TD>
				<TR>
				  <TD bgColor=$bgColor colSpan=3 height=1><IMG height=1 src=blank.gif></TD>
				</TR>
				<TR>
				  <TD colSpan=3 height=5><IMG height=5 src=blank.gif></TD>
				</TR>
			  </TBODY>
			</TABLE>";
	}
	return($resultsRound3);
	
}











function createPlayoffsRound4($PlayOffSeeds1,$PlayOffSeeds2, $rowsetR4, $bgColor, $seasonID) {

	$PlayOffSeeds = array_merge($PlayOffSeeds1, $PlayOffSeeds2);
//	print_r($PlayOffSeeds);

//	print_r($rowsetR3);
	include("config.php");
	include("mysql.php");
	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);	


	foreach($PlayOffSeeds as $team) {
//		print_r($team);
//		echo $team["CONFERENCE_NAME"];
		switch ($team["CONFERENCE_NAME"]) {
		//seeds 1,4,5,8
			case "Western":	
				$Round4[0][0] = $team;
				break;
			case "Eastern":
				$Round4[0][1] = $team;
				break;
		}
	}
	
//	print_r($Round4);
	foreach ($Round4 as $Round4Matches) {
//	print_r($Round4Matches);

		if ($Round4Matches[0]["GAMEDIFF"] < $Round4Matches[1]["GAMEDIFF"]) {
			//echo "team 2 won more";
				$tmp = $Round4Matches[0];
				$Round4Matches[0] = $Round4Matches[1];
				$Round4Matches[1] = $tmp;
				
		} else {
			//echo "team 1 won more";

			if ($Round4Matches[0]["SEED"] > $Round4Matches[1]["SEED"]) {
				//echo "team 1 is a higher seed";
				$tmp = $Round4Matches[0];
				$Round4Matches[0] = $Round4Matches[1];
				$Round4Matches[1] = $tmp;
			}
		}
		$Round4tmp[] = $Round4Matches;
	}

	$Round4 = $Round4tmp;


	foreach($Round4 as $PlayOffSeeds) {
		$highSeed = 0;
		$lowSeed = 1;

		$highSeedNum  = $PlayOffSeeds[$highSeed]["TEAMNUM"];
		$highSeedName = $PlayOffSeeds[$highSeed]["TEAMNAME"];
		$highSeedRank = $PlayOffSeeds[$highSeed]["SEED"];
//		$highSeedImage = "<IMG src=images/playoffs_teamlogo_$highSeedNum.gif border=0>";
		$highSeedNum != "" ? $highSeedImage = "<A href=viewteam.php?teamID=$highSeedNum><IMG src=images/playoffs_teamlogo_$highSeedNum.gif border=0></A>" : $highSeedImage = "&nbsp;";

		$highSeedWin = $rowsetR4[$highSeedNum]["TOTAL_WIN"];
		$highSeedLoss = $rowsetR4[$highSeedNum]["TOTAL_LOSS"];

		$lowSeedNum  = $PlayOffSeeds[$lowSeed]["TEAMNUM"];
		$lowSeedName = $PlayOffSeeds[$lowSeed]["TEAMNAME"];
		$lowSeedRank = $PlayOffSeeds[$lowSeed]["SEED"];
		$lowSeedNum != "" ? $lowSeedImage = "<A href=viewteam.php?teamID=$lowSeedNum><IMG src=images/playoffs_teamlogo_$lowSeedNum.gif border=0></A>" : $lowSeedImage = "&nbsp;";

		if ($highSeedWin == 3) {
			$PlayOffSeeds[$highSeed]["SEED"] = $highSeedRank;
			$PlayOffSeeds[$highSeed]["GAMEDIFF"] = $highSeedWin - $highSeedLoss;
			$resultsRound4[$highSeedRank] = $PlayOffSeeds[$highSeed];

		} else if ($highSeedLoss == 3) {
			$PlayOffSeeds[$lowSeed]["SEED"] = $lowSeedRank;
			$PlayOffSeeds[$lowSeed]["GAMEDIFF"] = $highSeedLoss - $highSeedWin ;
			$resultsRound4[$lowSeedRank] = $PlayOffSeeds[$lowSeed];
		} 

		$gameResults = "&nbsp;";
		$boxScore = "";

		if ($highSeedWin > 0 or $highSeedLoss > 0) {

			$sql = "SELECT	 SH.SCHEDULE_ID as SCHEDULE_ID 
						,TH.CITYNAME2 as HOME_TEAMNAME
						,TH.TEAMNUM as HOME_TEAMNUM
						,TA.CITYNAME2 as AWAY_TEAMNAME
						,TA.TEAMNUM as AWAY_TEAMNUM
						,SH.HOME_SCORE as HOME_SCORE
						,SH.AWAY_SCORE as AWAY_SCORE
						,SH.FORFEIT AS FORFEIT
					FROM	schedule SH
					INNER JOIN teams TH
					ON SH.HOME_TEAM = TH.TEAMNUM
					INNER JOIN teams TA
					ON SH.AWAY_TEAM = TA.TEAMNUM
					WHERE (TH.TEAMNUM = $highSeedNum or TA.TEAMNUM = $highSeedNum)
					AND PLAYED = 1
					and GAME_TYPE = 4

					AND SCHEDULE_ID IN (
								SELECT SCHEDULE_ID 
								FROM SCHEDULE SH
								INNER JOIN SEASON SE
								ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
								AND SE.SEASON_ID = $seasonID
					)
					
					order by SCHEDULE_ID, GAME_DATE";

			$result = $db->sql_query($sql);
			$rowsetMatches = $db->sql_fetchrowset($result);
//		echo $sql;
//	echo "<pre>";
//			print_r($rowsetMatches);

			foreach ($rowsetMatches as $value) {
				$boxScore = $value["AWAY_TEAMNAME"] . " " . $value["AWAY_SCORE"] . " @ " . $value["HOME_SCORE"] . " " . $value["HOME_TEAMNAME"];

				if ($value["FORFEIT"] != 0) {
					switch ($value["FORFEIT"]) {
						case $value["HOME_TEAMNUM"] :
							$boxScore = "Forfeit " . $value["HOME_TEAMNAME"];
							break;
						case $value["AWAY_TEAMNUM"] :
							$boxScore = "Forfeit " . $value["AWAY_TEAMNAME"];
							break;
					}

					$gameResults = $gameResults . "<a>$boxScore</a><br>";
				
				} else {
					$gameResults = $gameResults . "<a href=viewboxscore.php?scheduleID=". $value["SCHEDULE_ID"] .">$boxScore</a><br>";
				}
			}
		}



		

		echo "
			<TABLE cellSpacing=0 cellPadding=0 width=300 border=0>
			  <TBODY>
				<TR>
				  <TD bgColor=$bgColor colSpan=3 height=1><IMG height=1 src=blank.gif></TD>
				</TR>
				<TR>
				  <TD width=1 bgColor=$bgColor><IMG src=blank.gif width=1></TD>
				  <TD width=298> <TABLE cellSpacing=0 cellPadding=0 width=298 border=0>
					  <TBODY>
						<TR>
						  <TD bgcolor=$bgColor valign=top width=42 rowSpan=3>$highSeedImage</TD>
						  <TD width=214 bgColor=$bgColor> <DIV class=confHeader align=center>($highSeedRank) $highSeedName vs. ($lowSeedRank) $lowSeedName</DIV></TD>
						  <TD bgcolor=$bgColor valign=top width=42 rowSpan=3>$lowSeedImage</TD>
						</TR>
						<TR>
						  <TD bgColor=#eeeeee> <DIV class=confTextWest align=center><a><b>$highSeedName $highSeedWin, $lowSeedName $highSeedLoss</b></a></DIV></TD>
						</TR>
						<TR>
						  <TD bgColor=#ffffff> <DIV class=confTextWest align=center>$gameResults</DIV></TD>
						</TR>
					  </TBODY>
					</TABLE></TD>
				  <TD width=1 bgColor=$bgColor><IMG src=blank.gif width=1></TD>
				<TR>
				  <TD bgColor=$bgColor colSpan=3 height=1><IMG height=1 src=blank.gif></TD>
				</TR>
				<TR>
				  <TD colSpan=3 height=5><IMG height=5 src=blank.gif></TD>
				</TR>
			  </TBODY>
			</TABLE>";
	}
	
}
function createSeasonList($seasonList) {

	echo "<form id=teambox><select onchange=\"javascript:if( options[selectedIndex].value != 'Season') document.location = options[selectedIndex].value\" name=\"url\">";
	echo "<OPTION selected>Season</option>";
	foreach($seasonList as $season) {
		$seasonID = $season["SEASON_ID"];
		$seasonDesc = $season["SEASON"];
		echo "<OPTION value=\"viewplayoffs.php?seasonID=$seasonID\">$seasonDesc</option>";
	}
	echo "</select></form>";

}

?>

