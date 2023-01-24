<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Smtpemails
{
 	public function send($receiver_email,$subject,$message)
	{
   		 $config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'sg2plcpnl0003.prod.sin2.secureserver.net',
		  'smtp_port' => 465,
		  'smtp_user' => 'mailing@codeigniterexpert.com', // change it to yours
		  'smtp_pass' => 'mailing', // change it to yours
		  'mailtype' => 'html',
		  'charset'  => 'utf-8',
		  'wordwrap' => TRUE
		);
        $sender_email = "mailing@codeigniterexpert.com";
        $sender_name = "Payone";
		$ci =& get_instance();
		$ci->load->library('email');
		$ci->email->initialize($config);
		$ci->email->set_newline("\r\n");
		$ci->email->from($sender_email,$sender_name);
 
 		$ci->email->to($receiver_email); 
		$ci->email->subject($subject);
		$ci->email->message($message);
		$ci->email->send();
 	}
}
