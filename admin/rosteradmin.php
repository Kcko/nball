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
<STYLE>
BODY {
	FONT-FAMILY: tahoma, verdana,arial;
	FONT-SIZE: 12px;
}
TD {
	FONT-FAMILY: tahoma, verdana,arial;
	FONT-WEIGHT: bold;
	FONT-SIZE: 11px;
}
</STYLE>
<?
include("../mysql.php");

function UpdatePlayerRosters($rosterFileName, $oldtablename) {
	include("../config.php");

	if ( !$fp = dbase_open($rosterFileName,0) ) {
		   echo "Cannot open $dbname\n";
		   exit;
	}

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	if ($oldtablename == "") {
		$oldtablename = date('YmdHi',mktime());
	}

	$sql = "CREATE TABLE players_" . $oldtablename . " LIKE players";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>create new table failed";
		exit;
	}


	$sql = "insert into players_" . $oldtablename . " select * from players";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>update new table failed";
		exit;
	}

	$sql = "TRUNCATE players";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>Truncate failed";
		exit;
	}

	$sql = "LOCK TABLES players WRITE";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>Truncate failed";
		exit;
	}

	echo "<TABLE border=0 cellpadding=0 cellspacing=0>";

	$nr = dbase_numrecords($fp); // Number of records.
	for ($i=1; $i <= $nr; $i++) {  // From 1 to $nr as you know.
		$dbfRecord = dbase_get_record($fp,$i);
//		echo "<pre>";
//		print_r($dbfRecord);

		$teamID = $dbfRecord[97];
		$deleted = $dbfRecord["deleted"];


			$NAME = trim($dbfRecord[1]);
			$FNAME = trim($dbfRecord[2]);
			$PLAYERID = $dbfRecord [4];
			$NUMBER = $dbfRecord [5];
			if ($NUMBER == -1) {
				$NUMBER = "00";
			}
			$POSITION = $dbfRecord [6];
			$POSITION2 = $dbfRecord [7];
			$HEIGHT = $dbfRecord [8];
			$WEIGHT = $dbfRecord [9];
			$YEARSEXP = $dbfRecord [10];
			$SCHOOLNUM = $dbfRecord [11];
			$OVERALLRTG = $dbfRecord [68];
			$PLAYRVALUE = $dbfRecord [69];
			$FGPBASE = $dbfRecord [70];
			$THREEPTBAS = $dbfRecord [71];
			$FTPBASE = $dbfRecord [72];
			$DNKABILITY = $dbfRecord [73];
			$STLABILITY = $dbfRecord [74];
			$BLKABILITY = $dbfRecord [75];
			$OREABILITY = $dbfRecord [76];
			$DREABILITY = $dbfRecord [77];
			$BALABILITY = $dbfRecord [78];
			$OFFABILITY = $dbfRecord [79];
			$DEFABILITY = $dbfRecord [80];
			$SPEED = $dbfRecord [81];
			$QUICK = $dbfRecord [82];
			$JUMP = $dbfRecord [83];
			$DRIBBLE = $dbfRecord [84];
			$DSTRENGTH = $dbfRecord [85];
			$DHARDY = $dbfRecord [86];
			$DSHOOTRANG = $dbfRecord [87];
			$FATIGUE = $dbfRecord [88];
			$INSIDESC = $dbfRecord [89];
			$PRIMACY = $dbfRecord [90];
			$SCOREAREA = $dbfRecord [91];
			$ORIGTEAM = $dbfRecord [96];
			$TEAM = $dbfRecord [97];
			$ROSTERPOS = $dbfRecord [98];
			$BIRTHDATE = substr($dbfRecord [99],0,4) . "-" . substr($dbfRecord [99],4,2) . "-" . substr($dbfRecord [99],6,2) ;
			$DPLACE = $dbfRecord [101];
			$DROUND = $dbfRecord [102];
			$DOVERALL = $dbfRecord [103];
			$DRAFTYEAR = $dbfRecord [104];
			$DRAFTEDBY = trim($dbfRecord [105]);
			$SALARY = $dbfRecord [136];
			$YRSSIGNED = $dbfRecord [138];
			$YRSREMAIN = $dbfRecord [139];

			$currentPlayer = $FNAME . " " . $NAME . " " . $SALARY . " " . $YRSREMAIN . "/" . $YRSSIGNED ;

//			echo "$currentPlayer<BR>";

		if (($teamID <= 29 or $teamID == 40) AND $deleted == 0) {

			$playerIDFormatted = sprintf("%04d", $PLAYERID);
			$playerImageName = "player_" . $playerIDFormatted;
			echo "<tr>";
			echo "<td><img width=65 height=90 src=\"../images/players/" . $playerImageName . ".jpg\" ></img></td>";
			echo "<td>$PLAYERID. $FNAME $NAME ($TEAM)</td>";
			echo "<td>$SALARY</td>";
			echo "<td>$YRSREMAIN / $YRSSIGNED</td>";
			echo "<td>$OVERALLRTG</td>";
			echo "</tr>";


			$sql = "insert into players values(
			\"$NAME\",
			\"$FNAME\",
			\"$PLAYERID\",
			\"$NUMBER\",
			\"$POSITION\",
			\"$POSITION2\",
			\"$HEIGHT\",
			\"$WEIGHT\",
			\"$YEARSEXP\",
			\"$SCHOOLNUM\",
			\"$OVERALLRTG\",
			\"$PLAYRVALUE\",
			\"$FGPBASE\",
			\"$THREEPTBAS\",
			\"$FTPBASE\",
			\"$DNKABILITY\",
			\"$STLABILITY\",
			\"$BLKABILITY\",
			\"$OREABILITY\",
			\"$DREABILITY\",
			\"$BALABILITY\",
			\"$OFFABILITY\",
			\"$DEFABILITY\",
			\"$SPEED\",
			\"$QUICK\",
			\"$JUMP\",
			\"$DRIBBLE\",
			\"$DSTRENGTH\",
			\"$DHARDY\",
			\"$DSHOOTRANG\",
			\"$FATIGUE\",
			\"$INSIDESC\",
			\"$PRIMACY\",
			\"$SCOREAREA\",
			\"$ORIGTEAM\",
			\"$TEAM\",
			\"$ROSTERPOS\",
			\"$BIRTHDATE\",
			\"$DPLACE\",
			\"$DROUND\",
			\"$DOVERALL\",
			\"$DRAFTYEAR\",
			\"$DRAFTEDBY\",
			\"$SALARY\",
			\"$YRSSIGNED\",
			\"$YRSREMAIN\"
			); ";

			$result = $db->sql_query($sql);

		} else {
			$playerIDFormatted = sprintf("%04d", $PLAYERID);
			$playerImageName = "player_" . $playerIDFormatted;
			echo "<tr>";
			echo "<td><img width=65 height=90 src=\"../images/players/" . $playerImageName . ".jpg\" ></img></font></td>";
			echo "<td><font color=red>$PLAYERID. $FNAME $NAME ($TEAM)</font></td>";
			echo "<td><font color=red>$SALARY</font></td>";
			echo "<td><font color=red>$YRSREMAIN / $YRSSIGNED</font></td>";
			echo "<td><font color=red>$OVERALLRTG</font></td>";
			echo "</tr>";

		}
	}
	echo "</TABLE>";

	$sql = "UNLOCK TABLES";
	if ( !($result = $db->sql_query($sql)) ) {
		echo "<br>Truncate failed";
		exit;
	}

}


function CreateRosterUploadBox () {
	echo "<form action=\"rosteradmin.php\" method=\"POST\" enctype=\"multipart/form-data\">
	Send these files:<br>";
	echo "Roster: <input name=\"rosterfile\" type=\"file\"><br>\n";
	echo "Old Roster Table Name (default is todays date): <input name=\"oldtablename\" type=\"text\"><br>\n";
	echo "<input type=submit value=\"Send files\">\n";

	echo "</form>\n";
}


//UpdatePlayerRosters("players.dbf");
$rosterfile = $_FILES['rosterfile'];

$rosterfile[0] = $rosterfile['name'];


switch ($rosterfile[0]) {
	case '':
		CreateRosterUploadBox();
		break;

	default:
		UpdatePlayerRosters($rosterfile[0], $oldtablename);

}




?>
</TABLE>