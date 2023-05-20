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
	var PlayersViewObject = new StatsView();
			
	var PlayersTopic = new StatsTopic('Select A Team');
	PlayersTopic.AddURL(new URLPair("Select A Player",""));
	PlayersViewObject.AddTopic(PlayersTopic);



<?
	include('config.php');
	include('mysql.php');
	include('inc_player.php');

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "
		SELECT	 PL.PLAYERID
				,PL.FNAME 
				,PL.NAME
				,TM.TEAMNUM				
				,TM.CITYNAME
				,TM.TEAMNAME

			FROM PLAYERS PL
			INNER JOIN TEAMS TM
			ON PL.TEAM = TM.TEAMNUM

			ORDER BY TM.TEAMNUM, PL.NAME, PL.FNAME, PL.PLAYERID
	";

	if ( !($result = $db->sql_query($sql)) ) {
	}

	$row = $db->sql_fetchrowset($result);
	
//	echo "<PRE>";
//	print_r($row);
//	echo "</PRE>";

	$c_teamID = "";
	$p_teamID = "";

	$teamCount = "0";

	foreach ($row as $playerLine) {
		$playerID = $playerLine["PLAYERID"];
		
		if ($playerLine["FNAME"] == "") {
			$playerName = trim($playerLine["NAME"]);
		} else {
			$playerName = trim($playerLine["NAME"] . ", " . $playerLine["FNAME"]);
		}

		$teamID = $playerLine["TEAMNUM"];
		$teamName = $playerLine["CITYNAME"] . " " . $playerLine["TEAMNAME"];

		if ($c_teamID != $teamID) {
				if ($teamID > 0) {
					$c_teamNum = $teamCount - 1;
					echo "PlayersViewObject.AddTopic(PlayersTopic$c_teamNum);\n";
				}
				echo "var PlayersTopic$teamID = new StatsTopic('$teamName');\n";
				echo "PlayersTopic$teamID.AddURL(new URLPair(\"Select A Player\",\"\"));\n";
				$c_teamID = $teamID;
				$teamCount++;
			}
	    echo "PlayersTopic$teamID.AddURL(new URLPair(\"$playerName\",\"headtohead.php?playerID=$playerID\"))\n";
	    
	}
	
	$c_teamNum = $teamCount - 1;
	echo "PlayersViewObject.AddTopic(PlayersTopic$teamID);\n";
	
