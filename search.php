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
		echo "<tr><td class=gSGRowEvenStatsGrid align=center colspan=10>no players found</td>";
	
	}
	
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

	echo "</table>";

}




	$statsArray = 	array(  "OVERALLRTG",
							"PLAYRVALUE",
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


	if ($submit == 1) {

		include('config.php');
		include('mysql.php');

		$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);


		$sql = "select * from players where 1 = 1";

		foreach($statsArray as $statName) {
			$item0 = $HTTP_GET_VARS[$statName][0];
			$item1 = $HTTP_GET_VARS[$statName][1];
			if ($HTTP_GET_VARS[$statName][0] != "NA" and $HTTP_GET_VARS[$statName][1] != "NA") {

				$sql = $sql . " and $statName between \"$item0\" and \"$item1\"";
			}
		}

		if ($HTTP_GET_VARS["POSITION"] != "NA") {
			$sql = $sql . " and POSITION = " . $HTTP_GET_VARS["POSITION"] ;
		
		}

		if ($HTTP_GET_VARS["HEIGHT"][0] != "NA" and $HTTP_GET_VERS["HEIGHT"][1] != "NA") {
			$sql = $sql . " and HEIGHT between " . $HTTP_GET_VARS["HEIGHT"][0] . " and " . $HTTP_GET_VARS["HEIGHT"][1];
		
		}


		$sql .= " limit 100";
		
		echo $sql;

		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrowset($result);
		
		echo count($row);
		echo "<BR>";

//		print_r($row);
		
		createTeamLineup($row);

	}


?>

<form action=search.php>

<input type=hidden name=submit value=1>
<?

	$positionArray = array("C","PF","SF","SG","PG");

	$i = 0;
	echo "Position\n";
	echo "<select name=POSITION>";
	echo "<option value=NA></option>";	
	foreach ($positionArray as $positioName) {
		if ($HTTP_GET_VARS["POSITION"] == $i and isset($HTTP_GET_VARS["POSITION"]) and $HTTP_GET_VARS["POSITION"] != "NA") {
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

		if ($HTTP_GET_VARS["HEIGHT"][0] == $i and isset($HTTP_GET_VARS["HEIGHT"]) and $HTTP_GET_VARS["HEIGHT"][0] != "NA") {
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
		if ($HTTP_GET_VARS["HEIGHT"][1] == $i and isset($HTTP_GET_VARS["HEIGHT"]) and $HTTP_GET_VARS["HEIGHT"][1] != "NA") {
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
		
		if ($HTTP_GET_VARS[$statName][0] == "NA") {
			echo "<option value=NA selected></option>";	
		} else {
			echo "<option value=NA selected></option>";	
		}

		for ($i = 0; $i <= 100; $i = $i + 5) {
			if ($HTTP_GET_VARS[$statName][0] == $i and $HTTP_GET_VARS[$statName][0] != "NA" and isset($HTTP_GET_VARS[$statName][0])) {
				echo "<option value=$i selected>$i</option>";
			} else {
				echo "<option value=$i>$i</option>";
			}
		}
		echo "</select>";
		
		echo "<select name=". $statName . "[]>";
		echo "<option value=NA selected></option>";	
		for ($i = 0; $i <= 100; $i = $i + 5) {
			if ($HTTP_GET_VARS[$statName][1] == $i and $HTTP_GET_VARS[$statName][1] != "NA" and isset($HTTP_GET_VARS[$statName][1])) {
				echo "<option value=$i selected>$i</option>";
			} else {
				echo "<option value=$i>$i</option>";
			}
		}
		echo "</select>";
		echo "<BR>";
	}

?>
<input type=submit>

</form>


