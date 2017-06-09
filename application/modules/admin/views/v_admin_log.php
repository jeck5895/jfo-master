<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="app-container" style="">
                <center><h5>ACTIVITY LOGS</h5></center>
                <hr>


                <div class="box box-widget no-border">
                    <div class="box-header with-border">
                    </div>
                    <div class="box-body">

                        <table class="table table-responsive no-border-top dt-responsive" id="admin-logs-table" width="100%">
                            <thead class="thead-semi-dark">
                                <tr>
                                    <th class="" style="width: 5%;"><small>No.</small></th>
                                    <th class="" style="width: 10%;"><small>Activity</small></th>
                                    <th class="" style="width: 10%;"><small>User</small></th>
                                    <th class="" style="width: 10%;"><small>Table Affected</small></th>
                                    <th class="" style="width: 10%;"><small>Record Affected</small></th>
                                    <th class="" style="width: 10%;"><small>IP Address</small></th>
                                    <th class="" style="width: 10%;"><small>Date Recorded</small></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table> 

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>        

<?php $this->load->view('template/modal')?>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/logs.js');?>"></script>

