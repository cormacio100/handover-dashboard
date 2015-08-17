<?php
/**
 * Class objects act as a container for what is displayed on the screen 
 */
 
 
class Page
{
	public $objArr;
	
	public function __construct($galleryObjArr)
	{
		$this->setObjArr($galleryObjArr);
	}
	
	/**
	 * SETTER function
	 */
	public function setObjArr($galleryObjArr)
	{
		$this->objArr=$galleryObjArr;
	}
	
	/**
	 * GETTER function
	 */
	 public function getObjArr()
	 {
	 	return $this->objArr;
	 }
}
