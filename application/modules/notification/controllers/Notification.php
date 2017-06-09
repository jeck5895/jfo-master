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
                    $html_message = "";
                    $action = $this->input->post('method');
                    $temp = str_replace(array('\\', '/'), '', $query->job_position);
                    $position_uri =  str_replace(' ', '-', $temp);
                    $job_id = $this->my_encrypt->encode($query->job_id);


                    
                    if($action == "tag_as_reviewed"){
                    	
                        $message = $query->recruiter.' is currently reviewing your applicantion for '.$query->job_position;
                        $html_message = '<strong>'.$query->recruiter.'</strong> is currently reviewing your applicantion for <strong>'.$query->job_position.'</strong>';
                    }
                    elseif($action == "tag_for_interview"){
                    	$message = 'Your application for '.$query->recruiter.' for the position of '.$query->job_position.' has been tag as Qualified. Please wait for the employer to contact you for further processing of your application';

                        $html_message = 'Your application for <strong>'.$query->recruiter.'</strong> for the position of <strong>'.$query->job_position.'</strong> has been tag as Qualified. Please wait for the employer to contact you for further processing of your application';
                    }
                    elseif($action == "tag_as_reject"){
                        $message = $query->recruiter.' has dismissed application for '.$query->job_position;
                        $html_message = '<strong>'.$query->recruiter.'</strong> has dismissed application for <strong>'.$query->job_position.'</strong>';   
                    }
                    else{

                    }

                    $data['sender_id'] = $user->user_id;
                    $data['receiver_id'] = $query->applicant_id;
                    $data['notification'] = $message;
                    $data['notification_html'] = $html_message;
                    $data['channel_name'] = "private-".$query->applicant_id;
                    $data['notif_event'] = "private-".$query->applicant_id."-notification";
                    $data['date_created'] = date("Y-m-d H:i:s");
                    $data['status'] = 1;

                    if($notif_id = $this->notification_model->create($data))
                    {
                        $updateData['notif_url'] = site_url('jobs/details/'.$position_uri.'/'.$job_id.'/?notif_id='.$notif_id);

                        if($this->notification_model->update($notif_id, $updateData) == TRUE)
                        {
                        	$notif['name'] = 'Hello '.$query->apl_fname."!<br> ";
    						$notif['message'] = $data['notification'];
                            $notif['link'] = site_url('jobs/details/'.$position_uri.'/'.$job_id.'/?notif_id='.$notif_id);

    						$event = $pusher->trigger($data['channel_name'], $data['notif_event'], $notif);	
                        }
                    }
                }

                if ($event === TRUE)
                {
                    $response = array("status"=>TRUE);

                    echo json_encode($response);
                }
                else
                {
                    $response = array("status"=>FALSE);

                    echo json_encode($response);
                }  
            }
            if(!empty($user) && $user->account_type == 1)
            {
                $this->load->model('api/job_post_model');
                
                $ids = $this->input->post('id',true);
                $action = $this->input->post('method');
                
                foreach($ids AS $id )
                {
                    $id = $this->my_encrypt->decode($id);
                    
                    $query = $this->job_post_model->get($id);
     
                    $message = "";
                    $html_message = "";
    
                    if($action == "approve"){
                        
                        $temp = str_replace(array('\\', '/'), '', $query['job_position']);
                        $position_uri =  str_replace(' ', '-', $temp);
                        $job_id = $this->my_encrypt->encode($query['job_id']);

                        $message = 'Greetings! '.$query['first_name'].' your job post '.$query['job_position'].' has been approved';
                        $html_message = 'Greetings! '.$query['first_name'].' your job post <strong>'.$query['job_position'].'</strong> has been Approved';
                        
                    }
                    if($action == "decline"){
                        $message = 'Greetings! '.$query['first_name'].' your job post '.$query['job_position'].' has been declined.';
                        $html_message = 'Greetings! '.$query['first_name'].' your job post <strong>'.$query['job_position'].'</strong> has been Declined';
                        
                    }

                    $data['sender_id'] = $user->user_id;
                    $data['receiver_id'] = $query['user_id'];
                    $data['notification'] = $message;
                    $data['notification_html'] = $html_message;
                    $data['channel_name'] = "private-".$query['user_id'];
                    $data['notif_event'] = "private-".$query['user_id']."-notification";
                    $data['date_created'] = date("Y-m-d H:i:s");
                    $data['status'] = 1;

                    if($notif_id = $this->notification_model->create($data))
                    {

                        $updateData['notif_url'] = ($action == "approve")? $link =  site_url('jobs/details/'.$position_uri.'/'.$job_id.'/?notif_id='.$notif_id): site_url('co/jobs');



                        if($this->notification_model->update($notif_id, $updateData) == TRUE)
                        {
                            
                            $notif['message'] = $data['notification'];
                            $notif['link'] = $updateData['notif_url'];

                            $event = $pusher->trigger($data['channel_name'], $data['notif_event'], $notif); 
                        }
                    }
                }


                if ($event === TRUE)
                {
                    $response = array("status"=>TRUE);
                    
                    echo json_encode($response);
                }
                else
                {
                    $response = array("status"=>FALSE);
                    
                    echo json_encode($response);
                }
              
            }
        }
	}
}
