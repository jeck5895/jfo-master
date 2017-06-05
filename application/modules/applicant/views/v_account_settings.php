<?php $this->load->view('applicant/v_applicant_sidebar')?>
<div class="content-wrapper">
    <section class="content-header" style="">

    </section>  
    <section class="content">
        <div class="row">
            <div class="form-box">
                <h5> Account Settings</h5>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-info-box">
                            <h6 class="header">Profile Status</h6>
                            <div class="pull-top-beside-label toggle-box">
                                <label class="tgl">
                                    <input type="checkbox" name="info_status" checked/>
                                    <span class="tgl_body">
                                        <span class="tgl_switch"></span>
                                        <span class="tgl_track">
                                            <span class="tgl_bgd">Public</span>
                                            <span class="tgl_bgd tgl_bgd-negative">Private</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="box box-widget">
                    <div class="box-header with-border form-note">
                        <small><p>Making your profile <strong class="text-success">PUBLIC</strong> will allow all recruiters to view your profile, making it <strong class="text-danger">PRIVATE</strong> will allow recruiters whom you applied to view your profile. </p></small>
                    </div>
                </div>  
                    
               
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h6> CHANGE EMAIL</h6>
                    </div>
                    <div class="box-body">
                        <form id="form-change-email">
                            <div class="row col-md-8 offset-md-2">
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Current Email</small></label>
                                    <p id="current-email"></p>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>New Email</small></label>
                                    <input type="email" class="form-control" name="newEmail" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Password</small></label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3" style="margin: 0 auto;">
                                    <button id="btn-save-email" type="submit" class="btn btn-success btn-materialize">Save Changes</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>

                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h6> CHANGE MOBILE NUMBER</h6>
                    </div>
                    <div class="box-body">
                        <form id="form-change-mobile">
                            <div class="row col-md-8 offset-md-2">
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Current Mobile No.</small></label>
                                    <p id="current-mobile"></p>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Phone number</small></label>
                                    <input type="text" id="phone" minlength="11" value="" name="phonenumber" placeholder="0935-353-1234" class="form-control" data-inputmask='"mask": "09-9999-99999"' data-mask tabindex="">
                                </div>

                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Password</small></label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter your current password" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3" style="margin: 0 auto;">
                                    <button id="btn-save-mobile" type="submit" class="btn btn-success btn-materialize">Save Changes</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>

                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h6> CHANGE PASSWORD</h6>
                    </div>
                    <div class="box-body">
                        <form id="form-change-password">
                            <div class="row col-md-8 offset-md-2">
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Current Password</small></label>
                                    <input type="password" class="form-control" name="oldPassword" placeholder="Enter your current password" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>New Password</small></label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Confirm Password</small></label>
                                    <input type="password" class="form-control" name="confirmPassword" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3" style="margin: 0 auto;">
                                    <button id="btn-save-password" type="submit" class="btn btn-success btn-materialize">Save Changes</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>

            </div>  
           
            <?php $this->load->view('template/v_ads_box')?>    
        </div>
    </section>
</div>

<script type="text/javascript" src="<?=base_url('assets/js/applicant/settings.js')?>"></script>
<?= $this->load->view('template/modal')?>