<?php
class User_m extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
 	public function get_login_user_row($user_id)
	{
		$this->db->select('user_id, user_type, user_full_name, username, user_email, user_picture');
		$this->db->from('tbl_users');
		$this->db->where("user_id='".$user_id."'");
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->row();
		}
 	}
	public function is_username_email_exist($column_name,$field_value,$update_id)
	{
		$this->db->select('user_id');
		$this->db->from('tbl_users');
		if($column_name=='username')
		{
 			$this->db->where('username',$field_value);
		}
		elseif($column_name=='user_email')
		{
 			$this->db->where('user_email',$field_value);
		}
		else
		{
			//for invalid value
			$this->db->where('user_email',0);
		}
		if($update_id>0)
		{
			$this->db->where('user_id!='.$update_id);
		}
  		$query = $this->db->get();
   		return $query->num_rows();
 	}
	
 	public function update_profile()
	{
		$update_id =  $this->session->userdata('payone_user_id');
		$update_array = array(
			'user_full_name'  => $this->input->post('user_full_name'),
			'user_email'  => $this->input->post('user_email'),
   		);
		$this->db->set($update_array);
		$this->db->where('user_id', $update_id);
		$this->db->update('tbl_users');
	}
	public function update_user_password()
	{
		$user_array = array(
			'user_password' => md5($this->input->post('new_password')),
 		);
		$this->db->set($user_array);
		$this->db->where("user_id",$this->session->userdata('payone_user_id'));
		$this->db->update('tbl_users');
	}
	public function check_user_password($user_id,$password)
	{
		$this->db->select("user_id");
 		$this->db->where("user_id",$this->session->userdata('payone_user_id'));
		$this->db->where("user_password",md5($password));
  		$this->db->from('tbl_users');
 		$query = $this->db->get();
   		return $query->num_rows();
	}
	public function get_unique_cat_users_list($cat_id)
	{
		$this->db->select('u.user_id,u.user_full_name, u.username, u.user_email');
		$this->db->where("u.user_status",'active');
		$this->db->where("c.cat_id",$cat_id);
		$this->db->from('tbl_user_categories as c');
		$this->db->join('tbl_users as u', 'u.user_id=c.user_id','inner');
		$this->db->group_by('u.user_id');
   		$query = $this->db->get();
   		if($query->num_rows() > 0)
		{
			return $query->result();
		}
 	}
	public function get_front_user_row($user_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where("user_id",$user_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->row();
		}
 	}
 	public function get_front_user_name($user_id)
	{
		$this->db->select('username, user_full_name');
		$this->db->from('tbl_users');
		$this->db->where("user_id",$user_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if(!empty($row))
			{
 				if(!empty($row->user_full_name))
				{
					return $query->row()->user_full_name;
				}
				elseif(!empty($row->username))
				{
					return $query->row()->username;
				}
			}
		}
 	}
	public function get_subscriber_row($subscriber_id)
	{
		$this->db->select('subscriber_name, subscriber_email');
		$this->db->from('tbl_subscribers');
		$this->db->where("subscriber_id",$subscriber_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->row();
		}
 	}
	/*=================================Front End Users=================================*/
	public function update_front_user_status($user_id,$user_status)
	{
 		$this->db->set('user_status',$user_status);
		$this->db->where('user_id', $user_id);
		$this->db->update('tbl_users');
	}
	public function get_front_users_count()
	{
		$this->db->select('user_id');
		$this->db->from('tbl_users');
  		if(!empty($_POST['username']))
		{
 			$this->db->where("username",trim($this->input->post('username')));
		}
		if(!empty($_POST['user_full_name']))
		{
 			$this->db->like('user_full_name',trim($this->input->post('user_full_name')),'both');
		}
		if(!empty($_POST['user_email']))
		{
			$this->db->where("user_email",trim($this->input->post('user_email')));
		}
  		$query = $this->db->get();
  		return $query->num_rows();
	}
	public function get_front_users_data($limit,$start)
	{	
 		$this->db->select('*');
		$this->db->from('tbl_users');
  		if(!empty($_POST['username']))
		{
 			$this->db->where("username",trim($this->input->post('username')));
		}
		if(!empty($_POST['user_full_name']))
		{
 			$this->db->like('user_full_name',trim($this->input->post('user_full_name')),'both');
		}
		if(!empty($_POST['user_email']))
		{
			$this->db->where("user_email",trim($this->input->post('user_email')));
		}
  		$this->db->order_by('user_id','desc');
		$this->db->limit($start, $limit);
		$query = $this->db->get();
   		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
}
?>