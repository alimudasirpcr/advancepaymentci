<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_Controller 
{
 	public function index()
	{
		$header_data = array('page_title' => 'Dashboard');
		$this->load->model("Transactions_m","transactions");
  		$data['statistics_row'] = $this->transactions->get_transaction_statistics();
		load_main_template('dashboard_v', $header_data,$data);
	}
}
