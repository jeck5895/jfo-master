<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="dashboard-job-container">
                <center><h5>FEATURED JOBS<span id="current-tab"></span></h5></center>
                <hr>
                <ul class="nav nav-tabs applicant-edit-tab nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#featured-form-tab" role="tab">Add Featured Jobs</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#featured-list-tab" role="tab">List</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active animated fadeIn" id="featured-form-tab" role="tabpanel">
                        <div class="tab1-content">

                            <div class="box box-widget">
                                <div class="box-header with-border">

                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <form id="featured-job-form" action="" method="">
                                                <div class="form-group">
                                                    <label for="email" class="control-label"><small>Company Name</small></label>
                                                    <input type="text" name="company_name" class="form-control" placeholder=""  tabindex="1" autofocus required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="control-label "><small>Job Position</small></label>
                                                    <input type="text" name="job_position" class="form-control" placeholder=""  tabindex="2" required>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="email" class="control-label "><small>Duration</small></label>
                                                        <select name="duration" class="form-control" required>
                                                            <option value="7">1 week</option>
                                                            <option value="14">2 weeks</option>
                                                            <option value="21">3 weeks</option>
                                                            <option value="30">1 month</option>
                                                            <option value="60">2 months</option>
                                                            <option value="90">3 months</option>
                                                        </select>
                                                    </div>
                                                </div>
                
                                                <div class="form-group">
                                                    <label for="email" id="jobdesc-label" class="control-label">
                                                        <small>Job Description</small>
                                                    </label>
                                                    <textarea class="form-control ignore" id="featuredContent" name="featuredContent" minlength="150" rows="10" tabindex="12" required></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label> <small>Job Link </small></label>
                                                    <input type="url" class="form-control" name="job_link" tabindex="5" placeholder="http://yourdomain.com" required>
                                                </div>

                                                <div class="form-group">
                                                    <label> <small>Company Website</small></label>
                                                    <input type="url" class="form-control" name="comp_link" tabindex="5" placeholder="http://yourdomain.com" required>
                                                </div>
                            
                                                <div class="form-group">
                                                    <button class="btn btn-success btn-materialize" id="btn-save-job" name="submit" tabindex="13">
                                                        Save Featured Job
                                                    </button>
                                                </div>
                                            </form>
                                        </div>  
                                    </div>  

                                </div>
                            </div>
                        </div>
                    </div>

            

                    <div class="tab-pane animated fadeIn" id="featured-list-tab" role="tabpanel">
                        <div class="tab3-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                   

                                </div>
                                <div class="box-body">

                                    <table class="table table-responsive no-border-top" id="featured-job-list-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="no-sort" style="width: 5%;"> <small class="header">Id</small></th>
                                                <th class="mw-200"><small class="header">Company Name</small></th>
                                                <th style=""><small class="header">Job Position</small></th>
                                                <th style=""><small class="header">Duration</small></th>
                                                <th style=""><small class="header">Start Date</small></th>
                                                <th style=""><small class="header">End Date</small></th>
                                                <th style=""><small class="header">Status</small></th>
                                                <th class="no-sort" style="width:15%; text-align: center;"></th>   
                                            </tr>    
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>    
<?php $this->load->view('template/modal')?>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/fads.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/plugins/ckeditor/ckeditor.js')?>"></script> 