<?php
       ini_set('display_errors', '1');
	   ini_set('display_startup_errors', '1');
	   error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');
use Stripe\Stripe;
require 'vendor/autoload.php';
class Transactions extends MY_Controller 

{

	public function __construct()

	{

		parent::__construct();

		$this->load->model("Transactions_m","transactions");
 
   	}

 	public function index()

	{

 		$header_data = array('page_title' => 'Transactions');

 		load_main_template('transactions_v', $header_data,'');

 	}


	public function updatepayment($id){


		$transaction_status = 'approved';

		if(isset($_POST['updatestripepayment'])){
			$transaction_status = $_POST['updatestripepayment'];
		}

		$sub_transaction_data = array(
			'transaction_status' => $transaction_status,
			'sub_is_run_cron_job' => 'Yes',
			'sub_transaction_date'=> date('d-m-Y',time()),
			'sub_transaction_timestamp'=> time(),
			'response_message' => $this->input->post('jsondata')
		   );
		$this->db->set($sub_transaction_data);
		$this->db->where('sub_transaction_id', $id);
		$this->db->update('tbl_sub_transactions');

		$SQL='SELECT * FROM `tbl_sub_transactions` WHERE sub_transaction_id = '. $id.' ';    
		$query = $this->db->query($SQL);
		 $sub =  $query->result_array();
		  $main_transaction_id=  $sub[0]['main_transaction_id'];
		  $sub_transaction_id = $id;
		$status = '';
		$txid = '';
		$userid = '';
		$mandate_identification = '';
		$mandate_dateofsignature = '';
		$creditor_identifier = '';
		$creditor_name = '';
		$creditor_street = '';
		$creditor_zip = '';
		$creditor_city = '';
		$creditor_country = '';
		$creditor_email = '';
		$clearing_date = '';
		$clearing_amount = '';
		$response = json_decode($this->input->post('jsondata'));





		 if(!empty($response->status))
		{
			$status = $response->status;
		}
		if(!empty($response->id))
		{
			$txid = $response->id;
		}
	
		 //payment table
		$payment_data = array(
			'main_transaction_id' => $main_transaction_id,
			'sub_transaction_id' => $sub_transaction_id,
			'status' =>$status,
			'txid' => $txid ,
			'userid' => '',
			'mandate_identification' => $response->client_secret,
			 'mandate_dateofsignature' => $response->payment_method,
			'creditor_identifier' => $response->payment_method,
			'creditor_name' =>  $sub[0]['full_name'],
			'creditor_street' => '',
			'creditor_zip' => "",
			 'creditor_city' => "",
			'creditor_country' => "",
			 'creditor_email' => ($response->email)?$response->email:'',
			'clearing_date' =>'',
			'clearing_amount' => $response->amount,
		  );
		$this->db->set($payment_data);
		$this->db->insert('tbl_payments');	


	}

	public function config(){
		$pub_key = $this->config->item('stripepublickey');
		$amount = '300';
		$currency = 'EUR';

		echo json_encode([ 
			'publicKey' => $pub_key, 
			'amount' => $amount, 
			'currency' => $currency 
		  ]);
	}

	public function create_payment_intent(){

		Stripe::setApiKey($this->config->item('stripeseckey'));
		$pub_key =$this->config->item('stripepublickey');
		$body = json_decode(file_get_contents('php://input'),true);
		// print_r($body['items'][0]['description']);
	
		// Create a PaymentIntent with the order amount and currency
		$payment_intent = \Stripe\PaymentIntent::create([
		  'payment_method_types' => ['sepa_debit'],
		  'amount' => $body['items'][0]['price'],
		  'currency' => 'EUR',
		  'description' => $body['items'][0]['description'],
		  'statement_descriptor' => $body['items'][0]['description']
		]);
		
	
	
		echo json_encode([ 'publicKey' => $pub_key, 'clientSecret' => $payment_intent->client_secret]);
	 
		// Send publishable key and PaymentIntent details to client
		
	}

	public function stripepay($id){
		$data['id'] = $id;

		$SQL='SELECT * FROM `tbl_sub_transactions` WHERE  sub_transaction_id='.$id.' ';    
		$query = $this->db->query($SQL);
		$data['trans'] = $query->result_array();


		// echo "<pre>";
		// print_r($data['gettodaytrans']);
		// exit();

		$header_data = array('page_title' => 'Make Stripe Transactions');
		load_main_template('stripetransactionspay_v', $header_data,$data);
	}
	public function maketrans($days = 1){
	

		
		$data['gettodaytrans'] = $this->transactions->gettodaytrans((int)$days);
//    echo count($data['gettodaytrans']);
// 		echo "<pre>";
// 		print_r($data['gettodaytrans']);
// 		exit();
		$data['days'] = $days;
		$header_data = array('page_title' => 'Make Stripe Transactions');
		load_main_template('stripetransactions_v', $header_data,$data);
	}

