<?php

#------------------------------------------
#	Authorised Access Controller Functions
#------------------------------------------


# start or resume a session
if(!isset($_SESSION))
{
    session_start();
	ob_start();
}

/**
 * Function provides access to authorised home page
 * User has options to choose which part of the handover they want to access
 */
function authHome()
{
	global $twig;
	//global $nav;
	
	$loggedInText=null;
	$userCat=null;


	# check if user is authenticated
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
		if(isset($_SESSION['userCat']))
		{
			$userCat=$_SESSION['userCat'];
		}
	}

	# retrieve the ticker value
	$ticker=getTicker();
	
	$args_array=array(
		'loggedInText' 	=> $loggedInText,
		'ticker' 		=> $ticker,
		//'nav'			=> $nav,
		'userCat'		=> $userCat,
	);
	$template='auth_home';
	echo $twig->render($template.'.html.twig',$args_array);	
}


/**
 * Function displays a list of incidents (DEPENDING ON CATEGORY) or else a form to enter one
 */
function authIncident()
{
	global $twig;

	$loggedInText=null;
	$userCat=null;
	$searchParam=null;
	$searchParamArr=array();
	$arraysearchParamIncs=array();
	$displayCreateBtn='Yes';
	$incId=0;
	$button='createInc';
	$buttonVal='create';
	
	# used for LIMITING the query for each page
	$pageSize=5;
	$pageNum=1;
	$start=0;	# starting limiter for query
	$count=5;	# count for num records to retrieve
			
	$action='./authAddIncident';	# default action to be used in form
	$totalRecords=0;
	
	# check if user is authenticated
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
		if(isset($_SESSION['userCat']))
		{
			$userCat=$_SESSION['userCat'];
		}
	}
	
	# retrieve the ticker value
	$ticker=getTicker();
	
	# determine what the search is for
	if(isset($_GET['searchParam']))
	{
		$searchParam=filter_input(INPUT_GET,'searchParam',FILTER_SANITIZE_STRING);

    	# default message if no incidennts are found for this search parameter
		$message='No Incidents found for <span class="orange">'.$searchParam.'</span><BR>Create a new Incident';
	}
	else
	{
		# display error if no searchParams found
		header('Location: ./messageDisplay?messageId=0');		
		exit;
	}
	
	# get the total number of incidents of type RAN
	$totalRecords=sizeof(getIncRecordArr($searchParam));
	
	# check what values have been passed in by Pager links to see if start and count limit have changed
	# then retrieve incidents for this searchParam
	if(isset($_GET['start']) && isset($_GET['count']))
	{
		$start=filter_input(INPUT_GET,'start',FILTER_SANITIZE_NUMBER_INT);
		$count=filter_input(INPUT_GET,'count',FILTER_SANITIZE_NUMBER_INT);
	}

	# create incident screen gets displayed if the totalRecords values is set to 0. 
	# check if the createInc button was pressed on the incident listings page
	# Retrieve value from POST if the button is clicked, in which case set totalRecords to 0
	if(isset($_GET['createInc']))
	{
		# CREATE BUTTON PRESSED FROM INCIDENT LIST PAGE
		
		$totalRecords=0;
		$button='createInc';
		$buttonVal='create';
		$message='Create a new Incident for '.$searchParam; 
		
		//echo '<br>totalRecords line 131-'.$totalRecords;
	}
	else if(isset($_GET['updateInc']) && isset($_GET['incId']))
	{
		# UPDATE BUTTON PRESSED FROM INCIDENT LIST PAGE
		
		# retrieve the incident ID	
		$incId=filter_input(INPUT_GET,'incId',FILTER_SANITIZE_NUMBER_INT);	
	
		# change message at top of screen
		$message='Update <span class="orange">'.$searchParam.'</span> Incident.<br>  ID: <span class="orange">'.$incId.'</span>';
		
		$totalRecords=0;
		$button='updateInc';
		$buttonVal='update';
		
		# retrieve the incident values based on incident ID
		$incToUpdateArr=getIncRecord($incId);
		
		# retrieve values and build menus with relevant options selected
		$incStatus=$incToUpdateArr['incStatus'];

		$incRef=$incToUpdateArr['incRef'];
		$incDesc=$incToUpdateArr['incDesc'];
		
		$incDashDisplay=$incToUpdateArr['incDashDisplay'];
		# action to be used in form
		$action='./authUpdateIncident';
	}

	# Create Incident button doesn't display for DashDisplay incidents
	if('DASHDISPLAYED'==$searchParam)
	{
		$displayCreateBtn='No';
	}

	$args_array=array(
		'loggedInText' 		=> $loggedInText,
		'ticker' 			=> $ticker,
		'userCat'			=> $userCat,
		'searchParam'		=> $searchParam,
		'message'			=> $message,
		'displayCreateBtn' 	=> $displayCreateBtn,
	);
	
	# if no previous incidents found
	if($totalRecords==0)
	{
		# add a button to the template
		$args_array['button']=$button;
		$args_array['buttonVal']=$buttonVal;
		
		# add this to the argsArray
		$args_array['action']=$action;
		
		# check if incId has been set and if so need to add template variables
		if($incId)
		{
			# when updateInc button is pressed the inc values populate the form
			$args_array['incId']=$incId;
			$args_array['incStatus']=$incStatus;
			$args_array['incRef']=$incRef;
			$args_array['incDesc']=$incDesc;
			$args_array['incDashDisplay']=$incDashDisplay;
		}
		
		$template='auth_incident';
		echo $twig->render($template.'.html.twig',$args_array);
		exit;
	}
	else 
	{
		# retrieve the records
		$incArr=getIncRecordArr($searchParam,$start,$count);
		
		# the address of this function
		$url='./authIncident';
		
		# generating and displaying the pager links at the bottom of the screen when results are returned	
		$searchParamArr['searchParam']=$searchParam;
		
		# create an object of dbPager class
		$pager = new DBPager($totalRecords,$pageSize,$searchParamArr,$url);
		
		# retrieve links string
		$links=$pager->displayNavLinks();
		
		# the query will be used to export results to excel
		$queryExport = $incArr[0]['sqlQuery'];
		
		# add the array of incidents to be displayed 
		$args_array['incArr']=$incArr;
		$args_array['totalRecords']=$totalRecords;
		$args_array['links']=$links;
		
		# add the query to the s_SESSION array to be used in the template
		$_SESSION['queryExport']=$queryExport;	
		$_SESSION['searchParam']=$searchParam;
	}
		
	$template='auth_incident_list';
	echo $twig->render($template.'.html.twig',$args_array);
}

