<?php
	defined("BASEPATH") OR exit("No Direct script access allowed");
	
	
	class Employer_model extends CI_Model{
		
		public function __construct(){
	
			parent:: __construct();
			
			// $this->db->db_select('auth_google',TRUE);
			
		}

		public function getActiveEmployer($eid)
		{
			$query = $this->db->select('tb_users.user_id, tb_users.email, mobile_num, company_name, company_description, street_1, tb_cities.city_name AS city_1, tb_region.region_name AS province_1, profile_pic, first_name, middle_name, last_name, telephone_number, department, industry, position, area_code, company_banner, company_website, tb_region.id AS region_id, tb_cities.id AS city_id')
								->where('tb_users.user_id',$eid)
								->join('tb_employer','tb_employer.user_id = tb_users.user_id')
								->join('tb_region', 'tb_region.id = tb_employer.province_1')
								->join('tb_cities', 'tb_cities.id = tb_employer.city_1')
								->get('tb_users');
			return $query->row();					
		}

		public function updateCompanyProfile($user_id, $data)
		{
			$query = $this->db->where('user_id',$user_id)->update('tb_employer',$data);

			return TRUE;
		}

		public function updateProfile($user_id, $data)
		{
			$query = $this->db->where('user_id',$user_id)->update('tb_employer',$data);

			return TRUE;
		}

		public function updateEmail($user_id, $data)
		{
			$query = $this->db->where('user_id',$user_id)->update('tb_users',$data);

			return TRUE;
		}

		public function updatePassword($user_id, $data)
		{
			$query = $this->db->where('user_id',$user_id)->update('tb_users',$data);

			return TRUE;
		}

		public function updateMobileNumber($user_id, $data)
		{
			$query = $this->db->where('user_id', $user_id)->update('tb_users', $data);

			return TRUE;
		}

		public function validUser($user_id, $password)
		{
			$query = $this->db->where('user_id', $user_id)->where('password', $password)->get('tb_users');

			if($query->num_rows() === 1)
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}

		public function updateBanner($user_id, $banner)
		{
			$query = $this->db->where('user_id',$user_id)->update('tb_employer',$banner);

			return TRUE;
		}

		public function updateCompanyLogo($user_id, $banner)
		{
			$query = $this->db->where('user_id',$user_id)->update('tb_employer',$banner);

			return TRUE;
		}
	}
?>		