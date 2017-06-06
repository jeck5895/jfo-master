<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
	class Log_model extends CI_Model{
		
		public function __construct(){
	
			parent:: __construct();	
		}

		public function save($data = array())
		{
			$this->db->insert('tb_audit_logs',$data);

			return $this->db->insert_id();
		}

		public function get($id = FALSE)
		{
			if($id === FALSE)
			{
				$query = $this->db->get('tb_audit_logs');

				return $query->result();
			}
			else{
				$query = $this->db->where('id',$id)->get('tb_audit_logs');
			}
		}

	}	