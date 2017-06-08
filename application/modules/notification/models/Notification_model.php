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

	public function update($id, $data)
	{
		$this->db->where('id',$id)->update('tb_notification',$data);

		return TRUE;
	}

	public function getNotification($user_id, $status = FALSE)
	{
		$this->db->select("*");
		$this->db->from("tb_notification");
		
		if($status != FALSE){
			
			$this->db->where("status",1);
			
		}
		$this->db->where("receiver_id" ,$user_id);
		$this->db->order_by("date_created", "DESC");
		$query = $this->db->get();

		return $query->result();
	}
}	