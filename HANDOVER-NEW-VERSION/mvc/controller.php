<?php

#-----------------------------------------------------
#	Controller Functions
#-----------------------------------------------------

# start or resume a session
if(!isset($_SESSION))
{
	session_start();
	ob_start();
}

/**
 * Function accesses the Index page
 */
function index()
{
	global $twig;
	//global $isLoggedIn;
	//global $username;
	
	# if this option is clicked then the user is assumed to not be logged in
	unset($_SESSION);
	
	$args_array=array(
		//'isLoggedIn' 	=> $isLoggedIn,
		//'username'		=>	$username,
	);
	
	$template = 'index';
	echo $twig->render($template.'.html.twig',$args_array);
}

/**
 * Function attempts to authenticate a user and log them into system
 * 
 * @return $_SESSION['authenticate'] - session is authenticated if user credentials match
 */
function login()
{
	# if  this option is clicked then the user is assumed to not be logged in
	unset($_SESSION['authenticated']);
	
	# process the script only if the login button has been pressed
	if(array_key_exists('login',$_POST))
	{
		# Retrieve entered login details if set
		if(!empty($_POST['userLogin']))
			$userLogin=filter_input(INPUT_POST, 'userLogin',FILTER_SANITIZE_STRING);
		
		if(isset($_POST['userPassword']))
			$userPassword=filter_input(INPUT_POST, 'userPassword',FILTER_SANITIZE_STRING);	

		# DB stored passwords include a SALT and encryption so need to do the same to values passed in for comparison		
		$userPasswordEncrypted=md5($userPassword);

		$userArr=isValidUsernamePassword($userLogin,$userPasswordEncrypted);
			
		if(!empty($userArr))
		{
			# save user details to SESSION
			$_SESSION['authenticated']='yes';
			
			$_SESSION['userId']=$userArr['userId'];
			
			$_SESSION['userCat']=$userArr['userCat'];
			
			$userName=$userArr['userFName'].' '.$userArr['userSName'];	
			$_SESSION['userName']=$userName;
			
			$loggedInText=$userName.' is logged in<br><a href="./messageDisplay?messageId=4" class="logOut">log out</a>';
			$_SESSION['loggedInText']=$loggedInText;
	
			# allow the user access	
			header('Location: ./messageDisplay?messageId=3');
			exit;
		}
		else 
		{
			# access not allowed
			header('Location: ./messageDisplay?messageId=2');
			exit;
		}
	}
	else 
	{
		header('Location: ./messageDisplay?messageId=1');
	}
}


