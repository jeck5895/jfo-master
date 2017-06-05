<?php
	if (! defined('BASEPATH')) exit('No direct script access allowed');
	class Function_model extends CI_Model{
		
		public function __construct(){
	
			parent:: __construct();	
		}

		public function get_smtp_acct()
		{
			$query = $this->db->get('tb_email_settings');

			return $query->row();
		}

	}	