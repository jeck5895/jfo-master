<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
class Jobs extends REST_Controller {

    function __construct()
    {
        
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        // $this->load->model('employer/employer_model','emp_model');
        $this->load->model('job_post_model');
        $this->load->model('auth_model');
        $this->load->library('my_encrypt');
        // $this->load->module('api/key');
    }

    public function index_post()
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
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 3)
            {
                $job['user_id'] = $user->user_id;
                $job['job_position'] = $this->post('jobTitle');
                $job['location_id'] = $this->post('location');
                $job['city_id'] = $this->post('city');
                $job['category'] = $this->post('jobCategory');
                $job['salary_range1'] = $this->post('salary1');
                $job['salary_range2'] = $this->post('salary2');
                $job['salary_status'] = $this->post('salaryStatus');
                $job['num_vacancies'] = $this->post('jobVacancy');
                $job['educational_attainment'] =$this->post('educAttainment');
                $job['code'] = $this->post('addRequirements');
                $job['job_description'] = $this->post('jobDesc');
                $job['sex'] = $this->post('gender');
                $job['civil_status'] = $this->post('civilStatus');
                $job['expiration'] = $this->post('jobDuration'); //timespan of job post that will be added on job opendate to determine close date 
                $job['date_create'] = date('Y-m-d H:i:s');  
                $job['is_active'] = 1;  

                if($this->job_post_model->create($job))
                {
                    $response = array(
                            "status"=>TRUE,
                            "message" => "Your post has been submitted for review"
                            );
                    $this->response($response, REST_Controller::HTTP_CREATED);
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function index_patch()
    {

    }

    public function index_get()
    {
        $encrypted_job_id = $this->get('job_id');
        $keyword = ($this->get('keyword')=== NULL)? FALSE: $this->get('keyword');
        $offset = ($this->get('offset')=== NULL)? 0 : $this->get('offset');
        $region = ($this->get('region') === NULL)? FALSE : $this->get('region'); //for region filter
        $category = ($this->get('category') === NULL)? FALSE : $this->get('category');
        $job_status = ($this->get('status') === NULL)? "published" : $this->get('status'); 
        $company_id = ($this->get('cid') === NULL)? FALSE : $this->get('cid'); //get jobs related from a company
        $except = ($this->get('ex') === NULL)? FALSE : $this->my_encrypt->decode($this->get('ex')); //get jobs related to a job exept current

        if($this->get('ec') != NULL){
            $category = $this->my_encrypt->decode($this->get('ec'));
        }

        $limit = 10;
        
        $totalRows = $this->job_post_model->getTotalRows($job_status);

        if($this->get('ex') != NULL || $this->get('cid')){
            $limit = 3;
        }

        $user = (isset($_COOKIE['_ut']) && $_COOKIE['_typ'] == "ap")? $this->auth_model->getUserByToken($_COOKIE['_ut']): NULL;

        if($encrypted_job_id === NULL)
        {
            $query =  $this->job_post_model->get($encrypted_job_id = FALSE, $limit, $offset, $keyword, $region, $category, $job_status, $company_id, $except);

            $jobs = array();

            if(!empty($query['data']))
            {
                foreach($query['data'] as $job)
                {
                    $salary1 = floatval($job['salary_range1']);
                    $salary2 = floatval($job['salary_range2']);
                    $salary = ($job['salary_status'] == 1)? number_format($salary1).'-'.number_format($salary2):0; 
                    $job_id = $job['job_id'];
                    
                    if(!empty($user))
                    {
                        $status = ($this->job_post_model->jobHasApplicants($job_id, $user->user_id) == TRUE)? $this->job_post_model->applyStatus($job_id, $user->user_id):FALSE;
                    }
                    
                    $jobs[] = array(
                        "id" =>  $this->my_encrypt->encode($job_id),
                        "position" => $job['job_position'],
                        "cid" => $job['company_id'],
                        "company" => $job['company_name'],
                        "location" => $job['city_1'].','.$job['province_1'],
                        "salary" =>  $salary,
                        "open_date" =>  $job['job_opendate'],
                        "due_date" => $job['job_closedate'],
                        "date_created" => $job['date_create'],
                        "category" => $job['category_name'],
                        "job_description" => substr($job['job_description'], 0,250).'....',
                        "education_requirement" => $job['educational_attainment'],
                        "company_details" => $job['company_description'],
                        "company_logo" => base_url().str_replace("./", "",$job['profile_pic']),
                        "vacancies" => $job['num_vacancies'],
                        "course" => $job['code'],
                        "limit" => ($limit === NULL || $limit === 0)? $totalRows : intval($limit), 
                        "totalFiltered" => $query['filtered'],
                        "totalJobs" => $this->job_post_model->getTotalRows($job_status), 
                        "offset" => 0,
                        "status" => (!empty($user))?$status:FALSE,
                        "query" => $query['query_string']
                        );
                }

                $this->response($jobs, REST_Controller::HTTP_OK);
            }
            else
            {
                $response = array(
                    "data" => [],
                    "limit" => 10,
                    "totalFiltered" => 1,
                    "query_string" => $query['query_string'],
                    "totalRecords" => $this->job_post_model->getTotalRows($job_status)
                    );
                $this->response($response, REST_Controller::HTTP_OK);
            }  
        }
        else
        {
            $job_id = $this->my_encrypt->decode($encrypted_job_id);
            $jobs = array();
            $job = $this->job_post_model->get($job_id); 
        
            if(!empty($job))
            {
                if(!empty($user))
                {
                    $status = ($this->job_post_model->jobHasApplicants($job_id, $user->user_id) == TRUE)? $this->job_post_model->applyStatus($job_id, $user->user_id): FALSE;
                    $job_application = $this->job_post_model->getJobVerification($job_id, $user->user_id);
                }

                $salary1 = floatval($job['0']['salary_range1']);
                $salary2 = floatval($job['0']['salary_range2']);
                $salary = ($job['0']['salary_status'] == 1)? number_format($salary1,2,'.',',').'-'.number_format($salary2,2,'.',','):0; 
                $jobs = array(
                    "id" => $this->my_encrypt->encode($job['0']['job_id']),
                    "position" => $job['0']['job_position'],
                    "cid" => $job['0']['company_id'],
                    "company" => $job['0']['company_name'],
                    "location" => $job['0']['city_1'].','.$job['0']['province_1'],
                    "salary" =>  $salary,
                    "open_date" =>  $job['0']['job_opendate'],
                    "due_date" => $job['0']['job_closedate'],
                    "category" => $job['0']['category_name'],
                    "cat_id" => $job['0']['category'],
                    "job_description" => $job['0']['job_description'],
                    "education_requirement" => $job['0']['educational_attainment'],
                    "company_details" => $job['0']['company_description'],
                    "company_logo" => base_url().str_replace("./", "",$job['0']['profile_pic']),
                    "vacancies" => $job['0']['num_vacancies'],
                    "course" => $job['0']['code'],
                    "vid" => (!empty($user) && $status != FALSE)? $this->my_encrypt->encode($job_application->id) :FALSE,
                    "status" => (!empty($user))? $status :FALSE
                    );

                $this->response($jobs, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response([
                    "status" => FALSE,
                    "message" => "Job was not found"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function full_details_get()
    {
        $encrypted_job_id = $this->get('job_id');

        $job_id = $this->my_encrypt->decode($encrypted_job_id);
        $jobs = array();
        $job = $this->job_post_model->get($job_id); 

        if(!empty($job))
        {

            $jobs = array(
                "id" => $this->my_encrypt->encode($job['0']['job_id']),
                "position" => $job['0']['job_position'],
                "cid" => $job['0']['company_id'],
                "company" => $job['0']['company_name'],
                "location" => $job['0']['city_name'].','.$job['0']['region_name'],
                "city_id" => $job['0']['city_id'],
                "region_id" => $job['0']['region_id'],
                "salary_range1" => floatval($job['0']['salary_range1']),
                "salary_range2" => floatval($job['0']['salary_range2']),
                "open_date" =>  date('F d, Y',strtotime($job['0']['job_opendate'])),
                "due_date" => date('F d, Y',strtotime($job['0']['job_closedate'])),
                "category" => $job['0']['category_name'],
                "job_description" => $job['0']['job_description'],
                "education_requirement" => $job['0']['educational_attainment'],
                "company_details" => $job['0']['company_description'],
                "company_logo" => base_url().str_replace("./", "",$job['0']['profile_pic']),
                "vacancies" => floatval($job['0']['num_vacancies']),
                "course" => $job['0']['code'],
                "date_posted" => $job['0']['job_opendate'],
                "gender_requirement" => $job['0']['sex'],
                "civil_status_requirement" => $job['0']['civil_status'],
                "show_salary" => floatval($job['0']['salary_status']),
                "duration" => $job['0']['expiration'],
                "education_requirement" => $job['0']['educational_attainment'],
                "preferred_course" => $job['0']['code'],
                );

            $this->response($jobs, REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response([
                "status" => $job,
                "message" => "Job was not found"
                ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {

    }

    public function search_get()
    {
        $keyword = $this->get('keyword');

        if($keyword === "")
        {   
           $query = $this->job_post_model->get();
           $jobs = array();

            if(!empty($query))
            {
                foreach($query as $job)
                {
                    $salary1 = floatval($job['salary_range1']);
                    $salary2 = floatval($job['salary_range2']);
                    $salary = ($job['salary_status'] == 1)? number_format($salary1,2,'.',',').'-'.number_format($salary2,2,'.',','):0; 
                    $jobs[] = array(
                        "id" => $this->my_encrypt->encode($job['job_id']),
                        "position" => $job['job_position'],
                        "cid" => $job['company_id'],
                        "company" => $job['company_name'],
                        "location" => $job['city_1'].', '.$job['province_1'],
                        "salary" =>  $salary,
                        "open_date" =>  date('F d, Y',strtotime($job['job_opendate'])),
                        "due_date" => date('F d, Y',strtotime($job['job_closedate'])),
                        "category" => $job['category_name'],
                        "job_description" => substr($job['job_description'], 0,200).'....',
                        "education_requirement" => $job['educational_attainment'],
                        "company_details" => $job['company_description'],
                        "company_logo" => base_url().str_replace("./", "",$job['profile_pic']),
                        "vacancies" => $job['num_vacancies'],
                        "course" => $job['code'],
                        "date_posted" => $job['job_opendate'],
                        );
                }

                $this->response($jobs, REST_Controller::HTTP_OK);
            }    
            else
            {
                $this->response([
                    "status" => FALSE,
                    "message" => "No results found"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        else{
            $this->response($keyword, REST_Controller::HTTP_OK);
        }
    }

    public function apply_post()
    {
        if(isset($_COOKIE['_ut']))
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            $user_id = $user->user_id;

            if(!empty($user_id) && $user->account_type == 2 ){
                $job_id = $this->post('job_id');
                $date_created = date("Y-m-d H:i:s");
                $status = 1;
                $is_active = 1;

                $data = array(
                    "job_id" => $this->my_encrypt->decode($job_id),
                    "user_id" => $user_id,
                    "date_created" => $date_created,
                    "status" => $status,
                    "is_active" => $is_active
                    );

                if($this->job_post_model->apply($data) === TRUE){
                    $response = array(
                        "message" => "You have successfully applied to this Job",
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
            $this->response(['stsus'=> FALSE], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function applications_get()
    {
        $encjob_id = $this->get('id');
        $job_id = $this->my_encrypt->decode($encjob_id);
        $user_id = ($this->session->userdata('active_applicant')!= NULL)? $this->session->userdata('active_applicant')->user_id : NULL;
        $num = $this->job_post_model->jobHasApplicants($job_id, $user_id);

        $this->response($num, REST_Controller::HTTP_OK);
       
    }

    public function withdraw_post()
    {
        if(isset($_COOKIE['_ut']))
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            $user_id = $user->user_id;

            if(!empty($user_id) && $user->account_type == 2){
                $vid = $this->post('vid');
                $date_modified = date("Y-m-d H:i:s");
                $status = 2;

                $data = array(
                            "id" => $this->my_encrypt->decode($vid),
                            "user_id" => $user_id,
                            "date_modified" => $date_modified,
                            "status" => $status,
                            );

                if($this->job_post_model->withdraw($data) === TRUE){
                    $response = array(
                            "message" => "You have successfully withdraw your application",
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
            $this->response(['stsus'=> FALSE], REST_Controller::HTTP_BAD_REQUEST);
        }  
    }

    public function reapply_post()
    {
        if(isset($_COOKIE['_ut']))
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            $user_id = $user->user_id;

            if(!empty($user_id) && $user->account_type == 2){        

                $vid = $this->post('vid');
                $date_modified = date("Y-m-d H:i:s");
                $status = 1;

                $data = array(
                            "id" => $this->my_encrypt->decode($vid),
                            "user_id" => $user_id,
                            "date_modified" => $date_modified,
                            "status" => $status,
                            );

                if($this->job_post_model->reapply($data) === TRUE){
                    $response = array(
                            "message" => "You have successfully Re-submit your application",
                            "status" => true,
                            "id" => $vid 
                            );
                    $this->response($response, REST_Controller::HTTP_OK);
                }
            }
            else{
                $this->response(['stsus'=> FALSE], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        else{
            $this->response(['stsus'=> FALSE], REST_Controller::HTTP_BAD_REQUEST);
        }  
    }

    public function edit_post()
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
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 3)
            {
                $encrypt_id = $this->post('job_id');
                $id = $this->my_encrypt->decode($encrypt_id);
                $job['job_position'] = $this->post('jobTitle');
                $job['location_id'] = $this->post('location');
                $job['city_id'] = $this->post('city');
                $job['category'] = $this->post('jobCategory');
                $job['position'] = $this->post('jobRole');
                $job['sex'] = $this->post('gender');
                $job['civil_status'] = $this->post('civilStatus');
                $job['salary_range1'] = $this->post('salary1');
                $job['salary_range2'] = $this->post('salary2');
                $job['salary_status'] = $this->post('salaryStatus');
                $job['num_vacancies'] = $this->post('jobVacancy');
                $job['educational_attainment'] =$this->post('educAttainment');
                $job['code'] = $this->post('addRequirements');
                $job['job_description'] = $this->post('jobDesc');
                $job['expiration'] = $this->post('jobDuration');  
                $job['date_modified'] = date('Y-m-d H:i:s');  
                $job['is_active'] = 1;  

                if($this->job_post_model->update($id, $job) === TRUE)
                {
                    $response = array(
                        "status"=>TRUE,
                        "message" => "Job Post changes saved"
                        );
                    $this->response($response, REST_Controller::HTTP_OK);
                }
            }
            else{
                $this->response(["status" => FALSE], REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function approve_post()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user) && $user->account_type == 1)
            {
                $ids = $this->post('id');

                if($ids != NULL)
                {
                    foreach($ids as $id)
                    {
                        $id = $this->my_encrypt->decode($id);

                        if($this->job_post_model->approve($id) === TRUE)
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Job post has been approved",
                                //"data" => $this->job_post_model->approve($id)
                                );
                            $this->response($response, REST_Controller::HTTP_OK);
                        }
                    }
                    
                }
                else{
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }    
    }

    public function decline_post()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user) && $user->account_type == 1)
            {
                $ids = $this->post('id');

                if($ids != NULL)
                {
                    foreach($ids as $id)
                    {
                        $id = $this->my_encrypt->decode($id);

                        if($this->job_post_model->decline($id) === TRUE)
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Job post has been declined"
                                );
                            $this->response($response, REST_Controller::HTTP_OK);
                        }
                    }
                }
                else{
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }   
    }

    public function trash_post()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user) && $user->account_type == 1)
            {
                $ids = $this->post('id');

                if($ids != NULL)
                {
                    foreach($ids as $id)
                    {
                        $id = $this->my_encrypt->decode($id);

                        if($this->job_post_model->trash($id) === TRUE)
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Job post has been moved to trash"
                                );
                            $this->response($response, REST_Controller::HTTP_OK);
                        }
                    }
                }
                else{
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }   
    }

    public function review_post()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user) && $user->account_type == 1)
            {
                $ids = $this->post('id');

                if($ids != NULL)
                {
                    foreach($ids as $id)
                    {
                        $id = $this->my_encrypt->decode($id);

                        if($this->job_post_model->review($id) === TRUE)
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Job post has been Tag for Review"
                                );
                            $this->response($response, REST_Controller::HTTP_OK);
                        }
                    }
                }
                else{
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }   
    }

    public function delete_post()
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
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && ($user->account_type == 3 || $user->account_type == 1))
            {        $ids = $this->post('id');
                 
                foreach($ids as $id)
                {

                    $id = $this->my_encrypt->decode($id);
                    if($this->job_post_model->delete($id) === TRUE)
                    {
                        $response = array(
                            "status" => TRUE,
                            "message" => "Job(s) successfully deleted"
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                    else 
                    {
                        $this->response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }    
    }

    public function categories_get()
    {
        $id = $this->get('id');

        if($id === NULL)
        {
            $categories = $this->job_post_model->get_categories();

            if(!empty($categories))
            {
                $this->response($categories, REST_Controller::HTTP_OK);
            }
            else{

                $this->response([
                    "status" => FALSE,
                    "message" => "No results found"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        else{
            $category = $this->job_post_model->get_categories($id);

            if(!empty($category))
            {
                $this->response($category, REST_Controller::HTTP_OK);
            }
            else{

                $this->response([
                    "status" => FALSE,
                    "message" => "Category Not found"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function positions_get()
    {
        $id = $this->get('id');
        $cid = $this->get('cid');

        if($id === NULL && $cid === NULL)
        {
            $positions = $this->job_post_model->get_positions();

            if(!empty($positions))
            {
                $this->response($positions, REST_Controller::HTTP_OK);
            }
            else{

                $this->response([
                    "status" => FALSE,
                    "message" => "No results found"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        else{
            $position = $this->job_post_model->get_positions($id, $cid);

            if(!empty($position))
            {
                $this->response($position, REST_Controller::HTTP_OK);
            }
            else{

                $this->response([
                    "status" => FALSE,
                    "message" => "Job Role Not found"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function categories_post()
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
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 1)
            {
                $data['category_name'] = $this->post('category');
                $data['is_active'] = 1;

                if($data['category_name'] != NULL)
                {
                    if($this->job_post_model->createCategory($data) === TRUE)
                    {
                        $response = array(
                                "message" => "Job Category created",
                                "status" => true,
                                "data" => $data['category_name']
                                );
                        $this->response($response, REST_Controller::HTTP_CREATED);
                    }
                }
                else{
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }    
    }

    public function categories_patch()
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
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 1)
            {

                $id = $this->patch('id');
                $data['category_name'] = $this->patch('category');
                $action = $this->patch('action');

                if($action != NULL && $action == "disable")
                {
                    if($id != NULL)
                    {
                        if($this->job_post_model->disableCategory($id) === TRUE)
                        {
                            $response = array(
                                "message" => "Category has been deleted",
                                "status" => true,
                                "id" => $id
                                );
                            $this->response($response, REST_Controller::HTTP_OK);
                        }
                        else{
                            $this->response(NULL, REST_Controller::HTTP_NO_CONTENT);   
                        }
                    }
                    else{
                        $response = array(
                                "message" => "Category has been deleted",
                                "status" => true,
                                "id" => $id,
                                "action" => $action 
                                );
                        $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
                else{
                    if($data['category_name'] != NULL && $id != NULL)
                    {
                        if($this->job_post_model->updateCategory($id, $data) === TRUE)
                        {
                            $response = array(
                                "message" => "Category updated",
                                "status" => true
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                        else{
                            $this->response(NULL, REST_Controller::HTTP_NO_CONTENT);
                        }
                    }
                    else{
                        $this->response("missing data parameters", REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }    
    }

    public function positions_post()
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
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 1)
            {        
                $data['name'] = $this->post('position');
                $data['category_id'] = $this->post('category_id');
                $data['is_active'] = 1;

                if($data['name'] != NULL)
                {
                    if($this->job_post_model->createPosition($data) === TRUE)
                    {
                        $response = array(
                                "message" => "New Position created",
                                "status" => true,
                                "data" => $data['name']
                                );
                        $this->response($response, REST_Controller::HTTP_CREATED);
                    }
                }
                else{
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }   
    }

    public function positions_patch()
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
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->patch('id');
                $data['name'] = $this->patch('position');
                $data['category_id'] = $this->patch('category_id');
                $action = $this->patch('action');

                if($action != NULL && $action == "disable")
                {
                    if($id != NULL)
                    {
                        if($this->job_post_model->disablePosition($id) === TRUE)
                        {
                            $response = array(
                                "message" => "Job Role has been disabled",
                                "status" => true
                                );
                            $this->response($response, REST_Controller::HTTP_OK);
                        }
                        else{
                            $this->response(NULL, REST_Controller::HTTP_NO_CONTENT);   
                        }
                    }
                    else{
                        $this->response(array("message"=>"missing data parameters"), REST_Controller::HTTP_BAD_REQUEST);
                    }    
                }
                else{
                    if($data['name'] != NULL && $id != NULL)
                    {
                        if($this->job_post_model->updatePosition($id, $data) === TRUE)
                        {
                            $response = array(
                                "message" => "Job Role updated",
                                "status" => true
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                        else{
                            $this->response(NULL, REST_Controller::HTTP_NO_CONTENT);
                        }
                    }
                    else{
                        $response = array(
                                "message" => "Missing data parameters",
                                "status" => false,
                                );
                        $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    
    public function job_status_get()
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
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

            if(!empty($user)){
                
                $query = $this->job_post_model->getJobStatus();
                $status = array();

                foreach($query as $stat){
                    $status[] = array(
                        "id" => $stat['id'],
                        "status" => $stat['status_name']
                        );
                }

                $this->response($status, REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }   
    }

}    
