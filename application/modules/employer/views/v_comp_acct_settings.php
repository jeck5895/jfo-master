<?php $this->load->view('employer/v_employer_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">

    </section>  
    <section class="content">
        <div class="row">
            <div class="form-box-max">
                <h5> Account Settings</h5>
                <hr>
                      
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h6> CHANGE EMAIL</h6>
                    </div>
                    <div class="box-body">
                        <form id="email_settings_form">
                            <div class="row col-md-6 offset-md-3">
                                <div class="form-group col-sm-12">
                                    <label class="form-control-label"><small>Current Email</small></label>
                                    <p id="current_email"><?=$employer->email?></p>
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
                                    <p id="current-mobile"><?=$employer->mobile_num?></p>
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

            </div>  
        </div>
    </section>
</div>
<script type="text/javascript" src="<?=base_url('assets/js/employer_acct_settings.js')?>"></script>

