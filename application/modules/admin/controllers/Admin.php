<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    function __construct()
    {
        date_default_timezone_set('Asia/Manila');
        parent::__construct();

        $this->load->library('my_encrypt');
        $this->load->module('functions/functions');
        $this->load->library('my_encrypt');
        $this->load->model('api/auth_model');
        $this->load->model('api/admin_model');
    }

    public function index()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Admin | Dashboard';
                $page = 'v_admin_dashboard';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }  
    }

    public function review_job_post()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Admin | Dashboard';
                $page = 'v_admin_review_job';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }     
    }

    public function account_settings()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Admin | Account & Profile Settings';
                $page = 'v_admin_account_settings';
                $data['regions'] =  $this->reg_model->getLocation();
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $data['smtp_acct'] = $this->admin_model->get_smtp_acct();
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }
    }

    public function applicants_for_review()
    {
         if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'For Review Applicants';
                $page = 'v_admin_rev_applicants';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }   
    }

    public function applicants_public()
    {
         if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Public Applicants';
                $page = 'v_admin_pub_applicants';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }   
    }

    public function applicants_private()
    {
         if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Private Applicants';
                $page = 'v_admin_pri_applicants';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }   
    }

    public function applicants_inactive()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Inactive Applicants';
                $page = 'v_admin_inc_applicants';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }   
    }

    public function companies()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Admin | Review Employers';
                $page = 'v_admin_emp_dashboard';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }     
    }

    public function logs()
    {

        $page_title['title'] = 'Admin | Audit Logs';
        $page = 'v_admin_log';
        $data['admin'] = $admindata['user'] = $this->admin_model->getActiveAdmin($this->session->userdata('active_admin')->user_id);
        $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);
        
        $this->loadMainPage($page_title, $admindata, $page ,$data);   
    }

    public function reports()
    {

        $page_title['title'] = 'Admin | Audit Logs';
        $page = 'v_admin_reports';
        $data['admin'] = $admindata['user'] = $this->admin_model->getActiveAdmin($this->session->userdata('active_admin')->user_id);
        $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);
        
        $this->loadMainPage($page_title, $admindata, $page ,$data);
    }

    public function create_user()
    {
        $page_title['title'] = 'Admin | Create User';
        $page = 'v_admin_create_user';
        $data['regions'] =  $this->reg_model->getLocation();
        $data['admin'] = $admindata['user'] = $this->admin_model->getActiveAdmin($this->session->userdata('active_admin')->user_id);
        $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);
        
        $this->loadMainPage($page_title, $admindata, $page ,$data);
    }

    public function keywords()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Admin | Maintenance';
                $page = 'v_admin_configuration';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }     
    }

    public function maintenance_advertisements_sliders()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Advertisements | Sliders';
                $page = 'v_admin_ads_slider';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }     
    }

    public function maintenance_featured_jobs()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Advertisements | Featured Jobs';
                $page = 'v_admin_featured_post';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }
    }

    public function maintenance_featured_jobs_by_location()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Advertisements | Featured Jobs';
                $page = 'v_admin_featured_post_by_location';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }
    }

    public function maintenance_featured_companies()
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1){
                
                $page_title['title'] = 'Advertisements | Featured Companies';
                $page = 'v_admin_featured_company';
                $data['admin'] = $admindata['user'] = $this->auth_model->getUserDetails($user->user_id, $user->account_type);
                $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);

                $this->loadMainPage($page_title, $admindata, $page ,$data);
            }
            else{
                redirect('');    
            }
        }
        else{
            redirect('');
        }
    }

    //not used. Alternative is maintenance() with dynamic contents using templating(mustache)
    public function job_fair()
    {

        $page_title['title'] = 'Admin | Job Fair';
        $page = 'v_admin_job_fair';
        $data['regions'] =  $this->reg_model->getLocation();
        $data['admin'] = $admindata['user'] = $this->admin_model->getActiveAdmin($this->session->userdata('active_admin')->user_id);
        $admindata['admin_logo'] = base_url().str_replace("./", "", $data['admin']->profile_pic);
        
        $this->loadMainPage($page_title, $admindata, $page ,$data);   
    }
   


    public function get_job_post($status)
    {
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1)
            {    
                $this->load->model('jobs_model');

                $list = $this->jobs_model->get_datatables($status);
                $name = "";
                
                switch ($status) {
                    case 'pending':
                        $name = "select-admin-pending-job";
                        break;
                    case 'published':
                        $name = "select-admin-published-job";
                        break;
                    case 'declined':
                        $name = "select-admin-declined-job";
                        break;
                    case 'trash':
                        $name = "select-admin-trash-job";
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
                    $row[] = '<a href="#jobModal" data-toggle="modal" data-target="#jobModal" data-id="'.$job_id.'" onlick="return false;">'.$job->job_position.'</a>';
                    $row[] = $job->num_vacancies;
                    $row[] = $job->company_name;
                    $row[] = $job->employer_name;
                    $row[] = ($job->job_opendate === '0000-00-00 00:00:00')? 'TBD' :date('F j, Y', strtotime($job->job_opendate));
                    $row[] = ($job->job_closedate === '0000-00-00 00:00:00')? 'TBD' :date('F j, Y', strtotime($job->job_closedate));
                    $row[] = date('F j, Y', strtotime($job->date_create));
                        $html = '<div class="dropdown">';
                            $html .= '<button type="button" class="btn btn-secondary btn-sm form-control" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></button>';
                                $html .= '<div class="dropdown-menu center-dropdown-menu" id="registration" aria-labelledby="dropdownMenuButton">';
                                    $html .= '<a  class="dropdown-item" data-toggle="modal" data-target="#jobModal" data-id="'.$job_id.'" onlick="return false;" style="cursor: pointer;"><i class="fa fa-search"></i> View Job Post</a>';
                                    if($status == "pending")
                                    {
                                        $html .= '<a class="dropdown-item" data-title="Approve" data-action="approve" id="btn-admin-approve-job" style="cursor: pointer;"><i class="fa fa-thumbs-o-up"></i> Approve Request</a>';

                                        $html .= '<a class="dropdown-item" data-title="Decline" data-action="decline" id="btn-admin-decline-job" style="cursor: pointer;"><i class="fa fa-thumbs-o-down"></i> Decline Request</a>';
                                    }
                                    if($status == "published")
                                    {
                                        $html .= '<a class="dropdown-item" data-title="Tag for Review" data-action="review" id="btn-admin-review-job" style="cursor: pointer;"><i class="fa fa-eye"></i> Tag for Review</a>';

                                        $html .= '<a class="dropdown-item" data-title="Decline" data-action="decline" id="btn-admin-decline-job" style="cursor: pointer;"><i class="fa fa-thumbs-o-down"></i> Decline Request</a>';
                                    }
                                    if($status == "declined")
                                    {
                                        $html .= '<a class="dropdown-item" data-title="Approve" data-action="approve" id="btn-admin-approve-job" style="cursor: pointer;"><i class="fa fa-thumbs-o-up"></i> Approve Request</a>';

                                        $html .= '<a class="dropdown-item" data-title="Tag for Review" data-action="review" id="btn-admin-review-job" style="cursor: pointer;"><i class="fa fa-eye"></i> Tag for Review</a>';

                                        $html .= '<a class="dropdown-item" data-title="Move to Trash" data-action="trash" id="btn-admin-trash-job" style="cursor: pointer;"><i class="fa fa-trash"></i> Move to Trash</a>';
                                    }
                                    if($status == "trash")
                                    {
                                        $html .= '<a class="dropdown-item" data-title="Delete" data-action="delete" id="btn-admin-delete-job" style="cursor: pointer;"><i class="fa fa-times-circle"></i> Delete Permanently</a>';
                                    }

                                    $html .= '</div>';
                                $html .= '</div> ';
                         
                    $row[] = $html;

                    
                    
                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => $this->jobs_model->count_all(),
                                "recordsFiltered" => $this->jobs_model->count_filtered($status),
                                "data" => $data,
                                "order" => $_POST['order'],
                                "query" => $this->jobs_model->get_query($status)
                        );
                
                echo json_encode($output);
            }
            else{
                redirect("404");
            }
        }    
    }

    public function get_categories()
    {
        $this->load->model('category_model');

        $list = $this->category_model->get_datatables();

        $data = array();

        $no = $_POST['start'];
        foreach ($list as $category) {
            

            $no++;
            $row = array();
            
            $row[] = $category->id;
            $row[] = $category->category_name;
                

                $html = '<a href="" onclick="return false;" id="btn-edit" data-scope="edit-category" data-toggle="modal" data-target="#dynamicModal" data-id="'.$category->id.'" class="" style="margin-right:0.25rem;"><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';

                $html .= '<a href="" onclick="return false;" id="btn-disable" data-scope="category" data-id="'.$category->id.'"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
                $row[] = $html;
           

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->category_model->count_all(),
                        "recordsFiltered" => $this->category_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);  
    }

    public function get_job_roles()
    {
        $this->load->model('job_role_model');

        $list = $this->job_role_model->get_datatables();

        $data = array();

        $no = $_POST['start'];
        foreach ($list as $position) {
            

            $no++;
            $row = array();
            
            $row[] = $position->id;
            $row[] = $position->name;
            $row[] = $position->category_name;


                $html = '<a href="" onclick="return false;" id="btn-edit" data-scope="edit-position" data-toggle="modal" data-target="#dynamicModal" data-id="'.$position->id.'" class="" style="margin-right:0.25rem;"><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';

                $html .= '<a href="" onclick="return false;" id="btn-disable" data-scope="position" data-id="'.$position->id.'"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';

            $row[] = $html;
            

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->job_role_model->count_all(),
                        "recordsFiltered" => $this->job_role_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);  
    }

    public function get_religions()
    {
        $this->load->model('religion_model');

        $list = $this->religion_model->get_datatables();

        $data = array();

        $no = $_POST['start'];
        foreach ($list as $religion) {
            

            $no++;
            $row = array();
            
            $row[] = $religion->id;
            $row[] = $religion->religion_name;

                $html = '<a href="" onclick="return false;" id="btn-edit" data-scope="edit-religion" data-toggle="modal" data-target="#dynamicModal" data-id="'.$religion->id.'" class="" style="margin-right:0.25rem;"><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';

                $html .= '<a href="" onclick="return false;" id="btn-disable" data-scope="religion" data-id="'.$religion->id.'"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
               

                    
            $row[] = $html;
           

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->religion_model->count_all(),
                        "recordsFiltered" => $this->religion_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);  
    }

    public function get_industries()
    {
        $this->load->model('industry_model');

        $list = $this->industry_model->get_datatables();

        $data = array();

        $no = $_POST['start'];
        foreach ($list as $industry) {
            

            $no++;
            $row = array();
            
            $row[] = $industry->id;
            $row[] = $industry->industry_name;

                $html = '<a href="" onclick="return false;" id="btn-edit" data-scope="edit-industry" data-toggle="modal" data-target="#dynamicModal" data-id="'.$industry->id.'" class="" style="margin-right:0.25rem;"><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';

                $html .= '<a href="" onclick="return false;" id="btn-disable" data-title="'.$industry->industry_name.'" data-scope="industry" data-id="'.$industry->id.'"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
                    
            $row[] = $html;
            

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->industry_model->count_all(),
                        "recordsFiltered" => $this->industry_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);  
    }

    public function get_advertisements_sliders()
    {
        $this->load->model('advertisement_model');
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1)
            {    
                $list = $this->advertisement_model->get_datatables();

                $data = array();

                $no = $_POST['start'];
                foreach ($list as $advertisement) {
                    $date_now = new DateTime(date('Y-m-d H:i:s'));
                    $end_date = new DateTime($advertisement->end_date);
                    $interval = $date_now->diff($end_date)->format('%R%a days');
                    $advertisement_id = $this->my_encrypt->encode($advertisement->id);
                    $no++;
                    $row = array();
                    
                    $row[] = $advertisement->id;
                    $row[] = $advertisement->company_name;
                    $row[] = $advertisement->ads_title;
                    $row[] = ($advertisement->start_date != NULL)? date('F j, Y', strtotime($advertisement->start_date)) :"TBD";
                    $row[] = ($advertisement->end_date != NULL)? date('F j, Y', strtotime($advertisement->end_date)): "TBD" ;
                    $row[] = $advertisement->duration;
                    $row[] = ($advertisement->is_active == 1)? "Active":"Inactive";

                    if($advertisement->is_active == 1){
                         $html = '<a href="" onclick="return false;" id="btn-deactivate" data-id="'.$advertisement_id.'" data-title="'.$advertisement->ads_title.'" class="ml-2"><i class="fa fa-power-off fc-grey fa-1x"></i></a>';
                    }
                    else{
                        $html = '<a href="" onclick="return false;" id="btn-activate" data-id="'.$advertisement_id.'" data-title="'.$advertisement->ads_title.'" class="ml-2"><i class="fa fa-check fc-grey fa-1x"></i></a>';
                    }

                    $html .= '<a href="" onclick="return false;" id="btn-view" data-toggle="modal" data-target="#dynamicModal" data-id="'.$advertisement_id.'" data-title="'.$advertisement->ads_title.'" class="ml-2"><img id="view" src="'.base_url('assets/images/app/PreviewDataTableIcon.png').'" ></a> ';
                    
                    $html .= '<a href="" onclick="return false;" id="btn-edit" data-toggle="modal" data-target="#dynamicModal" data-id="'.$advertisement_id.'" data-title="'.$advertisement->ads_title.'" class="" style="margin-right:0.25rem;"><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';

                    $html .= '<a href="" onclick="return false;" id="btn-delete" data-id="'.$advertisement_id.'" data-title="'.$advertisement->ads_title.'"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
                            
                    $row[] = $html;
                    

                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => $this->advertisement_model->count_all(),
                                "recordsFiltered" => $this->advertisement_model->count_filtered(),
                                "data" => $data,
                        );
                //output to json format
                echo json_encode($output); 
            }
            else{
                redirect("404");
            }
        }    
    }

    public function get_featured_jobs()
    {
        $this->load->model('featured_job_model');
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1)
            {    
                $list = $this->featured_job_model->get_datatables();

                $data = array();

                $no = $_POST['start'];
                foreach ($list as $advertisement) {
                    $date_now = new DateTime(date('Y-m-d H:i:s'));
                    $end_date = new DateTime($advertisement->end_date);
                    $interval = $date_now->diff($end_date)->format('%R%a days');
                    $advertisement_id = $this->my_encrypt->encode($advertisement->id);
                    $no++;
                    $row = array();
                    
                    $row[] = $advertisement->id;
                    $row[] = $advertisement->company_name;
                    $row[] = ($advertisement->use_alternative == 1)? $advertisement->alternative_title:$advertisement->job_position;
                    $row[] = $advertisement->duration ." days";
                    $row[] = ($advertisement->start_date != NULL)? date('F j, Y', strtotime($advertisement->start_date)) :"TBD";
                    $row[] = ($advertisement->end_date != NULL)? date('F j, Y', strtotime($advertisement->end_date)): "TBD" ;
                    $row[] = ($advertisement->is_active == 1)? "Active":"Inactive";

                    if($advertisement->is_active == 1){
                         $html = '<a href="" onclick="return false;" id="btn-deactivate" data-id="'.$advertisement_id.'" data-title="'.$advertisement->job_position.'" class="ml-2"><i class="fa fa-power-off fc-grey fa-1x"></i></a>';
                    }
                    else{
                        $html = '<a href="" onclick="return false;" id="btn-activate" data-id="'.$advertisement_id.'" data-title="'.$advertisement->job_position.'" class="ml-2"><i class="fa fa-check fc-grey fa-1x"></i></a>';
                    }

                    // $html .= '<a href="'.$advertisement->url.'" target="'.$advertisement->url.'" class="ml-2"><img id="view" src="'.base_url('assets/images/app/PreviewDataTableIcon.png').'" ></a> ';
                    
                    $html .= '<a href="" onclick="return false;" id="btn-edit" data-toggle="modal" data-target="#dynamicModal" data-id="'.$advertisement_id.'" data-title="'.$advertisement->job_position.'" class="" style="margin-right:0.25rem;"><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';

                    $html .= '<a href="" onclick="return false;" id="btn-delete" data-id="'.$advertisement_id.'" data-title="'.$advertisement->job_position.'"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
                            
                    $row[] = $html;
                    

                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => $this->featured_job_model->count_all(),
                                "recordsFiltered" => $this->featured_job_model->count_filtered(),
                                "data" => $data,
                        );
                //output to json format
                echo json_encode($output); 
            }
            else{
                redirect("404");
            }
        }    
    }

    public function get_featured_jobs_by_location()
    {
        $this->load->model('featured_jobByLocation_model');
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1)
            {    
                $list = $this->featured_jobByLocation_model->get_datatables();

                $data = array();

                $no = $_POST['start'];
                foreach ($list as $advertisement) {
                    $date_now = new DateTime(date('Y-m-d H:i:s'));
                    $end_date = new DateTime($advertisement->end_date);
                    $interval = $date_now->diff($end_date)->format('%R%a days');
                    $advertisement_id = $this->my_encrypt->encode($advertisement->id);
                    $no++;
                    $row = array();
                    
                    $row[] = $advertisement->id;
                    $row[] = $advertisement->company_name;
                    $row[] = ($advertisement->use_alternative == 1)? $advertisement->alternative_title:$advertisement->job_position;
                    $row[] = $advertisement->duration ." days";
                    $row[] = ($advertisement->start_date != NULL)? date('F j, Y', strtotime($advertisement->start_date)) :"TBD";
                    $row[] = ($advertisement->end_date != NULL)? date('F j, Y', strtotime($advertisement->end_date)): "TBD" ;
                    $row[] = ($advertisement->is_active == 1)? "Active":"Inactive";

                    if($advertisement->is_active == 1){
                         $html = '<a href="" onclick="return false;" id="btn-deactivate" data-id="'.$advertisement_id.'" data-title="'.$advertisement->job_position.'" class="ml-2"><i class="fa fa-power-off fc-grey fa-1x"></i></a>';
                    }
                    else{
                        $html = '<a href="" onclick="return false;" id="btn-activate" data-id="'.$advertisement_id.'" data-title="'.$advertisement->job_position.'" class="ml-2"><i class="fa fa-check fc-grey fa-1x"></i></a>'; 
                    }

                    // $html .= '<a href="'.$advertisement->url.'" target="'.$advertisement->url.'" class="ml-2"><img id="view" src="'.base_url('assets/images/app/PreviewDataTableIcon.png').'" ></a> ';
                    
                    $html .= '<a href="" onclick="return false;" id="btn-edit" data-toggle="modal" data-target="#dynamicModal" data-id="'.$advertisement_id.'" data-title="'.$advertisement->job_position.'" class="" style="margin-right:0.25rem;"><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';

                    $html .= '<a href="" onclick="return false;" id="btn-delete" data-id="'.$advertisement_id.'" data-title="'.$advertisement->job_position.'"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
                            
                    $row[] = $html;

                    $row[] = $advertisement->location_id;
                     

                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => $this->featured_jobByLocation_model->count_all(),
                                "recordsFiltered" => $this->featured_jobByLocation_model->count_filtered(),
                                "data" => $data,
                        );
                //output to json format
                echo json_encode($output); 
            }
            else{
                redirect("404");
            }
        }    
    }

    public function get_featured_companies()
    {
        $this->load->model('featured_company_model');
        if(isset($_COOKIE['_ut']) && $_COOKIE['_typ'])
        {
            $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 1)
            {    
                $list = $this->featured_company_model->get_datatables();

                $data = array();

                $no = $_POST['start'];
                foreach ($list as $advertisement) {
                    $date_now = new DateTime(date('Y-m-d H:i:s'));
                    $end_date = new DateTime($advertisement->end_date);
                    $interval = $date_now->diff($end_date)->format('%R%a days');
                    $advertisement_id = $this->my_encrypt->encode($advertisement->id);
                    $no++;
                    $row = array();
                    
                    $row[] = $advertisement->id;
                    $row[] = $advertisement->company_name;
                    $row[] = $advertisement->industry_name;
                    $row[] = $advertisement->city_name.", ".$advertisement->region_name;
                    $row[] = $advertisement->duration ." days";
                    $row[] = ($advertisement->start_date != NULL)? date('F j, Y', strtotime($advertisement->start_date)) :"TBD";
                    $row[] = ($advertisement->end_date != NULL)? date('F j, Y', strtotime($advertisement->end_date)): "TBD" ;
                    $row[] = ($advertisement->is_active == 1)? "Active":"Inactive";

                    $html = '<div class="list-unstyled">';
                        if($advertisement->is_active == 1){
                            $html .= '<li class="text-center">';
                                $html .= '<a href="" onclick="return false;" id="btn-deactivate" data-id="'.$advertisement_id.'" data-title="'.$advertisement->company_name.'" class=""><i class="fa fa-power-off fc-grey fa-1x"></i></a>';
                            $html .= '</li>';
                        }else{
                            $html .= '<li class="text-center">';
                                $html .= '<a href="" onclick="return false;" id="btn-activate" data-id="'.$advertisement_id.'" data-title="'.$advertisement->company_name.'" class=""><i class="fa fa-check fc-grey fa-1x"></i></a>';
                            $html .= '</li>';
                        }
                       
                        $html .= '<li class="text-center mb-1">';
                            $html .= '<a href="" onclick="return false;" id="btn-edit" data-toggle="modal" data-target="#dynamicModal" data-id="'.$advertisement_id.'" data-title="'.$advertisement->company_name.'" class="" style=""><img id="edit" src="'.base_url('assets/images/app/EditDataTableIcon.png').'"></a> ';
                        $html .= '</li>';
                        $html .= '<li class="text-center">';
                            $html .= '<a href="" onclick="return false;" id="btn-delete" data-id="'.$advertisement_id.'" data-title="'.$advertisement->company_name.'"><img id="delete" src="'.base_url('assets/images/app/DeleteDataTableIcon.png').'"></a>';
                        $html .= '</li>';    
                    $html .= '</div>';

                    $row[] = $html;
                    

                    $data[] = $row;
                }

                $output = array(
                                "draw" => $_POST['draw'],
                                "recordsTotal" => $this->featured_company_model->count_all(),
                                "recordsFiltered" => $this->featured_company_model->count_filtered(),
                                "data" => $data,
                        );
                //output to json format
                echo json_encode($output); 
            }
            else{
                redirect("404");
            }
        }    
    }

    public function createAdmin()
    {
        $uid = $this->functions->guid();
        $user['user_id'] = $uid;
        $user['username'] = "admin";
        $user['password'] = $this->my_encrypt->encrypt("Admin@12345");
        $user['account_type'] = 1;
        $user['email'] = "jerick.labasan@csic.ph";
        $user['date_created'] = date('Y-m-d h:i:s');
        $user['status'] = 1;
        $user['status_1'] = 1;
        $user['email_activated'] = 1;
        $user['is_active'] = 1;

        $user_info['user_id'] = $uid;
        $user_info['first_name'] = "JFO";
        $user_info['middle_name'] = "First";
        $user_info['last_name'] = "Admin";
        $user_info['profile_pic'] ="";
        $user_info['street'] = "Kanto St";
        $user_info['city'] = 12;
        $user_info['province'] = 1;
        $user_info['date_create'] = date('Y-m-d h:i:s');
        $user_info['date_modified'] = date('Y-m-d h:i:s');
        $user_info['is_active'] = 1;
        $this->admin_model->create($user, $user_info);
    }   
}
