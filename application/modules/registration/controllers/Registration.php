<?php 
	defined('BASEPATH') Or Exit ('No direct script access allowed');

	/**
	* 
	*/
	class Registration extends MY_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('Registration_model','reg_model');
			$this->load->model('api/auth_model');
			$this->load->module('functions/functions');
			date_default_timezone_set('Asia/Manila');
			/** $this->load->model('Authenticate/Authenticate_model'); to load model model from another module*/
		}

		public function view_applicant_registration()
		{
			if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
			{
				$user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
				if($user->account_type == 1)
				{	
					redirect('admin/jobs/review');
				}
				if($user->account_type == 2)
				{
					redirect('applicant/applications/pending');
				}
				if($user->account_type == 3)
				{
					redirect('company/applicants/all');
				}
			}

			$page_title['title'] = 'Sign-up | Job Seeker ';
			$data['token'] = $this->formToken();
 			$data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
 			$userdata['user'] =  NULL; 
 			$data['regions'] =  $this->reg_model->getLocation();
 			$data['religions'] = $this->reg_model->get_religion();
			$this->loadMainPage($page_title, $userdata,'applicant-registration/applicant_registration_form',$data);			
		}

		public function view_employer_registration()
		{
			if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
			{
				$user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
				if($user->account_type == 1)
				{	
					redirect('admin/jobs/review');
				}
				if($user->account_type == 2)
				{
					redirect('applicant/applications/pending');
				}
				if($user->account_type == 3)
				{
					redirect('company/applicants/all');
				}
			}

			$data['token'] = $this->formToken();
			$data['industries'] = $this->reg_model->get_company_industry();
			$data['regions'] =  $this->reg_model->getLocation();
			$data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
			$page_title['title'] = 'Sign-up  | Employer';
			$this->loadMainPage($page_title, $userdata = NULL,'employer-registration/employer_registration_form',$data);
			//$this->loadMainPage($page_title, $userdata = NULL,'employer-registration/employer_registration',$data);
		}

		public function check_password_length()
		{
			$password = $this->input->post('password');
			$length = strlen($password);

			if($length >= 8)
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('check_password_length','Password must be at least 8 characters');
				return FALSE;
			}
		}

		public function check_password_strength()
		{
			$password = $this->input->post('password');
			if(preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/",$password))
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('check_password_strength','Password must contain at least one character, digit, symbol and is combination of small and capital letters');
				return FALSE;
			}
		}
		

		public function display_session()
		{
			echo "<pre>";
			var_dump($this->session->userdata('active_applicant'));
			echo "</pre>";
			echo "<pre>";
			var_dump($this->session->userdata('active_admin'));
			echo "</pre>";
			echo "<pre>";
			var_dump($this->session->userdata('active_employer'));
			echo "</pre>";
			echo "<pre>";
			var_dump($this->session->userdata('social_profile'));
			echo "</pre>";
			echo "<pre>";
			var_dump($this->session->userdata('user_token'));
			echo "</pre>";
			echo "<pre>";
			var_dump($this->session->userdata('form_token'));
			echo "</pre>";

			echo "<pre>";
			var_dump($_COOKIE);
			echo "</pre>";
			
		}

	}