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

	include ('inc_subscore.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "select * from teams order by teamnum";
	$result = $db->sql_query($sql);
	$rowset = $db->sql_fetchrowset($result);

	$homeTeamStats = $_FILES['userfile']['tmp_name'][0];
	$awayTeamStats = $_FILES['userfile']['tmp_name'][1];
	$gameStats = $_FILES['userfile']['tmp_name'][2];


	if ($homeTeamStats == "" | $awayTeamStats == "" | $gameStats == "") {
	
		die("missing files");
	}



	if ($homeTeamStats && $awayTeamStats && $gameStats) {
		$objHomeTeamStats = createPlayerStatObj($homeTeamStats, $HOME_TEAM, $HOME_TEAMNUM);
		$objAwayTeamStats = createPlayerStatObj($awayTeamStats, $AWAY_TEAM, $AWAY_TEAMNUM);
		$objGameStats = createGameStatObj($gameStats, $HOME_TEAM, $HOME_TEAMNUM, $AWAY_TEAM, $AWAY_TEAMNUM);
	}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Validate Scores</TITLE>
<LINK href="nbav2.css" type=text/css rel=stylesheet>
<LINK href="nbaOld.css" type=text/css rel=stylesheet>
<LINK href="players.css" type=text/css rel=stylesheet>
<!--<META HTTP-EQUIV=Refresh CONTENT="10; URL=viewfullschedule.php">-->
<!--<META HTTP-EQUIV=Refresh CONTENT="10; URL=viewboxscore.php?scheduleID=<? echo $SCHEDULE_ID;?>">-->


</HEAD>
<BODY text=#000000 bottomMargin=0 vLink=#003399 link=#003399 bgColor=#ffffff leftMargin=0 topMargin=0 rightMargin=0 marginheight="0" marginwidth="0">
<? 	include('header.php');?>
<!-- original template : playerfileBioOld2 -->
<TABLE cellSpacing=0 cellPadding=0 width=800 align=left border=0>
  <TBODY>
    <TR>
      <TD vAlign=top align=middle width="100%" height=1>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
          <TBODY>
            <TR>
              <TD vAlign=top align=left width=660>
                <!-- body -->
            <TABLE cellSpacing=0 cellPadding=0 width="100%" align=left
              border=0>
                  <TBODY>
                    <TR>
                      <TD class=insideHeaderTitle vAlign=center align=right width=595 height=20>VALIDATING SCORES</TD>
                      <TD vAlign=top align=left width=65 height=20><IMG height=20
                  src="titletab_subindex_right.jpg"
                  width=65 border=0></TD>
                    </TR>
                    <TR>
                      <TD vAlign=top align=left width=660 colSpan=2>
                        <!-- Begin inside Body -->
                        <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                          <!--DWLayoutTable-->
                          <TBODY>
                            <TR>
                              <TD class=playerFileGrid noWrap width=0><!--DWLayoutEmptyCell-->&nbsp;</TD>
                              <TD vAlign=top align=left width="100%" height=1>
                                <!-- common header -->
                        		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                                  <TBODY>
                                    <TR>
                                      <TD class=cBTopPlayerInfoBordersGrid vAlign=top align=middle width=140><DIV class=LogoImageTeamLogo><? //createTeamImageURL(strtolower($rowset[0]["IMAGENAME"]));?></DIV><BR><BR></TD>
                                      <TD vAlign=top width=519 height="100%">
                                        <!-- Paste Team Logo, Links here -->
                              			<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
                                          <TBODY>
                                            <TR><TD class=cBTopPlayerInfoBordersGrid>Validating Scores</TD>
                                            </TR>
								            <TR>
                                              <TD style="FONT-FAMILY: Arial; BACKGROUND-COLOR: #ffffff" vAlign=top align=left width="100%" height="100%">
                                				<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                                                  <TBODY>
                                                    <TR>
                                                      <TD vAlign=top align=left width="35%">
                                						<TABLE class=playerInfoGridPlayerInfoBorders width="100%" border=0>
                                                          <TBODY>
                                                            <TR>
                                                              <TD class=gSGSectionTitleStatsGrid vAlign=top width="100%">
                                                              <TABLE class=gSGSectionTitleStatsGrid cellPadding=0 width="100%" border=0>
                                                                  <TBODY>
                                                                    <TR>
                                                                      <TD class=gSGSectionTitleStatsGrid Align=Middle vAlign=middle width="70%"><? createTeamImageURL($rowset[$AWAY_TEAMNUM]["AWAY_TEAMNUM"]); echo "  <font size=20>@</a>   " ; createTeamImageURL($rowset[$HOME_TEAMNUM]["HOME_TEAMNUM"]); ?></TD>
                                                                    </TR>
                                                                  </TBODY>
                                                              </TABLE></TD>
                                                            </TR>
                                                          </TBODY>
                                                        </TABLE></TD>
                                                    </TR>
                                                  </TBODY>
                                                </TABLE></TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE></TD>
                                    </TR>
                                  </TBODY>
                                </TABLE></TD>
                              <TD class=playerFileGrid noWrap width=0><!--DWLayoutEmptyCell-->&nbsp;</TD>
                            </TR>
                            <TR>
                              <TD class=playerFileGrid colSpan=3 height=0>&nbsp;</TD>
                            </TR>
                            <TR>
                              <TD class=playerFileGrid noWrap width=0>&nbsp;</TD>
                              <TD style="FONT-FAMILY: Arial; BACKGROUND-COLOR: #ffffff" vAlign=top align=left width="100%" height=1>
								<? 		
									loadGameStats($SCHEDULE_ID, $objGameStats, $objHomeTeamStats, $objAwayTeamStats);
								?>
                              </TD>
                              <TD class=playerFileGrid noWrap width=0><!--DWLayoutEmptyCell-->&nbsp;</TD>
                            </TR>
                            <TR>
                              <TD class=playerFileGrid colSpan=3 height=0><!--DWLayoutEmptyCell-->&nbsp;</TD>
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
  </TBODY>
</TABLE>
</BODY>
</HTML>

