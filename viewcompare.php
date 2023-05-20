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

	if (trim($HTTP_COOKIE_VARS["PLAYERLIST"]) == "") {
		header("Location: index.php");
	}

	include('config.php');
	include('mysql.php');
	include('inc_player.php');


	$playerList = $HTTP_COOKIE_VARS["PLAYERLIST"];

	if ($sortOrder == "") {
		$sortOrder = "OVERALLRTG";
	}


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
			ON PL.PLAYERID IN ($playerList)
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

			GROUP BY 1,2,3,4,5,6 order by PL.$sortOrder desc";
			
	if ( !($result = $db->sql_query($sql)) ) {
	}

	$row = $db->sql_fetchrowset($result);
//	echo "<PRE>";
//	print_r($row);
//	echo "</pre>";


$ratingsTypes = array(
				array("OVERALLRTG"
					 ,"FGPBASE"
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
					 ,"DEFABILITY"
					 )

			   ,array("Overall"
			   		 ,"FG"
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
					 ,"D. Aware"
					 ));
					 
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
		$playerSalary[$rownum] = "$" . trim(number_format($value["SALARY"]));
		$playerContract[$rownum] = $value["YRSREMAIN"] . " / " . $value["YRSSIGNED"];
		
		
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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Player Comparison</TITLE>
<LINK href="nball.css" type=text/css rel=stylesheet>
<script>
window.name = 'LambertWindow';
</script>

<META content="MSHTML 6.00.2800.1276" name=GENERATOR>
</HEAD>
<BODY text=#000000 bottommargin=0 vlink=#003399 link=#003399 bgcolor=#ffffff leftmargin=0 topmargin=0 rightmargin=0 marginheight="0" marginwidth="0">
<? 	include('header.php');?>
<!-- original template : playerfileBioOld2 -->
<TABLE cellspacing=0 cellpadding=0 width=800 align=left border=0>
  <TBODY>
    <TR>
      <TD valign=top align=middle width="100%" height=1>

      <TABLE cellspacing=0 cellpadding=0 width="100%" border=0>
          <TBODY>
            <TR>
              <TD valign=top align=left width=660>
                <!-- body -->
            <TABLE cellspacing=0 cellpadding=0 width="100%" align=left border=0>
                  <TBODY>
                    <TR>
                      <TD class=insideHeaderTitle valign=center align=right width=595 height=20>PLAYER COMPARE</TD>
                      <TD valign=top align=left width=65 height=20><IMG height=20 src="titletab_subindex_right.jpg" width=65 border=0></TD>
                    </TR>
                    <TR>
                      <TD valign=top align=left width=660 colspan=2>
                        <!-- Begin inside Body -->
                        <TABLE cellspacing=0 cellpadding=0 width="100%" border=0>
                          <!--DWLayoutTable-->
                          <TBODY>
                            <TR>
                              <TD class=playerFileGrid nowrap width=0><!--DWLayoutEmptyCell-->&nbsp;</TD>
                              <TD valign=top align=left width="100%" height=1>
                                <!-- common header -->


	<table border=0 cellpadding=0 cellspacing=0 width=<? echo 80 + ($rowCount * 110); ?> >
		<tr>
		<td valign=top>
				 <table border="0" cellspacing="0" class="playerInfoGridPlayerInfoBorders" >
					<tr><td width=80>&nbsp;</td>

							<? 
								for ($i = 0; $i < $rowCount; $i++) {

				 					echo "<td width=125 align=middle valign=top >";
				 					//echo "<img border=0 height=90 width=65 src=http://www.nba.com/media/playerfile/$playerImageName[$i].jpg>";
				 					
				 					createPlayerImageURL($playerID[$i]);
				 					
									echo "</td>";
								}
							?>

					</tr>				 	<tr><td >&nbsp;</td>
							<? 
								for ($i = 0; $i < $rowCount; $i++) {
									echo "<td width=100 align=middle valign=top>";
									?>
									<div class="playerInfoHeadingPlayerInfoBorders"><b><? echo $playerName[$i]?></b></div>
									<div class="playerInfoStatsPlayerInfoBorders"><? echo $teamName[$i]?></div>
									<div class="playerInfoStatsPlayerInfoBorders">Position:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerPosition[$i];?></span></div>
									<div class="playerInfoStatsPlayerInfoBorders">Height:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerHeight[$i];?> </span> </div>
									<div class="playerInfoStatsPlayerInfoBorders">Weight:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerWeight[$i] ?></span></div>
									<div class="playerInfoStatsPlayerInfoBorders">Salary:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerSalary[$i] ?></span></div>
									<div class="playerInfoStatsPlayerInfoBorders">Contract:&nbsp;<span class="playerInfoValuePlayerInfoBorders"><? echo $playerContract[$i] ?></span></div>
									
									<div align="bottom">

									<?
									
									echo "</td>";
								}
							?>
					</tr>


					<tr>
					<td class="gSGSectionTitleStatsPlayerGrid">&nbsp;</td>
					<td colspan=<? echo $rowCount; ?> valign="top" align="center" class="gSGSectionTitleStatsPlayerGrid"><b>Player Ratings</td></tr>

					<? 
						$i = 0;
						$j = 0;
						$ratingsCount = count($ratingsTypes[0]);
						//"gSGRowOdd";
						//"gSGRowEven";
						$rowclass = "gSGRowEven";
						for ($j = 0; $j < $ratingsCount; $j++) {
							$ratingsDesc = $ratingsTypes[1][$j];
							$ratingColName = $ratingsTypes[0][$j];
							echo "<tr align=center><td align=left class=$rowclass><b><a class=liveScoresTeamLink href=viewcompare.php?sortOrder=$ratingColName>$ratingsDesc</a></b></td>";
							
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
							echo "<td class=gSGRowOdd><b><a class=liveScoresTeamLink href=removefromcompare.php?playerID=$removePlayerID>Remove</a></b></td>\n";
						}
					?>
					</tr>

				</table>

</td>
		</tr>
	</table>
                        		</TD>
                              <TD class=playerFileGrid nowrap width=0><!--DWLayoutEmptyCell-->&nbsp;</TD>
                            </TR>
                           
                            
                            <TR>
                              <TD class=playerFileGrid colspan=3 height=0>&nbsp;</TD>
                            </TR>

                         </TBODY>
                        </TABLE></TD>
                    </TR>
                  </TBODY>
                </TABLE>
                <!-- end of inside body -->
              </TD>
            </TR>
          </TBODY>
        </TABLE>

      </TD>
    </TR>
    <TR><TD>
<? 	include('footer.php');?>

	</TD></TR>

  </TBODY>
</TABLE>
</BODY>
</HTML>
