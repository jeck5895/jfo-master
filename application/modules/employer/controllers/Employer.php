<?php
class Employer extends MY_Controller{

	public function __construct()
	{
        date_default_timezone_set('Asia/Manila');
		parent::__construct();
		

        $this->load->model('api/company_model');
        $this->load->model('Jobs_review_model','jobs_review_model');
        $this->load->model('api/auth_model','auth_model');
        $this->load->library('my_encrypt');
	}

	public function view_applicants()
	{
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user)){
                redirect('login');
            }
            elseif($user->account_type != 3){
                redirect('login');
            }
            else{
                
                $page = 'v_employer_applicants';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['employer'] = $employerdata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $page_title['title'] =  $data['employer']->company_name.' | Applicants';
                $data['company_logo'] = ($data['employer']->profile_pic != "")? base_url().str_replace("./", "", $data['employer']->profile_pic) : base_url('assets/images/Default_Company_Logo1.png');
                
                $this->loadMainPage($page_title, $employerdata, $page ,$data);   
            }
        }
        else{
            redirect('');
        }    
        
	}

    public function view_all_applicants()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user)){
                redirect('login');
            }
            elseif($user->account_type != 3){
                redirect('login');
            }
            else{
                $page_title['title'] = 'Jobfair-Online | All Applicants';
                $page = 'v_employer_all_applicants';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['employer'] = $employerdata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);

                $data['company_logo'] = ($data['employer']->profile_pic != "")? base_url().str_replace("./", "", $data['employer']->profile_pic) : base_url('assets/images/Default_Company_Logo1.png');

                $this->loadMainPage($page_title, $employerdata, $page ,$data);
            }
        }
        else{
            redirect('');
        }

    }

    public function review_posted_jobs()
    {

        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user)){
                redirect('login');
            }
            elseif($user->account_type != 3){
                redirect('login');
            }
            else
            {
                $page_title['title'] = 'Review Posted Jobs';
                $page = 'v_review_posted_jobs';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['employer'] = $employerdata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['company_logo'] = ($data['employer']->profile_pic != "")? base_url().str_replace("./", "", $data['employer']->profile_pic) : base_url('assets/images/Default_Company_Logo1.png');        
               $this->loadMainPage($page_title, $employerdata, $page ,$data);
               
            }
        }
        else{
            redirect('');
        }
        
    }

    public function account_company_settings()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user)){
                redirect('login');
            }
            elseif($user->account_type != 3){
                redirect('login');
            }
            else
            {
                $page_title['title'] = 'Account & Company Settings';
                $page = 'v_comp_acct_settings';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['employer'] = $employerdata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['company_logo'] = ($data['employer']->profile_pic != "")? base_url().str_replace("./", "", $data['employer']->profile_pic) : base_url('assets/images/Default_Company_Logo1.png');

                $data['company_banner'] =($data['employer']->company_banner != "")? base_url().str_replace("./", "", $data['employer']->company_banner) : base_url('assets/images/Default_Company_Banner.png') ;
                $data['industries'] = $this->company_model->get_industries();
    
                $this->loadMainPage($page_title, $employerdata, $page ,$data);
               
            }
        }
        else{
            redirect('');
        }
    }

    public function profile_edit()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user)){
                redirect('login');
            }
            elseif($user->account_type != 3){
                redirect('login');
            }
            else
            {
                $page_title['title'] = 'Account & Company Settings';
                $page = 'v_comp_profile_edit';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['employer'] = $employerdata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['company_logo'] = ($data['employer']->profile_pic != "")? base_url().str_replace("./", "", $data['employer']->profile_pic) : base_url('assets/images/Default_Company_Logo1.png');
                $data['company_banner'] =($data['employer']->company_banner != "")? base_url().str_replace("./", "", $data['employer']->company_banner) : base_url('assets/images/Default_Company_Banner.png') ;
                $data['industries'] = $this->company_model->get_industries();
                //var_dump($data['industries']);
                $this->loadMainPage($page_title, $employerdata, $page ,$data);
               
            }
        }
        else{
            redirect('');
        }
    }

    public function create_job_post()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user)){
                redirect('login');
            }
            elseif($user->account_type != 3){
                redirect('login');
            }
            else
            {
                $page_title['title'] = 'Jobfair-Online | Create Job';
                $page = 'v_create_job_post';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['employer'] = $employerdata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['company_logo'] = ($data['employer']->profile_pic != "")? base_url().str_replace("./", "", $data['employer']->profile_pic) : base_url('assets/images/Default_Company_Logo1.png');

                $this->loadMainPage($page_title, $employerdata, $page ,$data);
               
            }
        }
        else{
            redirect('');
        }
    }

    public function edit_job_post($id)
    {
         if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(empty($user)){
                redirect('login');
            }
            elseif($user->account_type != 3){
                redirect('login');
            }
            else
            {
                $page_title['title'] = 'Jobfair-Online | Edit Job Post';
                $page = 'v_create_job_post';
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
                $data['employer'] = $employerdata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['company_logo'] = ($data['employer']->profile_pic != "")? base_url().str_replace("./", "", $data['employer']->profile_pic) : base_url('assets/images/Default_Company_Logo1.png');
                $this->loadMainPage($page_title, $employerdata, $page ,$data);
               
            }
        }
        else{
            redirect('');
        }
    }  

    /**--- Functions --*/


    public function display_date()
    {
        $job_exiration = 3;
        $date = strtotime(date('Y-m-d h:i:s'));
        // $date = strtotime("+". $job_exiration ."day", $date); //add days on current date
        $date = strtotime("+".$job_exiration."months",$date); // add months on current date
        var_dump(date('Y-m-d h:i:s',$date));
    }

	

    public function get_job_post($status)
    {
        $this->load->model('api/auth_model');
        $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
        $list = $this->jobs_review_model->get_datatables($status, $user->user_id);
        $name = "";
        
        switch ($status) {
            case 'pending':
                $name = "select-pending-job";
                break;
            case 'published':
                $name = "select-published-job";
                break;
            case 'declined':
                $name = "select-declined-job";
                break;
            case 'expired':
                $name = "select-expired-job";
                break;    
            default:
                # code...
                break;
        }

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $job) {
            $job_id = $this->my_encrypt->encode($job->job_id);
            
            $no++;
            $row = array();
                $input_html = "<label class='custom-control custom-checkbox'>";
                $input_html .= "<input type='checkbox' class='custom-control-input' name='".$name."' data-id='".$job_id ."'>";
                $input_html .= "<span class='custom-control-indicator'></span>";
                $input_html .= "<span class='custom-control-description'></span>";
                $input_html .= "</label>";
            $row[] = $input_html;
            $row[] = $job->job_position;
            $row[] = $job->num_vacancies;
            $row[] = ($job->job_opendate === '0000-00-00 00:00:00')? 'TBD' :date('F j, Y', strtotime($job->job_opendate));
            $row[] = ($job->job_closedate === '0000-00-00 00:00:00')? 'TBD' :date('F j, Y', strtotime($job->job_closedate));
            $row[] = date('F j, Y', strtotime($job->date_create));
                
            if($status == "pending"){
                $html = '<a title="Edit" href="'.base_url().'employer/job/edit/id/'.$job_id.'" target="'.$job_id.'" class="ml-2"><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';
                $html .= '<a title="Delete" href="" id="delete-job" data-id="'.$job_id.'" onclick="return false;" class="ml-2"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
            }
                
            $temp = str_replace(array('\\', '/'), '', $job->job_position);
            $position_uri =  str_replace(' ', '-', $temp);
            
            if($status == "published"){    
                $html = '<a title="View" href="'.base_url().'jobs/details/'.$position_uri.'/'.$job_id.'"  target="'.$job_id.'" class="ml-2"><img id="view" src="'.base_url('assets/images/app/PreviewDataTableIcon.png').'" ></a> ';
                $html .= '<a title="Delete" href="" id="delete-job" data-id="'.$job_id.'" onclick="return false;" class="ml-2"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
            }    
            
            if($status == "declined" || $status == "expired"){
                
                $html = '<a title="Delete"  href="" id="delete-job" data-id="'.$job_id.'" onclick="return false;" class="ml-2"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
          
            }
                 
            $row[] = $html;

            
            
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->jobs_review_model->count_all(),
                        "recordsFiltered" => $this->jobs_review_model->count_filtered($status,$user->user_id),
                        "data" => $data,
                        "order" => $_POST['order']
                );
        
        echo json_encode($output);
    }

    public function get_employer_applicants()
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
        
                $list = $this->employer_app_model->get_datatables($user);

                $data = array();
                $positions = [];

                $no = $_POST['start'];
                foreach ($list as $job) {
                    $job_id = $this->my_encrypt->encode($job->job_id);
                    $verification_id = $this->my_encrypt->encode($job->verification_id);

                    $app_job_positions = $this->reg_model->get_job_position($job->job_category);
                    $temp = unserialize($job->app_positions);

                    foreach($app_job_positions as $jobposition)
                    {
                        $positions[] = (in_array($jobposition->id, $temp))?$jobposition->name:false;
                    }

                    $user_photo = ($job->profile_pic != "")? str_replace("./", "",$job->profile_pic):'assets/images/avatar.jpg';

                    $no++;
                    $row = array();
                    $row[] = '<input type="checkbox" name="select-emp-applicant" class="selectCheckBox" data-id="'.$verification_id .'" data-app-name="'.strtolower($job->first_name).'">';
                           
                    $row[] = '<a href="#profileModal" id="view_app_profile" data-toggle="modal" data-target="#profileModal" data-aid="'.$job->app_id.'" onlick="return false;">'.$job->first_name ." ".$job->last_name.'</a>';
                    
                    $row[] = '<a href="'.base_url('jobs/details/'.$job_id).'" target="'.$job->job_id.'">'.$job->job_position;
                    $row[] = $job->status;
                    $row[] = $job->company_name;
                    $row[] = date('F j, Y', strtotime($job->date_applied));
                        $html = '<div class="dropdown ">
                                    <button type="button" class="btn btn-secondary" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-gears"></i></button>
                                    <div class="dropdown-menu center-dropdown-menu" id="registration" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="'.base_url().'jobs/details/'.$job_id.'"><i class="fa fa-search"></i> View Job Post</a>
                                        <a class="dropdown-item" href="#profileModal" id="view_app_profile" data-toggle="modal" data-target="#profileModal" data-aid="'.$job->app_id.'" onlick="return false;"><i class="fa fa-user"></i> View applicant profile</a>
                                        <a class="dropdown-item" href="'.base_url().'applicant/resume/'.$job->app_id.'"><i class="fa fa-file-pdf-o"></i> View applicant resume</a>
                                    </div>
                                </div> ';
                    $row[] = $html;
                    $positions = array();// reset

                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => $this->employer_app_model->count_all(),
                                "recordsFiltered" => $this->employer_app_model->count_filtered($user),
                                "data" => $data,
                        );
               
                echo json_encode($output);   
            }
            else{
                $this->response(['status' => FALSE, 'message' => 'REQUEST UNAUTHORIZED' ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function get_public_applicants()
    {

        $list = $this->public_app_model->getPublicApplicants();
        $positions = [];
        $applicants = array();

        foreach ($list as $applicant) 
        {
            $job_positions = $this->reg_model->get_job_position($applicant["job_category"]);
            $temp = unserialize($applicant["job_position"]);

            foreach($job_positions as $job_position)
            {
                $positions[] = (in_array($job_position->id, $temp))?$job_position->name:false;
            }

            $applicants[] = array(
                "id" => $applicant['user_id'],
                "fullname" => $applicant['first_name']." ".$applicant['middle_name']." ".$applicant['last_name'],
                "age" => $applicant['age'],
                "gender" => ucfirst($applicant['sex']),
                "civil_status" => ucfirst($applicant['civil_status']),
                "address" => $applicant['city_1'].", ".$applicant['province_1'],
                "mobile_num" => $applicant['mobile_num'],
                "position" => $positions,
                "user_photo" =>($applicant['profile_pic'] != "")? str_replace("./", "", $applicant['profile_pic']):'assets/images/avatar.jpg',
                "college_degree" => $applicant['college_degree'],
                "email" => $applicant['email'],
                "phone" => $applicant['mobile_num'],
                "college_name" => $applicant['college_name']
                );  
             $positions = array(); // reset the array after looping positions      
        }

        echo json_encode($applicants);
    }

   
}
		