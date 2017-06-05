<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	class Registration_model extends CI_Model{
		
		public function __construct(){
	
			parent:: __construct();
			
		}
	

		public function getLocation()
		{
			$query = $this->db->order_by('id','ASC')->where('is_active',1)->get('tb_region');

			return $query->result();
		}
		
		public function getCity($provinceID)
		{
			$query = $this->db->select('*')
							  ->from('tb_cities')
							  // ->join('tb_region','tb_region.id = tb_cities.region_id','inner')
							  ->where('region_id',$provinceID)
							  ->where('is_active', 1)
							  ->order_by('tb_cities.id','ASC')
							  ->get();

			return $query->result();

		}

		public function get_job_category()
		{
			$query = $this->db->select('*')->from('tb_category')->where('is_active',1)->get();

			return $query->result();
		}

		public function get_religion()
		{
			$query = $this->db->select('*')->from('tb_religion')->where('is_active',1)->get();

			return $query->result();
		}

		public function get_company_industry()
		{
			$query = $this->db->where('is_active',1)->order_by('industry_name')->get('tb_industry');

			return $query->result();
		}

		public function insert_applicant_data($data = array())
		{	
			$query = $this->db->insert('tb_employee',$data);

			return $this->db->insert_id();
		}

		public function updateUserResume($userid,$data = array())
		{
			$query = $this->db->where('user_id',$userid)->update('tb_employee',$data);

			return TRUE;
		}

		public function updateCompanyLogo($userid, $data = array())
		{
			$query = $this->db->where('user_id', $userid)->update('tb_employer',$data);

			return TRUE;
		}

		public function insert_applicant_acct($data = array())
		{
			$query = $this->db->insert('tb_users', $data);

			return $this->db->insert_id();
		}

		public function insert_company_info($data = array())
		{	
			$query = $this->db->insert('tb_employer',$data);

			return $this->db->insert_id();
		}

		public function insert_employer_acct($data = array())
		{
			$query = $this->db->insert('tb_users', $data);

			return $this->db->insert_id();
		}

		public function set_smtp_acct($data = array())
		{
			$query = $this->db->insert('tb_email_settings',$data);

			return $this->db->insert_id();
		}

		public function activateUser($userid)
		{
			$data['email_activated'] = 1;
			$data['is_active'] = 1;
			
			$query = $this->db->update('tb_users', $data, ["user_id" => $userid]);

			if($query)
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}

		public function setCodeStatus($code)
		{
			$data['status'] = 1;
			$data['date_modified'] = date('Y-m-d h:i:s');
			$query = $this->db->update('user_activation_codes', $data, ["code" => $code]);
			
			if($query)
			{
				return TRUE;
			}
		}

		public function newUserKey($userid, $key)
		{	
			$data['userid'] = $userid;
			$data['secret_key'] = $key;
			$query = $this->db->insert('tb_user_keys',$data);

			if($query)
			{
				return TRUE;
			}
		}

		public function companyNameValid($company_name)
		{
			$query = $this->db->where("company_name", $company_name)->get('tb_employer');

			return $query->num_rows();
		}
	}
?>