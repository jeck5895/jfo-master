<?php defined("BASEPATH") OR exit("No Direct script access allowed");

class Applicant_model_rest extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}

	public function getTotalRows($id = FALSE, $keyword = FALSE, $region = FALSE, $category = FALSE, $type=FALSE)
	{
		$sql = '(tb_employee.first_name LIKE "%'.$keyword.'%" OR tb_employee.middle_name LIKE "%'.$keyword.'%" OR tb_employee.last_name LIKE "%'.$keyword.'%" OR tb_employee.age LIKE "%'.$keyword.'%" OR tb_cities.city_name LIKE "%'.$keyword.'%" OR tb_region.region_name LIKE "%'.$keyword.'%" OR tb_employee.sex LIKE "%'.$keyword.'%" OR tb_employee.degree LIKE "%'.$keyword.'%" OR tb_employee.school_name LIKE "%'.$keyword.'%")';

		$this->db->select("*, tb_employee.user_id, tb_users.email, tb_users.mobile_num, tb_region.region_name AS province, tb_cities.city_name AS city, tb_category.category_name AS category");
		$this->db->from('tb_employee');
		$this->db->join('tb_users','tb_users.user_id = tb_employee.user_id', 'left');
		$this->db->join('tb_region','tb_region.id = tb_employee.province_1','left');
		$this->db->join('tb_cities','tb_cities.id = tb_employee.city_1','left');
		$this->db->join('tb_category','tb_category.id = tb_employee.job_category','left');

		if($keyword != FALSE)
		{
			$this->db->where($sql);	
		}	

		if($region != FALSE)
		{
			$this->db->where('tb_employee.province_1', $region);
		}

		if($category != FALSE)
		{
			$this->db->where('tb_employee.job_category', $category);
		}

		if($type == 'public')
		{
			$this->db->where('tb_users.status', 1);
			$this->db->where('tb_users.status_1', 1);
			$this->db->where('tb_employee.allow_info_status', 1);
			$this->db->where('tb_users.is_active', 1);
		}
		if($type == 'private')
		{
			$this->db->where('tb_users.status', 1);
			$this->db->where('tb_users.status_1', 1);
			$this->db->where('tb_employee.allow_info_status', 0);
			$this->db->where('tb_users.is_active', 1);	
		}
		if($type == 'review')
		{
			$this->db->where('tb_users.status', 0);
			$this->db->where('tb_users.status_1', 0);
			$this->db->where('tb_users.is_active', 1);
		}
		if ($type == 'inactive') {

			$this->db->where('tb_users.is_active', 0);
		}
		$this->db->where('tb_users.account_type', 2);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function create($applicant_info = array(), $applicant_acct = array())
	{
		$this->db->insert('tb_employee', $applicant_info);
		$this->db->insert('tb_users', $applicant_acct);

		return $this->db->insert_id();
	}

	public function update($user_id, $data=array())
	{
		$this->db->where('user_id', $user_id)->update('tb_employee', $data);

		return TRUE;
	}

	public function get($id = FALSE, $offset = FALSE, $keyword = FALSE, $region = FALSE, $category = FALSE, $type=FALSE, $limit=FALSE)
	{

		$sql = '(tb_employee.first_name LIKE "%'.$keyword.'%" OR tb_employee.middle_name LIKE "%'.$keyword.'%" OR tb_employee.last_name LIKE "%'.$keyword.'%" OR tb_employee.age LIKE "%'.$keyword.'%" OR tb_cities.city_name LIKE "%'.$keyword.'%" OR tb_region.region_name LIKE "%'.$keyword.'%" OR tb_employee.sex LIKE "%'.$keyword.'%" OR tb_employee.degree LIKE "%'.$keyword.'%" OR tb_employee.school_name LIKE "%'.$keyword.'%")';


		if($id === FALSE)
		{
			$this->db->select("*, tb_employee.user_id, tb_users.email, tb_users.mobile_num, tb_region.region_name AS province, tb_cities.city_name AS city, tb_category.category_name AS category");
			$this->db->from('tb_employee');
			$this->db->join('tb_users','tb_users.user_id = tb_employee.user_id', 'left');
			$this->db->join('tb_region','tb_region.id = tb_employee.province_1','left');
			$this->db->join('tb_cities','tb_cities.id = tb_employee.city_1','left');
			$this->db->join('tb_category','tb_category.id = tb_employee.job_category','left');
			 

			if($limit != FALSE)
			{
				$this->db->limit($limit, $offset);
			}
			
			if($keyword != FALSE)
			{
			 	$this->db->where($sql);	
			}	
			 
			if($region != FALSE)
			{
				$this->db->where('tb_employee.province_1', $region);
			}

			if($category != FALSE)
			{
				$this->db->where('tb_employee.job_category', $category);
			}

			if($type == 'public')
			{
				$this->db->where('tb_users.status', 1);
				$this->db->where('tb_users.status_1', 1);
				$this->db->where('tb_employee.allow_info_status', 1);
				$this->db->where('tb_users.is_active', 1);
				$this->db->order_by('tb_employee.date_created', 'DESC');
			}
			if($type == 'private')
			{
				$this->db->where('tb_users.status', 1);
				$this->db->where('tb_users.status_1', 1);
				$this->db->where('tb_employee.allow_info_status', 0);
				$this->db->where('tb_users.is_active', 1);	
			}
			if($type == 'review')
			{
				$this->db->where('tb_users.status', 0);
				$this->db->where('tb_users.status_1', 0);
				$this->db->where('tb_users.is_active', 1);
			}
			if ($type == 'inactive') {
				
				$this->db->where('tb_users.is_active', 0);
				$this->db->order_by('tb_employee.date_updated','DESC');
			}
			$this->db->where('tb_users.account_type', 2);
			
			$query = $this->db->get();
			
			if($keyword != FALSE)
			{
				return  $response = array(
							"data" => $query->result_array(),
							"limit" => $limit,
							"filtered" => $this->getTotalRows($id, $keyword, $region, $category, $type),
							);

			}
			if($region != FALSE)
			{
				return  $response = array(
					"data" => $query->result_array(),
					"limit" => $limit,
					"filtered" => $this->getTotalRows($id, $keyword, $region, $category, $type),
					
					);
			}
			if($category != FALSE)
			{
				return  $response = array(
					"data" => $query->result_array(),
					"limit" => $limit,
					"filtered" => $this->getTotalRows($id, $keyword, $region, $category, $type),
					
					);
			}
			else
			{
				return  $response = array(
							"data" => $query->result_array(),
							"limit" => $limit,
							"filtered" => $this->getTotalRows($id, $keyword, $region, $category, $type),
							
							);
			}
		}
		else
		{
			$query = $this->db->select("*, tb_employee.user_id, tb_users.email, tb_users.mobile_num, tb_region.region_name AS province, tb_cities.city_name AS city, tb_category.category_name AS category")
								->from('tb_employee')
								->join('tb_users','tb_users.user_id = tb_employee.user_id', 'left')
								->join('tb_work_history', 'tb_work_history.user_id = tb_employee.user_id', 'left')
								->join('tb_region','tb_region.id = tb_employee.province_1','left')
								->join('tb_cities','tb_cities.id = tb_employee.city_1','left')
								->join('tb_category','tb_category.id = tb_employee.job_category','left')
								->where('tb_employee.user_id', $id)
								->get();
			return $query->row_array();					
		}
		
	}

	public function get_work_history($userid = FALSE, $wid = FALSE)
	{
		if($wid != FALSE)
		{
			$query = $this->db->where('id', $wid)->get('tb_work_history');

			return $query->row_array();
		}
		else{
			$query = $this->db->where('user_id',$userid)->order_by('work_start','DESC')->get('tb_work_history');

			return $query->result_array();
		}
	}

	public function create_work_history($data = array())
	{
		$this->db->insert('tb_work_history', $data);
		
		return $this->db->insert_id();	
	}

	
	public function update_work_history($user_id, $wid, $data = array())
	{
		$this->db->where('id',$wid)->where('user_id', $user_id)->update('tb_work_history', $data);
		
		return TRUE;
	}

	public function delete_work_history($user_id, $wid)
	{	
		$this->db->where('id', $wid);
		$this->db->where('user_id', $user_id);
		$this->db->delete('tb_work_history'); 

		return TRUE;
	}	

	public function find($id)
	{

		$query = $this->db->where('id',$id)->get('tb_users');

		return $query->row_array();
	}

	public function get_total_rows($user_id, $status)
	{
		$query = $this->db->select("*, tb_jobpost.id AS job_id, tb_employer.id AS company_id, tb_employer.user_id")
							->from('tb_verification')
							->join('tb_jobpost', 'tb_jobpost.id = tb_verification.job_id','left')
							->join('tb_category','tb_category.id = tb_jobpost.category','left')
							->join('tb_employer', 'tb_employer.user_id = tb_jobpost.user_id','left')
							->where('tb_verification.user_id', $user_id)
							->where('tb_verification.status', $status)
							->get();

		return $query->num_rows();					
	}

	public function get_jobs($user_id, $status, $offset = FALSE)
	{
		$limit = 10;

		$query = $this->db->select("*,tb_verification.id AS vid ,tb_jobpost.id AS job_id, tb_employer.id AS company_id, tb_employer.user_id, tb_verification.status AS vstatus, tb_region.region_name AS province, tb_cities.city_name AS city")
							->from('tb_verification')
							->join('tb_jobpost', 'tb_jobpost.id = tb_verification.job_id','left')
							->join('tb_category','tb_category.id = tb_jobpost.category','left')
							->join('tb_employer', 'tb_employer.user_id = tb_jobpost.user_id','left')
							->join('tb_region', 'tb_region.id = tb_jobpost.location_id')
							->join('tb_cities', 'tb_cities.id = tb_jobpost.city_id')
							->where('tb_verification.user_id', $user_id)
							->where('tb_verification.status', $status)
							->limit($limit, $offset)
							->get();
		return $result = array(
							"data" => $query->result_array(),
							"filtered" => $this->get_total_rows($user_id, $status),
							"limit" => $limit
							);
	}

	public function setAsSeen($id)
	{
		$data['seen'] = 1;

		$this->where('job_id', $id)->update('tb_verification', $data);

		return TRUE;
	}

	public function updateEmail($user_id, $newEmail)
	{
		$data['email'] = $newEmail;
		$this->db->where('user_id',$user_id)->update('tb_users', $data);
		return TRUE;
	}

	public function updateMobile($user_id, $new_mobile)
	{
		$data['mobile_num'] = $new_mobile;
		$this->db->where('user_id',$user_id)->update('tb_users', $data);
		return TRUE;
	}

	
	public function updatePassword($user_id, $new_password)
	{
		$data['password'] = $new_password;
		$this->db->where('user_id',$user_id)->update('tb_users', $data);
		return TRUE;
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
		$data['is_active'] = 0;

		$this->db->where('user_id', $id)->update('tb_users', $data);

		return TRUE;
	}

	public function getUserWorkHistory($userid)
	{
		$query = $this->db->where('user_id',$userid)->order_by('work_start','DESC')->limit(3)->get('tb_work_history');

		return $query->result();
	}

	public function getUserWorkHistoryDetails($id)
	{
		$query = $this->db->where('id',$id)->get('tb_work_history');

		return $query->row();
	}


	public function deleteApplication($id)
	{
		$this->db->delete('tb_verification', array('id' => $id)); 

		return TRUE;
	}

	public function deleteAccount($id)
	{
		$this->db->delete('tb_employee', array('user_id' => $id)); 
		$this->db->delete('tb_users', array('user_id' => $id));
		$this->db->delete('tb_work_history', array('user_id' => $id));
		$this->db->delete('tb_verification', array('user_id' => $id));
		return TRUE;
	}
}	