var readyStates=[
	'0: UNSENT - XMLHttpRequest has been constructed',
	'1: OPENED - open() has been invoked, headers can be set, send() can now be invoked',
	'2: HEADERS RECEIVED - request has been sent & response headers have been received',
	'3: LOADING - request body is still being received',
	'4: DONE - Response has been fully received (or something went wrong- either way data transfer is complete)'
];

var dataSource='./dashJSON';		// data source for exchange rates. Default set to Euro	
var freeSms=0;
var sectors=0;

/* parse JSON string to an array */
function displayReceivedData(stringJSON)
{
	console.log('parsing JSON string to an array');
	
	var dashStatsArray=JSON.parse(stringJSON);
	
	/* retrieve stats and populate the page */
	freeSms=dashStatsArray['freeSms'];console.log('freeSMS '+freeSms);updateDiv('div_Free_SMS',freeSms);
	sectors=dashStatsArray['sectors'];console.log('sectors '+sectors);updateDiv('div_sectors',sectors);	
	netAvail2G=dashStatsArray['netAvail2G'];updateDiv('div_performance_2G3GNetwork_2Gavailability',netAvail2G);
	trafVol2G=dashStatsArray['trafVol2G'];updateDiv('div_performance_2G3GNetwork_2Gvolume',trafVol2G);
	netLocSuc2G=dashStatsArray['netLocSuc2G'];updateDiv('div_performance_2G3GNetwork_Location',netLocSuc2G);
	netAvail3G=dashStatsArray['netAvail3G'];updateDiv('div_performance_2G3GNetwork_3Gavailability',netAvail3G);
	trafVol3G=dashStatsArray['trafVol3G'];updateDiv('div_performance_2G3GNetwork_3Gvolume',trafVol3G);
	voiceTraf2G=dashStatsArray['voiceTraf2G'];updateDiv('div_performance_voice_traffic',voiceTraf2G);
	callCompRate2G=dashStatsArray['callCompRate2G'];updateDiv('div_performance_voice_2g_completion',callCompRate2G);
	callSuccRate2G=dashStatsArray['callSuccRate2G'];updateDiv('div_performance_voice_2g_setup',callSuccRate2G);
	callCompRate3G=dashStatsArray['callCompRate3G'];updateDiv('div_performance_voice_3g_completion',callCompRate3G);
	callSuccRate3G=dashStatsArray['callSuccRate3G'];updateDiv('div_performance_voice_3g_setup',callSuccRate3G);
	dataVol2G=dashStatsArray['dataVol2G'];updateDiv('div_performance_data_2g_volumes',dataVol2G);	
	edgeThru2G=dashStatsArray['edgeThru2G'];updateDiv('div_performance_data_edge',edgeThru2G);
	gprsThru2G=dashStatsArray['gprsThru2G'];updateDiv('div_performance_data_gprs_throughput',gprsThru2G);
	dataVol3G=dashStatsArray['dataVol3G'];updateDiv('div_performance_data_3g_volumes',dataVol3G);
	pakSetSuc3G=dashStatsArray['pakSetSuc3G'];updateDiv('div_performance_data_3g_packet_setup',pakSetSuc3G);
	pakCompRate3G=dashStatsArray['pakCompRate3G'];updateDiv('div_performance_data_3g_packet_completion',pakCompRate3G);
	mmsCompRate=dashStatsArray['mmsCompRate'];updateDiv('div_performance_messaging_mms',mmsCompRate);
	smsCompRate=dashStatsArray['smsCompRate'];updateDiv('div_performance_messaging_sms',mmsCompRate);
	
	/* TRAFFIC LIGHT VALUES */
	pssVoice=dashStatsArray['pssVoice'];colour('div_prser_voice_status',pssVoice);
	pssData=dashStatsArray['pssData'];colour('div_prser_data_status',pssData);
	pssMessaging=dashStatsArray['pssMessaging'];colour('div_prser_messaging_status',pssMessaging);
	pssRoaming=dashStatsArray['pssRoaming'];colour('div_prser_roaming_status',pssRoaming);
	pss2GNetwork=dashStatsArray['pss2GNetwork'];colour('div_prser_2gnetwork_status',pss2GNetwork);
	pss3GNetwork=dashStatsArray['pss3GNetwork'];colour('div_prser_3gnetwork_status',pss3GNetwork);
	essCustMgmnt=dashStatsArray['essCustMgmnt'];colour('div_enaser_custmanag_status',essCustMgmnt);
	essCustBill=dashStatsArray['essCustBill'];colour('div_enaser_custbill_status',essCustBill);
	essServProv=dashStatsArray['essServProv'];colour('div_enaser_servprov_status',essServProv);
	essTopUp=dashStatsArray['essTopUp'];colour('div_enaser_topup_status',essTopUp);
	essRetPos=dashStatsArray['essRetPos'];colour('div_enaser_retailpos_status',essRetPos);
	cssDataWareBI=dashStatsArray['cssDataWareBI'];colour('div_corpser_datware_status',cssDataWareBI);
	cssEmail=dashStatsArray['cssEmail'];colour('div_corpser_email_status',cssEmail);
	cssNetwork=dashStatsArray['cssNetwork'];colour('div_corpser_network_status',cssNetwork);
	cssTelePbx=dashStatsArray['cssTelePbx'];colour('div_corpser_telephony_status',cssTelePbx);
	cssErpBss=dashStatsArray['cssErpBss'];colour('div_corpser_erpbss_status',cssErpBss);
	
	/* Major Incidents */
	majorIncArr=dashStatsArray['majorIncArray'];
		//var majIncString=
		listIncs(majorIncArr,'div_major_incidents');
		//document.getElementById('div_major_incidents').innerHTML=majIncString;
		
	minorIncArr=dashStatsArray['minorIncArray'];
		//var minIncString=
		listIncs(minorIncArr,'div_minor_incidents');
		//document.getElementById('div_minor_incidents').innerHTML=majIncString;
}

