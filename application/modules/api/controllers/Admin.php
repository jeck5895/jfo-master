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
class Admin extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        date_default_timezone_set('Asia/Manila');
        $this->load->model('admin_model');
        $this->load->module('functions/functions');
        $this->load->model('job_post_model');
        $this->load->model('auth_model');
    }

    public function index_get()
    {

    }

    public function index_post()
    {
        $uid = $this->functions->guid();
        $phonenumber = str_replace("-", "", $this->post('phonenumber'));
        $admin_info['user_id'] = $uid;
        $admin_info['first_name'] = $this->post('firstname');
        $admin_info['middle_name'] = $this->post('middlename');
        $admin_info['last_name'] = $this->post('lastname');
        $admin_info['street'] = $this->post('street');
        $admin_info['city'] = $this->post('city_id');
        $admin_info['province'] = $this->post('region_id');
        $admin_info['date_create'] = date("Y-m-d h:i:s");
        $admin_info['is_active'] = 1;

        $admin_acct['user_id'] = $uid;
        $admin_acct['username'] = $phonenumber;
        $password = md5($this->post('password'));
        $admin_acct['password'] = $this->my_encrypt->encrypt($password);
        $admin_acct['email'] = $this->post('email');
        $admin_acct['mobile_num'] = $phonenumber;
        $admin_acct['account_type'] = $this->post('acct_type');
        $admin_acct['date_created'] = date('Y-m-d h:i:s');
        $admin_acct['status'] = 1;
        $admin_acct['status_1'] = 1;
        $admin_acct['is_active'] = 1;

        if($this->admin_model->create($admin_info, $admin_acct))
        {
            $log['user_id'] = $uid;
            $log['audit_action'] = 15;
            $log['table_name'] = "tb_users";
            $log['record_id'] = $uid;
            $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $log['date'] = date('Y-m-d H:i:s');
            $log['is_active'] = 1;
            $this->log_model->save($log);

            $response = array(
                "status"=>TRUE,
                "message" => "New Account has been created",
                "info" => $admin_info,
                "acct" => $admin_acct
                );
            $this->response($response, REST_Controller::HTTP_CREATED);
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $user->user_id;

                $operation = $this->patch('op');

                if($operation != NULL){

                    if($operation == "general_info_update"){

                        $data['first_name'] = $this->patch('first_name');
                        $data['middle_name'] = $this->patch('middle_name');
                        $data['last_name'] = $this->patch('last_name');
                        $data['street'] = $this->patch('street');
                        $data['province'] = $this->patch('province');
                        $data['city'] = $this->patch('city');

                        if($this->admin_model->update($id, $data))
                        {
                            $log['user_id'] = $user->user_id;
                            $log['audit_action'] = 56;
                            $log['table_name'] = "tb_sri_account";
                            $log['record_id'] = $user->user_id;
                            $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                            $log['date'] = date('Y-m-d H:i:s');
                            $log['is_active'] = 1;
                            $this->log_model->save($log);

                            $response = array(
                                "status"=>TRUE,
                                "message" => "Profile changes saved",
                                "data" => $data
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

                                if($this->admin_model->updateAccount($user->user_id, $data) === TRUE)
                                {
                                    $log['user_id'] = $user->user_id;
                                    $log['audit_action'] = 56;
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

                                if($this->admin_model->updateAccount($user->user_id, $data) === TRUE)
                                {
                                    $log['user_id'] = $user->user_id;
                                    $log['audit_action'] = 56;
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

                            if($this->admin_model->updateAccount($user->user_id, $data) === TRUE)
                            {
                                $log['user_id'] = $user->user_id;
                                $log['audit_action'] = 56;
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

    public function banner_post()
    {
        $user_id = $this->session->userdata('active_admin')->user_id;
        $banner_id = $this->functions->guid();
        $img_name = $_FILES['userfile']['name'];

        $res = $this->functions->upload_banner($banner_id, $img_name);

        if($res['status'] === TRUE)
        {
            $banner['user_id'] = $user_id;
            $banner['is_active'] = 1;
            $banner['date_created'] = date('Y-m-d h:i:s');
            $banner['status'] = 1;
            $banner['img_link'] = $res['path']."/".$img_name;

            if($this->admin_model->saveBanner($banner))
            {
                $response = array(
                    "status"=>TRUE,
                    "message" => "Banner has been upload",
                    );
                $this->response($response, REST_Controller::HTTP_CREATED);
            }
        }
        else{
            $response = array(
                "status"=>FALSE,
                "message" => $res['error'],
                );
            $this->response($response, REST_Controller::HTTP_NO_CONTENT);
        }
    }

    public function advertisement_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $ads['user_id'] = $user->user_id;
                $ads['company_name'] = $this->post('company_name');
                $ads['ads_title'] = $this->post('ads_title');
                $ads['ads_url'] = $this->post('ads_link');
                $ads['duration'] = $this->post('duration');
                $ads['date_created'] = date('Y-m-d h:i:s');
                $ads['is_active'] = 0;
                
                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 57;
                $log['table_name'] = "tb_advertisement";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);

                if($adsId = $this->admin_model->saveAdvertisementSlider($ads))
                {
                    $rand_id = time();
                    $filename = $rand_id.preg_replace('/\s+/', '_', $_FILES['userfile']['name']);
                    $folder = md5($rand_id.$this->functions->guid());
                    $upload_response = $this->functions->upload_advertisement($folder, $filename);

                    if($upload_response['status'] === TRUE)
                     {
                        $data['upload_path'] = $upload_response['path'];
                        $data['filename'] = $filename;
                        if($this->admin_model->updateAdvertisementSlider($adsId, $data))
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Advertisement has been saved",
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                    }
                    else{
                        $this->admin_model->deleteErrorUpload($adsId); //delete record of error upload file
                        rmdir($upload_response['path']); //delete folder
                        $response = array(
                            "status"=>TRUE,
                            "message" => $upload_response['error'],
                            );
                        $this->response($response, REST_Controller::HTTP_NO_CONTENT);
                    }
                }
                else{
                        $response = array(
                            "status"=>TRUE,
                            "message" => $adsId,
                            );
                        $this->response($response, REST_Controller::HTTP_CREATED);
                    }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function advertisement_activate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getAdvertisementSlider($id);
                $ads['start_date'] = date('Y-m-d H:i:s');
                $ads['end_date'] = date("Y-m-d H:i:s", strtotime('+'.$query->duration." day"));
                $ads['is_active'] = 1;

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 60;
                $log['table_name'] = "tb_advertisement";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
                
                
                if($fID = $this->admin_model->updateAdvertisementSlider($id, $ads))
                {

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Slider has been activated",                         
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function advertisement_deactivate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getAdvertisementSlider($id);
                $ads['start_date'] = NULL;
                $ads['end_date'] = NULL;
                $ads['is_active'] = 0;

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 61;
                $log['table_name'] = "tb_advertisement";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
                
                
                if($fID = $this->admin_model->updateAdvertisementSlider($id, $ads))
                {

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Slider has been deactivated",                         
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function advertisement_patch()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $ads_id = $this->my_encrypt->decode($this->patch('ads_id'));
                $ads['company_name'] = $this->patch('company_name');
                $ads['ads_title'] = $this->patch('ads_title');
                $ads['ads_url'] = $this->patch('ads_link');
                $ads['duration'] = $this->patch('duration');
        
                if($this->admin_model->updateAdvertisementSlider($ads_id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 58;
                    $log['table_name'] = "tb_advertisement";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(
                        "status"=>TRUE,
                        "message" => "Advertisement changes saved",
                        );
                    $this->response($response, REST_Controller::HTTP_CREATED);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }

    }

    public function advertisement_delete()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $ads_id = $this->my_encrypt->decode($this->delete('id'));

                $query = $this->admin_model->getAdvertisementSlider($ads_id);
            
                unlink($query->upload_path."/".$query->filename);
                rmdir($query->upload_path);
                $this->admin_model->deleteErrorUpload($ads_id);

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 59;
                $log['table_name'] = "tb_advertisement";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
                
                $response = array(
                    "status"=>TRUE,
                    "message" => "Advertisement deleted",
                    );
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function advertisement_get()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->get('id'));

                if($id == NULL)
                {
                    $sliderImages = array();
                    $query = $this->admin_model->getAdvertisementSlider();

                    if(!empty($query))
                    {
                        foreach($query as $image)
                        {
                            $sliderImages[] = array(
                                "path" => base_url().str_replace("./", "", $image->upload_path)."/".$image->filename,
                                "ads_url" => $image->ads_url,
                                "ads_title" => $image->ads_title,
                                "company" => $image->company_name,
                                "start_date" => $image->start_date,
                                "end_date" => $image->end_date
                                );
                        }

                        $this->response($sliderImages, REST_Controller::HTTP_OK);
                    }else{
                        $this->response(['status'=>FALSE,'message'=>'Advertisement not found'], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
                else{
                    $query = $this->admin_model->getAdvertisementSlider($id);
                    
                    if(!empty($query))
                    {
                        $sliderImage = array(
                            "path" => base_url().str_replace("./", "", $query->upload_path)."/".$query->filename,
                            "ads_url" => $query->ads_url,
                            "ads_title" => $query->ads_title,
                            "company" => $query->company_name,
                            "duration" => $query->duration
                            );
                        $this->response($sliderImage, REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response(['status'=>FALSE,'message'=>'Advertisement not found',"data"=> $query], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function advertisement_logo_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $ads['title'] = $this->post('ads_title');
                $ads['ads_url'] = $this->post('ads_link');
                $ads['duration'] = $this->post('duration');
                $ads['date_created'] = date('Y-m-d h:i:s');
                $ads['is_active'] = 0;
                $response = array(
                                "status"=>TRUE,
                                "message" => "Logo has been saved",
                                "data" => $ads
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 57;
                $log['table_name'] = "tb_advertisement";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);

                if($adsId = $this->admin_model->saveAdvertisementLogo($ads))
                {
                    $rand_id = time();
                    $filename = $rand_id.preg_replace('/\s+/', '_', $_FILES['userfile']['name']);
                    $folder = md5($rand_id.$this->functions->guid());
                    $upload_response = $this->functions->upload_advertisement_logo($folder, $filename);

                    if($upload_response['status'] === TRUE)
                     {
                        $data['upload_path'] = $upload_response['path'];
                        $data['filename'] = $filename;
                        if($this->admin_model->updateAdvertisementLogo($adsId, $data))
                        {
                            $response = array(
                                "status"=>TRUE,
                                "message" => "Advertisement has been saved",
                                );
                            $this->response($response, REST_Controller::HTTP_CREATED);
                        }
                    }
                    else{
                        $this->admin_model->deleteErrorUploadLogo($adsId); //delete record of error upload file
                        rmdir($upload_response['path']); //delete folder
                        $response = array(
                            "status"=>TRUE,
                            "message" => $upload_response['error'],
                            );
                        $this->response($response, REST_Controller::HTTP_NO_CONTENT);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }   
    }

    public function advertisement_logo_activate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getAdvertisementLogo($id);
                $ads['start_date'] = date('Y-m-d H:i:s');
                $ads['end_date'] = date("Y-m-d H:i:s", strtotime('+'.$query->duration." day"));
                $ads['is_active'] = 1;

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 60;
                $log['table_name'] = "tb_advertisement";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
                
                
                if($fID = $this->admin_model->updateAdvertisementLogo($id, $ads))
                {

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Logo has been activated",        
                        "data" => $ads                 
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function advertisement_logo_deactivate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getAdvertisementLogo($id);
                $ads['start_date'] = NULL;
                $ads['end_date'] = NULL;
                $ads['is_active'] = 0;

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 61;
                $log['table_name'] = "tb_advertisement";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
                
                
                if($fID = $this->admin_model->updateAdvertisementLogo($id, $ads))
                {

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Logo has been deactivated",                         
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function advertisement_logo_patch()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $ads_id = $this->my_encrypt->decode($this->patch('ads_id'));
                $ads['title'] = $this->patch('title');
                $ads['ads_url'] = $this->patch('ads_link');
                $ads['duration'] = $this->patch('duration');
        
                if($this->admin_model->updateAdvertisementLogo($ads_id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 58;
                    $log['table_name'] = "tb_advertisement";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(
                        "status"=>TRUE,
                        "message" => "Logo information changes saved",
                        );
                    $this->response($response, REST_Controller::HTTP_CREATED);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }

    }

    public function advertisement_logo_get()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->get('id'));

                if($id == NULL)
                {
                    $sliderImages = array();
                    $query = $this->admin_model->getAdvertisementLogo();

                    if(!empty($query))
                    {
                        foreach($query as $image)
                        {
                            $sliderImages[] = array(
                                "path" => base_url().str_replace("./", "", $image->upload_path)."/".$image->filename,
                                "ads_url" => $image->ads_url,
                                "ads_title" => $image->title,
                                "start_date" => $image->start_date,
                                "end_date" => $image->end_date,
                                "duration" => $query->duration,
                                );
                        }

                        $this->response($sliderImages, REST_Controller::HTTP_OK);
                    }else{
                        $this->response(['status'=>FALSE,'message'=>'Logo not found'], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
                else{
                    $query = $this->admin_model->getAdvertisementLogo($id);
                    
                    if(!empty($query))
                    {
                        $sliderImage = array(
                            "path" => base_url().str_replace("./", "", $query->upload_path)."/".$query->filename,
                            "ads_url" => $query->ads_url,
                            "ads_title" => $query->title,
                            "duration" => $query->duration,
                            );
                        $this->response($sliderImage, REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response(['status'=>FALSE,'message'=>'Logo not found',"data"=> $query], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function advertisement_logo_delete()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $ads_id = $this->my_encrypt->decode($this->delete('id'));

                $query = $this->admin_model->getAdvertisementLogo($ads_id);
            
                unlink($query->upload_path."/".$query->filename);
                rmdir($query->upload_path);
                $this->admin_model->deleteErrorUploadLogo($ads_id);

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 59;
                $log['table_name'] = "tb_advertisement";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);
                
                $response = array(
                    "status"=>TRUE,
                    "message" => "Advertisement deleted",
                    );
                $this->response($response, REST_Controller::HTTP_OK);
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }


    public function featured_jobs_get()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->get('id'));

                if($id == NULL)
                {
                    $jobs = array();
                    $query = $this->admin_model->getFeaturedJobs();

                    if(!empty($query))
                    {
                        foreach($query as $job)
                        {
                            $jobs[] = array(
                                "position" => $this->my_encrypt->encode($job->job_position),
                             "company" => $job->company_name,
                             "company_id" => $job->company_id,
                             "duration" => $job->duration,
                             "start_date" =>  date('Y-m-d', strtotime($job->start_date)),
                             "end_date" =>  date('Y-m-d', strtotime($job->end_date)),
                             "job_description" => $job->job_description,
                             "use_alternative" => $job->use_alternative,
                             "alternative_title" => $job->alternative_title
                                );
                        }

                        $this->response($jobs, REST_Controller::HTTP_OK);
                    }else{
                        $this->response(['status'=>FALSE,'message'=>'Jobs not found'], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
                else{
                    $query = $this->admin_model->getFeaturedJobs($id);
                    
                    if(!empty($query))
                    {
                        $job = array(
                        
                            "position" => $this->my_encrypt->encode($query->job_position),
                            "company" => $query->company_name,
                            "company_id" => $query->company_id,
                            "duration" => $query->duration,
                            "start_date" =>  date('Y-m-d', strtotime($query->start_date)),
                            "end_date" =>  date('Y-m-d', strtotime($query->end_date)),
                            "job_description" => $query->job_description,
                            "use_alternative" => $query->use_alternative,
                            "alternative_title" => $query->alternative_title
                            );
                        $this->response($job, REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response(['status'=>FALSE,'message'=>"Job not found"], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $ads['company_id'] = $this->post('company');
                $ads['job_position'] = $this->my_encrypt->decode($this->post('job_position'));
                $ads['duration'] = $this->post('duration');
                $ads['job_description'] = $this->post('job_content');
                $ads['date_created'] = date('Y-m-d h:i:s');
                $ads['is_active'] = 0;
                $ads['use_alternative']  = $this->post('alt_status');
                $ads['alternative_title'] = $this->post('alt_position');
                
                
                if($fID = $this->admin_model->saveFeaturedJob($ads))
                {

                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 57;
                    $log['table_name'] = "tb_featured_post";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Featured job has been saved",     
                        "data" => $ads                    
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_patch()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $fid = $this->my_encrypt->decode($this->patch('id'));
                $ads['company_id'] = $this->patch('company');
                $ads['job_position'] = $this->my_encrypt->decode($this->patch('job_position'));
                $ads['duration'] = $this->patch('duration');
                $ads['job_description'] = $this->patch('job_content');
                $ads['date_modified'] = date('Y-m-d H:i:s');
                $ads['use_alternative']  = $this->patch('alt_status');
                $ads['alternative_title'] = ($this->patch('alt_status') == 1)? $this->patch('alt_position') :"";

                if($this->admin_model->updateFeaturedJob($fid, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 58;
                    $log['table_name'] = "tb_featured_post";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(
                        "status"=>TRUE,
                        "message" => "Featured job changes saved",
                        );
                    $this->response($response, REST_Controller::HTTP_CREATED);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_activate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getFeaturedJobs($id);
                $ads['start_date'] = date('Y-m-d H:i:s');
                $ads['end_date'] = date("Y-m-d H:i:s", strtotime('+'.$query->duration." day"));
                $ads['is_active'] = 1;
                
                
                if($fID = $this->admin_model->updateFeaturedJob($id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 60;
                    $log['table_name'] = "tb_featured_post";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Featured job has been activated", 
                        "data" => $ads,
                        "duration" => $query->duration                        
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_deactivate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getFeaturedJobs($id);
                $ads['start_date'] = NULL;
                $ads['end_date'] = NULL;
                $ads['is_active'] = 0;
                
                
                if($fID = $this->admin_model->updateFeaturedJob($id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 61;
                    $log['table_name'] = "tb_featured_post";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Featured job has been deactivated", 
                        "data" => $ads,
                        "duration" => $query->duration                        
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_delete()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->delete('fid'));

                $this->admin_model->deleteFeaturedJob($id);

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 59;
                $log['table_name'] = "tb_featured_post";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);

                $response = array(
                    "status"=>TRUE,
                    "message" => "Featured job deleted",
                    );
                $this->response($response, REST_Controller::HTTP_NO_CONTENT);
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_by_location_get()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->get('id'));

                if($id == NULL)
                {
                    $jobs = array();
                    $query = $this->admin_model->getFeaturedJobsByLocation();

                    if(!empty($query))
                    {
                        foreach($query as $job)
                        {
                            $jobs[] = array(
                               
                                "position" => $this->my_encrypt->encode($job->job_position),
                                "company" => $job->company_name,
                                "company_id" => $job->company_id,
                                "duration" => $job->duration,
                                "start_date" => $job->start_date,
                                "end_date" => $job->end_date,
                                "job_description" => $job->job_description,
                                "use_alternative" => $job->use_alternative,
                                "alternative_title" =>  $job->alternative_title
                                );
                        }

                        $this->response($jobs, REST_Controller::HTTP_OK);
                    }else{
                        $this->response(['status'=>FALSE,'message'=>'Jobs not found'], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
                else{
                    $query = $this->admin_model->getFeaturedJobsByLocation($id);
                    
                    if(!empty($query))
                    {
                        $job = array(
                            "position" => $this->my_encrypt->encode($query->job_position),
                            "company" => $query->company_name,
                            "company_id" => $query->company_id,
                            "duration" => $query->duration,
                            "start_date" =>  date('Y-m-d', strtotime($query->start_date)),
                            "end_date" =>  date('Y-m-d', strtotime($query->end_date)),
                            "job_description" => $query->job_description,
                            "use_alternative" => $query->use_alternative,
                            "alternative_title" => $query->alternative_title
                            );
                        $this->response($job, REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response(['status'=>FALSE,'message'=>"Job not found"], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_by_location_patch()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $fid = $this->my_encrypt->decode($this->patch('id'));
            
                $ads['company_id'] = $this->patch('company');
                $ads['job_position'] = $this->my_encrypt->decode($this->patch('job_position'));
                $ads['duration'] = $this->patch('duration');
                $ads['job_description'] = $this->patch('job_content');
                $ads['date_modified'] = date('Y-m-d h:i:s');
                $ads['use_alternative']  = $this->patch('alt_status');
                $ads['alternative_title'] = ($this->patch('alt_status') == 1)? $this->patch('alt_position') :"";

                if($this->admin_model->updateFeaturedJobByLocation($fid, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 58;
                    $log['table_name'] = "tb_featured_jobpost_location";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(
                        "status"=>TRUE,
                        "message" => "Featured job changes saved",
                        );
                    $this->response($response, REST_Controller::HTTP_CREATED);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_by_location_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                
                $ads['company_id'] = $this->post('company');
                $ads['job_position'] = $this->my_encrypt->decode($this->post('job_position'));
                $ads['duration'] = $this->post('duration');
                $ads['job_description'] = $this->post('job_content');
                $ads['date_created'] = date('Y-m-d h:i:s');
                $ads['is_active'] = 0;
                $ads['use_alternative']  = $this->post('alt_status');
                $ads['alternative_title'] = $this->post('alt_position');
                
                
                if($fID = $this->admin_model->saveFeaturedJobByLocation($ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 57;
                    $log['table_name'] = "tb_featured_jobpost_location";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Job has been saved",                       
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }


    public function featured_jobs_by_location_activate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getFeaturedJobsByLocation($id);
                $ads['start_date'] = date('Y-m-d H:i:s');
                $ads['end_date'] = date("Y-m-d H:i:s", strtotime('+'.$query->duration." day"));
                $ads['is_active'] = 1;
                
                
                if($fID = $this->admin_model->updateFeaturedJobByLocation($id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 60;
                    $log['table_name'] = "tb_featured_jobpost_location";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Featured job has been activated",                       
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_by_location_deactivate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getFeaturedJobsByLocation($id);
                $ads['start_date'] = NULL;
                $ads['end_date'] = NULL;
                $ads['is_active'] = 0;
                
                
                if($fID = $this->admin_model->updateFeaturedJobByLocation($id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 61;
                    $log['table_name'] = "tb_featured_jobpost_location";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Featured job has been deactivated", 
                                               
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_jobs_by_location_delete()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->delete('fid'));

                $this->admin_model->deleteFeaturedJobByLocation($id);

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 59;
                $log['table_name'] = "tb_featured_jobpost_location";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);

                $response = array(
                    "status"=>TRUE,
                    "message" => "Featured job deleted",
                    );
                $this->response($response, REST_Controller::HTTP_NO_CONTENT);
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }


    public function featured_companies_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $ids = $this->post('id');
    
                foreach($ids AS $id)
                {
                    $temp = $this->admin_model->isCompanyExists($id);
                    if(count($temp) != 1)
                    {
                        $ads['company_id'] = $id;
                        $ads['duration'] = $this->post('duration');
                        $ads['date_created'] = date('Y-m-d h:i:s');
                        $ads['is_active'] = 0;

                        $this->admin_model->saveFeaturedCompany($ads);

                        $log['user_id'] = $user->user_id;
                        $log['audit_action'] = 57;
                        $log['table_name'] = "tb_featured_companies";
                        $log['record_id'] = $user->user_id;
                        $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                        $log['date'] = date('Y-m-d H:i:s');
                        $log['is_active'] = 1;
                        $this->log_model->save($log);

                        $response = array(    
                            "status"=>TRUE,
                            "message" => "Company has been saved to Featured Companies",                       
                            );
                        $this->response($response, REST_Controller::HTTP_CREATED);
                    }
                    else{
                        $response = array(    
                            "status"=>FALSE,
                            "message" => "Company is already been saved to featured companies",                       
                            );
                        $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
                    
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_companies_get()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->get('id'));

                if($id == NULL)
                {
                    $companies = array();
                    $query = $this->admin_model->getFeaturedCompanies();

                    if(!empty($query))
                    {
                        foreach($query as $comp)
                        {
                            $companies[] = array(
                                "id" => $comp->id,
                                "company" => $comp->company_id,
                                "duration" => $comp->duration,
                                "start_date" => $comp->start_date,
                                "end_date" => $comp->end_date,
                                "is_active" => $comp->is_active
                                );
                        }

                        $this->response($companies, REST_Controller::HTTP_OK);
                    }else{
                        $this->response(['status'=>FALSE,'message'=>'Jobs not found'], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
                else{
                    $query = $this->admin_model->getFeaturedCompanies($id);
                    
                    if(!empty($query))
                    {
                        $company = array(
                            "id" => $query->id,
                                "company" => $query->company_id,
                                "duration" => $query->duration,
                                "start_date" => $query->start_date,
                                "end_date" => $query->end_date,
                                "is_active" => $query->is_active
                            );
                        $this->response($company, REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->response(['status'=>FALSE,'message'=>"Job not found"], REST_Controller::HTTP_NOT_FOUND);
                    }
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_companies_patch()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->patch('id'));
                
                $ads['duration'] = $this->patch('duration');

                if($this->admin_model->updateFeaturedCompany($id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 58;
                    $log['table_name'] = "tb_featured_companies";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(
                        "status"=>TRUE,
                        "message" => "Changes saved",
                        );
                    $this->response($response, REST_Controller::HTTP_CREATED);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }


    public function featured_companies_delete()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->delete('id'));

                $this->admin_model->deleteFeaturedCompany($id);

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 59;
                $log['table_name'] = "tb_featured_companies";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);

                $response = array(
                    "status"=>TRUE,
                    "message" => "Featured company deleted",
                    );
                $this->response($response, REST_Controller::HTTP_NO_CONTENT);
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_companies_activate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getFeaturedCompanies($id);
                $ads['start_date'] = date('Y-m-d H:i:s');
                $ads['end_date'] = date("Y-m-d H:i:s", strtotime('+'.$query->duration." day"));
                $ads['is_active'] = 1;
                
                
                if($fID = $this->admin_model->updateFeaturedCompany($id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 60;
                    $log['table_name'] = "tb_featured_companies";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Featured company has been activated",                        
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function featured_companies_deactivate_post()
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

            if(!empty($user) && $user->account_type == 1)
            {
                $id = $this->my_encrypt->decode($this->post('id'));
                $query = $this->admin_model->getFeaturedCompanies($id);
                $ads['start_date'] = NULL;
                $ads['end_date'] = NULL;
                $ads['is_active'] = 0;
                
                
                if($fID = $this->admin_model->updateFeaturedCompany($id, $ads))
                {
                    $log['user_id'] = $user->user_id;
                    $log['audit_action'] = 61;
                    $log['table_name'] = "tb_featured_companies";
                    $log['record_id'] = $user->user_id;
                    $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $log['date'] = date('Y-m-d H:i:s');
                    $log['is_active'] = 1;
                    $this->log_model->save($log);

                    $response = array(    
                        "status"=>TRUE,
                        "message" => "Featured company has been deactivated",                        
                    );
                    $this->response($response, REST_Controller::HTTP_CREATED);

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

            if(!empty($user) && $user->account_type == 1)
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

                        $log['user_id'] = $user->user_id;
                        $log['audit_action'] = 56;
                        $log['table_name'] = "tb_sri_account";
                        $log['record_id'] = $user->user_id;
                        $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                        $log['date'] = date('Y-m-d H:i:s');
                        $log['is_active'] = 1;
                        $this->log_model->save($log);

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


    public function smtp_acct_post()
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

            if(!empty($user) && $user->account_type == 1)
            {   
                if($this->post('email') != NULL){
                    $smtp_acct['smtp_user'] = $this->post('email');
                }
                if($this->post('password') != NULL){
                    $smtp_acct['smtp_password'] = $this->my_encrypt->encode($this->post('password'));
                }

                if( $this->admin_model->set_smtp_acct($smtp_acct))
                {
                    $this->response(["status"=>TRUE,"message"=>"Account changes been saved"]);
                }
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }

    }
}