?>			

       

            var isNav = null;
            var isIE = null;
            var theTopicSelectionList = null;
            var theStatsCategorySelectionList = null;
            var theCurrentViewObject = null;
        
            function LoadViewObject(aStatsViewObject) {

                // set the current view 
                theCurrentViewObject = aStatsViewObject;

                // clear the topic select list
                theTopicSelectionList.options.length = 0;

                var tmpTopic = theCurrentViewObject.FirstTopic();

                while (tmpTopic != null ) {

                    AddSelectionListEntry(tmpTopic.label,0,theTopicSelectionList);

                    tmpTopic = theCurrentViewObject.NextTopic();
                }

                var theTopicIndexStr = '';
                var theTopicIndex = parseInt(theTopicIndexStr);
                if (isNaN(theTopicIndex) == false )
                    theTopicSelectionList.selectedIndex = theTopicIndex;
				else
	                theTopicSelectionList.selectedIndex = 0;

                // now load the statistics categories from the current topic

                var theTopicObject = theCurrentViewObject.GetTopic(theTopicSelectionList.selectedIndex);

                LoadStatsCategoryList(theTopicObject);

            }

        
            function LoadStatsCategoryList(aTopicObject) {

                // clear the list
                theStatsCategorySelectionList.options.length = 0;

                var aURLPair = aTopicObject.FirstURLPair();

                while (aURLPair != null ) {

                    AddSelectionListEntry(aURLPair.label,aURLPair.url,theStatsCategorySelectionList);

                    aURLPair = aTopicObject.NextURLPair();
                }

                // select the first list entry
                theStatsCategorySelectionList.options.selectedIndex = 0;
            }

         
            function OnChangeTopic() {
        
            var bUseGoButton = false;
        

            if ( bUseGoButton == false ) { 
                SwitchTopic();
            }
        }

         
            function SwitchTopic() {
                var aTopicObject = theCurrentViewObject.GetTopic(theTopicSelectionList.selectedIndex);
                LoadStatsCategoryList(aTopicObject);
            }

        
		
            function GoToPage() {
				
			
				
                var topicIndex = theTopicSelectionList.selectedIndex;
                var categoryIndex = theStatsCategorySelectionList.selectedIndex;
				if (theStatsCategorySelectionList.options[theStatsCategorySelectionList.selectedIndex].value !=''){
                var secondguy = theStatsCategorySelectionList.options[theStatsCategorySelectionList.selectedIndex].value;
				openWindow(player1,secondguy);
				}
               
            }
			
			

        
            function AddSelectionListEntry(entryString,entryValue,aSelectListObject) {

                if ( isNav == true ) {
                    var oOption = new Option(entryString,entryValue);
                    aSelectListObject.options[aSelectListObject.options.length] = oOption;
                }
                else {
                    var oOption = document.createElement("option");
                    oOption.text = entryString;
                    oOption.value = entryValue;
                    aSelectListObject.add(oOption);
                }

            }

            //
            // Internet Explorer or Netscape?
            //
            function DetectBrowser() {

                if (parseInt(navigator.appVersion) >= 4) {
                    if (navigator.appName == "Netscape") {
                        isNav = true;
                    }
                    else {
                        isIE = true;
                    }
                }

            }

        
            function URLPair(urlLabel,urlTarget) {
                this.label = urlLabel;
                this.url = urlTarget;
            }

        
            function StatsTopic(topicLabel) {
                this.URLPairs = new Array();
                this.URLPairsIndex = 0;
                this.label = topicLabel;
                this.AddURL = StatsTopicAddURL;
                this.FirstURLPair = StatsTopicFirstURLPair;
                this.NextURLPair = StatsTopicNextURLPair;
            }

        
            function StatsTopicAddURL(aURLPair) {
                this.URLPairs[this.URLPairs.length] = aURLPair;
            }

        
            function StatsTopicFirstURLPair() {

                var aURLPair = null;

                if ( this.URLPairs.length > 0 ) {
                    this.URLPairsIndex = 0;
                    aURLPair = this.URLPairs[this.URLPairsIndex];
                    this.URLPairsIndex++;
                }

                return aURLPair;
            }

        
            function StatsTopicNextURLPair() {
                var aURLPair = null;

                if ( (this.URLPairs.length > 0) && (this.URLPairsIndex < this.URLPairs.length)  ) {
                    aURLPair = this.URLPairs[this.URLPairsIndex];
                    this.URLPairsIndex++;
                }

                return aURLPair;
            }
        
            function StatsView() {
                this.TopicArray = new Array();
                this.TopicArrayIndex = 0;
                this.AddTopic = StatsViewAddTopic;
                this.FirstTopic = StatsViewFirstTopic;
                this.NextTopic = StatsViewNextTopic;
                this.GetTopic = StatsViewTopicByIndex;
            }

        
            function StatsViewAddTopic(aTopicObject) {
                this.TopicArray[this.TopicArray.length] = aTopicObject;
            }

        
            function StatsViewFirstTopic() {
                var aTopicObject = null;

                if ( this.TopicArray.length > 0 ) {
                    this.TopicArrayIndex = 0;
                    aTopicObject = this.TopicArray[this.TopicArrayIndex];
                    this.TopicArrayIndex++;
                }

                return aTopicObject;
            }

        
            function StatsViewNextTopic() {
                var aTopicObject = null;

                if ( (this.TopicArray.length > 0) && (this.TopicArrayIndex < this.TopicArray.length)  ) {
                    aTopicObject = this.TopicArray[this.TopicArrayIndex];
                    this.TopicArrayIndex++;
                }

                return aTopicObject;
            }


        
            function StatsViewTopicByIndex(anIndex) {
                var aTopicObject = null;

                if ( anIndex < this.TopicArray.length) {
                    aTopicObject = this.TopicArray[anIndex];
                }

                return aTopicObject;
            }

            function InitializeStatsFinder() {

                // first set the browser type
                DetectBrowser();

                // set selection list variables
                if ( isNav == true ) {
                    theTopicSelectionList = document.TheForm.TheTopicSelectionList;
                    theStatsCategorySelectionList = document.TheForm.TheStatsCategoryList;
                }
                else {
                    theTopicSelectionList = document.all.TheTopicSelectionList;
                    theStatsCategorySelectionList = document.all.TheStatsCategoryList;
                }

                LoadViewObject(PlayersViewObject);

                // set the topic and category default selection if possible
                var theTopicIndexStr = '';
                var theTopicIndex = parseInt(theTopicIndexStr);
                if (isNaN(theTopicIndex) == false )
                    theTopicSelectionList.selectedIndex = theTopicIndex;

                var theStatsCategoryIndexStr = '';
                var theStatsCategoryIndex = parseInt(theStatsCategoryIndexStr);
                if (isNaN(theStatsCategoryIndex) == false)
                    theStatsCategorySelectionList.selectedIndex = theStatsCategoryIndex;

            }








		

