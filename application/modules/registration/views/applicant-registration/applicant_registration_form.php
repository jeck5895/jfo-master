<div class="container">
    <section class="content margin-header-top-65">
        <div class="row">
            <div class="col-md-8 offset-md-2">
            <?php echo form_open_multipart('',array("id"=>"applicant-registration-form"));?>
                <?=form_hidden('token',$token) ?>
                <h4 class="registration-title">Personal Information</h4>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required"><small>First Name</small></label>
            
                            <input type="text" name="firstname" class="form-control" value="" placeholder="First Name" tabindex="1" autofocus>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"><small>Middle Name</small></label>
                           
                            <input type="text" name="middlename" class="form-control" value="" placeholder="Middle Name" tabindex="2">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required"><small>Last Name</small></label>
                            
                            <input type="text" name="lastname" class="form-control" value="" placeholder="Last Name" tabindex="3">
                        </div>
                    </div>
                </div>
                  
                <div class="row">  
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label required"><small>Birthdate</small></label>

                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" name="birth_month" required tabindex="4">
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>                                            
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" name="birth_date" required tabindex="5">
                                        <?php for($i = 1; $i <= 31; $i++):?>
                                            <option value="<?=$i?>"> <?=$i?> </option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                   <select class="form-control" name="birth_year" required tabindex="6">
                                    <?php for($now = date("Y"),$counter = 0; $now >= 1940; $now--):?>
                                        <?php $counter++;?>
                                        <?php $selected = ($counter == 1)? "selected" :"";?>
                                        <option value="<?=$now?>" <?=$selected?>> <?=$now?> </option>
                                    <?php endfor;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <label class="lead"><strong>Permanent Address</strong></label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required"><small>Street / Barangay</small></label>
                            <input type="text" name="street" class="form-control" placeholder="" value="" tabindex="7">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label required"><small>Municipality/Province</small> <small class="text-muted">(click to set location)</small></label>
                            <input type="text" class="form-control" name="permanent-address" value="" tabindex="8" onkeydown="return false;">
                            <input type="hidden" name="region_id" value="">
                            <input type="hidden" name="city_id" value="">
                        </div>
                    </div>
                </div>
                <br>
                <h4 class="registration-title">Log In & Contact Details</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Email</small></label>
                           
                            <input type="email" id="email" name="email" class="form-control" value="" placeholder="example@yahoo.com" tabindex="9">
                            
                        </div>
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Password</small></label>
                        
                                <input type="password" id="password" name="password" value="" class="form-control" placeholder="Password" tabindex="11">
                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Phone Number</small></label>
                           
                               <input type="text" id="phone" name="phonenumber" value="" placeholder="0935-312-3412" class="form-control" data-inputmask='"mask": "0999-999-9999"' data-mask tabindex="10">
                           
                       </div>
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Confirm Password</small></label>
                            <input type="password" name="confirmPassword" value="" class="form-control" placeholder="Re-type password" tabindex="12">
                        </div>
                    </div>
                </div>
                <br>
                <h4 class="registration-title">Job Interest</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required" for="email"><small>Educational Attainment</small></label>
                            <select class="form-control" tabindex="13" name="educAttainment">
                                <option>  </option>
                                <option value="Highschool Graduate"> High School Graduate</option>
                                <option value="Vocational Course" > Vocational Course</option>
                                <option value="College Level" > College Level</option>
                                <option value="College Graduate" > College Graduate</option>
                                <option value="Master Degree" > Master's Degree</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required" for="email"><small>Work Experience</small></label>
                            <select class="form-control" tabindex="14" name="workExp">
                                <option value="Fresh Graduate"> Fresh Graduate</option>
                                <option value="Below 1 year"> Below 1 year</option>
                                <option value="1 - 2 years"> 1 - 2 years</option>
                                <option value="3 - 5 years"> 3 - 5 years</option>
                                <option value="More than 5 years"> More than 5 years</option>
                                <option value="More than 10 years"> More than 10 years</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email"><small>Job Category</small></label>
                    <select class="form-control" tabindex="15" name="jobCategory">
                        <option>  </option>
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="email"><small>Job Role</small></label>
                    <select class="form-control select2 jobrole" id="job-role" multiple="multiple" tabindex="16" name="jobRole[]">
                        <option>  </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email"><small>Where did you hear about us?</small></label>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="list-inline">
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="facebook" type="radio" class="custom-control-input" tabindex="17">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-facebook-official"></i> Facebook</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="twitter" type="radio" class="custom-control-input" tabindex="18">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-twitter-square"></i> Twitter</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="linkedIn" type="radio" class="custom-control-input" tabindex="19">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-linkedin"></i> Link In</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-inline">
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="websearch" type="radio" class="custom-control-input" tabindex="20">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-search"></i> Web Search</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="magazine" type="radio" class="custom-control-input" tabindex="21">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-file-image-o"></i> Magazine Ads</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs"  value="newspaper" type="radio" class="custom-control-input" tabindex="22">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-newspaper-o"></i> Newspaper</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-inline">
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs"  value="friends" type="radio" class="custom-control-input" tabindex="23">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-users"></i> Friends</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="others" type="radio" class="custom-control-input" tabindex="24">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-external-link"></i> Others</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <br>
                <h4 class="registration-title">Terms and Condition</h4>
                <hr>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                    <input type="checkbox" name="termsCondition" class="custom-control-input" checked tabindex="25" value="1">
                    <span class="custom-control-indicator"></span>
                    <span class="terms-condition"></span>
                    <span class="custom-control-description">I agree to JobFair-Online.net Terms <?php echo form_error('termsCondition','<div style="color:red;"><i class="fa fa-exclamation-circle"> </i>','</div>');?></span>
                    </label>
                </div> 
                <br>
                <div class="form-group">
                    <label class="custom-control custom-radio">
                    <input id="radio3" name="infoCondition" type="radio" class="custom-control-input" tabindex="26" value="1" checked>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Allow Jobfair-online.net to make my name, age, gender, civil status, educational attainment and contact number available to all registered Employers and make my profile available to employers I applied to.</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="custom-control custom-radio">
                    <input id="radio3" name="infoCondition" type="radio" class="custom-control-input" tabindex="27" value="0">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Allow Jobfair-online.net to hide my name, age, gender, civil status, educational attainment and contact number to all registered employers and make my full profile available only to employers I applied to.</span>
                    </label>
                </div>
                <div class="form-group col-md-6 offset-md-3">
                    <input type="submit" id="register-applicant" name="register-applicant" value="REGISTER" class="form-control btn btn-info btn-materialize" tabindex="28">
                </div>
            </div>      
        </div>
        <?php echo form_close();?>
<!-- </form>  -->
    </section>
</div>
<?php $this->load->view('template/modal')?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/registration.js')?>"></script>