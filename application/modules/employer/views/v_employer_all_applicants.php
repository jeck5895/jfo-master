<?php $this->load->view('employer/v_employer_sidenav')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="app-container" style="">
                <center><h5>All Applicants</h5></center>
                <hr>
                <div class="col-md-12">
                    <div class="row d-filter-container">
                        <div class="col-md-3 d-filter-group">
                            <select name="filter-category" class="form-control">
                                <option value="" class='select-placeholder'>Seach by Job Category</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-filter-group">
                            <select name="filter-location" class="form-control province">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-md-4 d-filter-group">
                            <input type="search" id="search-public-applicants" class="form-control" name="search" placeholder="Search Applicants">  
                        </div>
                        <div class="col d-filter-group">
                            <button type="button" id="btn-search-app" class="btn btn-info btn-materialize form-control">SEARCH</button>
                        </div>
                    </div>
                </div>

                <div class="clear-filter-box">
                    <div class="ckb-box">
                        <label class="header"><span id="total-applicants"></span> total applicants</label> 
                     
                    </div>
        
                    <div class="ckb-box pull-top-right" >
                        <small>
                            <a href="" id="btn-clear-filter" onclick="return false;">CLEAR FILTER </a>
                        </small>
                    </div>
                </div>

                <div id="public-applicants-container" class="list-group app-container-main"> 

                </div>
                <div id="app-pagination"></div>
            </div>    
        </div>
    </section>
</div>

<?php $this->load->view('template/profile_modal')?>

<script type="text/javascript" src="<?=base_url('assets/js/pa.js')?>"></script>

