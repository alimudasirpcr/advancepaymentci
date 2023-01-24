<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends MY_Login_Controller 
{
	public function __construct()
	{
		parent::__construct();
  	}
  	public function index()
	{
		$header_data = array('page_title' => 'Login');
		load_login_template('login_v', $header_data,'');
	}
	public function ForgotPassword()
	{
		$header_data = array('page_title' => 'Forgot Password');
		load_login_template('forgot_password_v', $header_data,'');
	}
 	public function ResetPassword()
	{
		$header_data = array('page_title' => 'Reset Password');
		$check_flag = 0;
 		if(!empty($_GET['link']))
		{
			$this->load->model("login_m","login");
			$link = base64_decode($_GET['link']);
			$id = strtok($link,'The');
			if($id>0)
			{
				$reset_password_row = $this->login->get_user_reset_password_row($id);
 				if(!empty($reset_password_row))
				{
 					$expiry_timestamp = $reset_password_row->expiry_timestamp;
 					if($expiry_timestamp>time())
					{
						$check_flag = 1;
 					}
					else
					{
  						$data['message'] = 'We are sorry, This link is expired, Please try to reset pasword again!';
 					}
				}
				else
				{
 					$data['message'] = 'We are sorry, this link is no more available or deleted!';
 				}
			}
			else
			{
 				$data['message'] = 'We are sorry, the link you are requesting cannot be found!';
 			}
		}
		else
		{
 			$data['message'] = 'We are sorry, the link you are requesting cannot be found!';
 		}
		
		if($check_flag==1)
		{
			$data['data_link'] = $_GET['link'];
			load_login_template('reset_password_v', $header_data, $data);
		}
		else
		{
			load_login_template('login_404_v', $header_data, $data);
		}
	}
 	public function Check()
	{
		return $this->login_validation();
	}
	protected function login_validation()
	{		
 		$this->form_validation->set_error_delimiters('<li>', '</li>');
 		$this->form_validation->set_rules('username', 'username', 'trim|required',
			array('required' => 'Please enter valid username')
		);
		$this->form_validation->set_rules('password', 'Password', 'trim|required',
			array('required' => 'Please enter valid password')
		);
		if($this->form_validation->run() == FALSE)
		{
				echo validation_errors();
		}
		else
		{
			$this->load->model("login_m","login");
			$row = $this->login->get_login_user_credential();
 			if(!empty($row))
			{
 				if($row->user_id>0)
				{
 					$this->session->set_userdata("payone_user_id",$row->user_id);
					echo 'done';
				}
				else
				{
 					$this->login_enter_valid_info();
				}
			}
			else
			{
				$this->login_enter_valid_info();
			}
		}
  	}
	protected function login_enter_valid_info()
	{
		echo 'Please enter valid login information';
	}
	public function forgot_password_validation()
	{
  		$this->load->model("login_m","login");
  		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('user_email', '', 'trim|required|valid_email|callback_check_user_email',
			array(
					'required' => 'Please enter email',
					'valid_email' => 'Please enter valid email'
				 )
		);
		if($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
			$this->load->library("Smtpemails");
  			$this->load->library('Emailtemp');
			$user_row = $this->login->get_user_row_by_email($this->input->post('user_email'));
			if(!empty($user_row)) 
			{
				$receiver_full_name = $user_row->user_full_name;
 				$receiver_email = $this->input->post('user_email');
				$message_subject = "Forgot Password";
				
				$id = $this->login->add_user_reset_password();
				if($id>0)
				{
					$reset_password_row = $this->login->get_user_reset_password_row($id);
 					if($reset_password_row)
					{
						$add_timestamp = $reset_password_row->add_timestamp;
						$expiry_timestamp = $reset_password_row->expiry_timestamp;
						$message_body = $this->emailtemp->ForgotPasswordTemplate($receiver_full_name,$id,$add_timestamp,$expiry_timestamp);
					}
					else
					{
						$message_body ='';
					}
					$this->smtpemails->send($receiver_email,$message_subject, $message_body);
  					echo 'done';
				}
				else
				{
					echo 'Some error has occured, please try again';
				}
			}
		}
	}
	public function reset_password_validation()
	{
   		$this->load->model("login_m","login");
  		$this->form_validation->set_error_delimiters('<li>', '</li>');
		if(!empty($_POST['data_link']))
		{
			$link = base64_decode($_POST['data_link']);
			$id = strtok($link,'The');
			if($id>0)
			{
				$reset_password_row = $this->login->get_user_reset_password_row($id);
  				if(!empty($reset_password_row))
				{
					$expiry_timestamp = $reset_password_row->expiry_timestamp;
					if($expiry_timestamp>time())
					{
 						$this->form_validation->set_rules('password', '', 'trim|required|min_length[8]|max_length[25]',
						array(
								'required' => 'Please enter password',
								'min_length' => 'password must have minimum 8 characters or numbers',
								'max_length' => 'password must have maximum 25 characters or numbers',
							 )
						);
						if($this->form_validation->run() == FALSE)
						{
							echo validation_errors();
						}
						else
						{
							$this->form_validation->set_rules('cpassword', '', 'trim|required|matches[password]',
								array(
									'required' => 'Please enter confirm password',
									'matches' => 'password and confirm password not match'
								 )
							);
						
							if($this->form_validation->run() == FALSE)
							{
								echo validation_errors();
							}
							else
							{
								$this->load->library("Smtpemails");
								$this->load->library('Emailtemp');
								$user_row = $this->login->get_user_row_by_email($reset_password_row->email);
								if(!empty($user_row))
								{
  									$this->login->update_delete_user_reset_password($reset_password_row->id,$user_row->user_id);
									$receiver_full_name = $user_row->user_full_name;
									$receiver_email = $reset_password_row->email;
 									$message_subject = "Reset Password";
 									$message_body = $this->emailtemp->ResetPasswordTemplate($receiver_full_name);
 									$this->smtpemails->send($receiver_email,$message_subject, $message_body);
									echo 'done';
								}
								else
								{
									echo 'Some error has occured, please try again';
								}
  							}
						}
 					}
					else
					{
						echo 'We are sorry, This link is expired, Please try to reset pasword again!';
					}
				}
				else
				{
					echo 'We are sorry, the link you requested cannot be found any more!';	
				}
			}
			else
			{
				echo 'We are sorry, the link you requested cannot be found any more!';
			}
		}
		else
		{
			echo 'We are sorry, the link you requested cannot be found any more!';
		}
 	}
	public function check_user_email()
	{
		$this->load->model("login_m","login");
 		if($this->login->check_user_by_email($this->input->post('user_email'))<1)
		{
			$this->form_validation->set_message('check_user_email', 'Please enter valid email');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
