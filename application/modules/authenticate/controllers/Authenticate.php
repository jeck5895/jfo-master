<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('api/auth_model', 'auth_model');
		$this->load->model('Registration/Registration_model','reg_model');
		$this->load->library(array('my_encrypt','facebookSDK'));
		$this->load->module('functions/functions');
		$this->facebook = $this->facebooksdk;

	}

	public function auth()
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
				redirect('candidates');
			}
			if($user->account_type == 3)
			{
				redirect('company/applicants/all');
			}
		}
		
		$page_title['title'] = "Job-Fair Online | Login";
		$data['token'] = $this->formToken();
		$callback = base_url('login/facebook');
		$data['google_login_url'] = $this->googleplus->loginURL();
		$data['fb_login_url'] = $this->facebook->getLoginUrl($callback);
		//$this->load->view('v_auth',$data);
		$this->loadAuthPage($page_title,'v_auth', $data);
	}

	public function account_recovery()
	{
		$page_title['title'] = "Account Recovery";
		$data['token'] = $this->formToken();

		$this->loadAuthPage($page_title,'v_acct_recovery', $data);
	}

	public function reset_password()
	{
		$ucode = $_GET['ucode'];
		if($ucode == NULL)
		{
			redirect('login');
		}
		else{

			$bool = $this->auth_model->isResetCodeValid($ucode);

			if($bool === TRUE){
				$page_title['title'] = "Change Password";
				$data['token'] = $this->formToken();

				$this->loadAuthPage($page_title,'v_change_password', $data);
			}
			else{
				redirect('login');
			}
		}
	}

	public function employer_account_activate()
	{
		$ucode = $_GET['ucode'];
		$type = $_GET['type'];

		if(($ucode && $type == NULL ) || $type != 3)
		{
			redirect('login');
		}
		else{

			$user = $this->auth_model->isActivationCodeValid($ucode);

			if(!empty($user))
			{	
				if($this->auth_model->activateEmployer($user->user_id, $ucode)){
					$userInfo = $this->auth_model->getUserDetails($user->user_id, 3);
					$expDate = date("Y-m-d H:i:s", strtotime('+1 day'));
					$data['user_id'] = $user->user_id;
					$data['token'] = md5($this->functions->guid().$ucode);
					$data['exp_date'] = $expDate;
					$data['date_created'] = date('Y-m-d H:i:s');
					$data['status'] = 1;

					setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
					setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
					setcookie("_typ", "ep", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

					if($this->auth_model->newUserToken($data) === TRUE){
						redirect(site_url("/company/applicants/dashboard"));
					}
				}
			}
			else{
				redirect('login');
				// echo json_encode($response= array("status"=>FALSE,"403 FORBIDDEN"));
			}
		}
	}

	public function facebook()
	{ 
		//sign in with facebook
		if(isset($_GET['code']))
		{
			$token = $this->facebook->getAccessToken();
			$userProfile = $this->facebook->getUserData($token);
			$userData['oauth_provider'] = 'facebook';
			$userData['oauth_uid'] = $userProfile['id'];
			$userData['first_name'] = $userProfile['first_name'];
			$userData['last_name'] = $userProfile['last_name'];
			$userData['email'] = $userProfile['email'];
			$userData['gender'] = $userProfile['gender'];
			$userData['locale'] = $userProfile['locale'];
			$userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
			$userData['picture_url'] = $userProfile['picture']['url'];

			$this->session->set_userdata('social_profile',$userData);
			$this->session->set_userdata('user_token',(string)$token);
			echo 	"<script> 
							window.close();
							window.opener.location.href = '".base_url('sign-up-with-facebook')."';
					</script>";
		}
		else
		{
			redirect('login');
		}		
	}

	public function login_facebook()
	{
		if(isset($_GET['code']))
		{
			$token = $this->facebook->getAccessToken();
			$userProfile = $this->facebook->getUserData($token);
			$email = $userProfile['email'];
	
			$user = $this->auth_model->getUserByEmail($email);
			

			if(!empty($user))
			{
				$userInfo = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
				$expDate = date("Y-m-d H:i:s", strtotime('+1 day'));
				$data['user_id'] = $user->user_id;
				$data['token'] = md5($this->functions->guid());
				$data['exp_date'] = $expDate;
				$data['date_created'] = date('Y-m-d H:i:s');
				$data['status'] = 1;

				$log['user_id'] = $user->user_id;
				$log['audit_action'] = 3;
				$log['table_name'] = "tb_users";
				$log['record_id'] = $user->user_id;
				$log['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$log['date'] = date('Y-m-d H:i:s');
				$log['is_active'] = 1;
				$log['action_description'] = "Sign-in with Facebook";

				if($user->account_type == 3)
				{
					$boolean = $this->auth_model->isEmailActivated($user->user_id);

					if($boolean === FALSE){
						header('HTTP/1.0 403 Forbidden');

						echo "It seems your email is not verified. Please verify your email first.";
					}
					else{
						
						

						setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
						setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
						setcookie("_typ", "ep", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

						if($this->auth_model->newUserToken($data) === TRUE)
						{
							$this->log_model->save($log);

							echo 	"<script> 
										window.close();
										window.opener.location.href = '".site_url("/company/applicants/dashboard")."';
									</script>";
						}
					}
				}	
					

				if($user->account_type == 2){
					setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
					setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
					setcookie("_uc", $this->my_encrypt->encode($userInfo->job_category), time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
					setcookie("_typ", "ap", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

					if($this->auth_model->newUserToken($data) === TRUE)
					{
						$this->log_model->save($log);

						echo 	"<script> 
							window.close();
							window.opener.location.href = '".site_url("/applicant/applications/pending")."';
						</script>";
					}
				}

				if($user->account_type == 1){
					setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
					setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
					setcookie("_typ", "ad", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

					if($this->auth_model->newUserToken($data) === TRUE)
					{
						$this->log_model->save($log);

						echo 	"<script> 
							window.close();
							window.opener.location.href = '".site_url("/admin/review/jobs")."';
						</script>";
					}
				}

				
			}
			else{
				

				echo "Sorry! Couldn't found any related account. You may <a href='' onclick='return window.close();'><strong>CLOSE</strong></a> this window now";
			}
		}
		else
		{
			redirect('login');
		}		
	}

	public function google()
	{
		$this->googleplus->getAuthenticate();
		if($this->googleplus->getAccessToken())
		{

			$userInfo = $this->googleplus->getUserInfo();
			
				//prepare data of user
			$userData['oauth_uid'] = $userInfo['id'];
			$userData['first_name'] = $userInfo['given_name'];
			$userData['last_name'] = $userInfo['family_name'];
			$userData['full_name'] = $userInfo['name'];
			$userData['email'] = $userInfo['email'];
			$userData['gender'] = $userInfo['gender'];
			$userData['picture_url'] = $userInfo['picture'];

			$this->session->set_userdata('social_profile',$userData);
			$this->session->set_userdata('user_token',(string)$token);
			redirect('Registration/view_applicant_registration');
		} 
		else
		{
			$data['title'] = "Job-Fair Online | Login";
			$data['google_login_url'] = $this->googleplus->loginURL();
			$this->load->view('v_login',$data);
		} 	
	}

	public function login_google()
	{
		$this->googleplus->getAuthenticate();
		if($this->googleplus->getAccessToken())
		{

			$userInfo = $this->googleplus->getUserInfo();
			$email = $userInfo['email'];

			$user = $this->auth_model->getUserByEmail($email);

			if(!empty($user))
			{
				$userInfo = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
				$expDate = date("Y-m-d H:i:s", strtotime('+1 day'));
				$data['user_id'] = $user->user_id;
				$data['token'] = md5($this->functions->guid());
				$data['exp_date'] = $expDate;
				$data['date_created'] = date('Y-m-d H:i:s');
				$data['status'] = 1;

				$log['user_id'] = $user->user_id;
				$log['audit_action'] = 3;
				$log['table_name'] = "tb_users";
				$log['record_id'] = $user->user_id;
				$log['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$log['date'] = date('Y-m-d H:i:s');
				$log['is_active'] = 1;
				$log['action_description'] = "Sign-in with Google";

				if($user->account_type == 3)
				{
					$boolean = $this->auth_model->isEmailActivated($user->user_id);

					if($boolean === FALSE){
						header('HTTP/1.0 403 Forbidden');

						echo "It seems your email is not verified. Please verify your email first.";
					}
					else{
						
						

						setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
						setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
						setcookie("_typ", "ep", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

						if($this->auth_model->newUserToken($data) === TRUE)
						{
							$this->log_model->save($log);

							redirect(site_url("/company/applicants/dashboard"));
						}
					}
				}	
					

				if($user->account_type == 2){
					setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
					setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
					setcookie("_uc", $this->my_encrypt->encode($userInfo->job_category), time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
					setcookie("_typ", "ap", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

					if($this->auth_model->newUserToken($data) === TRUE)
					{
						$this->log_model->save($log);

						redirect(site_url("/applicant/applications/pending"));
					}
				}

				if($user->account_type == 1){
					setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
					setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
					setcookie("_typ", "ad", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

					if($this->auth_model->newUserToken($data) === TRUE)
					{
						$this->log_model->save($log);

						redirect(site_url("/admin/review/jobs"));
					}
				}

				
			}
			else{
				

				echo "Sorry! Couldn't found any related account. Back to <a style='text-decoration:none; color:#000;' href='".site_url("login")."'><strong>LOGIN</strong></a> this window now";
			}
			
		} 
		else
		{
			redirect("login");
		} 	
	}

	/*FUNCTIONS*/

	public function validate()
	{
		$action = $this->input->post('action', true);

		if($action == "validate_age")
		{
			$birth_year = $this->input->post('birth_year');  

			$age = date("Y") - $birth_year;
			if($age >= 15)
			{
				echo "true";
			}
			else
			{
				echo "false";
			}
		}

		if($action == "validate_new_email")
		{
			$newEmail = $this->input->post('email', true);

			$query = $this->auth_model->newEmailValid($newEmail);

			if($query == 0)
			{
				echo "true";
			}
			else
			{
				echo "false";
			}
		}
		if($action == "validate_new_number")
		{
			$newNumber = str_replace("-","",$this->input->post('phonenumber', true));

			$query = $this->auth_model->newNumberValid($newNumber);

			if($query == 0)
			{
				echo "true";
			}
			else
			{
				echo "false";
			}
		}
		if($action == "validate_recaptcha")
		{
			$captcha = $this->input->post('recaptcha');
			$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdeGAoUAAAAAJ3kuTUdlVMYC5Xi9H6qW8VJi8Hp&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
			echo json_encode($response);
		}

		if($action == "validate_company_name")
		{
			$temp = $this->input->post('company_name');
			$company_name = trim(strtoupper($temp));
			$query = $this->reg_model->companyNameValid($company_name);

			if($query == 0)
			{
				echo "true";
			}
			else
			{
				echo "false";
			}
		}
	}

	

	public function check_password_length()
	{
		$password = $this->input->post('newPassword');
		$length = strlen($password);

		if($length >= 8){
			return TRUE;
		}
		else{

			$this->form_validation->set_message('check_password_length','Password must be at least 8 characters');
			return FALSE;
		}

	}	

	public function check_password_strength()
	{
		$password = $this->input->post('newPassword');
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

}
