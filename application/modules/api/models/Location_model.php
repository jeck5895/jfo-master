<?php
defined("BASEPATH") OR exit("No Direct script access allowed");

class Location_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}

	public function get($id = FALSE)
	{
		if($id === FALSE)
		{
			$query = $this->db->select("*")
								->from('tb_region')
								->where('is_active', 1)
								->get();

			return $query->result_array();
		}
		else
		{
			$query = $this->db->select("*")
								->from('tb_region')
								->where('id', $id)
								->get();
			return $query->result_array();					
		}
		
	}

	public function getCity($id = FALSE, $rid = FALSE)
	{
		if($id === FALSE && $rid === FALSE)
		{
			$query = $this->db->select("*")
								->from('tb_cities')
								// ->where('is_active', 1)
								->get();

			return $query->result_array();
		}
		if($id != FALSE)
		{
			$query = $this->db->select("*")
								->from('tb_cities')
								->where('id', $id)
								->get();
			return $query->result_array();					
		}
		if($rid != FALSE)
		{
			$query = $this->db->select("*")
								->from('tb_cities')
								->where('region_id', $rid)
								->get();
			return $query->result_array();	
		}
	}

	public function find($id)
	{

		$query = $this->db->where('id',$id)->get('tb_users');

		return $query->row_array();
	}
}	