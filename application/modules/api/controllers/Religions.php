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
class Religions extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('religion_model');
        $this->load->model('auth_model');
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

            if(!empty($user) && $user->account_type == 1)
            {
                $religion = $this->post('religion');

                if($religion != NULL)
                {
                    $data['religion_name'] = $religion;
                    $data['is_active'] = 1;
                    if($this->religion_model->create($data) === TRUE)
                    {
                        $response = array(
                            "message" => "New Religion created",
                            "status" => true,
                            );
                    $this->response($response, REST_Controller::HTTP_CREATED);
                    }
                }
                else
                {
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

    public function index_get()
    {
        $id = $this->get('id');

        if($id === NULL)
        {
            $religions = $this->religion_model->get();

            if(!empty($religions))
            {
                $this->response($religions, REST_Controller::HTTP_OK);
            }
            else
            {

                $this->response([
                    'status' => FALSE,
                    'message' => 'No religions were found'
                    ], REST_Controller::HTTP_NOT_FOUND); 
            }
        }
        else
        {
            $religion = $this->religion_model->get($id);

            if(!empty($religion))
            {
                $this->response($religion, REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Religion not found'
                    ], REST_Controller::HTTP_NOT_FOUND); 
            }
        }
    }

    public function index_patch()
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
                $data['religion_name'] = $this->patch('religion');
                $action = $this->patch('action');

                if($action != NULL && $action == "disable")
                {
                    if($id != NULL)
                    {
                        if($this->religion_model->disableReligion($id) === TRUE)
                        {
                            $response = array(
                                "message" => "Religion has been deleted",
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
                    if($data['religion_name'] != NULL && $id != NULL)
                    {
                        if($this->religion_model->update($id, $data) === TRUE)
                        {
                            $response = array(
                                "message" => "Religion updated",
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

}
