<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

use \Core\Pager;

/**
 * Dashboard class
 */
class Dashboard
{
	use MainController;
	

	public function index()
	{

		$data['title'] = "Dashboard";

		$ses = new \Core\Session;
		$data['sale'] = new \Model\sale();
		$data['user'] = new \Model\User();
		$data['image'] = new \Model\Image;


		if(!$ses->is_logged_in())
		{
			redirect('login');
		}		

		 // fetch sales
		 $sale = new \Model\sale();
		 $data['total_sales'] = count($sale->getSales($sale)) ?? 0;

		 $data['revenue'] = $sale->getSaleRevenue($sale) ?? 0;

		$dailyData = $sale->TodayGraphRecords($sale);	
		$monthlyData = $sale->MonthGraphRecords($sale);
		$yearlyData = $sale->YearGraphRecords($sale);

		$data['daily_data'] = $sale->generate_daily_data($dailyData);
		$data['monthlyData'] =  $sale->generate_monthly_data($monthlyData);
		$data['yearlyData'] =  $sale->generate_yearly_data($yearlyData);
	
		$data['ses'] = $ses;
		if($ses->access('supervisor'))
		{
			$this->view('admin/a-home',$data);

		}else{
			redirect('access-denied');
		}

	}

	public  function products($type = "", $id = null)
	{
		//
		$data['ses'] = new \Core\Session;
		$data['req'] = new \Core\Request;
		$data['image'] = new \Model\Image;

		if(!$data['ses']->is_logged_in())
		{
			redirect('login');
		}

		$product = new \Model\product;

		switch ($type) {

			case 'add':

				$data['title'] = "Add Product";

				$data['product'] = $product;

				$data['categorys'] = (new \Model\Category())->getCategorys();
				$data['brands'] = (new \Model\brand())->getBrands();

				if($data['req']->posted())
				{
					$product->createProduct($_POST);
					redirect('admin/products');
				}

				if($data['ses']->access('supervisor'))
				{
					$this->view('admin/products/add',$data);
				}else{
					 redirect('access-denied');
				}

				break;
				
			case 'edit':

				$data['title'] = "Edit Product";

				$data['product'] = $product;

				if($data['req']->posted())
				{
					$product->editProduct($_POST,$id);
					redirect('admin/products');
				}

				$data['categorys'] = (new \Model\Category())->getCategorys();
				$data['brands'] = (new \Model\brand())->getBrands();

				$data['row'] = $data['product']->getProduct($id);
				if($data['ses']->access('supervisor')){
					$this->view('admin/products/edit',$data);
				}else{
					redirect('access-denied');
				}
				
				break;


			case 'delete':

				$data['title'] = "Delete Product";

				$data['product'] = $product;
				$data['row'] = $data['product']->getProduct($id);

				if($data['ses']->access('supervisor')){
					
					$this->view('admin/products/delete',$data);
				}else{
					redirect('access-denied');
				}
				break;

			
			default:

				$data['title'] = "Products";

                $limit = 2;
                $pager = new Pager($limit);
				$offset = $pager->offset;
				
				$product->limit = $limit;
				$product->offset = $offset;
						
				$data['pager'] = $pager;
				$data['product'] = $product;
				


				$data['products'] = $data['product']->getProducts($product->limit, $product->offset);
				if($data['ses']->access('supervisor')){

					$this->view('admin/products/product',$data);
				}else{
					redirect('access-denied');
				}
				break;
		}
	}

