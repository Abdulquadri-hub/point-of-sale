<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Payment class
 */
class Payment
{
	
	use Model;

	protected $table = 'payments';
	protected $primaryKey = 'id';

	protected $allowedColumns = [
		'email',
		'payment_id',
		'order_id',
		'user_id',
		'amountpaid',
	    'reference',
	    'customer_code',
	    'status',
		'paid_at',
	    'created_at'
	];

	public function create_payment($ref,
		$email,
		$amountpaid,
	    $reference,
	    $customer_code,
	    $status,$paid_at,
	    $created_at
		)
	{
		//
		$order = new \Model\Order;
		$ses = new \Core\Session;

		$user_id = $ses->user('user_id');
		$ip = getIPAddress();

		$row = $order->first(['ip_address'=>$ip, 'user_id'=>$user_id]);

		if(!$this->checkpayment($ref))
		{
		$data['email'] = $email;
		$data['payment_id'] = randomString(10);
		$data['order_id'] = $row->order_id;
		$data['user_id'] = $row->user_id;
		$data['amountpaid'] = $amountpaid;
		$data['reference'] = $reference;
		$data['customer_code'] = $customer_code;
		$data['status'] = $status;
		$data['paid_at'] = $paid_at;
		$data['created_at'] = $created_at;
	    }
		$this->insert($data);
	}

	public function checkpayment($ref)
	{
		//
		$ses = new \Core\Session;
		$ip = getIPAddress();
		
		$this->limit = 1;

			$row = $this->first(['reference'=>$ref]);
			if(is_array($row) && count($row) == 1)
			{
				return true;
			}
	}


}