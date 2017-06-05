<?php $this->load->view('applicant/v_applicant_sidebar')?>
<div class="content-wrapper">
    <section class="content-header" style="">
        
    </section>  
    <section class="content">
        <div class="row">
            
            <div class="job-container" style="">
                <h6 class=""><span id="total-jobs" class="text-bold"></span> total jobs that matches your job category</h6>

                <hr>
                <div id="recommended-jobs">

                </div>
                <div id="recommended-jobs-pagination" class=""></div>
                
            </div>

        <?php $this->load->view('template/v_ads_box')?>    
        </div>
    </section>
</div>

<script type="text/javascript" src="<?=base_url('assets/js/applicant/recommend.js')?>"></script>
