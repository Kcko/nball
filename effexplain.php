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

<style>
	.theStyle {font-family:verdana,arial;font-size:11px; padding:1px;}
	a.theLink {font-family:verdana,arial;font-size:11px;}
	a.theLink:visited {font-family:verdana,arial;font-size:11px;}
	a.theLink:hover {font-family:verdana,arial;font-size:11px;}
        td.theStyle {font-family:verdana,arial;font-size:11px;}
</style>

<div id="playerEff">
<?
	if (count($roundEffPlayer) > 0) {
		efficiencyRoundPlayerRecap($roundEffPlayer);
	}

?>
</div>

<div class="theStyle">

How do many NBA coaches quickly evaluate a player's game performance? They check his efficiency.<p>
NBA.com evaluates all players based on the efficiency formula, the same one also used by fantasy game players in Virtual GM: ((Points + Rebounds + Assists + Steals + Blocks) - ((Field Goals Att. - Field Goals Made) + (Free Throws Att. - Free Throws Made) + Turnovers)).<p>
For example, compare the following stat lines:<p>
<table cellspacing=3 cellpadding=0 width=350>
<tr>
<td>&nbsp;</td>
<td align=right><div class="theStyle"><b>MIN</b></div></td>
<td align=right><div class="theStyle"><b>FGM-A</b></div></td>
<td align=right><div class="theStyle"><b>FTM-A</b></div></td>
<td align=right><div class="theStyle"><b>REB</b></div></td>
<td align=right><div class="theStyle"><b>AST</b></div></td>
<td align=right><div class="theStyle"><b>STL</b></div></td>
<td align=right><div class="theStyle"><b>BS</b></div></td>
<td align=right><div class="theStyle"><b>TO</b></div></td>
<td align=right><div class="theStyle"><b>PTS</b></div></td>
</tr>
<tr>
<td><div class="theStyle">Player A</div></td>
<td align=right><div class="theStyle">43</div></td>
<td align=right><div class="theStyle">5-22</div></td>
<td align=right><div class="theStyle">7-9</div></td>
<td align=right><div class="theStyle">8</div></td>
<td align=right><div class="theStyle">6</div></td>
<td align=right><div class="theStyle">3</div></td>
<td align=right><div class="theStyle">0</div></td>
<td align=right><div class="theStyle">4</div></td>
<td align=right><div class="theStyle">17</div></td>
</tr>
<tr>
<td><div class="theStyle">Player B</div></td>
<td align=right><div class="theStyle">29</div></td>
<td align=right><div class="theStyle">5-8</div></td>
<td align=right><div class="theStyle">3-4</div></td>
<td align=right><div class="theStyle">4</div></td>
<td align=right><div class="theStyle">7</div></td>
<td align=right><div class="theStyle">0</div></td>
<td align=right><div class="theStyle">0</div></td>
<td align=right><div class="theStyle">2</div></td>
<td align=right><div class="theStyle">15</div></td>
</tr>
</table>
<p>

Player A had a better game, right?  Not exactly. Player B, who shot 5-8 from the field and committed two turnovers, registered a +20 efficiency total while Player A, who shot 5-22 from the field and committed four turnovers, posted a +11.<p>
</div>