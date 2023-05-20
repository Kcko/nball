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


?>
<html>
<head>

<style>
.selectBox {
	PADDING: 0px; 
	BORDER: black 1px solid; 
	FONT-WEIGHT: normal; 
	FONT-SIZE: 12px; 
	MARGIN: 10px; 
	WIDTH: 200px; 
	COLOR: black; 
	FONT-FAMILY: 'Trebuchet MS', Verdana, sans-serif;  
	BACKGROUND-COLOR: #c3d5f5; 
	TEXT-ALIGN: center;
}

.awardPlayerList {
	PADDING: 0px; 
	BORDER-TOP: black 1px solid; 
	BORDER-BOTTOM: black 0px solid; 
	BORDER-LEFT: black 0px solid; 
	BORDER-RIGHT: black 0px solid; 
	FONT-WEIGHT: normal; 
	FONT-SIZE: 12px; 
	WIDTH: 200px; 
	COLOR: black; 
	FONT-FAMILY: 'Trebuchet MS', Verdana, sans-serif;  
	BACKGROUND-COLOR: #ffffff; 
	TEXT-ALIGN: center;
}
</style>

<script type="text/javascript">
	function addToList(listField, awardType) {

		if (awardType == 1) {
			var awardTypeSelect = "playerList";
		} else {
			var awardTypeSelect = "teamList";
		}

		var playerSelect = document.getElementById(awardTypeSelect);
		var mySelect = document.getElementById(listField);

		txt = playerSelect[playerSelect.selectedIndex].text;
		val = playerSelect.value;

		strInput = "<input name="+listField+"[] type=hidden value=" + val + ">" + txt + "<br>";
		mySelect.innerHTML += strInput;
	}
</script>

</head>
<body>

<?
function createPlayerOptions($players) {
	foreach ($players as $player) {
		$playerID = $player["PLAYERID"];
		$playerName = $player["NAME"] . "," . $player["FNAME"];
		$playerName = trim($playerName);
		$teamName = $player["TEAMNAME"];
		echo "<option value=$playerID>$playerName - $teamName</option>\n";
	}
}

function createTeamOptions($teams) {
	foreach ($teams as $team) {
		$teamID = $team["TEAMNUM"];
		$teamName = $team["CITYNAME"] . " " . $team["TEAMNAME"];
		echo "<option value=$teamID>$teamName</option>\n";
	}
}

	include('../config.php');
	include('../mysql.php');


	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from players, teams, position where teams.teamnum = players.team and players.position = position.position order by name, fname, teamnum";
	$result = $db->sql_query($sql);
	$playerList = $db->sql_fetchrowset($result);

	$sql = "select * from teams order by teamnum";
	$result = $db->sql_query($sql);
	$teamList = $db->sql_fetchrowset($result);

	$sql = "select * from season";
	$result = $db->sql_query($sql);
	$seasonList = $db->sql_fetchrowset($result);

	$sql = "select * from award";
	$result = $db->sql_query($sql);
	$awardList = $db->sql_fetchrowset($result);

	echo "<form action=processawards.php method=post>";

	echo "<select name=seasonID>";
	foreach ($seasonList as $season) {
		$seasonID = $season["SEASON_ID"];
		$seasonShort = $season["SEASON"];
		$seasonDesc = $season["SEASON_DESC"];
		echo "<option value=$seasonID>$seasonDesc</option>\n";
	}
	echo "</select><br>";


//	print_r($seasonList);
//	print_r($awardList);


	echo "<select name=playerList>";
	createPlayerOptions($playerList);
	echo "</select><br>";

	echo "<select name=teamList>";
	createTeamOptions($teamList);
	echo "</select><br>";

	foreach ($awardList as $award) {
		$awardID = $award["AWARD_ID"];
		$awardType = $award["AWARD_TYPE"];
		$awardDesc = $award["AWARD_DESC"];

		echo "<span class=selectBox>\n";
		echo "<span class=description>$awardDesc\n";
		echo "<a href=# onclick=addToList('Award$awardID',$awardType)>add</a></span>\n";
		echo "<span class=awardPlayerList id=Award$awardID></span>\n";
		echo "</span>\n";
	}
?>

<input type="submit" name="submit" value="Go" />
</form>
</body>
</html>