<?php defined("BASEPATH") OR exit("No Direct script access allowed");

class Company_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}

	public function getTotalRows($status)
	{
		$this->db->select("*, tb_region.region_name AS province_1, tb_cities.city_name AS city_1");
		$this->db->from('tb_employer');
		$this->db->join('tb_region', 'tb_region.id = tb_employer.province_1');
		$this->db->join('tb_cities', 'tb_cities.id = tb_employer.city_1');
		$this->db->join('tb_industry', 'tb_industry.id = tb_employer.industry');

		if($status == "active")
		{
			$this->db->where('tb_employer.is_active', 1);
		}
		elseif($status == "inactive")
		{
			$this->db->where('tb_employer.is_active', 0);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}	

	public function get($id = FALSE, $status = FALSE, $offset = FALSE, $industry = FALSE, $region = FALSE, $keyword = FALSE)
	{
		if($id === FALSE)
		{
			$limit = 10;

			$sql = '(tb_employer.company_name LIKE "%'.$keyword.'%" OR tb_employer.first_name LIKE "%'.$keyword.'%" OR tb_employer.middle_name LIKE "%'.$keyword.'%" OR tb_employer.last_name LIKE "%'.$keyword.'%" OR tb_cities.city_name LIKE "%'.$keyword.'%" OR tb_region.region_name LIKE "%'.$keyword.'%" OR tb_industry.industry_name LIKE "%'.$keyword.'%")';

			$this->db->select("*, tb_region.region_name AS province_1, tb_cities.city_name AS city_1, tb_users.user_id AS user_id, tb_users.email AS email, tb_users.mobile_num AS mobile_num, tb_employer.date_created AS company_date_created, tb_industry.industry_name AS industry, tb_employer.id AS cid");
			$this->db->from('tb_employer');
			$this->db->join('tb_users','tb_users.user_id = tb_employer.user_id');
			$this->db->join('tb_region', 'tb_region.id = tb_employer.province_1');
			$this->db->join('tb_cities', 'tb_cities.id = tb_employer.city_1');
			$this->db->join('tb_industry', 'tb_industry.id = tb_employer.industry');
			$this->db->limit($limit, $offset);

			if($keyword != FALSE)
			{
			 	$this->db->where($sql);	
			}	

			if($region != FALSE)
			{
				$this->db->where('tb_employer.province_1', $region);
			}

			if($industry != FALSE)
			{
				$this->db->where('tb_employer.industry', $industry);
			}

			if($status == 'review')
			{
				$this->db->where('tb_users.status', 0);
				$this->db->where('tb_users.status_1', 0);
				$this->db->where('tb_users.is_active', 1);
			}

			if($status == "active")
			{	
				$this->db->where('tb_users.status', 1);
				$this->db->where('tb_users.status_1', 1);
				$this->db->where('tb_users.is_active', 1);
				$this->db->where('tb_employer.is_active', 1);
			}
			elseif($status == "inactive")
			{
				$this->db->where('tb_users.status', 0);
				$this->db->where('tb_users.status_1', 0);
				$this->db->where('tb_users.is_active', 0);
			}
			$this->db->where('tb_users.account_type', 3);
			$query = $this->db->get();

			if($keyword != FALSE)
			{
				return  $response = array(
							"data" => $query->result_array(),
							"limit" => $limit,
							"filtered" => $query->num_rows(),
							);

			}

			if($region != FALSE)
			{
				return  $response = array(
					"data" => $query->result_array(),
					"limit" => $limit,
					"filtered" => $query->num_rows(),
					);
			}

			if($industry != FALSE)
			{
				return  $response = array(
					"data" => $query->result_array(),
					"limit" => $limit,
					"filtered" => $query->num_rows(),
					);
			}

			else{
				return  $response = array(
							"data" => $query->result_array(),
							"limit" => $limit,
							"filtered" => $this->getTotalRows($status),
							);
			}

		}
		else
		{
			$query = $this->db->select("*, tb_region.region_name AS province_1, tb_cities.city_name AS city_1")
								->from('tb_employer')
								->join('tb_industry', 'tb_industry.id = tb_employer.industry','left')
								->join('tb_region', 'tb_region.id = tb_employer.province_1')
								->join('tb_cities', 'tb_cities.id = tb_employer.city_1')
								->where('tb_employer.id', $id)
								->get();
			return $query->result_array();					
		}
		
	}

	public function getById($user_id)
	{
		$query = $this->db->select("*, tb_region.region_name AS province_1, tb_cities.city_name AS city_1")
		->from('tb_employer')
		->join('tb_users', 'tb_users.user_id = tb_employer.user_id')
		->join('tb_industry', 'tb_industry.id = tb_employer.industry','left')
		->join('tb_region', 'tb_region.id = tb_employer.province_1')
		->join('tb_cities', 'tb_cities.id = tb_employer.city_1')
		->where('tb_employer.user_id', $user_id)
		->get();
		return $query->row();
	}

	public function get_job_applicants($user, $job_id = FALSE, $offset = FALSE, $keyword = FALSE, $region = FALSE, $category = FALSE, $status = FALSE)
	{
		$limit = 5;

		$sql = '(apl_fname LIKE "%'.$keyword.'%" OR apl_mname LIKE "%'.$keyword.'%" OR apl_lname LIKE "%'.$keyword.'%" OR fullname LIKE "%'.$keyword.'%" OR age LIKE "%'.$keyword.'%" OR city LIKE "%'.$keyword.'%" OR province LIKE "%'.$keyword.'%" OR sex LIKE "%'.$keyword.'%" OR s_educ_attain LIKE "%'.$keyword.'%" OR s_work_exp LIKE "%'.$keyword.'%" OR degree LIKE "%'.$keyword.'%" OR school_name LIKE "%'.$keyword.'%" OR category LIKE "%'.$keyword.'%")';

		$this->db->select('*');
		$this->db->from('tb_job_applicants_verification');
		
		if($keyword != FALSE)
		{
			$this->db->where($sql);	
		}	

		if($region != FALSE)
		{
			$this->db->where('province_id', $region);
		}

		if($category != FALSE)
		{
			$this->db->where('cat_id', $category);
		}

		if($job_id != FALSE)
		{
			$this->db->where('job_id', $job_id);
		}

		if($status != FALSE)
		{
			$this->db->where('stat_id', $status);
		}

		$this->db->where('recruiter_id', $user);
		$this->db->where('stat_id !=', 2); 
		$this->db->limit($limit, $offset);
		$this->db->order_by('date_applied','DESC');
		$query = $this->db->get();
		
		if($keyword != FALSE)
		{
			return  $response = array(
				"data" => $query->result_array(),
				"limit" => $limit,
				"filtered" => $this->getJobApplicantsTotal($user, $keyword, $region, $category),
				);

		}
		if($region != FALSE)
		{
			return  $response = array(
				"data" => $query->result_array(),
				"limit" => $limit,
				"filtered" => $this->getJobApplicantsTotal($user, $keyword, $region, $category),
				);
		}
		if($category != FALSE)
		{
			return  $response = array(
				"data" => $query->result_array(),
				"limit" => $limit,
				"filtered" => $this->getJobApplicantsTotal($user, $keyword, $region, $category),
				);
		}
		if($job_id != FALSE)
		{
			return  $response = array(
				"data" => $query->result_array(),
				"limit" => $limit,
				"filtered" => $this->getJobApplicantsTotal($user, $keyword, $region, $category),
				);
		}
		if($status != FALSE)
		{
			return  $response = array(
				"data" => $query->result_array(),
				"limit" => $limit,
				"filtered" => $this->getJobApplicantsTotal($user, $keyword, $region, $category),
				);
		}
		else
		{
			return  $response = array(
				"data" => $query->result_array(),
				"limit" => $limit,
				"filtered" =>  $this->getJobApplicantsTotal($user, $job_id, $keyword, $region, $category),
				);
		}
	}

	public function getJobApplicantsTotal($user, $job_id = FALSE, $keyword = FALSE, $region = FALSE, $category = FALSE, $status = FALSE)
	{
		$sql = '(apl_fname LIKE "%'.$keyword.'%" OR apl_mname LIKE "%'.$keyword.'%" OR apl_lname LIKE "%'.$keyword.'%" OR fullname LIKE "%'.$keyword.'%" OR age LIKE "%'.$keyword.'%" OR city LIKE "%'.$keyword.'%" OR province LIKE "%'.$keyword.'%" OR sex LIKE "%'.$keyword.'%" OR s_educ_attain LIKE "%'.$keyword.'%" OR s_work_exp LIKE "%'.$keyword.'%")';

		$this->db->select('*');
		$this->db->from('tb_job_applicants_verification');
		
		if($keyword != FALSE)
		{
			$this->db->where($sql);	
		}	

		if($region != FALSE)
		{
			$this->db->where('province_id', $region);
		}

		if($category != FALSE)
		{
			$this->db->where('cat_id', $category);
		}
		if($job_id != FALSE)
		{
			$this->db->where('job_id', $job_id);
		}

		$this->db->where('recruiter_id', $user); 
		$this->db->order_by('date_applied','DESC');
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function getVerification($id = FALSE)
	{	
		if($id === FALSE){
			$this->db->select('*');
			$this->db->from('tb_job_applicants_verification');
			$this->db->order_by('date_applied','DESC');
			$query = $this->db->get();

			return $query->result_array();
		}
		else{
			$this->db->select('*');
			$this->db->from('tb_job_applicants_verification');
			$this->db->where('vid', $id);
			$query = $this->db->get();

			return $query->row();
		}
	}

	public function create($company_info = array(), $company_acct = array())
	{
		$this->db->insert('tb_employer', $company_info);
		$this->db->insert('tb_users', $company_acct);

		return $this->db->insert_id();
	}

	public function update($user_id, $data=array())
	{
		$this->db->where('user_id', $user_id)->update('tb_employer', $data);

		return TRUE;
	}

	public function find($id)
	{

		$query = $this->db->where('id',$id)->get('tb_users');

		return $query->row_array();
	}

	public function setAsActive($id)
	{
		$data['status'] = 1;
		$data['status_1'] = 1;
		$data['is_active'] = 1;

		$this->db->where('user_id', $id)->update('tb_users', $data);

		return TRUE;
	}

	public function setAsInactive($id)
	{
		$data['status'] = 0;
		$data['status_1'] = 0;
		$data['is_active'] = 0;

		$this->db->where('user_id', $id)->update('tb_users', $data);

		return TRUE;
	}

	public function get_industries($id = FALSE)
	{
		if($id === FALSE)
		{
			$this->db->select('*');
			$this->db->from('tb_industry');
			$this->db->where('is_active',1);
			$query = $this->db->get();

			return $query->result_array();
		}
		else{
			$this->db->select('*');
			$this->db->from('tb_industry');
			$this->db->where('is_active',1);
			$this->db->where('id', $id);
			$query = $this->db->get();

			return $query->row_array();
		}
	}

	public function createIndustry($data = array())
	{
		$this->db->insert('tb_industry', $data);

		return TRUE;
	}

	public function updateIndustry($id, $data = array())
	{
		$this->db->where('id', $id)->update('tb_industry',$data);

		return TRUE;
	}

	public function disableIndustry($id)
	{
		$this->db->delete('tb_industry', array('id' => $id)); 

		return TRUE;
	}

	public function updateAccount($user_id, $data)
	{
		$this->db->where('user_id',$user_id)->update('tb_users', $data);
		return TRUE;
	}

	public function deleteAccount($id)
	{
		$this->db->delete('tb_employer', array('user_id' => $id)); 
		$this->db->delete('tb_users', array('user_id' => $id));
		$this->db->delete('tb_verification', array('user_id' => $id));
		$this->db->delete('tb_jobpost', array('user_id' => $id));
		$this->db->delete('tb_user_token', array('user_id' => $id));
		return TRUE;
	}
}	