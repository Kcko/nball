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
<ul id="menu">
		<li><a onkeypress="resetMenu('m0'); return false;" onclick="resetMenu('m0'); return false;" href="#">Home</a></li><ol class="submenu" id="m0"><li><a href="index.php">Stats Home</a></li><li><a href="/" target="_top">ALO Home</a></li></ol>
		<li><a onkeypress="resetMenu('m1'); return false;" onclick="resetMenu('m1'); return false;" href="#">Standings</a></li><ol class="submenu" id="m1"><li><a href="viewstandings.php">Division</a></li><li><a href="viewstandings.php?viewType=conf">Conference</a></li><li><a href="viewplayoffs.php?seasonID=2">Playoffs</a></li><li><a href="viewstandings.php?seasonID=1">03-04 Standings</a></li><li><a href="viewplayoffs.php?seasonID=1">03-04 Playoffs</a></li></ol>
		<li><a onkeypress="resetMenu('m2'); return false;" onclick="resetMenu('m2'); return false;" href="#">Players</a></li><ol class="submenu" id="m2"><li><a href="viewplayerlist.php">Player List</a></li><li><a href="playersearch.php">Player Search</a></li></ol>
		<li><a onkeypress="resetMenu('m3'); return false;" onclick="resetMenu('m3');" href="#">Statistics</a></li><ol class="submenu" id="m3"><li><a href="viewstats.php?stat_type=POINTS&stat_view=PG">League Leaders</a></li><li><a href="viewstats.php?stat_type=POINTS&stat_view=PT">League Leaders (32mins)</a></li><li><a href="viewstats.php?stat_type=POINTS&stat_view=TPG">Teams</a></li><li><a href="viewstats.php?stat_type=POINTS&stat_view=APG">All Time</a></li><li><a href="vieweffrecap.php">Efficiency Recap</a></li></ol>
		<li><form id="teambox"><select onchange="javascript:if( options[selectedIndex].value != 'Teams') document.location = options[selectedIndex].value" name="url">
			<OPTION selected>Teams</option>
			<OPTION value="viewteam.php?teamID=0">Atlanta</option>
			<OPTION value="viewteam.php?teamID=1">Boston</option>
			<OPTION value="viewteam.php?teamID=2">Chicago</option>
			<OPTION value="viewteam.php?teamID=3">Cleveland</option>
			<OPTION value="viewteam.php?teamID=4">Dallas</option>
			<OPTION value="viewteam.php?teamID=5">Denver</option>
			<OPTION value="viewteam.php?teamID=6">Detroit</option>
			<OPTION value="viewteam.php?teamID=7">Golden State</option>
			<OPTION value="viewteam.php?teamID=8">Houston</option>
			<OPTION value="viewteam.php?teamID=9">Indiana</option>
			<OPTION value="viewteam.php?teamID=10">LA Clippers</option>
			<OPTION value="viewteam.php?teamID=11">LA Lakers</option>
			<OPTION value="viewteam.php?teamID=12">Memphis</option>
			<OPTION value="viewteam.php?teamID=13">Miami</option>
			<OPTION value="viewteam.php?teamID=14">Milwaukee</option>
			<OPTION value="viewteam.php?teamID=15">Minnesota</option>
			<OPTION value="viewteam.php?teamID=16">New Jersey</option>
			<OPTION value="viewteam.php?teamID=17">New Orleans</option>
			<OPTION value="viewteam.php?teamID=18">New York</option>
			<OPTION value="viewteam.php?teamID=19">Orlando</option>
			<OPTION value="viewteam.php?teamID=20">Philadelphia</option>
			<OPTION value="viewteam.php?teamID=21">Phoenix</option>
			<OPTION value="viewteam.php?teamID=22">Portland</option>
			<OPTION value="viewteam.php?teamID=23">Sacramento</option>
			<OPTION value="viewteam.php?teamID=24">San Antonio</option>
			<OPTION value="viewteam.php?teamID=25">Seattle</option>
			<OPTION value="viewteam.php?teamID=26">Toronto</option>
			<OPTION value="viewteam.php?teamID=27">Utah</option>
			<OPTION value="viewteam.php?teamID=28">Washington</option>
			<OPTION value="viewteam.php?teamID=29">Free Agents</option>
			<OPTION value="viewteam.php?teamID=40">Retired</option>
		</select></form></li>
		<li><a onkeypress="resetMenu('m4'); return false;" onclick="resetMenu('m4');" href="#">Schedule</a><ol class="submenu" id="m4"><li><a href="viewfullschedule.php">Full Schedule</a></li><li><a href="viewfullschedule.php?round=1&seasonID=1">03-04 Schedule</a></li></ol></li>
		<li><a onkeypress="resetMenu('m5'); return false;" onclick="resetMenu('m5');" href="#">News/Features</a><ol class="submenu" id="m5"><li><a href="viewawards.php">Award Winners</a></li></ol></li>
	</ul>
