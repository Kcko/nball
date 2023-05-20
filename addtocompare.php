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

	if ($HTTP_COOKIE_VARS["PLAYERLIST"] == "") {
		setcookie("PLAYERLIST", $playerID);
//		echo $HTTP_COOKIE_VARS["PLAYERLIST"];
	} else {
		$comparePlayerID = explode(",", $HTTP_COOKIE_VARS["PLAYERLIST"]);
		$comparePlayerID[] = $playerID;
		$comparePlayerID = array_unique($comparePlayerID);
		$comparePlayerIDList = implode(",",array_slice($comparePlayerID,0,15));
		setcookie("PLAYERLIST", $comparePlayerIDList);
	}
	
//	header("Location: viewcompare.php");
?>
<META HTTP-EQUIV="refresh" CONTENT="0;URL=<? echo $HTTP_REFERER;?>">