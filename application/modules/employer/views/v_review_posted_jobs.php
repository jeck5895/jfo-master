<?php
    $this->load->model('notification/notification_model'); 
    if(isset($_GET['notif_id']))
    {

        $notif_id = $_GET['notif_id'];
        $data['status'] = 0;
        $data['date_modified'] = date("Y-m-d H:i:s");

        $this->notification_model->update($notif_id, $data);
    }
?>
<?php $this->load->view('employer/v_employer_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="dashboard-job-container">
                <center><h5>POSTED JOBS > <span id="current-tab"></span></h5></center>
                <hr>
                <ul class="nav nav-tabs applicant-edit-tab nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#for-approval-tab" role="tab">For Approval
                            <span id="approval-badge" class="badge badge-pill badge-danger pos-right" style="top:5px">0</span>
                        </a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#published-tab" role="tab">Published
                            <span id="published-badge" class="badge badge-pill badge-danger pos-right" style="top:5px">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#declined-tab" role="tab">Declined
                            <span id="declined-badge" class="badge badge-pill badge-danger pos-right" style="top:5px">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#expired-tab" role="tab">Expired
                            <span id="expired-badge" class="badge badge-pill badge-danger pos-right" style="top:5px">0</span>
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active animated fadeIn" id="for-approval-tab" role="tabpanel">
                        <div class="tab1-content">

                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <button id="btn-delete-job-post" data-scope="approval-tab" class="btn  btn-danger btn-sm btn-minimize">Delete </button>
                                </div>
                                <div class="box-body">

                                    <table class="table table-responsive no-border-top" id="approval_job_table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="no-sort"> 
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="select-all-emp-pending-job">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">&nbsp&nbsp</small></span>
                                                    </label>
                                                </th>
                                                <th style="width: 20%;"><small class="header">Job Title</small></th>
                                                <th style="width: 10%;"><small class="header">Vancancies</small></th>
                                                <th style="width: 15%;"><small class="header">Open Date</small></th>
                                                <th style="width: 15%;"><small class="header">Close Date</small></th>
                                                <th style="width: 15%;"><small class="header">Date Created</small></th>
                                                <th class="no-sort" style="width: 15%; text-align: center;">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                     <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="select-all-emp-pending-job">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description"></span>
                                                </label>
                                                </td>
                                            </tr>
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
                                   <button id="btn-delete-job-post" data-scope="published-tab" class="btn  btn-danger btn-sm btn-minimize">Delete </button>
                                </div>
                                <div class="box-body">

                                    <table class="table table-responsive no-border-top" id="published_job_table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="no-sort"> 
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="select-all-emp-published-job">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">&nbsp&nbsp</small></span>
                                                    </label>
                                                </th>
                                             
                                                <th class="mw-200" style="width: 20%;"><small class="header">Job Title</small></th>
                                                <th style="width: 10%;"><small class="header">Vancancies</small></th>
                                                <th style="width: 15%;"><small class="header">Open Date</small></th>
                                                <th style="width: 15%;"><small class="header">Close Date</small></th>
                                                <th style="width: 15%;"><small class="header">Date Created</small></th>
                                                <th class="no-sort" style="width: 15%; text-align: center;"></th>   
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
                                    <button id="btn-delete-job-post" data-scope="declined-tab" class="btn  btn-danger btn-sm btn-minimize">Delete </button>
                                </div>
                                <div class="box-body">
                                    

                                    <table class="table table-responsive no-border-top" id="declined_job_table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="no-sort"> 
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="select-all-emp-declined-job">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">&nbsp&nbsp</small></span>
                                                    </label>
                                                </th>
                                                <th class="mw-200" style="width: 20%;"><small class="header">Job Title</small></th>
                                                <th style="width: 10%;"><small class="header">Vancancies</small></th>
                                                <th style="width: 15%;"><small class="header">Open Date</small></th>
                                                <th style="width: 15%;"><small class="header">Close Date</small></th>
                                                <th style="width: 15%;"><small class="header">Date Created</small></th>
                                                <th class="no-sort" style="width: 15%; text-align: center;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="tab-pane animated fadeIn" id="expired-tab" role="tabpanel">
                        <div class="tab4-content">
                            <div class="box box-widget">
                                <div class="box-header with-border">
                                    <button id="btn-delete-job-post" data-scope="expired-tab" class="btn  btn-danger btn-sm btn-minimize">Delete </button>
                                </div>
                                <div class="box-body">
                                    
                                    <table class="table table-responsive no-border-top" id="expired_job_table" width="100%">
                                        <thead> 
                                            <tr>
                                                <th class="no-sort"> 
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="select-all-emp-expired-job">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">&nbsp&nbsp</small></span>
                                                    </label>
                                                </th>
                                                <th class="mw-200" style="width: 20%;"><small class="header">Job Title</small></th>
                                                <th style="width: 10%;"><small class="header">Vancancies</small></th>
                                                <th style="width: 15%;"><small class="header">Open Date</small></th>
                                                <th style="width: 15%;"><small class="header">Close Date</small></th>
                                                <th style="width: 15%;"><small class="header">Date Created</small></th>
                                                <th class="no-sort" style="width: 15%; text-align: center;"></th>
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