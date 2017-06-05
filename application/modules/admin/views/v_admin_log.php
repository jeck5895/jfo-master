<div class="container-fluid">
    <section class="content-header" style="">
        
       <?php $this->load->view('v_admin_header');?>
       
    </section>

    <section class="content">
        
        <div class="row">
            <?php //$this->load->view('v_admin_sidenav');?>

            <div class="col-lg-10" style="padding-left: 0;"> <!-- remove-pad -->
                
                <div class="box box-widget" style="min-height: 570px;">
                    <div class="box-header">

                    </div>
                    <div class="box-body">
                        <div class="table-container">

                            <table class="table table-hover dt-responsive nowrap" id="admin-active-employers-table" style="width: 100%;">
                                <thead>
                                    <th class="no-sort"> <input type="checkbox" name="select-all-active-employer" class="select-all-active-employer"></th>
                                    <th>Company Name</th>
                                    <th>Contact Person</th>
                                    <th>Industry</th>
                                    <th>Location</th>
                                    <th>Date Registered</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<?php $this->load->view('template/profile_modal')?>
