
<div class="sidebar-wide bg-semi-dark">
    <div class="info-container fs-12">
        <div class="user-image">
            <img src="<?= ($admin->profile_pic != '')? $admin_logo : base_url('assets/images/Default_User2.png'); ?>" class="img-fluid" alt="User Image">
        </div>
        <div class="user-info sidenav hidden-md-down">
            <?php $fname = strtolower($admin->first_name); $mname = strtolower($admin->middle_name); $lname= strtolower($admin->last_name);?>
            <label class="user-name"><?=ucfirst($fname) ." ". ucfirst($mname[0])."."." ". ucfirst($lname)?></label>  
            <small><p class="">Administrator</p></small>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li>
            <a href="<?=site_url('admin/dashboard')?>">
                <i class="fa fa-tachometer"></i> <span class="hidden-md-down">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="<?=site_url('admin/review/jobs')?>">
                <i class="fa fa-file-o"></i>  <span class="hidden-md-down">Review Job Post</span>
            </a>
        </li>
        <li>    
            <a id="sidebar-nav-collapse" data-toggle="collapse" href="#collapseSidebar" aria-expanded="false" aria-controls="collapseSidebar">
                <i class="fa fa-users"></i> <span class="hidden-md-down">Applicants</span>
            </a>
            <div class="collapse" id="collapseSidebar">
                <div class="card card-block">
                    <ul class="dashboard-menu list-unstyled">
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/applicants/for-review')?>" style="color: #909090;">
                                For Review
                                <!-- <span id="pending-badge" class="badge badge-pill badge-danger badge-align-right">0</span> -->
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/applicants/public')?>" style="color: #909090;">
                                Public Applicants
                                <!-- <span id="interview-badge" class="badge badge-pill badge-danger badge-align-right">0</span> -->
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/applicants/private')?>" style="color: #909090;">
                                Private Applicants
                                <!-- <span id="interview-badge" class="badge badge-pill badge-danger badge-align-right">0</span> -->
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/applicants/inactive')?>" style="color: #909090;">
                                Inactive Applicants
                                <!-- <span id="interview-badge" class="badge badge-pill badge-danger badge-align-right">0</span> -->
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <a href="<?=site_url('admin/companies')?>">
                <i class="fa fa-building-o"></i>  <span class="hidden-md-down">Companies</span>
            </a>
        </li>
        <li>    
            <a id="sidebar-nav-collapse-maintenance" data-toggle="collapse" href="#collapseSidebarMaintenance" aria-expanded="false" aria-controls="collapseSidebar">
                <i class="fa fa-wrench"></i> <span class="hidden-md-down">Maintenance</span>
            </a>
            <div class="collapse" id="collapseSidebarMaintenance">
                <div class="card card-block">
                    <ul class="maintenance-menu list-unstyled">
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/maintenance/keywords')?>" style="color: #909090;">
                                Form Keywords
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/account/settings')?>" style="color: #909090;">
                                Account Settings
                                
                            </a>
                        </li>

                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <label class="text-bold">
                                Advertisements
                            </label>    
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/maintenance/advertisements/sliders')?>" style="color: #909090;">
                                Slider
                                
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/maintenance/advertisements/logo')?>" style="color: #909090;">
                                Featured Logo
                                
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/maintenance/advertisements/featured/companies')?>" style="color: #909090;">
                                Featured Companies
                                
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/maintenance/advertisements/featured/jobs')?>" style="color: #909090;">
                                Featured Job Post
                            </a>
                        </li>
                        <li style="font-size: 12px; margin-bottom: 5px;">
                            <a href="<?=site_url('admin/maintenance/advertisements/featured/jobs-by-location')?>" style="color: #909090;">
                                Featured Job Post by City
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <a href="<?=site_url('admin/activity-logs')?>">
                <i class="fa fa-tasks"></i>  <span class="hidden-md-down">Activity Logs</span>
            </a>
        </li>
    </ul>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dropzone.js');?>"></script>