/**
 * Function inserts a new incident into the DB 
 */
function authAddIncident()
{
	//print_r($_POST);
	//EXIT;
	 $incCat=null;
	 $incStatus=null;
	 $incRef=null;
	 $incDesc=null;
	 $incDashDisplay=null;
	 $userId=0;
	 $incAdded=null;
	 
	# check if user is authenticated
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['userId']))
		{
			$userId=$_SESSION['userId'];
		}
	} 
	else
	{
		# unauthorised access
		header('Location: ./messageDisplay?messageId=1');	
		exit;
	}
	# check that the form button was pressed before 
 	if(isset($_POST['createInc']))
	{		
		if(isset($_POST['incCat']))
			$incCat=trim(filter_input(INPUT_POST,'incCat',FILTER_SANITIZE_STRING));
		if(isset($_POST['incStatus']))
			$incStatus=trim(filter_input(INPUT_POST,'incStatus',FILTER_SANITIZE_STRING));
		if(isset($_POST['incRef']))
			$incRef=trim(filter_input(INPUT_POST,'incRef',FILTER_SANITIZE_NUMBER_INT));
		if(isset($_POST['incDesc']))
			$incDesc=trim(filter_input(INPUT_POST,'incDesc',FILTER_SANITIZE_STRING));
		if(isset($_POST['incDashDisplay']))
			$incDashDisplay=trim(filter_input(INPUT_POST,'incDashDisplay',FILTER_SANITIZE_STRING));

		# update the database with the new ticker
		$incAdded=addIncident($incCat,$incStatus,$incRef,$incDesc,$incDashDisplay,$userId);
	}

	if($incAdded)
	{
		header('Location: ./messageDisplay?messageId=13&searchParam='.$incCat);		
		exit;
	}
	else
	{
		header('Location: ./messageDisplay?messageId=14&searchParam='.$incCat);		
		exit;
	}

}

/**
 * Function updates an incident
 * 
 * @param - $_POST array values
 */
function authUpdateIncident()
{
	$incId=null;	
	$incCat=null;
	$incStatus=null;
	$incRef=null;
	$incDesc=null;
	$incDashDisplay=null;
	$userId=0;
	$incAdded=null;
	 
	# check if user is authenticated
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['userId']))
		{
			$userId=$_SESSION['userId'];
		}
	} 	
	else
	{
		# unauthorised access
		header('Location: ./messageDisplay?messageId=1');	
		exit;
	}
	
	
	# check that the form button was pressed before 
 	if(isset($_POST['updateInc']))
	{
		if(isset($_POST['incId']))
			$incId=trim(filter_input(INPUT_POST,'incId',FILTER_SANITIZE_STRING)); echo 'incId is '.$incId;
		if(isset($_POST['incCat']))
			$incCat=trim(filter_input(INPUT_POST,'incCat',FILTER_SANITIZE_STRING));
		if(isset($_POST['incStatus']))
			$incStatus=trim(filter_input(INPUT_POST,'incStatus',FILTER_SANITIZE_STRING));
		if(isset($_POST['incRef']))
			$incRef=trim(filter_input(INPUT_POST,'incRef',FILTER_SANITIZE_NUMBER_INT));
		if(isset($_POST['incDesc']))
			$incDesc=trim(filter_input(INPUT_POST,'incDesc',FILTER_SANITIZE_STRING));
		if(isset($_POST['incDashDisplay']))
			$incDashDisplay=trim(filter_input(INPUT_POST,'incDashDisplay',FILTER_SANITIZE_STRING));

		
		# update the database record
		$incUpdated=updateIncident($incId,$incCat,$incStatus,$incRef,$incDesc,$incDashDisplay,$userId);
		
		if($incUpdated)
		{
			header('Location: ./messageDisplay?messageId=13&searchParam='.$incCat);		
			exit;
		}
		else
		{
			header('Location: ./messageDisplay?messageId=14&searchParam='.$incCat);		
			exit;
		}		
	}
}

