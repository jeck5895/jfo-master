<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="app-container" style="">
                <center><h5>FORM KEYWORDS</h5></center>
                <hr>


                <ul class="nav nav-tabs applicant-edit-tab nav-fill" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#jobcategory-tab" role="tab">Job Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#jobrole-tab" role="tab">Job Role</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#religion-tab" role="tab">Religions</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#industry-tab" role="tab">Company Industry</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active animated fadeIn" id="jobcategory-tab" role="tabpanel">
                        <div class="tab1-content">

                            <div class="box box-widget no-border">
                                <div class="box-header with-border">

                                    <button data-toggle="modal" data-target="#dynamicModal" data-scope="add-category" id="btn-admin-add-category" class="btn  btn-info btn-sm btn-minimize">
                                        New Category
                                    </button>   

                                </div>
                                <div class="box-body">
                                    
                                    <table class="table table-responsive no-border-top dt-responsive" id="admin-category-table" width="100%">
                                        <thead class="thead-semi-dark">
                                            <tr>
                                                <th class="" style="width: 10%;"><small>No.</small></th>
                                                <th class="" style="width: 100%;"><small>Category Name</small></th>
                                                <th class="no-sort" style="width: 100%; text-align: center;"><small>Actions</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table> 
                                   
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane animated fadeIn" id="jobrole-tab" role="tabpanel">
                        <div class="tab2-content">
                            
                            <div class="box box-widget no-border">
                                <div class="box-header with-border">
                                
                                    <button data-toggle="modal" data-target="#dynamicModal" data-scope="add-role" id="btn-admin-add-role" class="btn  btn-info btn-sm btn-minimize">
                                        New Role
                                    </button>

                                </div>
                                <div class="box-body">
                                    
                                   <table class="table table-responsive no-border-top dt-responsive" id="admin-role-table" width="100%">
                                        <thead class="thead-semi-dark">
                                            <tr>
                                                <th class="" style="width: 10%;"><small>No.</small></th>
                                                <th class="" style="width: 50%;"><small>Role Name</small></th>
                                                <th class="" style="width: 50%;"><small>Category</small></th>
                                                <th class="no-sort" style="width: 100%; text-align: center;"><small>Actions</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table> 
                                   
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane animated fadeIn" id="religion-tab" role="tabpanel">
                        <div class="tab3-content">
                            
                             <div class="box box-widget no-border">
                                <div class="box-header with-border">

                                    <button data-toggle="modal" data-target="#dynamicModal" data-scope="add-religion" id="btn-admin-add-religion" class="btn  btn-info btn-sm btn-minimize">
                                        New Religion
                                    </button>

                                </div>
                                <div class="box-body">
                                    
                                    <table class="table table-responsive no-border-top dt-responsive" id="admin-religion-table" width="100%">
                                        <thead class="thead-semi-dark">
                                            <tr>
                                                <th class="" style="width: 10%;"><small>No.</small></th>
                                                <th class="" style="width: 100%;"><small>Religion Name</small></th>
                                                <th class="no-sort" style="width: 100%; text-align: center;"><small>Actions</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>     
                                
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane animated fadeIn" id="industry-tab" role="tabpanel">
                        <div class="tab4-content">
                            
                             <div class="box box-widget no-border">
                                <div class="box-header with-border">

                                    <button data-toggle="modal" data-target="#dynamicModal" data-scope="add-industry" id="btn-admin-add-industry" class="btn  btn-info btn-sm btn-minimize">
                                        New Industry
                                    </button>                                    

                                </div>
                                <div class="box-body">
                                    
                                    <table class="table table-responsive no-border-top dt-responsive" id="admin-industry-table" width="100%">
                                        <thead class="thead-semi-dark">
                                            <tr>
                                                <th class="" style="width: 10%;"><small>No.</small></th>
                                                <th class="" style="width: 100%;"><small>Industry Name</small></th>
                                                <th class="no-sort" style="width: 100%; text-align: center;"><small>Actions</small></th>
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
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/conf.js');?>"></script>

