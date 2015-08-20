<?php

#------------------------------------------
#	Database Functions. 
#	Utilises the Database class
#------------------------------------------

 /**
  * Function checks DB if a user is able to log in or not
  * 
  * @return $authenticatedUser array containiing user details
  */ 
 function isValidUsernamePassword($userLogin,$userPassword)
 {
 	# default value
 	$authenticated=array();	
		
 	# create a database object	
	$db=new Database();
	
	# create query
	$query="SELECT userFName,userSName,userCat FROM user WHERE userName='".$userLogin."' AND userPassword='".$userPassword."' LIMIT 1";
	
	$authenticatedUser=$db->getSingleRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $authenticatedUser;
 }
  
  /**
   * Function updates DB if a user is able to log in or not
   * 
   * @param $_POST['createTicker']) - button was pressed value
   * @return $tickerUpdated boolean value
   */ 
 function newTicker($tickerDesc)
 {
 	$tickerDesc='';	
		
 	# create a database object	
	$db=new Database();
	
	if(isset($_POST['createTicker']))
	{
		$tickerDesc=filter_input(INPUT_POST,'tickerDesc',FILTER_SANITIZE_STRING);
	}
	
	# create a query
	$query="UPDATE ticker SET tickerDesc = '$tickerDesc' WHERE tickerDisplay='yes'";
	
	$tickerUpdated=$db->updateRecord($query);
	
	return $tickerUpdated;
 }
  
 /**
  * Function retrieves Ticker Description from the DB and parses it into AJAX
  * 
  * @return $displayTicker['tickerDesc'] - ticker to be display across screen
  */
 function getTicker()
 {
 	$displayTicker=array();		
		
 	# create a database object	
	$db=new Database();
	
	# create a query
	$query="SElECT tickerDesc FROM TICKER WHERE tickerDisplay='yes' LIMIT 1";
	
	$displayTicker=$db->getSingleRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $displayTicker['tickerDesc'];
 }
 
 /**
  * Function retrieves details of all the users active on the system
  * 
  * @return $userArray - mutlidimensional array containing all user details
  */
 function getAllUsers()
 {
 	$userArr=array();
	
 	# create a database object	
	$db=new Database();
	
	# create a query
	$query="SELECT * FROM user WHERE userActive='yes' ORDER BY userSName,userFName DESC";
	
	# execute query and save result to an array
	$userArr=$db->getMultiRecords($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $userArr;
 }

 /**
  * Function retrieves details of a single user
  * 
  * @param $userId for that user
  */
function getUser($userId)
{
 	$userArr=array();	
		
 	# create a database object	
	$db=new Database();
	
	# create a query
	$query="SElECT * FROM user WHERE userId='".$userId."' LIMIT 1";
	
	$userArr=$db->getSingleRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $userArr;
}


/**
 * Function retrieves available user categories
 * 
 * @return $catArr - array that holds different user categories
 */
function findUserCat() 
{
	# create a database object	
	$db=new Database();
	
	# create the query
	$query='SELECT userCat FROM user';
	
	# execute query and save result to an array
	$catArr=$db->getMultiRecords($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $catArr;	
}

/**
 * Function creates a new user
 * 
 * @param $userFName,$userSName,$userEmail,$userLogin,$userPasswordEncrypted,$userCat
 * @return - boolean value depending on if value was updated
 */
 function createUser($userFName,$userSName,$userEmail,$userLogin,$userPasswordEncrypted,$userCat)
 {
 	$createUser=false;	
		
 	# create a database object	
	$db=new Database();
	
	# create the query
	$query="INSERT INTO `user` (`userId`, `userFName`, `userSName`, `userLogin`, `userPassword`, `userCat`, `userEmail`, `userActive`) 
			VALUES(NULL,'".$userFName."','".$userSName."','".$userLogin."','".$userPasswordEncrypted."','".$userCat."','".$userEmail."','Yes')";
	
	
	# execute query and save result to an array
	$createUser=$db->updateRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $createUser;	
 }
/**
 * Function updates a user's details
 * 
 * @param $userId,$userFName,$userSName,$userEmail,$userLogin,$userPasswordEncrypted,$userCat
 * @return - boolean value depending on if value was updated
 */
 function updateUser($userId,$userFName,$userSName,$userEmail,$userLogin,$userPasswordEncrypted,$userCat)
 {
 	$updateUser=false;	
		
 	# create a database object	
	$db=new Database();
	
	# create the query
	$query="UPDATE user 
			SET userFName ='".$userFName."',userSName='".$userSName."',userLogin='".$userLogin."',userPassword='".$userPasswordEncrypted."', userCat='".$userCat."', userEmail='".$userEmail."'
			WHERE userId='".$userId."'";
	
	# execute query and save result to an array
	$updateUser=$db->updateRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $updateUser;	
 }

 /**
  * Function deletes a user from the list view by setting userActive status to 'No'
  * 
  * @param - $userId for the user to be deleted
  */
  function deleteUser($userId)
  {
  	$deleteUser=false;
	
 	# create a database object	
	$db=new Database();
	
	# create the query
	$query="UPDATE user 
			SET userActive='No'
			WHERE userId='".$userId."'";
	
	# execute query and save result to an array
	$deleteUser=$db->updateRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $deleteUser;		
	
  }
 
 /**
  * Function retrieves the values to be displayed on the dashboard admin form
  */
  function retrieveDashAdminValues()
  {
	$dashAdminArr=array();		
		
	# create a database object	
	$db=new Database();
	
	# create the query
	$query="SELECT * FROM dashStatus WHERE id='1' LIMIT 1";

	# execute query and save result to an array
	$dashAdminArr=$db->getSingleRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $dashAdminArr;		
  	
  }
 
 /**
  * Function updates dashBoard Admin values
  * 
  * @param all values on the dasshBoard admin page
  */
 function updateDashAdminDB($freeSms,$sectors,$netAvail2G,$trafVol2G,$netLocSuc2G,$netAvail3G,$trafVol3G,$voiceTraf2G,$callCompRate2G,
	$callSuccRate2G,$callCompRate3G,$callSuccRate3G,$dataVol2G,$edgeThru2G,$gprsThru2G,$dataVol3G,$pakSetSuc3G,$pakCompRate3G,
	$mmsCompRate,$smsCompRate,$pssVoice,$pssData,$pssMessaging,$pssRoaming,$pss2GNetwork,$pss3GNetwork,$essCustMgmnt,$essCustBill,$essServProv,$essTopUp,$essRetPos,
	$cssDataWareBI,$cssEmail,$cssNetwork,$cssTelePbx,$cssErpBss)
{
	# create array to hold individual query segments for each element on the page
	$sqlQueryArray = array();
	$updateDashAdmin=null;
	
	# create a database object	
	$db=new Database();

	# build the queries(plural)
	$updateQuery = "UPDATE dashStatus SET ";

	$sqlQueryArray['freeSms'] = "freeSms = '" . $freeSms . "' WHERE id='1';";
	$sqlQueryArray['sectors'] = "sectors='" . $sectors . "' WHERE id='1';";

	/*  CURRENT SERVICE STATUS QUERIES */
	$sqlQueryArray['pssVoice'] = "pssVoice='" . $pssVoice . "' WHERE id='1';";
	$sqlQueryArray['pssData'] = "pssData='" . $pssData . "' WHERE id='1';";
	$sqlQueryArray['pssMessaging'] = "pssMessaging='" . $pssMessaging . "' WHERE id='1';";
	$sqlQueryArray['pssRoaming'] = "pssRoaming='" . $pssRoaming . "' WHERE id='1';";
	$sqlQueryArray['pss2GNetwork'] = "pss2GNetwork='" . $pss2GNetwork . "' WHERE id='1';";
	$sqlQueryArray['pss3GNetwork'] = "pss3GNetwork='" . $pss3GNetwork . "' WHERE id='1';";
	$sqlQueryArray['essCustMgmnt'] = "essCustMgmnt='" . $essCustMgmnt . "' WHERE id='1';";
	$sqlQueryArray['essCustBill'] = "essCustBill='" . $essCustBill . "' WHERE id='1';";
	$sqlQueryArray['essServProv'] = "essServProv='" . $essServProv . "' WHERE id='1';";
	$sqlQueryArray['essTopUp'] = "essTopUp='" . $essTopUp . "' WHERE id='1';";
	$sqlQueryArray['essRetPos'] = "essRetPos='" . $essRetPos . "' WHERE id='1';";
	$sqlQueryArray['cssDataWareBI'] = "cssDataWareBI='" . $cssDataWareBI . "' WHERE id='1';";
	$sqlQueryArray['cssEmail'] = "cssEmail='" . $cssEmail . "' WHERE id='1';";
	$sqlQueryArray['cssNetwork'] = "cssNetwork='" . $cssNetwork . "' WHERE id='1';";
	$sqlQueryArray['cssTelePbx'] = "cssTelePbx='" . $cssTelePbx . "' WHERE id='1';";
	$sqlQueryArray['cssErpBss'] = "cssErpBss='" . $cssErpBss . "' WHERE id='1';";

	/*	NETWORK SERVICE CHECKS QUERIES	*/
	$sqlQueryArray['netAvail2G'] = "netAvail2G='" . $netAvail2G . "' WHERE id='1';";
	$sqlQueryArray['trafVol2G'] = "trafVol2G='" . $trafVol2G . "' WHERE id='1';";
	$sqlQueryArray['netLocSuc2G'] = "netLocSuc2G='" . $netLocSuc2G . "' WHERE id='1';";
	$sqlQueryArray['netAvail3G'] = "netAvail3G='" . $netAvail3G . "' WHERE id='1';";
	$sqlQueryArray['trafVol3G'] = "trafVol3G='" . $trafVol3G . "' WHERE id='1';";
	$sqlQueryArray['voiceTraf2G'] = "voiceTraf2G='" . $voiceTraf2G . "' WHERE id='1';";
	$sqlQueryArray['callCompRate2G'] = "callCompRate2G='" . $callCompRate2G . "' WHERE id='1';";
	$sqlQueryArray['callSuccRate2G'] = "callSuccRate2G='" . $callSuccRate2G . "' WHERE id='1';";
	$sqlQueryArray['callCompRate3G'] = "callCompRate3G='" . $callCompRate3G . "' WHERE id='1';";
	$sqlQueryArray['callSuccRate3G'] = "callSuccRate3G='" . $callSuccRate3G . "' WHERE id='1';";
	$sqlQueryArray['dataVol2G'] = "dataVol2G='" . $dataVol2G . "' WHERE id='1';";
	$sqlQueryArray['$_edgeThru2G'] = "edgeThru2G='" . $edgeThru2G . "' WHERE id='1';";
	$sqlQueryArray['gprsThru2G'] = "gprsThru2G='" . $gprsThru2G . "' WHERE id='1';";
	$sqlQueryArray['dataVol3G'] = "dataVol3G='" . $dataVol3G . "' WHERE id='1';";
	$sqlQueryArray['pakSetSuc3G'] = "pakSetSuc3G='" . $pakSetSuc3G . "' WHERE id='1';";
	$sqlQueryArray['pakCompRate3G'] = "pakCompRate3G='" . $pakCompRate3G . "' WHERE id='1';";
	$sqlQueryArray['mmsCompRate'] = "mmsCompRate='" . $mmsCompRate . "' WHERE id='1';";
	$sqlQueryArray['smsCompRate'] = "smsCompRate='" . $smsCompRate . "' WHERE id='1';";
	
	# Each loop creates the Update query for each of the elements of the sqlQueryArray 
	foreach ($sqlQueryArray as $key => $value) 
	{
		$sqlQueryArray['$key'] = $value;

		$query = $updateQuery.$value;
		
		echo $query.'<br>';
		
		# execute each query and temp store result as a boolean before overwriting
		$updateDashAdmin=$db->updateRecord($query);
		
		# if one of the updates fail then notify the user immediately for them to retry submiting the form
		if(false==$updateDashAdmin)
			return $updateDashAdmin;
	}
	
	# housekeeping - remove reference to object
	unset($db);
	
	# if all updates were a success
	return $updateDashAdmin;		
}
 
 /**
  * Function looks up DB for incidents
  * 
  * @param $searchParam - type of incident raised
  * @param $start - start record
  * @param $end - number of records
  * @return $incsArr - array holding records for result
  */
 function getIncRecordArr($searchParam,$start=0,$count=0)
 {
 	$incArr=array();	
		
 	# create a database object	
	$db=new Database();
	
	# create the query 
	$query="SELECT incId,incStatus,incRef,incDesc,DATEDIFF( NOW( ),incStartDate ) AS incDurationDays, incCat FROM incident WHERE incStatus='Open'";
	
	# DASHDISPLAYED query is different from other queries
	if('DASHDISPLAYED'==$searchParam)
	{
		$query.="AND incDashDisplay!='No'";
	}
	else 
	{
		$query.="AND incCat='".$searchParam."'";
	}
	
	$query.=" ORDER BY incStartDate DESC";
	
	# check the start and end values
	if($start!=1 && $count!=0)
	{
		$query.=" LIMIT ".$start.", ".$count;
	}
	
	# execute query and save result to an array
	$incArr=$db->getMultiRecords($query);

	# Need to record the sqlQuery itself so that it can be used by the export file
	if ($incArr) 
	{
		$incArr[0]['sqlQuery'] = $query;
	}
	
	# housekeeping - remove reference to object
	unset($db);	
	
	return $incArr;	
 }

/**
 * Function returns a single incident record
 */
function getIncRecord($incId)
{
	$singleIncArr=array();
	
	# create a database object	
	$db=new Database();
	
	# create the query
	$query="SELECT * FROM incident WHERE incId='".$incId."'";
	
	# execute query and save result to an array
	$singleIncArr=$db->getSingleRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);	
	
	return $singleIncArr;	
}
 
 /**
  * Function adds an incident to the database
  * 
  * @param $incStatus
  * @param $incRef
  * @param $incDesc
  * @param $incDashDisplay
  * @return $incAdded - boolean value for whether incident has updated or not
  */
 function addIncident($incCat,$incStatus,$incRef,$incDesc,$incDashDisplay,$userId)
 {
  	$incAdded=null;
		
 	# create a database object	
	$db=new Database();
	
	$incStartDate=date("Y-m-d G:i:s");
	
	# create the query
	$query="INSERT INTO `incident` (`incId`, `incStatus`, `incCat`, `incStartDate`, `incFinishDate`, `incRef`, `incDesc`, `incUpdatedOn`, `incDashDisplay`,`_userId`) 
			VALUES(NULL,'".$incStatus."','".$incCat."','".$incStartDate."','NULL','".$incRef."','".$incDesc."',CURRENT_TIMESTAMP, '".$incDashDisplay."', '".$userId."')";
	
	# execute query and save result to an array
	$incAdded=$db->updateRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $incAdded;		
 }
 
 /**
  * Function updates an incident on the DB
  * 
  * @param $incId,$incCat,$incStatus,$incRef,$incDesc,$incDashDisplay
  * @return boolean value to show if updated or not
  */
 function updateIncident($incId,$incCat,$incStatus,$incRef,$incDesc,$incDashDisplay,$userId)
 {
 	$incUpdated=null;
	
	# create a database object	
	$db=new Database();
	
	# create the query
	$query="UPDATE incident 
			SET incStatus='".$incStatus."',
				 incCat='".$incCat."', 
				 incRef='".$incRef."',
				 incDesc='".$incDesc."', 
				 incUpdatedOn=CURRENT_TIMESTAMP, 
				 incDashDisplay='".$incDashDisplay."',
				 _userId='".$userId."'";
	
	# if the incident is closed then the finishDate should get set	
	if('Closed'==$incStatus)
	{
		$query.=",incFinishDate=CURRENT_TIMESTAMP";
	}		
	
	$query.=" WHERE incId='".$incId."'";
	
				 
	# execute query and save result to an array
	$incUpdated=$db->updateRecord($query);
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $incUpdated;	
 }
 
 /**
  * Function executes the query that produces results and builds a String that will be exported to excel
  * 
  * @param $queryExport - the query for the results
  * @return $xlsDataArr - results parsed into a String saved in an array with key of header and data
  */
 function exportMysqlToExcel($queryExport)
 {
 	$resultToExportArr=array();
	$xlsDataArr=array();
	
 	# create a database object	
	$db=new Database();
	
	# execute query and save result to an array
	$resultObj=$db->getRecordSet($queryExport);
	
	# retrieve number of fields in result
	$count = mysqli_num_fields($resultObj);
	
	$header = "";
	$data = "";
	
	# retrieve a string of header names
	for ($i = 0; $i < $count; $i++) 
	{
		$header .= mysqli_fetch_field_direct($resultObj, $i)->name . "\t";
	}

	# save headers to array
	$xlsDataArr['header']=$header;
	
	# retrieve data from result object and build a string
	while ($row = mysqli_fetch_row($resultObj)) 
	{
		$line = '';
		foreach ($row as $value) 
		{
			if (!isset($value) || $value == "") 
			{
				$value = "\t";
			} 
			else 
			{
				# important to escape any quotes to preserve them in the data.
				$value = str_replace('"', '""', $value);
				# needed to encapsulate data in quotes because some data might be multi line.
				# the good news is that numbers remain numbers in Excel even though quoted.
				$value = '"' . $value . '"' . "\t";
			}

			$line .= $value;
		}

		$data .= trim($line) . "\n";
	}
	# this line is needed because returns embedded in the data have "\r"
	# and this looks like a "box character" in Excel
	$data = str_replace("\r", "", $data);

	# Nice to let someone know that the search came up empty.
	# Otherwise only the column name headers will be output to Excel.
	if ($data == "") {
		$data = "\nno matching records found\n";
	}	
	
	#save data to array
	$xlsDataArr['data']=$data;
	
	# housekeeping - remove reference to object
	unset($db);
	
	return $xlsDataArr;
 }

###############################################################################
# QUERIES FOR DASHBOARD AJAX REQUESTS

/**
 * Function looks up dashStatus table for free sms stats
 * 
 * @return $record - stats from dasDisplay table
 */
function getDashStat($query,$var)
{
	# create a database object	
	$db=new Database();

	# execute query and save result to an array
	$recordArr=$db->getSingleRecord($query);

	# housekeeping - remove reference to object
	unset($db);

	# return the variable from the array
	return $recordArr[$var];
}


/**
 * Function returns an array of incidents that are classed as Major Incidents
 * 
 * @return - $recordsArray
 */
function getMajorIncidents() 
{
	# create a database object	
	$db=new Database();
	
	# create the query
	$query = "SELECT incRef, incDesc 
				FROM incident
				WHERE incDashDisplay='Major-Incident'
				AND incStatus='Open'";

	# execute query and save results to an array
	$recordsArray=$db->getMultiRecords($query);

	# housekeeping - remove reference to object
	unset($db);

	return $recordsArray;
}

/**
 * Function returns an array of incidents that are classed as Major Incidents
 * 
 * @return - $recordsArray
 */
function getMinorIncidents() 
{
	# create a database object	
	$db=new Database();
	
	$query = "SELECT incRef, incDesc 
				FROM incident
				WHERE incDashDisplay='Minor-Incident';";

	# execute query and save results to an array
	$recordsArray=$db->getMultiRecords($query);

	# housekeeping - remove reference to object
	unset($db);

	return $recordsArray;
}
 