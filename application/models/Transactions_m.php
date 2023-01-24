<?php

class Transactions_m extends CI_Model

{

	function __construct()

    {

        parent::__construct();

    }

	/*======================Transaction=============================*/


	public function gettodaytrans($d)

	{	

 		// $this->db->query('SELECT * FROM `tbl_sub_transactions` WHERE sub_transaction_date = DATE_FORMAT(CURRENT_DATE, "%d-%m-%Y");');

		 //$SQL='SELECT * FROM `tbl_sub_transactions` WHERE process="STRIPE" AND sub_transaction_date = DATE_FORMAT(CURRENT_DATE, "%d-%m-%Y");';
		 $SQL='SELECT *   FROM `tbl_sub_transactions` WHERE process="STRIPE"  and  str_to_date(sub_transaction_date,"%d-%m-%Y")  >= ( CURDATE() - INTERVAL '.$d.' DAY ) and  str_to_date(sub_transaction_date,"%d-%m-%Y")  <= CURDATE()   order by  str_to_date(sub_transaction_date,"%d-%m-%Y") desc ';
		 $query = $this->db->query($SQL);
		 return $query->result_array();

	}



	public function add_transaction($uploaded_file_name,$records_array)

	{

    	if(!empty($uploaded_file_name) && !empty($records_array))

		{

 			//main transaction

			$main_transaction_data = array(

				'title' => $this->input->post('title'),

 				'merchant_id' => $this->input->post('merchant_id'),

				'uploaded_file_name' => $uploaded_file_name,

				'transaction_date' => time(),

				'main_record_type' => 'file',

				'main_is_run_cron_job' => 'No',

 			);

			$this->db->set($main_transaction_data);

			$this->db->insert('tbl_main_transactions');

			$main_transaction_id = $this->db->insert_id();

			if($main_transaction_id>0)

			{

				$today_date = date("d");
				//print_r($records_array); exit();

				foreach($records_array as $val)

				{

 					$run_cron_job_timestamp = strtotime('+5 minutes',time());

					$sub_transaction_date = date('d-m-Y',time());

					$sub_transaction_timestamp = time();

					$customdate=0;
					$custom_logic="";			

					$empty_one = '';

					$empty_two = '';

					$empty_three = '';

					$process = '';

					$firstname = '';

					$lastname = '';

					$amount = '';

					$user_amount = '';

 					$customer_id = '';

					$payment_subject = '';

					$iban = '';

					$bic = '';

					$period = 'one time';

					$is_recursion  = 'No';

					$recursion_date  = '';

					$recursion_start_type = '';
					$email ='';

					if(!empty($val['A']))

					{

						$empty_one = $val['A'];

					}

					if(!empty($val['B']))

					{

						$empty_two = $val['B'];

 					}

					if(!empty($val['C']))

					{

						$process = $val['C'];

					}

					if(!empty($val['R']))

					{

						$email = $val['R'];

					}
					if(!empty($val['E']))

					{

						$firstname = $val['E'];

					}

					if(!empty($val['F']))

					{

						$lastname = $val['F'];

					}

					if(!empty($val['G']))

					{

						$user_amount = $val['G'];

						$amount_symbols = array(",", ".");

						$amount = str_replace($amount_symbols, "", $user_amount);

					}

					if(!empty($val['I']))

					{

						$empty_three = $val['I'];

					}

 					if(!empty($val['J']))

					{

						$payment_subject = $val['J'];

					}

					if(!empty($val['K']))

					{

						$customer_id = $val['K'];

					}

 					if(!empty($val['L']))

					{

						$iban = $val['L'];

					}

					if(!empty($val['M']))

					{

						$bic = $val['M'];

					}

					if(!empty($val['N']))

					{

 						$period = strtolower($val['N']);

						if($period=='one time')

						{

							$is_recursion  = 'No';

							$recursion_date  = '';

							$is_cancel_recursion = 'N/A';

						}

						else

						{

							$is_recursion  = 'Yes';

							$recursion_date  = '';

							$is_cancel_recursion = 'No';

							if($period=='weekly')

							{

								$recursion_date  = strtotime('+1 week',time());

							}

							elseif($period=='monthly')

							{

 								if(!empty($val['O']))

								{

									$recursion_start_type = @ucfirst($val['O']);

									if($recursion_start_type=='Immediately')

									{

										$recursion_date  = strtotime('+1 month',time());

									}

									elseif($recursion_start_type=='Customdate')

									{
										if(!empty($val['P']))
										{
										$customdate=$val['P'];
										//Excel import dates are different than we normally deal. This function does its job.
										$unix_date = ($customdate - 25569) * 86400;
										$excel_date = 25569 + ($unix_date / 86400);
										$unix_date = ($excel_date - 25569) * 86400;
										$customdate=gmdate("m/d/Y", $unix_date);
										}
										else 
										{
											//in case if custom date is missing then we'll add 5 days 
										$customdate=strtotime('+5 days',date("m/d/Y"));
										}
										if(!empty($val['Q']))
										{
										$custom_logic=$val['Q'];
										}
										else {
										$custom_logic="keeplogic";
										}
										$customdate=strtotime($customdate);
										if($customdate < strtotime('-2 days',time()))
										{
										$customdate=strtotime('+5 days',date("m/d/Y"));	
										}
										$run_cron_job_timestamp = $customdate;
										if($custom_logic=="keeplogic")
										{
										$recursion_date  = strtotime('+1 month',time());
										}
										if($custom_logic=="keepcustom")
										{
										$recursion_date  = strtotime('+1 month',$run_cron_job_timestamp);
										}
									}
				


									elseif($recursion_start_type=='1st of month')

									{

 										if($today_date==1)

										{

											$run_cron_job_timestamp = strtotime('+5 minutes',time());

											$recursion_date = strtotime('+1 month',time());

											$sub_transaction_date = date('d-m-Y',time());

											$sub_transaction_timestamp = time();

										}

										else

										{

											$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 1, date('Y'));

											$recursion_date = strtotime('+1 month',$run_cron_job_timestamp);

											$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

											$sub_transaction_timestamp = $run_cron_job_timestamp;

										}

									}

									elseif($recursion_start_type=='15th of month')

									{

										if($today_date==15)

										{

											$run_cron_job_timestamp = strtotime('+5 minutes',time());

											$recursion_date = strtotime('+1 month',time());

											$sub_transaction_date = date('d-m-Y',time());

											$sub_transaction_timestamp = time();

										}

										elseif($today_date<15)

										{

											$run_cron_job_timestamp = mktime(0, 0, 0, date('m'), 15, date('Y'));

											$recursion_date = strtotime('+1 month',$run_cron_job_timestamp);

											$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

											$sub_transaction_timestamp = $run_cron_job_timestamp;

										}

										else

										{

											$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 15, date('Y'));

											$recursion_date = strtotime('+1 month',$run_cron_job_timestamp);

											$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

											$sub_transaction_timestamp = $run_cron_job_timestamp;

										}

									}

									else

									{

										$recursion_date  = strtotime('+1 month',time());

										$recursion_start_type = '';

									}

								}

								else

								{

									$recursion_date  = strtotime('+1 month',time());	

								}

							}

							elseif($period=='quarterly')

							{

 								if(!empty($val['O']))

								{

									$recursion_start_type = @ucfirst($val['O']);

									if($recursion_start_type=='Immediately')

									{

										$recursion_date  = strtotime('+3 month',time());

									}

									elseif($recursion_start_type=='1st of month')

									{

										if($today_date==1)

										{

											$run_cron_job_timestamp = strtotime('+5 minutes',time());

											$recursion_date = strtotime('+3 month',time());

											$sub_transaction_date = date('d-m-Y',time());

											$sub_transaction_timestamp = time();

										}

										else

										{

											$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 1, date('Y'));

											$recursion_date = strtotime('+3 month',$run_cron_job_timestamp);

											$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

											$sub_transaction_timestamp = $run_cron_job_timestamp;

										}

									}

									elseif($recursion_start_type=='15th of month')

									{

										if($today_date==15)

										{

											$run_cron_job_timestamp = strtotime('+5 minutes',time());

											$recursion_date = strtotime('+3 month',time());

											$sub_transaction_date = date('d-m-Y',time());

											$sub_transaction_timestamp = time();

										}

										elseif($today_date<15)

										{

											$run_cron_job_timestamp = mktime(0, 0, 0, date('m'), 15, date('Y'));

											$recursion_date = strtotime('+3 month',$run_cron_job_timestamp);

											$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

											$sub_transaction_timestamp = $run_cron_job_timestamp;

										}

										else

										{

											$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 15, date('Y'));

											$recursion_date = strtotime('+3 month',$run_cron_job_timestamp);

											$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

											$sub_transaction_timestamp = $run_cron_job_timestamp;

										}

									}

									else

									{

										$recursion_date  = strtotime('+3 month',time());

										$recursion_start_type = '';

									}

								}

								else

								{

									$recursion_date  = strtotime('+3 month',time());	

								}

							}

							elseif($period=='yearly')

							{

								$recursion_start_type = @ucfirst($val['O']);

									if($recursion_start_type=='Customdate')

									{
										if(!empty($val['P']))
										{
										$customdate=$val['P'];
										$unix_date = ($customdate - 25569) * 86400;
										$excel_date = 25569 + ($unix_date / 86400);
										$unix_date = ($excel_date - 25569) * 86400;
										$customdate=gmdate("m/d/Y", $unix_date);
										}
										else {
											//in case if custom date is missing then we'll add 5 days 
										$customdate=strtotime('+5 days',date("m/d/Y"));
										}
										if(!empty($val['Q']))
										{
										$custom_logic=$val['Q'];
										}
										else {
											$custom_logic="keeplogic";
										}
										$customdate=strtotime($customdate);
										$run_cron_job_timestamp = $customdate;
										if($custom_logic=="keeplogic")
										{
										$recursion_date  = strtotime('+1 year',time());
										}
										if($custom_logic=="keepcustom")
										{
										$recursion_date  = strtotime('+1 year',$run_cron_job_timestamp);
										}
									}
									else 
									{
										$recursion_date  = strtotime('+1 year',time());
									}

							}

							else

							{

								$is_recursion  = 'No';

								$recursion_date  = '';	

								$is_cancel_recursion = 'N/A';

							}

						}

					}