	public  function brands($type = "", $id = null)
	{
		//
		$image = new \Model\Image;
		$user = new \Model\User;
		$ses   = new \Core\Session;
		$req   =  new \Core\Request;
		$pager = new \Core\Pager();

		$brand = new \Model\Brand();

		if(!$ses->is_logged_in())
		{
			redirect('login');
		}

		switch ($type) {

			case 'add':

				$data['title'] = "Add Brand";

				if($req->posted())
				{
					$brand->create_brand($_POST);
				}

				$data['brand'] = $brand;
				$data['image'] = $image;
				$data['ses'] = $ses;
				if($data['ses']->access('supervisor')){

					$this->view('admin/brands/add',$data);
				}else{
					redirect('access-denied');
				}
				break;

			case 'edit':

				$data['title'] = "Edit Brand";

				$data['brand'] = $brand;
				$data['image'] = $image;
				$data['ses'] = $ses;

				if($req->posted())
				{
					$brand->editBrand($_POST,$id);
				}

				$data['row'] = $brand->getBrand($id);
				if($data['ses']->access('supervisor')){

					$this->view('admin/brands/edit',$data);
				}else{redirect('access-denied');}
				break;


			case 'delete':

				$data['title'] = "Delete Brand";
				
				$data['brand'] = $brand;
				$data['image'] = $image;
				$data['ses'] = $ses;

				if($req->posted())
				{
					$brand->deleteBrand($id);
					redirect('admin/brands');
				}

				$data['row'] = $brand->getBrand($id);
				if($data['ses']->access('supervisor')){

					$this->view('admin/brands/delete',$data);
				}else{redirect('access-denied');}
				break;

			
			default:

				$data['title'] = "Brands";

				$data['brand'] = $brand;
				$data['image'] = $image;
				$data['ses'] = $ses;

				$limit = 2;
                $pager = new Pager($limit);
				$offset = $pager->offset;
				
				$brand->limit = $limit;
				$brand->offset = $offset;
						
				$data['pager'] = $pager;

				$query = "select * from brands as b join users as u where b.user_id = u.user_id limit $limit offset $offset";
				$data['brands'] = $brand->query($query);
				
				if($data['ses']->access('supervisor')){

					$this->view('admin/brands/brand',$data);
				}else{redirect('access-denied');}
				break;
		}
	}

	public  function category($type = "", $id = null)
	{
		//
		$data['ses'] = new \Core\Session;
		$data['req'] = new \Core\Request;
		$data['pager'] = new \Core\Pager();
		$data['image'] = new \Model\Image;

		if(!$data['ses']->is_logged_in())
		{
			redirect('login');
		}

		$category = new \Model\Category();
		
		switch ($type) {

			case 'add':

				$data['title'] = "Add Category";

				if($data['req']->posted())
				{
					$category->createCategory($_POST);
				}

				$data['category'] = $category;
				if($data['ses']->access('supervisor')){

					$this->view('admin/categories/add',$data);
				}else{redirect('access-denied');}
				break;

			case 'edit':

				$data['title'] = "Edit Category";

				$data['category'] = $category;

				if($data['req']->posted())
				{
					$data['category']->editCategory($_POST,$id);
				}

				$data['row'] = $data['category']->getCategory($id);
				if($data['ses']->access('supervisor')){

					$this->view('admin/categories/edit',$data);
				}else{redirect('access-denied');}
				break;


			case 'delete':

				$data['title'] = "Delete Category";
				
				$data['category'] = $category;

				if($data['req']->posted())
				{
					$data['category']->deleteCategory($id);
					redirect('admin/category');
				}

				$data['row'] = $data['category']->getCategory($id);
				if($data['ses']->access('supervisor')){

					$this->view('admin/categories/delete',$data);
				}else{redirect('access-denied');}
				break;

			
			default:

				$data['title'] = "Category";


				$limit = 2;
                $pager = new Pager($limit);
				$offset = $pager->offset;
				
				$category->limit = $limit;
				$category->offset = $offset;
						
				$data['pager'] = $pager;

				$data['category'] = $category;

				$query = "select * from categorys as c 
				join users as u where c.user_id = u.user_id 
				limit $category->limit offset $category->offset";

				$data['categorys'] = $category->query($query);

				if($data['ses']->access('supervisor')){

					$this->view('admin/categories/category',$data);
				}else{redirect('access-denied');}
				break;
		}
	}


