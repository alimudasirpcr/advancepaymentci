<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Login_Controller extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->checkLoginStatus();
  	}
	// redirect user to login page if not logged in
	protected function checkLoginStatus() 
	{
		if ($this->session->userdata('payone_user_id')) 
		{
			redirect(base_url('dashboard'));
		}
	} 
}
?>