<?php $this->load->view('employer/v_employer_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="app-container" style="">
                <center><h5>APPLICANTS DASHBOARD</h5></center>
                <hr>
                <div class="col-md-12">
                    <div class="row d-filter-container">
                        <div class="col-md-3 d-filter-group">
                            <select name="filter-position" class="form-control">
                                <option value="" class="">Filter by Position Applied</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-filter-group">
                            <select name="filter-status" class="form-control">
                                <option value="" class="">Filter by Status</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-filter-group">
                            <input type="search" id="search-applicants" class="form-control" name="search" placeholder="Search Applicants">  
                        </div>
                        <div class="col d-filter-group">
                            <button type="button" id="btn-search-app" class="btn btn-info btn-materialize form-control">SEARCH</button>
                        </div>
                    </div>
                    
                </div>

                <ul class="list-inline" style="border:  1px solid rgba(0, 0, 0, 0.125); padding: 5px;">
                   
                    <li class="list-inline-item">
                        <div class="form-group">
                            <button class="btn  btn-success btn-sm btn-minimize"  data-title="for Interview" data-action="tag_interview" id="btn-interview-applicants">For Interview</button>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="form-group">
                            <button class="btn  btn-danger btn-sm btn-minimize" data-title="as Reject" data-action="tag_reject" id="btn-reject-applicants">Dismiss Application</button>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="form-group">
                            <button class="btn  btn-info btn-sm btn-minimize" data-title="as Reviewed" data-action="tag_review" id="btn-review-applicants">Tag as Reviewed</button>
                        </div>
                    </li>
                </ul>

                 <div class="clear-filter-box">
                     
                    <div class="ckb-box">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="select-all-emp-applicants">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description"><label class="header">SELECT ALL</label></span>
                        </label>
                    </div>
                    
                    <div class="ckb-box pull-top-right">
                        <small>
                            <a href="" id="btn-clear-filter" onclick="return false;">CLEAR FILTER </a>
                        </small>
                    </div>    
                </div>
                    
              
                <div id="job-applicants-container" class="list-group app-container-main"> 
        

                </div>
                <div id="job-app-pagination"></div>
            </div>    
        </div>
    </section>
</div>
<?php $this->load->view('template/profile_modal')?>
<script type="text/javascript" src="<?=base_url('assets/js/company/ea.js')?>"></script>