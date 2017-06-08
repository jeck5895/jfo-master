<?php defined("BASEPATH") OR exit("No Direct script access allowed");
	
	
	class Datatable_logs_model extends CI_Model{
		
		var $table = 'tb_audit_logs';
		var $column = array('tb_audit_logs.id','tb_audit_action.action_name','tb_audit_logs.table_name','tb_audit_logs.record_id','tb_audit_logs.ip_address','tb_audit_logs.date'); 
		var $order = array('tb_audit_logs.id' => 'ASC');

		public function __construct(){
	
			parent:: __construct();
		}

		private function _get_datatables_query()
	    {
	    	$sql = '(tb_employee.first_name LIKE "%'.$_POST['search']['value'].'%" OR tb_employee.last_name LIKE "%'. $_POST['search']['value'].'%" OR tb_employer.last_name LIKE "%'. $_POST['search']['value'].'%" OR tb_employer.last_name LIKE "%'. $_POST['search']['value'].'%" OR tb_sri_account.last_name LIKE "%'. $_POST['search']['value'].'%" OR tb_sri_account.first_name LIKE "%'. $_POST['search']['value'].'%" OR tb_audit_action.action_name LIKE "%'. $_POST['search']['value'].'%" OR tb_audit_logs.table_name LIKE "%'. $_POST['search']['value'].'%" OR tb_audit_logs.ip_address LIKE "%'. $_POST['search']['value'].'%")';
	         
	        $this->db->select('*, tb_audit_logs.id AS id, tb_sri_account.first_name AS afname, tb_sri_account.last_name AS alname, tb_employer.first_name AS erfname, tb_employer.last_name AS erlname, tb_employee.first_name AS emfname, tb_employee.last_name AS emlname');
			$this->db->from($this->table);
			$this->db->join('tb_audit_action','tb_audit_action.id = tb_audit_logs.audit_action','left');
			$this->db->join('tb_users','tb_users.user_id = tb_audit_logs.user_id','left');
			
			$this->db->join('tb_employee', 'tb_employee.user_id = tb_users.user_id','left');

			$this->db->join('tb_employer', 'tb_employer.user_id = tb_users.user_id','left');
			
			$this->db->join('tb_sri_account', 'tb_sri_account.user_id = tb_users.user_id','left');

			$this->db->where('tb_audit_logs.is_active', 1);

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