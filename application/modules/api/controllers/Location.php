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
class Location extends REST_Controller {

    function __construct()
    {
        
        parent::__construct();
       
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        // $this->load->model('employer/employer_model','emp_model');
        $this->load->model('location_model');
        $this->load->library('my_encrypt');
        // $this->load->module('api/key');
    }
    public function index_get()
    {
        redirect('api/location/regions');
    }

    public function regions_get()
    {
        $id = $this->get('id');

         if ($id === NULL)
         {
            $regions = $this->location_model->get();

            if (!empty($regions))
            {

                $this->response($regions, REST_Controller::HTTP_OK); 
            }
            else
            {

                $this->response([
                    'status' => FALSE,
                    'message' => 'No regions were found'
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        else
        {
            $region = $this->location_model->get($id);

            if(!empty($region))
            {
               
                $this->response($region, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response([
                    "status" => FALSE,
                    "message" => "Region doesn't exits"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function cities_get()
    {
        $id = $this->get('id');
        $region_id = $this->get('rid');

         if ($id === NULL && $region_id === NULL) 
         {
            $cities = $this->location_model->getCity();

            if (!empty($cities))
            {

                $this->response($cities, REST_Controller::HTTP_OK); 
            }
            else
            {

                $this->response([
                    'status' => FALSE,
                    'message' => 'No cities were found'
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
        else
        {

            $city = $this->location_model->getCity($id, $region_id);

            if(!empty($city))
            {
               
                $this->response($city, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response([
                    "status" => FALSE,
                    "message" => "City doesn't exits"
                    ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}
    