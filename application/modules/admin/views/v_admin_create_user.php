<div class="container-fluid">
    <section class="content-header" style="">
        <?php $this->load->view('v_admin_header');?>
    </section>

    <section class="content">
        
        <div class="row">
            <?php //$this->load->view('v_admin_sidenav');?>

            <div class="col-lg-10" style="padding-left: 0;"> <!-- remove-pad -->
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h1 class="registration-title">Create User</h1>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="create-user-form" action="" method="">
                                    <div class="form-group">
                                        <label for="email" class="control-label required"><small>Full Name</small></label>
                                        
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" name="firstname" class="form-control" placeholder="First name" required tabindex="1" autofocus>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="middlename" class="form-control" placeholder="Middle name" required tabindex="2">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="lastname" class="form-control" placeholder="Last name" required tabindex="3">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                
                                                    <label class="control-label required"><small>Street / Barangay</small></label>
                                                    <input type="text" name="street" class="form-control" placeholder="" value="" tabindex="8">
                                                
                                            </div>
                                            <div class="col-md-8">
                                                
                                                    <label class="control-label required"><small>Municipality/Province</small> <small class="text-muted">(click to set location)</small></label>
                                                    <input type="text" class="form-control" name="permanent-address" value="" tabindex="9" onkeydown="return false;">
                                                    <input type="hidden" name="region_id" value="">
                                                    <input type="hidden" name="city_id" value="">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-bottom:0.5rem;">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label required"><small>Type of User</small></label>

                                                <select tabindex="6" class="form-control" name="gender">
                                                    <option> </option>
                                                    <option value="Administrator"> Administrator</option>
                                                    <option value="Recruiter"> Recruiter</option>
                                                    <option value="Branch Manager"> Branch Manager</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="email" class="control-label required"><small>Phone Number</small></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input type="text" id="phone" name="phonenumber" value="" placeholder="0935-312-3412" class="form-control" data-inputmask='"mask": "0999-999-9999"' data-mask tabindex="11">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                
                                                    <label for="email" class="control-label required"><small>Email</small></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">@</span>
                                                        <input type="email" id="email" name="email" class="form-control" value="" placeholder="example@yahoo.com" tabindex="10">
                                                    </div>
                                                
                                            </div>
                                        </div>                                        
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group" style="margin-bottom:0.5rem;">
                                                    <label for="email" class="control-label required"><small>Password</small></label>
                                                    <input type="password" id="password" name="password" value="" class="form-control" placeholder="Password" tabindex="12">
                                        
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="email" class="control-label required"><small>Confirm Password</small></label>
                                                <input type="password" name="confirmPassword" value="" class="form-control" placeholder="Re-type password" tabindex="13">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success" id="submit" name="submit" tabindex="13">Create User</button>
                                    </div>
                                </form>
                            </div>  
                        </div>  
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<?php $this->load->view('template/profile_modal')?>
<?php $this->load->view('template/modal')?>
