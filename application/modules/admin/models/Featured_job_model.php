<?php defined("BASEPATH") OR exit("No Direct script access allowed");
	
	
	class Featured_job_model extends CI_Model{
		
		var $table = 'tb_featured_post';
		var $column = array('tb_featured_post.id',
							'company_name',
							'tb_featured_post.job_position', 
							'tb_featured_post.start_date', 
							'tb_featured_post.end_date', 
							'tb_featured_post.date_created', 
							'tb_featured_post.is_active',
							'tb_jobpost.location_id'); 
		var $order = array('tb_position.id' => 'ASC');

		public function __construct(){
	
			parent:: __construct();
		}

		private function _get_datatables_query()
	    {
	    	$sql = '(tb_featured_post.id LIKE "%'.$_POST['search']['value'].'%" OR tb_employer.company_name LIKE "%'. $_POST['search']['value'].'%" OR tb_jobpost.job_position LIKE "%'.$_POST['search']['value'].'%" OR tb_featured_post.start_date LIKE "%'.$_POST['search']['value'].'%" OR tb_featured_post.end_date LIKE "%'.$_POST['search']['value'].'%")';
	         
	        $this->db->select('*, tb_featured_post.id AS id, ,tb_featured_post.is_active AS is_active');
			$this->db->from($this->table);
			$this->db->join('tb_employer','tb_employer.id = tb_featured_post.company_id');
			$this->db->join('tb_jobpost', 'tb_jobpost.id = tb_featured_post.job_position');

			$i = 0;

			foreach ($this->column as $item) 
			{
				$column[$i] = $item;
				$i++;
			}

			
			if( $_POST['search']['value'])
			{
				$this->db->where($sql);
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

	    function get_datatables()
	    {
	    	$this->_get_datatables_query();
	    	if($_POST['length'] != -1)
	    		$this->db->limit($_POST['length'], $_POST['start']);
	    	$query = $this->db->get();
	    	return $query->result();
	    }


	    function count_filtered()
	    {
	    	$this->_get_datatables_query();
	    	$query = $this->db->get();
	    	return $query->num_rows();
	    }

	    function get_query()
	    {
	    	$this->_get_datatables_query();
	    	$query = $this->db->get();
	    	return $this->db->last_query();
	    }

	    public function count_all()
	    {
	    	$this->db->from($this->table);
	    	return $this->db->count_all_results();
	    }

	}	