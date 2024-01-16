<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');


/**
 * Profile class
 */
class Profile
{
	use MainController;

	public function index($id = null)
	{

		$data['title'] = "Profile";
		$user = new \Model\User();
		$data['ses'] = new \Core\Session;
		$data['image'] = new \Model\Image;

		$data['mode'] = "overview";

		if(!$data['ses']->is_logged_in())
		{
			redirect('login');
		}	

		$data['row'] = $user->first(['user_id'=>$id]);

        $data['user'] =  $user;
		$this->view('profile/profile',$data);
	}

	public function edit($id = null)
	{

		$data['title'] = "Profile";
		$user = new \Model\User();
		$data['ses'] = new \Core\Session;
		$data['image'] = new \Model\Image;
		$req = new \Core\Request;

		$data['mode'] = "edit";

		if(!$data['ses']->is_logged_in())
		{
			redirect('login');
		}	

		if($req->posted())
		{
			$user->editProfile($_POST,$id);
		}

		$data['row'] = $user->first(['user_id'=>$id]);

        $data['user'] =  $user;
		$this->view('profile/profile',$data);
	}

	public function delete($id = null)
	{

		$data['title'] = "Profile";
		$user = new \Model\User();
		$data['ses'] = new \Core\Session;
		$data['image'] = new \Model\Image;
		$req = new \Core\Request;

		$data['mode'] = "delete";

		if(!$data['ses']->is_logged_in())
		{
			redirect('login');
		}	

		if($req->posted())
		{
			$user->deleteProfile($id);
			redirect('logout');
		}

		$data['row'] = $user->first(['user_id'=>$id]);

        $data['user'] =  $user;
		$this->view('profile/profile',$data);
	}
	

}
