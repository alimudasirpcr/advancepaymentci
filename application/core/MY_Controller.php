<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->checkLoginStatus();
  	}
	// redirect user to login page if not logged in
	protected function checkLoginStatus() 
	{
		if (!$this->session->userdata('payone_user_id')) 
		{
			redirect(base_url('login'));
		}
	} 
 	public function get_login_user_row()
	{
		$this->load->model("User_m","user");
		return $this->user->get_login_user_row($this->session->userdata('payone_user_id'));	
	}
	public function get_main_transaction_row($main_transaction_id)
	{
		$this->load->model("Transactions_m","transactions");
		return $this->transactions->get_main_transaction_row($main_transaction_id);	
	}
 	public function count_approved_sub_transactions($main_transaction_id)
	{
		$this->load->model("Transactions_m","transactions");
		return $this->transactions->count_approved_sub_transactions($main_transaction_id);	
	}
	public function count_processed_sub_transactions($main_transaction_id)
	{
		$this->load->model("Transactions_m","transactions");
		return $this->transactions->count_processed_sub_transactions($main_transaction_id);	
	}
	public function count_total_approved_sub_transactions()
	{
		$this->load->model("Transactions_m","transactions");
		return $this->transactions->count_total_approved_sub_transactions();	
	}
	public function get_payment_mode()
	{
		$this->load->model("Transactions_m","transactions");
		$payment_mode = $this->transactions->get_payment_mode();
		if(!empty($payment_mode))
		{
			return $payment_mode;
		}
		else
		{
			return 'Test';	
		}
	}
}
?>