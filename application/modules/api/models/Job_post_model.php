<?php defined("BASEPATH") OR exit("No Direct script access allowed");

class Job_post_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
		date_default_timezone_set("Asia/Manila");
	}

	public function getTotalRows($status, $emp_id = FALSE)
	{
		$this->db->select("*, tb_jobpost.id AS job_id, tb_employer.id AS company_id, tb_employer.user_id");
		$this->db->from('tb_jobpost');
		$this->db->join('tb_employer','tb_employer.user_id = tb_jobpost.user_id', 'left');
		$this->db->join('tb_category','tb_category.id = tb_jobpost.category','left');
		
		if($status == "pending"){

			$this->db->where('tb_jobpost.status', 0);
			$this->db->where('tb_jobpost.status_1', 0);
			$this->db->where('tb_jobpost.is_active', 1);
		}
		if($status == "published"){

			$this->db->where('tb_jobpost.status', 1);
			$this->db->where('tb_jobpost.status_1', 1);
			$this->db->where('tb_jobpost.is_active', 1);
			$this->db->where('tb_jobpost.job_closedate >=', date('Y-m-d h:i:s'));
		}
		if($status == "declined"){

			$this->db->where('tb_jobpost.status', 0);
			$this->db->where('tb_jobpost.status_1', 1);
			$this->db->where('tb_jobpost.is_active', 1);

		}

		if($status == "expired"){

			$this->db->where('tb_jobpost.status', 1);
			$this->db->where('tb_jobpost.status_1', 1);
			$this->db->where('tb_jobpost.is_active', 1);
			$this->db->where('tb_jobpost.job_closedate <=', date('Y-m-d h:i:s'));
		}

		if($emp_id != FALSE){
			$this->db->where('tb_jobpost.user_id', $emp_id);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}


	public function get($id = FALSE, $limit = FALSE, $offset = FALSE, $keyword = FALSE, $region = FALSE, $category = FALSE, $job_status = FALSE, $cid = FALSE, $ex = FALSE, $emp_id = FALSE, $applicant_id = FALSE)
	{
		
		$keyword = ($keyword != FALSE)? $keyword : NULL;
		$sql = '(tb_jobpost.job_position LIKE "%'.$keyword.'%" OR tb_employer.company_name LIKE "%'.$keyword.'%" OR tb_jobpost.salary_range1 LIKE "%'.$keyword.'%" OR tb_jobpost.salary_range2 LIKE "%'.$keyword.'%" OR tb_category.category_name LIKE "%'.$keyword.'%" OR tb_region.region_name LIKE "%'.$keyword.'%" OR tb_cities.city_name LIKE "%'.$keyword.'%")';
		$result = array();

		if($id === FALSE)
		{

			$this->db->select("*, tb_jobpost.id AS job_id, tb_employer.id AS company_id, tb_employer.user_id, tb_region.id AS region_id, tb_cities.id AS city_id, tb_cities.city_name AS city_1, tb_region.region_name AS province_1");
			$this->db->from('tb_jobpost');
			$this->db->join('tb_employer','tb_employer.user_id = tb_jobpost.user_id', 'left');
			$this->db->join('tb_category','tb_category.id = tb_jobpost.category','left');
			$this->db->join('tb_region', 'tb_region.id = tb_jobpost.location_id');
			$this->db->join('tb_cities', 'tb_cities.id = tb_jobpost.city_id');

			if($keyword != FALSE)
			{
				$this->db->where($sql);
			}
			if($region != FALSE)
			{
				$this->db->where('tb_jobpost.location_id', $region);
			}

			if($category != FALSE)
			{
				$this->db->where('tb_jobpost.category', $category);
			}

			if($job_status == "pending"){
				
				$this->db->where('tb_jobpost.status', 0);
				$this->db->where('tb_jobpost.status_1', 0);
				$this->db->where('tb_jobpost.is_active', 1);
			}
			if($job_status == "published"){
		
				$this->db->where('tb_jobpost.status', 1);
				$this->db->where('tb_jobpost.status_1', 1);
				$this->db->where('tb_jobpost.is_active', 1);
				$this->db->where('tb_jobpost.job_closedate >=', date('Y-m-d h:i:s'));
			}
			if($job_status == "declined"){
				
				$this->db->where('tb_jobpost.status', 0);
				$this->db->where('tb_jobpost.status_1', 1);
				$this->db->where('tb_jobpost.is_active', 1);
				
			}

			if($job_status == "trash")
			{
				$this->db->where('tb_jobpost.status', 0);
				$this->db->where('tb_jobpost.status_1', 0);
				$this->db->where('tb_jobpost.is_active', 0);
			}
			
			if($job_status == "expired"){
				
				$this->db->where('tb_jobpost.status', 1);
				$this->db->where('tb_jobpost.status_1', 1);
				$this->db->where('tb_jobpost.is_active', 1);
				$this->db->where('tb_jobpost.job_closedate <=', date('Y-m-d h:i:s'));
			}

			if($cid != FALSE){
				$this->db->where('tb_employer.id', $cid);
			}

			//for filtering jobs based on category of a specific job
			if($ex != FALSE){ 
				$this->db->where('tb_jobpost.id !=', $ex);
			}

			if($emp_id != FALSE){
				$this->db->where('tb_jobpost.user_id', $emp_id);
			}

			if($limit != FALSE){
				$this->db->limit($limit, $offset);  
			}
			
			$this->db->order_by('tb_jobpost.job_opendate','DESC');
			$query = $this->db->get();

			if($keyword != FALSE)
			{
				return $result = array(
							"data" => $query->result_array(),
							"filtered" => $query->num_rows(),
							"query_string" => $this->db->last_query()
							);
			}
			if($region != FALSE)
			{
				return  $response = array(
					"data" => $query->result_array(),
					// "limit" => $limit,
					"filtered" => $query->num_rows(),
					"query_string" => $this->db->last_query()
					);
			}
			if($category != FALSE)
			{
				return  $response = array(
					"data" => $query->result_array(),
					// "limit" => $limit,
					"filtered" => $query->num_rows(),
					"query_string" => $this->db->last_query()
					);
			}
			if($emp_id != FALSE)
			{
				return  $response = array(
					"data" => $query->result_array(),
					"filtered" => $query->num_rows(),
					"query_string" => $this->db->last_query()
				);
			}
			else
			{
				return $result = array(
							"data" => $query->result_array(),
							"filtered" => $this->getTotalRows($job_status),
							"query_string" => $this->db->last_query()
							);
			}		

		}
		else
		{
			$query = $this->db->select("*, tb_jobpost.id AS job_id, tb_employer.id AS company_id,tb_employer.user_id, tb_region.id AS region_id, tb_cities.id AS city_id, tb_cities.city_name AS city_1, tb_region.region_name AS province_1")
								->from('tb_jobpost')
								->join('tb_employer','tb_employer.user_id = tb_jobpost.user_id', 'left')
								->join('tb_category','tb_category.id = tb_jobpost.category','left')
								->join('tb_region', 'tb_region.id = tb_jobpost.location_id')
								->join('tb_cities', 'tb_cities.id = tb_jobpost.city_id')
								->where('tb_jobpost.id', $id)
								->get();
			return $query->row_array();					
		}
		
	}

	public function find($id)
	{

		$query = $this->db->where('id',$id)->get('tb_users');

		return $query->row_array();
	}

	public function tagAsReviewed($id)
	{
		$data['status'] = 3; 
		$this->db->where('id', $id)->update('tb_verification',$data);

		return TRUE;
	}

	public function tagForInterview($id)
	{

		$data['status'] = 5; 
		$this->db->where('id', $id)->update('tb_verification',$data);

		return TRUE;
	}

	public function tagAsReject($id)
	{
		$data['status'] = 4; 
		$this->db->where('id', $id)->update('tb_verification',$data);

		return TRUE;
	}

	public function apply($data)
	{
		$this->db->insert('tb_verification', $data);

		return TRUE;
	}

	public function jobHasApplicants($job_id, $user_id)
	{
		$this->db->select("*");
		$this->db->from('tb_verification');
		$this->db->where('job_id', $job_id);
		$this->db->where('user_id', $user_id);
		$query=$this->db->get();
		
		return ($query->num_rows() != 0)? TRUE: FALSE;
	}

	public function getJobVerification($job_id, $user_id)
	{
		$this->db->select("*");
		$this->db->from('tb_verification');
		$this->db->where('job_id', $job_id);
		$this->db->where('user_id', $user_id);
		$query=$this->db->get();
		
		return $query->row();
	}

	public function applyStatus($job_id, $user_id)
	{
		$query = $this->db->select("status")
								->from('tb_verification')
								->where('job_id', $job_id)
								->where('user_id', $user_id)
								->get();
		$data = $query->row_array();	
		return $data['status'];
	}	

	public function withdraw($data)
	{
		$this->db->where('id', $data['id'])->where('user_id', $data['user_id'])->update('tb_verification',$data);

		return TRUE;
	}

	public function reapply($data)
	{
		$this->db->where('id', $data['id'])->where('user_id', $data['user_id'])->update('tb_verification',$data);

		return TRUE;
	}

	public function create($data)
	{
		$query = $this->db->insert("tb_jobpost", $data);

		return $this->db->insert_id();

	}

	public function update($id, $data)
	{
		$this->db->where('id', $id)->update('tb_jobpost',$data);

		return TRUE;
	}

	public function delete($job_id)
	{
		$this->db->delete('tb_jobpost', array('id' => $job_id)); 

		return TRUE;
	}

	public function approve($id)
	{
		$job = $this->get($id);
		$duration = $job['expiration'];
		$date_created = $job['date_create'];

		$data['status'] = 1;
		$data['status_1'] = 1;
		$data['is_active'] = 1;
		$data['job_opendate'] = date('Y-m-d H:i:s');
		$data['job_closedate'] = date('Y-m-d H:i:s', strtotime($data['job_opendate']. " + ". $duration ." months"));
		
		$this->db->where('id', $id)->update('tb_jobpost', $data);
		
		return TRUE;
	}

	public function decline($id)
	{
		$data['status'] = 0;
		$data['status_1'] = 1;
		$data['is_active'] = 1;

		$this->db->where('id', $id)->update('tb_jobpost', $data);

		return TRUE;
	}

	public function trash($id)
	{
		$data['status'] = 0;
		$data['status_1'] = 0;
		$data['is_active'] = 0;

		$this->db->where('id', $id)->update('tb_jobpost', $data);

		return TRUE;
	}

	public function review($id)
	{
		$data['status'] = 0;
		$data['status_1'] = 0;
		$data['is_active'] = 1;

		$this->db->where('id', $id)->update('tb_jobpost', $data);

		return TRUE;
	}

	public function get_categories($id = FALSE)
	{
		if($id === FALSE)
		{
			$this->db->select('*');
			$this->db->from('tb_category');
			$this->db->where('is_active',1);
			$query = $this->db->get();

			return $query->result_array();
		}
		else{
			$this->db->select('*');
			$this->db->from('tb_category');
			$this->db->where('is_active',1);
			$this->db->where('id', $id);
			$query = $this->db->get();

			return $query->row_array();
		}
	}

	public function get_positions($id = FALSE, $category_id = FALSE)
	{
		if($id === FALSE && $category_id == FALSE)
		{
			$this->db->select('*');
			$this->db->from('tb_position');
			$this->db->where('is_active',1);
			$query = $this->db->get();

			return $query->result_array();
		}
		if($category_id != FALSE)
		{
			$query = $this->db->select('tb_position.id, name')
			->from('tb_position')
			->join('tb_category','tb_category.id = tb_position.category_id','inner')
			->where('tb_position.category_id',$category_id)
			->where('tb_position.is_active',1)
			->order_by('tb_position.name','ASC')
			->get();

			return $query->result();
		}
		else{
			$this->db->select('*');
			$this->db->from('tb_position');
			$this->db->where('is_active',1);
			$this->db->where('id', $id);
			$query = $this->db->get();

			return $query->row_array();
		}
	}

	public function createCategory($data = array())
	{
		$this->db->insert('tb_category', $data);

		return TRUE;
	}

	public function updateCategory($id, $data = array())
	{
		$this->db->where('id', $id)->update('tb_category', $data);

		return TRUE;
	}

	public function disableCategory($id)
	{
		$this->db->delete('tb_category', array('id' => $id)); 

		return TRUE;
	}

	public function createPosition($data = array())
	{
		$this->db->insert('tb_position', $data);

		return TRUE;
	}

	public function updatePosition($id, $data = array())
	{
		$this->db->where('id', $id)->update('tb_position', $data);

		return TRUE;
	}

	public function disablePosition($id)
	{
		$this->db->delete('tb_position', array('id' => $id)); 

		return TRUE;
	}

	public function getJobStatus()
	{
		$query = $this->db->where('id !=',4)->get('tb_status');

		return $query->result_array();
	}

	public function getTotalJobsByLocation($location_id)
	{
		$query = $this->db->where('location_id',$location_id)
				->where('status', 1)
				->where('status_1', 1)
				->where('is_active', 1)
				->where('job_closedate >=', date('Y-m-d h:i:s'))
				->get('tb_jobpost');

		return $query->num_rows();
	}
}	