/**
 * Function exports results of query to excel
 */
function authExportMySqlToExcel()
{
	$queryExport=null;
	$exported=null;
	$resultToExportArr=null;
	$searchParam=null;
	$xlsDataStr=null;
	$header = "";
	$data = "";
	$limitPos=null;

	
	# check if user is authenticated
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['searchParam']))
		{
			$searchParam=$_SESSION['searchParam'];
		}
		if(isset($_SESSION['queryExport']))
		{
			$queryExport=$_SESSION['queryExport'];
		}
	}

	# if a limit is contained in string then it needs to be removed as ALL results are to be exported
	$limitPos=strpos($queryExport,'LIMIT');
	
	$queryExport=substr($queryExport,0,$limitPos);

	# retrieve array containing headers and data to be exported
	$xlsDataArr=exportMysqlToExcel($queryExport);
	
	# unset the SESSION value
	unset($_SESSION['queryExport']);
	
	# if query failed and nothing to export then display an error message
	if(!$xlsDataArr)
	{
		# display error and forward back to incident list page
		header('Location: ./messageDisplay?messageId=15&searchParam='.$searchParam);	
		exit;
	}
	
	$header=$xlsDataArr['header'];
	$data=$xlsDataArr['data'];

	# This line will stream the file to the user rather than spray it across the screen
	header("Content-Type: application/vnd.ms-excel; name='excel'");

	$xlsData = $header . "\n" . $data;

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=excelfile.xls");
	header("Cache-Control: public");
	header("Content-length: " . strlen($xlsData));

	header("Content-type: application/octet-stream");

	header("Pragma: no-cache");
	header("Expires: 0");

	echo $header . "\n" . $data;
	
	ob_end_flush();
}

/**
 * Function provides access to authorised ticker page
 * Ticker provides a scrolling header accross top of page to notify users
 */
function authTicker()
{
	global $twig;
	global $nav;
	$loggedInText=null;

	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
	}
	
	# retrieve the ticker value
	$ticker=getTicker();
	
	$args_array=array(
		'loggedInText' 	=> $loggedInText,
		'ticker' 		=> $ticker,
		'nav'			=> $nav,
	);
	$template='auth_ticker';
	echo $twig->render($template.'.html.twig',$args_array);	
	
	ob_end_flush();
}

/**
 * Function updates the database with the value entered for ticker
 * 
 * @param $_POST['ticketDesc']
 */
 function authCreateTicker()
 {
 	$tickerDesc=null;
	
 	if(isset($_POST['tickerDesc']))
	{
		$tickerDesc=trim(filter_input(INPUT_POST,'tickerDesc',FILTER_SANITIZE_STRING));
	}

	# update the database with the new ticker
	$tickerUpdated=newticker($tickerDesc);
	
	if($tickerUpdated)
	{
		header('Location: ./messageDisplay?messageId=5');		
		exit;
	}
	else
	{
		header('Location: ./messageDisplay?messageId=6');
		exit;
	}
	
	ob_end_flush();
 }


 /**
 * Function forwards the user to the admin page selected
 * Page calls function using AJAX
 * 
 */
function authForwardTo()
{
	
	if(isset($_POST['goThere']))
	{
		$forwardTo=filter_input(INPUT_POST,'authSection',FILTER_SANITIZE_STRING);
		
		# Decide which page to send the user
		if('handover'==$forwardTo)
		{
			header('Location: ./authHome');		
		}
		else if('handoverAdmin'==$forwardTo)
		{
			header('Location: ./authAdmin');	
		}
		else if('dashboardAdmin'==$forwardTo)
		{
			header('Location: ./authDashAdmin');	
		}
		else if('dashboardClient'==$forwardTo)
		{
			header('Location: ./dashClient');	
		}
	}
}

 /**
 * Function Allows user access to Handover admin
 * Page calls function using AJAX
 * 
 */
function authAdmin()
{
	global $twig;
	global $nav;
	$search='users listed';
	$loggedInText=null;
	$userCat=null;
	
	# check if user authenticated
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
		if(isset($_SESSION['userCat']))
		{
			$userCat=$_SESSION['userCat'];
		}
	}
	
	# general Users should not have access to this page
	if('general'==$userCat)
	{
		header('Location: ./authHome');
		exit;
	}
	
	$userArr=array();
	
	$userArr=getAllUsers();
	
	$numUsers=sizeof($userArr);
	
	# retrieve the ticker value
	$ticker=getTicker();
	
	$args_array=array(
		'loggedInText' 	=> $loggedInText,
		'ticker' 		=> $ticker,
		'nav'			=> $nav,
		'userArr'		=> $userArr,
		'numUsers'		=> $numUsers,
		'search'		=> $search,
	);
	
	$template='auth_admin';
	
	echo $twig->render($template.'.html.twig',$args_array);	
	ob_end_flush();
}