					if(!empty($firstname))

					{

						$full_name = $firstname." ".$lastname;

					}

					else

					{

						$full_name = $lastname;

					}

					$sub_transaction_data = array(

						'main_transaction_id' => $main_transaction_id,

						'sub_record_type' => 'file',

						'empty_one' => $empty_one,

						'empty_two' => $empty_two,

						'process' => $process,

						'email' => $email,
						
						'firstname' => $firstname,

						'lastname' => $lastname,

						'full_name' => $full_name,

						'country' => "DE",

						'amount' => $amount,

						'user_amount' => $user_amount,

						'empty_three' => $empty_three,

						'customer_id' => $customer_id,

						'payment_subject' => $payment_subject,
						'customdate' => $customdate,
						'custom_logic' => $custom_logic,
				
						'iban' => $iban,

						'bic' => $bic,

						'sub_transaction_date'=> $sub_transaction_date,

						'period' => $period,

						'sub_is_run_cron_job' => "No",

						'add_timestamp' => time(),

						'run_cron_job_timestamp' => $run_cron_job_timestamp,

						'is_recursion' => $is_recursion,

						'recursion_date' => $recursion_date,

						'is_cancel_recursion' => $is_cancel_recursion,

						'recursion_start_type' => $recursion_start_type,

						'sub_transaction_timestamp'=> $sub_transaction_timestamp,

					);

