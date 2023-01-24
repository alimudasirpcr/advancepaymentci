<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Stripe\Stripe;
require 'vendor/autoload.php';
class Cron extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Transactions_m","transactions");
   	}

	   public function webhook(){


		// Parse the message body (and check the signature if possible)
		$webhookSecret =  $this->config->item('stripewebhookkey');
		$request = json_decode(file_get_contents('php://input'),true);
	    // log_message('debug' ,json_encode($request),false);
		log_message('debug', "reqeust obj: ".json_encode($request), false);

		
		if(isset($_SERVER['HTTP_STRIPE_SIGNATURE'])){
			$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
		}else{
                echo 'variable not found';
				exit();
		}
		
		
		if(isset($request['data']['object']['status'])){
	

			$transaction_status = ($request['data']['object']['status']=='succeeded')?'Approved':'pending';
	
			$SQL='SELECT * FROM `tbl_payments` WHERE txid = "'. $request['data']['object']['id'].'" ';    
			$query = $this->db->query($SQL);
			 $pay =  $query->result_array();
			 if(count($pay)>0){
				$id=  $pay[0]['sub_transaction_id'];
				$sub_transaction_data = array(
					'transaction_status' => $transaction_status,
					'sub_is_run_cron_job' => 'Yes',
					'sub_transaction_date'=> date('d-m-Y',time()),
					'sub_transaction_timestamp'=> time(),
					'response_message' => json_encode($request)
				   );
				$this->db->set($sub_transaction_data);
				$this->db->where('sub_transaction_id', $id);
				$this->db->update('tbl_sub_transactions');
	
	
			 }
		}
		
		  

		  

		

	


		$event = null;
		  try {
			$event = \Stripe\Webhook::constructEvent(
				$request
			,$sig_header
			 ,
			  $webhookSecret
			);


		  } catch (\Exception $e) {
			return $e->getMessage();
			log_message('debug', 'fail webhook:'.$e->getMessage(), false);
		  }
		//   $event  =  json_encode($event);
		// $type = $event['type'];
		// $object = $event['data']['object'];
		// log_message('debug', 'succes webhook event:'.$event, false);
		// if ($type == 'payment_intent.succeeded') {
		//   // Fulfill any orders, e-mail receipts, etc
		//   // To cancel the payment you will need to issue a Refund (https://stripe.com/docs/api/refunds)
		//   dd('💰 Payment received! ');
		// } else if ($type == 'payment_intent.payment_failed') {
		//   dd('❌ Payment failed.');
		// }
	
		// echo $success


	}


 	public function index()
	{
		
   		$this->load->library('BSPayone');
		$sub_transactions = $this->transactions->get_cron_sub_transactions(0,10);
		if(!empty($sub_transactions))
		{
			foreach($sub_transactions as $val)
			{
				 $sub_transaction_id = $val->sub_transaction_id; 
				 $main_transaction_id = $val->main_transaction_id; 
				 $customer_id = $val->customer_id;  
				 $firstname = $val->firstname;  
				 $lastname = $val->lastname;  
				 $country = $val->country;  
				 $amount = $val->amount;  
				 $iban = $val->iban;  
				 $bic = $val->bic;
				 $payment_subject = $val->payment_subject; 
				 $transaction_status = $val->transaction_status;  
				 $response_message = $val->response_message; 
				 if(!empty($payment_subject))
				 {
					 $payment_subject = substr($payment_subject,0,26);
				 }
				 if($transaction_status=='pending')
				 {
 					$merchant_row = $this->transactions->get_cron_main_merchant_row($main_transaction_id);
					if(!empty($merchant_row))
					{
						$merchant_id = $merchant_row->merchant_id; 
						$merchant_name = $merchant_row->merchant_name; 
						$aid = $merchant_row->aid;  
						$mid = $merchant_row->mid;  
						$portalid = $merchant_row->portalid;  
						$md5_key = $merchant_row->md5_key; 
						$merchant_status = $merchant_row->merchant_status; 
						
						$payment_mode = $this->transactions->get_payment_mode();
						if(empty($payment_mode))
						{
							$payment_mode = 'test';
						}
						$defaults = array(
							"aid" => $aid, //not actually a standard parameter, but needed in most requests
							"mid" => $mid,
							"portalid" => $portalid,
							"key" => hash("md5", $md5_key), // the key has to be hashed as md5
							"api_version" => "3.10",
							"mode" => $payment_mode, // can be "live" for actual transactions
							"encoding" => "UTF-8"
						);
 						$personalData = array(
							"firstname" => $firstname,
 							"lastname" => $lastname, // mandatory
 							"country" => $country, // mandatory
							"customerid" => $customer_id,
							"narrative_text" => $payment_subject,
 							"language" => "en",
						);
 						$parameters = array(
							"clearingtype" => "elv", // sb means online bank transfer
							"reference" => $sub_transaction_id.uniqid(),
							"amount" => $amount, // amount in smallest currency unit, i.e. cents
							"currency" => "EUR",
							"request" => "authorization", // create account receivable and instantly book the amount
							"onlinebanktransfertype" => "PNT", // this is the type for Sofort.com
							"bankcountry" => "DE", // we need to know the country of the customer's bank, i.e. of the invoice address
							/**
							* As of July 2016, IBAN and BIC are optional for Sofort transactions as long as we get a bankcountry
							*/
							"iban" => $iban,
							//"bic" => $bic,
							"successurl" => "http://www.aktiver-deutscher-sicherheitsdienst.de/success?reference=your_unique_reference",
							"errorurl" => "http://www.aktiver-deutscher-sicherheitsdienst.de/error?reference=your_unique_reference",
							"backurl" => "http://www.aktiver-deutscher-sicherheitsdienst.de/back?reference=your_unique_reference",
						);
						$request = array_merge($defaults, $personalData, $parameters);
						
 						$response = Payone::sendRequest($request);
 						if(!empty($response))
						{
 							if(!empty($response['status']))
							{
								if($response['status']=='APPROVED')
								{
 									//update sub transactons
									$sub_transaction_data = array(
										'transaction_status' => 'approved',
										'sub_is_run_cron_job' => 'Yes',
										'sub_transaction_date'=> date('d-m-Y',time()),
										'sub_transaction_timestamp'=> time(),
   									);
									$this->db->set($sub_transaction_data);
									$this->db->where('sub_transaction_id', $sub_transaction_id);
									$this->db->update('tbl_sub_transactions');
									
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
									
 									if(!empty($response['status']))
									{
										$status = $response['status'];
									}
									if(!empty($response['txid']))
									{
										$txid = $response['txid'];
									}
									if(!empty($response['userid']))
									{
										$userid = $response['userid'];
									}
									if(!empty($response['mandate_identification']))
									{
										$mandate_identification = $response['mandate_identification'];
									}
									if(!empty($response['mandate_dateofsignature']))
									{
										$mandate_dateofsignature = $response['mandate_dateofsignature'];
									}
									if(!empty($response['creditor_identifier']))
									{
										$creditor_identifier = $response['creditor_identifier'];
									}
									if(!empty($response['creditor_name']))
									{
										$creditor_name = $response['creditor_name'];
									}
									if(!empty($response['creditor_street']))
									{
										$creditor_street = $response['creditor_street'];
									}
									if(!empty($response['creditor_zip']))
									{
										$creditor_zip = $response['creditor_zip'];
									}
									if(!empty($response['creditor_city']))
									{
										$creditor_city = $response['creditor_city'];
									}
									if(!empty($response['creditor_country']))
									{
										$creditor_country = $response['creditor_country'];
									}
									if(!empty($response['creditor_email']))
									{
										$creditor_email = $response['creditor_email'];
									}
									if(!empty($response['clearing_date']))
									{
										$clearing_date =$response['clearing_date'];
									}
									if(!empty($response['clearing_amount']))
									{
										$clearing_amount = $response['clearing_amount'];
									}
 									//payment table
									$payment_data = array(
										'main_transaction_id' => $main_transaction_id,
										'sub_transaction_id' => $sub_transaction_id,
										'status' => $response['status'],
										'txid' => $response['txid'],
										'userid' => $response['userid'],
										'mandate_identification' => $mandate_identification,
 										'mandate_dateofsignature' => $mandate_dateofsignature,
										'creditor_identifier' => $creditor_identifier,
										'creditor_name' => $creditor_name,
										'creditor_street' => $creditor_street,
										'creditor_zip' => $creditor_zip,
 										'creditor_city' => $creditor_city,
										'creditor_country' => $creditor_country,
 										'creditor_email' => $creditor_email,
										'clearing_date' =>$clearing_date,
										'clearing_amount' => $clearing_amount,
  									);
									$this->db->set($payment_data);
									$this->db->insert('tbl_payments');	
								}
								elseif($response['status']=='ERROR')
								{
									$custom_message = '';
									if(!empty($response['errorcode']))
									{
										$custom_message .= 'Error Code = '.$response['errorcode'].'.<br>';
									}
									if(!empty($response['errormessage']))
									{
										$custom_message .= 'Error Message = '.$response['errormessage'].'.<br>';
									}
									
									if(!empty($response['customermessage']))
									{
										$custom_message .= $response['customermessage'];
									}
									$response_data = array(
										'transaction_status' => 'failed',
										'response_message' => $custom_message,
										'sub_transaction_date'=> date('d-m-Y',time()),
										'sub_transaction_timestamp'=> time(),
									);
									$this->db->set($response_data);
									$this->db->where('sub_transaction_id', $sub_transaction_id);
									$this->db->update('tbl_sub_transactions');
								}
								else
								{
									$response_data = array(
										'transaction_status' => 'failed',
										'response_message' => 'The api give no response',
										'sub_transaction_date'=> date('d-m-Y',time()),
										'sub_transaction_timestamp'=> time(),
									);
									$this->db->set($response_data);
									$this->db->where('sub_transaction_id', $sub_transaction_id);
									$this->db->update('tbl_sub_transactions');
								}
							}
							else
							{
								$response_data = array(
									'transaction_status' => 'failed',
									'response_message' => 'The api give no response',
									'sub_transaction_date'=> date('d-m-Y',time()),
									'sub_transaction_timestamp'=> time(),
								);
								$this->db->set($response_data);
								$this->db->where('sub_transaction_id', $sub_transaction_id);
								$this->db->update('tbl_sub_transactions');
							}
						}
						else
						{
							$response_data = array(
								'transaction_status' => 'failed',
								'response_message' => 'The api give no response',
								'sub_transaction_date'=> date('d-m-Y',time()),
								'sub_transaction_timestamp'=> time(),
							);
							$this->db->set($response_data);
							$this->db->where('sub_transaction_id', $sub_transaction_id);
							$this->db->update('tbl_sub_transactions');
						}
						
						//update main transaction cron job
 						$this->db->set('main_is_run_cron_job','Yes');
						$this->db->where('main_transaction_id', $main_transaction_id);
						$this->db->update('tbl_main_transactions');
 					}
 					sleep(3);
 				 }
			}
		}
	}
	public function InsertRecursiveTransactions()
	{
  		$records_arr = $this->transactions->get_cron_ecursive_transactions(0,50);
		if(!empty($records_arr))
		{
			foreach($records_arr as $val)
			{
 				//insert New recod
				$add_sub_transaction_data = array(
					'main_transaction_id' => $val->main_transaction_id,
					'sub_record_type' => $val->sub_record_type,
					'empty_one' => $val->empty_one,
					'empty_two' => $val->empty_two,
					'process' => $val->process,
 					'firstname' => $val->firstname,
					'lastname' => $val->lastname,
					'full_name' => $val->full_name,
					'country' => $val->country,
					'amount' => $val->amount,
					'user_amount' => $val->user_amount,
					'empty_three' => $val->empty_three,
					'customer_id' => $val->customer_id,
					'payment_subject' => $val->payment_subject,
					'iban' => $val->iban,
					'bic' => $val->bic,
 					'sub_transaction_date'=> date('d-m-Y',time()),
					 'customdate' => $val->customdate,
					 'custom_logic' => $val->custom_logic,
 					'sub_is_run_cron_job' => "No",
					'add_timestamp' => time(),
					'run_cron_job_timestamp' => time(),
					'is_recursion' => 'No',
					'recursion_date' => 0,
					'is_cancel_recursion' => 'N/A',
					'recursion_start_type' => '',
					'sub_transaction_timestamp'=> time(),
				);
				$this->db->set($add_sub_transaction_data);
				$this->db->insert('tbl_sub_transactions');
				
				if($val->period=='weekly')
				{
					$recursion_date  = strtotime('+1 week',time());
				}
				elseif($val->period=='monthly')
				{
					$recursion_date  = strtotime('+1 month',time());
				}
				elseif($val->period=='quarterly')
				{
					$recursion_date  = strtotime('+3 month',time());
				}
				elseif($val->period=='yearly')
				{
					$recursion_date  = strtotime('+1 year',time());
				}
				else
				{
 					$recursion_date  = '';
 				}
				//update old recod
				$this->db->set('recursion_date',$recursion_date);
				$this->db->where('sub_transaction_id',$val->sub_transaction_id);
				$this->db->update('tbl_sub_transactions');	
 			}
		}
 	}
}