/**
 * Function allows user to view ongoing CRs
 */
function authOnGoingCr()
{
    global $twig;
    $loggedInText=null;
    $crArray=array();


    if(isset($_SESSION['authenticated']))
    {
        if(isset($_SESSION['loggedInText']))
        {
            $loggedInText=$_SESSION['loggedInText'];
        }
    }

    # retrieve the ticker value
    $crArray=getCRs();

    print_r($crArray);

    $args_array=array(
        'loggedInText' 	=>  $loggedInText,
        'crDesc' 		=>  $crArray['crDesc'],
        'crDashDisplay' =>  $crArray['crDashDisplay'],
    );

    $template='auth_cr';
    echo $twig->render($template.'.html.twig',$args_array);

    ob_end_flush();
}

/**
 * Function saves OnGoing Cr list to DB
 */
function authUpdateOnGoingCr()
{
    //print_r($_POST);

    $crDesc=null;
    $crDashDisplay=null;

    if(isset($_POST['crDesc']))
    {
        $crDesc=trim(filter_input(INPUT_POST,'crDesc',FILTER_SANITIZE_STRING));
    }
    if(isset($_POST['crDashDisplay']))
    {
        $crDashDisplay=trim(filter_input(INPUT_POST,'crDashDisplay',FILTER_SANITIZE_STRING));
    }

    //echo 'crDesc is '.$crDesc;

    # update the database with the new ticker
    $crUpdated=updateCr($crDesc,$crDashDisplay);

    if($crUpdated)
    {
        header('Location: ./messageDisplay?messageId=16');
        exit;
    }
    else
    {
        header('Location: ./messageDisplay?messageId=17');
        exit;
    }

    ob_end_flush();

}

 /**
 * Function Allows user access to update statistics on the Dashboard admin page
 * 
 */
function authDashAdmin()
{
	global $twig;
	global $nav;
	$search='users listed';
	$loggedInText=null;
	$dashAdminArr=array();
    $dashAdminSelectArr=array();
	
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
	}
	
	# retrieve all values for dashboard
	$dashAdminArr=retrieveDashAdminValues();

    $dashAdminSelectArr['pssVoice']=$dashAdminArr['pssVoice'];
    $dashAdminSelectArr['pssData']=$dashAdminArr['pssData'];
    $dashAdminSelectArr['pssMessaging']=$dashAdminArr['pssMessaging'];
    $dashAdminSelectArr['pssRoaming']=$dashAdminArr['pssRoaming'];
    $dashAdminSelectArr['pss2GNetwork']=$dashAdminArr['pss2GNetwork'];
    $dashAdminSelectArr['pss3GNetwork']=$dashAdminArr['pss3GNetwork'];
    $dashAdminSelectArr['essCustMgmnt']=$dashAdminArr['essCustMgmnt'];
    $dashAdminSelectArr['essCustBill']=$dashAdminArr['essCustBill'];
    $dashAdminSelectArr['essServProv']=$dashAdminArr['essServProv'];
    $dashAdminSelectArr['essTopUp']=$dashAdminArr['essTopUp'];
    $dashAdminSelectArr['essRetPos']=$dashAdminArr['essRetPos'];
    $dashAdminSelectArr['cssDataWareBI']=$dashAdminArr['cssDataWareBI'];
    $dashAdminSelectArr['cssEmail']=$dashAdminArr['cssEmail'];
    $dashAdminSelectArr['cssNetwork']=$dashAdminArr['cssNetwork'];
    $dashAdminSelectArr['cssTelePbx']=$dashAdminArr['cssTelePbx'];
    $dashAdminSelectArr['cssErpBss']=$dashAdminArr['cssErpBss'];

