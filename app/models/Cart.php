<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Cart class
 */
class Cart
{
	
	use Model;

	protected $table = 'carts';
	protected $primaryKey = 'id';
	protected $loginUniqueColumn = 'email';

	protected $allowedColumns = [

		'cart_id',
		'product_id',
		'quantity',
		'ip_address',
		'user_id',
		'date_created',
		'date_updated',
	];

	/*****************************
	 * 	rules include:
		required
		alpha
		email
		numeric
		unique
		symbol
		longer_than_8_chars
		alpha_numeric_symbol
		alpha_numeric
		alpha_symbol
	 * 
	 ****************************/
	protected $onInsertValidationRules = [

		'size' => [
			'required',
		],

	];

	protected $onUpdateValidationRules = [

		'size' => [
			'required',
		],
	];

	public function createCart($productSlug,$productId)
	{

		 $row = (new \Model\Product)->first(['slug'=>$productSlug, 'product_id'=>$productId]);

		if(!$this->checkCart($row->product_id))
		{
			$ses = new \Core\Session;
			$ip = getIPAddress();
				
			    if(!isset($_SESSION['cart_items']))
			    {
			    	$_SESSION['cart_items'] = [];
			    }
			
				$item['cart_id'] = randomString(10);
				$item['product_id'] = $row->product_id;
				$item['ip_address'] = $ip;
				$item['date_created'] = date("Y-m-d H:i:s");
				$item['date_updated'] = date("Y-m-d H:i:s");

				$data = $_SESSION['cart_items'][] = $item;
				if((is_array($data)) && (count($data)  > 0) && $data)
				{
					$this->insert($data);
					message("Bag Added!");
				}

				
			
				// if(($ses->is_logged_in()) && (!empty($ses->user('username'))))
				// {
				// 	$data = $_SESSION['cart_items'];
				// 	$data['user_id'] = $ses->user('user_id');
				// 	$this->insert($data);
				// }
		}else{
			redirect('home');
		}
	}

	public function deleteCart()
	{
		//
	}
	
	public function updateCart()
	{
		//
		if(isset($_POST['update']))
		{
			//
			$totalprice = $this->totalCartItemsPrice();

			$ip = getIPAddress();
			unset($_POST['delete'], $_POST['update']);

			$quantity = $_POST['quantity'];
			$cart_id = $_POST['cart_id'];

			if($quantity !== "")
			{
				$query = "update carts set quantity = :quantity 
				where ip_address = :ip_address 
				and cart_id = :cart_id limit 1";
				
				$item = $this->query($query,[
					'quantity'=>$quantity, 
					'ip_address'=>$ip,
					'cart_id'=>$cart_id
				]);

				if(!$item)
				{
					$quantity = $this->SumQuantity();
					$totalprice = (($totalprice) * $quantity);
					return $totalprice;
				}
			}
		}
	}

	public function checkCart($productid)
	{
		//
		$ses = new \Core\Session;
		$ip = getIPAddress();
		
		$this->limit = 1;


		if($ses->is_logged_in() && $ses->user('username'))
		{	
			
			$row = $this->where(['product_id'=>$productid, 'ip_address'=>$ip]);
			if(is_array($row) && count($row) == 1)
			{
				return true;
			}

		}else{

			if(isset($ip) && $ip)
			{
				if(!empty($_SESSION['cart_items']))
				{
					$row = $_SESSION['cart_items'];
	
					if((is_array($row)))
					{
						foreach($row as $r)
						{
							if($r['product_id'] == $productid)
							{
								return true;
							}	
						}
						
					}
				}
			}
		}

		
		return false;
	}

	public function CountCartItems()
	{
		//
		$ses = new \Core\Session;
		$ip = getIPAddress();
		
		if($ses->is_logged_in() && $ses->user('username'))
		{	//
			$row = $this->where(['ip_address'=>$ip]);
			if(is_array($row) && count($row) > 0 )
			{
				return count($row);
			}

		}else{

			if(isset($ip) && $ip)
			{
				if(!empty($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0)
				{
					$row = $_SESSION['cart_items'];
					if(is_array($row) && count($row) > 0)
					{
						return count($row);
					}

				}
			}
		}	

		return 0;
	}

	public function showCartItemsInBag()
	{
		//
		if(!empty($this->CountCartItems()))
		   return $this->CountCartItems();
	    else
		   return 0;
	}

	public function displayCartItems()
	{
		$ip = getIPAddress(); 
		$ses = new \Core\Session;

		$query = "select c.*, p.price, p.image, p.product from carts as c 
		join products as p on c.product_id = p.product_id 
		where ip_address = :ip_address";

		$data = $this->query($query,[
			'ip_address'=>$ip,
			// 'user_id'=>$ses->user('user_id')
	    ]);

		if(is_array($data) && count($data) > 0)
		{
			return $data;
		}

		return false;
	}

	public function totalCartItemsPrice()
	{

        $ip = getIPAddress(); 
        $totalPrice = 0;
		$ses = new \Core\Session;

		$query = "select c.*, p.price from carts as c 
		join products as p on c.product_id = p.product_id 
		where ip_address = :ip_address";

		$data = $this->query($query,[
			'ip_address'=>$ip,
			// 'user_id'=>$ses->user('user_id')
	    ]);

		if(is_array($data) && count($data) > 0)
		{

		    foreach($data as $dt)
		    {
		    	$data = array($dt->price);
		    	$data_values = array_sum($data);
		    	$totalPrice += $data_values; 
		    }
		    return $totalPrice;
		}
	}

	public function SumQuantity()
	{

        $ip = getIPAddress(); 
        $totalPrice = 0;
		$ses = new \Core\Session;

		$query = "select * from carts
		where ip_address = :ip_address";

		$data = $this->query($query,[
			'ip_address'=>$ip,
			// 'user_id'=>$ses->user('user_id')
	    ]);

		if(is_array($data) && count($data) > 0)
		{
		    foreach($data as $row)
		    {
				$data_values = array_sum(array($row->quantity));
		    }
		    return $data_values;
		}
	}

	public function getSubtotalPrice()
	{

		$totalprice = $this->totalCartItemsPrice();
		
		$quantity = $this->SumQuantity();
		$totalprice = (($totalprice) * $quantity);
		

		return $totalprice;
	}



}