/**
 * Function informs the user that they have attempted an action that incorrect or not available
 */
 function messageDisplay()
 {
 	global $twig;
	$nav=null;
	$messageId=null;
	$forward=false;
	$location=null;
	$authenticated=false;
	$ticker=null;
	$loggedInText=null;

	# retrieve the message ID passed to the script
	$messageId=filter_input(INPUT_GET,'messageId', FILTER_SANITIZE_NUMBER_INT);

	if(0==$messageId)
	{
		$messageText='Error 404. Page not available. Please login again <a href="./">here</a>';
		unset($_SESSION);	# ensure SESSION is cleared
	}
	else if(1==$messageId)
	{
		$messageText='Unathuthorised access attempt. Please login again <a href="./">here</a>';
		unset($_SESSION);	# ensure SESSION is cleared
	}
	else if(2==$messageId)
	{
		$messageText='Incorrect Username/Password combination.<br>Click <a href="./">here</a> to login again';
		unset($_SESSION);	# ensure SESSION is cleared
	}
	else if(3==$messageId)
	{
		# message will be displayed and then the page will forward to location
		$messageText='Checking User..';
		$forward=true;	
		$location='./authHome';
	}
	else if(4==$messageId)
	{
		# clear the session and log user out
		$messageText='Logging Out..';
		$forward=true;
		$location='./';
		unset($_SESSION);	
	}
	else if(5==$messageId)
	{
		# retrieve the current ticker value
		$ticker=getTicker();
		$messageText='Ticker updated. Forwarding...';
		$forward=true;
		$location='./authTicker';
		if(isset($_SESSION['authenticated']))
			$authenticated=true;
	}
	else if(6==$messageId)
	{
		# retrieve the current ticker value
		$ticker=getTicker();
		
		$messageText='Ticker was NOT updated';
		
		if(isset($_SESSION['authenticated']))
			$authenticated=true;
	}
	else if(7==$messageId)
	{
		$user=null;
		
		# retrieve the current ticker value
		$ticker=getTicker();
		
		if(isset($_GET['user']))
			$user=filter_input(INPUT_GET,'user',FILTER_SANITIZE_STRING);
		
		# message will be displayed and then the page will forward to location
		$messageText='User Details have been updated for user '.$user.'<br>Forwarding...';
		$forward=true;	
		$location='./authAdmin';
		
		if(isset($_SESSION['authenticated']))
			$authenticated=true;
	}
	else if(8==$messageId)
	{
		# retrieve the current ticker value
		$ticker=getTicker();
		
		$messageText='Error Occurred. User was NOT updated';
				
		if(isset($_SESSION['authenticated']))
			$authenticated=true;	
	}
	else if(9==$messageId)
	{
		# retrieve the current ticker value
		$ticker=getTicker();
		
		# message will be displayed and then the page will forward to location
		$messageText='User Deleted. Forwarding...';
		$forward=true;	
		$location='./authAdmin';
		
		if(isset($_SESSION['authenticated']))
			$authenticated=true;	
	}
	else if(10==$messageId)
	{
		# retrieve the current ticker value
		$ticker=getTicker();
		
		# message will be displayed and then the page will forward to location
		$messageText='User has NOT been deleted. Forwarding...';
		$forward=true;	
		$location='./authAdmin';
				
		if(isset($_SESSION['authenticated']))
			$authenticated=true;	
	}
	else if(11==$messageId)
	{
		# retrieve the current ticker value
		$ticker=getTicker();
		
		# message will be displayed and then the page will forward to location
		$messageText='Dashboard admin statistics updated. Forwarding...';
		$forward=true;
		$location='./authDashAdmin';
		
		if(isset($_SESSION['authenticated']))
			$authenticated=true;	
	}
	else if(12==$messageId)
	{
		# retrieve the current ticker value
		$ticker=getTicker();
		
		# message will be displayed and then the page will forward to location
		$messageText='Error! Dashboard admin statistics NOT updated. Forwarding...';
		$forward=true;
		$location='./authDashAdmin';
		
		if(isset($_SESSION['authenticated']))
			$authenticated=true;	
	}
	else if(13==$messageId)
	{
		$searchParam=null;	
		
		# retrieve the current ticker value
		$ticker=getTicker();
		
		# message will be displayed and then the page will forward to location
		$messageText='Database Updated. Forwarding...';
		$forward=true;
		
		# location determined by searchParam a few lines below
		
		if(isset($_SESSION['authenticated']))
			$authenticated=true;	
	}
	else if(14==$messageId)
	{
		$searchParam=null;	
		
		# retrieve the current ticker value
		$ticker=getTicker();
		
		# message will be displayed and then the page will forward to location
		$messageText='Database NOT Updated. Forwarding...';
		$forward=true;
		
		# location determined by searchParam a few lines below
		
		if(isset($_SESSION['authenticated']))
			$authenticated=true;	
	}
	else if(15==$messageId)
	{
		$searchParam=null;	
		
		# retrieve the current ticker value
		$ticker=getTicker();
		
		# message will be displayed and then the page will forward to location
		$messageText='Error occurred while exporting. Forwarding...';
		$forward=true;
		
		# location determined by searchParam a few lines below
		
		if(isset($_SESSION['authenticated']))
			$authenticated=true;	
	}
	else 
	{
		$messageText='Page not available. Please login again <a href="./">here</a>';
	}
	
	# check if an searchParam was passed in GET array. This will determine which incident page to pass back to
	if(isset($_GET['searchParam']))
	{
		# if the variable to forward the page is set then set the locations based on the searchParam
		if(true==$forward)
		{
			# retrieve the searchParam
			$searchParam=filter_input(INPUT_GET, 'searchParam',FILTER_SANITIZE_STRING);
		
			# determine which incident page to forward back to
			if('INTERNET'==$searchParam)
			{
				$location='./authIncident&searchParam=INTERNET';
			}
			else if('RAN'==$searchParam)
			{
				$location='./authIncident&searchParam=RAN';
			}
			else if('CRM'==$searchParam)
			{
				$location='./authIncident&searchParam=CRM';
			}
			else if('BPOPS'==$searchParam)
			{
				$location='./authIncident&searchParam=BPOPS';
			}
			else if('LEON'==$searchParam)
			{
				$location='./authIncident&searchParam=LEON';
			}
			else if('SHIFTLEAD'==$searchParam)
			{
				$location='./authIncident&searchParam=SHIFTLEAD';
			}
			else if('DASHDISPLAYED'==$searchParam)
			{
				$location='./authDashDisplayed=DASHDISPLAYED';
			}
		}
	}	
	
 	# check if page needs to be forwarded after the message is displayed
	if($forward==true)
	{
		header('Refresh:2; '.$location);
	}

	# check if logged in and if so display who is logged in
	if(isset($_SESSION['authenticated']))
	{
		if(isset($_SESSION['loggedInText']))
		{
			# if user is logged in then nav bar and logged in username should be displayed
			# except when the user is in the process of logging in
			if(3!=$messageId)
			{
				global $nav;	
				$loggedInText=$_SESSION['loggedInText'];
			}
				
		}
	}

	$args_array=array(
		'messageText' 	=> $messageText,
		'ticker' 		=> $ticker,
		'loggedInText' 	=> $loggedInText,
		'nav'			=> $nav,
	);
	
	$template='message_display';
	echo $twig->render($template.'.html.twig',$args_array);
 }


