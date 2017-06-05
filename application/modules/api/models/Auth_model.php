<?php
defined("BASEPATH") OR exit("No Direct script access allowed");

class Auth_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}

	public function get($user_id, $password)
	{
		$query = $this->db->where('email', $user_id)->where('password', $password)->where('is_active',1)->get('tb_users');

		return $query->row();
	}

	public function isEmailActivated($user_id){
		$query = $this->db->where('user_id', $user_id)->where('email_activated',1)->get('tb_users');

		return ($query->num_rows() == 1)? TRUE : FALSE;	
	}

	public function validateEmail($email)
	{
		$query = $this->db->where('email', $email)->get('tb_users');

		if($query->num_rows() === 1)
		{
			return TRUE;
		}
		else{
			return FALSE; 
		}
	}

	public function newUserToken($data)
	{
		$this->db->insert('tb_user_token', $data);

		return TRUE;
	}
	
	public function find($id)
	{

		$query = $this->db->where('id',$id)->get('tb_users');

		return $query->row_array();
	}

	public function getUserByToken($token)
	{
		$user = $this->db->select('tb_users.*')
		->from('tb_user_token')
		->where('token',$token)
		->where('exp_date >', date('Y-m-d H:i:s'))
		->join('tb_users','tb_users.user_id = tb_user_token.user_id')
		->get();

		return $user->row();
	}

	public function getUserDetails($user_id, $acct_type)
	{

		if($acct_type == 1){
			$this->db->select('tb_sri_account.*, tb_sri_account.user_id AS user_id, tb_users.email, tb_users.mobile_num, tb_cities.id AS city_id, tb_cities.city_name AS city, tb_region.region_name AS province, tb_region.id AS region_id, tb_users.account_type');
			$this->db->from('tb_sri_account');
			$this->db->join('tb_users','tb_users.user_id = tb_sri_account.user_id');
			$this->db->join('tb_region', 'tb_region.id = tb_sri_account.province');
			$this->db->join('tb_cities', 'tb_cities.id = tb_sri_account.city');
			$this->db->where('tb_sri_account.user_id', $user_id);
		}
		if($acct_type == 2){
			$this->db->select('tb_employee.*, tb_employee.user_id AS user_id, tb_users.email, tb_users.mobile_num, tb_cities.city_name AS city, tb_region.region_name AS province, tb_users.account_type');
			$this->db->from('tb_employee');
			$this->db->join('tb_users','tb_users.user_id = tb_employee.user_id');
			$this->db->join('tb_region', 'tb_region.id = tb_employee.province_1');
			$this->db->join('tb_cities', 'tb_cities.id = tb_employee.city_1');
			$this->db->where('tb_employee.user_id', $user_id);
		}
		if($acct_type == 3){
			$this->db->select('tb_employer.*, tb_employer.user_id AS user_id, tb_employer.id AS comp_id, tb_industry.industry_name AS industry, tb_employer.industry AS industry_id,tb_users.email, tb_users.mobile_num, tb_cities.city_name AS city, tb_region.region_name AS province, tb_users.account_type');
			$this->db->from('tb_employer');
			$this->db->join('tb_users','tb_users.user_id = tb_employer.user_id');
			$this->db->join('tb_region', 'tb_region.id = tb_employer.province_1');
			$this->db->join('tb_cities', 'tb_cities.id = tb_employer.city_1');
			$this->db->join('tb_industry', 'tb_industry.id = tb_employer.industry');
			$this->db->where('tb_employer.user_id', $user_id);
		}
		
		
		$user = $this->db->get();
		
		return $user->row();
	}

	public function getUserIdByToken($token)
	{
		$query = $this->db->select('user_id')->from('tb_user_token')->where('token', $token)->where('exp_date >', date('Y-m-d H:i:s'))->get();

		return $query->row()->user_id;
	}

	public function getUserByEmail($email)
	{
		$query = $this->db->where('email',$email)->get('tb_users');

		return $query->row();
	}

	public function destroyToken($token, $data=array())
	{
		$this->db->where('token', $token)->update('tb_user_token', $data);

		return TRUE;
	}

	public function newEmailValid($newEmail)
	{
		$query = $this->db->where('email',$newEmail)->get('tb_users');

		return $query->num_rows();
	}

	public function newNumberValid($newNumber)
	{
		$query = $this->db->where('mobile_num',$newNumber)->get('tb_users');

		return $query->num_rows();
	}

	public function newUserResetPasswordCode($data)
	{
		$query = $this->db->insert('user_reset_verfication_codes',$data);

		return $this->db->insert_id();
	}

	public function isResetCodeValid($code)
	{
		$query = $this->db->where('code', $code)->where('status',1)->where('expiration_date >', date('Y-m-d H:i:s'))->get('user_reset_verfication_codes');

		if($query->num_rows() === 1)
		{
			return TRUE;
		}
		else{
			return FALSE; 
		}
	}

	public function getUserByCode($code)
	{
		$query = $this->db->where('code', $code)->get('user_reset_verfication_codes');

		return $query->row();
	}

	public function resetUserPassword($id, $data)
	{
		$query = $this->db->where('user_id',$id)->update('tb_users', $data);

		return TRUE;
	}

	public function disableResetCode($code)
	{
		$this->db->delete('user_reset_verfication_codes', array('code' => $code)); 

		return TRUE;
	}

	public function newUserActivationCode($code, $uid, $dateCreated)
	{
		$data['code'] = $code;
		$data['userid'] = $uid;
		$data['date_created'] = $dateCreated;
		$data['status'] = 1;

		$query = $this->db->insert('user_activation_codes',$data);

		return $this->db->insert_id();
	}

	public function isActivationCodeValid($code)
	{
		$query = $this->db->where('code',$code)->where('status',1)->get('user_activation_codes');

		return $query->row();
	}

	public function activateEmployer($user_id, $code)
	{
		$data['email_activated'] = 1;
		$data['date_modified'] = date("Y-m-d H:i:s");

		$this->db->where("user_id", $user_id)->update("tb_users", $data);
		$this->db->delete('user_activation_codes', array('code' => $code, 'user_id'=> $user_id));

		return TRUE; 
	}
}	