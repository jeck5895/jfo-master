<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="dashboard-job-container">
                <center><h5>POSTED JOBS <span id="current-tab"></span></h5></center>
                <hr>
                <ul class="nav nav-tabs applicant-edit-tab nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#for-approval-tab" role="tab">For Review</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#published-tab" role="tab">Published</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#declined-tab" role="tab">Declined</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#trash-tab" role="tab">Trash</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active animated fadeIn" id="for-approval-tab" role="tabpanel">
                        <div class="tab1-content">

                            <div class="box box-widget">
                                <div class="box-header with-border">

                                    <button data-scope="review-tab" data-title="Approve" data-action="approve" id="btn-admin-approve-job" class="btn  btn-success btn-sm btn-minimize">
                                        Approve
                                    </button>

                                    <button data-scope="review-tab" data-title="Decline" data-action="decline" id="btn-admin-decline-job" class="btn  btn-danger btn-sm btn-minimize">
                                        Decline
                                    </button>
                                           
                                </div>
                                <div class="box-body">

                                    <table class="table table-responsive no-border-top" id="admin-review-job-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="no-sort"> 
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="select-all-admin-pending-job">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">&nbsp&nbsp</small></span>
                                                    </label>
                                                </th>
                                                <th class="mw-200" style="width: 20%;"><small class="header">Job Title</small></th>
                                                <th style="width: 10%;"><small class="header">Vancancies</small></th>
                                                <th style="width: 10%;"><small class="header">Company</small></th>
                                                <th style="width: 15%;"><small class="header">Employer Name</small></th>
                                                <th style="width: 15%;"><small class="header">Open Date</small></th>
                                                <th style="width: 15%;"><small class="header">Close Date</small></th>
                                                <th style="width: 15%;"><small class="header">Date Created</small></th>
                                                <!-- <th class="no-sort" style="width: 15%; text-align: center;">
                                                </th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

            

                    <div class="tab-pane animated fadeIn" id="published-tab" role="tabpanel">
                        <div class="tab3-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <button data-scope="published-tab" data-title="Add to Featured Job" data-action="add-to-featured" id="btn-admin-featured-job" class="btn  btn-success btn-sm btn-minimize">
                                        Add to Featured Job
                                    </button>

                                    <button data-scope="published-tab" data-title="Tag for Review" data-action="review" id="btn-admin-review-job" class="btn  btn-primary btn-sm btn-minimize">
                                        Tag for Review
                                    </button>

                                    <button data-scope="published-tab" data-title="Decline" data-action="decline" id="btn-admin-decline-job" class="btn  btn-danger btn-sm btn-minimize">
                                        Decline
                                    </button>

                                </div>
                                <div class="box-body">

                                    <table class="table table-responsive no-border-top" id="admin-published-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="no-sort"> 
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="select-all-admin-published-job">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">&nbsp&nbsp</small></span>
                                                    </label>
                                                </th>
                                             
                                                <th class="mw-200" style="width: 20%;"><small class="header">Job Title</small></th>
                                                <th style="width: 10%;"><small class="header">Vancancies</small></th>
                                                <th style="width: 10%;"><small class="header">Company</small></th>
                                                <th style="width: 15%;"><small class="header">Employer Name</small></th>
                                                <th style="width: 15%;"><small class="header">Open Date</small></th>
                                                <th style="width: 15%;"><small class="header">Close Date</small></th>
                                                <th style="width: 15%;"><small class="header">Date Created</small></th>
                                                <!-- <th class="no-sort" style="width: 15%; text-align: center;"></th>  -->  
                                            </tr>    
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane animated fadeIn" id="declined-tab" role="tabpanel">
                        <div class="tab4-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">

                                    <button data-scope="declined-tab" data-title="Approve" data-action="approve" id="btn-admin-approve-job" class="btn  btn-success btn-sm btn-minimize">
                                        Approve
                                    </button>
                                    
                                    <button data-scope="declined-tab" data-title="Tag for Review" data-action="review" id="btn-admin-review-job" class="btn  btn-primary btn-sm btn-minimize">
                                        Tag for Review
                                    </button>

                                    <button data-scope="declined-tab" data-title="Move to Trash" data-action="trash" id="btn-admin-trash-job" class="btn  btn-secondary btn-sm btn-minimize">
                                        Move to Trash
                                    </button>

                                </div>
                                <div class="box-body">
                                    

                                    <table class="table table-responsive no-border-top" id="admin-declined-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="no-sort"> 
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="select-all-admin-declined-job">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">&nbsp&nbsp</small></span>
                                                    </label>
                                                </th>
                                                <th class="mw-200" style="width: 20%;"><small class="header">Job Title</small></th>
                                                <th style="width: 10%;"><small class="header">Vancancies</small></th>
                                                <th style="width: 10%;"><small class="header">Company</small></th>
                                                <th style="width: 15%;"><small class="header">Employer Name</small></th>
                                                <th style="width: 15%;"><small class="header">Open Date</small></th>
                                                <th style="width: 15%;"><small class="header">Close Date</small></th>
                                                <th style="width: 15%;"><small class="header">Date Created</small></th>
                                                <!-- <th class="no-sort" style="width: 15%; text-align: center;"></th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="tab-pane animated fadeIn" id="trash-tab" role="tabpanel">
                        <div class="tab4-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <button data-scope="trash-tab" data-title="Delete" data-action="delete" id="btn-admin-delete-job" class="btn  btn-danger btn-sm btn-minimize">Delete Permanently</button>
                                </div>
                                <div class="box-body">
                                    
                                    <table class="table table-responsive no-border-top" id="admin-trash-table" width="100%">
                                        <thead> 
                                            <tr>
                                                <th class="no-sort"> 
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="select-all-admin-trash-job">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">&nbsp&nbsp</small></span>
                                                    </label>
                                                </th>
                                                <th class="mw-200" style="width: 20%;"><small class="header">Job Title</small></th>
                                                <th style="width: 10%;"><small class="header">Vancancies</small></th>
                                                <th style="width: 10%;"><small class="header">Company</small></th>
                                                <th style="width: 15%;"><small class="header">Employer Name</small></th>
                                                <th style="width: 15%;"><small class="header">Open Date</small></th>
                                                <th style="width: 15%;"><small class="header">Close Date</small></th>
                                                <th style="width: 15%;"><small class="header">Date Created</small></th>
                                                <!-- <th class="no-sort" style="width: 15%; text-align: center;"></th> -->
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

<?php $this->load->view('template/profile_modal')?>
<?php $this->load->view('template/job_modal')?>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/dashboard.js');?>"></script>