<?php

namespace Services;

/**
 * BaseService
 * @author Prasanth
 *
 */

class BaseService
{
	
	public $ci;
	
	public $em;
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->em = $this->ci->doctrine->em;
	} 
}