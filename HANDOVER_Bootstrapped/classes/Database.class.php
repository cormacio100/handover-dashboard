<?php

# Database.class.php

class Database 
{
	private $host=DB_HOST;
	private $username=DB_USER;
	private $password=DB_PASSWORD;
	private $db=DB_DATABASE;	
	private $link;					# link object

	/**
	 * constructor function
	 */ 
	public function __construct()
	{
		$this->createDbConnection();
	}
	
	/**
	 * function creates the Database connection object 
	 */ 
	private function createDbConnection()
	{
		$this->link=mysqli_connect($this->host,$this->username,$this->password,$this->db);
		
		# Check connection
		if (!$this->link) 
		{
		    die("Connection failed: " . mysqli_connect_error());
		}
	}
	
	/**
	 * function to close the connection
	 */ 
	private function closeDbConnection()
	{
		mysqli_close($this->link);
	}

	/**
	 * function executes query with expected single record result and converts result to assoc array
	 * 
	 * @param $query
	 * @return $result assoc array of result
	 */ 
	 public function getSingleRecord($query)
	 {
	 	
		# execute the query
	 	$record=mysqli_query($this->link,$query);
	
		# put result into an assoc array
		$result=mysqli_fetch_assoc($record);
	
		# close the connection
		$this->closeDbConnection();
	
		return $result;
	 }

	/**
	 * function processes query where one or more records are expected in result
	 * 
	 * @param $query
	 * @return $records - multidimensional array of results
	 */ 
	public function getMultiRecords($query)
	{
		$row=null;
		
		# execute the query
		$recordSet=mysqli_query($this->link,$query);

		$records=array();
		
		while($row=mysqli_fetch_assoc($recordSet))
		{
			$records[]=$row;
		}
		
		# close the connection
		$this->closeDbConnection();
		
		return $records;
	}

	/**
	 * function processes query and returns the recordSet without converting it to an array
	 * 
	 * @param $query
	 * @return $recordSet - recordSet Object
	 */ 
	public function getRecordSet($query)
	{
		$row=null;
		
		# execute the query
		$recordSet=mysqli_query($this->link,$query);
	
		# close the connection
		$this->closeDbConnection();
		
		return $recordSet;
	}	
	/**
	 * function process query to update a record
	 * 
	 * @param $query
	 * @return $update boolean value to indicate success of update
	 */
	 public function updateRecord($query)
	 {
	 	# create a connection
		//$this->createDbConnection();
		
		# execute the query
		$updated=mysqli_query($this->link,$query);
		
		# close the connection
		$this->closeDbConnection();
		
		return $updated;
	 }
}
