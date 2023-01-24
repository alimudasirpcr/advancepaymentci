<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('load_main_template'))
{
    function load_main_template($current_view, $header_data = '', $data = '') 
	{
  		$ci=& get_instance();
		$menu_data = array();
      	$ci->load->view('Templates/header',$header_data);
 		$top_menu_user_arr = $ci->get_login_user_row();
		if(!empty($top_menu_user_arr))
		{
			$menu_data['top_menu_user_arr'] = $ci->get_login_user_row();
		}
 		$ci->load->view('Templates/top_menu',$menu_data);
		$ci->load->view('Templates/left_menu');
 		$ci->load->view($current_view,$data);
   		$ci->load->view('Templates/pages-footer');
		return NULL;
	}
}
if(!function_exists('load_login_template'))
{
 	function load_login_template($current_view, $header_data = '', $data = '') 
	{
  		$ci=& get_instance();
  		$ci->load->view('Templates/header',$header_data);
 		$ci->load->view($current_view,$data);
   		$ci->load->view('Templates/footer');
		return NULL;
	}  
}
?>