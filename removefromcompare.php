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

	$comparePlayerID = explode(",", $HTTP_COOKIE_VARS["PLAYERLIST"]);

//	print_r($comparePlayerID);

	$key = array_search($playerID, $comparePlayerID);
	unset ($comparePlayerID[$key]);

//	print_r($comparePlayerID);
	$comparePlayerID = array_unique($comparePlayerID);
	$comparePlayerIDList = implode(",",array_slice($comparePlayerID,0,5));

//	echo $comparePlayerIDList;
	setcookie("PLAYERLIST", $comparePlayerIDList);


	if (trim($HTTP_COOKIE_VARS["PLAYERLIST"]) == "") {
		//header("Location: index.php");
		setcookie("PLAYERLIST", $comparePlayerIDList);
		echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=index.php\">";
		exit;
	}

?>
<META HTTP-EQUIV="refresh" CONTENT="0;URL=viewcompare.php">