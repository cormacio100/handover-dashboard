

function refreshDiv() 
{
	
	console.log('in refresh div');
	
	/*
		DATA RETRIEVED FROM PHP FILE IS IN JSON FORMAT...NOT XML
	*/
		
		////////////////////////////////////////////////////////////////
		//	-Load the JSON file sent from ajax5.php 
		//	-Tell the page what to put in each DIV from the JSON file
		//	-Prevent caching in Internet Explorer by adding
		//	a unique timestamp to the URL attribute
		///////////////////////////////////////////////////////////////
		
		var url = "./dashJSON?";
		
		var variable;
		var divName;
		
		var majorIncs;
		var minorIncs;
		
		console.log('url is '+url);
		
		$.getJSON(url + new Date().getTime(), function(data) 
		{    
			
			/*
				item is the "array" sent in the JSON file
			*/
			
			$.each(data,function (itemIndex, item) 
			{
				console.log("processing item:" + item);	  
				
				/*
					Empty the divs so that they're ready to receive updates
				*/
				
				emptyDiv();
				
				if(item['dashStats']['freeSms'])
				{
					console.log(item[0]['freeSMS'].valueOf);
					console.log(item['majorIncidentsArray']);
				}

				if (item['majorIncidentsArray']) 
				{
					
					console.log(item['majorIncidentsArray']);
				
					$.each(item['majorIncidentsArray'], function(i, val)
					{
						//$('#div_major_incidents').append("<p>" + "<u><b>" + item.majorIncidentsArray'][i]['reference'] +"</b></u><br>").append(item['majorIncidentsArray'][i]['description'] + "</p>");
					});

					console.log("processing majorIncidentsArray");
				}
				
			} ); //each
											
		}); // end getJSON
										
	  
	//});	
	
	
	//setTimeout(refreshDiv, 100000);
}

///////////////////////////////////////////////////
//
//	Need to clear each DIV before they are updated 
//	or else the new value will append to the
//	old value
//
///////////////////////////////////////////////////

function emptyDiv()
{

	$("#div_Free_SMS").empty();
	$("#div_sectors").empty();
	
	$('#div_prser_voice_status').empty();
	$('#div_prser_data_status').empty();
	$('#div_prser_messaging_status').empty(); 
	$('#div_prser_roaming_status').empty(); 
	$('#div_prser_2gnetwork_status').empty();
	$('#div_prser_3gnetwork_status').empty();
	$('#div_enaser_custmanag_status').empty();
	$('#div_enaser_custbill_status').empty();
	$('#div_enaser_servprov_status').empty();
	$('#div_enaser_topup_status').empty();
	$('#div_enaser_retailpos_status').empty();
	$('#div_corpser_datware_status').empty();
	$('#div_corpser_email_status').empty();
	$('#div_corpser_network_status').empty();
	$('#div_corpser_telephony_status').empty();
	$('#div_corpser_erpbss_status').empty();
	
	$("#div_performance_2G3GNetwork_2Gavailability").empty();
	$("#div_performance_2G3GNetwork_2Gvolume").empty();
	$("#div_performance_2G3GNetwork_Location").empty();
	$("#div_performance_2G3GNetwork_3Gavailability").empty();
	$("#div_performance_2G3GNetwork_3Gvolume").empty();	
	$("#div_performance_voice_traffic").empty();	
	$("#div_performance_2G3GNetwork_3Gvolume").empty();	
	$("#div_performance_voice_2g_completion").empty();	
	$("#div_performance_voice_2g_setup").empty();	
	$("#div_performance_voice_3g_completion").empty();	
	$("#div_performance_voice_3g_setup").empty(); 
	$("#div_performance_data_2g_volumes").empty(); 
	$('#div_performance_data_edge').empty(); 
	$('#div_performance_data_gprs_throughput').empty();
	$('#div_performance_data_3g_volumes').empty();
	$('#div_performance_data_3g_packet_setup').empty();
	$('#div_performance_messaging_mms').empty();
	$('#div_performance_messaging_sms').empty();
	
	$("#div_major_incidents").empty();
	$("#div_minor_incidents").empty();
}

/*
	Display a red,amber or green gif in relevant DIV depending on status
*/

function colour(variable, divName)
{

if(variable=="red")
	{
						//$('#div_prser_roaming_status').append("<p>" + item['pssRoaming'] + "</p>");
						//$("#content").empty().html('<img src="loading.gif" />');

		divName.html('<img src="img/led_red.gif" />');
	}
else if(variable=="amber")
	{
						//$('#div_prser_roaming_status').append("<p>" + item['pssRoaming'] + "</p>");
						//$("#content").empty().html('<img src="loading.gif" />');

		divName.html('<img src="img/led_amber.gif" />');
	}
else
	{
						//$('#div_prser_roaming_status').append("<p>" + item['pssRoaming'] + "</p>");
						//$("#content").empty().html('<img src="loading.gif" />');

		divName.html('<img src="img/led_green.gif" />');
	}

}

window.onload=function()
{
	console.log("Resfreshing....") ;

	setInterval(refreshDiv,10000);	
	
};


