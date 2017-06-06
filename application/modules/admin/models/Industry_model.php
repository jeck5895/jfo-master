<?php defined("BASEPATH") OR exit("No Direct script access allowed");
	
	
	class Industry_model extends CI_Model{
		
		var $table = 'tb_industry';
		var $column = array('tb_industry.id','tb_industry.industry_name'); 
		var $order = array('tb_industry.id' => 'ASC');

		public function __construct(){
	
			parent:: __construct();
		}

		private function _get_datatables_query()
	    {
	    	$sql = '(tb_industry.industry_name LIKE "%'. $_POST['search']['value'].'%")';
	         
	        $this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('tb_industry.is_active', 1);

			$i = 0;

			foreach ($this->column as $item) 
			{
				//if($_POST['search']['value'])
				//	($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
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