//  /  print_r($dashAdminArr);exit;

	# Build HTML Menu Strings with correct option selected
	
	# Primary Service Status Section Menus
	/*$pssVoiceMenu 	=getTrafficLightMenu($dashAdminArr['pssVoice'],'pssVoice','Voice');
	$pssDataMenu   	=getTrafficLightMenu($dashAdminArr['pssData'],'pssData','Data');
	$pssMessagingMenu  	=getTrafficLightMenu($dashAdminArr['pssMessaging'],'pssMessaging','Messaging'); 
	$pssRoamingMenu  	=getTrafficLightMenu($dashAdminArr['pssRoaming'],'pssRoaming','Roaming'); 
	$pss2GNetworkMenu  	=getTrafficLightMenu($dashAdminArr['pss2GNetwork'],'pss2GNetwork','2G Network'); 
	$pss3GNetworkMenu  	=getTrafficLightMenu($dashAdminArr['pss3GNetwork'],'pss3GNetwork','3G Network'); 
	
	# Enablement Service Status Section Menus
	$essCustMgmntMenu 	=getTrafficLightMenu($dashAdminArr['essCustMgmnt'],'essCustMgmnt','Customer Management');
	$essCustBillMenu   	=getTrafficLightMenu($dashAdminArr['essCustBill'],'essCustBill','Customer Billing');
	$essServProvMenu  	=getTrafficLightMenu($dashAdminArr['essServProv'],'essServProv','Service Provisioning'); 
	$essTopUpMenu  		=getTrafficLightMenu($dashAdminArr['essTopUp'],'essTopUp','Top Up'); 
	$essRetPosMenu  	=getTrafficLightMenu($dashAdminArr['essRetPos'],'essRetPos','Retail/POS'); 
 
 	# Corporate Service Status Section Menus
	$cssDataWareBIMenu 	=getTrafficLightMenu($dashAdminArr['cssDataWareBI'],'cssDataWareBI','Data WareHouse/BI');
	$cssEmailMenu   	=getTrafficLightMenu($dashAdminArr['cssEmail'],'cssEmail','E-Mail');
	$cssNetworkMenu  	=getTrafficLightMenu($dashAdminArr['cssNetwork'],'cssNetwork','Network'); 
	$cssTelePbxMenu  	=getTrafficLightMenu($dashAdminArr['cssTelePbx'],'cssTelePbx','Telephony/PBX'); 
	$cssErpBssMenu  	=getTrafficLightMenu($dashAdminArr['cssErpBss'],'cssErpBss','ERP/BSS');  */
	
	$args_array=array(
	'nav'					=> $nav,
	'loggedInText'			=> $loggedInText,
	'freeSms' 				=> $dashAdminArr['freeSms'], 
	'sectors' 				=> $dashAdminArr['sectors'],
	//'pssVoiceMenu' 			=> $pssVoiceMenu,
	//'pssDataMenu' 			=> $pssDataMenu,
	//'pssMessagingMenu' 		=> $pssMessagingMenu,
	//'pssRoamingMenu' 		=> $pssRoamingMenu,
	//'pss2GNetworkMenu' 		=> $pss2GNetworkMenu,
	//'pss3GNetworkMenu' 		=> $pss3GNetworkMenu,
	//'essCustMgmntMenu' 		=> $essCustMgmntMenu,
	//'essCustBillMenu' 		=> $essCustBillMenu,
	//'essServProvMenu' 		=> $essServProvMenu,
	//'essTopUpMenu' 			=> $essTopUpMenu,
	//'essRetPosMenu' 		=> $essRetPosMenu,
	//'cssDataWareBIMenu' 	=> $cssDataWareBIMenu,
	//'cssEmailMenu' 			=> $cssEmailMenu,
	//'cssNetworkMenu' 		=> $cssNetworkMenu,
	//'cssTelePbxMenu' 		=> $cssTelePbxMenu,
	//'cssErpBssMenu' 		=> $cssErpBssMenu,
	'netAvail2G' 			=> $dashAdminArr['netAvail2G'], 
	'trafVol2G' 			=> $dashAdminArr['trafVol2G'], 
	'netLocSuc2G' 			=> $dashAdminArr['netLocSuc2G'], 
	'netAvail3G' 			=> $dashAdminArr['netAvail3G'], 
	'trafVol3G' 			=> $dashAdminArr['trafVol3G'], 
	'voiceTraf2G' 			=> $dashAdminArr['voiceTraf2G'], 
	'callCompRate2G' 		=> $dashAdminArr['callCompRate2G'], 
	'callSuccRate2G' 		=> $dashAdminArr['callSuccRate2G'], 
	'callCompRate3G' 		=> $dashAdminArr['callCompRate3G'], 
	'callSuccRate3G' 		=> $dashAdminArr['callSuccRate3G'], 
	'dataVol2G' 			=> $dashAdminArr['dataVol2G'], 
	'edgeThru2G' 			=> $dashAdminArr['edgeThru2G'], 
	'gprsThru2G' 			=> $dashAdminArr['gprsThru2G'], 
	'dataVol3G' 			=> $dashAdminArr['dataVol3G'], 
	'pakSetSuc3G' 			=> $dashAdminArr['pakSetSuc3G'], 
	'pakCompRate3G' 		=> $dashAdminArr['pakCompRate3G'], 
	'mmsCompRate' 			=> $dashAdminArr['mmsCompRate'],
	'smsCompRate' 			=> $dashAdminArr['smsCompRate'],
    'dashAdminSelectArr'     => $dashAdminSelectArr,
	);
	
	$template='auth_dash_admin';
	
	echo $twig->render($template.'.html.twig',$args_array);	
	ob_end_flush();
}

/**
 * Function updates the values for the dashboard admin section
 * 
 * @param $_POST array containg all values for Dashboard Admin
 */
