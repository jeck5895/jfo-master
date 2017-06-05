<?php
	defined("BASEPATH") OR exit("No Direct script access allowed");
	
	
	class Jobs_review_model extends CI_Model{
		
		var $table = 'tb_jobpost';
		var $column = array('tb_jobpost.id','job_position','num_vacancies','job_opendate','job_closedate','tb_jobpost.date_create'); //this will reflect to column sorting in datatable
		var $order = array('tb_jobpost.id' => 'DESC');

		public function __construct(){
	
			parent:: __construct();
		}

		private function _get_datatables_query($status, $user_id)
	    {
	    	$sql = '(tb_jobpost.id LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.job_position LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.num_vacancies LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.job_opendate LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.job_closedate LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.date_create LIKE "%'. $_POST['search']['value'].'%")';
	         
	        $this->db->select('*, tb_jobpost.id AS job_id');
			$this->db->from($this->table);
			$this->db->join('tb_employer', 'tb_employer.user_id = tb_jobpost.user_id', 'left');
			
			if($status == "pending"){
				if( $_POST['search']['value'])
				{
					$this->db->where($sql);
				}
				$this->db->where('tb_jobpost.status', 0)->where('tb_jobpost.status_1', 0)->where('tb_jobpost.is_active', 1);// disregard the closedate because it is base upon date approval
				$this->db->order_by('tb_jobpost.id','DESC');
			}
			if($status == "published"){
				if( $_POST['search']['value'])
				{
					$this->db->where($sql);
				}
				$this->db->where('tb_jobpost.status', 1)->where('tb_jobpost.status_1', 1)->where('tb_jobpost.is_active', 1)->where('tb_jobpost.job_closedate >=', date('Y-m-d h:i:s'));
				$this->db->order_by('tb_jobpost.job_opendate','DESC');
			}
			if($status == "declined"){
				if( $_POST['search']['value'])
				{
					$this->db->where($sql);
				}
				$this->db->where('tb_jobpost.status', 0)->where('tb_jobpost.status_1', 1)->where('tb_jobpost.is_active', 1);
				$this->db->order_by('tb_jobpost.id','DESC');
				
			}
			
			if($status == "expired"){
				if( $_POST['search']['value'])
				{
					$this->db->where($sql);
				}
				$this->db->where('tb_jobpost.status', 1)->where('tb_jobpost.status_1', 1)->where('tb_jobpost.is_active', 1)->where('tb_jobpost.job_closedate <=', date('Y-m-d h:i:s'));
				$this->db->order_by('tb_jobpost.job_closedate','DESC');
			}
			$this->db->where('tb_jobpost.user_id', $user_id); 

			$i = 0;

			foreach ($this->column as $item) 
			{
				//if($_POST['search']['value'])
				//	($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
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

	    function get_datatables($status, $user_id)
	    {
	    	$this->_get_datatables_query($status, $user_id);
	    	if($_POST['length'] != -1)
	    		$this->db->limit($_POST['length'], $_POST['start']);
	    	$query = $this->db->get();
	    	return $query->result();
	    }


	    function count_filtered($status, $user_id)
	    {
	    	$this->_get_datatables_query($status, $user_id);
	    	$query = $this->db->get();
	    	return $query->num_rows();
	    }


	    public function count_all()
	    {
	    	$this->db->from($this->table);
	    	return $this->db->count_all_results();
	    }

	}	