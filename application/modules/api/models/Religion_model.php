<?php
defined("BASEPATH") OR exit("No Direct script access allowed");

class Religion_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}

	public function get($id = FALSE)
	{
		if($id === FALSE)
		{
			$query = $this->db->select("*")
								->from('tb_religion')
								->where('is_active', 1)
								->get();

			return $query->result_array();
		}
		else
		{
			$query = $this->db->select("*")
								->from('tb_religion')
								->where('id', $id)
								->get();
			return $query->row_array();					
		}
		
	}

	public function create($data)
	{
		$this->db->insert('tb_religion', $data);

		return TRUE;
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id)->update('tb_religion', $data);

		return TRUE;
	}

	public function disableReligion($id)
	{
		$this->db->delete('tb_religion', array('id' => $id)); 

		return TRUE;
	}
}	