function authDashboardAdminUpdate()
{
	//print_r($_POST);EXIT;
	
	# check button was pressed before doing update
	if(isset($_POST['updateDash']))
	{
		$freeSms=filter_input(INPUT_POST,'freeSms',FILTER_SANITIZE_STRING);
		$sectors=filter_input(INPUT_POST,'sectors',FILTER_SANITIZE_STRING);
		
		/* CURRENT SERVICE STATUS */
		$pssVoice=filter_input(INPUT_POST,'pssVoice',FILTER_SANITIZE_STRING);
		$pssData=filter_input(INPUT_POST,'pssData',FILTER_SANITIZE_STRING);
		$pssMessaging=filter_input(INPUT_POST,'pssMessaging',FILTER_SANITIZE_STRING);
		$pssRoaming=filter_input(INPUT_POST,'pssRoaming',FILTER_SANITIZE_STRING);
		$pss2GNetwork=filter_input(INPUT_POST,'pss2GNetwork',FILTER_SANITIZE_STRING);
		$pss3GNetwork=filter_input(INPUT_POST,'pss3GNetwork',FILTER_SANITIZE_STRING);
	
		/*	Enablement Service Status  */
		$essCustMgmnt=filter_input(INPUT_POST,'essCustMgmnt',FILTER_SANITIZE_STRING);
		$essCustBill=filter_input(INPUT_POST,'essCustBill',FILTER_SANITIZE_STRING);
		$essServProv=filter_input(INPUT_POST,'essServProv',FILTER_SANITIZE_STRING);
		$essTopUp=filter_input(INPUT_POST,'essTopUp',FILTER_SANITIZE_STRING);
		$essRetPos=filter_input(INPUT_POST,'essRetPos',FILTER_SANITIZE_STRING);
	
		/*	Corporate Services Status	*/
		$cssDataWareBI=filter_input(INPUT_POST,'cssDataWareBI',FILTER_SANITIZE_STRING);
		$cssEmail=filter_input(INPUT_POST,'cssEmail',FILTER_SANITIZE_STRING);
		$cssNetwork=filter_input(INPUT_POST,'cssNetwork',FILTER_SANITIZE_STRING);
		$cssTelePbx=filter_input(INPUT_POST,'cssTelePbx',FILTER_SANITIZE_STRING);
		$cssErpBss=filter_input(INPUT_POST,'cssErpBss',FILTER_SANITIZE_STRING);		
	
		/*	NETWORK SERVICE CHECKS VARIABLES	*/
		$netAvail2G=filter_input(INPUT_POST,'netAvail2G',FILTER_SANITIZE_NUMBER_INT);
		$trafVol2G=filter_input(INPUT_POST,'trafVol2G',FILTER_SANITIZE_NUMBER_INT);
		$netLocSuc2G= filter_input(INPUT_POST,'netLocSuc2G',FILTER_SANITIZE_NUMBER_INT);
		$netAvail3G=filter_input(INPUT_POST,'netAvail3G',FILTER_SANITIZE_NUMBER_INT);
		$trafVol3G= filter_input(INPUT_POST,'trafVol3G',FILTER_SANITIZE_NUMBER_INT);
		$voiceTraf2G=filter_input(INPUT_POST,'voiceTraf2G',FILTER_SANITIZE_NUMBER_INT);
		$callCompRate2G=filter_input(INPUT_POST,'callCompRate2G',FILTER_SANITIZE_NUMBER_INT);
		$callSuccRate2G=filter_input(INPUT_POST,'callSuccRate2G',FILTER_SANITIZE_NUMBER_INT);
		$callCompRate3G=filter_input(INPUT_POST,'callCompRate3G',FILTER_SANITIZE_NUMBER_INT);
		$callSuccRate3G=filter_input(INPUT_POST,'callSuccRate3G',FILTER_SANITIZE_NUMBER_INT);
		$dataVol2G=filter_input(INPUT_POST,'dataVol2G',FILTER_SANITIZE_NUMBER_INT);
		$edgeThru2G=filter_input(INPUT_POST,'edgeThru2G',FILTER_SANITIZE_NUMBER_INT);
		$gprsThru2G= filter_input(INPUT_POST,'gprsThru2G',FILTER_SANITIZE_NUMBER_INT);
		$dataVol3G=filter_input(INPUT_POST,'dataVol3G',FILTER_SANITIZE_NUMBER_INT);
		$pakSetSuc3G=filter_input(INPUT_POST,'pakSetSuc3G',FILTER_SANITIZE_NUMBER_INT);
		$pakCompRate3G=filter_input(INPUT_POST,'pakCompRate3G',FILTER_SANITIZE_NUMBER_INT);
		$mmsCompRate=filter_input(INPUT_POST,'mmsCompRate',FILTER_SANITIZE_NUMBER_INT);
		$smsCompRate=filter_input(INPUT_POST,'smsCompRate',FILTER_SANITIZE_NUMBER_INT);
		
		
		# Update the Database for the dashboard
		$dashUpdated=updateDashAdminDB($freeSms,$sectors,$netAvail2G,$trafVol2G,$netLocSuc2G,$netAvail3G,$trafVol3G,$voiceTraf2G,$callCompRate2G,
		$callSuccRate2G,$callCompRate3G,$callSuccRate3G,$dataVol2G,$edgeThru2G,$gprsThru2G,$dataVol3G,$pakSetSuc3G,$pakCompRate3G,
		$mmsCompRate,$smsCompRate,$pssVoice,$pssData,$pssMessaging,$pssRoaming,$pss2GNetwork,$pss3GNetwork,$essCustMgmnt,$essCustBill,$essServProv,$essTopUp,$essRetPos,$cssDataWareBI,$cssEmail,$cssNetwork,$cssTelePbx,$cssErpBss);
	
		if($dashUpdated)
		{
			header('Location: ./messageDisplay?messageId=11');
			exit;
		}
		else 
		{
			header('Location: ./messageDisplay?messageId=12');
			exit;
		}
	}
	else
	{
		header('Location: ./messageDisplay?messageId=12');
		exit;
	}
}



