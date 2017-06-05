<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="form-box-max" style="">
                <center><h5>Account Settings</h5></center>
                <hr>

                <div class="box box-widget">
                    
                    <div class="box-header with-border">
                        <h6> PERSONAL INFORMATION</h6>
                    </div>
                    
                    <div class="box-body">
                    
                        <form action="" method="" id="form-admin-info">

                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label class="control-label "><small>First Name</small></label>
                                    <input type="text" name="first_name" value="<?=$admin->first_name?>" class="form-control" placeholder="" tabindex="1" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label class="control-label "><small>Middle Name</small></label>
                                    <input type="text" name="middlename" value="<?=$admin->middle_name?>" class="form-control" placeholder="" tabindex="2" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label class="control-label ">Last Name</label>
                                    <input type="text" name="lastname" class="form-control" placeholder="" value="<?=$admin->last_name?>" tabindex="3" required>
                                </div>
                            </div>

                            <div class="row">   
                                <div class="form-group col-sm-6">
                                    <label for="email" class="control-label"><small>Street / Barangay</small></label>
                                    <input type="text" name="street" class="form-control" value="<?=$admin->street?>" placeholder="Street Address" tabindex="4" required>
                                </div>
                                <div class="form-group col-sm-6">
                                   <label class="control-label required"><small>Municipality/Province</small> <small class="text-muted">(click to set location)</small></label>
                                   <input type="text" class="form-control" name="permanent-address" value="<?php echo $admin->city."&#44;".$admin->province ; ?>" tabindex="5" onkeydown="return false;" required>
                                   <input type="hidden" name="region_id" value="<?=$admin->region_id?>">
                                   <input type="hidden" name="city_id" value="<?=$admin->city_id?>">
                               </div>
                            </div>



                            <div class="col-md-6">
                            <div class="form-group">
                                <button id="btn-save-info" name="submit" class="btn btn-success btn-materialize">Save Changes</button>
                            </div>
                        </div>

                    </form>    
                       
                    </div>
                </div>

                <div class="box box-widget">
                    
                    <div class="box-header with-border">
                        <h6> CHANGE EMAIL</h6>
                    </div>
                    
                    <div class="box-body">
                        <form id="email_settings_form">
                            <div class="row col-md-6 offset-md-3">
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Current Email</small></label>
                                    <p id="current_email"><?=$admin->email?></p>
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
                        <form id="change_mobile_number_form">
                            <div class="row col-md-6 offset-md-3">
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Current Mobile No.</small></label>
                                    <p id="current-mobile"><?=$admin->mobile_num?></p>
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
                        <form id="change_password_form">
                            <div class="row col-md-6 offset-md-3">
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

                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h6> SMTP SETTINGS (ACCOUNT FOR SENDING EMAILS)</h6>
                    </div>
                    <div class="box-body">
                        <form id="smtp_email_form">
                            <div class="row col-md-6 offset-md-3">
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Email</small></label>
                                    <input type="email" class="form-control" name="smtp_email" value="<?=$smtp_acct->smtp_user?>" required>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3" style="margin: 0 auto;">
                                    <button id="btn-save-smtp-email" type="submit" class="btn btn-success btn-materialize">Save Changes</button>
                                </div>
                            </div> 
                        </form>

                        <form id="smtp_password_form">
                            <div class="row col-md-6 offset-md-3">
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>New Password</small></label>
                                    <input type="password" class="form-control" id="newSmtpPassword" name="newSmtpPassword" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Confirm Password</small></label>
                                    <input type="password" class="form-control" name="confirmSmtpPassword" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3" style="margin: 0 auto;">
                                    <button id="btn-save-smtp-password" type="submit" class="btn btn-success btn-materialize">Save Changes</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>            
<?php $this->load->view('template/modal')?> 
<script type="text/javascript" src="<?=base_url('assets/js/admin/acs.js')?>"></script>