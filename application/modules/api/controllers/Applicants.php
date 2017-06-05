<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Applicants extends REST_Controller {

    function __construct()
    {

        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model('applicant/applicant_model_rest','app_model');
        $this->load->model('job_post_model', 'job_model');
        $this->load->model('auth_model');
        //$this->load->module('api/auth');
        $this->load->module('functions/functions');

        date_default_timezone_set('Asia/Manila');
    }

    public function index_get()
    {
        redirect('api/applicants/profiles');
    }    

    public function index_post()
    {
        $form_token = $this->post('form_token');
        
        if($form_token == $this->session->userdata('form_token'))
        {   
            $temp_date = $this->post('birth_year')."/".$this->post('birth_month').'/'.$this->post('birth_date');
            $birthdate = date("Y-m-d", strtotime($temp_date));
            $birth_year = date("Y", strtotime($this->post('birthdate')));  
            $age = date("Y") - $birth_year;
            $mobile_no = str_replace("-","",$this->post('phonenumber'));

            $uid = $this->functions->guid();
            $applicant_info['user_id'] = $uid;
            $applicant_info['first_name'] = strtolower($this->post('firstname'));
            $applicant_info['last_name'] = strtolower($this->post('lastname'));
            $applicant_info['middle_name'] = strtolower($this->post('middlename'));
          
            $applicant_info['birth_date'] = $birthdate;

            $applicant_info['s_educ_attain'] = $this->post('educAttainment');
            $applicant_info['s_work_exp'] = $this->post('workExp');
            $applicant_info['job_category'] = $this->post('jobCategory');
            $applicant_info['job_position'] = serialize($this->post('jobRole'));
            $applicant_info['about_us'] =($this->post('hearAboutUs') != NULL)? $this->post('hearAboutUs'):" ";
            $applicant_info['allow_info_status'] = $this->post('infoCondition');
            $applicant_info['date_created'] = date('Y-m-d H:i:s');
            $applicant_info['street_1'] = $this->post('street');
            $applicant_info['city_1'] = $this->post('city_id');
            $applicant_info['province_1'] =  $this->post('region_id');
            $applicant_info['age'] = $age;
            $applicant_info['is_active'] = 1;

            $applicant_acct['user_id'] = $uid;
            $password = $this->post('password');
            $applicant_acct['password'] = $this->my_encrypt->encrypt($password);
            $applicant_acct['email'] = $this->post('email',true);
            $applicant_acct['mobile_num'] = $mobile_no;
            $applicant_acct['account_type'] = 2;
            $applicant_acct['date_created'] = date('Y-m-d H:i:s');
            $applicant_acct['is_active'] = 1;
           
            if($this->app_model->create($applicant_info, $applicant_acct))
            {
                $expDate = date("Y-m-d H:i:s", strtotime('+1 day'));
                $data['user_id'] = $uid;
                $data['token'] = md5($this->functions->guid().$applicant_acct['email'].$applicant_acct['password']);
                $data['exp_date'] = $expDate;
                $data['date_created'] = date('Y-m-d H:i:s');
                $data['status'] = 1;

                setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
                setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
                setcookie("_uc", $this->my_encrypt->encode($applicant_info['job_category']), time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
                setcookie("_typ", "ap", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

                if($this->auth_model->newUserToken($data) === TRUE){
                    $response = array(
                        "status" => true,
                        "redirect" =>  site_url("/applicant/recommended-jobs") ,
                        );

                     $this->response($response,REST_Controller::HTTP_OK);
                }
            }
        }
        else{
            $this->response([
                'status' => FALSE,
                'message' => 'UNAUTHORIZED REQUEST' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function index_patch()
    {
        if(!isset($_COOKIE['_ut']))
        {
            $this->response(['status' => FALSE, 'message' => '' ],REST_Controller::HTTP_FORBIDDEN);
        }
        else{
            
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user))
            {
                $id = $user->user_id;

                if($id === NULL){
                    $this->response(['status' => FALSE, 'message' => 'Missing Request Paramerter' ],REST_Controller::HTTP_BAD_REQUEST);
                }
                elseif($user->account_type != 2)
                {
                    $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
                }
                else{

                    $operation = $this->patch('op');

                    if($operation == "general_update"){

                        $birthdate = date("Y-m-d", strtotime($this->patch('birthdate')));
                        $data['first_name'] = $this->patch('first_name');
                        $data['middle_name'] = $this->patch('middle_name');
                        $data['last_name'] = $this->patch('last_name');
                        $data['sex'] = $this->patch('gender');
                        $data['civil_status'] = $this->patch('civil_status');
                        $data['birth_date'] = $birthdate;
                        $data['religion'] = $this->patch('religion');
                        $data['street_1'] = $this->patch('street');
                        $data['city_1'] = $this->patch('city_id');
                        $data['province_1'] =  $this->patch('region_id');

                        if($this->app_model->update($id, $data))
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Profile changes saved",
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                    }
                    if($operation == "job_update"){

                        $data['s_work_exp'] = $this->patch('workExp');
                        $data['job_category'] = $this->patch('jobCategory');
                        $data['job_position'] = serialize($this->patch('jobRole'));

                        if($this->app_model->update($id, $data))
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Profile changes saved",
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                    }
                    if($operation == "educ_update"){

                        $data['degree'] = $this->patch('course');
                        $data['school_name'] = $this->patch('school');
                        $data['s_year_entered'] = $this->patch('year_entered');
                        $data['s_year_graduated'] = $this->patch('year_graduated');
                        $data['s_educ_attain'] = $this->patch('attainment'); 

                        if($this->app_model->update($id, $data))
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Profile changes saved",
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                    }
                    if($operation == "email_update"){

                        $user = $this->auth_model->getUserByToken($token);
                        $newEmail = $this->patch('newEmail');
                        $temp_password = $this->patch('password');
                        $password = $this->my_encrypt->encrypt($temp_password);


                        if($this->auth_model->get($user->email, $password))
                        {
                            if($this->auth_model->newEmailValid($newEmail) == 0)
                            {
                                if($this->app_model->updateEmail($user->user_id, $newEmail) === TRUE)
                                {
                                    $response = array(
                                        "status" => true,
                                        "message" => "New email saved"
                                        );
                                    $this->response($response, REST_Controller::HTTP_OK);
                                }
                                else{
                                    $this->response([
                                        'status' => FALSE,
                                        'message' => 'Internal Server Error' 
                                        ],REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                                }
                            }
                            else{
                                $this->response(['status' => FALSE, 'message' => 'Email already exists' ],REST_Controller::HTTP_BAD_REQUEST); 
                            }

                        }
                        else{
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Invalid Password',
                                ],REST_Controller::HTTP_UNAUTHORIZED);
                        }

                    }
                    if($operation == "mobile_update"){

                        $user = $this->auth_model->getUserByToken($token);
                        $new_mobile =  str_replace("-","",$this->patch('mobile_num'));
                        $temp_password = $this->patch('password');
                        $password = $this->my_encrypt->encrypt($temp_password);


                        if($this->auth_model->get($user->email, $password))
                        {
                            if($this->auth_model->newNumberValid($new_mobile) == 0)
                            {
                                if($this->app_model->updateMobile($user->user_id, $new_mobile) === TRUE)
                                {
                                    $response = array(
                                        "status" => true,
                                        "message" => "New mobile no. saved"
                                        );
                                    $this->response($response, REST_Controller::HTTP_OK);
                                }
                                else{
                                    $this->response([
                                        'status' => FALSE,
                                        'message' => 'Internal Server Error' 
                                        ],REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                                }
                            }
                            else{
                                $this->response(['status' => FALSE, 'message' => 'Mobile number already exists' ],REST_Controller::HTTP_BAD_REQUEST); 
                            }
                        }
                        else{
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Invalid Password',
                                ],REST_Controller::HTTP_UNAUTHORIZED);
                        }
                    }
                    if($operation == "password_update"){
                        $user = $this->auth_model->getUserByToken($token);
                        $new_password =  $this->my_encrypt->encrypt($this->patch('newPassword'));
                        $temp_password = $this->patch('password');
                        $password = $this->my_encrypt->encrypt($temp_password);

                        if($this->auth_model->get($user->email, $password))
                        {
                            if($this->app_model->updatePassword($user->user_id, $new_password) === TRUE)
                            {
                                $response = array(
                                    "status" => true,
                                    "message" => "New password saved",
                                    );
                                $this->response($response, REST_Controller::HTTP_OK);
                            }
                        }
                        else{
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Invalid Password',
                                ],REST_Controller::HTTP_UNAUTHORIZED);
                        }
                    }
                    if($operation == "info_status_update"){
                        
                        $info_status = $this->patch('info_status');
                        if($info_status != NULL)
                        {
                            $data['allow_info_status'] = $info_status;
                         
                            if($this->app_model->update($id, $data)){
                                $response = array(
                                    "status" => true,
                                    "message" => ($info_status == 1)?  "Profile status has been set as Public": "Profile status has been set as Private",
                                    );
                                $this->response($response, REST_Controller::HTTP_OK);
                            }
            
                        }
                        else {
                            $this->response(['success' => FALSE, 'message' => 'Missing Argument Paramerter' ],REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST FORBIDDEN' ],REST_Controller::HTTP_FORBIDDEN);
            }
        }
    }

    public function index_delete()
    {

    }

    /** My Routes */

    public function profiles_get()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST FORBIDDEN' 
                ],REST_Controller::HTTP_FORBIDDEN);
        }
        else
        {
            if(isset($_COOKIE['_ut']))
            {
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

                if(!empty($user))
                {
                    $id = NULL;
                    $type = ($this->get('type') === NULL)? 'public' : $this->get('type'); 
                    $keyword = ($this->get('keyword') === NULL)? FALSE: $this->get('keyword');
                    $offset = ($this->get('offset') === NULL)? 0 : $this->get('offset');
                    $region = ($this->get('region') === NULL)? FALSE : $this->get('region'); //for region filter
                    $category = ($this->get('category') === NULL)? FALSE : $this->get('category');
                    $limit = ($this->get('limit') === NULL)? 20 : $this->get('limit');
                    
                    if(isset($_COOKIE['_ut'])){
                        $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                        if($user->account_type == 2){
                            $id = $user->user_id;
                        }
                        else{
                            $id = $this->get('id');
                        }
                    }
                    
                    if ($id === NULL)
                    {   
                        $users = $this->app_model->get($id = FALSE, $offset, $keyword, $region, $category, $type, $limit); 

                        if(!empty($users['data']))
                        {
                            $applicants = array();
                            $positions = [];
                            $work_history = array();
                            $desired_positions = "";

                            foreach($users['data'] as $app)
                            {
                                $job_positions = $this->job_model->get_positions($id = FALSE, $app["job_category"]);
                                $temp = unserialize($app["job_position"]);

                                foreach($job_positions as $job_position)
                                {
                                    $positions[] = (in_array($job_position->id, $temp))?$job_position->name:false;
                                }
                                foreach($positions as $pos){
                                    if($pos != false)
                                    {
                                        $desired_positions .= ($desired_positions == "" ? "" : ",") . $pos;
                                    }
                                }

                                $workHistory = $this->app_model->get_work_history($app['user_id']);

                                foreach($workHistory as $app_workHistory)
                                {
                                    $work_history[] = array(
                                        "company_name" => $app_workHistory['company_name'],
                                        "position" => $app_workHistory['position'],
                                        "start_date" => date('F d, Y',strtotime($app_workHistory['work_start'])),
                                        "end_date" => date('F d, Y',strtotime($app_workHistory['work_end'])),
                                        "work_description" => $app_workHistory['work_description'] 
                                        );
                                }


                                $applicants[] = array(
                                    "id" => $app['user_id'],
                                    "first_name" => $app['first_name'],
                                    "middle_name" => $app['middle_name'],
                                    "last_name" => $app['last_name'],
                                    "profile_img" =>  ($app['profile_pic'] != "")?base_url().str_replace("./", "", $app['profile_pic']):base_url().'assets/images/Default_User1.png',
                                    "age" => $app['age'],
                                    "civil_status" => $app['civil_status'],
                                    "gender" => ucfirst($app['sex']),
                                    "address" => $app['city'].", ".$app['province'],
                                    "mobile" => $app['mobile_num'],
                                    "email" => $app['email'],
                                    "attainment" => $app['s_educ_attain'],
                                    "degree" => $app['degree'],
                                    "school" => $app['school_name'],
                                    "year_entered" => $app['s_year_entered'],
                                    "year_graduated" => $app['s_year_graduated'],
                                    "category" => $app['category'],
                                    "experience" => $app['s_work_exp'],
                                    "desired_positions" => $desired_positions,
                                    "work_history" => $work_history,
                                    "religion" => $app['religion'],
                                    "birthdate" => $app['birth_date'],
                                    "street" => $app['street_1'],
                                    "limit" => $users['limit'],
                                    "type" => $type,
                                    "totalFiltered" => $users['filtered'],
                                    "totalRecords" => $this->app_model->getTotalRows($type, $keyword, $region, $category, $type),
                                    
                                    ); 

                                $desired_positions = ""; //reset string after loop    
                                $positions = array();  //reset array after loop   
                                $work_history = array();
                            }
                            
                            $this->response($applicants, REST_Controller::HTTP_OK); 
                        }
                        else
                        {
                            $response = array(
                                        "data" => [],
                                        "limit" => $limit,
                                        "totalFiltered" => 1,
                                        "totalRecords" => $this->app_model->getTotalRows($type)
                                        );
                            $this->response($response, REST_Controller::HTTP_OK); 
                        }
                    }

                    else 
                    {
                        $app = $this->app_model->get($id);

                        if (!empty($app))
                        {
                            $applicant = array();
                            $positions = [];
                            $work_history = array();
                            $desired_positions = "";

                            $job_positions = $this->job_model->get_positions($id = FALSE, $app["job_category"]);
                            $temp = unserialize($app["job_position"]);


                            foreach($job_positions as $job_position)
                            {
                                $positions[] = (in_array($job_position->id, $temp))?$job_position->name:false;
                            }
                            foreach($positions as $pos){
                                if($pos != false)
                                {
                                    $desired_positions .= ($desired_positions == "" ? "" : ",") . $pos;
                                }
                            }

                            $workHistory = $this->app_model->get_work_history($app['user_id']);

                            foreach($workHistory as $app_workHistory)
                            {
                                $work_history[] = array(
                                    "wid" => $this->my_encrypt->encode($app_workHistory['id']),
                                    "company_name" => $app_workHistory['company_name'],
                                    "position" => $app_workHistory['position'],
                                    "start_date" => date('F d, Y',strtotime($app_workHistory['work_start'])),
                                    "end_date" => date('F d, Y',strtotime($app_workHistory['work_end'])),
                                    "work_description" => $app_workHistory['work_description']
                                    );
                            }

                            $applicant = array(
                                "id" => $app['user_id'],
                                "first_name" => $app['first_name'],
                                "middle_name" => $app['middle_name'],
                                "last_name" => $app['last_name'],
                                "profile_img" =>  ($app['profile_pic'] != "")?base_url().str_replace("./", "", $app['profile_pic']):base_url().'assets/images/Default_User2.png',
                                "age" => $app['age'],
                                "civil_status" => $app['civil_status'],
                                "gender" => $app['sex'],
                                "address" => $app['city'].",".$app['province'],
                                "mobile" => $app['mobile_num'],
                                "email" => $app['email'],
                                "attainment" => $app['s_educ_attain'],
                                "degree" => $app['degree'],
                                "school" => $app['school_name'],
                                "year_entered" => $app['s_year_entered'],
                                "year_graduated" => $app['s_year_graduated'],
                                "experience" => $app['s_work_exp'],
                                "category" => $app['category'],
                                "religion" => $app['religion'],
                                "birthdate" => $app['birth_date'],
                                "street" => $app['street_1'],
                                "cid" => $app['city_1'],
                                "rid" => $app['region_id'],
                                "resume" => $app['resume_name'],
                                "path" => base_url().str_replace("./", "", $app['resume_path']),
                                "ruid" => $app['resume_unique_name'],
                                "desired_positions" => $desired_positions,
                                "work_history" => $work_history,
                                "profile_type" => $app['allow_info_status'],
                                );

                            $this->set_response($applicant, REST_Controller::HTTP_OK); 
                        }
                        else
                        {
                            $this->set_response([
                                'status' => FALSE,
                                'message' => 'User could not be found'
                                ], REST_Controller::HTTP_NOT_FOUND); 
                        }
                    } 
                }
                else{
                    $this->response(['status'=>FALSE, "response"=> "REQUEST UNAUTHORIZED"], REST_Controller::HTTP_UNAUTHORIZED);
                }
            }
        }
          
    }

    public function application_get()
    {
        $offset = ($this->get('offset')=== NULL)? 0 : $this->get('offset');
        $job_status = $this->get('status');
        $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
        $user =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);
        $query = $this->app_model->get_jobs($user->user_id, $job_status, $offset);
        $jobs = array();

        if(!empty($query))
        {
            foreach($query['data'] as $job)
            {
               $salary1 = floatval($job['salary_range1']);
               $salary2 = floatval($job['salary_range2']);
               $salary = ($job['salary_status'] == 1)? number_format($salary1).'-'.number_format($salary2):0; 

                $jobs[] = array(
                        "id" => $this->my_encrypt->encode($job['job_id']),
                        "vid" => $this->my_encrypt->encode($job['vid']),
                        "position" => $job['job_position'],
                        "cid" => $job['company_id'],
                        "company" => $job['company_name'],
                        "location" => $job['city'].', '.$job['province'],
                        "salary" =>  $salary,
                        "open_date" =>  date('F d, Y',strtotime($job['job_opendate'])),
                        "date_posted" => $job['job_opendate'],
                        "due_date" => date('F d, Y',strtotime($job['job_closedate'])),
                        "category" => $job['category_name'],
                        "job_description" => substr($job['job_description'], 0,200).'....',
                        "education_requirement" => $job['educational_attainment'],
                        "company_details" => $job['company_description'],
                        "company_logo" => base_url().str_replace("./", "",$job['profile_pic']),
                        "vacancies" => $job['num_vacancies'],
                        "status" => $job['vstatus'],
                        "course" => $job['code'],
                        "totalFiltered" => $query['filtered'],
                        "limit" => $query['limit'],
                        "offset" => 0
                        );
            }
            $this->set_response($jobs, REST_Controller::HTTP_OK); 
        }
    }
    //seen status
    public function application_seen_post()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 2)
            {
                $ids = $this->post('ids');
                foreach ($ids AS  $id) {
                    $id = $this->my_encrypt->decode($id);
                    $this->app_model->setAsSeen($id);
                }
                $this->response([],REST_Controller::HTTP_OK);
            }
            else{
                $this->response(['status'=>FALSE, "response"=> "REQUEST UNAUTHORIZED"], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function application_delete_post()
    {
        if(isset($_COOKIE['_ut']))
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            $user_id = $user->user_id;

            if(!empty($user_id) && $user->account_type == 2){
                
                $id = $this->my_encrypt->decode($this->post('vid'));

                if($this->app_model->deleteApplication($id) === TRUE){
                    $response = array(
                            "message" => "You application has been deleted",
                            "status" => true
                            );
                    $this->response($response, REST_Controller::HTTP_OK);
                }
            }
            else{
                $this->response(['stsus'=> FALSE], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        else{
            $this->response(['stsus'=> FALSE], REST_Controller::HTTP_FORBIDDEN);
        }
    }


    public function set_active_post()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 1)
            {
                $ids = $this->post('id');

                foreach ($ids as $id) {

                   if($this->app_model->setAsActive($id) === TRUE)
                    {
                        $response = array(
                            "status"=>TRUE,
                            "message" => "Applicant(s) has been set as Active"
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response('', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }
            }
            else{
                $this->response(['status'=>FALSE, "response"=> "REQUEST UNAUTHORIZED"], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function set_inactive_post()
    {   
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 1)
            {
                $ids = $this->post('id');

                foreach ($ids as $id) {
                    
                    if($this->app_model->setAsInactive($id) === TRUE)
                    {
                        $response = array(
                            "status"=>TRUE,
                            "message" => "Applcant(s) has been set as Inactive"
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response('', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    }  
                }
             }
            else{
                $this->response(['status'=>FALSE, "response"=> "REQUEST UNAUTHORIZED"], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }



    public function work_history_post()
    {
        if(!isset($_COOKIE['_ut']))
        {
            $this->response(['status' => FALSE, 'message' => '' ],REST_Controller::HTTP_FORBIDDEN);
        }
        else{
            
            $token = $_COOKIE['_ut'];

            $user = $this->auth_model->getUserByToken($token);
            $user =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);

            if(!empty($user))
            {
                $data['user_id'] = $user->user_id;
                $data['company_name'] = $this->post('company');
                $data['position'] = $this->post('position');
                $data['work_description'] = $this->post('work_description');
                $data['work_start'] = $this->post('start_date');
                $data['work_end'] = $this->post('end_date');
                $data['date_created'] = date('Y-m-d H:i:s');
                $data['is_active'] = 1;

                if($this->app_model->create_work_history($data))
                {
                   $response = array(
                    "status"=>TRUE,
                    "message" => "New Work History created",
                    );
                   $this->response($response, REST_Controller::HTTP_CREATED);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function work_history_patch()
    {
        if(!isset($_COOKIE['_ut']))
        {
            $this->response(['status' => FALSE, 'message' => '' ],REST_Controller::HTTP_FORBIDDEN);
        }
        else{
            
            $token = $_COOKIE['_ut'];

            $user = $this->auth_model->getUserByToken($token);
            $user =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);

            if(!empty($user))
            {
                $id = $this->my_encrypt->decode($this->patch('wid'));

                if($id === NULL){
                    $this->response(['status' => FALSE, 'message' => 'Missing Request Paramerter' ],REST_Controller::HTTP_BAD_REQUEST);
                }
                else{
                    $data['company_name'] = $this->patch('company');
                    $data['position'] = $this->patch('position');
                    $data['work_description'] = $this->patch('work_description');
                    $data['work_start'] = $this->patch('start_date');
                    $data['work_end'] = $this->patch('end_date');
                    $data['date_modified'] = date('Y-m-d H:i:s');

                    if($this->app_model->update_work_history($user->user_id, $id, $data))
                    {
                       $response = array(
                        "status"=>TRUE,
                        "message" => "Work History changes saved",
                        );
                       $this->response($response, REST_Controller::HTTP_CREATED);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function work_history_delete()
    {
        if(!isset($_COOKIE['_ut']))
        {
            $this->response(['status' => FALSE, 'message' => '' ],REST_Controller::HTTP_FORBIDDEN);
        }
        else{
            
            $token = $_COOKIE['_ut'];

            $user = $this->auth_model->getUserByToken($token);
            $user =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);

            if(!empty($user))
            {
                $id = $this->my_encrypt->decode($this->delete('wid'));

                if($id === NULL){
                    $this->response(['status' => FALSE, 'message' => 'Missing Request Paramerter' ],REST_Controller::HTTP_BAD_REQUEST);
                }
                else{

                    if($this->app_model->delete_work_history($user->user_id, $id))
                    {
                       $response = array(
                        "status"=>TRUE,
                        "message" => "Work History has been deleted",
                        "data" => $user
                        );
                       $this->response($response, REST_Controller::HTTP_CREATED);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function work_history_get()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $id = $this->my_encrypt->decode($this->get('wid'));
            
            if($id === NULL)
            {
                $this->response(array("status" => false, "message" => "BAD REQUEST"), REST_Controller::HTTP_BAD_REQUEST);
            }
            else{
                
                $app_workHistory = $this->app_model->get_work_history($user_id = FALSE, $id);

                $work_history = array(
                    "wid" => $this->my_encrypt->encode($app_workHistory['id']),
                    "company_name" => $app_workHistory['company_name'],
                    "position" => $app_workHistory['position'],
                    "start_date" => $app_workHistory['work_start'],
                    "end_date" => $app_workHistory['work_end'],
                    "work_description" => $app_workHistory['work_description']
                );
                
                $this->response($work_history, REST_Controller::HTTP_OK); 
            }
        }   
    }

    public function resume_post()
    {
        if(!isset($_COOKIE['_ut']))
        {
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST FORBIDDEN' 
                ],REST_Controller::HTTP_FORBIDDEN);
        }
        else
        {
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);
            $user =  $this->auth_model->getUserDetails($user->user_id, $user->account_type);

            if(!empty($user))
            {
                $op = $_POST['op'];
                if($op == "upload")
                {
                    $rand_id = time();
                    $temp_file_name = preg_replace('/\s+/', '_', $_FILES['userfile']['name']);
                    $real_file_name = $_FILES['userfile']['name']; 
                    $file_name = $rand_id ."_".$temp_file_name;

                    $upload_response = $this->functions->upload_resume($user->user_id, $file_name);

                    if($upload_response['status'] == TRUE)
                    {
                        $data['resume_name'] = $real_file_name;
                        $data['resume_unique_name'] = $file_name;
                        $data['resume_path'] = $upload_response['resume_path'];
                        
                        if($this->app_model->update($user->user_id, $data)){
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Resume has been saved",
                                "id" => $file_name
                                );

                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                    }
                }
                elseif($op == "update")
                {
                    $rand_id = time();
                    $temp_file_name = preg_replace('/\s+/', '_', $_FILES['userfile']['name']);
                    $real_file_name = $_FILES['userfile']['name']; 
                    $file_name = $rand_id ."_".$temp_file_name;
                    $old_file = $_POST['old_file'];
                    $upload_response = $this->functions->upload_resume($user->user_id, $file_name);

                    if($upload_response['status'] == TRUE)
                    {
                        unlink($upload_response['resume_path']."/".$old_file);
                        $data['resume_name'] = $real_file_name;
                        $data['resume_unique_name'] = $file_name;
                        $data['resume_path'] = $upload_response['resume_path'];

                        if($this->app_model->update($user->user_id, $data))
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "New Resume has been saved",
                                "upload_response" => $upload_response
                                );

                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }                        
                    }

                }
                elseif($op == "remove")
                {
                    $old_file =  $this->post('old_file');
                    $data['resume_name'] = "";
                    $data['resume_unique_name'] = "";

                    unlink("./assets/uploads/resume/".$user->user_id."/".$old_file); //$user refers to folder name

                    if($this->app_model->update($user->user_id, $data)){
                        $response = array(
                            "status"=>TRUE,
                            "message" => "Resume has been removed",
                            );

                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                }
                else{
                    $this->response(['status'=> FALSE, 'message' => "Missing Argument Request"], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }


    public function user_photo_post()
    {
        if(!isset($_COOKIE['_ut']))
        {
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST FORBIDDEN' 
                ],REST_Controller::HTTP_FORBIDDEN);
        }
        else
        {
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user) && $user->account_type == 2)
            {   

                $rand_id = time();
                $file_name = $rand_id.preg_replace('/\s+/', '_', $_FILES['userfile']['name']);
                $upload_response = $this->functions->upload_userPhoto($user->user_id, $user->account_type, $file_name);

                if($upload_response['status'] == TRUE)
                {
                    if(isset($_POST['prev_img']))
                    {
                        $old_img = $_POST['prev_img'];
                        unlink($old_img);  
                    }
                     
                    $data['profile_pic'] = $upload_response['profile_path'];

                    if($this->app_model->update($user->user_id, $data)){
                        $response = array(
                            "status"=>TRUE,
                            );

                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function accounts_delete()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 1)
            {
                $ids = $this->delete('id');

                foreach ($ids as $id) {
                    $applicant = $this->app_model->get($id);

                    if($applicant['resume_path'] && $applicant['resume_unique_name'] != ""){
                       
                        unlink($applicant['resume_path'].'/'.$applicant['resume_unique_name']);
                        
                        rmdir($applicant['resume_path']);
                    }
                    if($applicant['profile_pic'] != ""){
                       $pathArr = explode("/", $applicant['profile_pic']);
                       unlink($applicant['profile_pic']);
                       end($pathArr);
                       rmdir("./assets/images/uploads/user_photos/".prev($pathArr));
                    }

                    if($this->app_model->deleteAccount($id) === TRUE)
                    {
                        $response = array(
                            "status"=>TRUE,
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response('', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }
            }
            else{
                $this->response(['status'=>FALSE, "response"=> "REQUEST UNAUTHORIZED"], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function notifications_get()
    {
         if(!isset($_COOKIE['_ut']))
        {
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST FORBIDDEN' 
                ],REST_Controller::HTTP_FORBIDDEN);
        }
        else
        {
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user) && $user->account_type == 2)
            { 
                $query = $this->app_model->getNotification($user->user_id);
                $notifications = array();

                foreach($query as $notif)
                {
                    $notifications[] = array(
                        "id" => $notif->id,
                        "notification" => $notif->notification,
                        "date_created" => $notif->date_created,
                        "status" => $notif->status 
                        );
                }

                //$response = array("status" => true, "data"=> $notifications,"id"=> $user->user_id);

                $this->response($notifications, REST_Controller::HTTP_OK);
            }
            else{
                $this->response(['status'=>FALSE, "response"=> "REQUEST UNAUTHORIZED"], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }
}       
