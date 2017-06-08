
<div class="sidebar hidden-md-down" id="sidebar-mini">
    <div class="info-container">
        <div class="user-image">
            <img src="<?php echo ($user->profile_pic != '')? $user_image :base_url('assets/images/Default_User1.png');?>" class="img-fluid" alt="User Image">
        </div>
    </div>
    <ul class="sidebar-nav">
        <li>    
            <a id="sidebar-nav-collapse" href="<?=site_url('applicant/applications/pending')?>" title="My Applications">
                <i class="fa fa-file"></i> 
            </a>
        </li>
        <li>
            <a href="<?=site_url('applicant/recommended-jobs')?>" title="Recommended Jobs">
                <i class="fa fa-check-square-o"></i>
            </a>
        </li>
        <li>
            <a href="<?=site_url('jobs')?>" title="Search Jobs">
                <i class="fa fa-search"></i> 
            </a>
        </li>
        <li>
            <a href="<?=site_url('applicant/profile')?>" title="My Profile">
                <i class="fa fa-user-circle"></i>  
            </a>
        </li>
    </ul>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/applicant/applicant.js');?>"></script>
