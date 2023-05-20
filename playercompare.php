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

<script>
window.name = 'LambertWindow';
</script>
<link href="/css/nbav2.css" rel="stylesheet" type="text/css">
<link href="/css/nbaOld.css" rel="stylesheet" type="text/css">	
<link href="/css/players/players.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="playerfinder.php"></script>

<body bgcolor="#ffffff" text="#000000" link="#003399" vlink="#003399" marginwidth="0" leftmargin="0" marginheight="0" topmargin="0" rightmargin="0" bottommargin="0">

		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="cBTopPlayerInfoPlayerNotes" colspan="3" height="0">
			<!-- Display Title -->
			<DIV class="cBTitlePlayerInfoPlayerNotes">
				Head-to-Head Comparisons
			</DIV></td>
		</tr>
		<tr>
		<td align="center" valign="top">
		<script>
		// initialize for popup window
 
	
	var player2 =null;
	var player1 =null;
		
	function openWindow(player1,player2){
	//fix names with single quotes
	var str = "Allen Iverson";
    var newstr = str.replace(/\'/g, "\'");
  	
	var popup = window.open('','', 'width=430,height=280,location=no,toolbar=no,menubar=no,scrollbars=no,resizable=no');
		popup.document.open();
		popup.document.write('<html><head><base target=\"LambertWindow\"><title>Head-to-Head ' + <? echo "'" . ereg_replace("'", "' + \"'\" + '", $playerName) . "'" ; ?> + '</title>');
		popup.document.write('</head><body marginwidth=0 leftmargin=0 marginheight=0 topmargin=0>');
		popup.document.write('<table cellpadding=0 cellspacing=0 border=0>');
		popup.document.write('<tr><td colspan=3></td></tr>');
		popup.document.write('<tr><td><iframe src="<? echo "headtohead.php?playerID=$playerID"; ?>" width=215 height=290 frameborder="0" scrolling="no" marginwidth="0" marginheight="0"><ilayer><layer src="<? echo "headtohead.php?playerID=$playerID"; ?>" width=215 height=290 frameborder="0" scrolling="no" marginwidth="0" marginheight="0"></layer></ilayer></iframe></td><td><img width="3" src="blank.gif"></td><td><iframe src='+ player2 +' width=215 height=290 frameborder="0" scrolling="no" marginwidth="0" marginheight="0"><ilayer><layer src='+ player2 +' width=215 height=290 frameborder="0" scrolling="no" marginwidth="0" marginheight="0"></layer></ilayer></iframe></td></tr>');
		popup.document.write('</table>');
		popup.document.write('</body></html>');
		popup.document.close();
			}


		</script>
		
		<table cellspacing="0" cellpadding="0" border="0" width="100%" align="center">
        <form name="TheForm" style="margin: 0">
        <tr align="center"><td ><br></td></tr>
        <tr align="center">
		<td >
		
        <select name="TheTopicSelectionList" size="1" onchange="OnChangeTopic()" style="width: 100%" width="100%">
        
                <option value="0">&nbsp;</option>
            
                <option value="1">&nbsp;</option>
            
                <option value="2">&nbsp;</option>
            
                <option value="3">&nbsp;</option>
            
                <option value="4">&nbsp;</option>
            
                <option value="5">&nbsp;</option>
            
                <option value="6">&nbsp;</option>
            
                <option value="7">&nbsp;</option>
            
                <option value="8">&nbsp;</option>
            
                <option value="9">&nbsp;</option>
            
                <option value="10">&nbsp;</option>
            
                <option value="11">&nbsp;</option>
            
                <option value="12">&nbsp;</option>
            
                <option value="13">&nbsp;</option>
            
                <option value="14">&nbsp;</option>
            
                <option value="15">&nbsp;</option>
            
                <option value="16">&nbsp;</option>
            
                <option value="17">&nbsp;</option>
            
                <option value="18">&nbsp;</option>
            
                <option value="19">&nbsp;</option>
            
                <option value="20">&nbsp;</option>
            
                <option value="21">&nbsp;</option>
            
                <option value="22">&nbsp;</option>
            
                <option value="23">&nbsp;</option>
            
                <option value="24">&nbsp;</option>
            
                <option value="25">&nbsp;</option>
            
                <option value="26">&nbsp;</option>
            
                <option value="27">&nbsp;</option>
            
                <option value="28">&nbsp;</option>
            
                <option value="29">&nbsp;</option>
            
                <option value="30">&nbsp;</option>
            
                <option value="31">&nbsp;</option>
            
                <option value="32">&nbsp;</option>
            
                <option value="33">&nbsp;</option>
            
                <option value="34">&nbsp;</option>
            
                <option value="35">&nbsp;</option>
            
                <option value="36">&nbsp;</option>
            
                <option value="37">&nbsp;</option>
            
                <option value="38">&nbsp;</option>
            
                <option value="39">&nbsp;</option>
            
                <option value="40">&nbsp;</option>
            
                <option value="41">&nbsp;</option>
            
                <option value="42">&nbsp;</option>
            
                <option value="43">&nbsp;</option>
            
                <option value="44">&nbsp;</option>
            
                <option value="45">&nbsp;</option>
            
                <option value="46">&nbsp;</option>
            
                <option value="47">&nbsp;</option>
            
                <option value="48">&nbsp;</option>
            
                <option value="49">&nbsp;</option>
            
        </select>
		</td>
		</tr>
        
		<tr align="center"><td ><br></td></tr>
        <tr align="center">
			<td>
			<select name="TheStatsCategoryList" size="1" style="width: 100%" width="100%">
        	
                	<option value="0">&nbsp;</option>
            	
                	<option value="1">&nbsp;</option>
            	
                	<option value="2">&nbsp;</option>
            	
                	<option value="3">&nbsp;</option>
            	
                	<option value="4">&nbsp;</option>
            	
                	<option value="5">&nbsp;</option>
            	
                	<option value="6">&nbsp;</option>
            	
                	<option value="7">&nbsp;</option>
            	
                	<option value="8">&nbsp;</option>
            	
                	<option value="9">&nbsp;</option>
            	
                	<option value="10">&nbsp;</option>
            	
                	<option value="11">&nbsp;</option>
            	
                	<option value="12">&nbsp;</option>
            	
                	<option value="13">&nbsp;</option>
            	
                	<option value="14">&nbsp;</option>
            	
                	<option value="15">&nbsp;</option>
            	
                	<option value="16">&nbsp;</option>
            	
                	<option value="17">&nbsp;</option>
            	
                	<option value="18">&nbsp;</option>
            	
                	<option value="19">&nbsp;</option>
            	
                	<option value="20">&nbsp;</option>
            	
                	<option value="21">&nbsp;</option>
            	
                	<option value="22">&nbsp;</option>
            	
                	<option value="23">&nbsp;</option>
            	
                	<option value="24">&nbsp;</option>
            	
                	<option value="25">&nbsp;</option>
            	
                	<option value="26">&nbsp;</option>
            	
                	<option value="27">&nbsp;</option>
            	
                	<option value="28">&nbsp;</option>
            	
                	<option value="29">&nbsp;</option>
            	
                	<option value="30">&nbsp;</option>
            	
                	<option value="31">&nbsp;</option>
            	
                	<option value="32">&nbsp;</option>
            	
                	<option value="33">&nbsp;</option>
            	
                	<option value="34">&nbsp;</option>
            	
                	<option value="35">&nbsp;</option>
            	
                	<option value="36">&nbsp;</option>
            	
                	<option value="37">&nbsp;</option>
            	
                	<option value="38">&nbsp;</option>
            	
                	<option value="39">&nbsp;</option>
            	
                	<option value="40">&nbsp;</option>
            	
                	<option value="41">&nbsp;</option>
            	
                	<option value="42">&nbsp;</option>
            	
                	<option value="43">&nbsp;</option>
            	
                	<option value="44">&nbsp;</option>
            	
                	<option value="45">&nbsp;</option>
            	
                	<option value="46">&nbsp;</option>
            	
                	<option value="47">&nbsp;</option>
            	
                	<option value="48">&nbsp;</option>
            	
                	<option value="49">&nbsp;</option>
            	
        	</select>
			</td>
        </tr>
        
		<tr>
        <td align="center">
        <input type=button value="Go" style="width:40px;" onclick="GoToPage()">
        </td>
        </tr>
        </form>
        </table>
        <script language="Javascript">
            InitializeStatsFinder();
        </script>
	
		</td>
		</tr>
		</table>

