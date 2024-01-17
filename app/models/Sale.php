<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * sale class
 */
class sale
{
	
	use Model;

	protected $table = 'sales';
	protected $primaryKey = 'id';
	protected $loginUniqueColumn = 'email';
// sales_id	product_id	user_id	receipt_no	quantity	amount	total	date_created
	protected $allowedColumns = [
		'sales_id',
		'product_id',
		'user_id',
		'receipt_no',
		'quantity',
		'amount',
		'total',
		'sales_date_created',
		'sales_date_updated',
	];

	protected $onInsertValidationRules = [
	];

	protected $onUpdateValidationRules = [
	];

	public function createsale()
	{
		$cart = new \Model\Cart;
		$ses = new \Core\Session;

		if(!$this->checksale())
		{
			
			$data['sale_id'] = randomString(10);
			$data['user_id'] = $ses->user('user_id');
			$data['ip_address'] = getIPAddress();
			$data['subtotalprice'] = $cart->totalCartItemsPrice();
			$data['totalquantity'] = $cart->getSubtotalPrice();
			$data['status'] = "pending";
			$data['date_created'] = date("Y-m-d H:i:s");
			$data['date_updated'] = date("Y-m-d H:i:s");

			$this->insert($data);

		}

		return false;

	}

	public  function checksale()
	{
		//
		$ses = new \Core\Session;

			$row = $this->first(['user'=>$ses->user('user_id')]);
			if(is_array($row) && count($row) == 1)
			{
				return true;
			}
	}


	public  function deletesale($sales_id)
	{
		//
		$ses = new \Core\Session;

		$query = "delete from sales where 
		sales_id = :sales_id
		";
        (new \Model\sale)->query($query,[
			'sales_id' => $sales_id,
		]);
      
	}

	public function getTodaySale($sale)
	{
		
		$arr = [];
		$arr['year'] = date('Y');
		$arr['month'] = date('m');
		$arr['day'] = date('d');

		$result = $sale->query("select sum(total) as total from sales
		where year(sales_date_created) = :year && month(sales_date_created) = :month && day(sales_date_created) = :day
		order by $sale->order_column $sale->order_type", $arr);
		$td = $result[0];
		$data['total_sales'] = 0; 
		if($td)
		{
			
			return $data['total_sales']  = $td->total ?? 0;
		}

		return 0;	
	}

	public function getSaleRevenue($sale)
	{
		
		$arr = [];
		$arr['year'] = date('Y');
		$arr['month'] = date('m');
		$arr['day'] = date('d');

		$result = $sale->query("select sum(total) as total from sales
		order by $sale->order_column $sale->order_type");
		$td = $result[0];
		$data['total_sales'] = 0; 
		if($td)
		{
			return $data['total_sales']  = $td->total ?? 0;
		}

		return 0;	
	}

	
	public function TodayGraphRecords($sale){
		
		$arr = [];
		$arr['today'] = date('Y-m-d');

		$result = $sale->query("select total, sales_date_created from sales
		where DATE(sales_date_created) = :today", $arr);
		if($result)
		{
			return $result;
		}

	}

	public function generate_daily_data($dailyData)
	{
		$arr = [];
		for($i = 0; $i < 24; $i++)
		{
			if(!isset($arr[$i]))
				$arr[$i] = 0;  

			if(isset($dailyData)) 
			{
				foreach($dailyData as $row)
				{
					$hour = date('H', strtotime($row->sales_date_created));
					if($hour == $i)
					{
						$arr[$i] = $row->total;
					}
				}
			}
		}
		$arr = json_encode($arr);
		return $arr;
	}


	public function generate_monthly_data($records)
	{
		$arr = [];
		$total_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

		for($i = 1; $i <= $total_days; $i++)
		{
			if(!isset($arr[$i]))
				$arr[$i] = 0;  

			foreach($records as $row)
			{
				$day = date('d', strtotime($row->sales_date_created));
				if($day == $i)
				{
					$arr[$i] = $row->total;
				}
			}
		}
		
		$arr = json_encode($arr);
		return $arr;
	}

	public function generate_yearly_data($records)
	{
		$arr = [];

		for($i = 1; $i <= 12; $i++)
		{
			if(!isset($arr[$i]))
				$arr[$i] = 0;  

			foreach($records as $row)
			{
				$month = date('m', strtotime($row->sales_date_created));
				if($month == $i)
				{
					$arr[$i] = $row->total;
				}
			}
		}
		$arr = json_encode($arr);
		return $arr;
	}

	public function MonthGraphRecords($sale){
		
		$arr = [];
		$arr['month'] = date('m');
		$arr['year'] = date('Y');

		$result = $sale->query("select total,sales_date_created from sales
		where  month(sales_date_created) = :month && year(sales_date_created) = :year", $arr);
		if($result)
		{
			return $result;
		}

	}


	public function YearGraphRecords($sale){
		
		$arr = [];
		// $arr['month'] = date('m');
		$arr['year'] = date('Y');

		$result = $sale->query("select total, sales_date_created from sales
		where year(sales_date_created) = :year", $arr);
		if($result)
		{
			return $result;
		}

	}


	public function getSales($sale)
	{
		$query = "select sales.id,sales.sales_id,sales.quantity,sales.amount,sales.id, 
		sales.total,sales.sales_date_created,users.name,products.image,products.product from sales 
		join users on sales.user_id = users.user_id
		join products on sales.product_id = products.product_id 
		order by id desc limit $sale->limit offset  $sale->offset";



		$data['sales'] = $sale->query($query);

		if(is_array($data['sales']))
		{
			return $data['sales'];
		}
	}

	public function getSalesByDate($sale, $startdate,$enddate)
	{
		$var['syear'] = date('Y', strtotime($startdate));
		$var['smonth'] = date('m', strtotime($startdate));
		$var['sday'] = date('d', strtotime($startdate));

		$var['eyear'] = date('Y', strtotime($enddate));
		$var['emonth'] = date('m', strtotime($enddate));
		$var['eday'] = date('d', strtotime($enddate));

		$query = "select sales.id,sales.sales_id,sales.quantity,sales.amount,sales.id, 
		sales.total,sales.sales_date_created,users.name,products.image,products.product from sales 
		join users on sales.user_id = users.user_id
		join products on sales.product_id = products.product_id 
		where (year(sales_date_created) >= :syear 
		&& month(sales_date_created) >= :smonth 
		&& day(sales_date_created) >= :sday)
		&& (year(sales_date_created) <= :eyear 
		&& month(sales_date_created) <= :emonth 
		&& day(sales_date_created) <= :eday)
		order by $sale->order_column $sale->order_type";



		$data['sales'] = $sale->query($query,$var);

		if(is_array($data['sales']))
		{
			return $data['sales'];
		}
	}

	public function getSalesByStartDate($sale, $startdate)
	{
		$svar['syear'] = date('Y', strtotime($startdate));
		$svar['smonth'] = date('m', strtotime($startdate));
		$svar['sday'] = date('d', strtotime($startdate));

		$query = "select sales.id,sales.sales_id,sales.quantity,sales.amount,sales.id, 
		sales.total,sales.sales_date_created,users.name,products.image,products.product from sales 
		join users on sales.user_id = users.user_id
		join products on sales.product_id = products.product_id 
		where (year(sales_date_created) = :syear 
		&& month(sales_date_created) = :smonth 
		&& day(sales_date_created) = :sday)
		order by $sale->order_column $sale->order_type";



		$data['sales'] = $sale->query($query,$svar);

		if(is_array($data['sales']))
		{
			return $data['sales'];
		}
	}



}