					$this->db->set($sub_transaction_data);

					$this->db->insert('tbl_sub_transactions');

				}

			}

		}

  	}

	public function add_single_transaction()

	{
		$today_date = date("d");

		$recursion_start_type = '';

		$customdate=0;
		$custom_logic="";

		$run_cron_job_timestamp = strtotime('+5 minutes',time());

 		$sub_transaction_date = date('d-m-Y',time());

		$sub_transaction_timestamp = time();

		//main transaction

		$main_transaction_data = array(

			'title' => $this->input->post('payment_subject'),

			'merchant_id' => $this->input->post('merchant_id'),

			'transaction_date' => time(),

			'main_record_type' => 'entry',

			'main_is_run_cron_job' => 'No',

 		);

		$this->db->set($main_transaction_data);

		$this->db->insert('tbl_main_transactions');

		$main_transaction_id = $this->db->insert_id();

		if($main_transaction_id>0)

		{

 			if($this->input->post('period')=='one time')

			{

				$is_recursion  = 'No';

				$recursion_date  = '';

				$is_cancel_recursion = 'N/A';

			}

			else

			{

 				$is_recursion  = 'Yes';

				$recursion_date  = '';

				$is_cancel_recursion = 'No';

				if($this->input->post('period')=='weekly')

				{

					$recursion_date  = strtotime('+1 week',time());

				}

				elseif($this->input->post('period')=='monthly')

				{

					$recursion_start_type = ucfirst($this->input->post('recursion_start_type'));

					if($recursion_start_type=='Immediately')

					{

						$recursion_date  = strtotime('+1 month',time());

					}
					elseif($recursion_start_type=='Customdate')

					{
						$customdate=$this->input->post('customdate');
						if($customdate=="")
						{
						// For security purpose. In case if custom is missed. 
						$customdate=strtotime('+5 days',date("m/d/Y"));
						}

						$custom_logic=$this->input->post('custom_logic');
						$customdate=strtotime($customdate);
						$run_cron_job_timestamp = $customdate;
						if($custom_logic=="keeplogic")
						{
						$recursion_date  = strtotime('+1 month',time());
						}
						if($custom_logic=="keepcustom")
						{
						$recursion_date  = strtotime('+1 month',$run_cron_job_timestamp);
						}
					}

					elseif($recursion_start_type=='1st of month')

					{

						if($today_date==1)

						{

  							$run_cron_job_timestamp = strtotime('+5 minutes',time());

							$recursion_date = strtotime('+1 month',time());

							$sub_transaction_date = date('d-m-Y',time());

							$sub_transaction_timestamp = time();

						}

						else

						{

  							$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 1, date('Y'));

							$recursion_date = strtotime('+1 month',$run_cron_job_timestamp);

							$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

							$sub_transaction_timestamp = $run_cron_job_timestamp;

						}

 					}

					elseif($recursion_start_type=='15th of month')

					{

  						if($today_date==15)

						{

  							$run_cron_job_timestamp = strtotime('+5 minutes',time());

							$recursion_date = strtotime('+1 month',time());

							$sub_transaction_date = date('d-m-Y',time());

							$sub_transaction_timestamp = time();

						}

						elseif($today_date<15)

						{

  							$run_cron_job_timestamp = mktime(0, 0, 0, date('m'), 15, date('Y'));

							$recursion_date = strtotime('+1 month',$run_cron_job_timestamp);

							$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

							$sub_transaction_timestamp = $run_cron_job_timestamp;

						}

						else

						{

  							$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 15, date('Y'));

							$recursion_date = strtotime('+1 month',$run_cron_job_timestamp);

							$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

							$sub_transaction_timestamp = $run_cron_job_timestamp;

						}

 					}

					else

					{

						$recursion_date  = strtotime('+1 month',time());

						$recursion_start_type = '';

					}

				}

				elseif($this->input->post('period')=='quarterly')

				{

 					$recursion_start_type = ucfirst($this->input->post('recursion_start_type'));

					if($recursion_start_type=='Immediately')

					{

						$recursion_date  = strtotime('+3 month',time());

					}

					elseif($recursion_start_type=='1st of month')

					{

						/*if($today_date==1)

						{

  							$run_cron_job_timestamp = strtotime('+5 minutes',time());

							$recursion_date = strtotime('+3 month',time());

							$sub_transaction_date = date('d-m-Y',time());

							$sub_transaction_timestamp = time();

						}

						else

						{

  							$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 1, date('Y'));

							$recursion_date = strtotime('+3 month',$run_cron_job_timestamp);

							$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

							$sub_transaction_timestamp = $run_cron_job_timestamp;

						}*/

						

						$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 1, date('Y'));

						$recursion_date = strtotime('+3 month',$run_cron_job_timestamp);

						$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

						$sub_transaction_timestamp = $run_cron_job_timestamp;

					}

					elseif($recursion_start_type=='15th of month')

					{

						if($today_date==15)

						{

  							/*$run_cron_job_timestamp = strtotime('+5 minutes',time());

							$recursion_date = strtotime('+3 month',time());

							$sub_transaction_date = date('d-m-Y',time());

							$sub_transaction_timestamp = time();*/

							

							$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 15, date('Y'));

							$recursion_date = strtotime('+3 month',$run_cron_job_timestamp);

							$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

							$sub_transaction_timestamp = $run_cron_job_timestamp;

						}

						elseif($today_date<15)

						{

  							$run_cron_job_timestamp = mktime(0, 0, 0, date('m'), 15, date('Y'));

							$recursion_date = strtotime('+3 month',$run_cron_job_timestamp);

							$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

							$sub_transaction_timestamp = $run_cron_job_timestamp;

						}

						else

						{

  							$run_cron_job_timestamp =  mktime(0, 0, 0, date('m')+1, 15, date('Y'));

							$recursion_date = strtotime('+3 month',$run_cron_job_timestamp);

							$sub_transaction_date = date('d-m-Y',$run_cron_job_timestamp);

							$sub_transaction_timestamp = $run_cron_job_timestamp;

						}

					}

					else

					{

						$recursion_date  = strtotime('+3 month',time());

						$recursion_start_type = '';

					}

				}

				elseif($this->input->post('period')=='yearly')

				{
					$recursion_start_type = ucfirst($this->input->post('recursion_start_type'));

					if($recursion_start_type=='Customdate')
					{
						$customdate=$this->input->post('customdate');
						if($customdate=="")
						{
						// For security purpose. In case if custom is missed. 
						$customdate=strtotime('+5 days',date("m/d/Y"));
						}
						$custom_logic=$this->input->post('custom_logic');
						$customdate=strtotime($customdate);
						$run_cron_job_timestamp = $customdate;
						if($custom_logic=="keeplogic")
						{
						$recursion_date  = strtotime('+1 year',time());
						}
						if($custom_logic=="keepcustom")
						{
						$recursion_date  = strtotime('+1 year',$run_cron_job_timestamp);
						}
						
					}
					else {
					$recursion_date  = strtotime('+1 year',time());
					}


				}

				else

				{

					$is_recursion  = 'No';

					$recursion_date  = '';	

					$is_cancel_recursion = 'N/A';

				}

			}

			$user_amount = $this->input->post('amount');

			$amount_symbols = array(",", ".");

			$amount = str_replace($amount_symbols, "", $user_amount);

			if(!empty($this->input->post('firstname')))

			{

				$full_name = $this->input->post('firstname')." ".$this->input->post('lastname');

			}

			else

			{

				$full_name = $this->input->post('firstname');

			}

  			$sub_transaction_data = array(

				'main_transaction_id' => $main_transaction_id,

				'sub_record_type' => 'entry',

				'customer_id' => $this->input->post('customer_id'),

				'firstname' => $this->input->post('firstname'),

				'lastname' => $this->input->post('lastname'),
				'process' => $this->input->post('type'),
				'email' => $this->input->post('email'),
				'full_name' => $full_name,

				'country' => "DE",

				'amount' => $amount,

				'user_amount' => $user_amount,

				'iban' => $this->input->post('iban'),

				'bic' => $this->input->post('bic'),

				'period' => $this->input->post('period'),
				'customdate' => $customdate,
				'custom_logic' => $custom_logic,

				'sub_transaction_date'=> $sub_transaction_date,

				'payment_subject' => $this->input->post('payment_subject'),

				'sub_is_run_cron_job' => "No",

				'add_timestamp' => time(),

				'run_cron_job_timestamp' => $run_cron_job_timestamp,

				'is_recursion' => $is_recursion,

				'recursion_date' => $recursion_date,

				'is_cancel_recursion' => $is_cancel_recursion,

				'recursion_start_type' => $recursion_start_type,

				'sub_transaction_timestamp'=> $sub_transaction_timestamp,

			);

			$this->db->set($sub_transaction_data);

			$this->db->insert('tbl_sub_transactions');

		}

  	}

	public function get_main_transactions_count()

	{

		$this->db->select('main_transaction_id');

		$this->db->from('tbl_main_transactions');

		if(!empty($_POST['payment_subject']))

		{

 			$this->db->like('title',trim($this->input->post('payment_subject')),'both');	

		}

		if(!empty($_POST['main_record_type']))

		{

			$this->db->where("main_record_type", $this->input->post('main_record_type'));	

		}

 		$query = $this->db->get();

  		return $query->num_rows();

	}

	public function get_main_transactions_data($limit,$start)

	{	

 		$this->db->select('*');

		$this->db->from('tbl_main_transactions');

		if(!empty($_POST['payment_subject']))

		{

 			$this->db->like('title',trim($this->input->post('payment_subject')),'both');	

		}

		if(!empty($_POST['main_record_type']))

		{

			$this->db->where("main_record_type", $this->input->post('main_record_type'));	

		}

  		$this->db->order_by('main_transaction_id','desc');

		$this->db->limit($start, $limit);

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->result();

		}

	}

 	public function get_sub_transactions_history_count()

	{

		$this->db->select('sub_transaction_id');

		$this->db->from('tbl_sub_transactions');

 		if(!empty($_POST['full_name']))

		{

 			$this->db->like('full_name',trim($this->input->post('full_name')),'both');	

		}

 		if(!empty($_POST['amount']))

		{

			$this->db->where("amount", $this->input->post('amount'));	

		}

		if(!empty($_POST['sub_record_type']))

		{

			$this->db->where("sub_record_type", $this->input->post('sub_record_type'));	

		}

		if(!empty($_POST['transaction_status']))

		{

			$this->db->where("transaction_status", $this->input->post('transaction_status'));	

		}

 		if(!empty($_POST['is_cancel_recursion']))

		{

			$this->db->where("is_cancel_recursion", $this->input->post('is_cancel_recursion'));	

		}

 		if(!empty($_POST['period']))

		{

			$this->db->where("period", $this->input->post('period'));	

		}

		if(!empty($_POST['customer_id']))

		{

			$this->db->where("customer_id", $this->input->post('customer_id'));	

		}

 		$query = $this->db->get();

  		return $query->num_rows();

	}

	public function get_sub_transactions_history_data($limit,$start)

	{	

 		$this->db->select('*');

		$this->db->from('tbl_sub_transactions');

		if(!empty($_POST['full_name']))

		{

 			$this->db->like('full_name',trim($this->input->post('full_name')),'both');	

		}

 		if(!empty($_POST['amount']))

		{

			$this->db->where("amount", $this->input->post('amount'));	

		}

		if(!empty($_POST['sub_record_type']))

		{

			$this->db->where("sub_record_type", $this->input->post('sub_record_type'));	

		}

		if(!empty($_POST['transaction_status']))

		{

			$this->db->where("transaction_status", $this->input->post('transaction_status'));	

		}

 		if(!empty($_POST['is_cancel_recursion']))

		{

			$this->db->where("is_cancel_recursion", $this->input->post('is_cancel_recursion'));	

		}

 		if(!empty($_POST['period']))

		{

			$this->db->where("period", $this->input->post('period'));	

		}

		if(!empty($_POST['customer_id']))

		{

			$this->db->where("customer_id", $this->input->post('customer_id'));	

		}

  		$this->db->order_by('sub_transaction_timestamp','desc');

		$this->db->limit($start, $limit);

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->result();

		}

	}

	public function get_sub_transactions_count($main_transaction_id)

	{

 		$this->db->select('sub_transaction_id');

		$this->db->from('tbl_sub_transactions');

		$this->db->where("main_transaction_id", $main_transaction_id);

 		$query = $this->db->get();

  		return $query->num_rows();

	}

	public function get_sub_transactions_data($limit,$start,$main_transaction_id)

	{	

 		$this->db->select('*');

		$this->db->from('tbl_sub_transactions');

		$this->db->where("main_transaction_id", $main_transaction_id);

  		$this->db->order_by('sub_transaction_id','asc');

		$this->db->limit($start, $limit);

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->result();

		}

	}

 	public function get_main_transaction_row($main_transaction_id)

	{	

 		$this->db->select('*');

		$this->db->from('tbl_main_transactions');

 		$this->db->where("main_transaction_id", $main_transaction_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->row();

		}

	}

	public function get_sub_transaction_row($sub_transaction_id)

	{	

 		$this->db->select('*');

		$this->db->from('tbl_sub_transactions');

 		$this->db->where("sub_transaction_id", $sub_transaction_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->row();

		}

	}

	public function update_cancel_recursion($sub_transaction_id)

	{

		$this->db->set('is_cancel_recursion','Yes');

		$this->db->where('sub_transaction_id',$sub_transaction_id);

		$this->db->update('tbl_sub_transactions');	

 	}

	public function get_transaction_statistics()

	{

		$this->db->select("COUNT(case when sub_transaction_id>0 then 1 end) as total_transactions, COUNT(case when transaction_status='pending' then 1 end) as total_pending, count(case when transaction_status='approved' then 1 end) as total_approved,count(case when transaction_status='failed' then 1 end) as total_failed");

		$this->db->from('tbl_sub_transactions');

 		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->row();

		}

	}

	public function get_cvs_transactions_export_list($main_transaction_id)

	{

 		$this->db->select('s.empty_one, s.empty_two, s.process, p.txid, s.firstname, s.lastname, s.user_amount, s.sub_transaction_date, s.empty_three, s.payment_subject, s.customer_id, s.iban, s.bic, s.period, s.transaction_status, s.recursion_start_type');

		$this->db->from('tbl_sub_transactions as s');

		$this->db->where("s.main_transaction_id", $main_transaction_id);

		$this->db->join('tbl_payments as p', 's.sub_transaction_id=p.sub_transaction_id','left');

		$this->db->order_by('s.sub_transaction_id','desc');

		$this->db->limit(1000, 0);

 		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->result_array();

		}

	}

	public function get_cvs_sub_transactions_export_list()

	{

 		$this->db->select('s.sub_transaction_id, s.empty_one, s.empty_two, s.process, s.firstname, s.lastname, s.user_amount, s.sub_transaction_date, s.empty_three, s.payment_subject, s.customer_id, s.iban, s.bic, s.period, s.customdate ,s.custom_logic,  s.transaction_status, s.recursion_start_type  ');

		$this->db->from('tbl_sub_transactions as s');

 		//$this->db->join('tbl_payments as p', 's.sub_transaction_id=p.sub_transaction_id','left');

		$this->db->order_by('s.sub_transaction_id','desc');

		$this->db->limit(1000, 0);

 		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			  return $query->result_array();
			 // echo $this->db->last_query();
			 // 	print_r($data); exit();

		}

	}

	public function count_approved_sub_transactions($main_transaction_id)

	{

 		$this->db->select('sub_transaction_id');

		$this->db->from('tbl_sub_transactions');

		$this->db->where("main_transaction_id", $main_transaction_id);

		$this->db->where("transaction_status", 'approved');

  		$query = $this->db->get();

  		return $query->num_rows();

	}

	public function count_total_approved_sub_transactions()

	{

 		$this->db->select('sub_transaction_id');

		$this->db->from('tbl_sub_transactions');

 		$this->db->where("transaction_status", 'approved');

  		$query = $this->db->get();

  		return $query->num_rows();

	}

	public function count_processed_sub_transactions($main_transaction_id)

	{

		$processed_status = array('approved', 'failed');

 		$this->db->select('sub_transaction_id');

		$this->db->from('tbl_sub_transactions');

		$this->db->where("main_transaction_id", $main_transaction_id);

		$this->db->where_in("transaction_status", $processed_status);

  		$query = $this->db->get();

  		return $query->num_rows();

	}

	public function delete_main_transaction_record($main_transaction_id)

	{

		$this->db->where('main_transaction_id',$main_transaction_id);

		$this->db->delete('tbl_main_transactions');

		

		$this->db->where('main_transaction_id',$main_transaction_id);

		$this->db->delete('tbl_sub_transactions');

	}

 	/*======================Cron=============================*/

	public function get_cron_sub_transactions($limit,$start)

	{	

  		$this->db->select('*');

		$this->db->from('tbl_sub_transactions');

		$this->db->where("transaction_status", 'pending');

		$this->db->where("sub_is_run_cron_job", 'No');

		$this->db->where("run_cron_job_timestamp<=", time());

   		$this->db->order_by('sub_transaction_id','asc');

		$this->db->limit($start, $limit);

		$query = $this->db->get();

		if($query->num_rows()>0)

		{

			return $query->result();

		}

	}

 	public function get_cron_main_merchant_row($main_transaction_id)

	{	

 		$this->db->select('m.merchant_id, m.merchant_name, m.aid, m.mid, m.portalid, m.md5_key, m.merchant_status');

  		$this->db->where("t.main_transaction_id",$main_transaction_id);

		$this->db->from('tbl_merchants as m');

		$this->db->join('tbl_main_transactions as t', 'm.mid=t.merchant_id','inner');

		$query = $this->db->get();

 		if($query->num_rows() > 0)

		{

			return $query->row();

		}

	}

	public function get_cron_ecursive_transactions($limit,$start)

	{	

		$period_options = array('weekly','monthly','quarterly','yearly');

  		$this->db->select('*');

		$this->db->from('tbl_sub_transactions');

 		$this->db->where("is_recursion", 'Yes');

		$this->db->where("is_cancel_recursion", 'No');

		$this->db->where_in("period", $period_options);

		$this->db->where("recursion_date<=", time());

   		$this->db->order_by('sub_transaction_id','asc');

		$this->db->limit($start, $limit);

		$query = $this->db->get();

		if($query->num_rows()>0)

		{

			return $query->result();

		}

	}

	/*======================Merchants=============================*/

	public function add_merchant()

	{

		$add_data = array(

			'merchant_name' => $this->input->post('merchant_name'),

			'aid' => $this->input->post('aid'),

			'mid' => $this->input->post('mid'),

			'md5_key' => $this->input->post('md5_key'),

			'portalid' => $this->input->post('portalid'),

			'merchant_status' => 'active',

		);

		$this->db->set($add_data);

		$this->db->insert('tbl_merchants');	

	}

	public function update_merchant()

	{

		$update_id = base64_decode($this->input->post('update_id'));

		$update_data = array(

			'merchant_name' => $this->input->post('merchant_name'),

			'aid' => $this->input->post('aid'),

			'mid' => $this->input->post('mid'),

			'md5_key' => $this->input->post('md5_key'),

			'portalid' => $this->input->post('portalid'),

			'merchant_status' => 'active',

		);

		$this->db->set($update_data);

		$this->db->where('mid',$update_id);

		$this->db->update('tbl_merchants');	

	}

	public function get_merchants_list()

	{	

 		$this->db->select('*');

		$this->db->from('tbl_merchants');

  		$this->db->order_by('mid','desc');

		$this->db->where("merchant_status", "active");

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->result();

		}

	}

	public function get_merchants_count()

	{

		$this->db->select('merchant_id');

		$this->db->from('tbl_merchants');

 		$query = $this->db->get();

  		return $query->num_rows();

	}

	public function get_merchants_data($limit,$start)

	{	

 		$this->db->select('*');

		$this->db->from('tbl_merchants');

  		$this->db->order_by('merchant_id','desc');

		$this->db->limit($start, $limit);

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->result();

		}

	}

	

	public function get_merchant_row($merchant_id,$merchant_status)

	{	

 		$this->db->select('*');

		$this->db->from('tbl_merchants');

 		$this->db->where("merchant_id", $merchant_id);

		if($merchant_status!='all')

		{

			$this->db->where("merchant_status", $merchant_status);

		}

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->row();

		}

	}

	public function check_merchant_mid($mid,$merchant_status,$update_id)

	{	

 		$this->db->select('merchant_id');

		$this->db->from('tbl_merchants');

 		$this->db->where("mid", $mid);

		if($merchant_status!='all')

		{

			$this->db->where("merchant_status", $merchant_status);

		}

		if($update_id>0)

		{

			$this->db->where("mid!='".$update_id."'");

		}

		$query = $this->db->get();

 		return $query->num_rows();

	}

	

	/*======================Payment Mode=============================*/

	public function get_payment_mode()

	{

		$this->db->select('payment_mode');

		$this->db->from('tbl_setting');

 		$this->db->where("setting_id", 1);

		$query = $this->db->get();

		if($query->num_rows() > 0)

		{

			return $query->row()->payment_mode;

		}

 	}

	public function save_payment_mode()

	{

		$this->db->truncate('tbl_setting');

 		$this->db->set('payment_mode',$this->input->post('payment_mode'));

		$this->db->insert('tbl_setting');	

	}

	public function update_sub_transaction()

	{

		$sub_transaction_id = base64_decode($this->input->post('update_id'));

		$row = $this->get_sub_transaction_row($sub_transaction_id);

		if(!empty($row))

		{

			$total_update = $row->total_update+1;

			$actual_amount = $row->amount;

			$update_data = array(

				'amount' => $this->input->post('amount'),

				'user_amount' => $this->input->post('amount'),

				'customer_id' => $this->input->post('c_id'),

				'payment_subject' => $this->input->post('payment_subject'),

				'actual_amount' => $actual_amount,

				'update_user_id' => $this->session->userdata('payone_user_id'),

				'update_date_timestamp' => time(),

				'total_update' => $total_update,

			);

			$this->db->set($update_data);

			$this->db->where('sub_transaction_id',$sub_transaction_id);

			$this->db->update('tbl_sub_transactions');

		}

	}

	public function check_sub_transaction($sub_transaction_id)

	{	

 		$this->db->select('sub_transaction_id');

		$this->db->from('tbl_sub_transactions');

 		$this->db->where("sub_transaction_id", $sub_transaction_id);

		$query = $this->db->get();

		return $query->num_rows(); 

	}

}

?>