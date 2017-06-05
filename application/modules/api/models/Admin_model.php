<?php defined("BASEPATH") OR exit("No Direct script access allowed");

class Admin_model extends CI_Model{

	public function __construct(){

		parent:: __construct();
	}
	
	public function create($admin_info = array(), $admin_acct = array())
	{
		$this->db->insert('tb_sri_account', $admin_info);
		$this->db->insert('tb_users', $admin_acct);

		return $this->db->insert_id();
	}

	public function update($id, $data = array())
	{
		$this->db->where('user_id', $id)->update('tb_sri_account', $data);

		return TRUE;
	}
	
	public function updateAccount($user_id, $data)
	{
		$this->db->where('user_id',$user_id)->update('tb_users', $data);
		return TRUE;
	}

	public function saveAdvertisement($data = array())
	{
		$this->db->insert('tb_advertisement', $data);

		return $this->db->insert_id();
	}

	public function saveFeaturedJob($data = array())
	{
		$this->db->insert('tb_featured_post', $data);

		return $this->db->insert_id();
	}

	public function getAdvertisementSlider($id = FALSE)
	{
		if($id == FALSE)
		{
			$query = $this->db->where('is_active',1)->get('tb_ads_slider');
			return $query->result();
		}
		else{
			$query = $this->db->where('id', $id)->get('tb_ads_slider');
			return $query->row();
		}
	}

	public function getFeaturedJobs($id = FALSE)
	{
		if($id == FALSE)
		{
			$query = $this->db->where('is_active',1)->limit(8)->get('tb_featured_post');
			return $query->result();
		}
		else{
			$query = $this->db->where('id', $id)->get('tb_featured_post');
			return $query->row();
		}
	}

	public function getFeaturedCompanies($id = FALSE)
	{
		if($id == FALSE)
		{
			$this->db->select('*, tb_featured_companies.id AS id, tb_featured_companies.is_active AS is_active, tb_employer.id AS cid');
			$this->db->join('tb_employer','tb_employer.id = tb_featured_companies.company_id');
			$this->db->join('tb_industry','tb_industry.id = tb_employer.industry');
			$this->db->join('tb_region', 'tb_region.id = tb_employer.province_1');
			$this->db->join('tb_cities', 'tb_cities.id = tb_employer.city_1');
			$this->db->where('tb_featured_companies.is_active',1);
			$this->db->limit(10);
			$query = $this->db->get('tb_featured_companies');
			return $query->result();
		}
		else{
			$query = $this->db->where('id', $id)->get('tb_featured_companies');
			return $query->row();
		}
	}

	public function saveAdvertisementSlider($data = array())
	{
		$this->db->insert('tb_ads_slider', $data);

		return $this->db->insert_id();
	}

	public function saveFeaturedCompany($data = array())
	{
		$this->db->insert('tb_featured_companies', $data);

		return $this->db->insert_id();
	}

	public function isCompanyExists($id)
	{
		$query = $this->db->where('company_id', $id)->get('tb_featured_companies');

		return $query->row();
	}

	public function updateAdvertisementSlider($id, $data = array())
	{
		$this->db->where('id', $id)->update('tb_ads_slider', $data);

		return TRUE;
	}

	public function updateFeaturedJob($id, $data = array())
	{
		$this->db->where('id', $id)->update('tb_featured_post', $data);

		return TRUE;
	}

	public function updateFeaturedCompany($id, $data = array())
	{
		$this->db->where('id', $id)->update('tb_featured_companies', $data);

		return TRUE;
	}

	public function deleteErrorUpload($id)
	{
		$this->db->delete('tb_ads_slider', array('id' => $id)); 

		return TRUE;
	}

	public function deleteFeaturedJob($id)
	{
		$this->db->delete('tb_featured_post', array('id' => $id));

		return TRUE;
	}

	public function deleteFeaturedCompany($id)
	{
		$this->db->delete('tb_featured_companies', array('id' => $id));

		return TRUE;
	}

	public function updateAdvertisement($id, $data = array())
	{
		$this->db->where('id', $id)->update('tb_advertisement', $data);

		return TRUE;
	}


	public function saveBanner($banner)
	{
		$this->db->insert('tb_jobfair', $banner);

		return $this->db->insert_id();
	}

	public function set_smtp_acct($data = array())
	{
		$query = $this->db->where('id',1)->update('tb_email_settings',$data);

		return TRUE;
	}

	public function get_smtp_acct()
	{
		$query = $this->db->where('id',1)->get('tb_email_settings');

		return $query->row();
	}
}	