#------------------------------------------
#	ADMIN User create/delete/update section
#------------------------------------------

/**
 * Function displays form which allows admin user to create a new System user
 * 
 */
function authCreateUser()
{
	global $twig;
	//global $nav;
	$loggedInText=null;
	$userArr=array();
	$userId=null;
	
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
	}
	
	$userName='Create User: ';
	
	# retrieve catageories available for building a select menu with relevant option selected
	$catMenu = getUserCatMenu(); 
	
	# set the form action
	$action='./authUserCreated';
	
	# set the type of button
	$button='create';
	
	# retrieve the ticker value
	$ticker=getTicker();
	
	$args_array=array(
		'userId'	=> $userId,
		'loggedInText' 	=> $loggedInText,
		'ticker' 		=> $ticker,
		'userName'		=> $userName,
		'userArr'		=> $userArr,
		'catMenu'		=> $catMenu,
		'action'		=> $action,
		'button'		=> $button,
	);
	
	$template='auth_edit_user';
	echo $twig->render($template.'.html.twig',$args_array);	
	
	ob_end_flush();
}

/**
 * Function creates a new user base on details entered
 * 
 * @param $_POST array containing userFName, userSName, userEmail, userLogin, userPassword, userCat
 */
function authUserCreated()
{
	global $twig;
	global $nav;
	$loggedInText=null;
	
	# user variables
	//$userId=null;
	$userFName=null;
	$userSName=null;
	$userEmail=null;
	$userLogin=null;
	$userPassword=null;
	$userCat=null;
	
	$updated=false;	
	
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
	}
	
	
	# check that form was submitted else display an error message
	if(isset($_POST['create']))
	{
		if(isset($_POST['userFName']))
			$userFName=filter_input(INPUT_POST,'userFName',FILTER_SANITIZE_STRING);
		if(isset($_POST['userSName']))
			$userSName=filter_input(INPUT_POST,'userSName',FILTER_SANITIZE_STRING);
		if(isset($_POST['userEmail']))
			$userEmail=filter_input(INPUT_POST,'userEmail',FILTER_SANITIZE_EMAIL);
		if(isset($_POST['userLogin']))
			$userLogin=filter_input(INPUT_POST,'userLogin',FILTER_SANITIZE_STRING);
		if(isset($_POST['userPassword']))
		{
			$userPassword=filter_input(INPUT_POST,'userPassword',FILTER_SANITIZE_STRING);
			
			# encrypt			
			$userPasswordEncrypted=md5($userPassword);
		}
		if(isset($_POST['userCat']))
			$userCat=filter_input(INPUT_POST,'userCat',FILTER_SANITIZE_STRING);

		# update the database and check if successful
		$created=createUser($userFName,$userSName,$userEmail,$userLogin,$userPasswordEncrypted,$userCat);
		
		if($created)
		{
			header('Location: ./messageDisplay?messageId=7&user='.$userFName.' '.$userSName);	
			exit;
		}
		else
		{
			header('Location: ./messageDisplay?messageId=8');
			exit;
		}
	}
	else 
	{
		header('Location: ./messageDisplay?messageId=8');
		exit;
	}
}

/**
 * Function to Delete a user
 * 
 * @param $_POST['userId'] - userId for that user
 */
function authDeleteUser()
{	
	global $twig;
	global $nav;
	$loggedInText=null;
	$userName=null;
	$userId=null;
	
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
	}
	
	if(isset($_POST['deleteUser']))
	{
		$userId=filter_input(INPUT_POST,'userId',FILTER_SANITIZE_NUMBER_INT);
	}
	
	# retrieve the user
	$userArr=getUser($userId);
	
	# create the user's full name to be displayed
	$userName=$userArr['userFName'].' '.$userArr['userSName'];
	
	# set the form action
	$action='./authUserDeleted';
	
	# set the type of button
	$button1='deleteYes';
	$button2='deleteNo';
	
	# retrieve the ticker value
	$ticker=getTicker();
	
	$args_array=array(
		'userId'	=> $userId,
		'loggedInText' 	=> $loggedInText,
		'ticker' 		=> $ticker,
		'nav'			=> $nav,
		'userName'		=> $userName,
		'action'		=> $action,
		'button1'		=> $button1,
		'button2'		=> $button2,
	);
	
	$template='auth_delete_user';
	echo $twig->render($template.'.html.twig',$args_array);	
	
	ob_end_flush();
}

/**
 * Function deletes a user depending on the selecttion they made
 * 
 * @param $_POST array containing yes or no selection and userId
 */