	public function TransactionsHistory()

	{

		$header_data = array('page_title' => 'Transactions History');

		load_main_template('sub_transactions_history_list_v', $header_data,'');

	}

	public function AddSingleTransaction()

	{

		$data['merchant_list'] = $this->transactions->get_merchants_list();

 		$header_data = array('page_title' => 'Single Transaction');

		load_main_template('add_single_transaction_v', $header_data,$data);

	}

	public function AddTransaction()

	{

		$data['merchant_list'] = $this->transactions->get_merchants_list();

		$header_data = array('page_title' => 'Add Transaction');

		load_main_template('add_transaction_v', $header_data, $data);

	}

	public function ViewTransaction()

	{

   		$header_data = array('page_title' => 'View Transaction');

		$data['error_message'] = '';

		if(!empty($_GET['key_id']))

		{

  			$main_transaction_id = base64_decode($this->input->get('key_id', TRUE));

			if($main_transaction_id>0)

			{

  				$data['main_row'] = $this->transactions->get_main_transaction_row($main_transaction_id);

				if(empty($data['main_row']))

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

  		load_main_template('view_transaction_v', $header_data,$data);

	}

  	public function load_ajax_transactions_list()

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

			$total_records = $this->transactions->get_main_transactions_count();

			$data['total_pages'] = ceil($total_records/$perPage);

			$data['start'] = ceil(($data['page_number']-1) * $perPage);

  			$data['results'] = $this->transactions->get_main_transactions_data($data['start'],$perPage);

 		}

		else

		{

			$data['error_message'] = 'No Record Found!';

		}

 		$this->load->view("Ajaxviews/load_ajax_transactions_v",$data);

	}

	public function load_ajax_sub_transactions_history_list()

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

			$total_records = $this->transactions->get_sub_transactions_history_count();

			$data['total_pages'] = ceil($total_records/$perPage);

			$data['start'] = ceil(($data['page_number']-1) * $perPage);

