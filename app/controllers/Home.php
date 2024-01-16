<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * home class
 */
class Home
{
	use MainController;

	public function index()
	{

		$data['title'] = "Home";
		$data['ses'] = new \Core\Session;
		$data['sales'] = new \Model\Sale();
		$data['user'] = new \Model\User();
		$category= new \Model\Category;

		$data['categorys'] = $category->getCategorys();
		$this->view('home',$data);
	}

}
