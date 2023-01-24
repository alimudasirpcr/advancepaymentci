<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CI_Controller 
{
	public function index()
	{
 		$data = array('payone_user_id');
 		$this->session->unset_userdata($data);
		return redirect(base_url('login'));
	}
}
