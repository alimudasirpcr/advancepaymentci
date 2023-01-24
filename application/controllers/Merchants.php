<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Merchants extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Transactions_m","transactions");
   	}
 	public function index()
	{
		$header_data = array('page_title' => 'Merchants');
		load_main_template('merchants_v', $header_data,'');
	}
	public function AddMerchant()
	{
 		$header_data = array('page_title' => 'Add Merchant');
		load_main_template('add_merchant_v', $header_data, '');
	}
	public function UpdateMerchan1d()
	{
   		$header_data = array('page_title' => 'Update Merchant');
		$data['error_message'] = '';
		if(!empty($_GET['key_id']))
		{
  			$merchant_id = base64_decode($this->input->get('key_id', TRUE));
			if($merchant_id>0)
			{
  				$data['row'] = $this->transactions->get_merchant_row($merchant_id,"all");
				if(empty($data['row']))
				{
					$data['error_message'] = 'Please select valid record';
				}
  			}
			else
			{
				$data['error_message'] = 'Please select valid record';	
			}
 		}
		else
		{
			$data['error_message'] = 'Please select valid record';	
		}
  		load_main_template('update_merchant_v', $header_data,$data);
	}
  	public function load_ajax_merchants_list()
	{
		$data = array();
		$data['page_number'] = 0;
		$data['error_message'] = '';
 		if(!empty($_POST['page_number']))
		{
			$data['page_number'] = $_POST['page_number'];
		}
		if($data['page_number']>0)
		{
			$perPage = 30;
			$total_records = $this->transactions->get_merchants_count();
			$data['total_pages'] = ceil($total_records/$perPage);
			$data['start'] = ceil(($data['page_number']-1) * $perPage);
  			$data['results'] = $this->transactions->get_merchants_data($data['start'],$perPage);
 		}
		else
		{
			$data['error_message'] = 'No Record Found!';
		}
 		$this->load->view("Ajaxviews/load_ajax_merchants_v",$data);
	}
}
