<!-- Modal Dialog -->
<div id="whistoryModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog"  >
        <div class="modal-content">
            <div class="modal-header">
            <h5>Work History Details </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <form id="add-work-history-form" method="" action="">
                    
                    <div class="form-group" style="margin-bottom:0.5rem;">
                        <label class="control-label" required for="email"><small>Company Name</small></label>
                        <input type="text" id="compName" name="company_name" class="form-control" placeholder="Enter the name of company" tabindex="41" required>
                        <input type="hidden" name="work_id">
                    </div>
                    <div class="form-group" style="margin-bottom:0.5rem;">
                        <label class="control-label" required for="email"><small>Position</small></label>
                        <input type="text" id="position" name="passed_position" class="form-control" placeholder="Enter your position" tabindex="42" required>
                    </div>
                     <div class="form-group" style="margin-bottom:0.5rem;">
                        <label class="control-label" required for="email"><small>Work Description</small></label>
                        <textarea class="form-control" name="work_description" placeholder="Description of your previous work" cols="3" tabindex="43"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" required for="email"><small>Date Started</small></label>
                                <input class="form-control" id="start_date" name="start_date" type="date" data-date-format="mm/dd/yyyy" tabindex="45" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" required for="email"><small>Date Ended</small></label>
                                <input class="form-control" name="end_date" type="date" data-date-format="mm/dd/yyyy" tabindex="45" required>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="addWorkHistory" class="btn btn-success btn-materialize">SAVE</button>
                <button type="button" class="btn btn-danger btn-materialize" data-dismiss="modal" >Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL DIALOG -->

