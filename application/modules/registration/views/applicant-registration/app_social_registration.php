<div class="container">
	<section class="content margin-header-top-65">
    	<div class="row">
     		<div class="col-md-8 offset-md-2">
     			<form action="<?php echo base_url('Registration/social_registration')?>" method="POST">
     				<div class="alert alert-info" role="alert">
     					<h1 class="lead">Well done!</h1>
     					<p><small>We just need you to fill up this form in order for you to receive the most relative job oppoturnities</small></p>
     				</div>
     				<h1 class="registration-title">PERSONAL INFORMATION</h1>
     				<br>
     				<div class="row">
     					<div class="col-md-6">
     						<div class="form-group">
     							<?php echo form_error('firstname','<div style="color:red; ">',"</div>");?>
     							<label class="control-label required"><small>First Name</small></label>
     							<input type="text" name="firstname" class="form-control" placeholder="Firstname" tabindex="1" value="<?php echo $this->session->userdata('social_profile')['first_name']?>">
     						</div>
     					</div>
     					<div class="col-md-6">
	     					<div class="form-group">
	     						<label class="control-label required"><small>Last Name</small></label>
	     						<?php echo form_error('lastname','<div style="color:red; font-size: 80%;">',"</div>");?>
	     						<input type="text" name="lastname" class="form-control" placeholder="Lastname" tabindex="3" value="<?php echo $this->session->userdata('social_profile')['last_name']?>">
	     					</div>
	     				</div>
	     				<div class="col-md-6">
	     					<div class="form-group" style="margin-bottom:0.5rem;">
	     						<label for="email" class="control-label required"><small>Email</small></label>
	     						<?php echo form_error('email','<div style="color:red; font-size: 80%;">',"</div>");?>
	     						<div class="input-group">
	     							<span class="input-group-addon">@</span>
	     							<input type="email" id="email" name="email" class="form-control" placeholder="example@yahoo.com" tabindex="15" value="<?php echo $this->session->userdata('social_profile')['email']?>">
	     						</div>
	     					</div>
	     				</div>
	     				<div class="col-md-6">
	     					<div class="form-group" style="margin-bottom:0.5rem;">
	     						<label for="email" class="control-label required"><small>Phone number</small></label>
	     						<?php echo form_error('phonenumber','<div style="color:red; font-size: 80%;">',"</div>");?>
	     						<div class="input-group">
	     							<span class="input-group-addon"><i class="fa fa-phone"></i></span>
	     							<input type="text" id="phone" name="phonenumber" value="<?php echo set_value('phonenumber'); ?>" placeholder="09x-xxx-xxxxx" class="form-control" data-inputmask='"mask": "09-9999-99999"' data-mask tabindex="16">
	     						</div>
	     					</div>
	     				</div>	
     				</div>
     				<hr style="width: 50%;">
     				<h1 class="registration-title">Job Interest</h1>
     				<br>
     				<div class="row">
     					<div class="col-md-6">
     						<div class="form-group">
     							<label class="control-label required" for="email"><small>Educational Attainment</small></label>
     							<?php echo form_error('educAttainment','<div style="color:red; font-size: 80%;">',"</div>");?>
     							<select class="form-control" tabindex="19" name="educAttainment">
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
     							<select class="form-control" tabindex="20" name="workExp">
     								<option> </option>
     								<option value="0" <?php echo set_select('workExp', '0'); ?>> Fresh Graduate</option>
     								<option value="1" <?php echo set_select('workExp', '1'); ?>> Below 1 year</option>
     								<option value="2" <?php echo set_select('workExp', '2'); ?>> 1 - 2 years</option>
     								<option value="3" <?php echo set_select('workExp', '3'); ?>> 3 - 5 years</option>
     								<option value="4" <?php echo set_select('workExp', '4'); ?>> More than 5 years</option>
     							</select>
     						</div>
     					</div>
     					<div class="col-md-6">
     						<div class="form-group">
     							<label for="email"><small>Job Category</small></label>
     							<select class="form-control" tabindex="21" name="jobCategory">
     								<option>  </option>
     								<?php foreach($job_categories as $category){ ?>
     								<option value="<?php echo $category['id']?>" <?php echo set_select('jobCategory', $category['id']);?>>  <?php echo $category['category_name']?></option>
     								<?php } ?>
     							</select>
     						</div>
     					</div>
     					<div class="col-md-6">
     						<div class="form-group">
     							<label for="email"><small>Job Role</small></label>
     							<select class="form-control select2 jobrole" id="job-role" multiple="multiple" tabindex="22" name="jobRole[]">
     								<option>  </option>
     							</select>
     						</div>
     					</div>
     				</div>
     				<hr style="width: 50%;">
     				<h1 class="registration-title">Terms and Condition</h1>
     				<br>
     				<div class="form-group">
     					<label class="custom-control custom-checkbox">
     						<input type="checkbox" name="termsCondition" class="custom-control-input" checked tabindex="32" value="1">
     						<span class="custom-control-indicator"></span>
     						<span class="terms-condition"></span>
     						<span class="custom-control-description">I agree to JobFair-Online.net,Inc. Terms <?php echo form_error('termsCondition','<div style="color:red;"><i class="fa fa-exclamation-circle"> </i>','</div>');?></span>
     					</label>
     				</div>
     				<div class="form-group col-md-6 offset-md-3">
     					<?php echo form_error('g-recaptcha-response','<div style="color:red;"><i class="fa fa-exclamation-circle"> </i>','</div>');?>
     					<div class="g-recaptcha" data-sitekey="6LdeGAoUAAAAACIOxGcK8ggjMqTpWTdNN9FY0-7v"></div>
     				</div>
     				<div class="form-group">
     					<label class="custom-control custom-radio">
     						<input id="radio3" name="infoCondition" type="radio" class="custom-control-input" tabindex="33" value="1" checked>
     						<span class="custom-control-indicator"></span>
     						<span class="custom-control-description">Allow Jobfair-online.net to make my name, age, gender, civil status, educational attainment and contact number available to all registered Employers and make my profile available to employers I applied to.</span>
     					</label>
     				</div>
     				<div class="form-group">
     					<label class="custom-control custom-radio">
     						<input id="radio3" name="infoCondition" type="radio" class="custom-control-input" tabindex="34" value="1">
     						<span class="custom-control-indicator"></span>
     						<span class="custom-control-description">Allow Jobfair-online.net to hide my name, age, gender, civil status, educational attainment and contact number to all registered employers and make my full profile available only to employers I applied to.</span>
     					</label>
     				</div>
     				<div class="form-group col-md-6 offset-md-3">
     					<input type="submit" name="register-applicant" value="REGISTER" class="form-control btn btn-primary" tabindex="35">
     				</div> 
     			</form>
     		</div>
     	</div>
    </section>
</div>     		

