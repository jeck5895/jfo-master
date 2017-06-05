
<div class="sidebar-wide">
    <div class="info-container fs-12">
        <div class="user-image">
            <img src="<?php echo ($user->profile_pic != '')? $user_image : base_url('assets/images/Default_User1.png'); ?>" class="img-fluid" alt="User Image">
        </div>
        <div class="user-info sidenav hidden-md-down">
            <?php $firstname = strtolower($user->first_name); $lastname = strtolower($user->last_name); $middle = ($user->middle_name != "")? strtolower($user->middle_name):"";?>
            <label class="user-name"><?php  echo ucfirst($firstname)." ".ucfirst($lastname); ?></label>  
            <ul class="list-unstyled">
                <li><?=$user->city.", ".$user->province?></li>
                <li><?=$user->email?></li>
                <li><i class="fa fa-phone"></i> <?=$user->mobile_num?></li>
            </ul>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li>    
            <a id="sidebar-nav-collapse" data-toggle="collapse" href="#collapseSidebar" aria-expanded="false" aria-controls="collapseSidebar">
                <i class="fa fa-file"></i> <span class="hidden-md-down">Applications</span>
            </a>
            <div class="collapse" id="collapseSidebar">
                <div class="card card-block">
                    <ul class="dashboard-menu list-unstyled">
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('applicant/applications/pending')?>" style="color: #909090;">
                                Pending Applications
                               
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('applicant/applications/withdrawn')?>" style="color: #909090;">
                                Withdrawn
            
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('applicant/applications/for-interview')?>" style="color: #909090;">
                                For Interview
                                <span id="interview-badge" class="badge badge-pill badge-danger badge-align-right">0</span>
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('applicant/applications/reviewed')?>" style="color: #909090;">
                                Reviewed
                                <span id="review-badge" class="badge badge-pill badge-danger badge-align-right">0</span>
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('applicant/applications/declined')?>" style="color: #909090;">
                                Declined
                                <span id="reject-badge" class="badge badge-pill badge-danger badge-align-right">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <a href="<?=site_url('applicant/recommended-jobs')?>">
                <i class="fa fa-check-square-o"></i>  <span class="hidden-md-down">Recommended Jobs</span>
            </a>
        </li>
        <li>
            <a href="<?=site_url('jobs')?>">
                <i class="fa fa-search"></i> <span class="hidden-md-down">Search Jobs</span>
            </a>
        </li>
        <li>
            <a href="<?=site_url('applicant/profile')?>">
                <i class="fa fa-user-circle"></i>  <span class="hidden-md-down">My Profile</span>
            </a>
        </li>
    </ul>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/applicant/applicant.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dropzone.js');?>"></script>