<div class="container">
    <section class="content ">
        <form id="employer-registration-form" enctype="multipart/form-data">
        <?=form_hidden('token',$token) ?>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h4 class="registration-title">COMPANY INFORMATION</h4>  
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="control-label required"><small>Company Name</small></label>
                            <input type="text" name="company_name" class="form-control" value="<?php echo set_value('company_name'); ?>" placeholder="Company Name" tabindex="1" required autofocus>
                            <?php echo form_error('company_name','<div style="color:red; font-size: 80%;">',"</div>");?>
                        </div>
                        <div class="form-group"> 
                            <label for="email" class="control-label required"><small>Company Address</small></label>
                            <input type="text" name="street_address" class="form-control" value="<?php echo set_value('street_address'); ?>" placeholder="Street Address" tabindex="3" required>
                            <?php echo form_error('street_address','<div style="color:red; font-size: 80%;">',"</div>");?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="control-label required"><small>Company Industry</small></label>
                            <select class="form-control" tabindex="2" name="company_industry" required>
                                <option> </option>
                            <?php foreach($industries as $industry):?>
                                <option value="<?=$industry->id?>" <?php echo set_select('company_industry', $industry->id); ?>><?=$industry->industry_name;?></option>
                            <?php endforeach;?>
                            </select>
                            <?php echo form_error('company_industry','<div style="color:red; font-size: 80%;">',"</div>");?>
                        </div>

                        <div class="form-group">
                            <label class="control-label required"><small></small> <small class="text-muted">(click to set location)</small></label>
                            <?php echo form_error('permanent_address','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <input type="text" class="form-control" name="permanent-address" value="<?php echo set_value('permanent-address'); ?>" tabindex="4" onkeydown="return false;" placeholder="City Address" required>
                            <?php echo form_error('permanent_address','<div style="color:red; font-size: 80%;">',"</div>");?>
                            <input type="hidden" name="region_id" value="">
                            <input type="hidden" name="city_id" value="">
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="email" class="control-label required"><small>Company Logo</small></label> 
                                    <input type="file" id="input_file" name="userfile" data-buttonText="Choose Image" class="filestyle"  data-buttonName="btn-secondary" data-input="true" accept="image/*" style="">
                                    <small class="text-muted">(Image dimensions 150 x 150 Size not exceed 1 MB)</small> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="company-logo-container">
                                    <img id="company-logo-preview" src="" alt="" style="width: 100%; height: 100%;"/>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" ">
                            <label for="email" class="control-label required"><small>Company Description</small></label>
                            <textarea name="company_description" class="form-control" placeholder="Describe something about your company" rows="5" tabindex="5" required><?php echo set_value('company_description');?></textarea>
                            <?php echo form_error('company_description','<div style="color:red; font-size: 80%;">',"</div>");?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h4 class="registration-title">CONTACT PERSON</h4>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="control-label required"><small>First Name</small></label>
                            <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" class="form-control" placeholder="" tabindex="6" required>
                            <?php echo form_error('first_name','<div style="color:red; font-size: 80%;">',"</div>");?>
                        </div>
                        <div class="form-group">
                            <label for="email"  class="control-label required"><small>Position</small></label>
                            <input type="text" name="position" value="" class="form-control" placeholder="Position" tabindex="9" required>  
                            <?php echo form_error('position','<div style="color:red; font-size: 80%;">',"</div>");?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="control-label required"><small>Middle Name</small></label>
                            <input type="text" name="middlename" value="" class="form-control" placeholder="" tabindex="7">
                            <?php echo form_error('middlename','<div style="color:red; font-size: 80%;">',"</div>");?>
                        </div>
                        <div class="form-group">
                            <label for="email"  class="control-label required"><small>Department</small></label>
                            <input type="text" name="department" class="form-control" value="" placeholder="Department" tabindex="10" required>  
                        
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="control-label required">Last Name</label>
                            <input type="text" name="lastname" class="form-control" placeholder="" value="" tabindex="8" required>
                            
                        </div>
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="landline"  class="control-label"><small>Landline</small></label>
                            <div class="row">
                                <div class="col-sm-5" style="padding-right: 2px;">
                                    <input type="text" name="area-code" placeholder="Area-code" value="" tabindex="11" class="form-control">
                                </div>
                                <div class="col-sm-7" style="padding-left: 2px;">
                                    <input type="text" id="landline" name="landline" value="<?php echo set_value('landline'); ?>" placeholder="411-11-11" class="form-control" data-inputmask='"mask": "999-99-99"' data-mask tabindex="12">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <h4 class="registration-title">LOG IN CREDENTIALS</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email" class="control-label required"><small>Email</small></label>
                            
                                <input type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" placeholder="example@yahoo.com" tabindex="13" required>
                                
                          
                        </div>
                        <div class="form-group" style="margin-bottom:0.5rem;">
                                
                                <label for="email" class="control-label required"><small>Password</small></label>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Password" tabindex="15" required>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="phone"  class="control-label required"><small>Phone number</small></label>
                            
                                <input type="text" id="phone" value="<?php echo set_value('phonenumber'); ?>" name="phonenumber" placeholder="09-353-1234" class="form-control" data-inputmask='"mask": "0999-999-9999"' data-mask tabindex="14" required>
                                
                           
                        </div>
                        <div class="form-group" style="margin-bottom:0.5rem;">
                            <label for="email"  class="control-label required"><small>Re-type Password</small></label>
                            <input name="confirm_password" type="password" class="form-control" placeholder="Re-type password" tabindex="16" required>
                            
                        </div>           
                    </div>
                </div>
            </div>
        </div>
        <br>

        <br>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h4 class="registration-title">Terms and Condition</h4>
                <hr>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" id="terms-condition" class="custom-control-input" checked tabindex="17">
                        <span class="custom-control-indicator"></span>
                        <span class="terms-condition"></span>
                        <span class="custom-control-description">I agree to <a href="#termsAgreement" data-toggle="collapse" aria-expanded="false">JobFair-Online.net,Inc. Terms</a></span>
                    </label>
                </div>
                <div class="collapse" id="termsAgreement">
                    <div class="card card-block">
                        <p>JobFair-Online do not charge any fee or amount from job applicants or employers for their utilization of the facilities provided in this website. The maintainers of the site reserve the right to refuse or limit access to the site for any reason not contrary to law.</p>

                        <p>This site is intended for purely legitimate purposes for the amelioration of the unemployment situation in the country and the need to bring together the job requirements of potential employers and the job needs of the labor market in the Philippines. This site is therefore absolutely against all illegal purposes and activities such as violation of human rights and human trafficking which include, but are not limited to, labor trafficking and sex trafficking. Labor trafficking includes the recruitment, harboring, transporting, providing, or obtaining of people for forced labor, white slavery, violations of minimum wage and wage payment laws, health and safety standards, and established human rights. Violators of these laws and rights will be prosecuted to the fullest extent of the law.</p>

                        <p>JobFair-Online.Net as maintainers of this site have adopted, and reserve the right to employ, all legitimate methods to prevent misuse of the site by individuals, firms and entities, ensure authenticity and legitimacy of those using the site; and, further, reserve the right to refuse, remove and delete any or all forms of materials/statements, data and advertisements posted or inserted in the site and found to be offensive, immoral or fraudulently making misrepresentations of articles of trade, individuals, corporations or any entity or otherwise in violation of the above policies.</p>

                        <p>JobFair-Online.Net shall not be liable in case of site hacking but shall exercise due diligence to ensure security of the data in the site and its proper maintenance. These entities are not in any way liable for any statements or data provided by applicants or employers in connection with their utilization of this site. nor be held liable for any damage or harm, whether real or not, suffered by those utilizing this site.</p>
                    </div>    
                </div>
                <div class="" >
                    <div class="form-group col-md-6 offset-md-3" style="padding-left: 1.5rem;">
                        <?php echo form_error('g-recaptcha-response','<div style="color:red;"><i class="fa fa-exclamation-circle"> </i>','</div>');?>
                        <div class="g-recaptcha" data-sitekey="6LdeGAoUAAAAACIOxGcK8ggjMqTpWTdNN9FY0-7v"></div>
                    </div>
                </div>
                <div class="form-group col-md-6 offset-md-3">
                    <input type="submit" id="register-employer" name="register-employer" value="REGISTER" class="form-control btn btn-info btn-materialize" tabindex="18">
                </div>
            </div>
        </div>    
    </form>
    <?php //form_close();?>
    </section>
</div>
<?php $this->load->view('template/modal')?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/registration.js')?>"></script>
