<div class="container-fluid">
    <section class="content-header" style="">
        
        <?php $this->load->view('v_admin_header');?>
    </section>

    <section class="content">
        
        <div class="row">

            <div class="col-lg-10 offset-lg-1" style=""> 
                <ul class="nav nav-tabs admin nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active minimize" data-toggle="tab" href="#admin-job-fair-list" role="tab"><h6>List of Job Fair &nbsp<span id="admin-review-badge" data-toggle="tooltip" title="" class="app badge">0</span></h6></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link minimize" data-toggle="tab" href="#admin-create-job-fair" role="tab"><h6>Create Job Fair &nbsp<i class="fa fa-file"></i></h6></a>
                    </li>
                </ul>
                <div class="tab-content tab-content-admin">

                    <div class="tab-pane active" id="admin-job-fair-list" role="tabpanel">     
                        
                        <div class="table-container">

                            <table class="table table-hover dt-responsive nowrap" id="admin-active-employers-table" style="width: 100%;">
                                <thead>
                                    <th class="no-sort"> No.</th>
                                    <th>Title</th>
                                    <th>Establishment</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>Options</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>    

                    </div>

                    <div class="tab-pane" id="admin-create-job-fair" role="tabpanel">
                        <div class="table-container">
                            <div class="col-md-10 offset-md-1">
                                <form id="create-job-fair-form" action="" method="">
                                    <div class="form-group">
                                        <label for="email" class="control-label required"><small>Job Fair Title</small></label>
                                        <input type="text" name="title" class="form-control" placeholder="" required tabindex="1">
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="control-label required"><small>Establishment</small></label>
                                        <input type="text" name="establishment" class="form-control" placeholder="" required tabindex="2">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">

                                                <label class="control-label required"><small>Street / Barangay</small></label>
                                                <input type="text" name="street" class="form-control" placeholder="" value="" tabindex="3">

                                            </div>
                                            <div class="col-md-8">

                                                <label class="control-label required"><small>Municipality/Province</small> <small class="text-muted">(click to set location)</small></label>
                                                <input type="text" class="form-control" name="permanent-address" value="" tabindex="4" onkeydown="return false;">
                                                <input type="hidden" name="region_id" value="">
                                                <input type="hidden" name="city_id" value="">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label required"><small>Duration</small></label>
                                                <input name="duration" class="form-control" placeholder="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="email" class="control-label required"><small>Start Time</small></label>
                                                <input type="time" name="start_time" class="form-control">

                                            </div>
                                            <div class="col-sm-4">
                                                <label for="email" class="control-label required"><small>End Time</small></label>
                                                <input type="time" name="end_time" class="form-control">
                                            </div>
                                        </div>                                        
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="control-label required"><small>Website</small></label>
                                        <input type="url" name="website" class="form-control">
                                    </div>

                                    <h4>Contact Person</h4>

                                    <div class="form-group">
                                        <label for="email" class="control-label required"><small>Full Name</small></label>

                                        <div class="row">
                                            <div class="col-sm-4 form-group">
                                                <input type="text" name="firstname" class="form-control" placeholder="First name" required tabindex="1" autofocus>
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <input type="text" name="middlename" class="form-control" placeholder="Middle name" required tabindex="2">
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <input type="text" name="lastname" class="form-control" placeholder="Last name" required tabindex="3">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-bottom:0.5rem;">
                                        <div class="row">
                                            <div class="col-sm-4">

                                                <label for="landline"  class="control-label"><small>Landline</small></label>
                                                <div class="row">
                                                    <div class="col-sm-5 form-group" style="">
                                                        <input type="text" name="area-code" placeholder="Area-code" value="" tabindex="11" class="form-control">
                                                    </div>
                                                    <div class="col-sm-7 form-group" style="">
                                                        <input type="text" id="landline" name="landline" value="<?php echo set_value('landline'); ?>" placeholder="411-11-11" class="form-control" data-inputmask='"mask": "999-99-99"' data-mask tabindex="12">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="email" class="control-label required"><small>Phone Number</small></label>

                                                <input type="text" id="phone" name="phonenumber" value="" placeholder="0935-312-3412" class="form-control" data-inputmask='"mask": "0999-999-9999"' data-mask tabindex="11">

                                            </div>

                                            <div class="col-sm-4">
                                                <label for="email" class="control-label required"><small>Email</small></label>
                                                <input type="email" id="email" name="email" class="form-control" value="" placeholder="example@yahoo.com" tabindex="10">
                                            </div>
                                        </div>                                        
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email" class="control-label required"><small>Upload Image</small></label> 
                                                    <input type="file" id="input_file" name="userfile" data-buttonText="Choose Image" class="filestyle"  data-buttonName="btn-secondary" data-input="true" data-iconName="fa fa-image" accept="image/*" style="">
                                                    <small class="text-muted">(Image dimensions 150 x 150 Size not exceed 1 MB)</small> 
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success" id="submit" name="submit" tabindex="13">Save Job Fair</button>
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
<script type="text/javascript" src="<?=base_url('assets/js/admin/conf.js')?>"></script>