  			$data['results'] = $this->transactions->get_sub_transactions_history_data($data['start'],$perPage);

 		}

		else

		{

			$data['error_message'] = 'No Record Found!';

		}

 		$this->load->view("Ajaxviews/load_ajax_sub_transactions_history_list_v",$data);

	}

	

	public function load_ajax_sub_transactions_list()

	{

		$data = array();

		$data['page_number'] = 0;

		$main_transaction_id = 0;

 		$data['error_message'] = '';

 		if(!empty($_POST['main_id']))

		{

			$data['get_main_transaction_id'] = $_POST['main_id'];

			$main_transaction_id = base64_decode($_POST['main_id']);

		}

		if(!empty($_POST['page_number']))

		{

			$data['page_number'] = $_POST['page_number'];

		}

		if($data['page_number']>0)

		{

			$perPage = 30;

			$total_records = $this->transactions->get_sub_transactions_count($main_transaction_id);

			$data['total_pages'] = ceil($total_records/$perPage);

			$data['start'] = ceil(($data['page_number']-1) * $perPage);

   			$data['sub_transactions'] = $this->transactions->get_sub_transactions_data($data['start'],$perPage,$main_transaction_id);

 		}

		else

		{

			$data['error_message'] = 'No Record Found!';

		}

 		$this->load->view("Ajaxviews/load_ajax_sub_transactions_v",$data);

	}

	public function Download_main_file()

	{

 		$error = '';

		$this->load->helper('download');

		$this->load->helper('file');

 		if(!empty($this->session->userdata('payone_user_id')))

		{

			if(!empty($_GET['key_id']))

			{

				$main_transaction_id = base64_decode($this->input->get('key_id', TRUE));

 				$main_row = $this->transactions->get_main_transaction_row($main_transaction_id); 

 				if(!empty($main_row))

				{

					if($main_row->main_transaction_id>0 && $main_row->main_record_type=='file')

					{

						$target_file_path = FCPATH."uploads/ImportedFile/".$main_row->uploaded_file_name;

						force_download($target_file_path, NULL); 

 					}

					else

					{

						$error = 1;	

					}

				}

				else

				{

					$error = 1;	

				}

			}

			else

			{

				$error = 1;	

			}

			if(!empty($error))

			{

				echo "<div class='col-md-12 mb-20'><span class='dx-ticket-item dx-block-decorated text-danger'>We are sorry, the link you are trying to access is not available!</span></div>";

			}

		}

		else

		{

			echo "<div class='col-md-12 mb-20'><span class='dx-ticket-item dx-block-decorated text-danger'>Please login to continue!</span></div>";

		}

 	}

	// Export data in CSV format

	public function ExportTransactions()

	{

		$flag_error = 1;

   		if(!empty($_GET['key_id']))

		{

			$main_transaction_id = base64_decode($this->input->get('key_id', TRUE));

			if($main_transaction_id>0)

			{

				// get data

				$trans_arr = $this->transactions->get_cvs_transactions_export_list($main_transaction_id);

				if(!empty($trans_arr))

				{

					$flag_error = 2;

					// file name

					$filename = 'transaction_'.time().'.csv';

					header("Content-Description: File Transfer");

					header("Content-Disposition: attachment; filename=$filename");

					header("Content-Type: application/csv; "); 

					

					

					// file creation

					$file = fopen('php://output', 'w');

					foreach($trans_arr as $key => $value)

					{

						fputcsv($file,$value);

					}

					fclose($file);

					exit;

				}

 			}

		}

		

		

		if($flag_error==1)

		{

			$header_data = array('page_title' => 'Export Transactions');

			load_main_template('export_transactions_v', $header_data,'');

		}

		

		

	}

	public function ExportSubTransactions()

	{

		$flag_error = 1;

   		// get data

		$trans_arr = $this->transactions->get_cvs_sub_transactions_export_list();
		//	print_r($trans_arr); exit();

		if(!empty($trans_arr))

		{

			$flag_error = 2;

			// file name

			$filename = 'transaction_'.time().'.csv';

			header("Content-Description: File Transfer");

			header("Content-Disposition: attachment; filename=$filename");

			header("Content-Type: application/csv; "); 

			

 			// file creation

			$file = fopen('php://output', 'w');

			foreach($trans_arr as $key => $value)

			{
                $this->db->select('p.txid');

        		$this->db->from('tbl_payments as p');
        
         		$this->db->where('p.sub_transaction_id', $value['sub_transaction_id'] );
        
        		$this->db->limit(1, 0);
        
         		$query = $this->db->get();
         		if($query->num_rows() > 0)

            		{
            
            			  $data =  $query->result_array();
            			  $inserted = array('txid'=> $data[0]['txid']);
            			
            
            		}
            	array_splice( $value, 3, 0, $inserted ); // splice in at position 3
            	
            	//$value['txid'] = $data[0]['txid'];
            	unset($value['sub_transaction_id']);
				fputcsv($file,$value);

			}

			fclose($file);

			exit;

		}

 		

		if($flag_error==1)

		{

			$header_data = array('page_title' => 'Export Transactions');

			load_main_template('export_sub_transactions_v', $header_data,'');

		}

	}

	function load_recursion_start_type()

	{

		if(!empty($_POST['type']))

		{

  			$type = $this->input->post('type', TRUE);

			if($type=='yearly')
			{
			?>
			<div class="form-group row">
			<label class="col-md-2">Start of payment <span class="text-danger">*</span></label> 
				<div class="col-md-10">
					<select name="recursion_start_type" onchange="load_customdate(this.value)" id="yearly_custom" class="form-control select2">
					<option value="">Immediately</option>
					<option value="customdate">Custom Date</option>
					</select>
				</div>
			</div>
			
			<?php
			}

			if($type=='monthly' || $type=='quarterly')

			{

			?>

            	<div class="form-group row">

                    <label class="col-md-2">Start of payment <span class="text-danger">*</span></label> 

                    <div class="col-md-10">

                        <select name="recursion_start_type" onchange="load_customdate(this.value)" id="recursion_start_type" class="form-control select2">

                            <option value="">Please select start of payment</option>

                            <option value="Immediately">Immediately</option>
							<?php 
							if($type=='monthly')
							{
							?>
                            <option value="customdate">Custom Date</option>
							<?php  } ?>

                            <option value="1st of month">1st of month</option>

                             <option value="15th of month">15th of month</option>

                          </select>

                     </div>

                </div>

                <script>$('#recursion_start_type').select2();</script>

            <?php	

			}


		}

	}

	public function load_custom_date()
	{

		if(!empty($_POST['type']))

		{

  			$type = $this->input->post('type', TRUE);

			if($type=='customdate')

			{

			?>

            	<div class="form-group row">

                    <label class="col-md-2">Custom Date <span class="text-danger">*</span></label> 

                    <div class="col-md-4">

						<div class="input-group date" data-provide="datepicker">
							<input id="customdate" type="text" name="customdate" class="form-control">
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
                    </div>
					<div class="col-md-3">
						<select name="custom_logic" id="custom_logic" class="form-control select2">
							<option value="keeplogic">Keep Logic</option>
							<option value="keepcustom">Keep Custom Logic</option>
						</select>
					</div>

                </div>

                <script>$('.datepicker').datepicker();</script>

            <?php	

			}


		}

	}


	public function Update()

	{

		$data['error_message'] = '';

		if(!empty($_GET['key_id']))

		{

  			$sub_transaction_id = base64_decode($this->input->get('key_id', TRUE));

			if($sub_transaction_id>0)

			{

  				$data['row'] = $this->transactions->get_sub_transaction_row($sub_transaction_id);

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

  		$this->load->view('update_transaction_v',$data);

	}

}

