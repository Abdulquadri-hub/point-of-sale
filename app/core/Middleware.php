<?php

/**
 * Auth class
 * Save or read data to the current session
 */

 namespace Core;

 defined('ROOTPATH') OR exit('Access Denied!');

 use \Core\Session;

class Middleware
{

	public $mainkey = 'APP';
	public $userkey = 'USER';

	public static function access($role)
	{
		$ses = new Session();

		$access['admin'] = ['admin'];
		$access['supervisor'] = ['admin','supervisor'];
		$access['chasier'] = ['admin','supervisor','chasier'];
		$access['usee'] = ['admin','supervisor','chasier','user'];

		$myRole = $ses->get('role');
		if(in_array($myRole , $access[$role]))
		{
			return true;
		}

		return false;
	}

}