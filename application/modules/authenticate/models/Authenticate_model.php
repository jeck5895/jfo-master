<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	class Authenticate_model extends CI_Model{
		
		public function __construct(){
	
			parent:: __construct();
			
		}

		public function auth($username,$password)
		{
			$query = $this->db->query("
						SELECT *
						FROM tb_users 
						WHERE  
						(tb_users.mobile_num ='".$username."' AND tb_users.password ='".$password."') 
						OR (tb_users.email ='".$username."' AND tb_users.password ='".$password."')
				");

		
			return $query->row();
		}

		public function isEmailExist($email)
		{
			$query = $this->db->select('*')->from('tb_users')->where('email',$email)->get();

			return $query->row();
		}

		public function resetPassword($user_id,$newPassword)
		{
			$data = array('password' => $newPassword);	
			
			$query = $this->db->where('user_id',$user_id)->update('tb_users',$data);

			if($query)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		public function getUserPassword($email)
		{
			$query = $this->db->join('tb_employee','tb_employee.user_id = tb_users.user_id')->get_where('tb_users', ['tb_employee.email' => $email]);

			return $query->row_array();	
		}

		public function newUserResetPasswordCode($code, $uid, $dateCreated)
		{
			$data['code'] = $code;
			$data['userid'] = $uid;
			$data['date_created'] = $dateCreated;
			
			$query = $this->db->insert('user_reset_verfication_codes',$data);

			return $this->db->insert_id();
		}

		public function getUserIdByCode($code)
		{
			$query = $this->db->where('code',$code)->get('user_reset_verfication_codes');

			return $query->row();
		}

		public function checkResetCodeStatus($code, $userid)
		{
			$query = $this->db->where('code', $code)
								->where('userid',$userid)
								->get('user_reset_verfication_codes');
			return $query->row();
		}

		public function setResetCodeStatus($code)
		{
			$data['status'] = 1;
			$data['date_modified'] = date('Y-m-d h:i:s');
			$query = $this->db->update('user_reset_verfication_codes', $data, ["code" => $code]);
			
			if($query)
			{
				return TRUE;
			}
		}

		public function isCurrentEmail($newEmail, $user_id)
		{
			$query = $this->db->where('email',$newEmail)->where('user_id', $user_id)->get('tb_users');

			return $query->num_rows();
		}
	}
?>			
