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
<TABLE border="0" cellPadding="0" cellSpacing="0" width=100%>
		<TR>
			<TD>
			<TABLE border="0" cellPadding="0" cellSpacing="0" width="100%">
			<TR>
				<TD class="cBTop" colSpan="3">
				<DIV class="cBTitle">STAT SEARCH</DIV></TD>
			</TR>
			<TR>
				<TD class="cBSide" noWrap><BR></TD>
				<TD align="left" class="cBComp" vAlign="top" width="100%">
        <script>

            var LeadersViewObject = new StatsView();
        

<?
	include('config.php');
	include('mysql.php');

/*
	var LeadersTopic0 = new StatsTopic('League Leaders');
	LeadersTopic0.AddURL(new URLPair('','viewstats.php?stat_type=&stat_view='));
	LeadersViewObject.AddTopic(LeadersTopic0);
*/

	$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

	$sql = "SELECT distinct SH.GAME_DATE, SE.SEASON, SH.GAME_TYPE
			FROM SCHEDULE SH
			INNER JOIN SEASON SE
			ON  SH.GAME_DATE BETWEEN SE.SEASON_SDTE AND SE.SEASON_EDTE
			order by sh.game_date";

	if ( !($result = $db->sql_query($sql)) ) {

	}

	$rowset = $db->sql_fetchrowset($result);

	$c_season = $rowset[0]["SEASON"];
	$p_season = "";
	$i = 0;
	$roundNum = 1;

	echo "var LeadersTopic$i = new StatsTopic('$c_season');\n";

	foreach ($rowset as $row) {
		$gameDate = $row["GAME_DATE"];
		$gameType = $row["GAME_TYPE"];

		$c_season = $row["SEASON"];
		if ($c_season != $p_season) {
			if ($p_season != "") {
				echo "LeadersViewObject.AddTopic(LeadersTopic$i);\n";
				$i++;	
				echo "var LeadersTopic$i = new StatsTopic('$c_season');\n";
			}
			$p_season = $c_season;
			$roundNum = 1;
		}
		
		switch ($gameType) {

			case 1:	$roundDesc = "Conference Quarter Final";
					break;
			case 2: $roundDesc = "Conference Semi Final";
					break;
			case 3: $roundDesc = "Conference Final";
					break;
			case 4: $roundDesc = "Season Final";
					break;
			case 0: $roundDesc = "Round $roundNum";
		}

		$displayRound = $roundNum - 1;

		echo "LeadersTopic$i.AddURL(new URLPair('$roundDesc','vieweffrecap.php?roundDate=$gameDate&seasonNumber=$i&round=$displayRound'));\n";
		$roundNum++;
	}


	echo "LeadersViewObject.AddTopic(LeadersTopic$i);\n";

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

                var theTopicIndexStr = '<? echo $seasonNumber; ?>';
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

                var theURL = theStatsCategorySelectionList.options[theStatsCategorySelectionList.selectedIndex].value;
                window.location = theURL;
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

                LoadViewObject(LeadersViewObject);

                // set the topic and category default selection if possible
                var theTopicIndexStr = '<? echo $seasonNumber; ?>';
                var theTopicIndex = parseInt(theTopicIndexStr);
//alert(theTopicIndexStr);                
                if (isNaN(theTopicIndex) == false )
                    theTopicSelectionList.selectedIndex = theTopicIndex;

                var theStatsCategoryIndexStr = '<? echo $round; ?>';
                var theStatsCategoryIndex = parseInt(theStatsCategoryIndexStr);
                if (isNaN(theStatsCategoryIndex) == false)
                    theStatsCategorySelectionList.selectedIndex = theStatsCategoryIndex;

            }

        </script>
<div class=statsFinderBackground>
        <table class=statsFinderTable cellspacing="0" cellpadding="0" border="0" width="100%">
        <form name="TheForm" style="margin: 0">
        <tr>
		<td class=statsFinderBackground nowrap width=10><br></td>
        
        <td class=statsFinderBackground>Select a Topic</td>
        <td class=statsFinderBackground>&nbsp;</td>
        <td class=statsFinderBackground>Select a Category</td>
        <td class=statsFinderBackground>&nbsp;</td>
        
        </tr>
        <tr>
		<td class=statsFinderBackground nowrap width=10><br></td>
        <td class=statsFinderBackground>
        
        <select name="TheTopicSelectionList" size="1" onchange="OnChangeTopic()">
        
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
        <td class=statsFinderBackground>
        
        &nbsp;
        
        </td>
        <td class=statsFinderBackground>
        <select name="TheStatsCategoryList" size="1" >
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
        <td class=statsFinderBackground>
        <input type=button value="GO" onclick="GoToPage()">
        </td>
        </tr>
        </form>
        </table>
</div>
        <script language="Javascript">
            InitializeStatsFinder();
        </script>


	</TD>
				<TD class="cBSide" noWrap><BR></TD>
			</TR>
			</TABLE>
			</TD>
		</TR>
	</TABLE>