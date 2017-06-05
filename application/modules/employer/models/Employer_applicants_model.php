<?php
	defined("BASEPATH") OR exit("No Direct script access allowed");
	
	
	class Employer_applicants_model extends CI_Model{
		
		var $table = 'tb_verification';
		var $column = array('tb_jobpost.job_position','tb_verification.status','company_name','tb_employee.first_name','tb_employee.last_name','tb_verification.date_created');
		var $order = array('id' => 'desc');

		public function __construct(){
	
			parent:: __construct();
		}

		private function _get_datatables_query($user)
	    { 
	        $this->db->select('tb_verification.id AS "verification_id", tb_verification.job_id AS "job_id", tb_verification.date_created AS "date_applied", tb_verification.user_id AS "app_id", tb_status.status_name AS "status",tb_jobpost.job_position AS "job_position", tb_employer.company_name AS "company_name", tb_employee.first_name AS "first_name", tb_employee.last_name AS "last_name", tb_employee.profile_pic, tb_employee.age AS "app_age", tb_employee.sex AS "app_gender", tb_employee.city_1, tb_employee.province_1, tb_users.email, tb_users.mobile_num, tb_employee.college_degree, tb_employee.college_name, tb_employee.job_category, tb_employee.job_position AS "app_positions"');
			$this->db->from($this->table);
			$this->db->join('tb_users', 'tb_users.user_id = tb_verification.user_id', 'left');
			$this->db->join('tb_employee', 'tb_employee.user_id = tb_users.user_id', 'left');
			$this->db->join('tb_jobpost', 'tb_jobpost.id = tb_verification.job_id', 'left');
			$this->db->join('tb_employer', 'tb_employer.user_id = tb_jobpost.user_id', 'left');
			$this->db->join('tb_status', 'tb_status.id = tb_verification.status', 'left');
			$this->db->where('tb_verification.is_active', 1);
			$this->db->where('tb_verification.status !=', 4);
			$this->db->where('tb_jobpost.user_id', $user); 
			$this->db->order_by('tb_verification.date_created','DESC');
			$i = 0;

			foreach ($this->column as $item) 
			{
				if($_POST['search']['value'])
					($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
				$column[$i] = $item;
				$i++;
			}

			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}      
	    }

	    function get_datatables($user)
	    {
	    	$this->_get_datatables_query($user);
	    	if($_POST['length'] != -1)
	    		$this->db->limit($_POST['length'], $_POST['start']);
	    	$query = $this->db->get();
	    	return $query->result();
	    }


	    function count_filtered($user)
	    {
	    	$this->_get_datatables_query($user);
	    	$query = $this->db->get();
	    	return $query->num_rows();
	    }


	    public function count_all()
	    {
	    	$this->db->from($this->table);
	    	return $this->db->count_all_results();
	    }

	}	