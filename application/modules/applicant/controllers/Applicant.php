<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicant extends MY_Controller {

    function __construct()
    {
        date_default_timezone_set('Asia/Manila');
        parent::__construct();
        $this->load->model('applicant_model_rest','app_model');
        $this->load->model('api/auth_model','auth_model');
        $this->load->model('registration/registration_model','reg_model');
        $this->load->module('applicant/applicant');
    }

    
    public function dashboard_pending()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 2)
            {
               
                $page = 'v_applicant_dashboard_pending';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);

                $page_title['title'] = ucfirst($data['user']->first_name).' '.ucfirst($data['user']->last_name).' | Pending Applications';
                $this->loadMainPage($page_title, $userdata, $page ,$data); 
               
            }
            else{
                redirect('login');
            }           
        }
        else{
            redirect('login');
        }        
    }

    public function dashboard_interview()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 2)
            {
               
               $page = 'v_applicant_dashboard_ivw';
               $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
               $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
               $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);

                $page_title['title'] = ucfirst($data['user']->first_name).' '.ucfirst($data['user']->last_name).' | For Interview Applications';

               $this->loadMainPage($page_title, $userdata, $page ,$data);
            }
            else{
                redirect('login');
            }           
        }
        else{
            redirect('login');
        }
    }

    public function dashboard_withdrawn()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 2)
            {
                
                $page = 'v_applicant_dashboard_withdrawn';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);
                 $page_title['title'] = ucfirst($data['user']->first_name).' '.ucfirst($data['user']->last_name).' | Withdrawn Applications';

                $this->loadMainPage($page_title, $userdata, $page ,$data); 
            }
            else{
                redirect('login');
            }           
        }
        else{
            redirect('login');
        }
            
    }

    public function dashboard_reviewed()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 2)
            {
               
                $page = 'v_applicant_dashboard_reviewed';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);
                 $page_title['title'] = ucfirst($data['user']->first_name).' '.ucfirst($data['user']->last_name).' | Reviewed Applications';

                $this->loadMainPage($page_title, $userdata, $page ,$data); 
            }
            else{
                redirect('login');
            }           
        }
        else{
            redirect('login');
        }
    }

    public function dashboard_declined()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 2)
            {
               
                $page = 'v_applicant_dashboard_declined';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);

                 $page_title['title'] =ucfirst($data['user']->first_name).' '.ucfirst($data['user']->last_name).' | Declined Applications';

                $this->loadMainPage($page_title, $userdata, $page ,$data); 
            }
            else{
                redirect('login');
            }           
        }
        else{
            redirect('login');
        }
    }

    public function recommended_jobs()
    {
         if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 2)
            {
                $page_title['title'] = 'Recommend Jobs';
                $page = 'v_job_match';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);

                $this->loadMainPage($page_title, $userdata, $page ,$data); 
            }
            else{
                redirect('login');
            }           
        }
        else{
            redirect('login');
        }
    }

    public function user_profile()
    {
        $this->load->module('functions/functions');
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user))
                redirect('login');
            else if($user->account_type != 2){
                redirect('login');
            }
            else{

                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);
                $data['userWorkHisto'] = $this->app_model->getUserWorkHistory($data['user']->user_id);
                $page_title['title'] = $this->functions->ucfirstFormat($data['user']->first_name) ." ". $this->functions->ucfirstFormat($data['user']->last_name);

                $this->loadMainPage($page_title, $userdata,'v_applicant_profile' ,$data);
            }
        }
        else{
            redirect('login');
        }
        
    }

    public function account_settings()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user))
                redirect('');
            else if($user->account_type != 2){
                redirect('login');
            }
            else{

                $page_title['title'] = 'Applicant | Account Settings';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);
                $this->loadMainPage($page_title, $userdata,'v_account_settings' ,$data );
            }
        }
        else{
            redirect('login');
        }
        
    }

    public function user_profile_edit()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user))
                redirect('');
            else if($user->account_type != 2){
                redirect('login');
            }
            else{

                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['user'] = $userdata['user'] =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['user_image'] = base_url().str_replace("./", "", $data['user']->profile_pic);
                $page_title['title'] = 'Applicant | Update Profile';
                $data['religions'] = $this->get_religion();
                $data['job_categories'] = $this->get_job_category();
                $data['regions'] =  $this->reg_model->getLocation();
                $data['userWorkHisto'] = $this->app_model->getUserWorkHistory($data['user']->user_id);
                $this->loadMainPage($page_title, $userdata,'v_applicant_profile_update' ,$data); 
            }
        }
        else{
            redirect('login');
        }
    }
   

    public function get_religion()
    {
        $dataset =  $this->reg_model->get_religion();

        foreach ($dataset as $data) 
        {
            $results[]= array(
                "id" => $data->id,
                "religion" => $data->religion_name
            );
        } 
        
        return $results;
    }

    public function get_job_category()
    {
        $dataset =  $this->reg_model->get_job_category();

        foreach ($dataset as $data) 
        {
            $results[]= array(
                "id" => $data->id,
                "category_name" => $data->category_name
            );
        } 
        
        return $results;
    }

    public function getLocation()
    {
        $dataset =  $this->reg_model->getLocation();

        foreach ($dataset as $data) 
        {
            $results[]= array(
                "id" => $data->id,
                "region_name" => $data->region_name
            );
        } 

        return $results; 
    }

    public function getCities($provinceID)
    {
        $dataset =  $this->reg_model->getCity($provinceID);
      
        foreach ($dataset as $data) 
        {
            $results[]= array(
                "id" => $data->id,
                "lat_coordinate" => $data->lat_coordinate,
                "long_coordinate" => $data->long_coordinate,
                "city" => $data->city,
                "area_name" => $data->area_name
            );
        } 
      
        return $results;  
    } 

  }
