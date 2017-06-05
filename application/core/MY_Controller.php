<?php 
	
	class MY_Controller extends MX_Controller{

		function __construct()
		{
			date_default_timezone_set('Asia/Manila');
			parent::__construct();
			$this->load->module(['Template']);
			$this->load->library('form_validation');
			$this->form_validation->CI =& $this;
		}
		/**
			All functions that will be place here can be used in all controllers

			NOTE: PROCESSING WILL BE A LOT OF WORK LOAD THAT MIGHT DECREASED PERFORMANCE
		*/

		/** Template */

		public function loadHomePage($title, $data)
		{
			$this->load->view('template/header', $title);
			$this->load->view('template/navigation');
			$this->load->view('contents/cover_page',$data);
			$this->load->view('template/footer');
		}

		public function loadAuthPage($title, $page, $data)
		{
			$this->load->view('auth-template/auth_header', $title);
			$this->load->view('auth-template/auth_navigation');
			$this->load->view($page,$data);
			$this->load->view('auth-template/auth_footer');
		}

		public function loadMainPage($title, $userdata = NULL, $page, $data)
		{
			$this->load->view('template/header',$title);
			$this->load->view('template/v_navigation_default', $userdata);
			$this->load->view($page, $data);
			$this->load->view('template/footer');
		}

		function formToken()
		{
			$token = md5(uniqid(rand(), true));

			$this->session->set_userdata('form_token',$token);

			return $token;
		}

		function userToken()
		{
			$token = hash("sha256", md5(uniqid(rand(), true)));

			return $token;
		} 	
	}
?>