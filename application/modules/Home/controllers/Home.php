<?php
	defined("BASEPATH") OR exit ("No direct Script Access allowed");

	class Home extends MY_Controller{

		public function __construct()
		{
			parent::__construct();
			$this->load->model('api/auth_model');
			$this->load->model('employer/employer_model','emp_model');
			$this->load->model('api/admin_model');

		}

		public function index()
		{
			if(isset($_COOKIE['_ut'])){
				$token = $_COOKIE['_ut'];
				
				$user = $this->auth_model->getUserByToken($token);
				
				if(!empty($user) && $user->account_type == 1){
					redirect('admin/review/jobs');
				}	
				if(!empty($user) && $user->account_type == 2){
					redirect('jobs');
				}	
				if(!empty($user) && $user->account_type == 3){
					redirect('company/applicants/dashboard');
				}
			}

			$page_title['title'] = "Job-Fair Online";
			$sliderImages = array();
			$featuredCompanies = array();
			$query = $this->admin_model->getAdvertisementSlider();
			$companies = $this->admin_model->getFeaturedCompanies();
				
				foreach($query as $image)
				{
					$sliderImages[] = array(
						"path" => base_url().str_replace("./", "", $image->upload_path)."/".$image->filename,
						"ads_url" => $image->ads_url,
						"ads_title" => $image->ads_title,
						"company" => $image->company_name,
						);
				}

				foreach($companies as $company)
				{
					$featuredCompanies[] = array(
						"logo" => base_url().str_replace("./", "", $company->profile_pic),
						"company" => $company->company_name,
						"location" => $company->city_name.", ".$company->region_name,
						"industry" => $company->industry_name,
						"industry_id" => $company->industry,
						"prov_id" => $company->province_1,
						"city_id" => $company->city_1,
						"cid" => $company->cid
						);
				}
			$data['sliderImages'] = $sliderImages;
			$data['featuredCompanies'] = $featuredCompanies;
			$this->loadHomePage($page_title,$data);
		}

		public function jobs()
		{
			if(isset($_COOKIE['_ut'])){
				$token = $_COOKIE['_ut'];
				
				$user = $this->auth_model->getUserByToken($token);
				
				if(!empty($user) && $user->account_type == 1){
					redirect('admin/review/jobs');
				}	
				if(!empty($user) && $user->account_type == 3){
					redirect('company/applicants/dashboard');
				}
			}
			
			$page_title['title'] = "Job-Fair Online";
			$data = NULL;
			$userdata['user'] = NULL; 

			$featuredJobs = array();
			

			$query = $this->admin_model->getFeaturedJobs();

			foreach($query AS $job){
				$featuredJobs [] = array(
					"company" => $job->company_name,
					"position" => ($job->use_alternative == 1)? $job->alternative_title:$job->job_position,
					"job" => $job->job_description,
					"url" => site_url('jobs/details/'.str_replace("+","-",urlencode(ucfirst($job->job_position))).'-/'.$this->my_encrypt->encode($job->job_id)),
					"company_url" => site_url('companies/'.str_replace("+","-",urlencode(ucfirst($job->company_name))).'-'.$job->company_id),
					"description" => $job->job_description,//substr($job->job_description, 0,50).'....',
					);
			}

			$data['featuredJobs'] = $featuredJobs;

			if(isset($_COOKIE['_ut']) && isset($_COOKIE['_typ']))
			{
				$user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
				$userdata['user'] = $data['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
				$userdata['user_image'] = base_url().str_replace("./", "", $userdata['user']->profile_pic);
			}
		
		
			$this->loadMainPage($page_title, $userdata,'contents/job_posts',$data);
				
		}

		public function company_job_post()
		{
			$page_title['title'] = 'Company | Job Details';
			$page = 'contents/v_full_job_description';
			$userdata['user'] = NULL; 
			$data = NULL;
			if(isset($_COOKIE['_ut']) && isset($_COOKIE['_typ']))
			{
				$user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
				$userdata['user'] = $data['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
				
			}
			$this->loadMainPage($page_title,  $userdata, $page, $data);
		}

		public function company_profile($company_name)
		{
			$page_title['title'] = 'JFO | Company Profile';
			$page = 'contents/v_company_profile_page';
			$data = NULL;
			$userdata['user'] = NULL; 
			
			if(isset($_COOKIE['_ut']) && isset($_COOKIE['_typ']))
			{
				$user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
        		$userdata['user'] = $data['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
			}
			$this->loadMainPage($page_title, $userdata, $page ,$data);
		}

		public function applicant_profile($company_name)
		{
			$page_title['title'] = 'JFO | Company Profile';
			$page = 'contents/v_applicant_profile';
			$data = NULL;
			$userdata['user'] = NULL; 
			
			if(isset($_COOKIE['_ut']) && isset($_COOKIE['_typ']))
			{
				$user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
        		$userdata['user'] = $data['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);

        		if((!empty($user) && $user->account_type == 1) || (!empty($user) && $user->account_type ==3))
        		{
        			$this->loadMainPage($page_title, $userdata, $page ,$data);
        		}
        		else{
        			redirect('');
        		}
			}
			else{
        			redirect('');
        		}
			
		}
	}