/* function loops through arrays and lists major an minor incidnets in relevant DIV */
function listIncs(incArr,divName)
{
	var buildString='';
	
	/* build the string */
	for(i=0;i<incArr.length;i++)
	{
		var incRef=incArr[i]['incRef'];
		var incDesc=incArr[i]['incDesc'];
		
		buildString=buildString+'<b><u>'+incRef+'</b></u><br>'+incDesc+'<br><br>';
		
		console.log('buildString is'+buildString);
	}	
	document.getElementById(divName).innerHTML=buildString;
	//return buildString;
}


/* function updates relevant div based on divName passed in as well as value */
function updateDiv(divName,value)
{
	var theDiv = document.getElementById(divName);
	
	/* empty the div before populating again */
	theDiv.innerHTML='';
	
	/* add the content */
	var content = document.createTextNode(value);
	theDiv.appendChild(content);
}

/*
	Display a red,amber or green gif in relevant DIV depending on status
*/

function colour(imgId,variable)
{

if(variable=="red")
	{
						//$('#div_prser_roaming_status').append("<p>" + item['pssRoaming'] + "</p>");
						//$("#content").empty().html('<img src="loading.gif" />');
		document.getElementById(imgId).src = "img/led_red.gif";
		//divName.html('<img src="img/led_red.gif" />');
	}
else if(variable=="amber")
	{
						//$('#div_prser_roaming_status').append("<p>" + item['pssRoaming'] + "</p>");
						//$("#content").empty().html('<img src="loading.gif" />');
		document.getElementById(imgId).src = "img/led_amber.gif";
		//divName.innerHTML('<img src="img/led_amber.gif" />');
	}
else
	{
						//$('#div_prser_roaming_status').append("<p>" + item['pssRoaming'] + "</p>");
						//$("#content").empty().html('<img src="loading.gif" />');
		document.getElementById(imgId).src = "img/led_green.gif";
		//divName.html('<img src="img/led_green.gif" />');
	}

}


/*
 * function retrieves JSON formatted data
 */
function loadJSON()
{
	console.log('loading JSON');
	
	/*
	 * STEP 1 - Define Values
	 * 
	 * a - Data Source
	 * b - Http Request Obj
	 * c - asynch or non
	 * d - constant
	 */

	var httpReq=new XMLHttpRequest({mozSystem: true});
	var asynchronous=true;
	var HTTP_REQUEST_COMPLETED=4;
	var PAGEFOUND=200;
	var PAGENOTFOUND=404;
	var htmlEntities='';
	
	console.log(readyStates[httpReq.readyState]);
	
	/*
	 * STEP 2 - DEFINE an anon function for handling a state change
	 */
	httpReq.onreadystatechange=function()
	{
		console.log(readyStates[httpReq.readyState]);
		
		/*
		 * STEP 5 - retrieve the new ready state and check if complete
		 */
		if(HTTP_REQUEST_COMPLETED==httpReq.readyState)
		{
			/*
			 * STEP 6 - check response status and if found display on screen
			 */	
			 if(PAGEFOUND==httpReq.status)
			 {
			 	displayReceivedData(httpReq.responseText);
			 }
			 else if(PAGENOTFOUND==httpReq.status)
			 {
			 	document.getElementById('tradeMessageList').innerHTML='Error 404';
			 }
		}
		
	};
	
	/*
	 * STEP 3 - Open the request
	 */
	
	httpReq.open('GET',dataSource,asynchronous);
	
	/*
	 * STEP 4 - Send the request
	 */
	//httpReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	httpReq.send();
}

window.onload=function()
{
	console.log('loading page');
	
	setInterval(loadJSON,10000);
};
