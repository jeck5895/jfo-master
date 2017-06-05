<?php $this->load->view('employer/v_employer_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="form-box-max">
                <h5> CREATE JOB POST </h5>
                <hr>
                <div class="box box-widget">
					<div class="box-header with-border">
						<h6>JOB SPECIFICATION</h6>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-8 offset-md-2">
								<form id="create-job-post-form" action="" method="">
									<div class="form-group">
										<label for="email" class="control-label required"><small>Job Title</small></label>
										<input type="text" name="jobTitle" class="form-control" placeholder="e.g Accounting Staff" required tabindex="1" autofocus>
									</div>
									<div class="form-group">
										<label class="control-label required"><small>Job Location</small> <small class="text-muted">(click to set location)</small></label>
										<input type="text" class="form-control" data-region="0" data-city="0" id="permanentAddress" name="permanentAddress" value="" tabindex="2" onkeydown="return false;" >
									</div>
									<div class="form-group">
										<label for="email" class="control-label required"><small>Job Category</small></label>
										<select class="form-control" tabindex="3" id="jobCategory" name="jobCategory" required>
                                                    <option>  </option>

                                                </select>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label for="email"><small>Gender</small></label>
													<select class="form-control" name="gender" tabindex="10">
														<option value="Not Required" selected>Not Required</option>
														<option value="Male">Male</option>
														<option value="Female">Female</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6">		
												<div class="form-group">
													<label for="email"><small>Civil Status</small></label>
													<select class="form-control" name="civilStatus" tabindex="10">
														<option value="Not Required" selected>Not Required</option>
														<option value="Single">Single</option>
														<option value="Married">Married</option>
													</select>
												</div>	
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="email" class="control-label required"><small>Salary</small> <small class="text-muted">(per month)</small></label>
												<div class="row">
													<div class="col-sm-5" >
														<div class="input-group">
															<input type="number" name="salary1" class="form-control" tabindex="5" placeholder="11000">
															<div class="input-group-addon"><small>PHP</small></div>
														</div>	
													</div>
													<div class="col-sm-2" style="width: 13px; padding: 0;">
														<label for="email">to</label>
													</div>
													<div class="col-sm-5">
														<div class="input-group">
															<input type="number" name="salary2" class="form-control" tabindex="6" placeholder="12000">
															<div class="input-group-addon"><small>PHP</small></div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="custom-control custom-checkbox" id="displaySalary" data-toggle="popover" data-placement="left" data-html="true" title="<h6><i class='fa fa-lightbulb-o'></i> &nbspSuggestion</h6>" data-content="Displaying the salary might attract more applicants.">
														<input type="checkbox" name="displaySalary" class="custom-control-input" checked tabindex="7" value="1">
														<span class="custom-control-indicator"></span>
														<span class="terms-condition"></span>
														<span class="custom-control-description"><small>Show salary in public</small></span>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email"><small>No. of Job Vancancies</small></label>
												<input type="text" name="jobVacancy" class="form-control" value="1" tabindex="8" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email"><small>Job Post Duration</small></label>												<!-- <input type="date" name="jobExpiration" class="form-control" required readonly> -->
												<select name="jobDuration" id="jobDuration" class="form-control" tabindex="9">
													<option value="2" selected>2 Months</option>
													<option value="3">3 Months</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email"><small>Educational Attainment</small></label>
												<select class="form-control" name="educationalAttainment" tabindex="10">
													<option></option>
													<option value="High School Graduate">High School Graduate</option>
													<option value="College Graduate">College Graduate</option>
													<option value="College Level">College Level</option>
													<option value="Masters Degree">Masters Degree</option>
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email"><small>Preffered Course</small></label>
												<input type="text" name="add_requirements" class="form-control" tabindex="11">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="email" id="jobdesc-label" class="control-label required"><small>Job Qualification & Description</small></label>
										<textarea class="form-control ignore" id="jobDescription" name="jobDescription" minlength="150" rows="10" tabindex="12" required></textarea>
										<small class="text-muted">Minimum of 150 characters</small> 
										<small class="pull-right"><label id="char-label">Total:&nbsp</label><label id="char-count">0</label></small>
									</div>

									<div class="form-group">
										<button class="btn btn-success btn-materialize" id="submit" name="submit" tabindex="13">
											Save Post
										</button>
										
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

<?php $this->load->view('template/modal')?>     
<script type="text/javascript" src="<?=base_url('assets/js/emp_job_post.js')?>"></script> 
<script type="text/javascript" src="<?=base_url('assets/js/plugins/ckeditor/ckeditor.js')?>"></script> 
 