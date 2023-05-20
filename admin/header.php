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
.globalNavLink {
	FONT-WEIGHT: bold; FONT-SIZE: 10px; COLOR: #000000; FONT-STYLE: normal; FONT-FAMILY: Arial; TEXT-DECORATION: none
}
.globalNavVline {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #cc0000; FONT-STYLE: normal; FONT-FAMILY: Arial
}
</STYLE>

<table cellpadding="3" cellspacing="0" border="0" bgcolor="#cccccc" width="660">
<tr>
	<td width="10"><img src="blank.gif" width="10" height="1"></td>
	<td align=middle><a class="globalNavLink" href="../">STANDINGS</a></td>
	<td class="globalNavVline">|</td>
	<td valign="center" align=middle><a class="globalNavLink" href="../viewfullschedule.php">FULL SCHEDULE</a></td>
	<td class="globalNavVline">|</td>
	<td valign="center" align=middle><a class="globalNavLink" href="../viewstats.php">STATISTICS</a></td>
	<td class="globalNavVline">|</td>
	<td>
	<div style="margin:3px">
	<!--Begin Dropdown-->
	<SELECT style="width:120px;font:10px verdana, arial, sans-serif;text-decoration:none;background-color:#cccccc;" name=url onchange="javascript:if( options[selectedIndex].value != 'Teams') document.location = options[selectedIndex].value">
	<OPTION selected>Teams</option>
	<OPTION value="../viewteam.php?teamID=0">Atlanta</option>
	<OPTION value="../viewteam.php?teamID=1">Boston</option>
	<OPTION value="../viewteam.php?teamID=2">Chicago</option>
	<OPTION value="../viewteam.php?teamID=3">Cleveland</option>
	<OPTION value="../viewteam.php?teamID=4">Dallas</option>
	<OPTION value="../viewteam.php?teamID=5">Denver</option>
	<OPTION value="../viewteam.php?teamID=6">Detroit</option>
	<OPTION value="../viewteam.php?teamID=7">Golden State</option>
	<OPTION value="../viewteam.php?teamID=8">Houston</option>
	<OPTION value="../viewteam.php?teamID=9">Indiana</option>
	<OPTION value="../viewteam.php?teamID=10">LA Clippers</option>
	<OPTION value="../viewteam.php?teamID=11">LA Lakers</option>
	<OPTION value="../viewteam.php?teamID=12">Memphis</option>
	<OPTION value="../viewteam.php?teamID=13">Miami</option>
	<OPTION value="../viewteam.php?teamID=14">Milwaukee</option>
	<OPTION value="../viewteam.php?teamID=15">Minnesota</option>
	<OPTION value="../viewteam.php?teamID=16">New Jersey</option>
	<OPTION value="../viewteam.php?teamID=17">New Orleans</option>
	<OPTION value="../viewteam.php?teamID=18">New York</option>
	<OPTION value="../viewteam.php?teamID=19">Orlando</option>
	<OPTION value="../viewteam.php?teamID=20">Philadelphia</option>
	<OPTION value="../viewteam.php?teamID=21">Phoenix</option>
	<OPTION value="../viewteam.php?teamID=22">Portland</option>
	<OPTION value="../viewteam.php?teamID=23">Sacramento</option>
	<OPTION value="../viewteam.php?teamID=24">San Antonio</option>
	<OPTION value="../viewteam.php?teamID=25">Seattle</option>
	<OPTION value="../viewteam.php?teamID=26">Toronto</option>
	<OPTION value="../viewteam.php?teamID=27">Utah</option>
	<OPTION value="../viewteam.php?teamID=28">Washington</option>
	<OPTION value="../viewteam.php?teamID=29">Free Agents</option>
	</select>
	</form>
	<!--End Dropdown--></div>
	</td>
	<td width="50"><img src="blank.gif" width="10" height="1"></td>
	<td></td>
	<td></td>
	<td width="5" class="globalNavVline"></td>
	<td width="50"></td>
	<td class="globalNavVline"></td>
	<td width="5"></td>
	<td class="globalNavVline"></td>
	<td width="50"></td> 
	<td class="globalNavVline"></td>     
	<td></td>
	<td width="10"></td>
</tr>
</table>
