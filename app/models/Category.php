<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Category class
 */
class Category
{
	
	use Model;

	protected $table = 'categorys';
	protected $primaryKey = 'id';
	protected $loginUniqueColumn = 'email';

	protected $allowedColumns = [

		'category',
		'category_id',
		'user_id',
		'date_created',
		'date_updated',
		'status',
	];

	protected $onInsertValidationRules = [

		'category' => [
			'alpha_numeric_symbol',
			'required',
		],
	];

	protected $onUpdateValidationRules = [

		'category' => [
			'required',
			'alpha_numeric_symbol',
		],
		
	];


	public function createCategory($data)
	{

		$ses   = new \Core\Session;

		if($this->validate($data))
		{
			//add extra user columns here
			$data['category_slug'] = slugify(esc($data['category']));
			$data['category_id'] = randomString(10);
			$data['user_id'] = $ses->user('user_id');
			$data['date_created'] = date("Y-m-d H:i:s");
			$data['date_updated'] = date("Y-m-d H:i:s");
			$data['status'] = "active";

			$this->insert($data);
			message("Category Created!");
		}
	}

	public function getCategorys()
	{
		$user = new \Model\User;

		$query = "select * from categorys as c join users as u where c.user_id = u.user_id";
		$data = $this->query($query);

		if(is_array($data))
		{
			return $data;
		}
	}

	public function getCategory($id)
	{
		//
		$row = $this->first(['category_id'=>$id]);
		if(!empty($row))
		{
			return $row;
		}
	}

	public function editCategory($data,$id)
	{

		if($this->validate($data))
		{
			//add extra user columns here
			$data['category'] = esc($data['category']);
			$data['date_updated'] = date("Y-m-d H:i:s");
			$data['status'] = "active";

			$this->update($id, $data, 'category_id');
			message("Category Edited!");
		}
	}

	public function deleteCategory($id, $category_id = "category_id")
	{
			$this->delete($id, $category_id);
			message("Category trashed!");
	}
}