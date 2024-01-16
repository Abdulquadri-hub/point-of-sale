<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Graph class
 */
class Graph
{
	use MainController;

	public function index()
	{

		$data['title'] = "Graph";
		$this->view('graph');
	}

}
