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

/**
    NOTE: IF USING REST API ALL REQUEST MUST BE AJAX BECAUSE THE RETURN TYPE IS JSON
    
*/

class Auth extends REST_Controller {

    function __construct()
    {
        
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->library('my_encrypt');
        $this->load->module('Key');
        $this->load->module('functions');
    }

    public function index_post()
    {
        $form_token = $this->post('form_token');
        
        if($form_token == $this->session->userdata('form_token'))
        {
            $username = $this->post('username');
            $password = $this->my_encrypt->encrypt($this->post('password'));
            $redirect = $this->post('redirect');


            if($this->auth_model->validateEmail($username) === TRUE)
            {   
                $user = $this->auth_model->get($username, $password);


                if($user)
                {
                    if($user->account_type == 3){
                        $boolean = $this->auth_model->isEmailActivated($user->user_id);

                        if($boolean === FALSE){
                            $response = array(
                                "status" => FALSE,
                                "message" => "It seems your email is not verified. Please verify your email first."
                                );
                            $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);

                        }
                        else{
                            $userInfo = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                            $expDate = date("Y-m-d H:i:s", strtotime('+1 day'));
                            $data['user_id'] = $user->user_id;
                            $data['token'] = md5($this->functions->guid().$username.$password);
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
                            $this->log_model->save($log);

                            setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
                            setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
                            setcookie("_typ", "ep", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
                            
                            if($this->auth_model->newUserToken($data) === TRUE){
                                $response = array(
                                    "status" => true,
                                    "redirect" => site_url("/company/applicants/dashboard"),
                                    );

                                $this->response($response, REST_Controller::HTTP_OK);
                            }
                        
                        }
                    }
                    else
                    {
                        $userInfo = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                        $expDate = date("Y-m-d H:i:s", strtotime('+1 day'));
                        $data['user_id'] = $user->user_id;
                        $data['token'] = md5($this->functions->guid().$username.$password);
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
                        $this->log_model->save($log);

                        setcookie("_ut", $data['token'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,true);
                        setcookie("_u", $data['user_id'], time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);

                        if($user->account_type == 2){
                            setcookie("_uc", $this->my_encrypt->encode($userInfo->job_category), time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
                            setcookie("_typ", "ap", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
                        }
                        if($user->account_type == 1){
                            setcookie("_typ", "ad", time()+86400,'/',$_SERVER['HTTP_HOST'],false,false);
                        }
                        


                        if($this->auth_model->newUserToken($data) === TRUE){

                            if($user->account_type == 1){
                                $response = array(
                                    "status" => true,
                                    "redirect" => site_url("/admin/review/jobs"),
                                    );

                                $this->response($response, REST_Controller::HTTP_OK);
                            }

                            if($user->account_type == 2){


                                $response = array(
                                    "status" => true,
                                    "redirect" => ($redirect === NULL)? site_url("/applicant/applications/pending") : $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$redirect,
                                    );

                                $this->response($response, REST_Controller::HTTP_OK);   
                            }
                        }
                    }
                }
                else{
                    $response = array(
                        "status" => false,
                        "message" => "Invalid Email or Password"
                        );
                    $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
                }
            }
            else{
                $response = array(
                            "status" => false,
                            "message" => "Invalid Email or Password"
                        );
                $this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
        else{
            $this->response([
                'status' => FALSE, 
                'message' => 'Error: Token mismatch'
                ],REST_Controller::HTTP_BAD_REQUEST);
        }
    }   

    public function logout_post()
    {
        if(isset($_COOKIE['_ut']))
        {

            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);
            $data['status'] = 0;
            $data['date_destroyed'] = date('Y-m-d H:i:s');
            if($this->auth_model->destroyToken($token ,$data) === TRUE)
            {
                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 4;
                $log['table_name'] = "tb_users";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);

                $this->session->sess_destroy();

                $this->response(array("status" => true), REST_Controller::HTTP_OK);
            }
        }

        else{
            $response = array(
                        "status"=>false
                        );
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function destroy_post()
    {
        setcookie("_ut", $_COOKIE['_ut'], time() - 86400,'/',$_SERVER['HTTP_HOST'],false,true);
    
        setcookie("_u", $_COOKIE['_u'], time() - 86400,'/',$_SERVER['HTTP_HOST'],false,false);
        
        if(isset($_COOKIE['_uc'])){
            setcookie("_uc", $_COOKIE['_uc'], time() - 86400,'/',$_SERVER['HTTP_HOST'],false,false);
        }
                       
        setcookie("_typ", $_COOKIE['_typ'], time() - 86400,'/',$_SERVER['HTTP_HOST'],false,false);

        $this->response(array("status" => true), REST_Controller::HTTP_OK);
    }

    public function validate_post()
    {
        $form_token = $this->post('form_token');
        
        if($form_token == $this->session->userdata('form_token'))
        {
            $email = $this->post('email');

            if($email != NULL)
            {
                $bool = $this->auth_model->validateEmail($email);
               

                if($bool === TRUE)
                {
                    $user = $this->auth_model->getUserByEmail($email);
                    $user = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                    $resetPasswordCode = md5($this->functions->guid().$user->user_id);
                    $firstname = strtolower($user->first_name);

                    $subject = "Jobfair-Online Reset Password"; 
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
                    $content .= "<td align='center' style='padding: 30px'><h1>JobFair-Online Reset Password</h1></td>";
                    $content .= "<tr>";
                    $content .= "<tr>";
                    $content .= "<td><hr></td>";
                    $content .= "</tr>";
                    $content .= "</thead>";
                    $content .= "<tbody style='background: #fff;'>";
                    $content .= "<tr>";
                    $content .= "<td style=' font-size: 4.5rem;font-weight: 300;padding: 20px 30px 0;color: #12b5c4; '><h3>Hello ".ucfirst($firstname)."</h3></td>";
                    $content .= "</tr>";
                    $content .= "<tr>";
                    $content .= "<td style='padding: 0 30px 0;'> ";
                    $content .= "<br>"; 
                    $content .= "<p class='lead' style='text-indent: 14px;'>";
                    $content .= "We received request to reset your password. Click the<a href='".base_url()."accounts/resetpassword?ucode=".$resetPasswordCode."'>     here to reset your account password</a>";
                    $content .= "</p>";
                    $content .= "</td>";
                    $content .= "</tr>";
                    $content .= "<tr>";
                    $content .= "<td align='right' style='padding: 50px 30px 50px;'>Thank you! <br/><i><a style='font-style: italic;color: #12b5c4;text-decoration:none;' href='#'>-JobFair-Online.net Team</a></i>";
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
                    
                    $email_response = $this->functions->sendEmail($email, $subject, $content);

                    if($email_response['status'] == TRUE)
                    {
                        $data['code'] = $resetPasswordCode;
                        $data['user_id'] = $user->user_id;
                        $data['date_created'] = date("Y-m-d H:i:s");
                        $data['expiration_date'] = date("Y-m-d H:i:s", strtotime("+1 day"));
                        $data['status'] = 1;

                        if($res = $this->auth_model->newUserResetPasswordCode($data)){
                            $response = array(
                                "status" => TRUE,
                                "message" => "Please check your email for reset password link",
                                );
                            $this->response($response,REST_Controller::HTTP_OK); 
                        }
                        else{
                            $response = array(
                                "status" => FALSE,
                                "message" => $res
                                );
                            $this->response($response,REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                        }
                    }
                    else{
                        $response = array(
                            "status" => FALSE,
                            "message" => $email_response['message']
                            );
                        $this->response($response,REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    }
                          
                }
                else{
                    $response = array(
                        "status" => FALSE,
                        "message" => "Jobfair-Online doesn't recognize this email"
                        );
                    $this->response($response,REST_Controller::HTTP_BAD_REQUEST);
               }
                    
            }
            else{
                 $response = array(
                        "status" => FALSE,
                        "message" => "Email is required"
                        );
                    $this->response($response,REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        else{
            $this->response([
                'status' => FALSE, 
                'message' => 'Error: Token mismatch'
                ],REST_Controller::HTTP_BAD_REQUEST);
        }       
    }

    public function resetpassword_post()
    {
        $form_token = $this->post('form_token');
        
        if($form_token == $this->session->userdata('form_token'))
        {   
            $code = $this->post('code');
            $data['password'] = $this->my_encrypt->encrypt($this->post('password'));

            $user = $this->auth_model->getUserByCode($code);
            
            if(!empty($user))
            {
                $this->auth_model->resetUserPassword($user->user_id, $data);
                $this->auth_model->disableResetCode($code);

                $log['user_id'] = $user->user_id;
                $log['audit_action'] = 4;
                $log['table_name'] = "tb_users";
                $log['record_id'] = $user->user_id;
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $log['date'] = date('Y-m-d H:i:s');
                $log['is_active'] = 1;
                $this->log_model->save($log);

                $response = array(
                    "status" => TRUE,
                    "message" => "Password has been reset",
                    "data" => $data
                    );

                $this->response($response,REST_Controller::HTTP_OK);   
            }
            else{
                $this->response([
                    'status' => FALSE, 
                    'message' => 'Invalid user'
                    ],REST_Controller::HTTP_BAD_REQUEST);   
            }
        }
        else{
            $this->response([
                'status' => FALSE, 
                'message' => 'Error: Token mismatch'
                ],REST_Controller::HTTP_BAD_REQUEST);
        } 
    }
}    
