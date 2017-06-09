
<div class="sidebar-wide bg-dark-purple">
    <div class="info-container fs-12">
        <div class="user-image">
            <img src="<?php echo $company_logo?>" class="img-fluid" alt="User Image">
        </div>
        <div class="user-info sidenav hidden-md-down">
            <?php $company_name = strtolower($employer->company_name);?>
            <label class="user-name"><?php  echo ucfirst($company_name); ?></label>  
            <ul class="list-unstyled">
                <li><?=$employer->city.", ".$employer->province?></li>
                <li><?=$employer->email?></li>
            </ul>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li>    
            <a id="sidebar-nav-collapse" data-toggle="collapse" href="#collapseSidebar" aria-expanded="false" aria-controls="collapseSidebar">
                <i class="fa fa-users"></i> <span class="hidden-md-down">Applicants</span>
            </a>
            <div class="collapse" id="collapseSidebar">
                <div class="card card-block">
                    <ul class="dashboard-menu list-unstyled">
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('company/applicants/dashboard')?>" style="color: #909090;">
                                Applicants on Job Post
                                <span id="pending-badge" class="badge badge-pill badge-danger badge-align-right">0</span>
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('candidates')?>" style="color: #909090;">
                                Search All Candidates
                                <!-- <span id="interview-badge" class="badge badge-pill badge-danger badge-align-right">0</span> -->
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <a href="<?=site_url('co/jobs')?>">
                <i class="fa fa-briefcase"></i> <span class="hidden-md-down">Review Posted Jobs</span>
            </a>
        </li>
        <li>
            <a href="<?=site_url('co/job/create')?>">
                <i class="fa fa-plus-circle"></i>  <span class="hidden-md-down">Create Job Post</span>
            </a>
        </li>
        <li>
            <a href="<?=site_url('co/profile/edit')?>">
                <i class="fa fa-edit"></i>  <span class="hidden-md-down">Edit Profile</span>
            </a>
        </li>
        <li>
            <a href="<?=site_url('co/profile/settings')?>">
                <i class="fa fa-gears"></i>  <span class="hidden-md-down">Company Settings</span>
            </a>
        </li>
        <li>
            <a href="<?=site_url('companies/'.str_replace("+","-",urlencode(ucfirst($company_name))).'-'.$employer->id)?>">
                <i class="fa fa-building"></i>  <span class="hidden-md-down">Company Profile</span>
            </a>
        </li>
    </ul>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/company/pjp.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dropzone.js');?>"></script>