/**
 * Function Allows user access to DashClient
 * Not Necessary to be logged in 
 * dashClient Page uses AJAX to retrieve data and populate page
 */
function dashClient()
{

	global $twig;
	
	$args_array=array();
	
	$template='dashBoardClient';
	echo $twig->render($template.'.html.twig',$args_array);
}

/**	
 * This page retrieves data for the dashboard from the DB
 *	via multiple model functions file
 *	and converts it to JSON format so that it can be read
 * 	and displayed by the JQUERY script linked to the
 *	dashboard.html page
 * 
 *  @return JSON output
 */
function dashJSON()
{

	$myData=new dataObject;
	$array=array();
	
	$time=time();
	
	# send the query and property name t be executed and a value returned
	
	# Free SMS
	$myData->freeSms = getDashStat("SELECT freeSms FROM dashStatus WHERE id='1' LIMIT 1",'freeSms');
	# sectors off air
	$myData->sectors = getDashStat("SELECT sectors FROM dashStatus WHERE id='1' LIMIT 1",'sectors');	
	
	# Network Service Statistics
	$myData->netAvail2G = getDashStat("SELECT netAvail2G FROM dashStatus WHERE id='1' LIMIT 1",'netAvail2G');	
	$myData->trafVol2G = getDashStat("SELECT trafVol2G FROM dashStatus WHERE id='1' LIMIT 1",'trafVol2G');	
	$myData->netLocSuc2G = getDashStat("SELECT netLocSuc2G FROM dashStatus WHERE id='1' LIMIT 1",'netLocSuc2G');	
	$myData->netAvail3G = getDashStat("SELECT netAvail3G FROM dashStatus WHERE id='1' LIMIT 1",'netAvail3G');	
	$myData->trafVol3G = getDashStat("SELECT trafVol3G FROM dashStatus WHERE id='1' LIMIT 1",'trafVol3G');
	$myData->voiceTraf2G  = getDashStat("SELECT voiceTraf2G FROM dashStatus WHERE id='1' LIMIT 1",'voiceTraf2G');
	$myData->callCompRate2G = getDashStat("SELECT callCompRate2G FROM dashStatus WHERE id='1' LIMIT 1",'callCompRate2G');
	$myData->callSuccRate2G = getDashStat("SELECT callSuccRate2G FROM dashStatus WHERE id='1' LIMIT 1",'callSuccRate2G');
	$myData->callCompRate3G = getDashStat("SELECT callCompRate3G FROM dashStatus WHERE id='1' LIMIT 1",'callCompRate3G');
	$myData->callSuccRate3G = getDashStat("SELECT callSuccRate3G FROM dashStatus WHERE id='1' LIMIT 1",'callSuccRate3G');
	$myData->dataVol2G = getDashStat("SELECT dataVol2G FROM dashStatus WHERE id='1' LIMIT 1",'dataVol2G');
	$myData->edgeThru2G = getDashStat("SELECT edgeThru2G FROM dashStatus WHERE id='1' LIMIT 1",'edgeThru2G');
	$myData->gprsThru2G = getDashStat("SELECT gprsThru2G FROM dashStatus WHERE id='1' LIMIT 1",'gprsThru2G');
	$myData->dataVol3G = getDashStat("SELECT dataVol3G FROM dashStatus WHERE id='1' LIMIT 1",'dataVol3G');
	$myData->pakSetSuc3G = getDashStat("SELECT pakSetSuc3G FROM dashStatus WHERE id='1' LIMIT 1",'pakSetSuc3G');
	$myData->pakCompRate3G = getDashStat("SELECT pakCompRate3G FROM dashStatus WHERE id='1' LIMIT 1",'pakCompRate3G');
	$myData->mmsCompRate = getDashStat("SELECT mmsCompRate FROM dashStatus WHERE id='1' LIMIT 1",'mmsCompRate');
	$myData->smsCompRate = getDashStat("SELECT smsCompRate FROM dashStatus WHERE id='1' LIMIT 1",'smsCompRate');
	$myData->pssVoice = getDashStat("SELECT pssVoice FROM dashStatus WHERE id='1' LIMIT 1",'pssVoice');
	$myData->pssData = getDashStat("SELECT pssData FROM dashStatus WHERE id='1' LIMIT 1",'pssData');
	$myData->pssMessaging = getDashStat("SELECT pssMessaging FROM dashStatus WHERE id='1' LIMIT 1",'pssMessaging');
	$myData->pssRoaming = getDashStat("SELECT pssRoaming FROM dashStatus WHERE id='1' LIMIT 1",'pssRoaming');
	$myData->pss2GNetwork = getDashStat("SELECT pss2GNetwork FROM dashStatus WHERE id='1' LIMIT 1",'pss2GNetwork');
	$myData->pss3GNetwork = getDashStat("SELECT pss3GNetwork FROM dashStatus WHERE id='1' LIMIT 1",'pss3GNetwork');
	$myData->essCustMgmnt = getDashStat("SELECT essCustMgmnt FROM dashStatus WHERE id='1' LIMIT 1",'essCustMgmnt');
	$myData->essCustBill = getDashStat("SELECT essCustBill FROM dashStatus WHERE id='1' LIMIT 1",'essCustBill');
	$myData->essServProv = getDashStat("SELECT essServProv FROM dashStatus WHERE id='1' LIMIT 1",'essServProv');
	$myData->essTopUp = getDashStat("SELECT essTopUp FROM dashStatus WHERE id='1' LIMIT 1",'essTopUp');
	$myData->essRetPos = getDashStat("SELECT essRetPos FROM dashStatus WHERE id='1' LIMIT 1",'essRetPos');
	$myData->essRetPos = getDashStat("SELECT essRetPos FROM dashStatus WHERE id='1' LIMIT 1",'essRetPos');
	$myData->cssEmail = getDashStat("SELECT cssEmail FROM dashStatus WHERE id='1' LIMIT 1",'cssEmail');
	$myData->cssNetwork = getDashStat("SELECT cssNetwork FROM dashStatus WHERE id='1' LIMIT 1",'cssNetwork');
	$myData->cssTelePbx = getDashStat("SELECT cssTelePbx FROM dashStatus WHERE id='1' LIMIT 1",'cssTelePbx');
	$myData->cssErpBss = getDashStat("SELECT cssErpBss FROM dashStatus WHERE id='1' LIMIT 1",'cssErpBss');
		
	# Major incidents
	$myData->majorIncArray=getMajorIncidents(); 
		
	# Minor Incident
	$myData->minorIncArray=getMinorIncidents();
	
	for($i = 0; $i < 5; $i++) 
	{
		$myData->items[$i] = "This is message $i and the time is ".$time ;	
	}
	for($i = 0; $i < 5; $i++) 
	{
		$myData->alerts[$i] = "This is alert $i";
	}
	
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: 0");
	header('Content-Type: application/json');
	
	$jsonOutput = json_encode($myData);
	
	echo $jsonOutput;	
}

/**
 * Function informs the user that they have attempted an action that incorrect or not available
 */
 function error404()
 {
 	# display a message an log user out
 	header('Location: ./messageDisplay?messageId=0');
	exit;
 
 }


ob_end_flush();
