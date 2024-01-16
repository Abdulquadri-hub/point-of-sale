<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Ajax class
 */
class Ajax
{
	use MainController;

	public function index()
	{

		$data['title'] = "Ajax";
		$data['product'] = new \Model\Product();
		$sale = new \Model\Sale();
		$ses = new \Core\Session();
		$data['image'] = new \Model\Image();

		// if($_SERVER['REQUEST_METHOD'] == "POST")
		// {
			
			$raw_data = file_get_contents("php://input");

			$OBJ = (object)json_decode($raw_data, true);
			$info = (object)[];

			if(is_object($OBJ)){
				
				if($OBJ->data_type == "read")
				{
					$info->data_type = $OBJ->data_type;
					$data['product']->limit = 10;
					$rows =  $data['product']->findAll();
			
					if($rows)
					{
						$info->data = $rows;
						foreach ($rows as $key => $row) {
							
							$rows[$key]->description = strtoupper($row->description);
							// $rows[$key]->image = $data['image']->crop($row->image, 900, 900);
						}
					}
				}else
				if($OBJ->data_type == "search")
				{
					$info->data_type = $OBJ->data_type;
					$info->text = $OBJ->text;
					if(!empty($OBJ->text))
					{
						$find = "%" .$OBJ->text . "%"; 
						$rows =  $data['product']->query("select * from products where product like :find limit 10",['find'=>$find]);
						
					}else{
						$rows =  $data['product']->findAll();
					}
					if($rows)
					{
						$info->data = $rows;
						foreach ($rows as $key => $row) {
							
							$rows[$key]->description = strtoupper($row->description);
							// $rows[$key]->image = $data['image']->crop($row->image, 900, 900);
						}
					}
				}else
				if($OBJ->data_type == "checkout")
				{
					
					$info->data_type = $OBJ->data_type;
					$info->text = $OBJ->text;

					$arr = [];
					
					foreach ($OBJ->text as $row) 
					{
						$row = (object)$row;
						if(is_object($row))
						{
							$arr['sales_id'] = randomString(10);
							$arr['product_id'] = $row->product_id;
							$arr['user_id'] =  $ses ->user('user_id');
							$arr['receipt_no'] =  getRecieptNumber();
							$arr['quantity'] =  $row->quantity;
							$arr['amount'] =  $row->price;
							$arr['total'] =  ($row->price  * $row->quantity);
							$arr['sales_date_created'] =  date("Y-m-d H:i:s");

							$sale->insert($arr);
							$info->status = "Sales saved";
						}
					}
					
				}		
			
				echo json_encode($info);
			}			
		//}
	}

}



