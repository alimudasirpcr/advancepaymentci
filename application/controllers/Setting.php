<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
   	}
 	/*=================================Profile=================================*/
	public function Profile()
	{
 		$header_data = array('page_title' => 'Update Profile');
 		$this->load->model("User_m","user");
		$data = array();
		if(!empty($this->session->userdata('payone_user_id')))
		{
  			$data['row'] = $this->user->get_login_user_row($this->session->userdata('payone_user_id'));
		}
		load_main_template('update_profile_v', $header_data, $data);
	}
	public function Changepassword()
	{
 		$header_data = array('page_title' => 'Change Password');
		load_main_template('change_password_v', $header_data, '');
	}
	public function PaymentMode()
	{
		$this->load->model("Transactions_m","transactions");
		$data['payment_mode'] = $this->transactions->get_payment_mode();
 		$header_data = array('page_title' => 'Mode of Payment');
		load_main_template('payment_mode_v', $header_data, $data);
	}
}
