<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * register class
 */
class Register
{
	use MainController;

	public function index()
	{

		$data['user'] = new \Model\User;
		$req = new \Core\Request;
		if($req->posted())
		{
			$data['user']->signup($_POST);
		}

		$this->view('register',$data);
	}

}
