<?php


/**
 * CLASS creates Pager OBJECT for paging of results
 * 
 * @return $link string containing start, count and searchParam for each page 
 */
class DBPager
{
	
	public $totalRecords;
	public $recordsPerPage;
	public $totalPages;
	public $searchParamArr;
	public $url;
	
	function __construct($totalRecords,$pageSize,$searchParamArr=array(),$url) 
	{

		# total number of records to be displayed	
		$this->totalRecords=$totalRecords;
		
		$modulus=$this->totalRecords%10;
		
		# The ususal number of records per page and the number of pages
		$this->recordsPerPage=$pageSize;
		
		$this->totalPages=$this->totalRecords/$this->recordsPerPage;
		
		# Need to Establish the number of records to be displayed on the last page
		$this->lastPage= $this->totalRecords % $this->recordsPerPage;   
		
		# The searchParameters being used
		$this->searchParamArr=$searchParamArr;
		
		# The URL that the search relates to is sent from calling function
		$this->url=$url;
				
	}
	
	/**
	 *	Function returns the pager links to the searchPage as a string
	 * 
	 * @return $outputHTML - String of links
	 */
	
	function displayNavLinks()
	{
		$outputHTML="<hr/>";
		$start=0;
		
		#	ceil function rounds up to next integer
		if($this->totalRecords%10>0)
		{
			for($i=0; $i<ceil($this->totalPages);$i++)
			{
				# Increment the starting value by the number of records shown on the page
				$outputHTML.=$this->createLink($i,$start)."-";
				$start+=$this->recordsPerPage;
			}
		}
		else
		{
			for($i=0; $i<=ceil($this->totalPages);$i++)
			{
				#	Increment the starting value by the number of records shown on the page
				$outputHTML.=$this->createLink($i,$start)."-";
				$start+=$this->recordsPerPage;
			}
			
		}
			$outputHTML.="<hr/>";
					
			return $outputHTML;
	}
	
	/**
	 *	Function builds the pager links inclluding relevant search parametere
	 * 
	 *  @return $linkText - HTML string for each page link
	 */
	function createLink($pageNum, $start)
	{
		$pageNum=$pageNum+1;
		
		$linkText="<a href=\"";
		
		$linkText.=$this->url;
		
		$linkText.="?start=$start&count=".$this->recordsPerPage;
		
		foreach($this->searchParamArr as $key => $value) 
		{
			$linkText .= "&$key=$value";	
		}
		
		$displayStart=$start+1;
		
		$displayCount=$displayStart+9;
		
		$linkText.="\">($displayStart-$displayCount)</a>\n";
		

		# send link back as a sting
		return $linkText;
	}
	
}
