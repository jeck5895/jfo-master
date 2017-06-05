<?php
	class Functions extends MY_Controller{

		public function __construct()
		{
			parent::__construct();
			$this->load->model('Function_model','function_model');
			$this->load->model('registration/registration_model', 'reg_model');
		}

		function guid() 
		{
			mt_srand((double) microtime() * 10000);
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);
			$uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
			return $uuid;
		}

		function ucfirstFormat($var)
		{
			$temp = strtolower($var);

			return ucfirst($temp);
		}

		public function sendEmail($email, $subject, $content)
		{
			$smtp_acct = $this->function_model->get_smtp_acct();
			
			ini_set('max_execution_time', 0);
			
			$config['protocol']  = 'smtp';
			$config['smtp_host'] = 'ssl://smtp.googlemail.com';
			$config['smtp_port'] = '465';
			$config['smtp_timeout'] = '59';
			$config['smtp_user'] = $smtp_acct->smtp_user;
			$config['smtp_pass'] = $this->my_encrypt->decode($smtp_acct->smtp_password);
			$config['charset']  = 'utf-8';
			$config['mailtype'] = 'html';
			$config['newline']  = "\r\n";

			$this->load->library('email', $config);
			$this->email->from($smtp_acct->smtp_user,'JobFair-Online.net'); // change it to yours
			$this->email->to($email); // change it to yours
			$this->email->subject($subject);
			$this->email->message($content);
			
			if($this->email->send())
			{
				$result['status'] = TRUE;

				return $result;
			}
			else
			{
			 	$result['status'] = FALSE;
			 	$result['message'] = $this->email->print_debugger();

			 	return $result;
			} 	
		}

		public function upload_advertisement($folder, $file)
		{
			$config['file_name'] =  $file;
			$config['upload_path']   = './assets/images/carousel/'.$folder; 
			$config['allowed_types'] = 'jpeg|jpg|png|gif'; 
			$config['remove_spaces'] = FALSE;
			$config['max_size'] = 0;
			$config['detect_mime']  = TRUE;

			$this->load->library('upload', $config);

			if (!file_exists($config['upload_path'])) 
            {
                mkdir('./assets/images/carousel/'.$folder, 0777);
            }

            if(!$this->upload->do_upload())
            {
              	$result['error'] = $this->upload->display_errors();
              	$result['status'] = FALSE;
              	$result['path'] = $config['upload_path'];
             	return $result;
            }
            else
            {
            	$img_path['path'] = $config['upload_path'];
            	$img_path['status'] = TRUE;
				
				return $img_path;
            }	
		}

		public function upload_banner($id, $file)
		{
			$folder_name = $id;
			$config['file_name'] =  $file;
			$config['upload_path']   = './assets/images/uploads/company_banner/'.$folder_name; 
			$config['allowed_types'] = 'jpeg|jpg|png|gif'; 
			$config['remove_spaces'] = FALSE;
			$config['max_size'] = 0;
			$config['detect_mime']  = TRUE;

			$this->load->library('upload', $config);

			 if (!file_exists($config['upload_path'])) 
            {
                mkdir('./assets/images/uploads/company_banner/'.$folder_name, 0777);
            }

            if(!$this->upload->do_upload())
            {
              	$result['error'] = $this->upload->display_errors();
              	$result['status'] = FALSE;
             	return $result;
            }
            else
            {
            	$img_path['path'] = $config['upload_path']."/".$config['file_name'];
            	$img_path['status'] = TRUE;
				
				return $img_path;
            }	
		}

		public function upload_userPhoto($id, $user_type, $file)
		{

			$folder_name = $id;

			if($user_type == 2)
			{
				$config['file_name'] =  $file;
				$config['upload_path']   = './assets/images/uploads/user_photos/'.$folder_name; 
				$config['allowed_types'] = 'jpeg|jpg|png|gif|ico'; 
				$config['remove_spaces'] = FALSE;

				if (file_exists($config['upload_path'])) 
				{ 

				}
				else{
					mkdir('./assets/images/uploads/user_photos/'.$folder_name, 0777);
				}

				$this->load->library('upload', $config);
				if(!$this->upload->do_upload())
				{
					$result['error'] = $this->upload->display_errors();
					$result['status'] = FALSE;
					return $result;
				}
				else
				{
					$user_image['profile_path'] = $config['upload_path']."/".$config['file_name'];
					$user_image['status'] = TRUE;

					return $user_image;
				}
			}
			if($user_type == 3)
			{
				$config['file_name'] =  $file;
				$config['upload_path']   = './assets/images/uploads/company_logos/'.$folder_name; 
				$config['allowed_types'] = 'jpeg|jpg|png|gif|ico'; 
				$config['remove_spaces'] = FALSE;

				if (file_exists($config['upload_path'])) 
				{ 

				}
				else{
					mkdir('./assets/images/uploads/company_logos/'.$folder_name, 0777);
				}

				$this->load->library('upload', $config);
				if(!$this->upload->do_upload())
				{
					$result['error'] = $this->upload->display_errors();
					$result['status'] = FALSE;
					return $result;
				}
				else
				{
					$user_image['profile_path'] = $config['upload_path']."/".$config['file_name'];
					$user_image['status'] = TRUE;

					return $user_image;
				}
			}
		}

		public function upload_resume($id, $file)
		{
			$folder_name = $id;
			$config['file_name'] =  $file;
			$config['upload_path']   = './assets/uploads/resume/'.$folder_name; 
			$config['allowed_types'] = 'docx|doc|pdf';
			$config['remove_spaces'] = FALSE;

			if (file_exists($config['upload_path'])) 
			{ 
				
			}
			else{
				mkdir('./assets/uploads/resume/'.$folder_name, 0777);
			}

			$this->load->library('upload', $config);
			if(!$this->upload->do_upload())
			{
				$result['error'] = $this->upload->display_errors();
				return $result;
			}
			else
			{
				$resume_info['resume_path'] = $config['upload_path'];
				$resume_info['resume_name'] = $config['file_name'];
				$resume_info['status'] = TRUE;

				return $resume_info;
			}
		}        	  
	}