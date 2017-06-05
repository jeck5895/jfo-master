<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="app-container" style="">
                <center><h5>LIST OF COMPANIES</h5></center>
                <hr>


                <ul class="nav nav-tabs applicant-edit-tab nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#for-review-tab" role="tab">For Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#active-tab" role="tab">Active Companies</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#inactive-tab" role="tab">Inactive Companies</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane active animated fadeIn" id="for-review-tab" role="tabpanel">
                        <div class="tab1-content">

                            <div class="box box-widget">
                                <div class="box-header with-border">

                                    <button data-scope="review" data-action="active" id="btn-admin-set-active-employers" class="btn  btn-success btn-sm btn-minimize">
                                        Set as Active
                                    </button>

                                    <button class="btn btn-danger btn-sm btn-minimize" data-scope="review" data-action="inactive" id="btn-admin-set-inactive-employers">Set as Inactive 
                                    </button>  

                                </div>
                                <div class="box-body">
                                    
                                    <div class="col-md-12">
                                        <div class="row d-filter-container">
                                            <div class="col-md-5 d-filter-group">
                                                <div class="col-md-5 d-filter-group">
                                                    <div class="form-inline">
                                                        <label class="mr-sm-1">Show</label>
                                                        <select data-scope="private" name="select-limit" class="form-control form-control-sm">
                                                            <option value="10" class="">10</option>
                                                            <option value="50" class="">50</option>
                                                            <option value="100" class="">100</option>
                                                        </select>
                                                        <label class="ml-sm-1">entries</label>
                                                    </div>
                                                </div>
                                            </div>

                                           <!--  <div class="col-md-5 d-filter-group">
                                                <input type="search" data-scope="private" id="admin-search-applicants-private" class="form-control form-control-sm" name="search" placeholder="Search Applicants">  
                                            </div>
                                            <div class="col d-filter-group">
                                                <button type="button" data-scope="private" id="btn-admin-search-app" class="btn btn-info btn-materialize btn-materialize-sm form-control form-control-sm">SEARCH</button>
                                            </div> -->
                                        </div>
                                    </div>

                                    <div class="clear-filter-box">

                                        <div class="ckb-box">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="select-all-admin-review-employers">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"></span>
                                            </label>
                                        </div>

                                    </div>

                                    <div id="review-emp-container" class="list-group app-container-main"> 


                                    </div>
                                    <div id="review-emp-pagination"></div>
                                   
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane animated fadeIn" id="active-tab" role="tabpanel">
                        <div class="tab3-content">
                            
                            <div class="box box-widget no-border">
                                <div class="box-header with-border">

                                    <button data-action="featured_companies" id="btn-admin-add-to-featured" class="btn  btn-warning btn-sm btn-minimize pos">
                                        Add to Featured Company
                                    </button>

                                    <button class="btn btn-danger btn-sm btn-minimize" data-scope="active" data-title="as Reviewed" data-action="inactive" id="btn-admin-set-inactive-employers">Set as Inactive 
                                    </button>   

                                </div>
                                <div class="box-body">
                                    
                                    <div class="col-md-12">
                                        <div class="row d-filter-container">
                                            <div class="col-md-3 d-filter-group">
                                                <select data-scope="active" id="filter-industry-active" name="filter-industry" class="form-control form-control-sm">
                                                    <option value="" class='select-placeholder'>All Industry</option>
                                                </select>

                                            </div>
                                            <div class="col-md-3 d-filter-group">
                                                <select data-scope="active" id="filter-location-active" name="filter-location" class="form-control form-control-sm province">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-filter-group">
                                                <input type="search" id="admin-search-employers-active" data-scope="active" class="form-control form-control-sm" name="search" placeholder="Search Applicants" style="height: 29px;">  
                                            </div>
                                            <div class="col d-filter-group">
                                                <button type="button" data-scope="active" id="btn-admin-search-emp" class="btn btn-info btn-materialize btn-materialize-sm form-control form-control-sm">SEARCH</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clear-filter-box no-pad-lr">

                                        <div class="ckb-box">
                                            <label class="custom-control custom-checkbox ml-2">
                                                <input type="checkbox" class="custom-control-input" name="select-all-admin-active-employers">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"></span>
                                            </label>
                                        </div>

                                        <div class="form-inline pull-top-right">
                                            <label class="mr-sm-1">Show</label>
                                            <select data-scope="private" name="select-limit" class="form-control form-control-sm">
                                                <option value="10" class="">10</option>
                                                <option value="50" class="">50</option>
                                                <option value="100" class="">100</option>
                                            </select>
                                            <label class="ml-sm-1">entries</label>
                                        </div>

                                    </div>

                                    <div id="active-employers-container" class="list-group app-container-main"> 


                                    </div>
                                    <div id="active-emp-pagination"></div>
                                   
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane animated fadeIn" id="inactive-tab" role="tabpanel">
                        <div class="tab3-content">
                            
                             <div class="box box-widget no-border">
                                <div class="box-header with-border">

                                    <button data-scope="inactive" data-title="as Reviewed" data-action="active" id="btn-admin-set-active-employers" class="btn  btn-success btn-sm btn-minimize">
                                        Set as Active
                                    </button>

                                    <button class="btn btn-danger btn-sm btn-minimize" data-title="delete" data-action="Delete" id="btn-delete-acct">Delete Account</button>

                                    <!-- <button class="btn btn-danger btn-sm btn-minimize" data-title="as Reviewed" data-action="inactive" id="btn-admin-set-inactive-employers">Set as Inactive 
                                    </button> -->   

                                </div>
                                <div class="box-body">
                                    
                                    <div class="col-md-12">
                                        <div class="row d-filter-container">
                                            <div class="col-md-3 d-filter-group">
                                                <select data-scope="inactive" id="filter-industry-inactive" name="filter-industry" class="form-control form-control-sm">
                                                    <option value="" class='select-placeholder'>All Industry</option>
                                                </select>

                                            </div>
                                            <div class="col-md-3 d-filter-group">
                                                <select data-scope="inactive" id="filter-location-inactive" name="filter-location" class="form-control form-control-sm province">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-filter-group">
                                                <input type="search" id="admin-search-employers-inactive" data-scope="inactive" class="form-control form-control-sm" name="search" placeholder="Search Applicants" style="height: 29px;">  
                                            </div>
                                            <div class="col d-filter-group">
                                                <button type="button" data-scope="inactive" id="btn-admin-search-emp" class="btn btn-info btn-materialize btn-materialize-sm form-control form-control-sm">SEARCH</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clear-filter-box no-pad-lr">

                                        <div class="ckb-box">
                                            <label class="custom-control custom-checkbox ml-2">
                                                <input type="checkbox" class="custom-control-input" name="select-all-admin-inactive-employers">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"></span>
                                            </label>
                                        </div>

                                        <div class="form-inline pull-top-right">
                                            <label class="mr-sm-1">Show</label>
                                            <select data-scope="private" name="select-limit" class="form-control form-control-sm">
                                                <option value="10" class="">10</option>
                                                <option value="50" class="">50</option>
                                                <option value="100" class="">100</option>
                                            </select>
                                            <label class="ml-sm-1">entries</label>
                                        </div>

                                    </div>

                                    <div id="inactive-employers-container" class="list-group app-container-main"> 


                                    </div>
                                    <div id="inactive-emp-pagination"></div>
                                   
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
<script type="text/javascript" src="<?=base_url('assets/js/admin/emplist.js')?>"></script>