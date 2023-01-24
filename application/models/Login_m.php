<?php
class Login_m extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
 	public function get_login_user_credential()
	{
		if(!empty($_POST['username']) && !empty($_POST['password']))
		{
			$username = trim($this->input->post('username'));
 			$password = trim($this->input->post('password'));
			$this->db->select('user_id, user_type, user_full_name, username, user_email');
			$this->db->from('tbl_users');
			$this->db->where("(username='".$username."' or user_email='".$username."') and user_password='".md5($password)."' and user_status='active'");
			$query = $this->db->get();
			if($query->num_rows()>0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	public function check_user_by_email($user_email)
	{
		$this->db->select("user_id");
		$this->db->from('tbl_users');
		$this->db->where("user_email",$user_email);
 		$this->db->where("user_status",'active');
  		$query = $this->db->get();
		return $query->num_rows();
	}
	public function get_user_row_by_email($user_email)
	{
		$this->db->select("user_id,user_full_name");
		$this->db->from('tbl_users');
		$this->db->where("user_email",$user_email);
 		$this->db->where("user_status",'active');
  		$query = $this->db->get();
   		if($query->num_rows()>0)
		{
			return $query->row();
		}
	}
	public function add_user_reset_password()
	{
 		//Delete old Reset password
		$this->db->where('email',$this->input->post('user_email'));
		$this->db->delete('tbl_reset_password');
		//Add New Record
 		$expiry_timestamp = time()+60*60*5;
		$add_array = array(
			'email'  => $this->input->post('user_email'),
 			'add_timestamp' => time(),
			'expiry_timestamp'  => $expiry_timestamp,
 		);
		$this->db->set($add_array);
		$this->db->insert('tbl_reset_password');
		return $this->db->insert_id();
	}
	
	public function get_user_reset_password_row($id)
	{
 		$this->db->select("r.id, r.email, r.add_timestamp, r.expiry_timestamp, u.user_id");
		$this->db->where("r.id",$id);
		$this->db->where("u.user_status","active");
		$this->db->from('tbl_reset_password r');
		$this->db->join('tbl_users as u', 'r.email = u.user_email');
 		$query = $this->db->get();
   		if($query->num_rows()>0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	public function update_delete_user_reset_password($id,$user_id)
	{
		//delete from reset table
		$this->db->where('id',$id);
		$this->db->delete('tbl_reset_password');	
 		
		//update user table
		$update_array = array(
			'user_password'  => md5($this->input->post('password'))
  		);
		$this->db->set($update_array);
		$this->db->where('user_id', $user_id);
		$this->db->update('tbl_users');
	}
}
?>