<?php $this->load->view('applicant/v_applicant_sidebar')?>
<div class="content-wrapper">
    <section class="content-header" style="">

    </section>  
    <section class="content">
        <div class="row">
            <div class="form-box">
                <h5> EDIT PROFILE </h5>
                <hr>
               

                <ul class="nav nav-tabs applicant-edit-tab nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general-info-tab" role="tab">General</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#job-tab" role="tab">Job Interest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#education-tab" role="tab">Education</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#work-history-tab" role="tab">Work History</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active animated fadeIn" id="general-info-tab" role="tabpanel">
                        <div class="tab1-content">

                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <h6> PERSONAL INFORMATION</h6>
                                </div>
                                <div class="box-body">
                                    <form id="form-general-info">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label class="form-control-label"><small>First name</small></label>
                                                <input type="text" class="form-control" name="firstname" required autofocus>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="form-control-label"><small>Middle name</small></label>
                                                <input type="textl" class="form-control" name="middlename" required>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="form-control-label"><small>Last name</small></label>
                                                <input type="text" class="form-control" name="lastname" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="form-control-label"><small>Birthdate</small></label>
                                                <input type="date" class="form-control" name="birthdate" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-control-label"><small>Religion</small></label>
                                                <select class="form-control" tabindex="7" name="religion" required>
                                                    <option> </option>
                                                    <?php foreach($religions as $religion): ?>
                                                        <option value="<?php echo $religion['religion'];?>"> <?php echo $religion['religion'];?> </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="form-control-label"><small>Civil Status</small></label>
                                                <select class="form-control" tabindex="9" name="civilStatus" required>
                                                    <option> </option>
                                                    <option value="single"> Single</option>
                                                    <option value="married" > Married</option>
                                                    <option value="separated" > Seperated</option>
                                                    <option value="divorced"> Divorced</option>
                                                    <option value="widowed"> Widowed</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label class="form-control-label"><small>Gender</small></label>
                                                <select tabindex="8" class="form-control" name="gender" required>

                                                    <option> </option>
                                                    <option value="male" selected> Male</option>
                                                    <option value="female"> Female</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label required"><small>Street / Barangay</small></label>
                                                    <input type="text" name="street" class="form-control" placeholder="" value="" tabindex="8" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label class="control-label required"><small>Municipality/Province</small> <small class="text-muted">(click to set location)</small></label>
                                                    <input type="text" class="form-control" name="permanent-address" value="" tabindex="9" onkeydown="return false;">
                                                    <input type="hidden" name="region_id" value="">
                                                    <input type="hidden" name="city_id" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-3 offset-sm-4">
                                                <button id="btn-save-gen-info" type="submit" class="btn btn-info btn-materialize">Save Changes</button>
                                            </div>
                                        </div>  

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

            

                    <div class="tab-pane animated fadeIn" id="job-tab" role="tabpanel">
                        <div class="tab3-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <h6> JOB INTEREST</h6>
                                </div>
                                <div class="box-body">
                                    <form id="form-job-interest">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="form-control-label"><small>Work Experience</small></label>
                                                <select class="form-control" tabindex="29" name="work-experience" required>
                                                    <option value="Fresh Graduate"> Fresh Graduate</option>
                                                    <option value="Below 1 year"> Below 1 year</option>
                                                    <option value="1 - 2 years" > 1 - 2 years</option>
                                                    <option value="3 - 5 years" > 3 - 5 years</option>
                                                    <option value="More than 5 years" > More than 5 years</option>
                                                    <option value="More than 10 years"> More than 10 years</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-control-label"><small>Job Category</small></label>
                                                <select class="form-control" tabindex="16" name="jobCategory" required>
                                                    <option>  </option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for="email"><small>Job Role</small></label>
                                                <select class="form-control select2 jobrole" id="job-role" multiple="multiple" tabindex="17" name="jobRole[]">
                                                    <option>  </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-3 offset-sm-4">
                                                <button id="btn-save-job" type="submit" class="btn btn-info btn-materialize">Save Changes</button>
                                            </div>
                                        </div> 
                                    </form>
                                </div>
                            </div>

                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <h6> RESUME</h6>
                                    <div class="box-tools" id="resume-box-tools" style="display: none;">
                                        <a class="btn btn-sm btn-secondary btn-materialize btn-materialize-sm" href="https://docs.google.com/viewerng/viewer?url=http://jobfair-online.net/download?applicant_id=VkZkd2JtVnJNVlZoZWpBOQ==" class="btn btn-box-tool" target="blank" title="view" data-toggle = "tooltip">
                                         View
                                        </a>
                                        <a class="btn btn-sm btn-secondary btn-materialize btn-materialize-sm" data-toggle="tooltip" title="Download" href="http://localhost/jobfair-online-net/assets/uploads/resume/JFO-RedesignTimeline.docx">
                                        Download</a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <small><p class="text-muted">Accepted File: DOCX/PDF</p></small>
                                    <div class="row">
                                        <div class="form-resume-box">
                                                <div class="resume-file-name-box">
                                                    <label id="resume-file-name"></label>&emsp;<small>
                                                    <a id="btn-remove-resume" data-action="remove" style="color:#005999; cursor: pointer; text-decoration:underline; display: none;">Remove</a></small>
                                                </div>                                            
                                                <div class="form-group">

                                                    <input type="file" name="userfile_resume" class="filestyle" data-input="true" data-buttonText="Choose File" data-buttonName="btn btn-secondary " accept="application/pdf,application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">

                                                    <label class="text-danger"><small id="form-error-text"></small></label>
                                                    <div id="btn-resume-box" >

                                                        <input type="submit" id="btn-save-resume" data-action="upload" value="Save File" class="btn btn-info btn-materialize" disabled>

                                                    </div>
                                                </div>
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane animated fadeIn" id="education-tab" role="tabpanel">
                        <div class="tab4-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <h6> EDUCATIONAL BACKGROUND</h6>
                                </div>
                                <div class="box-body">
                                    
                                    <div class="col-container">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label class="form-control-label"><small>Educational Attainment</small></label>
                                                <select class="form-control" tabindex="" name="educ-attainment" required>
                                                    <option value="Highschool Graduate"> High School Graduate</option>
                                                    <option value="Vocational Course"> Vocational Course</option>
                                                    <option value="College Level" > College Level</option>
                                                    <option value="College Graduate"> College Graduate</option>
                                                    <option value="Master Degree" > Master's Degree</option>
                                                </select>
                                            </div>
                                        </div>
                                        <form id="form-education">    

                                            <div class="row">
                                                <div class="form-group col-sm-12 degree-container">
                                                    <label class="form-control-label"><small>Degree</small></label>
                                                    <input type="text" class="form-control" name="course" placeholder="Course / Degree pursue">
                                                </div>

                                                <div class="form-group col-sm-12 school-container">
                                                    <label class="form-control-label"><small>School/Institution</small></label>
                                                    <input type="text" class="form-control" name="school" placeholder="School name" required>
                                                </div>
                                            </div>

                                            <div class="row year-container">
                                                <div class="form-group col-sm-6">
                                                    <label class="form-control-label"><small>Year Entered</small></label>
                                                    <input class="form-control" type="number" maxlength="4" minlength="4" tabindex="" name="year_entered" placeholder="2000">

                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-control-label"><small>Year Graduated</small></label>
                                                    <input name="year_graduated" type="number" maxlength="4" minlength="4" placeholder="2004" class="form-control">
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="form-group col-sm-3 offset-sm-4">
                                                    <button id="btn-save-ed" type="submit" class="btn btn-info btn-materialize">Save Changes</button>
                                                </div>
                                            </div> 
                                        </form>
                                    </div>

                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="tab-pane animated " id="work-history-tab" role="tabpanel">
                        <div class="tab5-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <h6>WORK HISTORY</h6>
                                    <!--  <small class="text-muted text-danger">(3 most recent will be displayed)</small> -->
                                    <div class="box-tools">
                                        <a class="btn btn-info btn-sm btn-materialize-sm" id="btn-add-wh" data-toggle="modal" href="#whistoryModal" data-action="add">Add New</a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div id="work-history-container"></div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>

            </div>  
           
            <?php $this->load->view('template/v_ads_box')?>    
        </div>
    </section>
</div>

<script type="text/javascript" src="<?=base_url('assets/js/applicant/profilemod.js')?>"></script>
<?= $this->load->view('template/modal')?>