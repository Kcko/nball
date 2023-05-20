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


function createTeamLineup($teamInfo) {
	echo "<table width=100% border=0 cellpadding=0 cellspacing=0 >";
	echo "<tr><td class=gSGSectionTitle colspan=10><div class=gSGSectionTitle>&nbsp; Roster</div></td></tr>";
	echo "<tr class=gSGSectionColumnHeadings>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>NUM</b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>PLAYER</b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>POS</b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>HT</b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>WT</b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>DRAFT INFO</b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>RTG</b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>YRS</b></td>";
	echo "<td NOWRAP align=left class=gSGSectionColumnHeadings><b>CON</b></td>";
	echo "<td NOWRAP align=right class=gSGSectionColumnHeadings><b>SAL</b></td>";
	echo "</tr>";	

	if (count($teamInfo) == 0) {
		echo "<tr><td class=gSGRowEvenStatsGrid align=center colspan=10><b>No players found</b></td>";
	
	}
	
	if (count($teamInfo) == 100) {
		echo "<tr><td class=gSGRowEvenStatsGrid align=center colspan=10><b>More than 100 players found. Please refine your search</b></td>";
	
	} else {

		foreach ($teamInfo as $value) {
			echo "<tr><td class=gSGRowEvenStatsGrid align=left>&nbsp;" . $value["NUMBER"] . "</td>";

			$playerName = trim($value["FNAME"] . " " . $value["NAME"]); 
			$playerID = $value["PLAYERID"];

			echo "<td class=gSGRowEvenStatsGrid align=left><a href=viewplayer.php?playerID=$playerID>" . $playerName . "</a> "; 
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
			echo "<td class=gSGRowEvenStatsGrid align=right> " . trim(number_format($value["SALARY"])) ."</td></tr>";
		}
	}

	echo "</table>";

}

function createSearchBox($incomingVars) {
	$statsArray = 	array(  "OVERALLRTG",
							"FGPBASE",
							"THREEPTBAS",
							"FTPBASE",
							"DNKABILITY",
							"STLABILITY",
							"BLKABILITY",
							"OREABILITY",
							"DREABILITY",
							"BALABILITY",
							"OFFABILITY",
							"DEFABILITY",
							"SPEED",
							"QUICK",
							"JUMP",
							"DRIBBLE",
							"DSTRENGTH",
							"DHARDY",
							"FATIGUE",
							"INSIDESC",
							"DOVERALL"
							);


	echo "<form action=playersearch.php method=post>";
	echo "<input type=hidden name=submit value=1>";

	$positionArray = array("C","PF","SF","SG","PG");

	$i = 0;
	echo "Position\n";
	echo "<select name=POSITION>";
	echo "<option value=NA></option>";	
	foreach ($positionArray as $positioName) {
		if ($incomingVars["POSITION"] == $i and isset($incomingVars["POSITION"]) and $incomingVars["POSITION"] != "NA") {
			echo "<option value=$i selected>$positioName</option>";
		} else {
			echo "<option value=$i>$positioName</option>";
		}
		
		$i++;
	}
	echo "</select>";
	echo "<BR>";			

	echo "Height\n";
	echo "<select name=HEIGHT[]>";
	echo "<option value=NA selected></option>";	
	for ($i = 60; $i <= 91; $i = $i + 1) {
		$HEIGHT = intval($i / 12) . "-" . $i % 12;

		if ($incomingVars["HEIGHT"][0] == $i and isset($incomingVars["HEIGHT"]) and $incomingVars["HEIGHT"][0] != "NA") {
			echo "<option value=$i selected>$HEIGHT</option>";
		} else {
			echo "<option value=$i>$HEIGHT</option>";
		}

	}
	echo "</select>";

	echo "<select name=HEIGHT[]>";
	echo "<option value=NA selected></option>";	
	for ($i = 50; $i <= 95; $i = $i + 1) {
		$HEIGHT = intval($i / 12) . "-" . $i % 12;
		if ($incomingVars["HEIGHT"][1] == $i and isset($incomingVars["HEIGHT"]) and $incomingVars["HEIGHT"][1] != "NA") {
			echo "<option value=$i selected>$HEIGHT</option>";
		} else {
			echo "<option value=$i>$HEIGHT</option>";
		}

	}
	echo "</select>";
	echo "<BR>";			


	foreach ($statsArray as $statName) {
		echo $statName . "\n";
		echo "<select name=". $statName . "[]>";
		
		if ($incomingVars[$statName][0] == "NA") {
			echo "<option value=NA selected></option>";	
		} else {
			echo "<option value=NA selected></option>";	
		}

		for ($i = 0; $i <= 100; $i = $i + 5) {
			if ($incomingVars[$statName][0] == $i and $incomingVars[$statName][0] != "NA" and isset($incomingVars[$statName][0])) {
				echo "<option value=$i selected>$i</option>";
			} else {
				echo "<option value=$i>$i</option>";
			}
		}
		echo "</select>";
		
		echo "<select name=". $statName . "[]>";
		echo "<option value=NA selected></option>";	
		for ($i = 0; $i <= 100; $i = $i + 5) {
			if ($incomingVars[$statName][1] == $i and $incomingVars[$statName][1] != "NA" and isset($incomingVars[$statName][1])) {
				echo "<option value=$i selected>$i</option>";
			} else {
				echo "<option value=$i>$i</option>";
			}
		}
		echo "</select>";
		echo "<BR>";
	}

	echo "<input type=submit value=GO>";
	echo "</form>";
}

function createSQL($incomingVars) {

	$statsArray = 	array(  "OVERALLRTG",
							"FGPBASE",
							"THREEPTBAS",
							"FTPBASE",
							"DNKABILITY",
							"STLABILITY",
							"BLKABILITY",
							"OREABILITY",
							"DREABILITY",
							"BALABILITY",
							"OFFABILITY",
							"DEFABILITY",
							"SPEED",
							"QUICK",
							"JUMP",
							"DRIBBLE",
							"DSTRENGTH",
							"DHARDY",
							"FATIGUE",
							"INSIDESC"
							);

	$positionArray = array("C","PF","SF","SG","PG");


	$sql = "select * from players where 1 = 1";

	foreach($statsArray as $statName) {
		$item0 = $incomingVars[$statName][0];
		$item1 = $incomingVars[$statName][1];
		if ($incomingVars[$statName][0] != "NA" and $incomingVars[$statName][1] != "NA") {

			$sql = $sql . " and $statName between \"$item0\" and \"$item1\"";
		}
	}

	if ($incomingVars["POSITION"] != "NA") {
		$sql = $sql . " and POSITION = " . $incomingVars["POSITION"] ;

	}

	if ($incomingVars["HEIGHT"][0] != "NA" and $incomingVars["HEIGHT"][1] != "NA") {
		$sql = $sql . " and HEIGHT between " . $incomingVars["HEIGHT"][0] . " and " . $incomingVars["HEIGHT"][1];

	}


	$sql .= " limit 100";

	return $sql;


}



?>

