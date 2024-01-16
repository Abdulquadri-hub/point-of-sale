<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Brand class
 */
class Brand
{
	
	use Model;

	protected $table = 'brands';
	protected $primaryKey = 'id';
	protected $loginUniqueColumn = 'email';

	protected $allowedColumns = [

		'brand',
		'brand_id',
		'user_id',
		'date_created',
		'date_updated',
		'status',
	];

	protected $onInsertValidationRules = [

		'brand' => [
			'alpha_numeric_symbol',
			'required',
		],
	];

	protected $onUpdateValidationRules = [

		'brand' => [
			'required',
			'alpha_numeric_symbol',
		],
		
	];


	public function create_brand($data)
	{

		$ses   = new \Core\Session;

		if($this->validate($data))
		{
			//add extra user columns here
			$data['brand_slug'] = slugify(esc($data['brand']));
			$data['brand_id'] = randomString(10);
			$data['user_id'] = $ses->user('user_id');
			$data['date_created'] = date("Y-m-d H:i:s");
			$data['date_updated'] = date("Y-m-d H:i:s");
			$data['status'] = "active";

			$this->insert($data);
			message("Brand created!");
		}
	}

	public function getBrands()
	{
		$user = new \Model\User;

		$query = "select * from brands as b join users as u where b.user_id = u.user_id";
		$data = $this->query($query);

		if(is_array($data))
		{
			// show($data);die;
			return $data;
		}
	}

	public function getBrand($id)
	{
		//
		$row = $this->first(['brand_id'=>$id]);
		if(!empty($row))
		{
			return $row;
		}
	}

	public function editBrand($data,$id)
	{

		$ses   = new \Core\Session;

		if($this->validate($data))
		{
			//add extra user columns here
			$data['brand'] = esc($data['brand']);
			$data['date_updated'] = date("Y-m-d H:i:s");
			$data['status'] = "active";

			$this->update($id, $data, 'brand_id');
			message("Brand Edited!");
		}
	}

	public function deleteBrand($id, $brand_id = "brand_id")
	{
			$this->delete($id, $brand_id);
			message("Brand trashed!");
	}

}