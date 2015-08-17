 
	function GateKeeper(divNum)
		{
			openWin();
			
			/*password=prompt("Password required:","");
			if(password=="smcuser")
				{
					change_p1(divNum);		
					openWin()
				}
			else 
				{
					alert("Password Incorrect");
					return false;
				}*/
		}
	function change_p1(divNum)
		{
			textValue=prompt("Enter the text that you want to update with");	
			
			document.getElementById(divNum).firstChild.nodeValue=textValue;
		}
		
		function SetMyColor(chosencolor)
		{
			
			window.document.bgColor = chosencolor;
			/*window.document.all("net_stat1").bgColor = chosencolor;*/
			window.document.all("net_stat2").bgColor = chosencolor;
			window.document.all("net_stat3").bgColor = chosencolor;
			window.document.all("net_stat4").bgColor = chosencolor;
		}
		
		function openWin()
		{
			myWin=open("form-index.html", "displayWindow",
			"width=600,height=650,status=no,toolbar=no,menubar=no");
		}
		
		function openWin2()
		{
			myWin=open("img/primary-services-dash.jpg", "displayWindow",
			"width=950,height=750,status=no,toolbar=no,menubar=no");
		}
		function openWin3()
		{
			myWin=open("img/enablement-services-dash.jpg", "displayWindow",
			"width=1200,height=600,status=no,toolbar=no,menubar=no");
		}
		function openWin4()
		{
			myWin=open("img/corporate-services-dash.jpg", "displayWindow",
			"width=650,height=500,status=no,toolbar=no,menubar=no");
		}