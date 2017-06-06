<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller
{
	function __construct()
    {
      
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->module('functions/functions');
        $this->load->model('notification/notification_model');
        $this->load->model('api/auth_model');
        $this->load->model('api/company_model');
        $this->load->model('applicant/applicant_model_rest', 'applicant_model');
        $this->load->library('ci_pusher');
    }

	public function index()
	{
		$this->load->view('errors/html/error_404');
	}

	public function trigger_event()
	{
		// Load the library.
		// You can also autoload the library by adding it to config/autoload.php
		
		$pusher = $this->ci_pusher->get_pusher();

		
		$data['name'] = "JobFair-Online.net";
		$data['message'] = 'Hello Jeck! This message was sent at ' . date('Y-m-d H:i:s');

		// Send message
		$event = $pusher->trigger('private-jfo-channel', 'private-jfo-notification', $data);

		if ($event === TRUE)
		{
			$response = array(
				"status" => TRUE,
				"New notification has been sent",
				"response" => $event
				);	

			echo json_encode($response); 
		}
		else
		{
			$response = array(
				"status" => FALSE,
				"message" => "Ouch, something happend. Could not trigger event.",
				"response" => $event
				);

			echo json_encode($response);
		}
	}

	public function new_notification()
	{
		$pusher = $this->ci_pusher->get_pusher();	

		if(!isset($_COOKIE['_ut'])){
            header('HTTP/1.0 403 Forbidden');

            $response = array(
            		"status" => FALSE,
            		"message" => "REQUEST FORBIDDEN"
            		);

            echo json_encode($response);
        }
        else
        {
            $token = $_COOKIE['_ut'];
            $user = $this->auth_model->getUserByToken($token);

            if(!empty($user) && $user->account_type == 3)
            {
         
                $ids = $this->input->post('vid');
                foreach($ids as $id)
                {
                	$id = $this->my_encrypt->decode($id);
                
                	$query = $this->company_model->getVerification($id);

                	$message = "";
                    $action = $this->input->post('method');
                    $temp = str_replace(array('\\', '/'), '', $query->job_position);
                    $position_uri =  str_replace(' ', '-', $temp);
                    $job_id = $this->my_encrypt->encode($query->job_id);


                    
                    if($action == "tag_as_reviewed"){
                    	$message = '<a href="'.base_url().'jobs/details/'.$position_uri.'/'.$job_id.'" target="'.$job_id.'"><strong>'.$query->recruiter.'</strong> has viewed and is reviewing your application for the position <strong>'.$query->job_position.'</strong></a>';
                    }
                    elseif($action == "tag_for_interview"){
                    	$message = '<a href="'.base_url().'jobs/details/'.$position_uri.'/'.$job_id.'" target="'.$job_id.'"><strong>'.$query->recruiter.'</strong> has been tag you as FOR INTERVIEW.</a>';
                    }
                    else{

                    }

                    $data['sender_id'] = $user->user_id;
                    $data['receiver_id'] = $query->applicant_id;
                    $data['notification'] = $message;
                    $data['channel_name'] = "private-".$query->applicant_id;
                    $data['notif_event'] = "private-".$query->applicant_id."-notification";
                    $data['date_created'] = date("Y-m-d H:i:s");
                    $data['status'] = 1;

                    if($this->notification_model->create($data))
                    {
                    	$notif['name'] = 'Hello '.$query->apl_fname."!<br> ";
						$notif['message'] = $data['notification'];

						$event = $pusher->trigger($data['channel_name'], $data['notif_event'], $notif);

						if ($event === TRUE)
						{
							$response = array("status"=>TRUE, "data"=>$query, "ids" => $ids);
	                        
	                        echo json_encode($response);
						}
						else
						{
							$response = array("status"=>TRUE);
	                        
	                        echo json_encode($response);
						}	
                    }
                }  
            }
            else
            {
            	header('HTTP/1.0 403 Forbidden');

            	$response = array(
            		"status" => FALSE,
            		"message" => "REQUEST FORBIDDEN"
            		);

            	echo json_encode($response);
            }
        }
	}
}
