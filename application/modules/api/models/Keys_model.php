<?php defined("BASEPATH") OR exit("No Direct script access allowed");

class Keys_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}

	public function get($id = FALSE)
	{
		if($id === FALSE)
		{
			$query = $this->db->select("*, tb_employee.user_id, tb_users.email, tb_users.mobile_num")
								->from('tb_employee')
								->join('tb_users','tb_users.user_id = tb_employee.user_id', 'left')
								->get();

			return $query->result_array();
		}
		else
		{
			$query = $this->db->select("*, tb_employee.user_id, tb_users.email, tb_users.mobile_num")
								->from('tb_employee')
								->join('tb_users','tb_users.user_id = tb_employee.user_id', 'left')
								->where('tb_employee.user_id', $id)
								->get();
			return $query->result_array();					
		}
		
	}

	public function find($id)
	{

		$query = $this->db->where('id',$id)->get('tb_users');

		return $query->row_array();
	}

	public function get_user_key($user_id)
	{
		$query = $this->db->where('user_id',$user_id)->get('keys');

		return $query->result();
	}

}	