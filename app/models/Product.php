<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Product class
 */
class Product
{
	
	use Model;

	protected $table = 'products';
	protected $primaryKey = 'id';

	protected $allowedColumns = [

		'product',
		'product_id',
		'user_id',
		'category_id',
		'brand_id',
		'description',
		'price',
		'quantity',
		'status',
		'slug',
		'barcode',
		'image',
		'date_created',
		'date_updated',
	];

	protected $onInsertValidationRules = [
		
		'product' => [
			'alpha_numeric_symbol',
			'required',
		],
		'description' => [
			'alpha_numeric_symbol',
			'required',
		],
		'price' => [
			'required',
		],
		'category' => [
			'alpha_numeric_symbol',
			'required',
		],
		'brand' => [
			'alpha_numeric_symbol',
			'required',
		],
		'image' => [
			'required',
		],
		'barcode' => [
			'required',
		],
	];

	protected $onUpdateValidationRules = [

		'product' => [
			'alpha_numeric_symbol',
			'required',
		],
		'description' => [
			'alpha_numeric_symbol',
			'required',
		],
		'price' => [
			'required',
		],
		'category' => [
			'alpha',
			'required',
		],
		'brand' => [
			'alpha',
			'required',
		],
		'image' => [
			'required',
		],
		'barcode' => [
			'required',
		],
	];


	public function createProduct($data)
	{
		//
		$ses   = new \Core\Session;
		$req   = new \Core\Request;

		if($this->validate($data))
		{
			$data['product_id'] = randomString(10);
			$data['slug'] = slugify(esc($data['product']));
			$data['status'] = "active";
			$data['barcode'] = random_int(000000,99999999);
			$data['user_id'] = $ses->user('user_id');
			$data['date_created'] = date("Y-m-d H:i:s");
			$data['date_updated'] = date("Y-m-d H:i:s");
			$data['image'] = "";

            
			$files = $req->files();

			$image = $files['image'];

			if(!empty($image['name']))
			{
				$folder = 'productimages/';
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder . 'index.php', "");
				}

				$allowed = ['image/jpeg', 'image/jpg', 'image/webp', 'image/png'];

				if(in_array($image['type'], $allowed))
				{
					$data['image'] = $folder . time() . "." . $image['name'];
					move_uploaded_file($image['tmp_name'], $data['image']);

					(new \Model\Image())->resize($data['image'], 1000);

				}else{
					$this->errors['image'] =  "This file is not supported";
				}

			}else{
				$this->errors['image'] =  "Image is required";
			}

			if(empty($this->errors))
			{
				$this->insert($data);
				message('Product Created!');
			}	
		}
	}

	public function editProduct($data,$id)
	{
		//
		
		$ses   = new \Core\Session;
		$req   = new \Core\Request;

		// $data['id'] = $id; 

		if($this->validate($data))
		{
			$data['slug'] = slugify(esc($data['product']));
			$data['status'] = "active";
			$data['date_updated'] = date("Y-m-d H:i:s");

		     
			$files = $req->files();

			$image = $files['image'];
			

			$folder = 'productimages/';

			if(!file_exists($folder))
			{
				mkdir($folder,0777,true);
				file_put_contents($folder . 'index.php', "");
			}

			$allowed = ['image/jpeg', 'image/jpg', 'image/webp', 'image/png'];

			if(!empty($image['name']))
			{  
				if(in_array($image['type'], $allowed))
				{
					
					$data['image'] = $folder . time() . "." . $image['name'];
					move_uploaded_file($image['tmp_name'], $data['image']);

					(new \Model\Image())->resize($data['image'], 1000);

					$row = $this->getProduct($id);
					if(file_exists($row->image))
						unlink($row->image);
				}else{
					$this->errors['image'] =  "This file is not supported";
				}
			}	

			if(empty($this->errors))
			{				
				$this->update($id, $data, 'product_id');
				message('Product Edited!');
			}
		}
	}

	public function getProducts($limit, $offset)
	{

		$query = "select * from products as p 
		join users as u on u.user_id = p.user_id
		join categorys as c on c.category_id = p.category_id
		join brands as b on b.brand_id = p.brand_id limit $limit offset $offset";

		$data = $this->query($query);
		if(is_array($data))
		{
			
			return $data;
			
		}
	}

	public function getProduct($id)
	{
		//
		$category = new \Model\Category;
		$brand = new \Model\Brand;

		$this->limit = 1;

		$row = $this->where(['product_id'=>$id]);
		if(!empty($row))
		{
			foreach($row as $key => $value)
			{
				$row[$key]->category =  $category->first(['category_id' => $row[$key]->category_id]);
				$row[$key]->brand =  $brand->first(['brand_id' => $row[$key]->brand_id]);
				return $row[0];
			}
		}
	}

	public function getProductBySlug($slug,$product_id)
	{
		//
		$category = new \Model\Category;
		$brand = new \Model\Brand;

		// $query = "select * from products as p 
		// join users as u on u.user_id = p.user_id
		// join categorys as c on c.category_id = p.category_id
		// join brands as b on b.brand_id = p.brand_id 
		// where slug = :slug and product_id = :product_id limit 1";

		$row = $this->first(['slug'=>$slug, 'product_id'=>$product_id]);
		if(!empty($row))
		{ 
			$this->updateProductViews($row->slug);
			return $row;
		}
	}

	public function getPopularProducts()
	{
		
		$this->order_column = "views";
		$this->limit = 10;
		$data = $this->findAll();
		if(is_array($data))
		{
			return $data;
		}
	}

	public function productsWithCategory()
	{
		$query = "select * from products as p 
		join users as u on u.user_id = p.user_id
		join categorys as c on c.category_id = p.category_id";

		$data = $this->query($query);
		if(is_array($data))
		{
			return $data;
			
		}
	}

	public function updateProductViews($slug)
	{
		
		$query = "update products set views = (views + 1) where slug = :slug limit 1";
		$data = $this->query($query, ['slug'=>$slug]);
		if(is_array($data))
		{
			return true;
		}

		return false;
	}
	
	public function countProductViews(){}
}