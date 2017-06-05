<?php $this->load->view('admin/v_admin_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="app-container" style="">
                <h5>APPLICANTS > PRIVATE</h5>
                <hr>

                <ul class="list-inline" style="border:  1px solid rgba(0, 0, 0, 0.125); padding: 5px;">
                   
                    <li class="list-inline-item">
                        <div class="form-group" style="margin-bottom: 5px;">
                            <button class="btn btn-danger btn-sm btn-minimize" data-title="private" data-action="Inactive" id="btn-set-inactive-applicants">Set as Inactive </button>
                        </div>
                    </li>
                    
                </ul>

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

                        <div class="col-md-5 d-filter-group">
                            <input type="search" data-scope="private" id="admin-search-applicants-private" class="form-control form-control-sm" name="search" placeholder="Search Applicants" style="height: 29px;">  
                        </div>
                        <div class="col d-filter-group">
                            <button type="button" data-scope="private" id="btn-admin-search-app" class="btn btn-info btn-materialize  btn-materialize-sm form-control">SEARCH</button>
                        </div>
                    </div>
                    
                </div>

                <div class="clear-filter-box">
                     
                    <div class="ckb-box">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="select-all-admin-private-applicants">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description"></span>
                        </label>
                    </div>
  
                </div>

                <div id="private-applicants-container" class="list-group app-container-main"> 
                    

                </div>
                <div id="private-app-pagination"></div>

            </div>
        </div>
    </section>
</div>        

<script type="text/javascript" src="<?=base_url('assets/js/admin/applist.js')?>"></script>
