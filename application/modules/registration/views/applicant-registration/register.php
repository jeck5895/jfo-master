<div class="container">
    <section class="content margin-header-top-65">
        <div class="row">
            <div class="col-md-8 offset-md-2">
            <?php echo form_open_multipart('registration/applicant');?>
                <?=form_hidden('token',$token) ?>
                <h1 class="registration-title">Personal Information</h1>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required"><small>First Name</small></label>
                            <?php echo form_error('firstname','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <input type="text" name="firstname" class="form-control" value="<?php echo set_value('firstname'); ?>" placeholder="First Name" tabindex="1" autofocus>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required"><small>Middle Name</small></label>
                            <?php echo form_error('middlename','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <input type="text" name="middlename" class="form-control" value="<?php echo set_value('middlename'); ?>" placeholder="Middle Name" tabindex="2">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required"><small>Last Name</small></label>
                            <?php echo form_error('lastname','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <input type="text" name="lastname" class="form-control" value="<?php echo set_value('lastname'); ?>" placeholder="Last Name" tabindex="3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">     
                        <div class="form-group">
                              <label class="control-label required"><small>Civil Status</small></label>
                              <?php echo form_error('civilStatus','<div style="color:red; font-size: 80%;">',"</div>");?>
                              <select class="form-control" tabindex="4" name="civilStatus">
                                <option> </option>
                                <option value="single" <?php echo set_select('civilStatus', 'single'); ?>> Single</option>
                                <option value="married" <?php echo set_select('civilStatus', 'married'); ?>> Married</option>
                                <option value="separated" <?php echo set_select('civilStatus', 'separated'); ?>> Seperated</option>
                                <option value="divorced" <?php echo set_select('civilStatus', 'divorced'); ?>> Divorced</option>
                                <option value="widowed" <?php echo set_select('civilStatus', 'widowed'); ?>> Widowed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label required"><small>Gender</small></label>
                            <?php echo form_error('gender','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <select tabindex="6" class="form-control" name="gender">
                                <option> </option>
                                <option value="male" <?php echo  set_select('gender', 'male'); ?>> Male</option>
                                <option value="female" <?php echo  set_select('gender', 'female');?>> Female</option>
                            </select>
                        </div>         
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required"><small>Birthdate</small></label>
                            <?php echo form_error('birthdate','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input tabindex="5" type="date" id="datepicker" placeholder="mm/dd/yyyy" name="birthdate" value="<?php echo set_value('birthdate'); ?>" class="form-control" data-inputmask='"alias": "date"' data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label required"><small>Religion</small></label>
                            <?php echo form_error('religion','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <select class="form-control" tabindex="7" name="religion">
                              <option> </option>
                              <?php
                              foreach($religions as $religion){
                                ?>
                                <option value="<?php echo $religion['religion'];?>" <?php echo set_select('religion', $religion['religion']); ?>> <?php echo $religion['religion'];?> </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <label class="lead"><strong>Permanent Address</strong></label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required"><small>Street</small></label>
                            <?php echo form_error('street','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <input type="text" name="street" class="form-control" placeholder="" value="<?php echo set_value('street'); ?>" tabindex="8">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label required"><small>Municipality/Province</small> <small class="text-muted">(click to set location)</small></label>
                            <?php echo form_error('permanent-address','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <input type="text" class="form-control" name="permanent-address" value="<?php echo set_value('permanent-address'); ?>" tabindex="9" onkeydown="return false;">
                            <input type="hidden" name="region_id" value="">
                            <input type="hidden" name="city_id" value="">
                        </div>
                    </div>
                </div>
                <br>
                <h1 class="registration-title">Log In & Contact Details</h1>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Email</small></label>
                            <?php echo form_error('email','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <div class="input-group">
                                <span class="input-group-addon">@</span>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="example@yahoo.com" tabindex="10">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Phone Number</small></label>
                            <?php echo form_error('phonenumber','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <div class="input-group">
                               <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                               <input type="text" id="phone" name="phonenumber" value="<?php echo set_value('phonenumber'); ?>" placeholder="0935-312-3412" class="form-control" data-inputmask='"mask": "0999-999-9999"' data-mask tabindex="12">
                           </div>
                       </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Password</small></label>
                            <?php echo form_error('password','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" placeholder="Password" tabindex="11">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Confirm Password</small></label>
                            <?php echo form_error('confirmPassword','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <input type="password" name="confirmPassword" value="<?php echo set_value('confirmPassword'); ?>" class="form-control" placeholder="Re-type password" tabindex="13">
                        </div>
                    </div>
                </div>
                <br>
                <h1 class="registration-title">Job Interest</h1>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required" for="email"><small>Educational Attainment</small></label>
                            <?php echo form_error('educAttainment','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <select class="form-control" tabindex="14" name="educAttainment">
                                <option>  </option>
                                <option value="Highschool Graduate" <?php echo set_select('educAttainment', 'Highschool Graduate'); ?>> High School Graduate</option>
                                <option value="Vocational Course" <?php echo set_select('educAttainment', 'Vocational Course'); ?>> Vocational Course</option>
                                <option value="College Level" <?php echo set_select('educAttainment', 'College Level'); ?>> College Level</option>
                                <option value="College Graduate" <?php echo set_select('educAttainment', 'College Graduate'); ?>> College Graduate</option>
                                <option value="Master Degree" <?php echo set_select('educAttainment', 'Master Degree'); ?>> Master's Degree</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required" for="email"><small>Work Experience</small></label>
                            <?php echo form_error('workExp','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <select class="form-control" tabindex="15" name="workExp">
                                <option> </option>
                                <option value="0" <?php echo set_select('workExp', '0'); ?>> Fresh Graduate</option>
                                <option value="1" <?php echo set_select('workExp', '1'); ?>> Below 1 year</option>
                                <option value="2" <?php echo set_select('workExp', '2'); ?>> 1 - 2 years</option>
                                <option value="3" <?php echo set_select('workExp', '3'); ?>> 3 - 5 years</option>
                                <option value="4" <?php echo set_select('workExp', '4'); ?>> More than 5 years</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email"><small>Job Category</small></label>
                    <select class="form-control" tabindex="16" name="jobCategory">
                        <option>  </option>
                        <?php foreach($job_categories as $category): ?>
                        <option value="<?php echo $category['id']?>" <?php echo set_select('jobCategory', $category['id']);?>>  <?php echo $category['category_name']?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email"><small>Job Role</small></label>
                    <select class="form-control select2 jobrole" id="job-role" multiple="multiple" tabindex="17" name="jobRole[]">
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
                                    <input id="radio3" name="hearAboutUs" value="facebook" type="radio" class="custom-control-input" tabindex="23">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-facebook-official"></i> Facebook</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="twitter" type="radio" class="custom-control-input" tabindex="24">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-twitter-square"></i> Twitter</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="linkedIn" type="radio" class="custom-control-input" tabindex="25">
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
                                    <input id="radio3" name="hearAboutUs" value="websearch" type="radio" class="custom-control-input" tabindex="26">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-search"></i> Web Search</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="magazine" type="radio" class="custom-control-input" tabindex="27">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-file-image-o"></i> Magazine Ads</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs"  value="newspaper" type="radio" class="custom-control-input" tabindex="28">
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
                                    <input id="radio3" name="hearAboutUs"  value="friends" type="radio" class="custom-control-input" tabindex="29">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-users"></i> Friends</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-control custom-radio">
                                    <input id="radio3" name="hearAboutUs" value="others" type="radio" class="custom-control-input" tabindex="30">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><i class="fa fa-external-link"></i> Others</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 ">
                        <?php if ($this->session->flashdata('resume_upload_error')): ?>
                        <div class="" style="color:red;">
                            <h4><i class="icon fa fa-exclamation-triangle"></i> Upload Error!</h4>
                            <?php echo $this->session->flashdata('resume_upload_error'); ?>
                        </div>
                        <?php endif ?>
                        <label for="email"><small>Upload Resume</small></label>
                        <br>
                        <input type="file" name="userfile" class="filestyle"  data-buttonName="btn-primary" data-input="true" data-iconName="fa fa-file-word-o" tabindex="18" accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    </div>
                </div>
                <br>
                <h1 class="registration-title">Terms and Condition</h1>
                <hr>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                    <input type="checkbox" name="termsCondition" class="custom-control-input" checked tabindex="19" value="1">
                    <span class="custom-control-indicator"></span>
                    <span class="terms-condition"></span>
                    <span class="custom-control-description">I agree to JobFair-Online.net Terms <?php echo form_error('termsCondition','<div style="color:red;"><i class="fa fa-exclamation-circle"> </i>','</div>');?></span>
                    </label>
                </div> 
                <div class="form-group col-md-6 offset-md-3">
                    <?php echo form_error('g-recaptcha-response','<div style="color:red;"><i class="fa fa-exclamation-circle"> </i>','</div>');?>
                    <div class="g-recaptcha" data-sitekey="6LdeGAoUAAAAACIOxGcK8ggjMqTpWTdNN9FY0-7v"></div>
                </div>
                <br>
                <div class="form-group">
                    <label class="custom-control custom-radio">
                    <input id="radio3" name="infoCondition" type="radio" class="custom-control-input" tabindex="20" value="1" checked>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Allow Jobfair-online.net to make my name, age, gender, civil status, educational attainment and contact number available to all registered Employers and make my profile available to employers I applied to.</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="custom-control custom-radio">
                    <input id="radio3" name="infoCondition" type="radio" class="custom-control-input" tabindex="21" value="1">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Allow Jobfair-online.net to hide my name, age, gender, civil status, educational attainment and contact number to all registered employers and make my full profile available only to employers I applied to.</span>
                    </label>
                </div>
                <div class="form-group col-md-6 offset-md-3">
                    <input type="submit" name="register-applicant" value="REGISTER" class="form-control btn btn-primary" tabindex="22">
                </div>
            </div>      
        </div>
        <?php echo form_close();?>
<!-- </form>  -->
    </section>
</div>
<?php $this->load->view('template/modal')?>