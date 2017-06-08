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
class Companies extends REST_Controller {

    function __construct()
    {
        
        parent::__construct();

        $this->load->model('job_post_model');
        $this->load->model('registration/registration_model','reg_model');
        $this->load->model('company_model');
        $this->load->model('auth_model');
        $this->load->model('applicant/applicant_model_rest','app_model');
        $this->load->library('my_encrypt');
        $this->load->module('functions/functions');
        date_default_timezone_set('Asia/Manila');
        
    }

    public function index_get()
    {       
        $id = $this->get('id');
        $status = ($this->get('status') === NULL)? "active" : $this->get('status');
        $keyword = ($this->get('keyword') === NULL)? FALSE: $this->get('keyword');
        $offset = ($this->get('offset') === NULL)? 0 : $this->get('offset');
        $region = ($this->get('region') === NULL)? FALSE : $this->get('region'); 
        $industry = ($this->get('industry') === NULL)? FALSE : $this->get('industry');

        if($id === NULL)
        {
            $query = $this->company_model->get($id = FALSE, $status, $offset, $industry, $region, $keyword);

            if(!empty($query['data']))
            {
                foreach($query['data'] as $company)
                {
                    $companies[] = array(
                        "id" => $company['cid'],
                        "company" => $company['company_name'],
                        "location" => $company['street_1'].", ".$company['city_1'].", ".$company['province_1'],
                        "logo" => base_url().str_replace("./", "", $company['profile_pic']),
                        "industry" => $company['industry'],
                        "company_description" => substr($company['company_description'], 0,150).'...',
                        "contact_person_fName" => $company['first_name'],
                        "contact_person_mName" => $company['middle_name'],
                        "contact_person_lName" => $company['last_name'],
                        "contact_person_position" => $company['position'],
                        "user_id" => $company['user_id'],
                        "email" => $company['email'],
                        "mobile_no" => $company['mobile_num'],
                        "telephone_number" => $company['telephone_number'],
                        "url" => $company['company_website'],
                        "date_registered" => $company['company_date_created'],
                        "limit" => $query['limit'],
                        "totalFiltered" => $query['filtered'],
                        "totalRecords" => $this->company_model->getTotalRows($status)
                        );
                }

                $this->response($companies, REST_Controller::HTTP_OK);
            }
            else
            {
                $response = array(
                    "data" => [],
                    "limit" => 10,
                    "totalFiltered" => 1,
                    "totalRecords" => $this->company_model->getTotalRows($status)
                    );
                $this->response($response, REST_Controller::HTTP_OK);

            }   
        }
        else
        {
            $query = $this->company_model->get($id);
            $company = array();

            if(!empty($query))
            {
                $company = array(
                    "company_name" => $query['0']['company_name'],
                    "banner" => ($query['0']['company_banner']!="")? base_url().str_replace("./", "",$query['0']['company_banner']): base_url('assets/images/Default_Company_Banner.png'),
                    "logo" => base_url().str_replace("./", "", $query['0']['profile_pic']),
                    "industry" => $query['0']['industry_name'],
                    "email" => $query['0']['email'],
                    "address" => $query['0']['street_1'].', '.$query['0']['city_1'].', '.$query['0']['province_1'],
                    "site" => $query['0']['company_website'],
                    "details" => $query['0']['company_description'] 
                    );
                $this->response($company, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response([
                    "status" => FALSE,
                    "message" => "Company doesn't exits"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        } 
    }

    public function index_post()
    {
        $form_token = $_POST['form_token'];
        if($form_token != "" || $form_token != NULL)
        {
            if($form_token == $this->session->userdata('form_token'))
            {
                $uid = $this->functions->guid();
                $employer_info['user_id'] = $uid;
                $employer_info['company_name'] = strtoupper($_POST['company_name']); 
                $employer_info['industry'] = $_POST['company_industry'];
                $employer_info['street_1'] = $_POST['street_address'];

                $employer_info['city_1'] = $_POST['region_id'];
                $employer_info['province_1'] =  $_POST['city_id'];

                $employer_info['company_description'] = trim($_POST['company_description']); 
                $employer_info['first_name'] = strtoupper($_POST['firstname']); 
                $employer_info['middle_name'] = strtoupper($_POST['middlename']); 
                $employer_info['last_name'] = strtoupper($_POST['lastname']); 

                $landline = ($_POST['landline']!='')? $_POST['landline']: "";  
                $area_code = ($_POST['area_code'] != '')? $_POST['area_code']: "";
                $employer['telephone_number'] = $landline;
                $employer['area_code'] = $area_code;
                $employer_info['position'] = $_POST['position'];
                $employer_info['department'] = strtoupper($_POST['department']);
                $employer_info['is_active'] = 1;
                $employer_acct['user_id'] = $uid;
                $password = $_POST['password'];
                $employer_acct['password'] = $this->my_encrypt->encrypt($password);
                $employer_acct['email'] = $_POST['email']; 
                $mobile_no = str_replace("-","",$_POST['phonenumber']);
                $employer_acct['mobile_num'] = $mobile_no;
                $employer_acct['account_type'] = 3;
                $employer_acct['date_created'] = date('Y-m-d h:i:s'); 
                $employer_acct['status'] = 0;
                $employer_acct['status_1'] = 0; 
                $employer_acct['is_active'] = 1;

                //send email verification
                $temp_name = strtolower($employer_info['first_name']);
                $firstname = ucfirst($temp_name);
                $activationCode = md5($uid);
                $email = $employer_acct['email'] = $_POST['email'];
                $subject = "Jobfair-Online Email Verification"; 

                $content = "";
                $content .= "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
                $content .= "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>";
                $content .= "<head>";
                $content .= "<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>";
                $content .= "<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>";
                $content .= "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css' integrity='sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi' crossorigin='anonymous'>";
                $content .= "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js' integrity='sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK' crossorigin='anonymous'></script>";
                $content .= "<title>Jobfair-Online</title>";
                $content .= "</head>";
                $content .= "<body style='background: #eeeeee'>";
                $content .= "<table align='center' 'border='0' width='600' cellpadding='0' cellspacing='0' style='border-spacing: 20px;border-collapse: collapse;'>";
                $content .= "<thead style='background: #fff;'>";
                $content .= "<tr>";
                $content .= "<td align='center' style='padding: 30px'><h1>JobFair-Online Email Verification</h1></td>";
                $content .= "<tr>";
                $content .= "<tr>";
                $content .= "<td><hr></td>";
                $content .= "</tr>";
                $content .= "</thead>";
                $content .= "<tbody style='background: #fff;'>";
                $content .= "<tr>";
                $content .= "<td style=' font-size: 4.5rem;font-weight: 300;padding: 20px 30px 0;color: #12b5c4; '><h3>Hello ".$firstname."</h3></td>";
                $content .= "</tr>";
                $content .= "<tr>";
                $content .= "<td style='padding: 0 30px 0;'> ";
                $content .= "<br>"; 
                $content .= "<p class='lead' style='text-indent: 14px;'>";
                $content .= "You have successfully registered your employer account to Jobfair-Online.net. Please <a href='".base_url()."accounts/employers/activate/?ucode=".$activationCode."&type=3'>verify</a> your account.";

                $content .= "</p>";
                $content .= "</td>";
                $content .= "</tr>";
                $content .= "<tr>";
                $content .= "<td align='right' style='padding: 50px 30px 50px;'>Thank you ! <br/><i><a style='font-style: italic;color: #12b5c4;text-decoration:none;' href='#'>-People LInk Staffing Solutions</a></i>";
                $content .= "</td>";
                $content .= "</tr>";
                $content .= "</tbody>";
                $content .= "<tfoot style='text-align: center; background-color: #fff;'>";
                $content .= "<tr>";
                $content .= "<td><hr></td>";
                $content .= "</tr>";    
                $content .= "<tr>";
                $content .= "<td style='padding: 30px'>Contact Us @  <a style='color: #12b5c4;text-decoration:none;' href='mailto:jobfaironline.ph'>jobfaironline.ph</a> <br>Call us: 621-2324</td>";
                $content .= "</tr>";
                $content .= "</tfoot>";
                $content .= "</table>";
                $content .= "</body>";
                $content .= "</html>";  

                $upload_response = $this->functions->upload_userPhoto($uid, $employer_acct['account_type'] , $_FILES['userfile']['name']);
                
                if($upload_response['status'] === TRUE)
                {

                    $employer_info['profile_pic'] = $upload_response['profile_path'];
                    if($this->company_model->create($employer_info, $employer_acct))
                    {   
                        $log['user_id'] = $uid;
                        $log['audit_action'] = 2;
                        $log['table_name'] = "tb_users";
                        $log['record_id'] = $uid;
                        $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                        $log['date'] = date('Y-m-d H:i:s');
                        $log['is_active'] = 1;
                        $this->log_model->save($log);
                        
                        $comp_activation_code = $this->auth_model->newUserActivationCode($activationCode, $uid, $employer_acct['date_created']);
                        $email_response = $this->functions->sendEmail($email, $subject, $content);
                        
                        if($email_response == TRUE)
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "You have successfully registered your account! Pleas verify your email to make sure this email exists ",
                                "token" => "user token here and redirect to login",
                                "info" => $employer_info,
                                "acct" => $employer_acct,
                                "other_response" => $upload_response ,
                                "email_response" => $email_response,
                                "activation_id" => $comp_activation_code
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                    } 
                }  
            }    
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => '' 
                    ],REST_Controller::HTTP_FORBIDDEN);
            } 
        }
        else{
            $this->response([
                    'status' => FALSE,
                    'message' => '' 
                    ],REST_Controller::HTTP_FORBIDDEN);
        }          
    }

    public function index_patch()
    {
        if(!isset($_COOKIE['_ut']))
        {
            $this->response(['status' => FALSE, 'message' => 'REQUEST FORBIDDEN' ],REST_Controller::HTTP_FORBIDDEN);
        }
        else{
            
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user) && $user->account_type == 3)
            {
                $id = $user->user_id;

                $operation = $this->patch('op');

                if($operation != NULL){
                    if($operation == "general_update"){

                        $data['company_name'] = $this->patch('company_name');
                        $data['street_1'] = $this->patch('street_address');
                        $data['industry'] = $this->patch('company_industry');
                        $data['city_1'] = $this->patch('city');
                        $data['province_1'] =  $this->patch('province');
                        $data['company_description'] = $this->patch('company_description');
                        $data['company_website'] = $this->patch('company_website');

                        if($this->company_model->update($id, $data))
                        {
                            $log['user_id'] = $user->user_id;
                            $log['audit_action'] = 14;
                            $log['table_name'] = "tb_employer";
                            $log['record_id'] = $user->user_id;
                            $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                            $log['date'] = date('Y-m-d H:i:s');
                            $log['is_active'] = 1;
                            $this->log_model->save($log);

                            $response = array(
                                "status"=>TRUE,
                                "message" => "Company profile changes saved",
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                    }
                    if($operation == "contact_info_update"){

                        $data['first_name'] = $this->patch('first_name');
                        $data['middle_name'] = $this->patch('middle_name');
                        $data['last_name'] = $this->patch('last_name');
                        $data['position'] = $this->patch('position');
                        $data['department'] = $this->patch('department');
                        $data['area_code'] = $this->patch('area_code');
                        $data['telephone_number'] = $this->patch('landline');

                        if($this->company_model->update($id, $data))
                        {
                            $log['user_id'] = $user->user_id;
                            $log['audit_action'] = 14;
                            $log['table_name'] = "tb_employer";
                            $log['record_id'] = $user->user_id;
                            $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                            $log['date'] = date('Y-m-d H:i:s');
                            $log['is_active'] = 1;
                            $this->log_model->save($log);

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
                                $data['email'] = $newEmail;

                                if($this->company_model->updateAccount($user->user_id, $data) === TRUE)
                                {
                                    $log['user_id'] = $user->user_id;
                                    $log['audit_action'] = 16;
                                    $log['table_name'] = "tb_users";
                                    $log['record_id'] = $user->user_id;
                                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                                    $log['date'] = date('Y-m-d H:i:s');
                                    $log['is_active'] = 1;
                                    $this->log_model->save($log);

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
                                $data['mobile_num'] = $new_mobile;

                                if($this->company_model->updateAccount($user->user_id, $data) === TRUE)
                                {
                                    $log['user_id'] = $user->user_id;
                                    $log['audit_action'] = 14;
                                    $log['table_name'] = "tb_users";
                                    $log['record_id'] = $user->user_id;
                                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                                    $log['date'] = date('Y-m-d H:i:s');
                                    $log['is_active'] = 1;
                                    $this->log_model->save($log);

                                    $response = array(
                                        "status" => true,
                                        "message" => "New mobile number saved",
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
                            $data['password'] = $new_password;

                            if($this->company_model->updateAccount($user->user_id, $data) === TRUE)
                            {
                                $log['user_id'] = $user->user_id;
                                $log['audit_action'] = 17;
                                $log['table_name'] = "tb_users";
                                $log['record_id'] = $user->user_id;
                                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                                $log['date'] = date('Y-m-d H:i:s');
                                $log['is_active'] = 1;
                                $this->log_model->save($log);

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
                }
                else{
                    $this->response(['success' => FALSE, 'message' => 'Missing Argument Paramerter' ],REST_Controller::HTTP_BAD_REQUEST);
                }
                
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function active_post()
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

                   if($this->company_model->setAsActive($id) === TRUE)
                    {
                        $response = array(
                            "status"=>TRUE,
                            "message" => "Employer(s) has been set as Active",
                            "id" => $id
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                }

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 54;
                $log['table_name'] = "tb_users";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function inactive_post()
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

                   if($this->company_model->setAsInactive($id) === TRUE)
                    {
                        $response = array(
                            "status"=>TRUE,
                            "message" => "Employer(s) has been set as Inactive"
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                }

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 55;
                $log['table_name'] = "tb_users";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function industries_get()
    {
        $id = $this->get('id');

        if($id === NULL)
        {
            $industries = $this->company_model->get_industries();

            if(!empty($industries))
            {
                $this->response($industries, REST_Controller::HTTP_OK);
            }
            else{

                $this->response([
                    "status" => FALSE,
                    "message" => "No results found"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        else{
            $industry = $this->company_model->get_industries($id);

            if(!empty($industry))
            {
                $this->response($industry, REST_Controller::HTTP_OK);
            }
            else{

                $this->response([
                    "status" => FALSE,
                    "message" => "No result found"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function industries_post()
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
                $data['industry_name'] = $this->post('industry');
                $data['is_active'] = 1;

                if($data['industry_name'] != NULL)
                {
                    if($this->company_model->createIndustry($data) === TRUE)
                    {
                        $log['user_id'] = $user->user_id;
                        $log['audit_action'] = 44;
                        $log['table_name'] = "tb_industry";
                        $log['record_id'] = $user->user_id;
                        $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                        $log['date'] = date('Y-m-d H:i:s');
                        $log['is_active'] = 1;
                        $this->log_model->save($log);

                        $response = array(
                                "message" => "New Industry created",
                                "status" => true
                                );
                        $this->response($response, REST_Controller::HTTP_CREATED);
                    }
                }
                else{
                    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function industries_patch()
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
                $id = $this->patch('id');
                $data['industry_name'] = $this->patch('industry');
                $action = $this->patch('action');

                if($action != NULL && $action == "disable")
                {
                    if($id != NULL)
                    {
                        if($this->company_model->disableIndustry($id) === TRUE)
                        {
                            $log['user_id'] = $user->user_id;
                            $log['audit_action'] = 46;
                            $log['table_name'] = "tb_industry";
                            $log['record_id'] = $user->user_id;
                            $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                            $log['date'] = date('Y-m-d H:i:s');
                            $log['is_active'] = 1;
                            $this->log_model->save($log);

                            $response = array(
                                "message" => "Industry has been deleted",
                                "status" => true
                                );
                            $this->response($response, REST_Controller::HTTP_OK);
                        }
                        else{
                            $this->response(NULL, REST_Controller::HTTP_NO_CONTENT);   
                        }
                    }
                    else{
                        $this->response("missing data parameters", REST_Controller::HTTP_BAD_REQUEST);
                    }    
                }
                else{
                    if($data['industry_name'] != NULL && $id != NULL)
                    {
                        if($this->company_model->updateIndustry($id, $data) === TRUE)
                        {
                            $log['user_id'] = $user->user_id;
                            $log['audit_action'] = 45;
                            $log['table_name'] = "tb_industry";
                            $log['record_id'] = $user->user_id;
                            $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                            $log['date'] = date('Y-m-d H:i:s');
                            $log['is_active'] = 1;
                            $this->log_model->save($log);

                            $response = array(
                                "message" => "Industry updated",
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
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function jobs_get()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            $job_status = ($this->get('status') === NULL)? "published" : $this->get('status'); 
           

            if(isset($_COOKIE['_ut']))
            {
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                
                if(!empty($user) && $user->account_type == 3)
                {
                    $userId = $user->user_id;

                    $query =  $this->job_post_model->get($encrypted_job_id = FALSE, $limit = FALSE, $offset = FALSE, $keyword = FALSE, $region = FALSE, $category = FALSE, $job_status, $company_id = FALSE, $except = FALSE, $userId);

                    $jobs = array();

                    if(!empty($query['data']))
                    {
                        foreach($query['data'] as $job)
                        {
                            $salary1 = floatval($job['salary_range1']);
                            $salary2 = floatval($job['salary_range2']);
                            $salary = ($job['salary_status'] == 1)? number_format($salary1).'-'.number_format($salary2):0; 
                            $job_id = $job['job_id'];
                            
                            
                            $jobs[] = array(
                                "id" =>  $this->my_encrypt->encode($job_id),
                                "position" => $job['job_position'],
                                "cid" => $job['company_id'],
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
                else{
                    $this->response([
                        'status' => FALSE,
                        'message' => 'REQUEST UNAUTHORIZED' 
                        ],REST_Controller::HTTP_UNAUTHORIZED);
                }   
            }
        }
    }

    public function job_applicants_get()
    {
        if(!isset($_COOKIE['_ut'])){
            $this->response([
                'status' => FALSE,
                'message' => 'REQUEST UNAUTHORIZED' 
                ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        else
        {
            if(isset($_COOKIE['_ut']))
            {
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);

                $keyword = ($this->get('keyword') === NULL)? FALSE: urldecode($this->get('keyword'));
                if(!empty($user))
                {
                    $job_id = ($this->get('job_id') === NULL)? FALSE : $this->my_encrypt->decode($this->get('job_id'));
                    $offset = ($this->get('offset') === NULL)? 0 : $this->get('offset');
                    $region = ($this->get('region') === NULL)? FALSE : $this->get('region'); 
                    $category = ($this->get('category') === NULL)? FALSE : $this->get('category');
                    $status = ($this->get('status')===NULL)? FALSE : $this->get('status');

                    $query = $this->company_model->get_job_applicants($user->user_id, $job_id, $offset, $keyword, $region, $category, $status);
                    
                    if(!empty($query['data']))
                    {
                        $applicants = array();
                        $work_history = array();
                       
                        foreach($query['data'] as $app)
                        {


                            $workHistory = $this->app_model->get_work_history($app['applicant_id']);

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
                                "vid" => $this->my_encrypt->encode($app['vid']),
                                "job_id" => $app['job_id'],
                                "applied_position" => $app['job_position'],
                                "data_applied" => $app['date_applied'],
                                "stat_id" => $app['stat_id'],
                                "status" => $app['status'],
                                "apl_id" => $app['applicant_id'],
                                "first_name" => $app['apl_fname'],
                                "middle_name" => $app['apl_mname'],
                                "last_name" => $app['apl_lname'],
                                "profile_photo" =>  ($app['profile_pic'] != "")?base_url().str_replace("./", "", $app['profile_pic']):base_url().'assets/images/Default_User1.png',
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
                                "work_history" => $work_history,
                                "religion" => $app['religion'],
                                "birthdate" => $app['birth_date'],
                                "street" => $app['street_1'],
                                "limit" => $query['limit'],
                                "totalFiltered" => $query['filtered'],
                                "totalRecords" => $this->company_model->getJobApplicantsTotal($user->user_id, $job_id, $keyword, $region, $category, $status),
                    
                            ); 
 
                            $work_history = array();
                        }

                        $this->response($applicants, REST_Controller::HTTP_OK); 
                    }
                    else
                    {
                        $response = array(
                            "data" => [],
                            "limit" => 10,
                            "totalFiltered" => 1,
                            "totalRecords" => $this->company_model->getJobApplicantsTotal($user->user_id),
                            "parameters" => $keyword
                            );
                        $this->response($response, REST_Controller::HTTP_OK); 
                    }
                }
                else{
                    $this->response(['status'=>FALSE, "response"=> "REQUEST UNAUTHORIZED"], REST_Controller::HTTP_UNAUTHORIZED);
                }
            }
        }
    }

    public function tag_as_reviewed_post()
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

            if(!empty($user) && $user->account_type == 3)
            {
                $ids = $this->post('id');

                foreach($ids as $id)
                {

                    $id = $this->my_encrypt->decode($id);
                    if($this->job_post_model->tagAsReviewed($id) === TRUE)
                    {
                        $response = array(
                            "status"=>TRUE,
                            "message" => "Applicant(s) has been Tag as Reviewed",
                            "id" => $id
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }

                }   

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 32;
                $log['table_name'] = "tb_verification";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function tag_for_interview_post()
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

            if(!empty($user) && $user->account_type == 3)
            {
                $ids = $this->post('id');
                
                foreach($ids as $id)
                {

                    $id = $this->my_encrypt->decode($id);
                    if($this->job_post_model->tagForInterview($id) === TRUE)
                    {
                        $response = array(
                            "status"=>TRUE,
                            "message" => "Applicant(s) has been Tag for Interview"
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                } 

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 34;
                $log['table_name'] = "tb_verification";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1; 
                $this->log_model->save($log);
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }    
    }

    public function tag_as_reject_post()
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

            if(!empty($user) && $user->account_type == 3)
            {
                $ids = $this->post('id');

                foreach($ids as $id)
                {

                    $id = $this->my_encrypt->decode($id);
                    if($this->job_post_model->tagAsReject($id) === TRUE)
                    {
                        $response = array(
                            "status" => TRUE,
                            "message" => "Applicant(s) has been Tag as Reject"
                            );
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                }

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 33;
                $log['table_name'] = "tb_verification";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'REQUEST UNAUTHORIZED' 
                    ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }      
    }

    public function upload_photo_post()
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

            if(!empty($user) && $user->account_type == 3)
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

                    if($this->company_model->update($user->user_id, $data)){
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

    public function banner_post()
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

            if(!empty($user) && $user->account_type == 3)
            {   

                $rand_id = time();
                $file_name = $rand_id.preg_replace('/\s+/', '_', $_FILES['userfile']['name']);
                $upload_response = $this->functions->upload_banner($user->user_id, $file_name);

                if($upload_response['status'] == TRUE)
                {
                    if(isset($_POST['prev_img']))
                    {
                        $old_img = $_POST['prev_img'];
                        unlink($old_img);  
                    }
                     
                    $data['company_banner'] = $upload_response['path'];

                    if($this->company_model->update($user->user_id, $data)){
                        $response = array(
                            "status"=>TRUE,
                            "message"=>"Company has been saved"
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

    public function banner_get()
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

            if(!empty($user) && $user->account_type == 3)
            {

                $company = $this->company_model->get($user->user_id);
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function notifications_get()
    {
        $this->load->model('notification/notification_model');
         
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

            if(!empty($user) && $user->account_type == 3)
            { 
                $query = $this->notification_model->getNotification($user->user_id);
                $notifications = array();

                foreach($query as $notif)
                {
                    $notifications[] = array(
                        "id" => $notif->id,
                        "notification" => $notif->notification,
                        "notification_html" => $notif->notification_html,
                        "link" => $notif->notif_url,
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

                    $employer = $this->company_model->getById($id);
                    
                    if($employer->company_banner != ""){
                        $bannerPathArr = explode("/", $employer->company_banner);
                        unlink($employer->company_banner);
                        end($bannerPathArr);
                        rmdir("./assets/images/uploads/company_banner/".prev($bannerPathArr));
                    }
                    if($employer->profile_pic != ""){
                       $pathArr = explode("/", $employer->profile_pic);
                       unlink($employer->profile_pic);
                       end($pathArr);
                       rmdir("./assets/images/uploads/company_logos/".prev($pathArr));
                    }
                   
                    if($this->company_model->deleteAccount($id) === TRUE)
                    {
                        $response = array(
                            "status"=>TRUE,
                            
                            );
                        $this->response($response, REST_Controller::HTTP_NO_CONTENT);

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
}    
