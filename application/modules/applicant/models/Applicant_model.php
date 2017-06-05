<?php
	defined("BASEPATH") OR exit("No Direct script access allowed");
	
	
	class Applicant_model extends CI_Model{
		
		public function __construct(){
	
			parent:: __construct();
			
			// $this->db->db_select('auth_google',TRUE);
			
		}

		public function insert_applicant_data($data=array())
		{
			$query = $this->db->insert('tb_applicants',$data);

			return $this->db->insert_id();
		}

		public function update_applicant_info($userid, $data=array())
		{
			$query = $this->db->where('tb_employee.user_id',$userid)
								->join('tb_users','tb_users.user_id = tb_employee.user_id')
								->update('tb_employee',$data);
		}

		public function update_bdate($id,$data=array())
		{

			$query = $this->db->where('username',$id)->update('tb_employee',$data);
		}

		public function auth($username,$password){
			$query = $this->db->select('*')->from('tb_applicants')->where('username',$username)->where('password',$password)->get();

			return $query->row();
		}

		public function registerApplicant($data=array())
		{
			$applicant['oauth_id'] = $data['oauth_uid'];	
			$applicant['first_name'] = $data['first_name'];
			$applicant['last_name'] = $data['last_name'];
			$applicant['email'] = $data['email'];
			$applicant['gender'] = $data['gender'];
			$applicant['date_created'] = date('Y-m-d h:i:s');
			$query = $this->db->insert('applicant_accounts',$applicant);

			return $this->db->insert_id();
		}

		public function applicantExist($data=array())
		{
			$query = $this->db->select("*")->from("applicant_accounts")->where("email",$data['email'])->get();
			
			return $query->row();	
		}

		public function getActiveUser($user_id)
		{
			$query = $this->db->select("*, tb_employee.user_id AS user_id, tb_users.email AS email, tb_users.mobile_num AS mobile_num, tb_cities.city_name AS city, tb_region.region_name AS province")
								->from('tb_users')
								->join('tb_employee','tb_employee.user_id = tb_users.user_id','inner')
								->join('tb_region', 'tb_region.id = tb_employee.province_1')
								->join('tb_cities', 'tb_cities.id = tb_employee.city_1')
								->where('tb_employee.user_id', $user_id)
								->get();
			
			return $query->row();
		}

		public function getUserJobCategory($username,$categoryId)
		{
			$query = $this->db->select('category_name')
								->from('tb_category')
								->join('tb_employee','tb_employee.job_category = tb_category.id')
								->where('tb_category.id',$categoryId)
								->where('tb_employee.user_id',$username)
								->get();
			return $query->row();					
		}

		public function addUserWorkHistory($data=array())
		{
			$query = $this->db->insert('tb_work_history',$data);

			return $this->db->insert_id();
		}

		public function getUserWorkHistoryDetails($id)
		{
			$query = $this->db->where('id',$id)->get('tb_work_history');

			return $query->row();
		}

		public function updateUserWorkHistory($id,$userid,$data=array())
		{
			$query = $this->db->where('id',$id)->where('user_id',$userid)->update('tb_work_history',$data);

			return $this->db->affected_rows();
		}
		public function updateUserImage($userid,$data = array())
		{
			$query = $this->db->where('user_id',$userid)->update('tb_employee',$data);

			return TRUE;
		}
	}	
