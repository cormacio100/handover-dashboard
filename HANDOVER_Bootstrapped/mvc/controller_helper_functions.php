<?php

#--------------------------------------------------------------------------
#	Helper functions and variables for use with the Controller Functions
#--------------------------------------------------------------------------


# navigation bar displayed at top of screen (when logged in)
$nav='<ul id="navlist">
		<li><a href="./authHome">Home</a></li>
		<li><a href="./authIncident?searchParam=INTERNET">Internet</a></li>
		<li><a href="./authIncident?searchParam=RAN">RAN</a></li>
		<li><a href="./authIncident?searchParam=CRM">CRM</a></li>
		<li><a href="./authIncident?searchParam=BPOPS">B&amp;P Ops</a></li>
		<li><a href="./authIncident?searchParam=LEON">Leon</a></li>
		<li><a href="./authIncident?searchParam=SHIFTLEAD">Shift Lead</a></li>
		<li><a href="./authIncident?searchParam=DASHDISPLAYED">Dash Displayed</a></li>
		<li><a href="./authTicker" class="lastTab">Ticker</a></li>	
	</ul>';

/**
 * Function builds a string for a user category SELECT box
 * 
 * @param $userCat - category retrieved from DB
 * @return $catMenu - HTML SELECT string 
 */
function getUserCatMenu($userCat=null) 
{
	$catMenu = '<div id="editCat" name="editCat" class="grid_3">
					<select name="userCat">
						<option value="general">General</option>
						<option value="admin">Admin</option>
					</select>
				</div> ';

	$catLen = strLen($userCat);

	if ($catLen > 0) 
	{
		$catMenu = htmlSelected($catMenu, $userCat, $catLen);
	}
	return $catMenu;
}

/**
 * Function returns the traffic light menu
 * 
 * @param $colour - Value passed in to the function which will be selected
 * @return
 */
function getTrafficLightMenu($colour=null,$menuName=null,$menuLabel=null)
{
	$trafficLightMenu='
		<label for="'.$menuName.'">'.$menuLabel.':</label>
		<select id="'.$menuName.'" name="'.$menuName.'">
			<option value="green">GREEN</option>
			<option value="amber">AMBER</option>
			<option value="red">RED</option>
		</select> ';
	
	$menuLen = strLen($colour);

	if ($menuLen > 0) 
	{
		$trafficLightMenu = htmlSelected($trafficLightMenu, $colour, $menuLen);
	}
	return $trafficLightMenu;
}

/**
 * Function builds a string for a user category SELECT box
 * 
 * @param $incStatus - status retrieved from DB
 * @return $incStatusMenu - HTML SELECT string 
 */
function getIncStatusMenu($incStatus=null) 
{
	$incStatusMenu = '<select name="incStatus" id="incStatus">
				<option value="Open">Open</option>
				<option value="Closed">Closed</option>
			</select> ';

	$incStatusLen = strLen($incStatus);

	if ($incStatusLen > 0) 
	{
		$incStatusMenu= htmlSelected($incStatusMenu, $incStatus, $incStatusLen);
	}
	return $incStatusMenu;
}

/**
 * Function builds a string for a user category SELECT box
 * 
 * @param $$incDashDisplay - Dash Display status retrieved from DB
 * @return $incDashDisplayMenu - HTML SELECT string 
 */
function getDashDisplayMenu($incDashDisplay=null) 
{
	//echo 'incDashDisplay '.$incDashDisplay;
	//exit;
	
	$incDashDisplayMenu = '<select name="incDashDisplay">
				<option value="No">No</option>
				<option value="Major-Incident">Major-Incident</option>
				<option value="Minor-Incident">Minor-Incident</option>
			</select> ';

	$incDashDisplayLen = strLen($incDashDisplay);

	if ($incDashDisplayLen > 0) 
	{
		$incDashDisplayMenu=htmlSelected($incDashDisplayMenu, $incDashDisplay, $incDashDisplayLen);
	}
	return $incDashDisplayMenu;
}

/**
 * Function Dynamically inserts the SELECTED tag into a SELECT list depending on the value that was selected previously
 * 
 * @param $menu - the SELECT menu string
 * @param $dbVal - the value pulled from the DB
 * @param $dbVarLen - the length of the DB value String 
 */
function htmlSelected($menu, $dbVal, $dbVarLen) 
{

	#Position of start of word
	$pos = strpos($menu, $dbVal);

	# Position of end of word
	$pos = $pos + $dbVarLen;

	# Convert position number to integer and add 1
	$pos = (int)$pos;
	$pos = $pos + 1;

	# Convert position number back to string and split the status string into 2 substrings depeneding on where the searched for inc_status is found
	$subString1 = substr($menu, 0, $pos);

	# Add the SELECTED tag to the string
	$subString1 = $subString1 . " SELECTED";
	$subString2 = substr($menu, $pos, -1);

	# combine the two strings again
	$menu = $subString1 . $subString2;

	return $menu;
}