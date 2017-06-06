<?php defined("BASEPATH") OR exit("No Direct script access allowed");
	
	
	class Jobs_model extends CI_Model{
		
		var $table = 'tb_jobpost';
		var $column = array('tb_jobpost.id','tb_jobpost.job_position','tb_jobpost.num_vacancies','tb_employer.company_name','tb_employer.first_name','tb_jobpost.job_opendate','tb_jobpost.job_closedate','tb_jobpost.date_create'); 
		var $order = array('tb_jobpost.id' => 'DESC');

		public function __construct(){
	
			parent:: __construct();
		}

		private function _get_datatables_query($status)
	    {
	    	$sql = '(tb_jobpost.id LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.job_position LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.num_vacancies LIKE "%'. $_POST['search']['value'].'%" OR tb_employer.company_name LIKE "%'. $_POST['search']['value'].'%" OR tb_employer.first_name LIKE "%'. $_POST['search']['value'].'%" OR tb_employer.middle_name LIKE "%'. $_POST['search']['value'].'%" OR tb_employer.last_name LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.job_opendate LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.job_closedate LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.date_create LIKE "%'. $_POST['search']['value'].'%")';
	         
	        $this->db->select('*, tb_jobpost.id AS job_id, tb_jobpost.job_position AS job_position, tb_jobpost.num_vacancies AS num_vacancies, tb_employer.company_name AS company_name, CONCAT(tb_employer.first_name," ",tb_employer.middle_name," ",tb_employer.last_name) AS employer_name, tb_jobpost.job_opendate AS job_opendate, tb_jobpost.job_closedate AS job_closedate');
			$this->db->from($this->table);
			$this->db->join('tb_employer', 'tb_employer.user_id = tb_jobpost.user_id', 'left');
			$i = 0;

			foreach ($this->column as $item) 
			{
				//if($_POST['search']['value'])
				//	($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
				$column[$i] = $item;
				$i++;
			}

			if($status == "pending")
			{
				if( $_POST['search']['value'])
				{
					$this->db->where($sql);
				}

				$this->db->where('tb_jobpost.status', 0)->where('tb_jobpost.status_1', 0)->where('tb_jobpost.is_active', 1);// disregard the closedate because it is base upon date approval
			}
			
			if($status == "published")
			{
				if( $_POST['search']['value'])
				{
					$this->db->where($sql);
				}
				$this->db->where('tb_jobpost.status', 1)->where('tb_jobpost.status_1', 1)->where('tb_jobpost.is_active', 1)->where('tb_jobpost.job_closedate >=', date('Y-m-d h:i:s'));
				
			}
			if($status == "declined")
			{
				if( $_POST['search']['value'])
				{
					$this->db->where($sql);
				}
				$this->db->where('tb_jobpost.status', 0)->where('tb_jobpost.status_1', 1)->where('tb_jobpost.is_active', 1);
				
				//remove because it doesnt have close date if it is pending ->where('tb_jobpost.job_closedate >=', date('Y-m-d h:i:s'))
			}
			
			if($status == "trash")
			{
				if( $_POST['search']['value'])
				{
					$this->db->where($sql);
				}
				$this->db->where('tb_jobpost.status', 0)->where('tb_jobpost.status_1', 0)->where('tb_jobpost.is_active', 0);
				
			}
			 
			foreach ($this->column as $item) 
				{
					//if($_POST['search']['value']) WRONG FILTERING OF SEARCH
						//($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
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

	    function get_datatables($status)
	    {
	    	$this->_get_datatables_query($status);
	    	if($_POST['length'] != -1)
	    		$this->db->limit($_POST['length'], $_POST['start']);
	    	$query = $this->db->get();
	    	return $query->result();
	    }


	    function count_filtered($status)
	    {
	    	$this->_get_datatables_query($status);
	    	$query = $this->db->get();
	    	return $query->num_rows();
	    }

	    function get_query($status)
	    {
	    	$this->_get_datatables_query($status);
	    	$query = $this->db->get();
	    	return $this->db->last_query();
	    }

	    public function count_all()
	    {
	    	$this->db->from($this->table);
	    	return $this->db->count_all_results();
	    }

	}	