function authUserDeleted()
{
	$deleteYes=null;
	$deleteNo=null;	
	$userId=null;
	$userDeleted=false;
	
	
	# if user chose the Yes button to delete the user
	if(isset($_POST['deleteYes']))
	{
		$deleteYes=filter_input(INPUT_POST,'deleteYes',FILTER_SANITIZE_STRING);
	
		if('Yes'==$deleteYes)
		{
			if(isset($_POST['userId']))
				$userId=filter_input(INPUT_POST,'userId',FILTER_SANITIZE_STRING);
			
			# send userId to function to delete/disable the user
			$userDeleted=deleteUser($userId);	
			
			if($userDeleted)
			{
				header('Location: ./messageDisplay?messageId=9');
				exit;
			}
			else 
			{
				header('Location: ./messageDisplay?messageId=9');
				exit;
			}
		}
	}
	
	# if user chose the No button to NOT delete the user
	if(isset($_POST['deleteNo']))
	{
		$deleteNo=filter_input(INPUT_POST,'deleteNo',FILTER_SANITIZE_STRING);
	
		if('No'==$deleteNo)
		{
			header('Location: ./messageDisplay?messageId=10');
			exit;
		}
	}
	
}


/**
 * Function displays form of users details and allows the user to edit
 * 
 * @param $_POST['userId'] to edit a specific user
 */
function authEditUser()
{
	global $twig;
	//global $nav;
	$loggedInText=null;
	$userName=null;
	$userArr=array();
	$userId=null;
    $pageAction='edit';
    $userCat=null;
	
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
	}
	
	if(isset($_POST['editUser']))
	{
		$userId=filter_input(INPUT_POST,'userId',FILTER_SANITIZE_NUMBER_INT);
	}

	# retrieve the user details
	$userArr = getUser($userId);

	//$userName='Edit User: '.$userArr['userFName'].' '.$userArr['userSName'];
    $userName=$userArr['userFName'].' '.$userArr['userSName'];
	
	# retrieve categeories available for building a select menu with relevant option selected
	//$catMenu = getUserCatMenu($userArr['userCat']);
	$userCat=$userArr['userCat'];

	# set the form action
	$action='./authUserEdited';
	
	# set the type of button
	$button='edit';
	
	# retrieve the ticker value
	$ticker=getTicker();
	
	# set the username field to readOnly
	$readOnly='readonly class="readOnly"';
	//$readOnlyNotice='(Read Only)';
	
	$args_array=array(
		'userId'	=> $userId,
		'loggedInText' 	=> $loggedInText,
		'ticker' 		=> $ticker,
		'pageAction'	=> $pageAction,
		'userName'		=> $userName,
		'userArr'		=> $userArr,
		//'catMenu'		=> $catMenu,
        'userCat'       => $userCat,
		'action'		=> $action,
		'readOnly'		=> $readOnly,
		//'readOnlyNotice'=> $readOnlyNotice,
		'button'		=> $button,
	);
	
	$template='auth_edit_user';
	echo $twig->render($template.'.html.twig',$args_array);	
	
	ob_end_flush();
}

/**
 * Function updates a user's details
 * 
 * @param $_POST array containing userId, userFName, userSName, userEmail, userLogin, userPassword, userCat
 */
 function authUserEdited()
 {
	global $twig;
	global $nav;
	$loggedInText=null;
	
	# user variables
	$userId=null;
	$userFName=null;
	$userSName=null;
	$userEmail=null;
	$userLogin=null;
	$userPassword=null;
	$userCat=null;
	
	$updated=false;	
	
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			$loggedInText=$_SESSION['loggedInText'];
		}
	}
	
	# check that form was submitted else display an error message
	if(isset($_POST['edit']))
	{
		if(isset($_POST['userId']))
			$userId=filter_input(INPUT_POST,'userId',FILTER_SANITIZE_NUMBER_INT);
		if(isset($_POST['userFName']))
			$userFName=filter_input(INPUT_POST,'userFName',FILTER_SANITIZE_STRING);
		if(isset($_POST['userSName']))
			$userSName=filter_input(INPUT_POST,'userSName',FILTER_SANITIZE_STRING);
		if(isset($_POST['userEmail']))
			$userEmail=filter_input(INPUT_POST,'userEmail',FILTER_SANITIZE_EMAIL);
		if(isset($_POST['userLogin']))
			$userLogin=filter_input(INPUT_POST,'userLogin',FILTER_SANITIZE_STRING);
		if(isset($_POST['userPassword']))
		{
			$userPassword=filter_input(INPUT_POST,'userPassword',FILTER_SANITIZE_STRING);
			
			# add SALT to the password and encrypt			
			$userPasswordEncrypted=md5($userPassword);//.PASSWORD_SALT);
		}
		if(isset($_POST['userCat']))
			$userCat=filter_input(INPUT_POST,'userCat',FILTER_SANITIZE_STRING);

		# update the database and check if successful
		$updated=updateUser($userId,$userFName,$userSName,$userEmail,$userLogin,$userPasswordEncrypted,$userCat);
		
		if($updated)
		{
			header('Location: ./messageDisplay?messageId=7&user='.$userFName.' '.$userSName);	
			exit;
		}
		else
		{
			header('Location: ./messageDisplay?messageId=8');
			exit;
		}
	}
	else 
	{
		header('Location: ./messageDisplay?messageId=8');
		exit;
	}
 }


