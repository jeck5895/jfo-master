<?php $this->load->view('applicant/v_applicant_sidebar')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            <div class="job-container" style="">
                <h5>SUGGESTED JOBS</h5>
                <div class="col-md-12">
                    <div class="row d-filter-container">
                    <div class="col-md-9 d-filter-group">
                            <input type="search" id="search-jobs" class="form-control" name="search" placeholder="Search Job">  
                        </div>
                        <div class="col d-filter-group">
                            <button type="button" id="btn-i-search" class="btn btn-info btn-materialize form-control">SEARCH</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="pending-app">

                </div>
                <div id="pending-app-pagination" class=""></div>
            </div>

        <?php $this->load->view('template/v_ads_box')?>    
        </div>
    </section>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/applicant/applicant.js')?>"></script>