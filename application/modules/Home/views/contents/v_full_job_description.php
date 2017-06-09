<?php
    $this->load->model('notification/notification_model'); 
    if(isset($_GET['notif_id']))
    {

        $notif_id = $_GET['notif_id'];
        $data['status'] = 0;
        $data['date_modified'] = date("Y-m-d H:i:s");

        $this->notification_model->update($notif_id, $data);
    }
?>
<?php if(isset($_COOKIE['_ut']) && isset($_COOKIE['_u']) && isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == "ap"):?>
    <?=$this->load->view('template/v_home_sidebar');//$this->load->view('applicant/v_applicant_sidebar');?>
<?php endif;?>

<div class="container">
    <div class="col-md-10 offset-md-1">
        <div class="c-profile-box job-details">
            <div class="box-header">
            <div class="btn-box pull-right mt-2 mr-4">
                <?php $this->load->model('auth/auth_model');?>
                <?php if(!isset($_COOKIE['_ut'])):?>

                    <div class="pull-right">
                        <a href="<?=base_url('login?redirect='.$_SERVER['REDIRECT_URL'])?>" class="btn btn-primary btn-materialize">Login to Apply</a>
                    </div>

                <?php else:?>
                    <?php $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);?> 
                    <?php if($user->account_type == 2 && $user->is_active == 1):?>   

                        <div id="app-option" class="">
                            <button id="btn-apply" class="btn btn-info btn-materialize btn-materialize-sm ripple">Apply</button>
                            <button id="btn-add-job" class="btn btn-secondary btn-materialize btn-materialize-sm ripple">Add to My Joblist</button> 
                        </div>
                    <?php elseif($user->account_type == 2 && $user->is_active == 0):?>
                        <div id="" class="warning-box">
                            <label class="error">Your account has been set to inactive status due to some inconsistency in your profile information. Please fix your information.</label>
                        </div>    
                    <?php endif;?>


                <?php endif?>
            </div>
            </div>
            <div class="job-box-body">

                <div class="c-info-box-header">
                    <div class="col-md-9 no-pad-lr">
                        <h4 class="header" id="job-title"></h4>
                    </div>
                    <small><a id="company" href="#" target="" class="light-blue"></a></small>
                    <div class="company-logo-container pull-top-right t-3 r-3 hidden-md-down">
                        <img id="company-logo" src="" alt="" class="img-fluid" />
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <dl class="row"> 
                                <div class="col-sm-4">
                                    <small>
                                        <label class="header">Salary</label>
                                    </small>
                                </div>
                                <div class="col-sm-8"> <small><p id="salary"></p></small></div>

                                <div class="col-sm-4">
                                    <small>
                                        <label class="header">Location</label>
                                    </small>
                                </div>
                                <div class="col-sm-8"><small><p id="location"></p></small></div>
                            </dl>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <small>
                                <p id="job-expiration"><small class="text-muted"><strong>Posted</strong>: <span id="job-opendate"></span></small></p>
                                <p><small class="text-muted"><strong>Until</strong>: <span id="job-duedate"></span></small></p>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="about-box">
                    <h5 class="header light-black">Job Qualification</h5>

                    <dl class="row"> 
                        <div class="col-sm-4">
                            <small>
                                <label class="header">Education Attainment:</label>
                            </small>
                        </div>
                        <div class="col-sm-8"> <small><p id="educ-qualification"></p></small></div>

                        <div class="col-sm-4">
                            <small>
                                <label class="header">Preffered Course:</label>
                            </small>
                        </div>
                        <div class="col-sm-8"><small><p id="preferred-course"></p></small></div>
                    </dl>
                </div>

                <div class="about-box">
                    <h5 class="header light-black">Job Information</h5>
                    
                    <dl class="row"> 
                        <div class="col-sm-4">
                            <small>
                                <label class="header">No. of Vacancies:</label>
                            </small>
                        </div>
                        <div class="col-sm-8"> <small><p id="job-vacancy"></p></small></div>

                        <div class="col-sm-4">
                            <small>
                                <label class="header">Job Category:</label>
                            </small>
                        </div>
                        <div class="col-sm-8"><small><p id="job-category"></p></small></div>
                    </dl>
                </div>

                <div class="about-box">
                    <h5 class="header light-black">Work Description</h5>   
                    <div id="job-description"></div>
               
                </div>

            </div> 
        </div>

        <div class="box box-widget">
            <div class="box-header">
                <div class="">
                    <h6 class="header">Related Job Posts</h6>
                </div>
            </div>
        </div>

        <div class="">
            <div id="jobs-container">

            </div>
            <div class="pagination-box">
                <p id="jobs-pagination"></p>
            </div>      
        </div>
        <?php 
            $this->load->model('api/auth_model');
            if(isset($_COOKIE['_ut'])):
                $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
            if(!empty($user) && $user->account_type == 2):
        ?>
            <div style="padding: 5px; margin-bottom: 1rem;">
                <center><a href="<?=site_url('jobs/')?>">See All Jobs</a></center>
            </div>
        <?php 
                endif;
            endif;
        ?>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/jdesc.js')?>"></script>    

<?php 
    $this->load->model('api/auth_model');
    if(isset($_COOKIE['_ut'])):
        $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);
        if(!empty($user) && $user->account_type == 3):
?>
    <script type="text/javascript" src="<?php echo base_url('assets/js/company/pjp.js');?>"></script>
<?php 
        endif;
    endif;
?>