<?php defined("BASEPATH") OR exit("No Direct script access allowed");

class Notification_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}
	
	public function create($data = array())
	{
		$this->db->insert("tb_notification", $data);

		return $this->db->insert_id();
	}
}	