	public  function sales($type = "", $id = null)
	{
		//
		$data['ses'] = new \Core\Session;
		$data['req'] = new \Core\Request;
		$data['image'] = new \Model\Image;
		$sale = new \Model\sale();
		

		if(!$data['ses']->is_logged_in())
		{
			redirect('login');
		}

		switch ($type) {

			case 'edit':

				$data['title'] = "Edit Sales";

				if($data['ses']->access('supervisor')){

					$this->view('admin/sales/edit',$data);
				}else{redirect('access-denied');}
				break;


			case 'delete':

				$data['title'] = "Delete sales";

				$sale->deletesale($id);
				redirect('admin/sales');
				
				// $this->view('admin/sales/delete',$data);
				break;

			
			default:

				$data['title'] = "Sales";

				$startdate = $_POST['start'] ?? null;
				$enddate = $_POST['end'] ?? null;

                $limit = 3;
                $pager = new Pager($limit);
				$offset = $pager->offset;
				
				$sale->limit = $limit;
				$sale->offset = $offset;

				$tab = $_GET['tab'] ?? "";

				switch ($tab) {
					case 'table':
				        // fetch total
						$total_sales = $sale->getTodaySale($sale);
        
				        // fetch sales
						$data['sales'] = $sale->getSales($sale);
						break;

					case 'graph':

						// todays records logic
						$dailyData = $sale->TodayGraphRecords($sale);			

                        //  monthly records logic
						$monthlyData = $sale->MonthGraphRecords($sale);

						$yearlyData = $sale->YearGraphRecords($sale);

						$data['daily_data'] = $sale->generate_daily_data($dailyData);
						$data['monthlyData'] =  $sale->generate_monthly_data($monthlyData);
						$data['yearlyData'] =  $sale->generate_yearly_data($yearlyData);
						
						break;
					
					default:
					
				    // fetch sales
					$data['sales'] = $sale->getSales($sale);

					if($startdate && $enddate)
					{
						$data['sales'] = $sale->getSalesByDate($sale, $startdate,$enddate);

					}else
					if($startdate && !$enddate)
					{
						$data['sales'] = $sale->getSalesByStartDate($sale, $startdate);
					}

				    // fetch total
					$total_sales = $sale->getTodaySale($sale);
					break;
				}

				$data['sale'] = $sale;
				$data['pager'] = $pager;
				$data['tab'] = $tab;
				$data['total_sales'] = $total_sales ?? 0;

				if($data['ses']->access('supervisor')){

					$this->view('admin/sales/home',$data);
				}else{redirect('access-denied');}
				break;
		}
	}


	// users 
	public  function users($type = "", $id = null)
	{
		//
		$data['ses'] = new \Core\Session;
		$req = new \Core\Request;
		$data['pager'] = new \Core\Pager();
		$data['image'] = new \Model\Image;
		$user = new \Model\user();

		if(!$data['ses']->is_logged_in())
		{
			redirect('login');
		}
		
		$limit = 10;
		$data['pager'] = new \Core\Pager($limit);
		$offset = $data['pager']->offset;
				
		$user->limit = $limit;
		$user->offset = $offset;

		$data['title'] = "Users";
		$data['user'] = $user;
		$this->view('admin/users/users',$data);
	}
	public  function users_ajax($type = "", $id = null)
	{
		//
		$data['ses'] = new \Core\Session;
		$req = new \Core\Request;
		$data['pager'] = new \Core\Pager();
		$data['image'] = new \Model\Image;
		$user = new \Model\user();

		if(!$data['ses']->is_logged_in())
		{
			redirect('login');
		}

		$data['title'] = "Users";

		if($req->method() == "POST")
		{

			$OBJ = (object)$_POST;
			$info = (object)[];

			if(is_object(($OBJ)))
			{
				if($OBJ->data_type == "read")
				{
					$info->data_type = $OBJ->data_type;

					$rows = $user->findAll();
					$info->data = $rows;

				}else
				if($OBJ->data_type == "search")
				{
					$info->data_type = $OBJ->data_type;

					if(!empty($OBJ->text))
					{
						$find = "%". $OBJ->text ."%";
						$query = "select * from users where name like :name || email like :email || role like :role limit 10";
						$rows = $user->query($query,['name'=>$find, 'email'=>$find, 'role'=>$find]);

					}else{

						$rows = $user->findAll();
					}

					$info->data = $rows;

				}else
				if($OBJ->data_type == "delete")
				{
					$id = $OBJ->id;
					$info->data_type = $OBJ->data_type;
					
					$user->query("delete from users where id = :id limit 1",['id'=>$id]);
					$info->status = "User deleted";
					
				}else
				if($OBJ->data_type == "get-row")
				{
					$id = $OBJ->id;
					$info->data_type = $OBJ->data_type;

					$row = $user->first(['id'=>$id]);
					$info->data = $row;
					
				}else
				if($OBJ->data_type == "edit")
				{
					$id = $OBJ->id;
					$info->data_type = $OBJ->data_type;

					if(!empty((int)$id))
					{
						$arr['name'] = $OBJ->name;
						$arr['email'] =  $OBJ->email;
						$arr['username'] =  $OBJ->username;
						$arr['date_updated'] =  date("Y-m-d H:i:s");

						$user->update($id, $arr);
						$info->status = "User Updated";
					}
				}


				echo json_encode($info);
				
			}
		}

	}


}

