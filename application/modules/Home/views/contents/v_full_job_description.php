<div class="container">
    <div class="col-md-10 offset-md-1">
        <div class="c-profile-box">
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

                <div class="btn-box">
                    <?php $this->load->model('auth/auth_model');?>
                    <?php if(!isset($_COOKIE['_ut'])):?>
                        
                        <div class="pull-right">
                            <a href="<?=base_url('login?redirect='.$_SERVER['REDIRECT_URL'])?>" class="btn btn-primary btn-materialize">Login to Apply</a>
                        </div>
                        
                    <?php else:?>
                            <?php $user = $this->auth_model->getUserByToken($_COOKIE['_ut']);?> 
                            <?php if($user->account_type == 2):?>   
                            
                            <div id="app-option" class="pull-right">
                                <button id="btn-apply" class="btn btn-info btn-materialize btn-materialize-sm">Apply</button>
                                <button id="btn-add-job" class="btn btn-secondary btn-materialize btn-materialize-sm">Add to My Joblist</button> 
                            </div>
                            <?php endif;?>
                  
                            
                    <?php endif?>
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
        <div style="padding: 5px; margin-bottom: 1rem;">
            <center><a href="<?=site_url('jobs/')?>">See All Jobs</a></center>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/jdesc.js')?>"></script>    