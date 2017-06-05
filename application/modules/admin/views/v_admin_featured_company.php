<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="dashboard-job-container">
                <center><h5>LIST OF FEATURED COMPANIES<span id="current-tab"></span></h5></center>
                <hr>
                    
                <div class="box box-widget">
                    <div class="box-header with-border">


                    </div>
                    <div class="box-body">

                        <table class="table table-responsive no-border-top" id="featured-job-list-table" width="100%">
                            <thead>
                                <tr>
                                    <th class="no-sort" style="width: 5%;"> <small class="header">Id</small></th>
                                    <th class="mw-200" style="width: 10%;"><small class="header">Company</small></th>
                                    <th style="width: 20%;"><small class="header">Industry</small></th>
                                    <th style="width: 15%;"><small class="header">Location</small></th>
                                    <th style="width: 15%;"><small class="header">Duration</small></th>
                                    <th style="width: 15%;"><small class="header">Start Date</small></th>
                                    <th style="width: 15%;"><small class="header">End Date</small></th>
                                    <th style="width: 10%;"><small class="header">Status</small></th>
                                    <th class="no-sort" style="width:10%; text-align: center;"></th>   
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
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/facs.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/plugins/ckeditor/ckeditor.js')?>"></script> 