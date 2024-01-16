<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * User class
 */
class User
{
	
	use Model;

	protected $table = 'users';
	protected $primaryKey = 'id';
	protected $loginUniqueColumn = 'email';

	protected $allowedColumns = [

		'name',
		'username',
		'user_id',
		'photo',
		'role',
		'email',
		'password',
		'date_created',
		'date_updated',
	];

	protected $onInsertValidationRules = [

		'email' => [
			'email',
			'unique',
			'required',
		],
		'name' => [
			'alpha_space',
			'required',
		],
		'username' => [
			'alpha',
			'required',
		],
		'photo' => [
			'required',
		],
		'terms' => [
			'alpha',
			'required',
		],
		'password' => [
			'not_less_than_8_chars',
			'required',
		],
	];

	protected $onUpdateValidationRules = [

		'email' => [
			'email',
			'unique',
			'required',
		],
		'name' => [
			'alpha_space',
			'required',
		],
		'photo' => [
			'required',
		],
		'username' => [
			'alpha',
			'required',
		],
		'terms' => [
			'alpha',
			'required',
		],
		'password' => [
			'not_less_than_8_chars',
			'required',
		],
		
	];

	public function signup($data)
	{
		if($this->validate($data))
		{
			//add extra user columns here
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			$data['date_created'] = date("Y-m-d H:i:s");
			$data['date_updated'] = date("Y-m-d H:i:s");
			$data['user_id'] = randomString(10);
			$data['role'] = "customer";

			$this->insert($data);
			message("Your account was created! kindly login");
			redirect('login');
		}
	}

	public function login($data)
	{
		$row = $this->first([$this->loginUniqueColumn=>$data[$this->loginUniqueColumn]]);

		if($row){

			//confirm password
			if(password_verify($data['password'], $row->password))
			{
				$ses = new \Core\Session;
				$cart = new \Model\Cart;
				$ses->auth($row);

				switch ($row->role) {

					case 'admin':
						redirect('admin');
						break;

					case 'customer':
						$cartItems = $cart->displayCartItems();
						if($cartItems){
							redirect('carts/cart');
						}else{
							redirect('customer');
						}
						break;
					
					default:
						redirect('home');
						break;
				}
				
			}else{
				$this->errors[$this->loginUniqueColumn] = "Wrong $this->loginUniqueColumn or password";
			}
		}else{
			$this->errors[$this->loginUniqueColumn] = "Wrong $this->loginUniqueColumn or password";
		}
	}

	public function editCustomerProfile($data,$id)
	{
		//
		$req   = new \Core\Request;

		$data['id'] = $id;
		if($this->validate($data) || !empty($data))
		{
			//add extra user columns here
			$data['date_updated'] = date("Y-m-d H:i:s");

			$files = $req->files();

			$image = $files['photo'];

			$row = $this->first(['user_id'=>$id]);

			if(!empty($image['name']))
			{

			$folder = 'userimages/';

			if(!file_exists($folder))
			{
				mkdir($folder,0777,true);
				file_put_contents($folder . 'index.php', "");
			}

			$allowed = ['image/jpeg', 'image/jpg', 'image/webp', 'image/png'];

				if(in_array($image['type'], $allowed))
				{
					$data['photo'] = $folder . time() . "." . $image['name'];
					move_uploaded_file($image['tmp_name'], $data['photo']);

					(new \Model\Image())->resize($data['photo'], 1000);

					if(file_exists($row->photo))
						unlink($row->photo);
				}else{
					$this->errors['photo'] =  "This file is not supported";
				}
			}	

			// if(empty($this->errors))
			// {				
				$this->update($id, $data, 'user_id');
				message("Account Edited !!");
			// }

		}
	}

	public function deleteCustomerProfile($id)
	{
			$this->delete($id,'user_id');
			message("Account deleted! create new one");
	}


}