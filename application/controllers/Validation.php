<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Validation extends MY_Controller 

{

	public function __construct()

	{

		parent::__construct();

   	}

 	public function index()

	{

  		$id = $this->input->get('id', TRUE);

		if(is_numeric($id))

		{

			$id = $id;

 		}

		else

		{

			$id =  base64_decode($this->input->get('id', TRUE));

 			if(!empty($_POST['type']))

			{

				$get_type =  base64_decode($this->input->get('type', TRUE));

				if($get_type=='main transaction')

				{

					$id = 9;

				}

				elseif($get_type=='cancel sub transaction recursion')

				{

					$id = 11;

				}

  			}

 		}

		switch($id)

		{

			case 1: $this->add_transaction_validation(); break;

			case 4: $this->update_profile_validation(); break;

			case 5: $this->change_password_validation(); break;

			case 6: $this->add_merchant_validation(); break;

			case 7: $this->update_merchant_validation(); break;

			case 8: $this->add_single_transaction_validation(); break;

			case 9: $this->delete_main_transaction_validation(); break;

			case 10: $this->payment_mode_validation(); break;

			case 11: $this->cancel_sub_transaction_recursion_validation(); break;

			case 12: $this->update_sub_transaction_validation(); break;

 			default: echo "Default"; break;

		}

 	}

	/*==================Settng validation===========================*/

	protected function update_profile_validation()

	{

   		$this->form_validation->set_error_delimiters('<li>', '</li>');

 		$this->form_validation->set_rules('user_full_name', '', 'trim|required',

 			array('required' => 'Please enter name')

		);

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

			$this->load->model("User_m","user");

 			$this->user->update_profile();

			echo 'done-SEPARATOR-update-SEPARATOR-'.base_url('setting/profile');

		}

	}

	public function change_password_validation()

	{

  		$this->form_validation->set_error_delimiters('<li>', '</li>');

 		$this->form_validation->set_rules('old_password', '', 'trim|required|callback_check_user_password',

				array('required' => 'Please enter current password')

		);

		$this->form_validation->set_rules('new_password', '', 'trim|required|min_length[8]|max_length[25]|callback_check_password_strength',

			array(

					'required' => 'Please enter new password',

					'min_length' => 'New password must have minimum 8 characters or numbers',

					'max_length' => 'New password must have maximum 25 characters or numbers',

				 )

		);

		$this->form_validation->set_rules('confirm_password', '', 'trim|required|matches[new_password]',

				array(

					'required' => 'Please enter confirm password',

					'matches' => 'New password and confirm password not match'

				 )

		);

   		if($this->form_validation->run() == FALSE)

		{

			echo validation_errors();

		}

		else

		{

			$this->load->model("User_m","user");

 			$this->user->update_user_password();

 			echo 'done-SEPARATOR-update-SEPARATOR-'.base_url('setting/Changepassword');

 		}

   	}

	public function payment_mode_validation()

	{

  		$this->form_validation->set_error_delimiters('<li>', '</li>');

 		$this->form_validation->set_rules('payment_mode', '', 'trim|required|callback_check_payment_mode',

				array('required' => 'Please select mode of payment')

		);

		if($this->form_validation->run() == FALSE)

		{

			echo validation_errors();

		}

		else

		{

			$this->load->model("Transactions_m","transactions");

 			$this->transactions->save_payment_mode();

 			echo 'done-SEPARATOR-update-SEPARATOR-'.base_url('setting/PaymentMode');

 		}

   	}

 	/*==================Transaction validation===========================*/

	protected function add_transaction_validation()

	{

		$this->load->library('excel');

		$this->load->helper('file');

		$this->load->model("Transactions_m","transactions");

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_rules('merchant_id', '', 'trim|required',

			array('required' => 'Please select merchant id')

		);

		$this->form_validation->set_rules('file', '', 'callback_check_import_file');

 		if($this->form_validation->run() == FALSE)

		{

			echo validation_errors();

		}

		else

		{

			//upload file start

 			$upload_folder = FCPATH.'uploads';

			$target_folder = FCPATH.'uploads/ImportedFile';

			if(!file_exists($upload_folder)) 

			{

				mkdir($upload_folder, 0777, true);

			}

			if(!file_exists($target_folder)) 

			{

				mkdir($target_folder, 0777, true);

			}

			$config['upload_path']   = $target_folder.'/';

			$config['allowed_types'] = '*';

			$new_name = time().$_FILES["file"]['name'];

			$config['file_name'] = $new_name;

			$this->load->library('upload', $config);

			if($this->upload->do_upload('file'))

			{

 				$uploadData = $this->upload->data();

				$uploadedFile = $uploadData['file_name'];

				//upload file end

				//import code start

				$records_array = array();

				$data = array();

				$path = $_FILES["file"]["tmp_name"];

				

				$object = PHPExcel_IOFactory::load($path);

				$cell_collection = $object->getActiveSheet()->getCellCollection();

  				if(!empty($cell_collection)) 

				{

					foreach($cell_collection as $cell)

					{

						$column = $object->getActiveSheet()->getCell($cell)->getColumn();

						$row = $object->getActiveSheet()->getCell($cell)->getRow(); 

						$data_value = $object->getActiveSheet()->getCell($cell)->getCalculatedValue();

						

						/*if($row>1)

						{

							$records_array[$row][$column] = $data_value;

						}*/

						

						$records_array[$row][$column] = $data_value;

					}

				}

  				//import code end

				//insert in databse

 				if(!empty($uploadedFile) && !empty($records_array))

				{

					$this->transactions->add_transaction($uploadedFile,$records_array);

					echo 'done-SEPARATOR-add-SEPARATOR-'.base_url('transactions');

				} 

				else

				{

					echo "<li>Please refresh page and try again";	

				}

 			}

   		}

	}

	protected function add_single_transaction_validation()

	{
 		$this->load->model("Transactions_m","transactions");

		$this->form_validation->set_error_delimiters('<li>', '</li>');

 		$this->form_validation->set_rules('merchant_id', '', 'trim|required',

			array('required' => 'Please select merchant id')

		);

		$this->form_validation->set_rules('lastname', '', 'trim|required',

			array('required' => 'Please enter last name')

		);

		$this->form_validation->set_rules('amount', '', 'trim|required',

			array('required' => 'Please enter amount')

		);

		$this->form_validation->set_rules('iban', '', 'trim|required',

			array('required' => 'Please enter iban')

		);

		/*$this->form_validation->set_rules('bic', '', 'trim|required',

			array('required' => 'Please enter bic')

		);*/

		$this->form_validation->set_rules('period', '', 'trim|required|callback_check_transaction_period',

			array('required' => 'Please select period')

		);

  		if($this->form_validation->run() == FALSE)

		{

			echo validation_errors();

		}

		else

		{ 

			$this->transactions->add_single_transaction();

			echo 'done-SEPARATOR-add-SEPARATOR-'.base_url('transactions');

		}

	}

	protected function delete_main_transaction_validation()

	{

		$this->load->model("Transactions_m","transactions");

 		if(!empty($_POST['ids']))

		{

			$main_transaction_id = base64_decode($this->input->post('ids'));

			if($main_transaction_id>0)

			{

				$main_row = $this->transactions->get_main_transaction_row($main_transaction_id);

				if(!empty($main_row))

				{

					if($main_row->main_transaction_id>0)

					{

						$count_processed_sub_transactions= $this->transactions->count_processed_sub_transactions($main_transaction_id);

						if($count_processed_sub_transactions<1)

						{

 							if(!empty($main_row->uploaded_file_name))

							{

								$target_folder = FCPATH.'uploads/ImportedFile/';

								@unlink($target_folder.$main_row->uploaded_file_name);

							}

							$this->transactions->delete_main_transaction_record($main_transaction_id);

							echo 'done';

						}

						else

						{

							echo "This transaction is already processed";

						}

					}

					else

					{

						echo "Please select valid record to delete";

					}

				}

				else

				{

					echo "Please select valid record to delete";

				}

 			}

			else

			{

				echo "Please select valid record to delete";

			}

		}

		else

		{

			echo "Please select valid record to delete";

		}

 	}

	protected function cancel_sub_transaction_recursion_validation()

	{

		$this->load->model("Transactions_m","transactions");

 		if(!empty($_POST['ids']))

		{

			$sub_transaction_id = base64_decode($this->input->post('ids'));

			if($sub_transaction_id>0)

			{

				$sub_transaction_arr = $this->transactions->get_sub_transaction_row($sub_transaction_id);

				if(!empty($sub_transaction_arr))

				{

					if($sub_transaction_arr->sub_transaction_id>0)

					{

						if($sub_transaction_arr->is_cancel_recursion=='No')

						{

							$this->transactions->update_cancel_recursion($sub_transaction_id);

							echo 'done';

						}

 						elseif($sub_transaction_arr->is_cancel_recursion=='N/A')

						{

							echo "There is no recursion set for this transaction";

						}

						else

						{

							echo "Recursion is already removed from this transaction";

						}

					}

					else

					{

						echo "Please select valid record to continue!";

					}

				}

				else

				{

					echo "Please select valid record to continue!";

				}

 			}

			else

			{

				echo "Please select valid record to continue!";

			}

		}

		else

		{

			echo "Please select valid record to continue!";

		}

 	}

	/*==================Merchant validation===========================*/

	protected function add_merchant_validation()

	{

 		$this->load->model("Transactions_m","transactions");

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_rules('merchant_name', '', 'trim|required',

			array('required' => 'Please enter merchant name')

		);

		$this->form_validation->set_rules('aid', '', 'trim|required',

			array('required' => 'Please enter AID')

		);

		$this->form_validation->set_rules('mid', '', 'trim|required|callback_check_mid',

			array('required' => 'Please enter merchant id(MID)')

		);

		$this->form_validation->set_rules('md5_key', '', 'trim|required',

			array('required' => 'Please enter key')

		);

		$this->form_validation->set_rules('portalid', '', 'trim|required',

			array('required' => 'Please enter portal id')

		);

  		if($this->form_validation->run() == FALSE)

		{

			echo validation_errors();

		}

		else

		{

			$this->transactions->add_merchant();

			echo 'done-SEPARATOR-add-SEPARATOR-'.base_url('merchants');

   		}

	}

	protected function update_merchant_validation()

	{

 		$this->load->model("Transactions_m","transactions");

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_rules('update_id', '', 'trim|required|callback_check_merchant_record',

			array('required' => 'Please select valid record to continue')

		);

		if($this->form_validation->run() == FALSE)

		{

			echo validation_errors();

		}

		else

		{

			$this->form_validation->set_rules('merchant_name', '', 'trim|required',

				array('required' => 'Please enter merchant name')

			);

			$this->form_validation->set_rules('aid', '', 'trim|required',

				array('required' => 'Please enter AID')

			);

			$this->form_validation->set_rules('mid', '', 'trim|required|callback_check_mid',

				array('required' => 'Please enter merchant id(MID)')

			);

			$this->form_validation->set_rules('md5_key', '', 'trim|required',

				array('required' => 'Please enter key')

			);

			$this->form_validation->set_rules('portalid', '', 'trim|required',

				array('required' => 'Please enter portal id')

			);

			if($this->form_validation->run() == FALSE)

			{

				echo validation_errors();

			}

			else

			{

				$this->transactions->update_merchant();

				echo 'done-SEPARATOR-update-SEPARATOR-'.base_url('merchants');

			}

   		}

 	}

	/*==================Common validation===========================*/

	public function check_import_file()

	{

		if(isset($_FILES['file']['name']) && $_FILES['file']['name']!="")

		{

			$allowed_size = 10.1;

			$allowed_file_extension = array('xls', 'xlsx', 'csv');

			$File_extension  = strtolower(substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.')+1));

			$get_file_size = filesize($_FILES["file"]['tmp_name']);

			$current_file_size = (($get_file_size/1024)/1024);

			if(!in_array($File_extension,$allowed_file_extension))

			{

				$this->form_validation->set_message('check_import_file', $_FILES["file"]['name']." is not allowed");

				return FALSE;

			}

			else

			{

				if(($allowed_size < $current_file_size) || $get_file_size=='')

				{

					$this->form_validation->set_message('check_import_file', $_FILES["files"]['name']." size is greater than allowed size");

					return FALSE;

				}

				else

				{

					return TRUE;

				}

			}

		}

		else

		{

			$this->form_validation->set_message('check_import_file', "Please upload excel file");

			return FALSE;

		}

 	}

	public function check_user_email()

	{

		if(!empty($this->session->userdata('payone_user_id')))

		{

			$update_id = $this->session->userdata('payone_user_id');

		}

		else

		{

			$update_id = 0;

		}

		$this->load->model("user_m","user");

   		if($this->user->is_username_email_exist('user_email',$this->input->post('user_email'),$update_id)>0)

		{

			$this->form_validation->set_message('check_user_email', 'This email already exists!');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	public function check_user_password()

	{

		$this->load->model("User_m","user");

		if(!empty($this->session->userdata('payone_user_id')))

		{

			$user_id = $this->session->userdata('payone_user_id');

		}

		else

		{

			$user_id = 0;

		}

		if($this->user->check_user_password($user_id,$this->input->post('old_password'))<1)

		{

			$this->form_validation->set_message('check_user_password', 'please enter valid current password');

			return FALSE;

		}

 		else

		{

			return TRUE;

		}

	}

	public function check_password_strength()

    {

		if(!empty($_POST['new_password']))

		{

			$user_password = $this->input->post('new_password');

		}

		elseif(!empty($_POST['user_password']))

		{

			$user_password = $this->input->post('user_password');

		}

		elseif(!empty($_POST['password']))

		{

			$user_password = $this->input->post('password');

		}

		else

		{

			$user_password = '';

		}

        if(!empty($user_password))

		{

  			$pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

			

 			$total_upper_case = strlen(preg_replace('![^A-Z]+!', '', $user_password));

			$total_lower_case = strlen(preg_replace('![^a-z]+!', '', $user_password));

			$total_number =strlen(preg_replace('![^0-9]+!', '', $user_password));

			$total_special_characters = 0;

			if(preg_match($pattern,$user_password))

			{

				$total_special_characters = 1;	

			}

 			if($total_upper_case<1) // lacking uppercase characters

			{

 				$this->form_validation->set_message('check_password_strength', 'Password must contain at least one uppercase character(A-Z)');

				return FALSE;

			}

			elseif($total_lower_case<1) // lacking lowercase characters

			{

 				$this->form_validation->set_message('check_password_strength', 'Password must contain at least one lowercase character(a-z)');

				return FALSE;

			}

			elseif($total_number<1) //  lacking numbers

			{

 				$this->form_validation->set_message('check_password_strength', 'Password must contain at least one number(0-9)');

				return FALSE;

			}

			elseif($total_special_characters<1) //  lacking Special characters

			{

 				$this->form_validation->set_message('check_password_strength', 'Password must contain at least one special character');

				return FALSE;

			}

			else

			{

				return true;

			}

		}

    }

	public function check_merchant_record()

	{

 		$this->load->model("Transactions_m","transactions");

		if($this->transactions->check_merchant_mid($this->input->post('mid'),"all",0)>0)

		{

			$this->form_validation->set_message('check_mid', 'This mid already exists!');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	public function check_mid()

	{

 		$this->load->model("Transactions_m","transactions");

		if($this->transactions->check_merchant_mid($this->input->post('mid'),"all",0)>0)

		{

			$this->form_validation->set_message('check_mid', 'This mid already exists!');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	

	public function check_update_mid()

	{

 		$this->load->model("Transactions_m","transactions");

		if(!empty($_POST['update_id']))

		{

			$update_id = base64_decode($this->input->post('update_id'));

			if($update_id>0)

			{

 				if($this->transactions->check_merchant_mid($this->input->post('mid'),"all",$update_id)>0)

				{

					$this->form_validation->set_message('check_update_mid', 'Please select valid record to contnue!');

					return FALSE;

				}

				else

				{

					return TRUE;

				}

			}

			else

			{

				$this->form_validation->set_message('check_update_mid', 'Please select valid record to contnue!');

				return FALSE;

			}

		}

		else

		{

			 $this->form_validation->set_message('check_update_mid', 'Please select valid record to contnue!');

			return FALSE;

		}

 	}

	public function check_transaction_period()

	{

		if(!empty($_POST['period']))

		{

			$period = trim($this->input->post('period'));

			$possible_values = array('one time', 'weekly', 'monthly', 'quarterly', 'yearly');

			if(!in_array($period, $possible_values))

			{

				$this->form_validation->set_message('check_transaction_period', 'Please select valid period');

				return FALSE;

			}

			elseif($period=='monthly' || $period=='quarterly')

			{

				 if(!empty($_POST['recursion_start_type']))

				 {

					$recursion_start_type = trim($this->input->post('recursion_start_type'));

					$possible_recursion_start_options = array('Immediately', '1st of month', '15th of month' , 'customdate');

					if(!in_array($recursion_start_type, $possible_recursion_start_options))

					{

						$this->form_validation->set_message('check_transaction_period', 'Please select valid start of payment');

						return FALSE;

					}

					else

					{

						return TRUE;

					}

				 }

				 else

				 {

					$this->form_validation->set_message('check_transaction_period', 'Please select start of payment');

					return FALSE;

				 }

			}

			else

			{

				return TRUE;

			}

		}

		else

		{

			return TRUE;

		}

	}

	

	public function check_payment_mode()

	{

		if(!empty($_POST['payment_mode']))

		{

			$payment_mode = trim($this->input->post('payment_mode'));

			$possible_values = array('test', 'live');

			if(!in_array($payment_mode, $possible_values))

			{

				$this->form_validation->set_message('check_payment_mode', 'Please select valid mode of payment');

				return FALSE;

			}

			else

			{

				return TRUE;

			}

		}

		else

		{

			return TRUE;

		}

	}

	public function update_sub_transaction_validation()

	{

		if(!empty($_POST['update_id']))

		{

			$sub_transaction_id = base64_decode($this->input->post('update_id', TRUE));

			$this->load->model("Transactions_m","transactions");

			if($this->transactions->check_sub_transaction($sub_transaction_id)>0)

			{

				$this->form_validation->set_error_delimiters('<li>', '</li>');

				$this->form_validation->set_rules('payment_subject', '', 'trim|required',

					array('required' => 'Please enter subject of payment')

				);

				$this->form_validation->set_rules('amount', '', 'trim|required',

					array('required' => 'Please enter amount')

				);

				$this->form_validation->set_rules('c_id', '', 'trim|required',

					array('required' => 'Please enter Customer ID')

				);

				if($this->form_validation->run() == FALSE)

				{

					echo validation_errors();

				}

				else

				{

					if(!is_numeric($_POST['amount']))

					{

						echo 'please select valid amount';

					}

					else

					{

						$this->transactions->update_sub_transaction();

						echo 'done-SEPARATOR-update-SEPARATOR-'.base_url('transactions/TransactionsHistory');

					}

 				}

			}

			else

			{

				echo 'please select valid record';

			}

		}

		else

		{

			echo 'please select valid record';

		}

	}

 }