<?php
defined("BASEPATH") OR exit("No Direct script access allowed");


class Admin_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}

	public function create($admin_acct, $admin_info)
	{
		$this->db->insert("tb_users", $admin_acct);
		$this->db->insert('tb_sri_account', $admin_info);
		return TRUE;
	}

	public function getActiveAdmin($user_id)
	{
		//SELECT tb_sri_account.user_id AS tb_sri_id, tb_users.profile_id AS tb_user_id FROM `tb_users` INNER JOIN tb_sri_account ON tb_sri_account.user_id = tb_users.profile_id
		$query = $this->db->select("*, tb_users.user_id AS user_id, tb_users.email AS email, tb_users.mobile_num AS mobile_num, tb_cities.city_name AS city, tb_region.region_name AS province, tb_sri_account.province AS region_id, tb_sri_account.city AS city_id")
							->from('tb_users')
							->join('tb_sri_account', 'tb_sri_account.user_id = tb_users.user_id')
							->join('tb_region', 'tb_region.id = tb_sri_account.province')
							->join('tb_cities', 'tb_cities.id = tb_sri_account.city')
							->where('tb_users.user_id', $user_id)
							->get();
		return $query->row();					
	}

	public function updateLogo($user_id, $logo)
	{
		$query = $this->db->where('user_id',$user_id)->update('tb_sri_account',$logo);

		return TRUE;
	}
}	
